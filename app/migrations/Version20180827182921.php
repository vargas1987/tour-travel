<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180827182921 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            INSERT INTO type_room (type, name, short_name, color, `specific`, sort) 
            VALUES 
            (\'single\', \'Single\', \'SNG\', \'6f9e20\', 0, 1),
            (\'double\', \'Double\', \'DBL\', \'2487c5\', 0, 2),
            (\'twin\', \'Twin\', \'TWN\', \'6f9e20\', 0, 3),
            (\'triple\', \'Triple\', \'TPL\', \'923298\', 0, 4),
            (\'family_suite\', \'Family Suite\', \'FML\', \'e65050\', 0, 5),
            (\'specific\', \'Specific Room Types\', \'SPC\', \'000000\', 1, 6)
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    }
}
