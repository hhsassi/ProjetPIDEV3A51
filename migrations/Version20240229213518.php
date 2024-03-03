<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229213518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, nom_certif VARCHAR(255) NOT NULL, badge_certif VARCHAR(255) NOT NULL, descriotion_certif VARCHAR(255) NOT NULL, duree_certif INT NOT NULL, niveau_certif INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certification_user (certification_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_CCF1DE6CCB47068A (certification_id), INDEX IDX_CCF1DE6CA76ED395 (user_id), PRIMARY KEY(certification_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, certification_id INT DEFAULT NULL, titre_cours VARCHAR(255) NOT NULL, description_cours VARCHAR(255) NOT NULL, niveau VARCHAR(255) NOT NULL, file VARCHAR(255) NOT NULL, INDEX IDX_FDCA8C9CCB47068A (certification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE certification_user ADD CONSTRAINT FK_CCF1DE6CCB47068A FOREIGN KEY (certification_id) REFERENCES certification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE certification_user ADD CONSTRAINT FK_CCF1DE6CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CCB47068A FOREIGN KEY (certification_id) REFERENCES certification (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certification_user DROP FOREIGN KEY FK_CCF1DE6CCB47068A');
        $this->addSql('ALTER TABLE certification_user DROP FOREIGN KEY FK_CCF1DE6CA76ED395');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CCB47068A');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE certification_user');
        $this->addSql('DROP TABLE cours');
    }
}
