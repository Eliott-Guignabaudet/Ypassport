<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321161328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_sub_skill (user_id INT NOT NULL, sub_skill_id INT NOT NULL, INDEX IDX_B2990D2AA76ED395 (user_id), INDEX IDX_B2990D2AEF2A2F1B (sub_skill_id), PRIMARY KEY(user_id, sub_skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_sub_skill ADD CONSTRAINT FK_B2990D2AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_sub_skill ADD CONSTRAINT FK_B2990D2AEF2A2F1B FOREIGN KEY (sub_skill_id) REFERENCES sub_skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_sub_skill DROP FOREIGN KEY FK_B2990D2AA76ED395');
        $this->addSql('ALTER TABLE user_sub_skill DROP FOREIGN KEY FK_B2990D2AEF2A2F1B');
        $this->addSql('DROP TABLE user_sub_skill');
    }
}
