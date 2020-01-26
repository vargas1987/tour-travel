<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181210201333 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calculation (
          id INT AUTO_INCREMENT NOT NULL, 
          title VARCHAR(255) NOT NULL, 
          date_from DATE NOT NULL, 
          date_to DATE NOT NULL, 
          ea_residents TINYINT(1) NOT NULL, 
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
          updated_at DATETIME DEFAULT NULL, 
          UNIQUE INDEX UNIQ_F6A769702B36786B (title), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_department (
          type VARCHAR(32) NOT NULL, 
          title VARCHAR(255) NOT NULL, 
          description VARCHAR(255) DEFAULT NULL, 
          sort INT NOT NULL, 
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
          updated_at DATETIME DEFAULT NULL, 
          UNIQUE INDEX UNIQ_D01E37AF8CDE5729 (type), 
          PRIMARY KEY(type)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calculation_people (
          id INT AUTO_INCREMENT NOT NULL, 
          calculation_id INT DEFAULT NULL, 
          type VARCHAR(255) NOT NULL, 
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
          updated_at DATETIME DEFAULT NULL, 
          INDEX IDX_73BC09E1CE3D4B33 (calculation_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_hotel (
          type VARCHAR(32) NOT NULL, 
          title VARCHAR(255) NOT NULL, 
          description VARCHAR(255) DEFAULT NULL, 
          sort INT NOT NULL, 
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
          updated_at DATETIME DEFAULT NULL, 
          UNIQUE INDEX UNIQ_D5FD92E8CDE5729 (type), 
          PRIMARY KEY(type)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          calculation_people 
        ADD 
          CONSTRAINT FK_73BC09E1CE3D4B33 FOREIGN KEY (calculation_id) REFERENCES calculation (id)');
        $this->addSql('ALTER TABLE 
          hotel 
        ADD 
          type_hotel VARCHAR(32) DEFAULT NULL, 
        ADD 
          department_type VARCHAR(32) DEFAULT NULL, 
        ADD 
          ratio INT DEFAULT 0 NOT NULL, 
        ADD 
          phone VARCHAR(255) DEFAULT NULL, 
        ADD 
          email VARCHAR(255) DEFAULT NULL, 
        ADD 
          comment VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          hotel 
        ADD 
          CONSTRAINT FK_3535ED9D5FD92E FOREIGN KEY (type_hotel) REFERENCES type_hotel (type)');
        $this->addSql('ALTER TABLE 
          hotel 
        ADD 
          CONSTRAINT FK_3535ED92EC4307C FOREIGN KEY (department_type) REFERENCES type_department (type)');
        $this->addSql('CREATE INDEX IDX_3535ED9D5FD92E ON hotel (type_hotel)');
        $this->addSql('CREATE INDEX IDX_3535ED92EC4307C ON hotel (department_type)');

        $this->addSql('INSERT INTO type_hotel (type, title, sort) 
          VALUES
          (\'classic\', \'Classic\', 1),
          (\'luxury\', \'Luxury\', 2),
          (\'vip\', \'VIP\', 3)
        ');

        $this->addSql('INSERT INTO type_department (type, title, sort) 
          VALUES
          (\'sales\', \'Sales\', 1),
          (\'reservation\', \'Reservation\', 2),
          (\'general_manager\', \'General Manager\', 3)
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calculation_people DROP FOREIGN KEY FK_73BC09E1CE3D4B33');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED92EC4307C');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9D5FD92E');
        $this->addSql('DROP TABLE calculation');
        $this->addSql('DROP TABLE type_department');
        $this->addSql('DROP TABLE calculation_people');
        $this->addSql('DROP TABLE type_hotel');
        $this->addSql('DROP INDEX IDX_3535ED9D5FD92E ON hotel');
        $this->addSql('DROP INDEX IDX_3535ED92EC4307C ON hotel');
        $this->addSql('ALTER TABLE 
          hotel 
        DROP 
          type_hotel, 
        DROP 
          department_type, 
        DROP 
          ratio, 
        DROP 
          phone, 
        DROP 
          email, 
        DROP 
          comment');
    }
}
