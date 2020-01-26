<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180824123629 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_type_of_meal DROP FOREIGN KEY FK_B8E09A49912AB082');
        $this->addSql('DROP INDEX IDX_B8E09A49912AB082 ON hotel_type_of_meal');
        $this->addSql('ALTER TABLE hotel_type_of_meal DROP PRIMARY KEY');

        $this->addSql('ALTER TABLE hotel_type_of_meal CHANGE meal_plan_id meal_plan_type VARCHAR(32) NOT NULL');

        $this->addSql('
            UPDATE hotel_type_of_meal AS htom
            SET meal_plan_type = (
                SELECT tmp.type FROM type_meal_plan tmp WHERE tmp.id = htom.meal_plan_type
            );
        ');

        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D989D358F');
        $this->addSql('DROP INDEX IDX_291CEC1D989D358F ON hotel_price');
        $this->addSql('DROP INDEX hotel_price_unique ON hotel_price');

        $this->addSql('ALTER TABLE hotel_price CHANGE meal_plan_type_id meal_plan_type VARCHAR(32) NOT NULL');

        $this->addSql('
            UPDATE hotel_price AS hp
            SET meal_plan_type = (
                SELECT tmp.type FROM type_meal_plan tmp WHERE tmp.id = hp.meal_plan_type
            );
        ');

        $this->addSql('ALTER TABLE type_meal_plan MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE type_meal_plan DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE type_meal_plan DROP id, CHANGE type type VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7342C9998CDE5729 ON type_meal_plan (type)');
        $this->addSql('ALTER TABLE type_meal_plan ADD PRIMARY KEY (type)');

        $this->addSql('ALTER TABLE hotel_type_of_meal ADD CONSTRAINT FK_B8E09A49276799D0 FOREIGN KEY (meal_plan_type) REFERENCES type_meal_plan (type)');
        $this->addSql('CREATE INDEX IDX_B8E09A49276799D0 ON hotel_type_of_meal (meal_plan_type)');
        $this->addSql('ALTER TABLE hotel_type_of_meal ADD PRIMARY KEY (hotel_id, meal_plan_type)');

        $this->addSql('ALTER TABLE hotel_price ADD CONSTRAINT FK_291CEC1D276799D0 FOREIGN KEY (meal_plan_type) REFERENCES type_meal_plan (type)');
        $this->addSql('CREATE INDEX IDX_291CEC1D276799D0 ON hotel_price (meal_plan_type)');
        $this->addSql('CREATE UNIQUE INDEX hotel_price_unique ON hotel_price (hotel_id, meal_plan_type, room_id, accommodation_type, season_type, year)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel_price DROP FOREIGN KEY FK_291CEC1D276799D0');
        $this->addSql('DROP INDEX IDX_291CEC1D276799D0 ON hotel_price');
        $this->addSql('DROP INDEX hotel_price_unique ON hotel_price');
        $this->addSql('ALTER TABLE hotel_price ADD meal_plan_type_id INT DEFAULT NULL, DROP meal_plan_type');
        $this->addSql('ALTER TABLE hotel_price ADD CONSTRAINT FK_291CEC1D989D358F FOREIGN KEY (meal_plan_type_id) REFERENCES type_meal_plan (id)');
        $this->addSql('CREATE INDEX IDX_291CEC1D989D358F ON hotel_price (meal_plan_type_id)');
        $this->addSql('CREATE UNIQUE INDEX hotel_price_unique ON hotel_price (hotel_id, meal_plan_type_id, room_id, accommodation_type, season_type, year)');
        $this->addSql('ALTER TABLE hotel_type_of_meal DROP FOREIGN KEY FK_B8E09A49276799D0');
        $this->addSql('DROP INDEX IDX_B8E09A49276799D0 ON hotel_type_of_meal');
        $this->addSql('ALTER TABLE hotel_type_of_meal DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE hotel_type_of_meal ADD meal_plan_id INT NOT NULL, DROP meal_plan_type');
        $this->addSql('ALTER TABLE hotel_type_of_meal ADD CONSTRAINT FK_B8E09A49912AB082 FOREIGN KEY (meal_plan_id) REFERENCES type_meal_plan (id)');
        $this->addSql('CREATE INDEX IDX_B8E09A49912AB082 ON hotel_type_of_meal (meal_plan_id)');
        $this->addSql('ALTER TABLE hotel_type_of_meal ADD PRIMARY KEY (hotel_id, meal_plan_id)');
        $this->addSql('DROP INDEX UNIQ_7342C9998CDE5729 ON type_meal_plan');
        $this->addSql('ALTER TABLE type_meal_plan DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE type_meal_plan ADD id INT AUTO_INCREMENT NOT NULL, CHANGE type type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE type_meal_plan ADD PRIMARY KEY (id)');
    }
}
