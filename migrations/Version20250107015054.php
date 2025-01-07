<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107015054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company_critere (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, minimum_salary INT DEFAULT NULL, maximum_salary INT DEFAULT NULL, experience INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_5F389A84979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_critere_techno (company_critere_id INT NOT NULL, techno_id INT NOT NULL, INDEX IDX_22F1E2823D1AC3D (company_critere_id), INDEX IDX_22F1E2851F3C1BC (techno_id), PRIMARY KEY(company_critere_id, techno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_critere ADD CONSTRAINT FK_5F389A84979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_critere_techno ADD CONSTRAINT FK_22F1E2823D1AC3D FOREIGN KEY (company_critere_id) REFERENCES company_critere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_critere_techno ADD CONSTRAINT FK_22F1E2851F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_critere DROP FOREIGN KEY FK_5F389A84979B1AD6');
        $this->addSql('ALTER TABLE company_critere_techno DROP FOREIGN KEY FK_22F1E2823D1AC3D');
        $this->addSql('ALTER TABLE company_critere_techno DROP FOREIGN KEY FK_22F1E2851F3C1BC');
        $this->addSql('DROP TABLE company_critere');
        $this->addSql('DROP TABLE company_critere_techno');
    }
}
