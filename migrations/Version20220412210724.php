<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412210724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles_comments (id INT AUTO_INCREMENT NOT NULL, articles_id INT NOT NULL, author_id INT NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_FE0A60301EBAF6CC (articles_id), INDEX IDX_FE0A6030F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles_comments ADD CONSTRAINT FK_FE0A60301EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE articles_comments ADD CONSTRAINT FK_FE0A6030F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE articles_comments');
    }
}
