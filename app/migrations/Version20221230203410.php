<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221230203410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delayed_order (id INT AUTO_INCREMENT NOT NULL, request_id INT NOT NULL, delay_report_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, state VARCHAR(255) NOT NULL, description VARCHAR(1000) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_6005EBE3427EB8A5 (request_id), UNIQUE INDEX UNIQ_6005EBE350FA803C (delay_report_id), INDEX IDX_6005EBE33414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delayed_order ADD CONSTRAINT FK_6005EBE3427EB8A5 FOREIGN KEY (request_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE delayed_order ADD CONSTRAINT FK_6005EBE350FA803C FOREIGN KEY (delay_report_id) REFERENCES delay_report (id)');
        $this->addSql('ALTER TABLE delayed_order ADD CONSTRAINT FK_6005EBE33414710B FOREIGN KEY (agent_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE delayed_order_queue DROP FOREIGN KEY FK_4518370F427EB8A5');
        $this->addSql('ALTER TABLE delayed_order_queue DROP FOREIGN KEY FK_4518370F50FA803C');
        $this->addSql('DROP TABLE delayed_order_queue');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delayed_order_queue (id INT AUTO_INCREMENT NOT NULL, request_id INT NOT NULL, delay_report_id INT DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_4518370F50FA803C (delay_report_id), INDEX IDX_4518370F427EB8A5 (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE delayed_order_queue ADD CONSTRAINT FK_4518370F427EB8A5 FOREIGN KEY (request_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE delayed_order_queue ADD CONSTRAINT FK_4518370F50FA803C FOREIGN KEY (delay_report_id) REFERENCES delay_report (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE delayed_order DROP FOREIGN KEY FK_6005EBE3427EB8A5');
        $this->addSql('ALTER TABLE delayed_order DROP FOREIGN KEY FK_6005EBE350FA803C');
        $this->addSql('ALTER TABLE delayed_order DROP FOREIGN KEY FK_6005EBE33414710B');
        $this->addSql('DROP TABLE delayed_order');
    }
}
