<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190819211600 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('INSERT INTO type_additional_fee (type, behavior, title, sort, created_at) 
            VALUES 
            (\'wma_adult\', \'wma_adult_incl\', \'WMA Adult\', 5, CURRENT_TIMESTAMP),
            (\'wma_child\', \'wma_child_incl\', \'WMA Child\', 6, CURRENT_TIMESTAMP)
        ');
        $this->addSql('UPDATE hotel_price_additional_fee SET additional_fees_type = \'wma_adult\' WHERE additional_fees_type = \'wma\';');
        $this->addSql('DELETE FROM type_additional_fee WHERE type = \'wma\';');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('INSERT INTO type_additional_fee (type, behavior, title, sort, created_at) 
            VALUES 
            (\'wma\', \'wma_incl\', \'WMA\', 5, CURRENT_TIMESTAMP)
        ');
        $this->addSql('UPDATE hotel_price_additional_fee SET additional_fees_type = \'wma\' WHERE additional_fees_type = \'wma_adult\';');
        $this->addSql('DELETE FROM type_additional_fee WHERE type IN (\'wma_adult\', \'wma_child\');');
    }
}
