<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210603083732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP user_id, DROP region_id, CHANGE status status LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', CHANGE modified_at modified_at DATETIME DEFAULT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE audio DROP user_id, CHANGE type type LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE avatar DROP user_id');
        $this->addSql('ALTER TABLE texte DROP user_id, CHANGE status status LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce ADD user_id INT NOT NULL, ADD region_id INT NOT NULL, CHANGE status status VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE modified_at modified_at DATETIME NOT NULL, CHANGE deleted_at deleted_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE audio ADD user_id INT NOT NULL, CHANGE type type VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE avatar ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE texte ADD user_id INT NOT NULL, CHANGE status status VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
