<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229213658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certification_user DROP FOREIGN KEY FK_CCF1DE6CA76ED395');
        $this->addSql('ALTER TABLE certification_user DROP FOREIGN KEY FK_CCF1DE6CCB47068A');
        $this->addSql('DROP TABLE certification_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certification_user (certification_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_CCF1DE6CCB47068A (certification_id), INDEX IDX_CCF1DE6CA76ED395 (user_id), PRIMARY KEY(certification_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE certification_user ADD CONSTRAINT FK_CCF1DE6CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE certification_user ADD CONSTRAINT FK_CCF1DE6CCB47068A FOREIGN KEY (certification_id) REFERENCES certification (id) ON DELETE CASCADE');
    }
}
