<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190313090855 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calculation_setting_other (
          id INT AUTO_INCREMENT NOT NULL, 
          title VARCHAR(255) NOT NULL, 
          is_per_safari_day TINYINT(1) NOT NULL, 
          is_per_person TINYINT(1) NOT NULL, 
          price INT NOT NULL, 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        $this->addSql('
            INSERT INTO calculation_setting_other (title, is_per_safari_day, is_per_person, price)
                VALUES (\'Wi-Fi in the Safari car\', 1, 1, 5);
        ');
        $this->addSql('
            INSERT INTO calculation_setting_other (title, is_per_safari_day, is_per_person, price)
                VALUES (\'Bottled water (2 liters)\', 1, 1, 5);
        ');
        $this->addSql('
            INSERT INTO calculation_setting_other (title, is_per_safari_day, is_per_person, price)
                VALUES (\'Snacks\', 1, 1, 5);
        ');
        $this->addSql('
            INSERT INTO calculation_setting_other (title, is_per_safari_day, is_per_person, price)
                VALUES (\'Lunch Boxes\', 0, 1, 10);
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE calculation_setting_other');
    }
}
