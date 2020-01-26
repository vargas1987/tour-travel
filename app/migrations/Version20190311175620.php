<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190311175620 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('TRUNCATE calculation_setting_fee;');
        $this->addSql('TRUNCATE calculation_day;');

        $this->addSql('ALTER TABLE calculation_setting_fee DROP FOREIGN KEY FK_BC7E198444990C25');
        $this->addSql('ALTER TABLE 
          calculation_setting_fee 
        ADD 
          CONSTRAINT FK_BC7E198444990C25 FOREIGN KEY (park_id) REFERENCES territorial_park (id)');
        $this->addSql('ALTER TABLE calculation_day DROP FOREIGN KEY FK_316A1D5E44990C25');
        $this->addSql('ALTER TABLE 
          calculation_day 
        ADD 
          CONSTRAINT FK_316A1D5E44990C25 FOREIGN KEY (park_id) REFERENCES territorial_park (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calculation_day DROP FOREIGN KEY FK_316A1D5E44990C25');
        $this->addSql('ALTER TABLE 
          calculation_day 
        ADD 
          CONSTRAINT FK_316A1D5E44990C25 FOREIGN KEY (park_id) REFERENCES territorial_location (id)');
        $this->addSql('ALTER TABLE calculation_setting_fee DROP FOREIGN KEY FK_BC7E198444990C25');
        $this->addSql('ALTER TABLE 
          calculation_setting_fee 
        ADD 
          CONSTRAINT FK_BC7E198444990C25 FOREIGN KEY (park_id) REFERENCES territorial_location (id)');
    }
}
