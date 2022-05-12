<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417010338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commented (id_comment INT AUTO_INCREMENT NOT NULL, content TEXT NOT NULL, createdAt DATETIME DEFAULT NULL, state TEXT NOT NULL, userWhoCommented INT DEFAULT NULL, postCommented INT DEFAULT NULL, UNIQUE INDEX UNIQ_5FA1A85B35321851 (userWhoCommented), UNIQUE INDEX UNIQ_5FA1A85B4C7DE639 (postCommented), PRIMARY KEY(id_comment)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (idPost INT AUTO_INCREMENT NOT NULL, content TEXT NOT NULL, mediaURL TEXT DEFAULT NULL, createdAt DATETIME NOT NULL, categorie VARCHAR(20) NOT NULL, likeNum INT NOT NULL, state VARCHAR(15) DEFAULT \'Active\' NOT NULL, idOwer INT DEFAULT NULL, INDEX IDX_5A8A6C8DC6C397F0 (idOwer), PRIMARY KEY(idPost)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (cinUser INT AUTO_INCREMENT NOT NULL, email VARCHAR(50) NOT NULL, passwd VARCHAR(50) NOT NULL, createdAt DATETIME NOT NULL, imgURL TEXT NOT NULL, firstName VARCHAR(20) DEFAULT \'NULL\', lastName VARCHAR(20) DEFAULT \'NULL\', domaine VARCHAR(30) DEFAULT \'NULL\', departement VARCHAR(40) DEFAULT \'NULL\', typeClub VARCHAR(20) DEFAULT \'NULL\', class VARCHAR(20) DEFAULT \'NULL\', localisation VARCHAR(20) DEFAULT \'NULL\', entrepriseName VARCHAR(20) DEFAULT \'NULL\', role VARCHAR(20) NOT NULL, state VARCHAR(15) DEFAULT \'\'\'Active\'\'\' NOT NULL, PRIMARY KEY(cinUser)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (likeUser INT NOT NULL, likePost INT NOT NULL, INDEX IDX_AC6340B3C34CC264 (likeUser), INDEX IDX_AC6340B3145578A0 (likePost), PRIMARY KEY(likeUser, likePost)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commented ADD CONSTRAINT FK_5FA1A85B35321851 FOREIGN KEY (userWhoCommented) REFERENCES user (cinUser)');
        $this->addSql('ALTER TABLE commented ADD CONSTRAINT FK_5FA1A85B4C7DE639 FOREIGN KEY (postCommented) REFERENCES post (idPost)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DC6C397F0 FOREIGN KEY (idOwer) REFERENCES user (cinUser)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3C34CC264 FOREIGN KEY (likeUser) REFERENCES user (cinUser)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3145578A0 FOREIGN KEY (likePost) REFERENCES post (idPost)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commented DROP FOREIGN KEY FK_5FA1A85B4C7DE639');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3145578A0');
        $this->addSql('ALTER TABLE commented DROP FOREIGN KEY FK_5FA1A85B35321851');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DC6C397F0');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3C34CC264');
        $this->addSql('DROP TABLE commented');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE `like`');
    }
}
