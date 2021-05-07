<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210505075435 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE piece (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE libelle ADD courrier_id INT NOT NULL, CHANGE nom nom_l VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE libelle ADD CONSTRAINT FK_A4D607598BF41DC7 FOREIGN KEY (courrier_id) REFERENCES courrier (id)');
        $this->addSql('CREATE INDEX IDX_A4D607598BF41DC7 ON libelle (courrier_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE matricule matricule VARCHAR(255) NOT NULL, CHANGE contact contact VARCHAR(255) NOT NULL, CHANGE ip ip VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE piece');
        $this->addSql('ALTER TABLE libelle DROP FOREIGN KEY FK_A4D607598BF41DC7');
        $this->addSql('DROP INDEX IDX_A4D607598BF41DC7 ON libelle');
        $this->addSql('ALTER TABLE libelle DROP courrier_id, CHANGE nom_l nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE matricule matricule VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contact contact VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ip ip VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
