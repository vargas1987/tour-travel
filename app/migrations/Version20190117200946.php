<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190117200946 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calculation_night (
          id INT AUTO_INCREMENT NOT NULL, 
          calculation_id INT NOT NULL, 
          hotel_id INT NOT NULL, 
          meal_plan_type VARCHAR(32) NOT NULL, 
          room_id INT NOT NULL, 
          count_rooms INT NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          type VARCHAR(32) NOT NULL, 
          night INT DEFAULT NULL, 
          night_from INT DEFAULT NULL, 
          night_to INT DEFAULT NULL, 
          INDEX IDX_6517D528CE3D4B33 (calculation_id), 
          INDEX IDX_6517D5283243BB18 (hotel_id), 
          INDEX IDX_6517D528276799D0 (meal_plan_type), 
          INDEX IDX_6517D52854177093 (room_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calculation_day (
          id INT AUTO_INCREMENT NOT NULL, 
          calculation_id INT NOT NULL, 
          park_id INT NOT NULL, 
          count_days INT NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          type VARCHAR(32) NOT NULL, 
          INDEX IDX_316A1D5ECE3D4B33 (calculation_id), 
          INDEX IDX_316A1D5E44990C25 (park_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          calculation_night 
        ADD 
          CONSTRAINT FK_6517D528CE3D4B33 FOREIGN KEY (calculation_id) REFERENCES calculation (id)');
        $this->addSql('ALTER TABLE 
          calculation_night 
        ADD 
          CONSTRAINT FK_6517D5283243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE 
          calculation_night 
        ADD 
          CONSTRAINT FK_6517D528276799D0 FOREIGN KEY (meal_plan_type) REFERENCES type_meal_plan (type)');
        $this->addSql('ALTER TABLE 
          calculation_night 
        ADD 
          CONSTRAINT FK_6517D52854177093 FOREIGN KEY (room_id) REFERENCES hotel_room (id)');
        $this->addSql('ALTER TABLE 
          calculation_day 
        ADD 
          CONSTRAINT FK_316A1D5ECE3D4B33 FOREIGN KEY (calculation_id) REFERENCES calculation (id)');
        $this->addSql('ALTER TABLE 
          calculation_day 
        ADD 
          CONSTRAINT FK_316A1D5E44990C25 FOREIGN KEY (park_id) REFERENCES territorial_location (id)');
        $this->addSql('ALTER TABLE calculation_flight DROP FOREIGN KEY FK_99FD85C913755BFE');
        $this->addSql('DROP INDEX IDX_99FD85C913755BFE ON calculation_flight');
        $this->addSql('ALTER TABLE 
          calculation_flight 
        ADD 
          arrival_airstrip_id INT NOT NULL, 
        ADD 
          departure_airstrip_id INT NOT NULL, 
        DROP 
          airstrip_id, 
          CHANGE calculation_id calculation_id INT NOT NULL');
        $this->addSql('ALTER TABLE 
          calculation_flight 
        ADD 
          CONSTRAINT FK_99FD85C96948DDE6 FOREIGN KEY (arrival_airstrip_id) REFERENCES territorial_airstrip (id)');
        $this->addSql('ALTER TABLE 
          calculation_flight 
        ADD 
          CONSTRAINT FK_99FD85C9E4C9A25B FOREIGN KEY (departure_airstrip_id) REFERENCES territorial_airstrip (id)');
        $this->addSql('CREATE INDEX IDX_99FD85C96948DDE6 ON calculation_flight (arrival_airstrip_id)');
        $this->addSql('CREATE INDEX IDX_99FD85C9E4C9A25B ON calculation_flight (departure_airstrip_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE calculation_night');
        $this->addSql('DROP TABLE calculation_day');
        $this->addSql('ALTER TABLE calculation_flight DROP FOREIGN KEY FK_99FD85C96948DDE6');
        $this->addSql('ALTER TABLE calculation_flight DROP FOREIGN KEY FK_99FD85C9E4C9A25B');
        $this->addSql('DROP INDEX IDX_99FD85C96948DDE6 ON calculation_flight');
        $this->addSql('DROP INDEX IDX_99FD85C9E4C9A25B ON calculation_flight');
        $this->addSql('ALTER TABLE 
          calculation_flight 
        ADD 
          airstrip_id INT DEFAULT NULL, 
        DROP 
          arrival_airstrip_id, 
        DROP 
          departure_airstrip_id, 
          CHANGE calculation_id calculation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          calculation_flight 
        ADD 
          CONSTRAINT FK_99FD85C913755BFE FOREIGN KEY (airstrip_id) REFERENCES territorial_airstrip (id)');
        $this->addSql('CREATE INDEX IDX_99FD85C913755BFE ON calculation_flight (airstrip_id)');
    }
}
