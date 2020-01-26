<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180904223433 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hotel_price_additional_fee (
          id INT AUTO_INCREMENT NOT NULL, 
          hotel_id INT NOT NULL, 
          additional_fees_type VARCHAR(32) DEFAULT NULL, 
          price INT DEFAULT 0 NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          INDEX IDX_5CA994AA3243BB18 (hotel_id), 
          INDEX IDX_5CA994AA7D902800 (additional_fees_type), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_additional_fee (
          type VARCHAR(32) NOT NULL, 
          behavior VARCHAR(32) NOT NULL, 
          title VARCHAR(32) NOT NULL, 
          description VARCHAR(255) DEFAULT NULL, 
          sort INT DEFAULT 1 NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          UNIQUE INDEX UNIQ_E001025C8CDE5729 (type), 
          PRIMARY KEY(type)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          hotel_price_additional_fee 
        ADD 
          CONSTRAINT FK_5CA994AA3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE 
          hotel_price_additional_fee 
        ADD 
          CONSTRAINT FK_5CA994AA7D902800 FOREIGN KEY (additional_fees_type) REFERENCES type_additional_fee (type)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_price_additional_fee DROP FOREIGN KEY FK_5CA994AA7D902800');
        $this->addSql('DROP TABLE hotel_price_additional_fee');
        $this->addSql('DROP TABLE type_additional_fee');
    }
}
