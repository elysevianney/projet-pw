<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250105043219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dev_techno (dev_id INT NOT NULL, techno_id INT NOT NULL, INDEX IDX_1A9546A1A421F7B0 (dev_id), INDEX IDX_1A9546A151F3C1BC (techno_id), PRIMARY KEY(dev_id, techno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dev_technology (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dev_technology_dev (dev_technology_id INT NOT NULL, dev_id INT NOT NULL, INDEX IDX_253073AC92623239 (dev_technology_id), INDEX IDX_253073ACA421F7B0 (dev_id), PRIMARY KEY(dev_technology_id, dev_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dev_technology_technologie (dev_technology_id INT NOT NULL, technologie_id INT NOT NULL, INDEX IDX_DA67578C92623239 (dev_technology_id), INDEX IDX_DA67578C261A27D2 (technologie_id), PRIMARY KEY(dev_technology_id, technologie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE techno (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dev_techno ADD CONSTRAINT FK_1A9546A1A421F7B0 FOREIGN KEY (dev_id) REFERENCES dev (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_techno ADD CONSTRAINT FK_1A9546A151F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_technology_dev ADD CONSTRAINT FK_253073AC92623239 FOREIGN KEY (dev_technology_id) REFERENCES dev_technology (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_technology_dev ADD CONSTRAINT FK_253073ACA421F7B0 FOREIGN KEY (dev_id) REFERENCES dev (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_technology_technologie ADD CONSTRAINT FK_DA67578C92623239 FOREIGN KEY (dev_technology_id) REFERENCES dev_technology (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_technology_technologie ADD CONSTRAINT FK_DA67578C261A27D2 FOREIGN KEY (technologie_id) REFERENCES technologie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dev_techno DROP FOREIGN KEY FK_1A9546A1A421F7B0');
        $this->addSql('ALTER TABLE dev_techno DROP FOREIGN KEY FK_1A9546A151F3C1BC');
        $this->addSql('ALTER TABLE dev_technology_dev DROP FOREIGN KEY FK_253073AC92623239');
        $this->addSql('ALTER TABLE dev_technology_dev DROP FOREIGN KEY FK_253073ACA421F7B0');
        $this->addSql('ALTER TABLE dev_technology_technologie DROP FOREIGN KEY FK_DA67578C92623239');
        $this->addSql('ALTER TABLE dev_technology_technologie DROP FOREIGN KEY FK_DA67578C261A27D2');
        $this->addSql('DROP TABLE dev_techno');
        $this->addSql('DROP TABLE dev_technology');
        $this->addSql('DROP TABLE dev_technology_dev');
        $this->addSql('DROP TABLE dev_technology_technologie');
        $this->addSql('DROP TABLE techno');
    }
}
