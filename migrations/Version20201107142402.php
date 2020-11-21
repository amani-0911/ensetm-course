<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107142402 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles_filieres (articles_id INT NOT NULL, filieres_id INT NOT NULL, INDEX IDX_AD03570F1EBAF6CC (articles_id), INDEX IDX_AD03570FA5DB2FE8 (filieres_id), PRIMARY KEY(articles_id, filieres_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles_filieres ADD CONSTRAINT FK_AD03570F1EBAF6CC FOREIGN KEY (articles_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_filieres ADD CONSTRAINT FK_AD03570FA5DB2FE8 FOREIGN KEY (filieres_id) REFERENCES filieres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article ADD users_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_BFDD316867B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_BFDD316867B3B43D ON article (users_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE articles_filieres');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_BFDD316867B3B43D');
        $this->addSql('DROP INDEX IDX_BFDD316867B3B43D ON article');
        $this->addSql('ALTER TABLE article DROP users_id');
    }
}
