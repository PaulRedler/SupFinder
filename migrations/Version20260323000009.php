<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to remove single quotes from ecole logoUrl paths
 */
final class Version20260323000009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove single quotes from ecole logoUrl paths';
    }

    public function up(Schema $schema): void
    {
        // Remove single quotes from logo_url values
        $this->addSql("UPDATE ecole SET logo_url = TRIM(BOTH \"'\" FROM logo_url) WHERE logo_url IS NOT NULL AND logo_url LIKE \"'%'\"");
    }

    public function down(Schema $schema): void
    {
        // Add single quotes back around logo_url values
        $this->addSql("UPDATE ecole SET logo_url = CONCAT(\"'\", logo_url, \"'\") WHERE logo_url IS NOT NULL AND logo_url NOT LIKE \"'%'\"");
    }
}
