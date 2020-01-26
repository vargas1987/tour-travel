<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180628211008 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('INSERT INTO territorial_airstrip (
            location_id,
            area_id,
            type,
            title,
            created_at
          ) (
            SELECT 
              ta.location_id,
              ta.id,
              \'airport\',
              \'Seronera Airstrip\',
              CURRENT_TIMESTAMP()
            FROM territorial_area ta
            WHERE ta.title = \'Namiri, Southeastern\'
          );
        ');

        $this->addSql('INSERT INTO territorial_airstrip (
            location_id,
            area_id,
            type,
            title
          ) (
            SELECT 
              ta.location_id,
              ta.id,
              \'airport\',
              \'Abeid Amani Karume International Airport (ZNZ)\'
            FROM territorial_area ta
            WHERE ta.title IN (
              \'Kendwa, Northwestern\',
              \'Matemwe, Northeastern\',
              \'Kiwengwa, East\',
              \'Stone Town, Central\',
              \'Kizimkazi, South\',
              \'Paje, Southeastern\',
              \'Bwejuu, Southeastern\'
            )
          );
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
