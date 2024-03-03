<?php

declare(strict_types=1);

namespace DoctrineMigrations\us;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213213547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remboursement ADD pret_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE remboursement ADD CONSTRAINT FK_C0C0D9EF1B61704B FOREIGN KEY (pret_id) REFERENCES pret (id)');
        $this->addSql('CREATE INDEX IDX_C0C0D9EF1B61704B ON remboursement (pret_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remboursement DROP FOREIGN KEY FK_C0C0D9EF1B61704B');
        $this->addSql('DROP INDEX IDX_C0C0D9EF1B61704B ON remboursement');
        $this->addSql('ALTER TABLE remboursement DROP pret_id');
    }
}
