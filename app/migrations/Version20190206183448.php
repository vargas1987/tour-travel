<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190206183448 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calculation_transfer (
          id INT AUTO_INCREMENT NOT NULL, 
          calculation_id INT NOT NULL, 
          arrival_airstrip_id INT NOT NULL, 
          departure_airstrip_id INT NOT NULL, 
          one_way TINYINT(1) NOT NULL, 
          total_pax INT NOT NULL, 
          INDEX IDX_10348901CE3D4B33 (calculation_id), 
          INDEX IDX_103489016948DDE6 (arrival_airstrip_id), 
          INDEX IDX_10348901E4C9A25B (departure_airstrip_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          calculation_transfer 
        ADD 
          CONSTRAINT FK_10348901CE3D4B33 FOREIGN KEY (calculation_id) REFERENCES calculation (id)');
        $this->addSql('ALTER TABLE 
          calculation_transfer 
        ADD 
          CONSTRAINT FK_103489016948DDE6 FOREIGN KEY (arrival_airstrip_id) REFERENCES territorial_airstrip (id)');
        $this->addSql('ALTER TABLE 
          calculation_transfer 
        ADD 
          CONSTRAINT FK_10348901E4C9A25B FOREIGN KEY (departure_airstrip_id) REFERENCES territorial_airstrip (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE calculation_transfer');
    }
}
