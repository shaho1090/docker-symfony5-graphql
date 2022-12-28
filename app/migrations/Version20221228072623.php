<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228072623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BA2E33CBF');
        $this->addSql('DROP INDEX IDX_7656F53BA2E33CBF ON trip');
        $this->addSql('ALTER TABLE trip CHANGE ccourier_id courier_id INT NOT NULL');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BE3D8151C FOREIGN KEY (courier_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7656F53BE3D8151C ON trip (courier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BE3D8151C');
        $this->addSql('DROP INDEX IDX_7656F53BE3D8151C ON trip');
        $this->addSql('ALTER TABLE trip CHANGE courier_id ccourier_id INT NOT NULL');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BA2E33CBF FOREIGN KEY (ccourier_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_7656F53BA2E33CBF ON trip (ccourier_id)');
    }
}
