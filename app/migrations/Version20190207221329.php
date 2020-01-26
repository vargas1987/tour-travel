<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190207221329 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calculation_settings_fee (
          id INT AUTO_INCREMENT NOT NULL, 
          park_id INT NOT NULL, 
          type VARCHAR(32) NOT NULL, 
          car INT DEFAULT NULL, 
          driver INT DEFAULT NULL, 
          adult INT DEFAULT NULL, 
          child INT DEFAULT NULL, 
          concession_adult INT DEFAULT NULL, 
          concession_child INT DEFAULT NULL, 
          adult_concession INT DEFAULT NULL, 
          child_concession INT DEFAULT NULL, 
          priceTsh INT DEFAULT NULL, 
          priceUsd INT DEFAULT NULL, 
          INDEX IDX_FFB2331C44990C25 (park_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calculation_setting_car_rental (
          id INT AUTO_INCREMENT NOT NULL, 
          countDays INT NOT NULL, 
          price INT NOT NULL, 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calculation_setting_transfer (
          id INT AUTO_INCREMENT NOT NULL, 
          arrival_territorial_location_id INT NOT NULL, 
          to_territorial_location_id INT NOT NULL, 
          price INT NOT NULL, 
          INDEX IDX_ADD7F6A6D1609E81 (
            arrival_territorial_location_id
          ), 
          INDEX IDX_ADD7F6A6F9DF0EA5 (to_territorial_location_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          calculation_settings_fee 
        ADD 
          CONSTRAINT FK_FFB2331C44990C25 FOREIGN KEY (park_id) REFERENCES territorial_location (id)');
        $this->addSql('ALTER TABLE 
          calculation_setting_transfer 
        ADD 
          CONSTRAINT FK_ADD7F6A6D1609E81 FOREIGN KEY (
            arrival_territorial_location_id
          ) REFERENCES territorial_airstrip (id)');
        $this->addSql('ALTER TABLE 
          calculation_setting_transfer 
        ADD 
          CONSTRAINT FK_ADD7F6A6F9DF0EA5 FOREIGN KEY (to_territorial_location_id) REFERENCES territorial_location (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE abstract_calculation_settings_fee');
        $this->addSql('DROP TABLE CalculationSettingCarRental');
        $this->addSql('DROP TABLE calculation_settings_transfer');
    }
}
