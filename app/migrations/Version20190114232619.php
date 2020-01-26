<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190114232619 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calculation_flight (
          id INT AUTO_INCREMENT NOT NULL, 
          calculation_id INT DEFAULT NULL, 
          airstrip_id INT DEFAULT NULL, 
          one_way TINYINT(1) NOT NULL, 
          total_pax INT NOT NULL, 
          INDEX IDX_99FD85C9CE3D4B33 (calculation_id), 
          INDEX IDX_99FD85C913755BFE (airstrip_id), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          calculation_flight 
        ADD 
          CONSTRAINT FK_99FD85C9CE3D4B33 FOREIGN KEY (calculation_id) REFERENCES calculation (id)');
        $this->addSql('ALTER TABLE 
          calculation_flight 
        ADD 
          CONSTRAINT FK_99FD85C913755BFE FOREIGN KEY (airstrip_id) REFERENCES territorial_airstrip (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE calculation_flight');
    }
}
