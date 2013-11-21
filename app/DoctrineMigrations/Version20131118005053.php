<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131118005053 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP INDEX UNIQ_7ADAAB3CE7927C74 ON demo_user");
        $this->addSql("ALTER TABLE demo_user ADD is_admin TINYINT(1) NOT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE demo_user DROP is_admin, CHANGE email email VARCHAR(255) NOT NULL");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_7ADAAB3CE7927C74 ON demo_user (email)");
    }
}
