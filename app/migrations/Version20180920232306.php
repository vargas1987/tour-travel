<?php

namespace DoctrineMigrations;

use AltezzaTravelBundle\Entity\Hotel;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180920232306 extends AbstractMigration implements ContainerAwareInterface
{
    /** @var ContainerInterface $container */
    private $container;

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

        $this->addSql('ALTER TABLE hotel_price_specific_room_season DROP FOREIGN KEY FK_2A49A0DC548E0AA7');
        $this->addSql('DROP TABLE hotel_price_specific_room');
        $this->addSql('DROP TABLE hotel_price_specific_room_season');
    }

    public function postUp(Schema $schema)
    {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');
        $uow = $em->getUnitOfWork();

        $hotels = $em->getRepository(Hotel::class)->findAll();
        foreach ($hotels as $hotel) {
            $hotel->setUpdatedAt(new \DateTime());
            $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(Hotel::class), $hotel);
        }

        $em->flush();
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hotel_price_specific_room (
          id INT AUTO_INCREMENT NOT NULL,
          accommodation_type VARCHAR(32) DEFAULT NULL COLLATE utf8_unicode_ci,
          hotel_id INT NOT NULL,
          room_id INT DEFAULT NULL,
          year INT NOT NULL,
          created_at DATETIME NOT NULL,
          updated_at DATETIME NOT NULL,
          UNIQUE INDEX hotel_price_specific_room_unique (
            hotel_id, room_id, accommodation_type,
            year
          ),
          INDEX IDX_1639352D3243BB18 (hotel_id),
          INDEX IDX_1639352D54177093 (room_id),
          INDEX IDX_1639352D85E695E2 (accommodation_type),
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_price_specific_room_season (
          id INT AUTO_INCREMENT NOT NULL,
          season_type VARCHAR(32) DEFAULT NULL COLLATE utf8_unicode_ci,
          price_specific_room_id INT NOT NULL,
          price INT DEFAULT 0 NOT NULL,
          created_at DATETIME NOT NULL,
          updated_at DATETIME NOT NULL,
          INDEX IDX_2A49A0DC548E0AA7 (price_specific_room_id),
          INDEX IDX_2A49A0DCA97CBB7 (season_type),
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE
          hotel_price_specific_room
        ADD
          CONSTRAINT FK_1639352D85E695E2 FOREIGN KEY (accommodation_type) REFERENCES type_accommodation (type)');
        $this->addSql('ALTER TABLE
          hotel_price_specific_room
        ADD
          CONSTRAINT FK_1639352D3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE
          hotel_price_specific_room
        ADD
          CONSTRAINT FK_1639352D54177093 FOREIGN KEY (room_id) REFERENCES hotel_room (id)');
        $this->addSql('ALTER TABLE
          hotel_price_specific_room_season
        ADD
          CONSTRAINT FK_2A49A0DCA97CBB7 FOREIGN KEY (season_type) REFERENCES type_season (type)');
        $this->addSql('ALTER TABLE
          hotel_price_specific_room_season
        ADD
          CONSTRAINT FK_2A49A0DC548E0AA7 FOREIGN KEY (price_specific_room_id) REFERENCES hotel_price_specific_room (id)');
    }
}
