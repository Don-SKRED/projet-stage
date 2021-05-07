<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210505082844 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE upload ADD courier_id INT NOT NULL');
        $this->addSql('ALTER TABLE upload ADD CONSTRAINT FK_17BDE61FE3D8151C FOREIGN KEY (courier_id) REFERENCES courrier (id)');
        $this->addSql('CREATE INDEX IDX_17BDE61FE3D8151C ON upload (courier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE upload DROP FOREIGN KEY FK_17BDE61FE3D8151C');
        $this->addSql('DROP INDEX IDX_17BDE61FE3D8151C ON upload');
        $this->addSql('ALTER TABLE upload DROP courier_id');
    }
}
