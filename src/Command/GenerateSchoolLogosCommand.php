<?php

namespace App\Command;

use App\Repository\EcoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsCommand(
    name: 'app:generate-school-logos',
    description: 'Generate logo images for schools and update logo_url in database',
)]
class GenerateSchoolLogosCommand extends Command
{
    public function __construct(
        private EcoleRepository $ecoleRepository,
        private EntityManagerInterface $entityManager,
        private SluggerInterface $slugger,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $imagesDir = __DIR__ . '/../../assets/images';
        
        if (!is_dir($imagesDir)) {
            mkdir($imagesDir, 0755, true);
        }

        $ecoles = $this->ecoleRepository->findAll();
        $io->info(sprintf('Traitement de %d écoles...', count($ecoles)));

        $count = 0;
        foreach ($ecoles as $ecole) {
            if (empty($ecole->getLogoUrl())) {
                $slug = $this->slugger->slug($ecole->getNom())->lower();
                $filename = str_replace('-', '_', $slug) . '.svg';
                $filePath = $imagesDir . '/' . $filename;

                // Générer une image SVG avec le nom de l'école
                $this->generateLogoSvg($filePath, $ecole->getNom());

                // Mettre à jour le logo_url
                $logoUrl = 'images/' . $filename;
                $ecole->setLogoUrl($logoUrl);
                $count++;
                $io->writeln(sprintf('✓ <info>%s</info> → <comment>%s</comment>', $ecole->getNom(), $logoUrl));
            } else {
                $io->writeln(sprintf('⊘ <comment>%s</comment> : logo_url déjà défini', $ecole->getNom()));
            }
        }

        if ($count > 0) {
            $this->entityManager->flush();
            $io->success(sprintf('✓ %d écoles mises à jour avec leurs logos', $count));
        } else {
            $io->info('Aucune école à mettre à jour (tous les logos_url sont déjà définis)');
        }

        return Command::SUCCESS;
    }

    private function generateLogoSvg(string $filePath, string $schoolName): void
    {
        $initials = implode('', array_map(fn($word) => strtoupper($word[0] ?? ''), explode(' ', trim($schoolName))));
        $initials = substr($initials, 0, 3);

        $svg = sprintf(
            '<?xml version="1.0" encoding="UTF-8"?>
<svg width="160" height="120" viewBox="0 0 160 120" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="grad_%s" x1="0%%" y1="0%%" x2="100%%" y2="100%%">
      <stop offset="0%%" stop-color="#1d4ed8"/>
      <stop offset="100%%" stop-color="#f59e0b"/>
    </linearGradient>
  </defs>
  <rect width="160" height="120" rx="8" fill="url(#grad_%s)" opacity="0.95"/>
  <circle cx="80" cy="50" r="35" fill="rgba(255,255,255,0.2)"/>
  <text x="80" y="65" font-family="Arial, sans-serif" font-size="32" font-weight="bold" fill="#ffffff" text-anchor="middle">%s</text>
  <text x="80" y="110" font-family="Arial, sans-serif" font-size="11" fill="rgba(255,255,255,0.8)" text-anchor="middle">%s</text>
</svg>',
            uniqid(),
            uniqid(),
            htmlspecialchars($initials),
            htmlspecialchars(substr($schoolName, 0, 25))
        );

        file_put_contents($filePath, $svg);
    }
}
