<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221229145000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trip_state DROP FOREIGN KEY FK_79D852B8427EB8A5');
        $this->addSql('DROP INDEX IDX_79D852B8427EB8A5 ON trip_state');
        $this->addSql('ALTER TABLE trip_state DROP request_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trip_state ADD request_id INT NOT NULL');
        $this->addSql('ALTER TABLE trip_state ADD CONSTRAINT FK_79D852B8427EB8A5 FOREIGN KEY (request_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_79D852B8427EB8A5 ON trip_state (request_id)');
    }
}
