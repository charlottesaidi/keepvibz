<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210603092741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audio CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE competence CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE region CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE texte CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audio CHANGE deleted_at deleted_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE category CHANGE deleted_at deleted_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE competence CHANGE deleted_at deleted_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE region CHANGE deleted_at deleted_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE texte CHANGE deleted_at deleted_at DATETIME NOT NULL');
    }
}
