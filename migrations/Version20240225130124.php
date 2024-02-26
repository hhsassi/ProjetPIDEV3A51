<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240225130124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certification_certification DROP FOREIGN KEY FK_AF923529A047364B');
        $this->addSql('ALTER TABLE certification_certification DROP FOREIGN KEY FK_AF923529B9A266C4');
        $this->addSql('DROP TABLE certification_certification');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certification_certification (certification_source INT NOT NULL, certification_target INT NOT NULL, INDEX IDX_AF923529B9A266C4 (certification_source), INDEX IDX_AF923529A047364B (certification_target), PRIMARY KEY(certification_source, certification_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE certification_certification ADD CONSTRAINT FK_AF923529A047364B FOREIGN KEY (certification_target) REFERENCES certification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE certification_certification ADD CONSTRAINT FK_AF923529B9A266C4 FOREIGN KEY (certification_source) REFERENCES certification (id) ON DELETE CASCADE');
    }
}
