<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240207181654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, nom_certif VARCHAR(100) NOT NULL, niveau_certif INT NOT NULL, duree_certif INT NOT NULL, badge_certif VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, rib VARCHAR(50) NOT NULL, type_c VARCHAR(50) NOT NULL, solde_c DOUBLE PRECISION NOT NULL, frais_c DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etats_financier (id INT AUTO_INCREMENT NOT NULL, projet_id INT NOT NULL, bilan_financier VARCHAR(255) NOT NULL, compte_des_resultats VARCHAR(255) NOT NULL, tableau_des_flux VARCHAR(255) NOT NULL, ratio_de_rentabilite VARCHAR(255) NOT NULL, ratio_endettement VARCHAR(255) NOT NULL, INDEX IDX_98B5D2D3C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, certification_id INT NOT NULL, nom_module VARCHAR(100) NOT NULL, description_module VARCHAR(255) NOT NULL, duree_module INT NOT NULL, INDEX IDX_C242628CB47068A (certification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, nom_p VARCHAR(50) NOT NULL, description_p VARCHAR(255) NOT NULL, date_p DATE NOT NULL, somme_voulue_p DOUBLE PRECISION NOT NULL, part_offerte_p DOUBLE PRECISION NOT NULL, type_p VARCHAR(50) NOT NULL, etat_p VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, compte_id INT NOT NULL, montant_t DOUBLE PRECISION NOT NULL, date_t DATETIME NOT NULL, rib_dest VARCHAR(50) NOT NULL, INDEX IDX_723705D1F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etats_financier ADD CONSTRAINT FK_98B5D2D3C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628CB47068A FOREIGN KEY (certification_id) REFERENCES certification (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etats_financier DROP FOREIGN KEY FK_98B5D2D3C18272');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628CB47068A');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1F2C56620');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE etats_financier');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE transaction');
    }
}
