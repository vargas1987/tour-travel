<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180625074539 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE 
          hotel 
        DROP 
          type, 
        DROP 
          child_from, 
          CHANGE adult_from adult_from INT DEFAULT NULL, 
          CHANGE teenager_from teenager_from INT DEFAULT NULL, 
          CHANGE teenager_to teenager_to INT DEFAULT NULL, 
          CHANGE child_to child_to INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE 
          hotel 
        ADD 
          type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, 
        ADD 
          child_from INT NOT NULL, 
          CHANGE child_to child_to INT NOT NULL, 
          CHANGE teenager_from teenager_from INT NOT NULL, 
          CHANGE teenager_to teenager_to INT NOT NULL, 
          CHANGE adult_from adult_from INT NOT NULL');
    }
}
