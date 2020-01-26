<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180904223441 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('INSERT INTO type_additional_fee (type, behavior, title, sort) 
          VALUES
          (\'drivers_accommodation\', \'alone\', \'Drivers accommodation\', 1),
          (\'concession\', \'per_person\', \'Concession fee\', 2),
          (\'tdl\', \'per_person\', \'TDL\', 3),
          (\'conservation_charge\', \'per_person\', \'Conservation charge\', 4)
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
