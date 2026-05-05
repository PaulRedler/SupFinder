<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to update ecole logoUrl to absolute Windows paths
 */
final class Version20260323000002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update ecole logoUrl to absolute Windows paths format';
    }

    public function up(Schema $schema): void
    {
        // Update all logoUrl to absolute Windows path format
        // Extract the filename and convert to C:\Users\REDLER\SupFinder\assets\images\{filename}
        $this->addSql("UPDATE ecole SET logo_url = CONCAT('C:\\\\Users\\\\REDLER\\\\SupFinder\\\\assets\\\\images\\\\', SUBSTRING_INDEX(logo_url, '/', -1)) WHERE logo_url IS NOT NULL AND logo_url LIKE '/images/%'");
    }

    public function down(Schema $schema): void
    {
        // Rollback: convert back to relative paths /images/{filename}
        $this->addSql("
            UPDATE ecole 
            SET logo_url = CONCAT('/images/', SUBSTRING_INDEX(logo_url, '\\\\', -1))
            WHERE logo_url IS NOT NULL AND logo_url LIKE '%assets%images%'
        ");
    }
}
