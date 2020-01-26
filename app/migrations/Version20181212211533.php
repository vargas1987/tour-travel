<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181212211533 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hotel_contact (
          id INT AUTO_INCREMENT NOT NULL, 
          hotel_id INT NOT NULL, 
          department_type VARCHAR(32) DEFAULT NULL, 
          phone VARCHAR(255) NOT NULL, 
          email VARCHAR(255) NOT NULL, 
          comment VARCHAR(255) NOT NULL, 
          created_at DATETIME NOT NULL, 
          updated_at DATETIME NOT NULL, 
          INDEX IDX_9F28F8113243BB18 (hotel_id), 
          INDEX IDX_9F28F8112EC4307C (department_type), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          hotel_contact 
        ADD 
          CONSTRAINT FK_9F28F8113243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE 
          hotel_contact 
        ADD 
          CONSTRAINT FK_9F28F8112EC4307C FOREIGN KEY (department_type) REFERENCES type_department (type)');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED92EC4307C');
        $this->addSql('DROP INDEX IDX_3535ED92EC4307C ON hotel');
        $this->addSql('ALTER TABLE hotel DROP department_type, DROP phone, DROP email, DROP comment');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE hotel_contact');
        $this->addSql('ALTER TABLE 
          hotel 
        ADD 
          department_type VARCHAR(32) DEFAULT NULL COLLATE utf8_unicode_ci, 
        ADD 
          phone VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, 
        ADD 
          email VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, 
        ADD 
          comment VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE 
          hotel 
        ADD 
          CONSTRAINT FK_3535ED92EC4307C FOREIGN KEY (department_type) REFERENCES type_department (type)');
        $this->addSql('CREATE INDEX IDX_3535ED92EC4307C ON hotel (department_type)');
    }
}
