<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180703101442 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('DELETE FROM hotel_room_accommodation WHERE accommodation_id = 15 OR accommodation_id = 16;');
        $this->addSql('DELETE FROM hotel_price WHERE accommodation_id = 15 OR accommodation_id = 16;');
        $this->addSql('DELETE FROM hotel_accommodation_type WHERE type = \'1A2C\' OR type = \'3C\';');

        $this->addSql('INSERT INTO hotel_accommodation_type (type, count_adult, count_teenager, count_child) 
          VALUES
              (\'1A2T1C\', 1, 2, 1),
              (\'1A1T2C\', 1, 1, 2),
              (\'2A2T\', 2, 2, 0),
              (\'2A2C\', 2, 0, 2),
              (\'2A3T\', 2, 3, 0),
              (\'2A3C\', 2, 0, 3),
              (\'2A1T1C\', 2, 1, 1),
              (\'2A2T1C\', 2, 2, 1),
              (\'2A1T2C\', 2, 1, 2),
              (\'2A2T2C\', 2, 2, 2),
              (\'3A1T\', 3, 1, 0),
              (\'3A1C\', 3, 0, 1),
              (\'3A2T\', 3, 2, 0),
              (\'3A2C\', 3, 0, 2),
              (\'3A1T1C\', 3, 1, 1),
              (\'3A1T2C\', 3, 1, 2),
              (\'3A2T1C\', 3, 2, 1),
              (\'4A1T\', 4, 1, 0),
              (\'4A2T\', 4, 2, 0),
              (\'4A1C\', 4, 0, 1),
              (\'4A2C\', 4, 0, 2),
              (\'4A1T1C\', 4, 1, 1)
          ;
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
