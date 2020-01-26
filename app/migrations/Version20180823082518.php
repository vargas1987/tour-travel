<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180823082518 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_season DROP FOREIGN KEY FK_6C0E89CEE03525CD');
        $this->addSql('DROP INDEX IDX_6C0E89CEE03525CD ON hotel_season');
        $this->addSql('ALTER TABLE hotel_season CHANGE COLUMN season_type_id season_type VARCHAR(32) DEFAULT NULL');

        $this->addSql('
            UPDATE hotel_season AS hs
            SET season_type = (
                SELECT ts.type FROM type_season AS ts WHERE ts.id = hs.season_type
            );
        ');

        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1DE03525CD');
        $this->addSql('DROP INDEX IDX_291CEC1DE03525CD ON hotel_price');
        $this->addSql('ALTER TABLE hotel_price CHANGE COLUMN season_type_id season_type VARCHAR(32) DEFAULT NULL');

        $this->addSql('
            UPDATE hotel_price AS hp
            SET season_type = (
                SELECT ts.type FROM type_season AS ts WHERE ts.id = hp.season_type
            );
        ');

        $this->addSql('ALTER TABLE type_season MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE type_season DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE type_season DROP id, CHANGE type type VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D33330918CDE5729 ON type_season (type)');
        $this->addSql('ALTER TABLE type_season ADD PRIMARY KEY (type)');

        $this->addSql('ALTER TABLE hotel_season ADD CONSTRAINT FK_6C0E89CEA97CBB7 FOREIGN KEY (season_type) REFERENCES type_season (type)');
        $this->addSql('CREATE INDEX IDX_6C0E89CEA97CBB7 ON hotel_season (season_type)');

        $this->addSql('ALTER TABLE hotel_price ADD CONSTRAINT FK_291CEC1DA97CBB7 FOREIGN KEY (season_type) REFERENCES type_season (type)');
        $this->addSql('CREATE INDEX IDX_291CEC1DA97CBB7 ON hotel_price (season_type)');


        $this->addSql('ALTER TABLE type_room_accommodation DROP FOREIGN KEY FK_272EC245AEA6F6AD');
        $this->addSql('ALTER TABLE type_room_accommodation DROP FOREIGN KEY FK_272EC245B28C944D');
        $this->addSql('DROP INDEX IDX_272EC245B28C944D ON type_room_accommodation');
        $this->addSql('DROP INDEX IDX_272EC245AEA6F6AD ON type_room_accommodation');

        $this->addSql('ALTER TABLE type_room_accommodation CHANGE roomType_id room_type VARCHAR(32) NOT NULL');
        $this->addSql('ALTER TABLE type_room_accommodation CHANGE accommodationType_id accommodation_type VARCHAR(32) NOT NULL');

        $this->addSql('ALTER TABLE type_room_accommodation ADD CONSTRAINT FK_272EC245EFDABD4D FOREIGN KEY (room_type) REFERENCES type_room (type) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_room_accommodation ADD CONSTRAINT FK_272EC24585E695E2 FOREIGN KEY (accommodation_type) REFERENCES type_accommodation (type) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_272EC245EFDABD4D ON type_room_accommodation (room_type)');
        $this->addSql('CREATE INDEX IDX_272EC24585E695E2 ON type_room_accommodation (accommodation_type)');

        $this->addSql('ALTER TABLE type_room MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE type_room DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE type_room DROP id');
        $this->addSql('ALTER TABLE type_room ADD PRIMARY KEY (type)');

        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D8F3692CD');
        $this->addSql('DROP INDEX IDX_291CEC1D8F3692CD ON hotel_price');
        $this->addSql('DROP INDEX hotel_price_unique ON hotel_price');

        $this->addSql('ALTER TABLE hotel_price CHANGE accommodation_id accommodation_type VARCHAR(32) DEFAULT NULL');

        $this->addSql('
            UPDATE hotel_price AS hp
            SET accommodation_type = (
                SELECT ta.type FROM type_accommodation AS ta WHERE ta.id = hp.accommodation_type
            );
        ');

        $this->addSql('ALTER TABLE hotel_price ADD CONSTRAINT FK_291CEC1D85E695E2 FOREIGN KEY (accommodation_type) REFERENCES type_accommodation (type)');
        $this->addSql('CREATE INDEX IDX_291CEC1D85E695E2 ON hotel_price (accommodation_type)');
        $this->addSql('CREATE UNIQUE INDEX hotel_price_unique ON hotel_price (hotel_id, meal_plan_type_id, room_id, accommodation_type, season_type, year)');

        $this->addSql('ALTER TABLE hotel_room_accommodation DROP FOREIGN KEY FK_43101C9B8F3692CD');
        $this->addSql('DROP INDEX IDX_43101C9B8F3692CD ON hotel_room_accommodation');
        $this->addSql('ALTER TABLE hotel_room_accommodation DROP PRIMARY KEY');

        $this->addSql('ALTER TABLE hotel_room_accommodation CHANGE accommodation_id accommodation_type VARCHAR(32) NOT NULL');

        $this->addSql('
            UPDATE hotel_room_accommodation AS hra
            SET accommodation_type = (
                SELECT ta.type FROM type_accommodation AS ta WHERE ta.id = hra.accommodation_type
            );
        ');

        $this->addSql('ALTER TABLE hotel_room_accommodation ADD CONSTRAINT FK_43101C9B85E695E2 FOREIGN KEY (accommodation_type) REFERENCES type_accommodation (type)');
        $this->addSql('CREATE INDEX IDX_43101C9B85E695E2 ON hotel_room_accommodation (accommodation_type)');
        $this->addSql('ALTER TABLE hotel_room_accommodation ADD PRIMARY KEY (room_id, accommodation_type)');

        $this->addSql('ALTER TABLE type_accommodation MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE type_accommodation DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE type_accommodation DROP id');
        $this->addSql('ALTER TABLE type_accommodation ADD PRIMARY KEY (type)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        return;

        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D85E695E2');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1DA97CBB7');
        $this->addSql('DROP INDEX IDX_291CEC1D85E695E2 ON hotel_price');
        $this->addSql('DROP INDEX IDX_291CEC1DA97CBB7 ON hotel_price');
        $this->addSql('DROP INDEX hotel_price_unique ON hotel_price');
        $this->addSql('ALTER TABLE hotel_price ADD accommodation_id INT DEFAULT NULL, ADD season_type_id INT DEFAULT NULL, DROP accommodation_type, DROP season_type');
        $this->addSql('ALTER TABLE hotel_price ADD CONSTRAINT FK_291CEC1D8F3692CD FOREIGN KEY (accommodation_id) REFERENCES type_accommodation (id)');
        $this->addSql('ALTER TABLE hotel_price ADD CONSTRAINT FK_291CEC1DE03525CD FOREIGN KEY (season_type_id) REFERENCES type_season (id)');
        $this->addSql('CREATE INDEX IDX_291CEC1D8F3692CD ON hotel_price (accommodation_id)');
        $this->addSql('CREATE INDEX IDX_291CEC1DE03525CD ON hotel_price (season_type_id)');
        $this->addSql('CREATE UNIQUE INDEX hotel_price_unique ON hotel_price (hotel_id, meal_plan_type_id, room_id, accommodation_id, season_type_id, year)');
        $this->addSql('ALTER TABLE hotel_room_accommodation DROP FOREIGN KEY FK_43101C9B85E695E2');
        $this->addSql('DROP INDEX IDX_43101C9B85E695E2 ON hotel_room_accommodation');
        $this->addSql('ALTER TABLE hotel_room_accommodation DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE hotel_room_accommodation ADD accommodation_id INT NOT NULL, DROP accommodation_type');
        $this->addSql('ALTER TABLE hotel_room_accommodation ADD CONSTRAINT FK_43101C9B8F3692CD FOREIGN KEY (accommodation_id) REFERENCES type_accommodation (id)');
        $this->addSql('CREATE INDEX IDX_43101C9B8F3692CD ON hotel_room_accommodation (accommodation_id)');
        $this->addSql('ALTER TABLE hotel_room_accommodation ADD PRIMARY KEY (room_id, accommodation_id)');
        $this->addSql('ALTER TABLE hotel_season DROP FOREIGN KEY FK_6C0E89CEA97CBB7');
        $this->addSql('DROP INDEX IDX_6C0E89CEA97CBB7 ON hotel_season');
        $this->addSql('ALTER TABLE hotel_season ADD season_type_id INT DEFAULT NULL, DROP season_type');
        $this->addSql('ALTER TABLE hotel_season ADD CONSTRAINT FK_6C0E89CEE03525CD FOREIGN KEY (season_type_id) REFERENCES type_season (id)');
        $this->addSql('CREATE INDEX IDX_6C0E89CEE03525CD ON hotel_season (season_type_id)');
        $this->addSql('ALTER TABLE type_accommodation DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE type_accommodation ADD id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE type_accommodation ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE type_room DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE type_room ADD id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE type_room ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE type_room_accommodation DROP FOREIGN KEY FK_272EC245EFDABD4D');
        $this->addSql('ALTER TABLE type_room_accommodation DROP FOREIGN KEY FK_272EC24585E695E2');
        $this->addSql('DROP INDEX IDX_272EC245EFDABD4D ON type_room_accommodation');
        $this->addSql('DROP INDEX IDX_272EC24585E695E2 ON type_room_accommodation');
        $this->addSql('ALTER TABLE type_room_accommodation ADD roomType_id INT NOT NULL, ADD accommodationType_id INT NOT NULL, DROP room_type, DROP accommodation_type');
        $this->addSql('ALTER TABLE type_room_accommodation ADD CONSTRAINT FK_272EC245AEA6F6AD FOREIGN KEY (accommodationType_id) REFERENCES type_accommodation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_room_accommodation ADD CONSTRAINT FK_272EC245B28C944D FOREIGN KEY (roomType_id) REFERENCES type_room (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_272EC245B28C944D ON type_room_accommodation (roomType_id)');
        $this->addSql('CREATE INDEX IDX_272EC245AEA6F6AD ON type_room_accommodation (accommodationType_id)');
        $this->addSql('DROP INDEX UNIQ_D33330918CDE5729 ON type_season');
        $this->addSql('ALTER TABLE type_season DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE type_season ADD id INT AUTO_INCREMENT NOT NULL, CHANGE type type VARCHAR(32) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE type_season ADD PRIMARY KEY (id)');
    }
}
