<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to replace file extensions with .png in ecole logoUrl
 */
final class Version20260323000005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Replace file extensions with .png in ecole logoUrl paths';
    }

    public function up(Schema $schema): void
    {
        // Replace all file extensions with .png
        $this->addSql("UPDATE ecole SET logo_url = CONCAT(SUBSTRING(logo_url, 1, CHAR_LENGTH(logo_url) - CHAR_LENGTH(SUBSTRING_INDEX(logo_url, '.', -1)) - 1), '.png') WHERE logo_url IS NOT NULL");
    }

    public function down(Schema $schema): void
    {
        // Rollback: replace .png with .svg
        $this->addSql("UPDATE ecole SET logo_url = REPLACE(logo_url, '.png', '.svg') WHERE logo_url IS NOT NULL AND logo_url LIKE '%.png'");
    }
}
