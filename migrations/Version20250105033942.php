<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250105033942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dev_technologie (dev_id INT NOT NULL, technologie_id INT NOT NULL, INDEX IDX_8517239FA421F7B0 (dev_id), INDEX IDX_8517239F261A27D2 (technologie_id), PRIMARY KEY(dev_id, technologie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technologie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dev_technologie ADD CONSTRAINT FK_8517239FA421F7B0 FOREIGN KEY (dev_id) REFERENCES dev (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_technologie ADD CONSTRAINT FK_8517239F261A27D2 FOREIGN KEY (technologie_id) REFERENCES technologie (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE technology');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE technology (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE dev_technologie DROP FOREIGN KEY FK_8517239FA421F7B0');
        $this->addSql('ALTER TABLE dev_technologie DROP FOREIGN KEY FK_8517239F261A27D2');
        $this->addSql('DROP TABLE dev_technologie');
        $this->addSql('DROP TABLE technologie');
    }
}
