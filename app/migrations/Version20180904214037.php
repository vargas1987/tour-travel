<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180904214037 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE type_supplement (
          type VARCHAR(32) NOT NULL, 
          title VARCHAR(32) NOT NULL, 
          description VARCHAR(255) DEFAULT NULL, 
          sort INT DEFAULT 1 NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          UNIQUE INDEX UNIQ_1C59A5EC8CDE5729 (type), 
          PRIMARY KEY(type)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_price_supplement (
          id INT AUTO_INCREMENT NOT NULL, 
          hotel_id INT NOT NULL, 
          supplement_type VARCHAR(32) DEFAULT NULL, 
          date_from DATE NOT NULL, 
          date_to DATE NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          INDEX IDX_86602F9A3243BB18 (hotel_id), 
          INDEX IDX_86602F9A344438CD (supplement_type), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          hotel_price_supplement 
        ADD 
          CONSTRAINT FK_86602F9A3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE 
          hotel_price_supplement 
        ADD 
          CONSTRAINT FK_86602F9A344438CD FOREIGN KEY (supplement_type) REFERENCES type_supplement (type)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_price_supplement DROP FOREIGN KEY FK_86602F9A344438CD');
        $this->addSql('DROP TABLE type_supplement');
        $this->addSql('DROP TABLE hotel_price_supplement');
    }
}
