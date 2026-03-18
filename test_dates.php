<?php
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/.env');

$kernel = new App\Kernel($_SERVER['APP_ENV'] ?? 'dev', $_SERVER['APP_DEBUG'] ?? false);
$kernel->boot();
$container = $kernel->getContainer();
$entityManager = $container->get('doctrine')->getManager();

// Check if createdAt field exists and has values
$ecoleRepo = $entityManager->getRepository(\App\Entity\Ecole::class);
$ecoles = $ecoleRepo->findAll();

echo "=== Check Ecole createdAt ===\n";
foreach ($ecoles as $ecole) {
    $createdAt = $ecole->getCreatedAt();
    echo "Ecole: {$ecole->getNom()} | createdAt: " . ($createdAt ? $createdAt->format('Y-m-d H:i:s') : 'NULL') . "\n";
}

$formationRepo = $entityManager->getRepository(\App\Entity\Formation::class);
$formations = $formationRepo->findAll();

echo "\n=== Check Formation createdAt ===\n";
foreach ($formations as $formation) {
    $createdAt = $formation->getCreatedAt();
    echo "Formation: {$formation->getIntitule()} | createdAt: " . ($createdAt ? $createdAt->format('Y-m-d H:i:s') : 'NULL') . "\n";
}

$avisRepo = $entityManager->getRepository(\App\Entity\Avis::class);
$avis = $avisRepo->findAll();

echo "\n=== Check Avis createdAt ===\n";
foreach ($avis as $av) {
    $createdAt = $av->getCreatedAt();
    echo "Avis ID: {$av->getId()} | createdAt: " . ($createdAt ? $createdAt->format('Y-m-d H:i:s') : 'NULL') . "\n";
}

echo "\nDatabase checks completed!\n";
$kernel->shutdown();
