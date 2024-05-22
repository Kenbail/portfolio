<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515121932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formulaire (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_5BDD01A8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formulaire_questions (formulaire_id INT NOT NULL, questions_id INT NOT NULL, INDEX IDX_D67E752E5053569B (formulaire_id), INDEX IDX_D67E752EBCB134CE (questions_id), PRIMARY KEY(formulaire_id, questions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formulaire ADD CONSTRAINT FK_5BDD01A8A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE formulaire_questions ADD CONSTRAINT FK_D67E752E5053569B FOREIGN KEY (formulaire_id) REFERENCES formulaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formulaire_questions ADD CONSTRAINT FK_D67E752EBCB134CE FOREIGN KEY (questions_id) REFERENCES questions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponses ADD formulaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC65053569B FOREIGN KEY (formulaire_id) REFERENCES formulaire (id)');
        $this->addSql('CREATE INDEX IDX_1E512EC65053569B ON reponses (formulaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponses DROP FOREIGN KEY FK_1E512EC65053569B');
        $this->addSql('ALTER TABLE formulaire DROP FOREIGN KEY FK_5BDD01A8A76ED395');
        $this->addSql('ALTER TABLE formulaire_questions DROP FOREIGN KEY FK_D67E752E5053569B');
        $this->addSql('ALTER TABLE formulaire_questions DROP FOREIGN KEY FK_D67E752EBCB134CE');
        $this->addSql('DROP TABLE formulaire');
        $this->addSql('DROP TABLE formulaire_questions');
        $this->addSql('DROP INDEX IDX_1E512EC65053569B ON reponses');
        $this->addSql('ALTER TABLE reponses DROP formulaire_id');
    }
}
