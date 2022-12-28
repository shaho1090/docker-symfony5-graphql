<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228085625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delay_report (id INT AUTO_INCREMENT NOT NULL, reporter_id INT NOT NULL, request_id INT NOT NULL, agent_id INT DEFAULT NULL, vendor_id INT NOT NULL, status VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_E2AE1FB9E1CFE6F5 (reporter_id), INDEX IDX_E2AE1FB9427EB8A5 (request_id), INDEX IDX_E2AE1FB93414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, vendor_id INT NOT NULL, delivery_time INT NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F52993989395C3F3 (customer_id), INDEX IDX_F5299398F603EE73 (vendor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, courier_id INT NOT NULL, request_id INT NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_7656F53BE3D8151C (courier_id), UNIQUE INDEX UNIQ_7656F53B427EB8A5 (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, family VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, address VARCHAR(1000) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delay_report ADD CONSTRAINT FK_E2AE1FB9E1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE delay_report ADD CONSTRAINT FK_E2AE1FB9427EB8A5 FOREIGN KEY (request_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE delay_report ADD CONSTRAINT FK_E2AE1FB93414710B FOREIGN KEY (agent_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BE3D8151C FOREIGN KEY (courier_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B427EB8A5 FOREIGN KEY (request_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delay_report DROP FOREIGN KEY FK_E2AE1FB9E1CFE6F5');
        $this->addSql('ALTER TABLE delay_report DROP FOREIGN KEY FK_E2AE1FB9427EB8A5');
        $this->addSql('ALTER TABLE delay_report DROP FOREIGN KEY FK_E2AE1FB93414710B');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F603EE73');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BE3D8151C');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B427EB8A5');
        $this->addSql('DROP TABLE delay_report');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vendor');
    }
}
