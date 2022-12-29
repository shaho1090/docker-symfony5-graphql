<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221229082415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delay_report CHANGE vendor_id vendor_id INT NULL');
        $this->addSql('ALTER TABLE delay_report ADD CONSTRAINT FK_E2AE1FB9F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('CREATE INDEX IDX_E2AE1FB9F603EE73 ON delay_report (vendor_id)');
        $this->addSql('ALTER TABLE `order` ADD be_delivered_at DATETIME DEFAULT NULL, ADD delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delay_report DROP FOREIGN KEY FK_E2AE1FB9F603EE73');
        $this->addSql('DROP INDEX IDX_E2AE1FB9F603EE73 ON delay_report');
        $this->addSql('ALTER TABLE delay_report CHANGE vendor_id vendor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` DROP be_delivered_at, DROP delivered_at');
    }
}
