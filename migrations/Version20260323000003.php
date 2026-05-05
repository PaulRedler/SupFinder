<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to update ecole logoUrl to simple relative paths
 */
final class Version20260323000003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update ecole logoUrl to simple relative path format images/filename';
    }

    public function up(Schema $schema): void
    {
        // Update all logoUrl to simple relative path format images/{filename}
        $this->addSql("UPDATE ecole SET logo_url = CONCAT('images/', SUBSTRING_INDEX(logo_url, '\\\\', -1)) WHERE logo_url IS NOT NULL AND logo_url LIKE '%assets%images%'");
    }

    public function down(Schema $schema): void
    {
        // Rollback: convert back to absolute Windows paths
        $this->addSql("UPDATE ecole SET logo_url = CONCAT('C:\\\\Users\\\\REDLER\\\\SupFinder\\\\assets\\\\images\\\\', SUBSTRING_INDEX(logo_url, '/', -1)) WHERE logo_url IS NOT NULL AND logo_url LIKE 'images/%'");
    }
}
