<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260310135922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accreditation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, organisme VARCHAR(255) NOT NULL, niveau VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, avis LONGTEXT NOT NULL, note_enseignement DOUBLE PRECISION DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, note_globale DOUBLE PRECISION DEFAULT NULL, modere TINYINT NOT NULL, formation_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_8F91ABF05200282E (formation_id), INDEX IDX_8F91ABF0A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE domaine_formation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE domaine_formation_formation (domaine_formation_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_819DE503E22A2443 (domaine_formation_id), INDEX IDX_819DE5035200282E (formation_id), PRIMARY KEY (domaine_formation_id, formation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE domaine_formation_avis (domaine_formation_id INT NOT NULL, avis_id INT NOT NULL, INDEX IDX_1ABA75BE22A2443 (domaine_formation_id), INDEX IDX_1ABA75B197E709F (avis_id), PRIMARY KEY (domaine_formation_id, avis_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE ecole (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, email_contact VARCHAR(255) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, description_courte LONGTEXT DEFAULT NULL, description_longue LONGTEXT DEFAULT NULL, logo_url VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, media_id INT DEFAULT NULL, INDEX IDX_9786AACEA9FDD75 (media_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE ecole_status (ecole_id INT NOT NULL, status_id INT NOT NULL, INDEX IDX_1FFDF33D77EF1B1E (ecole_id), INDEX IDX_1FFDF33D6BF700BD (status_id), PRIMARY KEY (ecole_id, status_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE ecole_accreditation (id INT AUTO_INCREMENT NOT NULL, date_obtention DATE DEFAULT NULL, date_expi DATE DEFAULT NULL, accreditation_id INT DEFAULT NULL, ecole_id INT DEFAULT NULL, INDEX IDX_9DECE316A0822E24 (accreditation_id), INDEX IDX_9DECE31677EF1B1E (ecole_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, diplome VARCHAR(255) DEFAULT NULL, mode_formation VARCHAR(255) DEFAULT NULL, cout_min DOUBLE PRECISION DEFAULT NULL, cout_max DOUBLE PRECISION DEFAULT NULL, page INT DEFAULT NULL, slug VARCHAR(255) NOT NULL, ecole_id INT DEFAULT NULL, INDEX IDX_404021BF77EF1B1E (ecole_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, status_id INT DEFAULT NULL, INDEX IDX_6DC044C56BF700BD (status_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE group_ecole (group_id INT NOT NULL, ecole_id INT NOT NULL, INDEX IDX_595441CBFE54D947 (group_id), INDEX IDX_595441CB77EF1B1E (ecole_id), PRIMARY KEY (group_id, ecole_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, alt VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, type_ecole_id INT DEFAULT NULL, INDEX IDX_6A2CA10CBA103CE2 (type_ecole_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE niveau_formation (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, ordre INT DEFAULT NULL, formation_id INT DEFAULT NULL, domaine_formation_id INT DEFAULT NULL, INDEX IDX_1291C5495200282E (formation_id), INDEX IDX_1291C549E22A2443 (domaine_formation_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, info LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE type_ecole (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, info LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, manage_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649F1AF8971 (manage_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF05200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE domaine_formation_formation ADD CONSTRAINT FK_819DE503E22A2443 FOREIGN KEY (domaine_formation_id) REFERENCES domaine_formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE domaine_formation_formation ADD CONSTRAINT FK_819DE5035200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE domaine_formation_avis ADD CONSTRAINT FK_1ABA75BE22A2443 FOREIGN KEY (domaine_formation_id) REFERENCES domaine_formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE domaine_formation_avis ADD CONSTRAINT FK_1ABA75B197E709F FOREIGN KEY (avis_id) REFERENCES avis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ecole ADD CONSTRAINT FK_9786AACEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE ecole_status ADD CONSTRAINT FK_1FFDF33D77EF1B1E FOREIGN KEY (ecole_id) REFERENCES ecole (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ecole_status ADD CONSTRAINT FK_1FFDF33D6BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ecole_accreditation ADD CONSTRAINT FK_9DECE316A0822E24 FOREIGN KEY (accreditation_id) REFERENCES accreditation (id)');
        $this->addSql('ALTER TABLE ecole_accreditation ADD CONSTRAINT FK_9DECE31677EF1B1E FOREIGN KEY (ecole_id) REFERENCES ecole (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF77EF1B1E FOREIGN KEY (ecole_id) REFERENCES ecole (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C56BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE group_ecole ADD CONSTRAINT FK_595441CBFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_ecole ADD CONSTRAINT FK_595441CB77EF1B1E FOREIGN KEY (ecole_id) REFERENCES ecole (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CBA103CE2 FOREIGN KEY (type_ecole_id) REFERENCES type_ecole (id)');
        $this->addSql('ALTER TABLE niveau_formation ADD CONSTRAINT FK_1291C5495200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE niveau_formation ADD CONSTRAINT FK_1291C549E22A2443 FOREIGN KEY (domaine_formation_id) REFERENCES domaine_formation (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649F1AF8971 FOREIGN KEY (manage_id) REFERENCES `group` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF05200282E');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0A76ED395');
        $this->addSql('ALTER TABLE domaine_formation_formation DROP FOREIGN KEY FK_819DE503E22A2443');
        $this->addSql('ALTER TABLE domaine_formation_formation DROP FOREIGN KEY FK_819DE5035200282E');
        $this->addSql('ALTER TABLE domaine_formation_avis DROP FOREIGN KEY FK_1ABA75BE22A2443');
        $this->addSql('ALTER TABLE domaine_formation_avis DROP FOREIGN KEY FK_1ABA75B197E709F');
        $this->addSql('ALTER TABLE ecole DROP FOREIGN KEY FK_9786AACEA9FDD75');
        $this->addSql('ALTER TABLE ecole_status DROP FOREIGN KEY FK_1FFDF33D77EF1B1E');
        $this->addSql('ALTER TABLE ecole_status DROP FOREIGN KEY FK_1FFDF33D6BF700BD');
        $this->addSql('ALTER TABLE ecole_accreditation DROP FOREIGN KEY FK_9DECE316A0822E24');
        $this->addSql('ALTER TABLE ecole_accreditation DROP FOREIGN KEY FK_9DECE31677EF1B1E');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF77EF1B1E');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C56BF700BD');
        $this->addSql('ALTER TABLE group_ecole DROP FOREIGN KEY FK_595441CBFE54D947');
        $this->addSql('ALTER TABLE group_ecole DROP FOREIGN KEY FK_595441CB77EF1B1E');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CBA103CE2');
        $this->addSql('ALTER TABLE niveau_formation DROP FOREIGN KEY FK_1291C5495200282E');
        $this->addSql('ALTER TABLE niveau_formation DROP FOREIGN KEY FK_1291C549E22A2443');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649F1AF8971');
        $this->addSql('DROP TABLE accreditation');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE domaine_formation');
        $this->addSql('DROP TABLE domaine_formation_formation');
        $this->addSql('DROP TABLE domaine_formation_avis');
        $this->addSql('DROP TABLE ecole');
        $this->addSql('DROP TABLE ecole_status');
        $this->addSql('DROP TABLE ecole_accreditation');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_ecole');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE niveau_formation');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE type_ecole');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
