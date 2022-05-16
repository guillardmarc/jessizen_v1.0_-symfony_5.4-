<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515124806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles CHANGE is_commented is_commented TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE websites CHANGE presentation_picture_alt presentation_picture_alt VARCHAR(255) DEFAULT NULL, CHANGE presentation_picture_link presentation_picture_link VARCHAR(255) DEFAULT NULL, CHANGE presentation_picture_name presentation_picture_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles CHANGE is_commented is_commented TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE websites CHANGE presentation_picture_alt presentation_picture_alt VARCHAR(255) NOT NULL, CHANGE presentation_picture_link presentation_picture_link VARCHAR(255) NOT NULL, CHANGE presentation_picture_name presentation_picture_name VARCHAR(255) NOT NULL');
    }
}
