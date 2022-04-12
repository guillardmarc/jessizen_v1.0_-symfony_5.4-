<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412140800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE websites_updates (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, website_id INT NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, date DATE NOT NULL, more_info LONGTEXT DEFAULT NULL, under_version VARCHAR(3) DEFAULT NULL, INDEX IDX_84D2CA77F675F31B (author_id), INDEX IDX_84D2CA7718F45C82 (website_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE websites_updates ADD CONSTRAINT FK_84D2CA77F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE websites_updates ADD CONSTRAINT FK_84D2CA7718F45C82 FOREIGN KEY (website_id) REFERENCES websites (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE websites_updates');
    }
}
