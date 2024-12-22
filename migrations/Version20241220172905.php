<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241220172905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526c9d86650f');
        $this->addSql('DROP INDEX idx_9474526c9d86650f');
        $this->addSql('ALTER TABLE comment RENAME COLUMN user_id_id TO user_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CA76ED395');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('ALTER TABLE comment RENAME COLUMN user_id TO user_id_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526c9d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_9474526c9d86650f ON comment (user_id_id)');
    }
}
