<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221229211133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delay_report DROP FOREIGN KEY FK_E2AE1FB93414710B');
        $this->addSql('DROP INDEX IDX_E2AE1FB93414710B ON delay_report');
        $this->addSql('ALTER TABLE delay_report DROP agent_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delay_report ADD agent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE delay_report ADD CONSTRAINT FK_E2AE1FB93414710B FOREIGN KEY (agent_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E2AE1FB93414710B ON delay_report (agent_id)');
    }
}
