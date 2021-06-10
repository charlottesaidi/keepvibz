<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210609215048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avatar (id INT AUTO_INCREMENT NOT NULL, file VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(25) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instru (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, genre LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', bpm INT NOT NULL, cle VARCHAR(255) NOT NULL, file VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, modified_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_AF2F6724A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instru_topline (instru_id INT NOT NULL, topline_id INT NOT NULL, INDEX IDX_36835DF2D868EB9A (instru_id), INDEX IDX_36835DF2E3B5384D (topline_id), PRIMARY KEY(instru_id, topline_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE texte (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, instru_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_EAE1A6EEA76ED395 (user_id), INDEX IDX_EAE1A6EED868EB9A (instru_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topline (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, file VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_756B1DECA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, avatar_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, bio LONGTEXT DEFAULT NULL, town VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, valid TINYINT(1) NOT NULL, actif TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64986383B10 (avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_competence (user_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_33B3AE93A76ED395 (user_id), INDEX IDX_33B3AE9315761DAB (competence_id), PRIMARY KEY(user_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE instru ADD CONSTRAINT FK_AF2F6724A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE instru_topline ADD CONSTRAINT FK_36835DF2D868EB9A FOREIGN KEY (instru_id) REFERENCES instru (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instru_topline ADD CONSTRAINT FK_36835DF2E3B5384D FOREIGN KEY (topline_id) REFERENCES topline (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE texte ADD CONSTRAINT FK_EAE1A6EEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE texte ADD CONSTRAINT FK_EAE1A6EED868EB9A FOREIGN KEY (instru_id) REFERENCES instru (id)');
        $this->addSql('ALTER TABLE topline ADD CONSTRAINT FK_756B1DECA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES avatar (id)');
        $this->addSql('ALTER TABLE user_competence ADD CONSTRAINT FK_33B3AE93A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_competence ADD CONSTRAINT FK_33B3AE9315761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('ALTER TABLE user_competence DROP FOREIGN KEY FK_33B3AE9315761DAB');
        $this->addSql('ALTER TABLE instru_topline DROP FOREIGN KEY FK_36835DF2D868EB9A');
        $this->addSql('ALTER TABLE texte DROP FOREIGN KEY FK_EAE1A6EED868EB9A');
        $this->addSql('ALTER TABLE instru_topline DROP FOREIGN KEY FK_36835DF2E3B5384D');
        $this->addSql('ALTER TABLE instru DROP FOREIGN KEY FK_AF2F6724A76ED395');
        $this->addSql('ALTER TABLE texte DROP FOREIGN KEY FK_EAE1A6EEA76ED395');
        $this->addSql('ALTER TABLE topline DROP FOREIGN KEY FK_756B1DECA76ED395');
        $this->addSql('ALTER TABLE user_competence DROP FOREIGN KEY FK_33B3AE93A76ED395');
        $this->addSql('DROP TABLE avatar');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE instru');
        $this->addSql('DROP TABLE instru_topline');
        $this->addSql('DROP TABLE texte');
        $this->addSql('DROP TABLE topline');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_competence');
    }
}
