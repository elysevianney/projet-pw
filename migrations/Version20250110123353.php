<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110123353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, adress VARCHAR(255) DEFAULT NULL, postal_code INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, biography LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_4FBF094FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_critere (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, minimum_salary INT DEFAULT NULL, maximum_salary INT DEFAULT NULL, experience INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_5F389A84979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_critere_techno (company_critere_id INT NOT NULL, techno_id INT NOT NULL, INDEX IDX_22F1E2823D1AC3D (company_critere_id), INDEX IDX_22F1E2851F3C1BC (techno_id), PRIMARY KEY(company_critere_id, techno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dev (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, adress VARCHAR(255) DEFAULT NULL, postal_code INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, experience INT DEFAULT NULL, minimum_salay INT DEFAULT NULL, biography LONGTEXT DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, count_view INT NOT NULL, public_profile TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_1173F105A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dev_technologie (dev_id INT NOT NULL, technologie_id INT NOT NULL, INDEX IDX_8517239FA421F7B0 (dev_id), INDEX IDX_8517239F261A27D2 (technologie_id), PRIMARY KEY(dev_id, technologie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dev_techno (dev_id INT NOT NULL, techno_id INT NOT NULL, INDEX IDX_1A9546A1A421F7B0 (dev_id), INDEX IDX_1A9546A151F3C1BC (techno_id), PRIMARY KEY(dev_id, techno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dev_technology (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dev_technology_dev (dev_technology_id INT NOT NULL, dev_id INT NOT NULL, INDEX IDX_253073AC92623239 (dev_technology_id), INDEX IDX_253073ACA421F7B0 (dev_id), PRIMARY KEY(dev_technology_id, dev_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dev_technology_technologie (dev_technology_id INT NOT NULL, technologie_id INT NOT NULL, INDEX IDX_DA67578C92623239 (dev_technology_id), INDEX IDX_DA67578C261A27D2 (technologie_id), PRIMARY KEY(dev_technology_id, technologie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, experience INT NOT NULL, salary INT NOT NULL, description LONGTEXT NOT NULL, relation VARCHAR(255) DEFAULT NULL, INDEX IDX_5A8A6C8DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_techno (post_id INT NOT NULL, techno_id INT NOT NULL, INDEX IDX_9A50AB94B89032C (post_id), INDEX IDX_9A50AB951F3C1BC (techno_id), PRIMARY KEY(post_id, techno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE techno (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technologie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE company_critere ADD CONSTRAINT FK_5F389A84979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_critere_techno ADD CONSTRAINT FK_22F1E2823D1AC3D FOREIGN KEY (company_critere_id) REFERENCES company_critere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_critere_techno ADD CONSTRAINT FK_22F1E2851F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev ADD CONSTRAINT FK_1173F105A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE dev_technologie ADD CONSTRAINT FK_8517239FA421F7B0 FOREIGN KEY (dev_id) REFERENCES dev (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_technologie ADD CONSTRAINT FK_8517239F261A27D2 FOREIGN KEY (technologie_id) REFERENCES technologie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_techno ADD CONSTRAINT FK_1A9546A1A421F7B0 FOREIGN KEY (dev_id) REFERENCES dev (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_techno ADD CONSTRAINT FK_1A9546A151F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_technology_dev ADD CONSTRAINT FK_253073AC92623239 FOREIGN KEY (dev_technology_id) REFERENCES dev_technology (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_technology_dev ADD CONSTRAINT FK_253073ACA421F7B0 FOREIGN KEY (dev_id) REFERENCES dev (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_technology_technologie ADD CONSTRAINT FK_DA67578C92623239 FOREIGN KEY (dev_technology_id) REFERENCES dev_technology (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dev_technology_technologie ADD CONSTRAINT FK_DA67578C261A27D2 FOREIGN KEY (technologie_id) REFERENCES technologie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE post_techno ADD CONSTRAINT FK_9A50AB94B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_techno ADD CONSTRAINT FK_9A50AB951F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FA76ED395');
        $this->addSql('ALTER TABLE company_critere DROP FOREIGN KEY FK_5F389A84979B1AD6');
        $this->addSql('ALTER TABLE company_critere_techno DROP FOREIGN KEY FK_22F1E2823D1AC3D');
        $this->addSql('ALTER TABLE company_critere_techno DROP FOREIGN KEY FK_22F1E2851F3C1BC');
        $this->addSql('ALTER TABLE dev DROP FOREIGN KEY FK_1173F105A76ED395');
        $this->addSql('ALTER TABLE dev_technologie DROP FOREIGN KEY FK_8517239FA421F7B0');
        $this->addSql('ALTER TABLE dev_technologie DROP FOREIGN KEY FK_8517239F261A27D2');
        $this->addSql('ALTER TABLE dev_techno DROP FOREIGN KEY FK_1A9546A1A421F7B0');
        $this->addSql('ALTER TABLE dev_techno DROP FOREIGN KEY FK_1A9546A151F3C1BC');
        $this->addSql('ALTER TABLE dev_technology_dev DROP FOREIGN KEY FK_253073AC92623239');
        $this->addSql('ALTER TABLE dev_technology_dev DROP FOREIGN KEY FK_253073ACA421F7B0');
        $this->addSql('ALTER TABLE dev_technology_technologie DROP FOREIGN KEY FK_DA67578C92623239');
        $this->addSql('ALTER TABLE dev_technology_technologie DROP FOREIGN KEY FK_DA67578C261A27D2');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE post_techno DROP FOREIGN KEY FK_9A50AB94B89032C');
        $this->addSql('ALTER TABLE post_techno DROP FOREIGN KEY FK_9A50AB951F3C1BC');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE company_critere');
        $this->addSql('DROP TABLE company_critere_techno');
        $this->addSql('DROP TABLE dev');
        $this->addSql('DROP TABLE dev_technologie');
        $this->addSql('DROP TABLE dev_techno');
        $this->addSql('DROP TABLE dev_technology');
        $this->addSql('DROP TABLE dev_technology_dev');
        $this->addSql('DROP TABLE dev_technology_technologie');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_techno');
        $this->addSql('DROP TABLE techno');
        $this->addSql('DROP TABLE technologie');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
