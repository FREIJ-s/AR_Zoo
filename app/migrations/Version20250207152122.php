<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207152122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_animal ADD veterinary_id INT NOT NULL, ADD animal_id INT NOT NULL, ADD status VARCHAR(100) NOT NULL, ADD food VARCHAR(255) NOT NULL, ADD weight NUMERIC(10, 2) NOT NULL, ADD date_passage DATE NOT NULL');
        $this->addSql('ALTER TABLE info_animal ADD CONSTRAINT FK_A7767C49D954EB99 FOREIGN KEY (veterinary_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_animal ADD CONSTRAINT FK_A7767C498E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_A7767C49D954EB99 ON info_animal (veterinary_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A7767C498E962C16 ON info_animal (animal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_animal DROP FOREIGN KEY FK_A7767C49D954EB99');
        $this->addSql('ALTER TABLE info_animal DROP FOREIGN KEY FK_A7767C498E962C16');
        $this->addSql('DROP INDEX IDX_A7767C49D954EB99 ON info_animal');
        $this->addSql('DROP INDEX UNIQ_A7767C498E962C16 ON info_animal');
        $this->addSql('ALTER TABLE info_animal DROP veterinary_id, DROP animal_id, DROP status, DROP food, DROP weight, DROP date_passage');
    }
}
