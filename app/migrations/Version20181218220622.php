<?php

namespace DoctrineMigrations;

use AltezzaTravelBundle\Entity\TerritorialAirstrip;
use AltezzaTravelBundle\Entity\TerritorialArea;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181218220622 extends AbstractMigration implements ContainerAwareInterface
{
    /** @var ContainerInterface $container */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE territorial_location_airstrip (
          territorial_location_id INT NOT NULL,
          territorial_airtstrip_id INT NOT NULL,
          INDEX IDX_1D861FD8BCA0BA9C (territorial_location_id),
          INDEX IDX_1D861FD855447219 (territorial_airtstrip_id),
          PRIMARY KEY(
            territorial_location_id, territorial_airtstrip_id
          )
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE territorial_area_airstrip (
          territorial_area_id INT NOT NULL,
          territorial_airtstrip_id INT NOT NULL,
          INDEX IDX_14E1B4B28522B1DB (territorial_area_id),
          INDEX IDX_14E1B4B255447219 (territorial_airtstrip_id),
          PRIMARY KEY(
            territorial_area_id, territorial_airtstrip_id
          )
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE
          territorial_location_airstrip
        ADD
          CONSTRAINT FK_1D861FD8BCA0BA9C FOREIGN KEY (territorial_location_id) REFERENCES territorial_location (id)');
        $this->addSql('ALTER TABLE
          territorial_location_airstrip
        ADD
          CONSTRAINT FK_1D861FD855447219 FOREIGN KEY (territorial_airtstrip_id) REFERENCES territorial_airstrip (id)');
        $this->addSql('ALTER TABLE
          territorial_area_airstrip
        ADD
          CONSTRAINT FK_14E1B4B28522B1DB FOREIGN KEY (territorial_area_id) REFERENCES territorial_area (id)');
        $this->addSql('ALTER TABLE
          territorial_area_airstrip
        ADD
          CONSTRAINT FK_14E1B4B255447219 FOREIGN KEY (territorial_airtstrip_id) REFERENCES territorial_airstrip (id)');

        $this->addSql('INSERT INTO territorial_location_airstrip (territorial_airtstrip_id, territorial_location_id)
            SELECT t.id AS territorial_airtstrip_id, ta.location_id as territorial_location_id
            FROM territorial_airstrip ta
            INNER JOIN (
                SELECT id, location_id, title
                FROM territorial_airstrip
                GROUP BY title
            ) AS t ON (t.title = ta.title)
            WHERE ta.area_id IS NULL
            GROUP BY territorial_airtstrip_id, territorial_location_id;
        ');

        $this->addSql('INSERT INTO territorial_area_airstrip (territorial_airtstrip_id, territorial_area_id)
            SELECT t.id AS territorial_airtstrip_id, ta.area_id as territorial_area_id
            FROM territorial_airstrip ta
            INNER JOIN (
                SELECT id, area_id, title
                FROM territorial_airstrip
                GROUP BY title
            ) AS t ON (t.title = ta.title)
            WHERE ta.area_id IS NOT NULL
            GROUP BY territorial_airtstrip_id, territorial_area_id;
        ');

        $this->addSql('UPDATE territorial_airstrip SET
              location_id = NULL,
              area_id = NULL
            WHERE id IN (
              SELECT uta.id FROM (
                SELECT dta.id
                FROM territorial_airstrip dta
                       INNER JOIN (
                    SELECT t.id AS airtstrip_id, ta.title as title
                    FROM territorial_airstrip ta
                           INNER JOIN (
                        SELECT id, area_id, title
                        FROM territorial_airstrip
                        GROUP BY title
                      ) AS t ON (t.title = ta.title)
                    GROUP BY airtstrip_id, ta.title
                  ) AS t1 ON (t1.title = dta.title and t1.airtstrip_id != dta.id)
              ) AS uta
            );
        ');

        $this->addSql('UPDATE hotel AS h
            INNER JOIN (
                SELECT dta.id AS old_id, t1.airtstrip_id as new_id
                FROM territorial_airstrip dta
                       INNER JOIN (
                    SELECT t.id AS airtstrip_id, ta.title as title
                    FROM territorial_airstrip ta
                           INNER JOIN (
                        SELECT id, area_id, title
                        FROM territorial_airstrip
                        GROUP BY title
                      ) AS t ON (t.title = ta.title)
                    GROUP BY airtstrip_id, ta.title
                  ) AS t1 ON (t1.title = dta.title and t1.airtstrip_id != dta.id)
            ) AS uta
            SET h.airstrip_id = uta.new_id
            WHERE h.airstrip_id = uta.old_id;        
        ');

        $this->addSql('UPDATE hotel_mobile_camp AS hmc
            INNER JOIN (
                SELECT dta.id AS old_id, t1.airtstrip_id as new_id
                FROM territorial_airstrip dta
                       INNER JOIN (
                    SELECT t.id AS airtstrip_id, ta.title as title
                    FROM territorial_airstrip ta
                           INNER JOIN (
                        SELECT id, area_id, title
                        FROM territorial_airstrip
                        GROUP BY title
                      ) AS t ON (t.title = ta.title)
                    GROUP BY airtstrip_id, ta.title
                  ) AS t1 ON (t1.title = dta.title and t1.airtstrip_id != dta.id)
            ) AS uta
            SET hmc.airstrip_id = uta.new_id
            WHERE hmc.airstrip_id = uta.old_id;
        ');

        $this->addSql('DELETE FROM territorial_airstrip WHERE location_id IS NULL AND area_id IS NULL;');

        $this->addSql('ALTER TABLE territorial_airstrip DROP FOREIGN KEY FK_2047934A64D218E');
        $this->addSql('ALTER TABLE territorial_airstrip DROP FOREIGN KEY FK_2047934ABD0F409C');
        $this->addSql('DROP INDEX IDX_2047934A64D218E ON territorial_airstrip');
        $this->addSql('DROP INDEX IDX_2047934ABD0F409C ON territorial_airstrip');
        $this->addSql('ALTER TABLE territorial_airstrip DROP location_id, DROP area_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE territorial_location_airstrip');
        $this->addSql('DROP TABLE territorial_area_airstrip');

        //@TODO revert data

        $this->addSql('ALTER TABLE 
          territorial_airstrip 
        ADD 
          location_id INT DEFAULT NULL, 
        ADD 
          area_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          territorial_airstrip 
        ADD 
          CONSTRAINT FK_2047934A64D218E FOREIGN KEY (location_id) REFERENCES territorial_location (id)');
        $this->addSql('ALTER TABLE 
          territorial_airstrip 
        ADD 
          CONSTRAINT FK_2047934ABD0F409C FOREIGN KEY (area_id) REFERENCES territorial_area (id)');
        $this->addSql('CREATE INDEX IDX_2047934A64D218E ON territorial_airstrip (location_id)');
        $this->addSql('CREATE INDEX IDX_2047934ABD0F409C ON territorial_airstrip (area_id)');
    }
}
