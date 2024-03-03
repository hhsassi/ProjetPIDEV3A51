<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229203031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, nom_certif VARCHAR(255) NOT NULL, badge_certif VARCHAR(255) NOT NULL, descriotion_certif VARCHAR(255) NOT NULL, duree_certif INT NOT NULL, niveau_certif INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, rib VARCHAR(50) NOT NULL, type_c VARCHAR(50) NOT NULL, solde_c DOUBLE PRECISION NOT NULL, frais_c DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, certification_id INT DEFAULT NULL, titre_cours VARCHAR(255) NOT NULL, description_cours VARCHAR(255) NOT NULL, niveau VARCHAR(255) NOT NULL, file VARCHAR(255) NOT NULL, INDEX IDX_FDCA8C9CCB47068A (certification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etats_financier (id INT AUTO_INCREMENT NOT NULL, projet_id INT NOT NULL, bilan_financier VARCHAR(255) NOT NULL, compte_des_resultats VARCHAR(255) NOT NULL, tableau_des_flux VARCHAR(255) NOT NULL, ratio_de_rentabilite VARCHAR(255) NOT NULL, ratio_endettement VARCHAR(255) NOT NULL, INDEX IDX_98B5D2D3C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription_certif (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, certification_id INT DEFAULT NULL, INDEX IDX_E46FEC0BA76ED395 (user_id), INDEX IDX_E46FEC0BCB47068A (certification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, nom_p VARCHAR(50) NOT NULL, description_p VARCHAR(255) NOT NULL, date_p DATE NOT NULL, somme_voulue_p DOUBLE PRECISION NOT NULL, part_offerte_p DOUBLE PRECISION NOT NULL, type_p VARCHAR(50) NOT NULL, etat_p VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, compte_id INT NOT NULL, montant_t DOUBLE PRECISION NOT NULL, date_t DATETIME NOT NULL, rib_dest VARCHAR(50) NOT NULL, INDEX IDX_723705D1F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, cin VARCHAR(8) NOT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(20) NOT NULL, num_tel VARCHAR(50) NOT NULL, adress VARCHAR(100) NOT NULL, dob DATE NOT NULL, auth_code VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649ABE530DA (cin), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CCB47068A FOREIGN KEY (certification_id) REFERENCES certification (id)');
        $this->addSql('ALTER TABLE etats_financier ADD CONSTRAINT FK_98B5D2D3C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE inscription_certif ADD CONSTRAINT FK_E46FEC0BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE inscription_certif ADD CONSTRAINT FK_E46FEC0BCB47068A FOREIGN KEY (certification_id) REFERENCES certification (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CCB47068A');
        $this->addSql('ALTER TABLE etats_financier DROP FOREIGN KEY FK_98B5D2D3C18272');
        $this->addSql('ALTER TABLE inscription_certif DROP FOREIGN KEY FK_E46FEC0BA76ED395');
        $this->addSql('ALTER TABLE inscription_certif DROP FOREIGN KEY FK_E46FEC0BCB47068A');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1F2C56620');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE etats_financier');
        $this->addSql('DROP TABLE inscription_certif');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
