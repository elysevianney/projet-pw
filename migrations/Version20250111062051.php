<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250111062051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_view (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, viewer_id INT DEFAULT NULL, INDEX IDX_37A8CC854B89032C (post_id), INDEX IDX_37A8CC856C59C752 (viewer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_view ADD CONSTRAINT FK_37A8CC854B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post_view ADD CONSTRAINT FK_37A8CC856C59C752 FOREIGN KEY (viewer_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_view DROP FOREIGN KEY FK_37A8CC854B89032C');
        $this->addSql('ALTER TABLE post_view DROP FOREIGN KEY FK_37A8CC856C59C752');
        $this->addSql('DROP TABLE post_view');
    }
}
