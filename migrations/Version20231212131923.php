<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231212131923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            '
            INSERT INTO user (id, hashed_password, identifier, email)
            VALUES ("IU-655532dd20bae", "$2y$13$rTr3IlN8SUlHVoWWgJiVfOh91LBS3jJiXKTc8AW9EF7V5C/J0bWla", "st",
                    "sebastian.twarog1989@gmail.com")
            ON DUPLICATE KEY UPDATE id = id;
            
            INSERT INTO user (id, hashed_password, identifier, email)
            VALUES ("IU-9889635165161", "$2y$13$rTr3IlN8SUlHVoWWgJiVfOh91LBS3jJiXKTc8AW9EF7V5C/J0bWla", "test",
                    "rozliczenia@stwarog.com")
            ON DUPLICATE KEY UPDATE id = id;
            
            UPDATE metric set user_id = "IU-655532dd20bae" WHERE user_id = "";
            UPDATE catalog_meal set user_id = "IU-655532dd20bae" WHERE user_id = "";
            UPDATE catalog_product set user_id = "IU-655532dd20bae" WHERE user_id = "";
            UPDATE nutrition_log_day set user_id = "IU-655532dd20bae" WHERE user_id = "";
            '
        );

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
