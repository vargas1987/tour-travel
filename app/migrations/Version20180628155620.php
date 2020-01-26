<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180628155620 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D3243BB18');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D54177093');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D8F3692CD');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D989D358F');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1DE03525CD');
        $this->addSql('DROP INDEX user_unique ON hotel_price');
        $this->addSql('CREATE UNIQUE INDEX hotel_price_unique ON hotel_price (
          hotel_id, meal_plan_type_id, room_id, 
          accommodation_id, season_type_id, 
          year
        )');
        $this->addSql('ALTER TABLE 
          hotel_price 
        ADD 
          CONSTRAINT FK_291CEC1D3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
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
          CONSTRAINT FK_291CEC1D989D358F FOREIGN KEY (meal_plan_type_id) REFERENCES type_meal_plan (id)');
        $this->addSql('ALTER TABLE 
          hotel_price 
        ADD 
          CONSTRAINT FK_291CEC1DE03525CD FOREIGN KEY (season_type_id) REFERENCES type_season (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D3243BB18');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D989D358F');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D54177093');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D8F3692CD');
        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1DE03525CD');
        $this->addSql('DROP INDEX hotel_price_unique ON hotel_price');
        $this->addSql('CREATE UNIQUE INDEX user_unique ON hotel_price (
          hotel_id, meal_plan_type_id, room_id, 
          accommodation_id, season_type_id, 
          year
        )');
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
    }
}
