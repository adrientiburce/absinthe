<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190326190636 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course_favorites CHANGE course_id course_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course_category CHANGE semester semester VARCHAR(255) DEFAULT NULL, CHANGE promotion promotion VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE course_document CHANGE author_id author_id INT DEFAULT NULL, CHANGE label_id label_id INT DEFAULT NULL, CHANGE number_of_uploads number_of_uploads INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE pseudo pseudo VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE course CHANGE course_category_id course_category_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE duration duration TIME DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course CHANGE course_category_id course_category_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE duration duration TIME DEFAULT \'NULL\', CHANGE created_at created_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE course_category CHANGE semester semester VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE promotion promotion VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE course_document CHANGE author_id author_id INT DEFAULT NULL, CHANGE label_id label_id INT DEFAULT NULL, CHANGE number_of_uploads number_of_uploads INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course_favorites CHANGE course_id course_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE pseudo pseudo VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
