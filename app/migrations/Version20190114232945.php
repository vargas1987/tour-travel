<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190114232945 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calculation DROP FOREIGN KEY FK_F6A769703DE6659D');
        $this->addSql('ALTER TABLE calculation DROP FOREIGN KEY FK_F6A769708D3A6A9B');
        $this->addSql('DROP INDEX IDX_F6A769708D3A6A9B ON calculation');
        $this->addSql('DROP INDEX IDX_F6A769703DE6659D ON calculation');
        $this->addSql('ALTER TABLE calculation DROP to_airstrip_id, DROP from_airstrip_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calculation ADD to_airstrip_id INT NOT NULL, ADD from_airstrip_id INT NOT NULL');
        $this->addSql('ALTER TABLE 
          calculation 
        ADD 
          CONSTRAINT FK_F6A769703DE6659D FOREIGN KEY (to_airstrip_id) REFERENCES territorial_airstrip (id)');
        $this->addSql('ALTER TABLE 
          calculation 
        ADD 
          CONSTRAINT FK_F6A769708D3A6A9B FOREIGN KEY (from_airstrip_id) REFERENCES territorial_airstrip (id)');
        $this->addSql('CREATE INDEX IDX_F6A769708D3A6A9B ON calculation (from_airstrip_id)');
        $this->addSql('CREATE INDEX IDX_F6A769703DE6659D ON calculation (to_airstrip_id)');
    }
}
