<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107142952 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE filieres ADD departements_id INT NOT NULL');
        $this->addSql('ALTER TABLE filieres ADD CONSTRAINT FK_C97A1151DB279A6 FOREIGN KEY (departements_id) REFERENCES departements (id)');
        $this->addSql('CREATE INDEX IDX_C97A1151DB279A6 ON filieres (departements_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE filieres DROP FOREIGN KEY FK_C97A1151DB279A6');
        $this->addSql('DROP INDEX IDX_C97A1151DB279A6 ON filieres');
        $this->addSql('ALTER TABLE filieres DROP departements_id');
    }
}
