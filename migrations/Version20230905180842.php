<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230905180842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nutrition_log_day_meal ADD consumption_time VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE nutrition_log_day_meal_product DROP consumption_time');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nutrition_log_day_meal_product ADD consumption_time VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE nutrition_log_day_meal DROP consumption_time');
    }
}
