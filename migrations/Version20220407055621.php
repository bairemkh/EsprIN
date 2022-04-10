<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220407055621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs


        $this->addSql('ALTER TABLE post CHANGE createdAt createdAt DATETIME ');

        $this->addSql('ALTER TABLE user CHANGE cinUser cinUser INT AUTO_INCREMENT NOT NULL, CHANGE createdAt createdAt DATETIME NOT NULL, CHANGE firstName firstName VARCHAR(20) DEFAULT \'NULL\', CHANGE lastName lastName VARCHAR(20) DEFAULT \'NULL\', CHANGE domaine domaine VARCHAR(30) DEFAULT \'NULL\', CHANGE departement departement VARCHAR(40) DEFAULT \'NULL\', CHANGE typeClub typeClub VARCHAR(20) DEFAULT \'NULL\', CHANGE class class VARCHAR(20) DEFAULT \'NULL\', CHANGE localisation localisation VARCHAR(20) DEFAULT \'NULL\', CHANGE entrepriseName entrepriseName VARCHAR(20) DEFAULT \'NULL\', CHANGE state state VARCHAR(15) DEFAULT \'\'\'Active\'\'\' NOT NULL');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY Fk post liked');
        $this->addSql('ALTER TABLE `like` DROP createdAt');
        $this->addSql('DROP INDEX fk post liked ON `like`');
        $this->addSql('CREATE INDEX IDX_AC6340B3145578A0 ON `like` (likePost)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT Fk post liked FOREIGN KEY (likePost) REFERENCES post (idPost)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3145578A0');
        $this->addSql('ALTER TABLE `like` ADD createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('DROP INDEX idx_ac6340b3145578a0 ON `like`');
        $this->addSql('CREATE INDEX FK post liked ON `like` (likePost)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3145578A0 FOREIGN KEY (likePost) REFERENCES post (idPost)');
        $this->addSql('ALTER TABLE post CHANGE createdAt createdAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE cinUser cinUser INT NOT NULL, CHANGE createdAt createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE firstName firstName VARCHAR(20) DEFAULT NULL, CHANGE lastName lastName VARCHAR(20) DEFAULT NULL, CHANGE domaine domaine VARCHAR(30) DEFAULT NULL, CHANGE departement departement VARCHAR(40) DEFAULT NULL, CHANGE typeClub typeClub VARCHAR(20) DEFAULT NULL, CHANGE class class VARCHAR(20) DEFAULT NULL, CHANGE localisation localisation VARCHAR(20) DEFAULT NULL, CHANGE entrepriseName entrepriseName VARCHAR(20) DEFAULT NULL, CHANGE state state VARCHAR(15) DEFAULT \'Active\' NOT NULL');

    }
}
