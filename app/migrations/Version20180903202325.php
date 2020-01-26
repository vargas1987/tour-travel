<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180903202325 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE type_room_accommodation DROP FOREIGN KEY FK_272EC24585E695E2');
        $this->addSql('ALTER TABLE type_room_accommodation DROP FOREIGN KEY FK_272EC245EFDABD4D');
        $this->addSql('DROP INDEX idx_272ec245efdabd4d ON type_room_accommodation');
        $this->addSql('CREATE INDEX IDX_23E99F24EFDABD4D ON type_room_accommodation (room_type)');
        $this->addSql('DROP INDEX idx_272ec24585e695e2 ON type_room_accommodation');
        $this->addSql('CREATE INDEX IDX_23E99F2485E695E2 ON type_room_accommodation (accommodation_type)');
        $this->addSql('ALTER TABLE 
          type_room_accommodation 
        ADD 
          CONSTRAINT FK_272EC24585E695E2 FOREIGN KEY (accommodation_type) REFERENCES type_accommodation (type) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE 
          type_room_accommodation 
        ADD 
          CONSTRAINT FK_272EC245EFDABD4D FOREIGN KEY (room_type) REFERENCES type_room (type) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE type_room_accommodation DROP FOREIGN KEY FK_23E99F24EFDABD4D');
        $this->addSql('ALTER TABLE type_room_accommodation DROP FOREIGN KEY FK_23E99F2485E695E2');
        $this->addSql('DROP INDEX idx_23e99f24efdabd4d ON type_room_accommodation');
        $this->addSql('CREATE INDEX IDX_272EC245EFDABD4D ON type_room_accommodation (room_type)');
        $this->addSql('DROP INDEX idx_23e99f2485e695e2 ON type_room_accommodation');
        $this->addSql('CREATE INDEX IDX_272EC24585E695E2 ON type_room_accommodation (accommodation_type)');
        $this->addSql('ALTER TABLE 
          type_room_accommodation 
        ADD 
          CONSTRAINT FK_23E99F24EFDABD4D FOREIGN KEY (room_type) REFERENCES type_room (type) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE 
          type_room_accommodation 
        ADD 
          CONSTRAINT FK_23E99F2485E695E2 FOREIGN KEY (accommodation_type) REFERENCES type_accommodation (type) ON DELETE CASCADE');
    }
}
