CREATE TABLE `KLIENT`(
`rodne_cislo` CHAR(11),
`jmeno` VARCHAR(20) NOT NULL,
`prijmeni` VARCHAR(20) NOT NULL,
`tel_cislo` VARCHAR(15),
`ulice` VARCHAR(20),
`mesto` VARCHAR(20),
`vek` INTEGER CHECK (`vek` >= 0),
PRIMARY KEY(`rodne_cislo`)
)ENGINE=InnoDB;

CREATE TABLE `ZAMESTNANEC`(
`id_zamestnance` INT,
`jmeno` VARCHAR(20) NOT NULL,
`prijmeni` VARCHAR(20) NOT NULL,
`pozice` VARCHAR(20),
`telefon` VARCHAR(15),
PRIMARY KEY(`id_zamestnance`)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS  `VYPUJCKA` (
 `id_vypujcky` INT,
 `suma` NUMERIC( 7 ) CHECK (`suma` >0),
 `datum_pujceni` DATE NOT NULL ,
 `datum_vraceni` DATE NOT NULL ,
 `spravce` INT,
 `klient` CHAR( 11 ) ,
PRIMARY KEY (  `id_vypujcky` ) ,
KEY  `spravce` (  `spravce` ) ,
KEY  `klient` (  `klient` ) ,
CONSTRAINT  `FK_vypujcka_spravce` FOREIGN KEY (  `spravce` ) REFERENCES  `ZAMESTNANEC` (  `id_zamestnance` ) ,
CONSTRAINT  `FK_vypujcka_klient` FOREIGN KEY (  `klient` ) REFERENCES  `KLIENT` (  `rodne_cislo` ) ON DELETE CASCADE
)
COLLATE latin2_czech_cs
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `VYROBCE`(
`id_vyrobce` INT,
`nazev_firmy` VARCHAR(15) UNIQUE,
`stat_firmy` VARCHAR(15),
PRIMARY KEY(`id_vyrobce`)
)
COLLATE latin2_czech_cs
ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `KATEGORIE`(
`id_kategorie` VARCHAR(20),
`akce` VARCHAR(20),
PRIMARY KEY(`id_kategorie`)
)
COLLATE latin2_czech_cs
ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `KOSTYM`(
`id_kostymu` INT,
`nazev` VARCHAR(20) NOT NULL,
`barva` VARCHAR(20),
`velikost` VARCHAR(3),
`material` VARCHAR(20),
`cena` NUMERIC(6) NOT NULL,
`datum_vyroby` DATE,
`spravce` INT,
`vyrobce` INT,
PRIMARY KEY (`id_kostymu`),
KEY `spravce` (`spravce`),
KEY `vyrobce` (`vyrobce`),
CONSTRAINT `FK_kostym_spravce` FOREIGN KEY(`spravce`) REFERENCES `ZAMESTNANEC` (`id_zamestnance`),
CONSTRAINT `FK_kostym_vyrobce` FOREIGN KEY(`vyrobce`) REFERENCES `VYROBCE` (`id_vyrobce`)
)
COLLATE latin2_czech_cs
ENGINE=InnoDB;

CREATE TABLE `DOPLNEK`(
`id_doplnku` INT,
`nazev` VARCHAR(20) NOT NULL,
`barva` VARCHAR(20),
`material` VARCHAR(20),
`cena` NUMERIC(6) NOT NULL,
`datum_vyroby` DATE,
`spravce` INT,
`vyrobce` INT,
`kostym` INT,
PRIMARY KEY (`id_doplnku`),
KEY `spravce` (`spravce`),
KEY `vyrobce` (`vyrobce`),
KEY `kostym` (`kostym`),
CONSTRAINT `FK_doplnek_kostym` FOREIGN KEY(`kostym`) REFERENCES `KOSTYM` (`id_kostymu`) ON DELETE SET NULL,
CONSTRAINT `FK_doplnek_spravce` FOREIGN KEY(`spravce`) REFERENCES `ZAMESTNANEC` (`id_zamestnance`),
CONSTRAINT `FK_doplnek_vyrobce` FOREIGN KEY(`vyrobce`) REFERENCES `VYROBCE` (`id_vyrobce`)
)
COLLATE latin2_czech_cs
ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS`DODANI_KOSTYMU`(
`vypujcka` INT,
`kostym` INT,
PRIMARY KEY(`vypujcka`,`kostym`),
KEY `vypujcka` (`vypujcka`),
KEY `kostym` (`kostym`),
CONSTRAINT `FK_dodani_kostymu_kostym` FOREIGN KEY(`kostym`) REFERENCES `KOSTYM`(`id_kostymu`) ON DELETE CASCADE,
CONSTRAINT `FK_dodani_kostymu_vypujcka` FOREIGN KEY(`vypujcka`) REFERENCES `VYPUJCKA`(`id_vypujcky`) ON DELETE CASCADE
)
COLLATE latin2_czech_cs
ENGINE=InnoDB;

CREATE TABLE `DODANI_DOPLNKU`(
`vypujcka` INT,
`doplnek` INT,
KEY `vypujcka` (`vypujcka`),
KEY `doplnek` (`doplnek`), 
CONSTRAINT `FK_dodani_doplnku_doplnek` FOREIGN KEY(`doplnek`) REFERENCES `DOPLNEK`(`id_doplnku`) ON DELETE CASCADE,
CONSTRAINT `FK_dodani_doplnku_vypujcka` FOREIGN KEY(`vypujcka`) REFERENCES `VYPUJCKA`(`id_vypujcky`) ON DELETE CASCADE,
PRIMARY KEY(`vypujcka`,`doplnek`)
)
COLLATE latin2_czech_cs
ENGINE=InnoDB;

CREATE TABLE `DOPLNEK_KATEGORIE`(
`doplnek` INT,
`kategorie` VARCHAR(20),
PRIMARY KEY(`doplnek`,`kategorie`),
KEY `doplnek` (`doplnek`),
KEY `kategorie` (`kategorie`),
CONSTRAINT `FK_doplnek` FOREIGN KEY (`doplnek`) REFERENCES `DOPLNEK`(`id_doplnku`) ON DELETE CASCADE,
CONSTRAINT `FK_doplnek_kategorie` FOREIGN KEY(`kategorie`) REFERENCES `KATEGORIE`(`id_kategorie`) ON DELETE CASCADE
)
COLLATE latin2_czech_cs
ENGINE=InnoDB;

CREATE TABLE `KOSTYM_KATEGORIE`(
`kostym` INT,
`kategorie` VARCHAR(20),
PRIMARY KEY(`kostym`,`kategorie`),
KEY `kostym` (`kostym`),
KEY `kategorie` (`kategorie`),
CONSTRAINT `FK_kostym_kategorie` FOREIGN KEY(`kategorie`) REFERENCES `KATEGORIE`(`id_kategorie`) ON DELETE CASCADE,
CONSTRAINT `FK_kostym` FOREIGN KEY(`kostym`)
REFERENCES `KOSTYM`(`id_kostymu`) ON DELETE CASCADE
)
COLLATE latin2_czech_cs
ENGINE=InnoDB;