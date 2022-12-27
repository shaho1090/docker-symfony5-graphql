<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227161809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delay_report (id INT AUTO_INCREMENT NOT NULL, reporter_id INT NOT NULL, request_id INT NOT NULL, agent_id INT DEFAULT NULL, vendor_id INT NOT NULL, status VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_E2AE1FB9E1CFE6F5 (reporter_id), INDEX IDX_E2AE1FB9427EB8A5 (request_id), INDEX IDX_E2AE1FB93414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, vendor_id INT NOT NULL, delivery_time INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', description LONGTEXT DEFAULT NULL, INDEX IDX_F52993987E3C61F9 (owner_id), INDEX IDX_F5299398F603EE73 (vendor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, courier_id INT NOT NULL, request_id INT NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_7656F53BE3D8151C (courier_id), UNIQUE INDEX UNIQ_7656F53B427EB8A5 (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, family VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, address LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delay_report ADD CONSTRAINT FK_E2AE1FB9E1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE delay_report ADD CONSTRAINT FK_E2AE1FB9427EB8A5 FOREIGN KEY (request_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE delay_report ADD CONSTRAINT FK_E2AE1FB93414710B FOREIGN KEY (agent_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993987E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BE3D8151C FOREIGN KEY (courier_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B427EB8A5 FOREIGN KEY (request_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE trips DROP FOREIGN KEY FK_AA7370DA427EB8A5');
        $this->addSql('ALTER TABLE trips DROP FOREIGN KEY FK_AA7370DAE3D8151C');
        $this->addSql('ALTER TABLE delay_reports DROP FOREIGN KEY FK_A9516A3C3414710B');
        $this->addSql('ALTER TABLE delay_reports DROP FOREIGN KEY FK_A9516A3C427EB8A5');
        $this->addSql('ALTER TABLE delay_reports DROP FOREIGN KEY FK_A9516A3CE1CFE6F5');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE7E3C61F9');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEF603EE73');
        $this->addSql('DROP TABLE trips');
        $this->addSql('DROP TABLE delay_reports');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE vendors');
        $this->addSql('DROP TABLE orders');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trips (id INT AUTO_INCREMENT NOT NULL, courier_id INT NOT NULL, request_id INT NOT NULL, state VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_AA7370DA427EB8A5 (request_id), INDEX IDX_AA7370DAE3D8151C (courier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE delay_reports (id INT AUTO_INCREMENT NOT NULL, reporter_id INT NOT NULL, request_id INT NOT NULL, agent_id INT DEFAULT NULL, vendor_id INT NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_A9516A3CE1CFE6F5 (reporter_id), INDEX IDX_A9516A3C427EB8A5 (request_id), INDEX IDX_A9516A3C3414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, family VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, phone VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE vendors (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, address LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, vendor_id INT NOT NULL, delivery_time INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_E52FFDEE7E3C61F9 (owner_id), INDEX IDX_E52FFDEEF603EE73 (vendor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DA427EB8A5 FOREIGN KEY (request_id) REFERENCES orders (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DAE3D8151C FOREIGN KEY (courier_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE delay_reports ADD CONSTRAINT FK_A9516A3C3414710B FOREIGN KEY (agent_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE delay_reports ADD CONSTRAINT FK_A9516A3C427EB8A5 FOREIGN KEY (request_id) REFERENCES orders (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE delay_reports ADD CONSTRAINT FK_A9516A3CE1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendors (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE delay_report DROP FOREIGN KEY FK_E2AE1FB9E1CFE6F5');
        $this->addSql('ALTER TABLE delay_report DROP FOREIGN KEY FK_E2AE1FB9427EB8A5');
        $this->addSql('ALTER TABLE delay_report DROP FOREIGN KEY FK_E2AE1FB93414710B');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993987E3C61F9');
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
