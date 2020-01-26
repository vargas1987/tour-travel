<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190304142201 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calculation_setting_domestic_flight (
          id INT AUTO_INCREMENT NOT NULL, 
          departure_territorial_location_id INT NOT NULL, 
          arrival_territorial_location_id INT NOT NULL, 
          departure_time TIME NOT NULL, 
          arrival_time TIME NOT NULL, 
          description VARCHAR(255) DEFAULT NULL, 
          adult_price INT NOT NULL, 
          child_price INT NOT NULL, 
          tax VARCHAR(255) NOT NULL, 
          adult_xl_price INT NOT NULL, 
          child_xl_price INT NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          INDEX IDX_8BF21227C826E599 (
            departure_territorial_location_id
          ), 
          INDEX IDX_8BF21227D1609E81 (
            arrival_territorial_location_id
          ), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          calculation_setting_domestic_flight 
        ADD 
          CONSTRAINT FK_8BF21227C826E599 FOREIGN KEY (
            departure_territorial_location_id
          ) REFERENCES territorial_location (id)');
        $this->addSql('ALTER TABLE 
          calculation_setting_domestic_flight 
        ADD 
          CONSTRAINT FK_8BF21227D1609E81 FOREIGN KEY (
            arrival_territorial_location_id
          ) REFERENCES territorial_location (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE calculation_setting_domestic_flight');
    }
}
