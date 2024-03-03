<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303152941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, certification_id INT NOT NULL, nom_module VARCHAR(100) NOT NULL, description_module VARCHAR(255) NOT NULL, duree_module INT NOT NULL, INDEX IDX_C242628CB47068A (certification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628CB47068A FOREIGN KEY (certification_id) REFERENCES certification (id)');
        $this->addSql('ALTER TABLE certification DROP descriotion_certif, CHANGE nom_certif nom_certif VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628CB47068A');
        $this->addSql('DROP TABLE module');
        $this->addSql('ALTER TABLE certification ADD descriotion_certif VARCHAR(255) NOT NULL, CHANGE nom_certif nom_certif VARCHAR(255) NOT NULL');
    }
}
