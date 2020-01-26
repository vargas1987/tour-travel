<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180829111342 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE 
          hotel_price CHANGE meal_plan_type meal_plan_type VARCHAR(32) DEFAULT NULL, 
          CHANGE room_id room_id INT DEFAULT NULL, 
          CHANGE accommodation_type accommodation_type VARCHAR(32) DEFAULT NULL, 
          CHANGE season_type season_type VARCHAR(32) DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel_room DROP max_pax, CHANGE hotel_id hotel_id INT NOT NULL');
        $this->addSql('ALTER TABLE 
          hotel_room 
        ADD 
          CONSTRAINT FK_C55A87138CDE5729 FOREIGN KEY (type) REFERENCES type_room (type)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE 
          hotel_price CHANGE room_id room_id INT NOT NULL, 
          CHANGE meal_plan_type meal_plan_type VARCHAR(32) NOT NULL COLLATE utf8_unicode_ci, 
          CHANGE accommodation_type accommodation_type VARCHAR(32) NOT NULL COLLATE utf8_unicode_ci, 
          CHANGE season_type season_type VARCHAR(32) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE hotel_room DROP FOREIGN KEY FK_C55A87138CDE5729');
        $this->addSql('ALTER TABLE hotel_room ADD max_pax INT DEFAULT NULL, CHANGE hotel_id hotel_id INT DEFAULT NULL');
    }
}
