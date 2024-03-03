<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229230828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscription_certif (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, certification_id INT DEFAULT NULL, INDEX IDX_E46FEC0BA76ED395 (user_id), INDEX IDX_E46FEC0BCB47068A (certification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscription_certif ADD CONSTRAINT FK_E46FEC0BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE inscription_certif ADD CONSTRAINT FK_E46FEC0BCB47068A FOREIGN KEY (certification_id) REFERENCES certification (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription_certif DROP FOREIGN KEY FK_E46FEC0BA76ED395');
        $this->addSql('ALTER TABLE inscription_certif DROP FOREIGN KEY FK_E46FEC0BCB47068A');
        $this->addSql('DROP TABLE inscription_certif');
    }
}
