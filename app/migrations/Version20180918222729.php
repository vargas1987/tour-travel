<?php

namespace DoctrineMigrations;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelSeasonType;
use AltezzaTravelBundle\Entity\TypeSeason;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180918222729 extends AbstractMigration implements ContainerAwareInterface
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

        $this->addSql('CREATE TABLE hotel_season_type (
          id INT AUTO_INCREMENT NOT NULL, 
          hotel_id INT DEFAULT NULL, 
          type_season VARCHAR(32) DEFAULT NULL, 
          INDEX IDX_D45981983243BB18 (hotel_id), 
          INDEX IDX_D4598198D3333091 (type_season), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          hotel_season_type 
        ADD 
          CONSTRAINT FK_D45981983243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE 
          hotel_season_type 
        ADD 
          CONSTRAINT FK_D4598198D3333091 FOREIGN KEY (type_season) REFERENCES type_season (type)');
    }

    public function postUp(Schema $schema)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        $seasonTypes = $em->getRepository(TypeSeason::class)->findAll();
        $hotels = $em->getRepository(Hotel::class)->findAll();

        foreach ($hotels as $hotel) {
            foreach ($seasonTypes as $seasonType) {
                $hotelSeasonType = new HotelSeasonType();
                $hotelSeasonType
                    ->setHotel($hotel)
                    ->setSeasonType($seasonType)
                ;

                $em->persist($hotelSeasonType);
            }
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

        $this->addSql('DROP TABLE hotel_season_type');
    }
}
