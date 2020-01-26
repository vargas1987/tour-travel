<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180629214418 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('UPDATE type_meal_plan SET description = \'Bed & Breakfast\' WHERE type = \'bb\'');
        $this->addSql('UPDATE type_meal_plan SET description = \'Half Board\' WHERE type = \'hb\'');
        $this->addSql('UPDATE type_meal_plan SET description = \'Full Board\' WHERE type = \'fb\'');
        $this->addSql('UPDATE type_meal_plan SET description = \'All Inclusive\' WHERE type = \'ai\'');
        $this->addSql('UPDATE type_meal_plan SET description = \'Game Package\' WHERE type = \'gp\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
