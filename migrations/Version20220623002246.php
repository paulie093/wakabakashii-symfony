<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623002246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, online_host_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, title_jap_romaji VARCHAR(200) NOT NULL, title_jap_kanji VARCHAR(200) NOT NULL, episode_number INT NOT NULL, upload_date DATE DEFAULT NULL, download_url LONGTEXT DEFAULT NULL, online_embed_id VARCHAR(255) DEFAULT NULL, INDEX IDX_DDAA1CDA166D1F9C (project_id), INDEX IDX_DDAA1CDA2E2E027B (online_host_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, fansub_team_id INT NOT NULL, nickname VARCHAR(50) NOT NULL, INDEX IDX_70E4FA788A913423 (fansub_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, author_id INT NOT NULL, title VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1DD39950166D1F9C (project_id), INDEX IDX_1DD39950F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE online_host (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, project_video_quality_id INT NOT NULL, project_status_id INT NOT NULL, project_type_id INT NOT NULL, title VARCHAR(100) NOT NULL, title_jap VARCHAR(100) DEFAULT NULL, token VARCHAR(50) NOT NULL, start_year INT NOT NULL, end_year INT DEFAULT NULL, episode_number INT NOT NULL, official_site_url VARCHAR(255) DEFAULT NULL, anime_news_network_id INT DEFAULT NULL, ani_db_id INT DEFAULT NULL, my_anime_list_id INT DEFAULT NULL, release_resolution VARCHAR(20) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2FB3D0EE81DEB688 (project_video_quality_id), INDEX IDX_2FB3D0EE7ACB456A (project_status_id), INDEX IDX_2FB3D0EE535280F6 (project_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_team (project_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_FD716E07166D1F9C (project_id), INDEX IDX_FD716E07296CD8AE (team_id), PRIMARY KEY(project_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_status (id INT AUTO_INCREMENT NOT NULL, token VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_type (id INT AUTO_INCREMENT NOT NULL, token VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_video_quality (id INT AUTO_INCREMENT NOT NULL, token VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, token VARCHAR(40) NOT NULL, short_name VARCHAR(10) NOT NULL, website_url VARCHAR(200) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA2E2E027B FOREIGN KEY (online_host_id) REFERENCES online_host (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA788A913423 FOREIGN KEY (fansub_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE81DEB688 FOREIGN KEY (project_video_quality_id) REFERENCES project_video_quality (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE7ACB456A FOREIGN KEY (project_status_id) REFERENCES project_status (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE535280F6 FOREIGN KEY (project_type_id) REFERENCES project_type (id)');
        $this->addSql('ALTER TABLE project_team ADD CONSTRAINT FK_FD716E07166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_team ADD CONSTRAINT FK_FD716E07296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA2E2E027B');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA166D1F9C');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950166D1F9C');
        $this->addSql('ALTER TABLE project_team DROP FOREIGN KEY FK_FD716E07166D1F9C');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE7ACB456A');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE535280F6');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE81DEB688');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA788A913423');
        $this->addSql('ALTER TABLE project_team DROP FOREIGN KEY FK_FD716E07296CD8AE');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950F675F31B');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE online_host');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_team');
        $this->addSql('DROP TABLE project_status');
        $this->addSql('DROP TABLE project_type');
        $this->addSql('DROP TABLE project_video_quality');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
