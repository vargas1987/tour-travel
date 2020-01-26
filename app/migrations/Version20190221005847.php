<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190221005847 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calculation_setting_fee (
          id INT AUTO_INCREMENT NOT NULL, 
          park_id INT NOT NULL, 
          type VARCHAR(32) NOT NULL, 
          car INT DEFAULT NULL, 
          driver INT DEFAULT NULL, 
          adult INT DEFAULT NULL, 
          child INT DEFAULT NULL, 
          concession_adult INT DEFAULT NULL, 
          concession_child INT DEFAULT NULL, 
          priceTsh INT DEFAULT NULL, 
          priceUsd INT DEFAULT NULL, 
          INDEX IDX_BC7E198444990C25 (park_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          calculation_setting_fee 
        ADD 
          CONSTRAINT FK_BC7E198444990C25 FOREIGN KEY (park_id) REFERENCES territorial_location (id)');
        $this->addSql('DROP TABLE calculation_settings_fee');
        $this->addSql('ALTER TABLE calculation_setting_transfer DROP FOREIGN KEY FK_ADD7F6A6F9DF0EA5');
        $this->addSql('ALTER TABLE calculation_setting_transfer DROP FOREIGN KEY FK_ADD7F6A6D1609E81');
        $this->addSql('DROP INDEX IDX_B6F758AD1609E81 ON calculation_setting_transfer');
        $this->addSql('DROP INDEX IDX_B6F758AF9DF0EA5 ON calculation_setting_transfer');
        $this->addSql('ALTER TABLE 
          calculation_setting_transfer 
        ADD 
          departure_transfer_territorial_id INT NOT NULL, 
        ADD 
          arrival_transfer_territorial_id INT NOT NULL, 
        DROP 
          to_territorial_location_id, 
        DROP 
          arrival_territorial_location_id');

        $this->addSql('TRUNCATE calculation_setting_transfer;');

        $this->addSql('ALTER TABLE 
          calculation_setting_transfer 
        ADD 
          CONSTRAINT FK_B6F758A271549E9 FOREIGN KEY (
            departure_transfer_territorial_id
          ) REFERENCES settings_transfer_territorial (id)');
        $this->addSql('ALTER TABLE 
          calculation_setting_transfer 
        ADD 
          CONSTRAINT FK_B6F758A3E5332F1 FOREIGN KEY (
            arrival_transfer_territorial_id
          ) REFERENCES settings_transfer_territorial (id)');
        $this->addSql('CREATE INDEX IDX_B6F758A271549E9 ON calculation_setting_transfer (
          departure_transfer_territorial_id
        )');
        $this->addSql('CREATE INDEX IDX_B6F758A3E5332F1 ON calculation_setting_transfer (
          arrival_transfer_territorial_id
        )');
        $this->addSql('DROP INDEX IDX_103489016948DDE6 ON calculation_transfer');
        $this->addSql('DROP INDEX IDX_10348901E4C9A25B ON calculation_transfer');
        $this->addSql('ALTER TABLE 
          calculation_transfer 
        ADD 
          departure_transfer_territorial_id INT NOT NULL, 
        ADD 
          arrival_transfer_territorial_id INT NOT NULL, 
        DROP 
          arrival_airstrip_id, 
        DROP 
          departure_airstrip_id');

        $this->addSql('TRUNCATE calculation_transfer;');

        $this->addSql('ALTER TABLE 
          calculation_transfer 
        ADD 
          CONSTRAINT FK_10348901271549E9 FOREIGN KEY (
            departure_transfer_territorial_id
          ) REFERENCES settings_transfer_territorial (id)');
        $this->addSql('ALTER TABLE 
          calculation_transfer 
        ADD 
          CONSTRAINT FK_103489013E5332F1 FOREIGN KEY (
            arrival_transfer_territorial_id
          ) REFERENCES settings_transfer_territorial (id)');
        $this->addSql('CREATE INDEX IDX_10348901271549E9 ON calculation_transfer (departure_transfer_territorial_id)');
        $this->addSql('CREATE INDEX IDX_103489013E5332F1 ON calculation_transfer (arrival_transfer_territorial_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calculation_settings_fee (
          id INT AUTO_INCREMENT NOT NULL, 
          park_id INT NOT NULL, 
          type VARCHAR(32) NOT NULL COLLATE utf8_unicode_ci, 
          car INT DEFAULT NULL, 
          driver INT DEFAULT NULL, 
          adult INT DEFAULT NULL, 
          child INT DEFAULT NULL, 
          concession_adult INT DEFAULT NULL, 
          concession_child INT DEFAULT NULL, 
          priceTsh INT DEFAULT NULL, 
          priceUsd INT DEFAULT NULL, 
          INDEX IDX_8EE7880D44990C25 (park_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          calculation_settings_fee 
        ADD 
          CONSTRAINT FK_FFB2331C44990C25 FOREIGN KEY (park_id) REFERENCES territorial_location (id)');
        $this->addSql('DROP TABLE calculation_setting_fee');
        $this->addSql('ALTER TABLE calculation_setting_transfer DROP FOREIGN KEY FK_B6F758A271549E9');
        $this->addSql('ALTER TABLE calculation_setting_transfer DROP FOREIGN KEY FK_B6F758A3E5332F1');
        $this->addSql('DROP INDEX IDX_B6F758A271549E9 ON calculation_setting_transfer');
        $this->addSql('DROP INDEX IDX_B6F758A3E5332F1 ON calculation_setting_transfer');
        $this->addSql('ALTER TABLE 
          calculation_setting_transfer 
        ADD 
          to_territorial_location_id INT NOT NULL, 
        ADD 
          arrival_territorial_location_id INT NOT NULL, 
        DROP 
          departure_transfer_territorial_id, 
        DROP 
          arrival_transfer_territorial_id');
        $this->addSql('ALTER TABLE 
          calculation_setting_transfer 
        ADD 
          CONSTRAINT FK_ADD7F6A6F9DF0EA5 FOREIGN KEY (to_territorial_location_id) REFERENCES territorial_location (id)');
        $this->addSql('ALTER TABLE 
          calculation_setting_transfer 
        ADD 
          CONSTRAINT FK_ADD7F6A6D1609E81 FOREIGN KEY (
            arrival_territorial_location_id
          ) REFERENCES territorial_airstrip (id)');
        $this->addSql('CREATE INDEX IDX_B6F758AD1609E81 ON calculation_setting_transfer (
          arrival_territorial_location_id
        )');
        $this->addSql('CREATE INDEX IDX_B6F758AF9DF0EA5 ON calculation_setting_transfer (to_territorial_location_id)');
        $this->addSql('ALTER TABLE calculation_transfer DROP FOREIGN KEY FK_10348901271549E9');
        $this->addSql('ALTER TABLE calculation_transfer DROP FOREIGN KEY FK_103489013E5332F1');
        $this->addSql('DROP INDEX IDX_10348901271549E9 ON calculation_transfer');
        $this->addSql('DROP INDEX IDX_103489013E5332F1 ON calculation_transfer');
        $this->addSql('ALTER TABLE 
          calculation_transfer 
        ADD 
          arrival_airstrip_id INT NOT NULL, 
        ADD 
          departure_airstrip_id INT NOT NULL, 
        DROP 
          departure_transfer_territorial_id, 
        DROP 
          arrival_transfer_territorial_id');
        $this->addSql('CREATE INDEX IDX_103489016948DDE6 ON calculation_transfer (arrival_airstrip_id)');
        $this->addSql('CREATE INDEX IDX_10348901E4C9A25B ON calculation_transfer (departure_airstrip_id)');
    }
}
