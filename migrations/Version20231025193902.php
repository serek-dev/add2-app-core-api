<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231025193902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catalog_meal (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalog_meal_product (id VARCHAR(255) NOT NULL, meal_id VARCHAR(255) DEFAULT NULL, weight DOUBLE PRECISION NOT NULL, proteins DOUBLE PRECISION NOT NULL, fats DOUBLE PRECISION NOT NULL, carbs DOUBLE PRECISION NOT NULL, kcal DOUBLE PRECISION NOT NULL, name VARCHAR(255) NOT NULL, parent_id VARCHAR(255) NOT NULL, producer_name VARCHAR(255) DEFAULT NULL, INDEX IDX_9B868C7A639666D6 (meal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalog_product (id VARCHAR(255) NOT NULL, proteins DOUBLE PRECISION NOT NULL, fats DOUBLE PRECISION NOT NULL, carbs DOUBLE PRECISION NOT NULL, kcal DOUBLE PRECISION NOT NULL, name VARCHAR(255) NOT NULL, producer_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nutrition_log_day (id INT AUTO_INCREMENT NOT NULL, date VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nutrition_log_day_meal (id VARCHAR(255) NOT NULL, day_id INT DEFAULT NULL, consumption_time VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_BAADFCB39C24126 (day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nutrition_log_day_meal_product (id VARCHAR(255) NOT NULL, meal_id VARCHAR(255) DEFAULT NULL, weight DOUBLE PRECISION NOT NULL, proteins DOUBLE PRECISION NOT NULL, fats DOUBLE PRECISION NOT NULL, carbs DOUBLE PRECISION NOT NULL, kcal DOUBLE PRECISION NOT NULL, product_id VARCHAR(255) NOT NULL, product_name VARCHAR(255) NOT NULL, producer_name VARCHAR(255) DEFAULT NULL, INDEX IDX_A35076BC639666D6 (meal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nutrition_log_day_product (id VARCHAR(255) NOT NULL, day_id INT DEFAULT NULL, weight DOUBLE PRECISION NOT NULL, proteins DOUBLE PRECISION NOT NULL, fats DOUBLE PRECISION NOT NULL, carbs DOUBLE PRECISION NOT NULL, kcal DOUBLE PRECISION NOT NULL, product_id VARCHAR(255) NOT NULL, product_name VARCHAR(255) NOT NULL, producer_name VARCHAR(255) DEFAULT NULL, consumption_time VARCHAR(255) NOT NULL, INDEX IDX_1EB965C9C24126 (day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE catalog_meal_product ADD CONSTRAINT FK_9B868C7A639666D6 FOREIGN KEY (meal_id) REFERENCES catalog_meal (id)');
        $this->addSql('ALTER TABLE nutrition_log_day_meal ADD CONSTRAINT FK_BAADFCB39C24126 FOREIGN KEY (day_id) REFERENCES nutrition_log_day (id)');
        $this->addSql('ALTER TABLE nutrition_log_day_meal_product ADD CONSTRAINT FK_A35076BC639666D6 FOREIGN KEY (meal_id) REFERENCES nutrition_log_day_meal (id)');
        $this->addSql('ALTER TABLE nutrition_log_day_product ADD CONSTRAINT FK_1EB965C9C24126 FOREIGN KEY (day_id) REFERENCES nutrition_log_day (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog_meal_product DROP FOREIGN KEY FK_9B868C7A639666D6');
        $this->addSql('ALTER TABLE nutrition_log_day_meal DROP FOREIGN KEY FK_BAADFCB39C24126');
        $this->addSql('ALTER TABLE nutrition_log_day_meal_product DROP FOREIGN KEY FK_A35076BC639666D6');
        $this->addSql('ALTER TABLE nutrition_log_day_product DROP FOREIGN KEY FK_1EB965C9C24126');
        $this->addSql('DROP TABLE catalog_meal');
        $this->addSql('DROP TABLE catalog_meal_product');
        $this->addSql('DROP TABLE catalog_product');
        $this->addSql('DROP TABLE nutrition_log_day');
        $this->addSql('DROP TABLE nutrition_log_day_meal');
        $this->addSql('DROP TABLE nutrition_log_day_meal_product');
        $this->addSql('DROP TABLE nutrition_log_day_product');
    }
}
