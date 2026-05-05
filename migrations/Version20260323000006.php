<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to fix closing single quotes in ecole logoUrl
 */
final class Version20260323000006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add closing single quotes to ecole logoUrl paths';
    }

    public function up(Schema $schema): void
    {
        // Add closing single quotes where missing
        $this->addSql("UPDATE ecole SET logo_url = CONCAT(logo_url, \"'\") WHERE logo_url IS NOT NULL AND logo_url LIKE \"'images/%\" AND logo_url NOT LIKE \"%'\"");
    }

    public function down(Schema $schema): void
    {
        // Remove closing single quotes
        $this->addSql("UPDATE ecole SET logo_url = SUBSTRING(logo_url, 1, CHAR_LENGTH(logo_url) - 1) WHERE logo_url IS NOT NULL AND logo_url LIKE \"%'\"");
    }
}
