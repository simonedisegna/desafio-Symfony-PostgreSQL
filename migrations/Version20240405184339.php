<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405184339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empresa ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE socio ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE socio ALTER empresa_id DROP NOT NULL');
        $this->addSql('ALTER TABLE usuarios ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE empresa_id_seq');
        $this->addSql('SELECT setval(\'empresa_id_seq\', (SELECT MAX(id) FROM empresa))');
        $this->addSql('ALTER TABLE empresa ALTER id SET DEFAULT nextval(\'empresa_id_seq\')');
        $this->addSql('CREATE SEQUENCE usuarios_id_seq');
        $this->addSql('SELECT setval(\'usuarios_id_seq\', (SELECT MAX(id) FROM "usuarios"))');
        $this->addSql('ALTER TABLE "usuarios" ALTER id SET DEFAULT nextval(\'usuarios_id_seq\')');
        $this->addSql('CREATE SEQUENCE socio_id_seq');
        $this->addSql('SELECT setval(\'socio_id_seq\', (SELECT MAX(id) FROM socio))');
        $this->addSql('ALTER TABLE socio ALTER id SET DEFAULT nextval(\'socio_id_seq\')');
        $this->addSql('ALTER TABLE socio ALTER empresa_id SET NOT NULL');
    }
}
