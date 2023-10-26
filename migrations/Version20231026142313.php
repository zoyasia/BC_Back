<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231026142313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE selection (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, service_id INT DEFAULT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_96A50CD77294869C (article_id), INDEX IDX_96A50CD7ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE selection ADD CONSTRAINT FK_96A50CD77294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE selection ADD CONSTRAINT FK_96A50CD7ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE selection DROP FOREIGN KEY FK_96A50CD77294869C');
        $this->addSql('ALTER TABLE selection DROP FOREIGN KEY FK_96A50CD7ED5CA9E6');
        $this->addSql('DROP TABLE selection');
    }
}
