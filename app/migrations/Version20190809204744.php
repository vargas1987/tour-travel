<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190809204744 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE 
          hotel CHANGE airstrip_id airstrip_id INT DEFAULT NULL, 
          CHANGE location_id location_id INT NOT NULL, 
          CHANGE chain_id chain_id INT DEFAULT NULL, 
          CHANGE area_id area_id INT DEFAULT NULL, 
          CHANGE type_hotel type_hotel VARCHAR(32) DEFAULT NULL, 
          CHANGE time_to_airstrip time_to_airstrip INT DEFAULT NULL, 
          CHANGE adult_from adult_from INT DEFAULT NULL, 
          CHANGE teenager_from teenager_from INT DEFAULT NULL, 
          CHANGE teenager_to teenager_to INT DEFAULT NULL, 
          CHANGE child_to child_to INT DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL, 
          CHANGE price_up_to price_up_to DATE DEFAULT NULL, 
          CHANGE extra_data extra_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json_array)\', 
          CHANGE status status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE 
          calculation_person CHANGE calculation_id calculation_id INT NOT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL, 
          CHANGE count count INT DEFAULT NULL, 
          CHANGE age age INT DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          hotel_price_additional_fee CHANGE additional_fees_type additional_fees_type VARCHAR(32) DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          calculation_night CHANGE updated_at updated_at DATETIME DEFAULT NULL, 
          CHANGE night night INT DEFAULT NULL, 
          CHANGE night_from night_from INT DEFAULT NULL, 
          CHANGE night_to night_to INT DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          hotel_years_options CHANGE hotel_id hotel_id INT NOT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL, 
          CHANGE type type VARCHAR(255) DEFAULT \'boolean\' NOT NULL');
        $this->addSql('ALTER TABLE calculation_day CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          hotel_contact CHANGE department_type department_type VARCHAR(32) DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          type_supplement CHANGE description description VARCHAR(255) DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          type_season CHANGE updated_at updated_at DATETIME DEFAULT NULL, 
          CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          calculation_setting_fee CHANGE car car INT DEFAULT NULL, 
          CHANGE driver driver INT DEFAULT NULL, 
          CHANGE adult adult INT DEFAULT NULL, 
          CHANGE child child INT DEFAULT NULL, 
          CHANGE priceTsh priceTsh INT DEFAULT NULL, 
          CHANGE priceUsd priceUsd INT DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          calculation_setting_domestic_flight CHANGE description description VARCHAR(255) DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          calculation_setting_currency_rate CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          hotel_room CHANGE title title VARCHAR(255) DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          type_department CHANGE description description VARCHAR(255) DEFAULT NULL, 
          CHANGE created_at created_at DATETIME NOT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE settings_transfer_territorial CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE territorial_airstrip CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          user CHANGE updated_at updated_at DATETIME DEFAULT NULL, 
          CHANGE token token VARCHAR(64) DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          territorial_area CHANGE location_id location_id INT NOT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          type_meal_plan CHANGE description description VARCHAR(255) DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          hotel_mobile_camp CHANGE airstrip_id airstrip_id INT DEFAULT NULL, 
          CHANGE hotel_id hotel_id INT NOT NULL, 
          CHANGE location_id location_id INT NOT NULL, 
          CHANGE area_id area_id INT DEFAULT NULL, 
          CHANGE time_to_airstrip time_to_airstrip INT NOT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel_chain CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          hotel_price CHANGE meal_plan_type meal_plan_type VARCHAR(32) NOT NULL, 
          CHANGE hotel_id hotel_id INT NOT NULL, 
          CHANGE room_id room_id INT NOT NULL, 
          CHANGE accommodation_type accommodation_type VARCHAR(32) NOT NULL, 
          CHANGE season_type season_type VARCHAR(32) NOT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          territorial_park CHANGE location_id location_id INT NOT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          calculation 
        ADD 
          our_commission DOUBLE PRECISION DEFAULT \'35.00\' NOT NULL, 
          CHANGE created_at created_at DATETIME NOT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          hotel_season CHANGE season_type season_type VARCHAR(32) DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          type_additional_fee CHANGE description description VARCHAR(255) DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          type_room CHANGE description description VARCHAR(255) DEFAULT NULL, 
          CHANGE color color VARCHAR(6) DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          hotel_season_type CHANGE hotel_id hotel_id INT NOT NULL, 
          CHANGE type_season type_season VARCHAR(32) DEFAULT NULL');
        $this->addSql('ALTER TABLE territorial_location CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          hotel_price_supplement CHANGE supplement_type supplement_type VARCHAR(32) DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          type_hotel CHANGE description description VARCHAR(255) DEFAULT NULL, 
          CHANGE created_at created_at DATETIME NOT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE 
          calculation 
        DROP 
          our_commission, 
          CHANGE created_at created_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE calculation_day CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          calculation_night CHANGE updated_at updated_at DATETIME NOT NULL, 
          CHANGE night night INT DEFAULT NULL, 
          CHANGE night_from night_from INT DEFAULT NULL, 
          CHANGE night_to night_to INT DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          calculation_person CHANGE calculation_id calculation_id INT DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME NOT NULL, 
          CHANGE count count INT DEFAULT NULL, 
          CHANGE age age INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calculation_setting_currency_rate CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          calculation_setting_domestic_flight CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          calculation_setting_fee CHANGE car car INT DEFAULT NULL, 
          CHANGE driver driver INT DEFAULT NULL, 
          CHANGE adult adult INT DEFAULT NULL, 
          CHANGE child child INT DEFAULT NULL, 
          CHANGE priceTsh priceTsh INT DEFAULT NULL, 
          CHANGE priceUsd priceUsd INT DEFAULT NULL');
        $this->addSql('ALTER TABLE 
          hotel CHANGE type_hotel type_hotel VARCHAR(32) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE chain_id chain_id INT DEFAULT NULL, 
          CHANGE location_id location_id INT DEFAULT NULL, 
          CHANGE area_id area_id INT DEFAULT NULL, 
          CHANGE airstrip_id airstrip_id INT DEFAULT NULL, 
          CHANGE time_to_airstrip time_to_airstrip INT DEFAULT NULL, 
          CHANGE child_to child_to INT DEFAULT NULL, 
          CHANGE teenager_from teenager_from INT DEFAULT NULL, 
          CHANGE teenager_to teenager_to INT DEFAULT NULL, 
          CHANGE adult_from adult_from INT DEFAULT NULL, 
          CHANGE price_up_to price_up_to DATE DEFAULT \'NULL\', 
          CHANGE extra_data extra_data LONGTEXT DEFAULT \'NULL\' COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\', 
          CHANGE status status VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE hotel_chain CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          hotel_contact CHANGE department_type department_type VARCHAR(32) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          hotel_mobile_camp CHANGE hotel_id hotel_id INT DEFAULT NULL, 
          CHANGE location_id location_id INT DEFAULT NULL, 
          CHANGE area_id area_id INT DEFAULT NULL, 
          CHANGE airstrip_id airstrip_id INT DEFAULT NULL, 
          CHANGE time_to_airstrip time_to_airstrip INT DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          hotel_price CHANGE hotel_id hotel_id INT DEFAULT NULL, 
          CHANGE room_id room_id INT DEFAULT NULL, 
          CHANGE meal_plan_type meal_plan_type VARCHAR(32) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE accommodation_type accommodation_type VARCHAR(32) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE season_type season_type VARCHAR(32) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          hotel_price_additional_fee CHANGE additional_fees_type additional_fees_type VARCHAR(32) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          hotel_price_supplement CHANGE supplement_type supplement_type VARCHAR(32) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          hotel_room CHANGE title title VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          hotel_season CHANGE season_type season_type VARCHAR(32) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          hotel_season_type CHANGE hotel_id hotel_id INT DEFAULT NULL, 
          CHANGE type_season type_season VARCHAR(32) DEFAULT \'NULL\' COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE 
          hotel_years_options CHANGE hotel_id hotel_id INT DEFAULT NULL, 
          CHANGE type type VARCHAR(255) DEFAULT \'\' boolean \'\' NOT NULL COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE settings_transfer_territorial CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE territorial_airstrip CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          territorial_area CHANGE location_id location_id INT DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE territorial_location CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          territorial_park CHANGE location_id location_id INT DEFAULT NULL, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          type_additional_fee CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          type_department CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE created_at created_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE 
          type_hotel CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE created_at created_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL, 
          CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE 
          type_meal_plan CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          type_room CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE color color VARCHAR(6) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          type_season CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          type_supplement CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE 
          user CHANGE token token VARCHAR(64) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, 
          CHANGE updated_at updated_at DATETIME NOT NULL');
    }
}
