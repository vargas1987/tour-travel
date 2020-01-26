<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190311174152 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE territorial_park (
          id INT AUTO_INCREMENT NOT NULL, 
          location_id INT DEFAULT NULL, 
          title VARCHAR(255) NOT NULL, 
          is_crater TINYINT(1) NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          INDEX IDX_8016FB1764D218E (location_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          territorial_park 
        ADD 
          CONSTRAINT FK_8016FB1764D218E FOREIGN KEY (location_id) REFERENCES territorial_location (id)');

        $this->addSql('
            INSERT INTO territorial_park (location_id, title, is_crater, created_at, updated_at)
                VALUES (1, \'Arusha\', 0, \'2019-03-11 00:00:00\', \'2019-03-11 00:00:00\');
        ');
        $this->addSql('
            INSERT INTO territorial_park (location_id, title, is_crater, created_at, updated_at)
                VALUES (29, \'Lake Manyara\', 0, \'2019-03-11 00:00:00\', \'2019-03-11 00:00:00\');
        ');
        $this->addSql('
            INSERT INTO territorial_park (location_id, title, is_crater, created_at, updated_at)
                VALUES (8, \'Lake Natron\', 0, \'2019-03-11 00:00:00\', \'2019-03-11 00:00:00\');
        ');
        $this->addSql('
            INSERT INTO territorial_park (location_id, title, is_crater, created_at, updated_at)
                VALUES (16, \'Ngorongoro Crater\', 1, \'2019-03-11 00:00:00\', \'2019-03-11 00:00:00\');
        ');
        $this->addSql('
            INSERT INTO territorial_park (location_id, title, is_crater, created_at, updated_at)
                VALUES (16, \'Ngorongoro Transit\', 0, \'2019-03-11 00:00:00\', \'2019-03-11 00:00:00\');
        ');
        $this->addSql('
            INSERT INTO territorial_park (location_id, title, is_crater, created_at, updated_at)
                VALUES (23, \'Serengeti\', 0, \'2019-03-11 00:00:00\', \'2019-03-11 00:00:00\');
        ');
        $this->addSql('
            INSERT INTO territorial_park (location_id, title, is_crater, created_at, updated_at)
                VALUES (26, \'Tarangire\', 0, \'2019-03-11 00:00:00\', \'2019-03-11 00:00:00\');
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE territorial_park');
    }
}
