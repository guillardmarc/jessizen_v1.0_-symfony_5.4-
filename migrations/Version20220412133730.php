<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412133730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE websites (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, developper_id INT NOT NULL, owner_id INT NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, logo_text VARCHAR(255) NOT NULL, logo_picture_alt VARCHAR(255) DEFAULT NULL, logo_picture_link VARCHAR(255) DEFAULT NULL, logo_picture_name VARCHAR(255) DEFAULT NULL, copyright VARCHAR(255) NOT NULL, regulation LONGTEXT NOT NULL, version VARCHAR(3) NOT NULL, presentation_text LONGTEXT NOT NULL, presentation_picture_alt VARCHAR(255) NOT NULL, presentation_picture_link VARCHAR(255) NOT NULL, presentation_picture_name VARCHAR(255) NOT NULL, publication_date DATE DEFAULT NULL, INDEX IDX_2527D78DF675F31B (author_id), INDEX IDX_2527D78DDA42B93 (developper_id), INDEX IDX_2527D78D7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE websites ADD CONSTRAINT FK_2527D78DF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE websites ADD CONSTRAINT FK_2527D78DDA42B93 FOREIGN KEY (developper_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE websites ADD CONSTRAINT FK_2527D78D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE websites');
    }
}
