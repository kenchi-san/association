<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181230004612 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92C06A9F55');
        $this->addSql('DROP INDEX UNIQ_47CC8C92C06A9F55 ON action');
        $this->addSql('ALTER TABLE action CHANGE img_id image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C923DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_47CC8C923DA5256D ON action (image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C923DA5256D');
        $this->addSql('DROP INDEX UNIQ_47CC8C923DA5256D ON action');
        $this->addSql('ALTER TABLE action CHANGE image_id img_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92C06A9F55 FOREIGN KEY (img_id) REFERENCES images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_47CC8C92C06A9F55 ON action (img_id)');
    }
}
