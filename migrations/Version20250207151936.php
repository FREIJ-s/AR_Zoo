<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207151936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_habitat ADD habitat_id INT NOT NULL, ADD label VARCHAR(255) NOT NULL, ADD url LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE image_habitat ADD CONSTRAINT FK_AE27E534AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_AE27E534AFFE2D26 ON image_habitat (habitat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_habitat DROP FOREIGN KEY FK_AE27E534AFFE2D26');
        $this->addSql('DROP INDEX IDX_AE27E534AFFE2D26 ON image_habitat');
        $this->addSql('ALTER TABLE image_habitat DROP habitat_id, DROP label, DROP url');
    }
}
