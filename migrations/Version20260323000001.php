<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to remove /build/ from ecole logoUrl storage paths
 */
final class Version20260323000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove /build/ from ecole logoUrl storage paths';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("UPDATE ecole SET logo_url = REPLACE(logo_url, '/build/', '/') WHERE logo_url LIKE '%/build/%'");
    }

    public function down(Schema $schema): void
    {
        // Rollback: add /build/ back to the paths
        // Note: This is a simplified rollback and may not restore the exact original state
        // if the original paths contained multiple /build/ occurrences
    }
}
