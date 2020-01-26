<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180614205504 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hotel (
          id INT AUTO_INCREMENT NOT NULL, 
          chain_id INT DEFAULT NULL, 
          location_id INT DEFAULT NULL, 
          area_id INT DEFAULT NULL, 
          airstrip_id INT DEFAULT NULL, 
          title VARCHAR(255) NOT NULL, 
          type VARCHAR(255) NOT NULL, 
          time_to_airstrip INT DEFAULT NULL, 
          is_mobile_camp TINYINT(1) NOT NULL, 
          adult_from INT NOT NULL, 
          teenager_from INT NOT NULL, 
          teenager_to INT NOT NULL, 
          child_from INT NOT NULL, 
          child_to INT NOT NULL, 
          note LONGTEXT DEFAULT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          INDEX IDX_3535ED9966C2F62 (chain_id), 
          INDEX IDX_3535ED964D218E (location_id), 
          INDEX IDX_3535ED9BD0F409C (area_id), 
          INDEX IDX_3535ED913755BFE (airstrip_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_type_of_meal (
          hotel_id INT NOT NULL, 
          meal_plan_id INT NOT NULL, 
          INDEX IDX_B8E09A493243BB18 (hotel_id), 
          INDEX IDX_B8E09A49912AB082 (meal_plan_id), 
          PRIMARY KEY(hotel_id, meal_plan_id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_season (
          id INT AUTO_INCREMENT NOT NULL, 
          type VARCHAR(32) NOT NULL, 
          title VARCHAR(32) NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_accommodation_type (
          id INT AUTO_INCREMENT NOT NULL, 
          type VARCHAR(255) NOT NULL, 
          count_adult INT NOT NULL, 
          count_teenager INT NOT NULL, 
          count_child INT NOT NULL, 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_chain (
          id INT AUTO_INCREMENT NOT NULL, 
          title VARCHAR(255) NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE territorial_location (
          id INT AUTO_INCREMENT NOT NULL, 
          title VARCHAR(255) NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE territorial_airstrip (
          id INT AUTO_INCREMENT NOT NULL, 
          location_id INT DEFAULT NULL, 
          area_id INT DEFAULT NULL, 
          type VARCHAR(255) NOT NULL, 
          title VARCHAR(255) NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          INDEX IDX_2047934A64D218E (location_id), 
          INDEX IDX_2047934ABD0F409C (area_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_meal_plan (
          id INT AUTO_INCREMENT NOT NULL, 
          type VARCHAR(255) NOT NULL, 
          title VARCHAR(255) NOT NULL, 
          description VARCHAR(255) DEFAULT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE territorial_area (
          id INT AUTO_INCREMENT NOT NULL, 
          location_id INT DEFAULT NULL, 
          title VARCHAR(255) NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          INDEX IDX_9385BB4C64D218E (location_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_season (
          id INT AUTO_INCREMENT NOT NULL, 
          hotel_id INT NOT NULL, 
          season_type_id INT DEFAULT NULL, 
          date_from DATE NOT NULL, 
          date_to DATE NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          INDEX IDX_6C0E89CE3243BB18 (hotel_id), 
          INDEX IDX_6C0E89CEE03525CD (season_type_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_mobile_camp (
          id INT AUTO_INCREMENT NOT NULL, 
          hotel_id INT DEFAULT NULL, 
          location_id INT DEFAULT NULL, 
          area_id INT DEFAULT NULL, 
          airstrip_id INT DEFAULT NULL, 
          time_to_airstrip INT DEFAULT NULL, 
          date_from DATE NOT NULL, 
          date_to DATE NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          INDEX IDX_FD6810FD3243BB18 (hotel_id), 
          INDEX IDX_FD6810FD64D218E (location_id), 
          INDEX IDX_FD6810FDBD0F409C (area_id), 
          INDEX IDX_FD6810FD13755BFE (airstrip_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_price (
          id INT AUTO_INCREMENT NOT NULL, 
          hotel_id INT DEFAULT NULL, 
          meal_plan_type_id INT DEFAULT NULL, 
          room_id INT DEFAULT NULL, 
          accommodation_id INT DEFAULT NULL, 
          season_type_id INT DEFAULT NULL, 
          price NUMERIC(4, 4) DEFAULT \'0\' NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          INDEX IDX_291CEC1D3243BB18 (hotel_id), 
          INDEX IDX_291CEC1D989D358F (meal_plan_type_id), 
          INDEX IDX_291CEC1D54177093 (room_id), 
          INDEX IDX_291CEC1D8F3692CD (accommodation_id), 
          INDEX IDX_291CEC1DE03525CD (season_type_id), 
          UNIQUE INDEX user_unique (
            hotel_id, meal_plan_type_id, room_id, 
            accommodation_id, season_type_id
          ), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_room (
          id INT AUTO_INCREMENT NOT NULL, 
          hotel_id INT DEFAULT NULL, 
          title VARCHAR(255) NOT NULL, 
          max_pas INT DEFAULT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          type VARCHAR(32) NOT NULL, 
          INDEX IDX_C55A87133243BB18 (hotel_id), 
          INDEX IDX_C55A87138CDE5729 (type), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_room_accommodation (
          room_id INT NOT NULL, 
          accommodation_id INT NOT NULL, 
          INDEX IDX_43101C9B54177093 (room_id), 
          INDEX IDX_43101C9B8F3692CD (accommodation_id), 
          PRIMARY KEY(room_id, accommodation_id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (
          id INT AUTO_INCREMENT NOT NULL, 
          username VARCHAR(25) NOT NULL, 
          email VARCHAR(254) NOT NULL, 
          password VARCHAR(64) NOT NULL, 
          salt LONGTEXT NOT NULL, 
          roles LONGTEXT NOT NULL, 
          is_active TINYINT(1) NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), 
          UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          hotel 
        ADD 
          CONSTRAINT FK_3535ED9966C2F62 FOREIGN KEY (chain_id) REFERENCES hotel_chain (id)');
        $this->addSql('ALTER TABLE 
          hotel 
        ADD 
          CONSTRAINT FK_3535ED964D218E FOREIGN KEY (location_id) REFERENCES territorial_location (id)');
        $this->addSql('ALTER TABLE 
          hotel 
        ADD 
          CONSTRAINT FK_3535ED9BD0F409C FOREIGN KEY (area_id) REFERENCES territorial_area (id)');
        $this->addSql('ALTER TABLE 
          hotel 
        ADD 
          CONSTRAINT FK_3535ED913755BFE FOREIGN KEY (airstrip_id) REFERENCES territorial_airstrip (id)');
        $this->addSql('ALTER TABLE 
          hotel_type_of_meal 
        ADD 
          CONSTRAINT FK_B8E09A493243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE 
          hotel_type_of_meal 
        ADD 
          CONSTRAINT FK_B8E09A49912AB082 FOREIGN KEY (meal_plan_id) REFERENCES type_meal_plan (id)');
        $this->addSql('ALTER TABLE 
          territorial_airstrip 
        ADD 
          CONSTRAINT FK_2047934A64D218E FOREIGN KEY (location_id) REFERENCES territorial_location (id)');
        $this->addSql('ALTER TABLE 
          territorial_airstrip 
        ADD 
          CONSTRAINT FK_2047934ABD0F409C FOREIGN KEY (area_id) REFERENCES territorial_area (id)');
        $this->addSql('ALTER TABLE 
          territorial_area 
        ADD 
          CONSTRAINT FK_9385BB4C64D218E FOREIGN KEY (location_id) REFERENCES territorial_location (id)');
        $this->addSql('ALTER TABLE 
          hotel_season 
        ADD 
          CONSTRAINT FK_6C0E89CE3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE 
          hotel_season 
        ADD 
          CONSTRAINT FK_6C0E89CEE03525CD FOREIGN KEY (season_type_id) REFERENCES type_season (id)');
        $this->addSql('ALTER TABLE 
          hotel_mobile_camp 
        ADD 
          CONSTRAINT FK_FD6810FD3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE 
          hotel_mobile_camp 
        ADD 
          CONSTRAINT FK_FD6810FD64D218E FOREIGN KEY (location_id) REFERENCES territorial_location (id)');
        $this->addSql('ALTER TABLE 
          hotel_mobile_camp 
        ADD 
          CONSTRAINT FK_FD6810FDBD0F409C FOREIGN KEY (area_id) REFERENCES territorial_area (id)');
        $this->addSql('ALTER TABLE 
          hotel_mobile_camp 
        ADD 
          CONSTRAINT FK_FD6810FD13755BFE FOREIGN KEY (airstrip_id) REFERENCES territorial_airstrip (id)');
        $this->addSql('ALTER TABLE 
          hotel_price 
        ADD 
          CONSTRAINT FK_291CEC1D3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE 
          hotel_price 
        ADD 
          CONSTRAINT FK_291CEC1D989D358F FOREIGN KEY (meal_plan_type_id) REFERENCES type_meal_plan (id)');
        $this->addSql('ALTER TABLE 
          hotel_price 
        ADD 
          CONSTRAINT FK_291CEC1D54177093 FOREIGN KEY (room_id) REFERENCES hotel_room (id)');
        $this->addSql('ALTER TABLE 
          hotel_price 
        ADD 
          CONSTRAINT FK_291CEC1D8F3692CD FOREIGN KEY (accommodation_id) REFERENCES hotel_accommodation_type (id)');
        $this->addSql('ALTER TABLE 
          hotel_price 
        ADD 
          CONSTRAINT FK_291CEC1DE03525CD FOREIGN KEY (season_type_id) REFERENCES type_season (id)');
        $this->addSql('ALTER TABLE 
          hotel_room 
        ADD 
          CONSTRAINT FK_C55A87133243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE 
          hotel_room_accommodation 
        ADD 
          CONSTRAINT FK_43101C9B54177093 FOREIGN KEY (room_id) REFERENCES hotel_room (id)');
        $this->addSql('ALTER TABLE 
          hotel_room_accommodation 
        ADD 
          CONSTRAINT FK_43101C9B8F3692CD FOREIGN KEY (accommodation_id) REFERENCES hotel_accommodation_type (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_type_of_meal DROP FOREIGN KEY FK_B8E09A493243BB18');
        $this->addSql('ALTER TABLE hotel_season DROP FOREIGN KEY FK_6C0E89CE3243BB18');
        $this->addSql('ALTER TABLE hotel_mobile_camp DROP FOREIGN KEY FK_FD6810FD3243BB18');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D3243BB18');
        $this->addSql('ALTER TABLE hotel_room DROP FOREIGN KEY FK_C55A87133243BB18');
        $this->addSql('ALTER TABLE hotel_season DROP FOREIGN KEY FK_6C0E89CEE03525CD');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1DE03525CD');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D8F3692CD');
        $this->addSql('ALTER TABLE hotel_room_accommodation DROP FOREIGN KEY FK_43101C9B8F3692CD');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9966C2F62');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED964D218E');
        $this->addSql('ALTER TABLE territorial_airstrip DROP FOREIGN KEY FK_2047934A64D218E');
        $this->addSql('ALTER TABLE territorial_area DROP FOREIGN KEY FK_9385BB4C64D218E');
        $this->addSql('ALTER TABLE hotel_mobile_camp DROP FOREIGN KEY FK_FD6810FD64D218E');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED913755BFE');
        $this->addSql('ALTER TABLE hotel_mobile_camp DROP FOREIGN KEY FK_FD6810FD13755BFE');
        $this->addSql('ALTER TABLE hotel_type_of_meal DROP FOREIGN KEY FK_B8E09A49912AB082');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D989D358F');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9BD0F409C');
        $this->addSql('ALTER TABLE territorial_airstrip DROP FOREIGN KEY FK_2047934ABD0F409C');
        $this->addSql('ALTER TABLE hotel_mobile_camp DROP FOREIGN KEY FK_FD6810FDBD0F409C');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D54177093');
        $this->addSql('ALTER TABLE hotel_room_accommodation DROP FOREIGN KEY FK_43101C9B54177093');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE hotel_type_of_meal');
        $this->addSql('DROP TABLE type_season');
        $this->addSql('DROP TABLE hotel_accommodation_type');
        $this->addSql('DROP TABLE hotel_chain');
        $this->addSql('DROP TABLE territorial_location');
        $this->addSql('DROP TABLE territorial_airstrip');
        $this->addSql('DROP TABLE type_meal_plan');
        $this->addSql('DROP TABLE territorial_area');
        $this->addSql('DROP TABLE hotel_season');
        $this->addSql('DROP TABLE hotel_mobile_camp');
        $this->addSql('DROP TABLE hotel_price');
        $this->addSql('DROP TABLE hotel_room');
        $this->addSql('DROP TABLE hotel_room_accommodation');
        $this->addSql('DROP TABLE user');
    }
}
