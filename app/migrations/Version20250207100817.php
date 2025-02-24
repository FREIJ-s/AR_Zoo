<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207100817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_animal ADD animal_id INT NOT NULL, ADD label VARCHAR(255) NOT NULL, ADD url LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE image_animal ADD CONSTRAINT FK_C5B67DD78E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_C5B67DD78E962C16 ON image_animal (animal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_animal DROP FOREIGN KEY FK_C5B67DD78E962C16');
        $this->addSql('DROP INDEX IDX_C5B67DD78E962C16 ON image_animal');
        $this->addSql('ALTER TABLE image_animal DROP animal_id, DROP label, DROP url');
    }
}
