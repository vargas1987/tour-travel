<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191208231214 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE hotel_make_story (
          id INT AUTO_INCREMENT NOT NULL, 
          language VARCHAR(255) NOT NULL, 
          tariff VARCHAR(255) NOT NULL, 
          program VARCHAR(255) NOT NULL, 
          locate_since_at DATETIME NOT NULL, 
          locate_end_at DATETIME NOT NULL,
          is_hide_locate_dates BOOLEAN DEFAULT NULL,
          created_at DATETIME NOT NULL,
          updated_at DATETIME DEFAULT NULL,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        $this->addSql('CREATE TABLE hotel_make_story_program (
          id INT AUTO_INCREMENT NOT NULL, 
          make_story_id INT NOT NULL, 
          itinerary VARCHAR(255) NOT NULL,
          overnight VARCHAR(255) NOT NULL,
          created_at DATETIME NOT NULL,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        $this->addSql('CREATE TABLE hotel_make_story_extra_options (
          id INT AUTO_INCREMENT NOT NULL, 
          make_story_id INT NOT NULL, 
          date DATETIME NOT NULL,
          time VARCHAR(255) NOT NULL,
          name VARCHAR(255) NOT NULL,
          created_at DATETIME NOT NULL,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        $this->addSql('
          ALTER TABLE hotel_make_story_program 
          ADD CONSTRAINT hotel_make_story_program_make_story_id_fk 
          FOREIGN KEY (make_story_id) 
          REFERENCES hotel_make_story (id)
          ');

        $this->addSql('
          ALTER TABLE hotel_make_story_extra_options
          ADD CONSTRAINT hotel_make_story_extra_options_make_story_id_fk 
          FOREIGN KEY (make_story_id) 
          REFERENCES hotel_make_story (id)
          ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE hotel_make_story_extra_options');
        $this->addSql('DROP TABLE hotel_make_story_program');
        $this->addSql('DROP TABLE hotel_make_story');
    }
}
