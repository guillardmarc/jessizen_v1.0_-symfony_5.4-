<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412001547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD created_at DATETIME NOT NULL, ADD modified_at DATETIME NOT NULL, ADD pseudo VARCHAR(255) NOT NULL, ADD picture_profil_alt VARCHAR(255) DEFAULT NULL, ADD picture_profil_link VARCHAR(255) DEFAULT NULL, ADD picture_profil_name VARCHAR(255) DEFAULT NULL, ADD birthday DATE DEFAULT NULL, ADD more_info LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP created_at, DROP modified_at, DROP pseudo, DROP picture_profil_alt, DROP picture_profil_link, DROP picture_profil_name, DROP birthday, DROP more_info');
    }
}
