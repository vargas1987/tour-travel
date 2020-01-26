<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180822132055 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE type_room_accommodation (id INT AUTO_INCREMENT NOT NULL, sort INT NOT NULL, roomType_id INT NOT NULL, accommodationType_id INT NOT NULL, INDEX IDX_272EC245B28C944D (roomType_id), INDEX IDX_272EC245AEA6F6AD (accommodationType_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_room (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, short_name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, color VARCHAR(6) DEFAULT NULL, `specific` TINYINT(1) NOT NULL, sort INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_A59094938CDE5729 (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE type_room_accommodation ADD CONSTRAINT FK_272EC245B28C944D FOREIGN KEY (roomType_id) REFERENCES type_room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_room_accommodation ADD CONSTRAINT FK_272EC245AEA6F6AD FOREIGN KEY (accommodationType_id) REFERENCES type_accommodation (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5DD5E3278CDE5729 ON type_accommodation (type)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE type_room_accommodation DROP FOREIGN KEY FK_272EC245B28C944D');
        $this->addSql('DROP TABLE type_room_accommodation');
        $this->addSql('DROP TABLE type_room');
        $this->addSql('DROP INDEX UNIQ_5DD5E3278CDE5729 ON type_accommodation');
    }
}
