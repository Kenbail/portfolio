<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515121313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_reponse (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, reponse_user VARCHAR(500) NOT NULL, INDEX IDX_7BBC0CDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_users (users_id INT NOT NULL, PRIMARY KEY(users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_reponse ADD CONSTRAINT FK_7BBC0CDA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_users ADD CONSTRAINT FK_F3F401A067B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5E4084792 FOREIGN KEY (reponses_id) REFERENCES reponses (id)');
        $this->addSql('CREATE INDEX IDX_8ADC54D5E4084792 ON questions (reponses_id)');
        $this->addSql('ALTER TABLE reponses CHANGE type_input type_input VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_reponse DROP FOREIGN KEY FK_7BBC0CDA76ED395');
        $this->addSql('ALTER TABLE users_users DROP FOREIGN KEY FK_F3F401A067B3B43D');
        $this->addSql('DROP TABLE user_reponse');
        $this->addSql('DROP TABLE users_users');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5E4084792');
        $this->addSql('DROP INDEX IDX_8ADC54D5E4084792 ON questions');
        $this->addSql('ALTER TABLE reponses CHANGE type_input type_input VARCHAR(255) DEFAULT NULL');
    }
}
