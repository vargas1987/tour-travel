<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190121232158 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE calculation_night_room_accommodation');
        $this->addSql('ALTER TABLE calculation_night_room ADD accommodation_type VARCHAR(32) NOT NULL');
        $this->addSql('ALTER TABLE 
          calculation_night_room 
        ADD 
          CONSTRAINT FK_CE6226F985E695E2 FOREIGN KEY (accommodation_type) REFERENCES type_accommodation (type)');
        $this->addSql('CREATE INDEX IDX_CE6226F985E695E2 ON calculation_night_room (accommodation_type)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calculation_night_room_accommodation (
          night_room_id INT NOT NULL, 
          accommodation_type VARCHAR(32) NOT NULL COLLATE utf8_unicode_ci, 
          INDEX IDX_610FD6121D77DD94 (night_room_id), 
          INDEX IDX_610FD61285E695E2 (accommodation_type), 
          PRIMARY KEY(
            night_room_id, accommodation_type
          )
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          calculation_night_room_accommodation 
        ADD 
          CONSTRAINT FK_610FD61285E695E2 FOREIGN KEY (accommodation_type) REFERENCES type_accommodation (type)');
        $this->addSql('ALTER TABLE 
          calculation_night_room_accommodation 
        ADD 
          CONSTRAINT FK_610FD6121D77DD94 FOREIGN KEY (night_room_id) REFERENCES calculation_night_room (id)');
        $this->addSql('ALTER TABLE calculation_night_room DROP FOREIGN KEY FK_CE6226F985E695E2');
        $this->addSql('DROP INDEX IDX_CE6226F985E695E2 ON calculation_night_room');
        $this->addSql('ALTER TABLE calculation_night_room DROP accommodation_type');
    }
}
