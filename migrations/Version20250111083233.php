<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250111083233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dev_post (dev_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_F4FB173DA421F7B0 (dev_id), INDEX IDX_F4FB173D4B89032C (post_id), PRIMARY KEY(dev_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dev_post ADD CONSTRAINT FK_F4FB173DA421F7B0 FOREIGN KEY (dev_id) REFERENCES dev (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_post ADD CONSTRAINT FK_F4FB173D4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dev_post DROP FOREIGN KEY FK_F4FB173DA421F7B0');
        $this->addSql('ALTER TABLE dev_post DROP FOREIGN KEY FK_F4FB173D4B89032C');
        $this->addSql('DROP TABLE dev_post');
    }
}
