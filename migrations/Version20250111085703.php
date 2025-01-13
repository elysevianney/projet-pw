<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250111085703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company_dev (company_id INT NOT NULL, dev_id INT NOT NULL, INDEX IDX_1580756D979B1AD6 (company_id), INDEX IDX_1580756DA421F7B0 (dev_id), PRIMARY KEY(company_id, dev_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_dev ADD CONSTRAINT FK_1580756D979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_dev ADD CONSTRAINT FK_1580756DA421F7B0 FOREIGN KEY (dev_id) REFERENCES dev (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_dev DROP FOREIGN KEY FK_1580756D979B1AD6');
        $this->addSql('ALTER TABLE company_dev DROP FOREIGN KEY FK_1580756DA421F7B0');
        $this->addSql('DROP TABLE company_dev');
    }
}
