<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190503203706 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tache_sport ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE tache_sport ADD CONSTRAINT FK_854838139D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_854838139D86650F ON tache_sport (user_id_id)');
        $this->addSql('ALTER TABLE tache_dev ADD CONSTRAINT FK_257032C39D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_257032C39D86650F ON tache_dev (user_id_id)');
        $this->addSql('ALTER TABLE tache_rdv ADD CONSTRAINT FK_24C0DC409D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_24C0DC409D86650F ON tache_rdv (user_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tache_dev DROP FOREIGN KEY FK_257032C39D86650F');
        $this->addSql('DROP INDEX IDX_257032C39D86650F ON tache_dev');
        $this->addSql('ALTER TABLE tache_rdv DROP FOREIGN KEY FK_24C0DC409D86650F');
        $this->addSql('DROP INDEX IDX_24C0DC409D86650F ON tache_rdv');
        $this->addSql('ALTER TABLE tache_sport DROP FOREIGN KEY FK_854838139D86650F');
        $this->addSql('DROP INDEX IDX_854838139D86650F ON tache_sport');
        $this->addSql('ALTER TABLE tache_sport DROP user_id_id');
    }
}
