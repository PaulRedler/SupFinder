<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to add single quotes around ecole logoUrl paths
 */
final class Version20260323000004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add single quotes around ecole logoUrl paths';
    }

    public function up(Schema $schema): void
    {
        // Add single quotes around logo_url values
        $this->addSql("UPDATE ecole SET logo_url = CONCAT(\"'\", logo_url, \"'\") WHERE logo_url IS NOT NULL AND logo_url NOT LIKE \"'%'\"");
    }

    public function down(Schema $schema): void
    {
        // Remove single quotes from logo_url values
        $this->addSql("UPDATE ecole SET logo_url = TRIM(BOTH \"'\" FROM logo_url) WHERE logo_url IS NOT NULL AND logo_url LIKE \"'%'\"");
    }
}
