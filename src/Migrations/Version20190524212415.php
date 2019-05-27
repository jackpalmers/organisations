<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190524212415 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fiche_bug ADD num_fiche INT NOT NULL');
        $this->addSql('ALTER TABLE fiche_bug RENAME INDEX idx_257032c39d86650f TO IDX_505C0D909D86650F');
        $this->addSql('ALTER TABLE activite_sportive RENAME INDEX idx_854838139d86650f TO IDX_AB5BCABA9D86650F');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F869D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_10C31F869D86650F ON rdv (user_id_id)');
        $this->addSql('ALTER TABLE fiche_bug RENAME COLUMN_NAME num_fiche TO numero');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activite_sportive RENAME INDEX idx_ab5bcaba9d86650f TO IDX_854838139D86650F');
        $this->addSql('ALTER TABLE fiche_bug DROP num_fiche');
        $this->addSql('ALTER TABLE fiche_bug RENAME INDEX idx_505c0d909d86650f TO IDX_257032C39D86650F');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F869D86650F');
        $this->addSql('DROP INDEX IDX_10C31F869D86650F ON rdv');
        $this->addSql('ALTER TABLE fiche_bug RENAME COLUMN_NAME num_fiche TO numero');

    }
}
