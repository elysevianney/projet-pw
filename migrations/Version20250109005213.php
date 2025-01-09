<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109005213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dev_critere (id INT AUTO_INCREMENT NOT NULL, dev_id INT DEFAULT NULL, minimum_salary INT DEFAULT NULL, maximum_salary INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, experience INT DEFAULT NULL, UNIQUE INDEX UNIQ_51FD9F7AA421F7B0 (dev_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dev_critere_techno (dev_critere_id INT NOT NULL, techno_id INT NOT NULL, INDEX IDX_A789DE87AF23093 (dev_critere_id), INDEX IDX_A789DE8751F3C1BC (techno_id), PRIMARY KEY(dev_critere_id, techno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dev_critere ADD CONSTRAINT FK_51FD9F7AA421F7B0 FOREIGN KEY (dev_id) REFERENCES dev (id)');
        $this->addSql('ALTER TABLE dev_critere_techno ADD CONSTRAINT FK_A789DE87AF23093 FOREIGN KEY (dev_critere_id) REFERENCES dev_critere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_critere_techno ADD CONSTRAINT FK_A789DE8751F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev ADD dev_critere_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dev ADD CONSTRAINT FK_1173F105AF23093 FOREIGN KEY (dev_critere_id) REFERENCES dev_critere (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1173F105AF23093 ON dev (dev_critere_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dev DROP FOREIGN KEY FK_1173F105AF23093');
        $this->addSql('ALTER TABLE dev_critere DROP FOREIGN KEY FK_51FD9F7AA421F7B0');
        $this->addSql('ALTER TABLE dev_critere_techno DROP FOREIGN KEY FK_A789DE87AF23093');
        $this->addSql('ALTER TABLE dev_critere_techno DROP FOREIGN KEY FK_A789DE8751F3C1BC');
        $this->addSql('DROP TABLE dev_critere');
        $this->addSql('DROP TABLE dev_critere_techno');
        $this->addSql('DROP INDEX UNIQ_1173F105AF23093 ON dev');
        $this->addSql('ALTER TABLE dev DROP dev_critere_id');
    }
}
