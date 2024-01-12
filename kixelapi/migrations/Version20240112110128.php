<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112110128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bloc_article (bloc_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_B320E2E95582E9C0 (bloc_id), INDEX IDX_B320E2E97294869C (article_id), PRIMARY KEY(bloc_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_bloc (page_id INT NOT NULL, bloc_id INT NOT NULL, INDEX IDX_40BC8980C4663E4 (page_id), INDEX IDX_40BC89805582E9C0 (bloc_id), PRIMARY KEY(page_id, bloc_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_article (page_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_F85AE5F3C4663E4 (page_id), INDEX IDX_F85AE5F37294869C (article_id), PRIMARY KEY(page_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_9775E708F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bloc_article ADD CONSTRAINT FK_B320E2E95582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bloc_article ADD CONSTRAINT FK_B320E2E97294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_bloc ADD CONSTRAINT FK_40BC8980C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_bloc ADD CONSTRAINT FK_40BC89805582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_article ADD CONSTRAINT FK_F85AE5F3C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_article ADD CONSTRAINT FK_F85AE5F37294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E708F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE bloc ADD type_bloc_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bloc ADD CONSTRAINT FK_C778955A7DA38635 FOREIGN KEY (type_bloc_id) REFERENCES type_bloc (id)');
        $this->addSql('CREATE INDEX IDX_C778955A7DA38635 ON bloc (type_bloc_id)');
        $this->addSql('ALTER TABLE commentaire ADD user_id INT DEFAULT NULL, ADD bloc_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC5582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCA76ED395 ON commentaire (user_id)');
        $this->addSql('CREATE INDEX IDX_67F068BC5582E9C0 ON commentaire (bloc_id)');
        $this->addSql('ALTER TABLE data_set ADD site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE data_set ADD CONSTRAINT FK_A298C469F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_A298C469F6BD1646 ON data_set (site_id)');
        $this->addSql('ALTER TABLE page ADD site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_140AB620F6BD1646 ON page (site_id)');
        $this->addSql('ALTER TABLE reaction ADD user_id INT DEFAULT NULL, ADD bloc_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F75582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id)');
        $this->addSql('CREATE INDEX IDX_A4D707F7A76ED395 ON reaction (user_id)');
        $this->addSql('CREATE INDEX IDX_A4D707F75582E9C0 ON reaction (bloc_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bloc_article DROP FOREIGN KEY FK_B320E2E95582E9C0');
        $this->addSql('ALTER TABLE bloc_article DROP FOREIGN KEY FK_B320E2E97294869C');
        $this->addSql('ALTER TABLE page_bloc DROP FOREIGN KEY FK_40BC8980C4663E4');
        $this->addSql('ALTER TABLE page_bloc DROP FOREIGN KEY FK_40BC89805582E9C0');
        $this->addSql('ALTER TABLE page_article DROP FOREIGN KEY FK_F85AE5F3C4663E4');
        $this->addSql('ALTER TABLE page_article DROP FOREIGN KEY FK_F85AE5F37294869C');
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E708F6BD1646');
        $this->addSql('DROP TABLE bloc_article');
        $this->addSql('DROP TABLE page_bloc');
        $this->addSql('DROP TABLE page_article');
        $this->addSql('DROP TABLE theme');
        $this->addSql('ALTER TABLE bloc DROP FOREIGN KEY FK_C778955A7DA38635');
        $this->addSql('DROP INDEX IDX_C778955A7DA38635 ON bloc');
        $this->addSql('ALTER TABLE bloc DROP type_bloc_id');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC5582E9C0');
        $this->addSql('DROP INDEX IDX_67F068BCA76ED395 ON commentaire');
        $this->addSql('DROP INDEX IDX_67F068BC5582E9C0 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP user_id, DROP bloc_id');
        $this->addSql('ALTER TABLE data_set DROP FOREIGN KEY FK_A298C469F6BD1646');
        $this->addSql('DROP INDEX IDX_A298C469F6BD1646 ON data_set');
        $this->addSql('ALTER TABLE data_set DROP site_id');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620F6BD1646');
        $this->addSql('DROP INDEX IDX_140AB620F6BD1646 ON page');
        $this->addSql('ALTER TABLE page DROP site_id');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F7A76ED395');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F75582E9C0');
        $this->addSql('DROP INDEX IDX_A4D707F7A76ED395 ON reaction');
        $this->addSql('DROP INDEX IDX_A4D707F75582E9C0 ON reaction');
        $this->addSql('ALTER TABLE reaction DROP user_id, DROP bloc_id');
    }
}
