<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231105123431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nutrition_log_day CHANGE target_proteins target_proteins INT DEFAULT 0 NOT NULL, CHANGE target_fats target_fats INT DEFAULT 0 NOT NULL, CHANGE target_carbs target_carbs INT DEFAULT 0 NOT NULL, CHANGE target_kcal target_kcal DOUBLE PRECISION DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nutrition_log_day CHANGE target_proteins target_proteins DOUBLE PRECISION DEFAULT NULL, CHANGE target_fats target_fats DOUBLE PRECISION DEFAULT NULL, CHANGE target_carbs target_carbs DOUBLE PRECISION DEFAULT NULL, CHANGE target_kcal target_kcal DOUBLE PRECISION DEFAULT NULL');
    }
}
