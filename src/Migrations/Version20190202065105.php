<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190202065105 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, gender SMALLINT NOT NULL, birth_date DATETIME NOT NULL, email VARCHAR(50) NOT NULL, login VARCHAR(40) NOT NULL, password VARCHAR(40) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE driver (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT DEFAULT NULL, name VARCHAR(45) NOT NULL, birth_date DATETIME NOT NULL, email VARCHAR(50) NOT NULL, phone VARCHAR(40) NOT NULL, avatar VARCHAR(50) NOT NULL, INDEX IDX_11667CD9545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT DEFAULT NULL, code VARCHAR(50) NOT NULL, start_time_operation TIME NOT NULL, end_time_operation TIME NOT NULL, type VARCHAR(30) NOT NULL, map VARCHAR(50) NOT NULL, INDEX IDX_D114B4F6545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, line_id INT DEFAULT NULL, name VARCHAR(80) NOT NULL, position_station VARCHAR(15) NOT NULL, INDEX IDX_9F39F8B14D7B7542 (line_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, type VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE driver ADD CONSTRAINT FK_11667CD9545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE line ADD CONSTRAINT FK_D114B4F6545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B14D7B7542 FOREIGN KEY (line_id) REFERENCES line (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B14D7B7542');
        $this->addSql('ALTER TABLE driver DROP FOREIGN KEY FK_11667CD9545317D1');
        $this->addSql('ALTER TABLE line DROP FOREIGN KEY FK_D114B4F6545317D1');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE driver');
        $this->addSql('DROP TABLE line');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE vehicle');
    }
}
