<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221105153739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE herbolario (ID INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, URL VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE infocomercial (id_comercial INT AUTO_INCREMENT NOT NULL, PlantaID INT NOT NULL, HerbolarioID INT NOT NULL, Precio DOUBLE PRECISION NOT NULL, INDEX FKInfoComerc79765 (PlantaID), INDEX FKInfoComerc148513 (HerbolarioID), PRIMARY KEY(id_comercial)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE planta (Especie VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, ID INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Lugar VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE plantasusos (Planta INT NOT NULL, Uso INT NOT NULL, INDEX FKPlantasUso199696 (Uso), INDEX IDX_94C5431E51BBA868 (Planta), PRIMARY KEY(Planta, Uso)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE usos (ID INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE infocomercial ADD CONSTRAINT FKInfoComerc148513 FOREIGN KEY (HerbolarioID) REFERENCES herbolario (ID)');
        $this->addSql('ALTER TABLE infocomercial ADD CONSTRAINT FKInfoComerc79765 FOREIGN KEY (PlantaID) REFERENCES planta (ID)');
        $this->addSql('ALTER TABLE plantasusos ADD CONSTRAINT FKPlantasUso644177 FOREIGN KEY (Planta) REFERENCES planta (ID)');
        $this->addSql('ALTER TABLE plantasusos ADD CONSTRAINT FKPlantasUso199696 FOREIGN KEY (Uso) REFERENCES usos (ID)');
       
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE herbolario (ID INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, URL VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE infocomercial (id_comercial INT AUTO_INCREMENT NOT NULL, PlantaID INT NOT NULL, HerbolarioID INT NOT NULL, Precio DOUBLE PRECISION NOT NULL, INDEX FKInfoComerc79765 (PlantaID), INDEX FKInfoComerc148513 (HerbolarioID), PRIMARY KEY(id_comercial)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE planta (Especie VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, ID INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Lugar VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE plantasusos (Planta INT NOT NULL, Uso INT NOT NULL, INDEX FKPlantasUso199696 (Uso), INDEX IDX_94C5431E51BBA868 (Planta), PRIMARY KEY(Planta, Uso)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE usos (ID INT AUTO_INCREMENT NOT NULL, Nombre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE infocomercial ADD CONSTRAINT FKInfoComerc148513 FOREIGN KEY (HerbolarioID) REFERENCES herbolario (ID)');
        $this->addSql('ALTER TABLE infocomercial ADD CONSTRAINT FKInfoComerc79765 FOREIGN KEY (PlantaID) REFERENCES planta (ID)');
        $this->addSql('ALTER TABLE plantasusos ADD CONSTRAINT FKPlantasUso644177 FOREIGN KEY (Planta) REFERENCES planta (ID)');
        $this->addSql('ALTER TABLE plantasusos ADD CONSTRAINT FKPlantasUso199696 FOREIGN KEY (Uso) REFERENCES usos (ID)');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
