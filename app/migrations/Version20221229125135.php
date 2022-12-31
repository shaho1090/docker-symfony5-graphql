<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221229125135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_trip_state (id INT AUTO_INCREMENT NOT NULL, request_id INT NOT NULL, trip_id INT NOT NULL, state VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_CA02AFED427EB8A5 (request_id), INDEX IDX_CA02AFEDA5BC2E0E (trip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_trip_state ADD CONSTRAINT FK_CA02AFED427EB8A5 FOREIGN KEY (request_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_trip_state ADD CONSTRAINT FK_CA02AFEDA5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_trip_state DROP FOREIGN KEY FK_CA02AFED427EB8A5');
        $this->addSql('ALTER TABLE order_trip_state DROP FOREIGN KEY FK_CA02AFEDA5BC2E0E');
        $this->addSql('DROP TABLE order_trip_state');
    }
}
