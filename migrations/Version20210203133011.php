<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203133011 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE working_partner (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE working_partner_project (working_partner_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_2C177FA02F3DDAB7 (working_partner_id), INDEX IDX_2C177FA0166D1F9C (project_id), PRIMARY KEY(working_partner_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE working_partner_project ADD CONSTRAINT FK_2C177FA02F3DDAB7 FOREIGN KEY (working_partner_id) REFERENCES working_partner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE working_partner_project ADD CONSTRAINT FK_2C177FA0166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE working_partner_project DROP FOREIGN KEY FK_2C177FA02F3DDAB7');
        $this->addSql('DROP TABLE working_partner');
        $this->addSql('DROP TABLE working_partner_project');
    }
}
