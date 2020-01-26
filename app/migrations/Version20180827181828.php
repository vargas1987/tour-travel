<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180827181828 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE type_meal_plan ADD sort INT NOT NULL');
        $this->addSql('
            SET @i := 0;
            UPDATE type_meal_plan SET sort = @i:=@i+1 ORDER BY type;
        ');
        $this->addSql('ALTER TABLE hotel_price CHANGE room_id room_id INT NOT NULL, CHANGE accommodation_type accommodation_type VARCHAR(32) NOT NULL, CHANGE season_type season_type VARCHAR(32) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_price CHANGE room_id room_id INT DEFAULT NULL, CHANGE accommodation_type accommodation_type VARCHAR(32) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE season_type season_type VARCHAR(32) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE type_meal_plan DROP sort');
    }
}
