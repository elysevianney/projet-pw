<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109014255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dev_critere ADD deev_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dev_critere ADD CONSTRAINT FK_51FD9F7A3C2A323E FOREIGN KEY (deev_id) REFERENCES dev (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_51FD9F7A3C2A323E ON dev_critere (deev_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dev_critere DROP FOREIGN KEY FK_51FD9F7A3C2A323E');
        $this->addSql('DROP INDEX UNIQ_51FD9F7A3C2A323E ON dev_critere');
        $this->addSql('ALTER TABLE dev_critere DROP deev_id');
    }
}
