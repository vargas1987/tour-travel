<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180911210036 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_price_additional_fee ADD year INT NOT NULL');

        $this->addSql('
        
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (1, \'single\', \'1A\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (2, \'single\', \'1A1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (3, \'single\', \'1A1T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (4, \'single\', \'1T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (5, \'single\', \'1T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (1, \'double\', \'2A\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (1, \'twin\', \'2A\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (2, \'double\', \'2A1T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (2, \'twin\', \'2A1T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (3, \'double\', \'1A2T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (3, \'twin\', \'1A2T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (4, \'double\', \'2A1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (4, \'twin\', \'2A1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (5, \'double\', \'1A1T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (5, \'twin\', \'1A1T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (6, \'double\', \'2T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (6, \'twin\', \'2T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (7, \'double\', \'1T2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (7, \'twin\', \'1T2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (8, \'double\', \'2A\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (8, \'twin\', \'2A\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (9, \'double\', \'2A1T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (9, \'twin\', \'2A1T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (10, \'double\', \'1A2T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (10, \'twin\', \'1A2T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (11, \'double\', \'2A1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (11, \'twin\', \'2A1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (12, \'double\', \'1A1T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (12, \'twin\', \'1A1T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (13, \'double\', \'2T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (13, \'twin\', \'2T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (14, \'double\', \'1T2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (14, \'twin\', \'1T2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (1, \'triple\', \'3A\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (2, \'triple\', \'3T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (1, \'family_suite\', \'1A2T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (2, \'family_suite\', \'1A1T2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (3, \'family_suite\', \'2A2T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (4, \'family_suite\', \'2A2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (5, \'family_suite\', \'2A3T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (6, \'family_suite\', \'2A3C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (7, \'family_suite\', \'2A1T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (8, \'family_suite\', \'2A2T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (9, \'family_suite\', \'2A1T2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (10, \'family_suite\', \'2A2T2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (11, \'family_suite\', \'3A1T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (12, \'family_suite\', \'3A1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (13, \'family_suite\', \'3A2T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (14, \'family_suite\', \'3A2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (15, \'family_suite\', \'3A1T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (16, \'family_suite\', \'3A1T2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (17, \'family_suite\', \'3A2T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (18, \'family_suite\', \'4A1T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (19, \'family_suite\', \'4A2T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (20, \'family_suite\', \'4A1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (21, \'family_suite\', \'4A2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (22, \'family_suite\', \'4A1T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (1, \'specific\', \'2A\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (2, \'specific\', \'2A1T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (3, \'specific\', \'1A2T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (4, \'specific\', \'2A1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (5, \'specific\', \'1A1T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (6, \'specific\', \'2T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (7, \'specific\', \'1T2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (8, \'specific\', \'1A2T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (9, \'specific\', \'1A1T2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (10, \'specific\', \'2A2T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (11, \'specific\', \'2A2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (12, \'specific\', \'2A3T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (13, \'specific\', \'2A3C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (14, \'specific\', \'2A1T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (15, \'specific\', \'2A2T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (16, \'specific\', \'2A1T2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (17, \'specific\', \'2A2T2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (18, \'specific\', \'3A1T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (19, \'specific\', \'3A1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (20, \'specific\', \'3A2T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (21, \'specific\', \'3A2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (22, \'specific\', \'3A1T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (23, \'specific\', \'3A1T2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (24, \'specific\', \'3A2T1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (25, \'specific\', \'4A1T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (26, \'specific\', \'4A2T\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (27, \'specific\', \'4A1C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (28, \'specific\', \'4A2C\');
            INSERT INTO type_room_accommodation (sort, room_type, accommodation_type)
                VALUES (29, \'specific\', \'4A1T1C\');
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_price_additional_fee DROP year');
    }
}
