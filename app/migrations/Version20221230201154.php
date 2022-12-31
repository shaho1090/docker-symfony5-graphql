<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221230201154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delayed_order_queue DROP FOREIGN KEY FK_4518370F3414710B');
        $this->addSql('DROP INDEX IDX_4518370F3414710B ON delayed_order_queue');
        $this->addSql('ALTER TABLE delayed_order_queue DROP agent_id, DROP state, DROP description');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delayed_order_queue ADD agent_id INT DEFAULT NULL, ADD state VARCHAR(255) NOT NULL, ADD description VARCHAR(1000) DEFAULT NULL');
        $this->addSql('ALTER TABLE delayed_order_queue ADD CONSTRAINT FK_4518370F3414710B FOREIGN KEY (agent_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4518370F3414710B ON delayed_order_queue (agent_id)');
    }
}
