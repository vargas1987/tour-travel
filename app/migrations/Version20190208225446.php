<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190208225446 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calculation_setting_currency_rate (
          id INT AUTO_INCREMENT NOT NULL, 
          currency_from VARCHAR(255) NOT NULL, 
          currency_to VARCHAR(255) NOT NULL, 
          rate NUMERIC(10, 4) NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calculation_settings_fee DROP FOREIGN KEY FK_FFB2331C44990C25');
        $this->addSql('DROP INDEX idx_ffb2331c44990c25 ON calculation_settings_fee');
        $this->addSql('CREATE INDEX IDX_8EE7880D44990C25 ON calculation_settings_fee (park_id)');
        $this->addSql('ALTER TABLE 
          calculation_settings_fee 
        ADD 
          CONSTRAINT FK_FFB2331C44990C25 FOREIGN KEY (park_id) REFERENCES territorial_location (id)');
        $this->addSql('ALTER TABLE calculation_setting_transfer DROP FOREIGN KEY FK_ADD7F6A6F9DF0EA5');
        $this->addSql('ALTER TABLE calculation_setting_transfer DROP FOREIGN KEY FK_ADD7F6A6D1609E81');
        $this->addSql('DROP INDEX idx_add7f6a6d1609e81 ON calculation_setting_transfer');
        $this->addSql('CREATE INDEX IDX_B6F758AD1609E81 ON calculation_setting_transfer (
          arrival_territorial_location_id
        )');
        $this->addSql('DROP INDEX idx_add7f6a6f9df0ea5 ON calculation_setting_transfer');
        $this->addSql('CREATE INDEX IDX_B6F758AF9DF0EA5 ON calculation_setting_transfer (to_territorial_location_id)');
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
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE calculation_setting_currency_rate');
        $this->addSql('ALTER TABLE calculation_setting_transfer DROP FOREIGN KEY FK_B6F758AD1609E81');
        $this->addSql('ALTER TABLE calculation_setting_transfer DROP FOREIGN KEY FK_B6F758AF9DF0EA5');
        $this->addSql('DROP INDEX idx_b6f758ad1609e81 ON calculation_setting_transfer');
        $this->addSql('CREATE INDEX IDX_ADD7F6A6D1609E81 ON calculation_setting_transfer (
          arrival_territorial_location_id
        )');
        $this->addSql('DROP INDEX idx_b6f758af9df0ea5 ON calculation_setting_transfer');
        $this->addSql('CREATE INDEX IDX_ADD7F6A6F9DF0EA5 ON calculation_setting_transfer (to_territorial_location_id)');
        $this->addSql('ALTER TABLE 
          calculation_setting_transfer 
        ADD 
          CONSTRAINT FK_B6F758AD1609E81 FOREIGN KEY (
            arrival_territorial_location_id
          ) REFERENCES territorial_airstrip (id)');
        $this->addSql('ALTER TABLE 
          calculation_setting_transfer 
        ADD 
          CONSTRAINT FK_B6F758AF9DF0EA5 FOREIGN KEY (to_territorial_location_id) REFERENCES territorial_location (id)');
        $this->addSql('ALTER TABLE calculation_settings_fee DROP FOREIGN KEY FK_8EE7880D44990C25');
        $this->addSql('DROP INDEX idx_8ee7880d44990c25 ON calculation_settings_fee');
        $this->addSql('CREATE INDEX IDX_FFB2331C44990C25 ON calculation_settings_fee (park_id)');
        $this->addSql('ALTER TABLE 
          calculation_settings_fee 
        ADD 
          CONSTRAINT FK_8EE7880D44990C25 FOREIGN KEY (park_id) REFERENCES territorial_location (id)');
    }
}
