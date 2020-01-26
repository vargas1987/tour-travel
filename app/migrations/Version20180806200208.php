<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180806200208 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D8F3692CD');
        $this->addSql('ALTER TABLE hotel_room_accommodation DROP FOREIGN KEY FK_43101C9B8F3692CD');
        $this->addSql('RENAME TABLE hotel_accommodation_type TO type_accommodation;');
        $this->addSql('ALTER TABLE 
          hotel_price 
        ADD 
          CONSTRAINT FK_291CEC1D8F3692CD FOREIGN KEY (accommodation_id) REFERENCES type_accommodation (id)');
        $this->addSql('ALTER TABLE 
          hotel_room_accommodation 
        ADD 
          CONSTRAINT FK_43101C9B8F3692CD FOREIGN KEY (accommodation_id) REFERENCES type_accommodation (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D8F3692CD');
        $this->addSql('ALTER TABLE hotel_room_accommodation DROP FOREIGN KEY FK_43101C9B8F3692CD');
        $this->addSql('DROP TABLE type_accommodation');
        $this->addSql('RENAME TABLE type_accommodation TO hotel_accommodation_type;');
        $this->addSql('ALTER TABLE 
          hotel_price 
        ADD 
          CONSTRAINT FK_291CEC1D8F3692CD FOREIGN KEY (accommodation_id) REFERENCES hotel_accommodation_type (id)');
        $this->addSql('ALTER TABLE 
          hotel_room_accommodation 
        ADD 
          CONSTRAINT FK_43101C9B8F3692CD FOREIGN KEY (accommodation_id) REFERENCES hotel_accommodation_type (id)');
    }
}
