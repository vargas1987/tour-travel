<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190117205015 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calculation_night_room (
          id INT AUTO_INCREMENT NOT NULL, 
          calculation_night_id INT NOT NULL, 
          room_id INT NOT NULL, 
          count INT NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          INDEX IDX_CE6226F92F836690 (calculation_night_id), 
          INDEX IDX_CE6226F954177093 (room_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calculation_night_room_accommodation (
          night_room_id INT NOT NULL, 
          accommodation_type VARCHAR(32) NOT NULL, 
          INDEX IDX_610FD6121D77DD94 (night_room_id), 
          INDEX IDX_610FD61285E695E2 (accommodation_type), 
          PRIMARY KEY(
            night_room_id, accommodation_type
          )
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          calculation_night_room 
        ADD 
          CONSTRAINT FK_CE6226F92F836690 FOREIGN KEY (calculation_night_id) REFERENCES calculation_night (id)');
        $this->addSql('ALTER TABLE 
          calculation_night_room 
        ADD 
          CONSTRAINT FK_CE6226F954177093 FOREIGN KEY (room_id) REFERENCES hotel_room (id)');
        $this->addSql('ALTER TABLE 
          calculation_night_room_accommodation 
        ADD 
          CONSTRAINT FK_610FD6121D77DD94 FOREIGN KEY (night_room_id) REFERENCES calculation_night_room (id)');
        $this->addSql('ALTER TABLE 
          calculation_night_room_accommodation 
        ADD 
          CONSTRAINT FK_610FD61285E695E2 FOREIGN KEY (accommodation_type) REFERENCES type_accommodation (type)');
        $this->addSql('ALTER TABLE calculation_night DROP FOREIGN KEY FK_6517D52854177093');
        $this->addSql('DROP INDEX IDX_6517D52854177093 ON calculation_night');
        $this->addSql('ALTER TABLE calculation_night DROP room_id, DROP count_rooms');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calculation_night_room_accommodation DROP FOREIGN KEY FK_610FD6121D77DD94');
        $this->addSql('DROP TABLE calculation_night_room');
        $this->addSql('DROP TABLE calculation_night_room_accommodation');
        $this->addSql('ALTER TABLE calculation_night ADD room_id INT NOT NULL, ADD count_rooms INT NOT NULL');
        $this->addSql('ALTER TABLE 
          calculation_night 
        ADD 
          CONSTRAINT FK_6517D52854177093 FOREIGN KEY (room_id) REFERENCES hotel_room (id)');
        $this->addSql('CREATE INDEX IDX_6517D52854177093 ON calculation_night (room_id)');
    }
}
