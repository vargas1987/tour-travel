<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180619200519 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX user_unique ON hotel_price');
        $this->addSql('ALTER TABLE hotel_price ADD year INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX user_unique ON hotel_price (
          hotel_id, meal_plan_type_id, room_id, 
          accommodation_id, season_type_id, 
          year
        )');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX user_unique ON hotel_price');
        $this->addSql('ALTER TABLE hotel_price DROP year');
        $this->addSql('CREATE UNIQUE INDEX user_unique ON hotel_price (
          hotel_id, meal_plan_type_id, room_id, 
          accommodation_id, season_type_id
        )');
    }
}
