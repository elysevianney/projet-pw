<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250111033418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profile_view (id INT AUTO_INCREMENT NOT NULL, profile_owner_id INT DEFAULT NULL, viewer_id INT DEFAULT NULL, INDEX IDX_4835241A87560048 (profile_owner_id), INDEX IDX_4835241A6C59C752 (viewer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profile_view ADD CONSTRAINT FK_4835241A87560048 FOREIGN KEY (profile_owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE profile_view ADD CONSTRAINT FK_4835241A6C59C752 FOREIGN KEY (viewer_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile_view DROP FOREIGN KEY FK_4835241A87560048');
        $this->addSql('ALTER TABLE profile_view DROP FOREIGN KEY FK_4835241A6C59C752');
        $this->addSql('DROP TABLE profile_view');
    }
}
