<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to format ecole logoUrl with underscores and lowercase
 */
final class Version20260323000008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Format ecole logoUrl to lowercase with underscores';
    }

    public function up(Schema $schema): void
    {
        // Get all current logo_url values
        $connection = $this->connection;
        $rows = $connection->fetchAllAssociative('SELECT id, logo_url FROM ecole WHERE logo_url IS NOT NULL');

        foreach ($rows as $row) {
            $oldPath = $row['logo_url'];
            $id = $row['id'];
            
            // Parse: 'images/Universite D Avignon.png' or 'images/universite_d_avignon.png'
            preg_match("/'images\/(.+)\.png'/", $oldPath, $matches);
            
            if (isset($matches[1])) {
                $filename = $matches[1];  // e.g., 'Universite D Avignon'
                
                // Convert spaces to underscores and make lowercase
                $newFilename = strtolower(str_replace(' ', '_', $filename));
                $newPath = "'images/{$newFilename}.png'";
                
                // Update the database
                $connection->update('ecole', ['logo_url' => $newPath], ['id' => $id]);
            }
        }
    }

    public function down(Schema $schema): void
    {
        // Rollback: convert underscores to spaces and Title Case
        $connection = $this->connection;
        $rows = $connection->fetchAllAssociative('SELECT id, logo_url FROM ecole WHERE logo_url IS NOT NULL');

        foreach ($rows as $row) {
            $oldPath = $row['logo_url'];
            $id = $row['id'];
            
            // Parse: 'images/universite_d_avignon.png'
            preg_match("/'images\/(.+)\.png'/", $oldPath, $matches);
            
            if (isset($matches[1])) {
                $filename = $matches[1];
                
                // Split by underscore and convert each word to Title Case
                $words = explode('_', $filename);
                $titleCaseWords = array_map(function($word) {
                    return ucfirst(strtolower($word));
                }, $words);
                
                // Join with spaces
                $newFilename = implode(' ', $titleCaseWords);
                $newPath = "'images/{$newFilename}.png'";
                
                // Update the database
                $connection->update('ecole', ['logo_url' => $newPath], ['id' => $id]);
            }
        }
    }
}
