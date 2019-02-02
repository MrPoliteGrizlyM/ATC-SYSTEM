<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190202070439 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE line DROP FOREIGN KEY FK_D114B4F6545317D1');
        $this->addSql('DROP INDEX IDX_D114B4F6545317D1 ON line');
        $this->addSql('ALTER TABLE line DROP vehicle_id');
        $this->addSql('ALTER TABLE vehicle ADD line_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4864D7B7542 FOREIGN KEY (line_id) REFERENCES line (id)');
        $this->addSql('CREATE INDEX IDX_1B80E4864D7B7542 ON vehicle (line_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE line ADD vehicle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line ADD CONSTRAINT FK_D114B4F6545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('CREATE INDEX IDX_D114B4F6545317D1 ON line (vehicle_id)');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4864D7B7542');
        $this->addSql('DROP INDEX IDX_1B80E4864D7B7542 ON vehicle');
        $this->addSql('ALTER TABLE vehicle DROP line_id');
    }
}
