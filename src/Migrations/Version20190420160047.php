<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190420160047 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE seo_descrition (id INT AUTO_INCREMENT NOT NULL, desciption VARCHAR(70) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seo_title (id INT AUTO_INCREMENT NOT NULL, description_id INT NOT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_DA1E4C39D9F966B (description_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE seo_title ADD CONSTRAINT FK_DA1E4C39D9F966B FOREIGN KEY (description_id) REFERENCES seo_descrition (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE seo_title DROP FOREIGN KEY FK_DA1E4C39D9F966B');
        $this->addSql('DROP TABLE seo_descrition');
        $this->addSql('DROP TABLE seo_title');
    }
}
