<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240127151159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) DEFAULT NULL, resume VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bloc (id INT AUTO_INCREMENT NOT NULL, type_bloc_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, contenu VARCHAR(255) DEFAULT NULL, notable TINYINT(1) DEFAULT NULL, file_path VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C778955A7DA38635 (type_bloc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bloc_article (bloc_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_B320E2E95582E9C0 (bloc_id), INDEX IDX_B320E2E97294869C (article_id), PRIMARY KEY(bloc_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, bloc_id INT DEFAULT NULL, contenu VARCHAR(255) DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, INDEX IDX_67F068BCA76ED395 (user_id), INDEX IDX_67F068BC5582E9C0 (bloc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_set (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, json_path VARCHAR(255) DEFAULT NULL, INDEX IDX_A298C469F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, INDEX IDX_140AB620F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_bloc (page_id INT NOT NULL, bloc_id INT NOT NULL, INDEX IDX_40BC8980C4663E4 (page_id), INDEX IDX_40BC89805582E9C0 (bloc_id), PRIMARY KEY(page_id, bloc_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_article (page_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_F85AE5F3C4663E4 (page_id), INDEX IDX_F85AE5F37294869C (article_id), PRIMARY KEY(page_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reaction (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, bloc_id INT DEFAULT NULL, note INT DEFAULT NULL, INDEX IDX_A4D707F7A76ED395 (user_id), INDEX IDX_A4D707F75582E9C0 (bloc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_9775E708F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bloc (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, info_bloc_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_site (user_id INT NOT NULL, site_id INT NOT NULL, INDEX IDX_13C2452DA76ED395 (user_id), INDEX IDX_13C2452DF6BD1646 (site_id), PRIMARY KEY(user_id, site_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bloc ADD CONSTRAINT FK_C778955A7DA38635 FOREIGN KEY (type_bloc_id) REFERENCES type_bloc (id)');
        $this->addSql('ALTER TABLE bloc_article ADD CONSTRAINT FK_B320E2E95582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bloc_article ADD CONSTRAINT FK_B320E2E97294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC5582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id)');
        $this->addSql('ALTER TABLE data_set ADD CONSTRAINT FK_A298C469F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE page_bloc ADD CONSTRAINT FK_40BC8980C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_bloc ADD CONSTRAINT FK_40BC89805582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_article ADD CONSTRAINT FK_F85AE5F3C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_article ADD CONSTRAINT FK_F85AE5F37294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F75582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id)');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E708F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE user_site ADD CONSTRAINT FK_13C2452DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_site ADD CONSTRAINT FK_13C2452DF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bloc DROP FOREIGN KEY FK_C778955A7DA38635');
        $this->addSql('ALTER TABLE bloc_article DROP FOREIGN KEY FK_B320E2E95582E9C0');
        $this->addSql('ALTER TABLE bloc_article DROP FOREIGN KEY FK_B320E2E97294869C');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC5582E9C0');
        $this->addSql('ALTER TABLE data_set DROP FOREIGN KEY FK_A298C469F6BD1646');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620F6BD1646');
        $this->addSql('ALTER TABLE page_bloc DROP FOREIGN KEY FK_40BC8980C4663E4');
        $this->addSql('ALTER TABLE page_bloc DROP FOREIGN KEY FK_40BC89805582E9C0');
        $this->addSql('ALTER TABLE page_article DROP FOREIGN KEY FK_F85AE5F3C4663E4');
        $this->addSql('ALTER TABLE page_article DROP FOREIGN KEY FK_F85AE5F37294869C');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F7A76ED395');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F75582E9C0');
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E708F6BD1646');
        $this->addSql('ALTER TABLE user_site DROP FOREIGN KEY FK_13C2452DA76ED395');
        $this->addSql('ALTER TABLE user_site DROP FOREIGN KEY FK_13C2452DF6BD1646');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE bloc');
        $this->addSql('DROP TABLE bloc_article');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE data_set');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_bloc');
        $this->addSql('DROP TABLE page_article');
        $this->addSql('DROP TABLE reaction');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE type_bloc');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_site');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
