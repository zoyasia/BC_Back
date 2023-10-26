<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231026144507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_23A0E6612469DE2 ON article (category_id)');
        $this->addSql('ALTER TABLE selection ADD orders_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE selection ADD CONSTRAINT FK_96A50CD7CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_96A50CD7CFFE9AD6 ON selection (orders_id)');
        $this->addSql('ALTER TABLE user ADD city VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6612469DE2');
        $this->addSql('DROP INDEX IDX_23A0E6612469DE2 ON article');
        $this->addSql('ALTER TABLE article DROP category_id');
        $this->addSql('ALTER TABLE selection DROP FOREIGN KEY FK_96A50CD7CFFE9AD6');
        $this->addSql('DROP INDEX IDX_96A50CD7CFFE9AD6 ON selection');
        $this->addSql('ALTER TABLE selection DROP orders_id');
        $this->addSql('ALTER TABLE user DROP city');
    }
}
