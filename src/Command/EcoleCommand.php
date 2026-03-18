<?php

namespace App\Command;

use App\Entity\Ecole;
use App\Repository\EcoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsCommand(
    name: 'app:import-ecoles',
    description: 'Import écoles depuis l\'API publique fr-esr-principaux-etablissements-enseignement-superieur.',
)]
class ImportEcolesCommand extends Command
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly EntityManagerInterface $em,
        private readonly EcoleRepository $ecoleRepository,
        private readonly SluggerInterface $slugger,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('rows', null, InputOption::VALUE_OPTIONAL, 'Nombre d\'enregistrements à récupérer', '245')
            ->addOption('start', null, InputOption::VALUE_OPTIONAL, 'Offset de départ (pagination API)', '0')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Mettre à jour les enregistrements existants (par défaut : ne pas toucher)')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Ne rien persister en base (test)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rows = (int) $input->getOption('rows');
        $start = (int) $input->getOption('start');
        $force = (bool) $input->getOption('force');
        $dryRun = (bool) $input->getOption('dry-run');

        $url = sprintf(
            'https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&rows=%d&start=%d&timezone=UTC',
            $rows,
            $start
        );

        $output->writeln(sprintf('Récupération de %d enregistrements depuis %s', $rows, $url));

        $response = $this->httpClient->request('GET', $url);
        if (200 !== $response->getStatusCode()) {
            $output->writeln(sprintf('<error>Échec de la récupération (HTTP %d)</error>', $response->getStatusCode()));
            return Command::FAILURE;
        }

        $payload = $response->toArray(false);
        $records = $payload['records'] ?? [];

        $progress = new ProgressBar($output, count($records));
        $progress->start();

        $countCreated = 0;
        $countUpdated = 0;

        foreach ($records as $record) {
            $fields = $record['fields'] ?? [];

            $name = $fields['uo_lib_officiel'] ?? $fields['uo_lib'] ?? $fields['champ_recherche'] ?? null;
            if (!$name) {
                $progress->advance();
                continue;
            }

            $slugBase = (string) ($fields['uo_lib_officiel'] ?? $fields['uo_lib'] ?? $name);
            $slug = strtolower($this->slugger->slug($slugBase)->toString());

            if (isset($fields['uai']) && $fields['uai'] !== '') {
                $slug = sprintf('%s-%s', $slug, strtolower(preg_replace('/[^a-z0-9]+/', '-', (string) $fields['uai'])));
            }

            $ecole = $this->ecoleRepository->findOneBy(['slug' => $slug]);
            if (!$ecole) {
                $ecole = $this->ecoleRepository->findOneBy(['nom' => $name]);
            }

            $isNew = false;
            if (!$ecole) {
                $ecole = new Ecole();
                $ecole->setCreatedAt(new \DateTime());
                $isNew = true;
            } elseif (!$force) {
                $progress->advance();
                continue;
            }

            $ecole->setNom($name);
            $ecole->setSlug($slug);
            $ecole->setSiteWeb($fields['url'] ?? null);
            $ecole->setEmailContact($fields['courriel'] ?? $fields['mail'] ?? null);
            $ecole->setTitre($fields['sigle'] ?? null);

            $descriptionCourte = $fields['texte_de_ref_creation_lib'] ?? $fields['texte_de_ref_creation'] ?? null;
            $ecole->setDescriptionCourte($descriptionCourte);

            $descriptionParts = [];
            $mapping = [
                'adresse_uai' => 'Adresse',
                'code_postal_uai' => 'Code postal',
                'com_nom' => 'Commune',
                'numero_telephone_uai' => 'Téléphone',
                'statut_juridique_long' => 'Statut juridique',
                'type_d_etablissement' => 'Type d\'établissement',
                'typologie_d_universites_et_assimiles' => 'Typologie',
                'flux_rss' => 'Flux RSS',
                'element_wikidata' => 'Wikidata',
                'element_ror' => 'ROR',
                'element_isni' => 'ISNI',
            ];

            foreach ($mapping as $fieldKey => $label) {
                if (!empty($fields[$fieldKey])) {
                    $descriptionParts[] = sprintf('%s: %s', $label, $fields[$fieldKey]);
                }
            }

            $ecole->setDescriptionLongue($descriptionParts ? implode("\n", $descriptionParts) : null);

            if ($isNew) {
                $this->em->persist($ecole);
                $countCreated++;
            } else {
                $countUpdated++;
            }

            $progress->advance();
        }

        $progress->finish();
        $output->writeln('');

        if (!$dryRun) {
            $this->em->flush();
        }

        $output->writeln(sprintf('✅ Créés: %d, mis à jour: %d (dry-run=%s)', $countCreated, $countUpdated, $dryRun ? 'oui' : 'non'));

        return Command::SUCCESS;
    }
}
