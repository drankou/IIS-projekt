CREATE TABLE `KLIENT`(
`rodne_cislo` CHAR(11),
`jmeno` VARCHAR(20) NOT NULL,
`prijmeni` VARCHAR(20) NOT NULL,
`tel_cislo` VARCHAR(15),
`ulice` VARCHAR(20),
`mesto` VARCHAR(20),
`login` VARCHAR(20),
`heslo` VARCHAR(20),
`email` VARCHAR(20),
`vek` INTEGER CHECK (`vek` >= 0),
PRIMARY KEY(`rodne_cislo`)
)
COLLATE utf8_czech_ci
ENGINE=InnoDB;

CREATE TABLE `ZAMESTNANEC`(
`id_zamestnance` INT NOT NULL AUTO_INCREMENT,
`jmeno` VARCHAR(20) NOT NULL,
`prijmeni` VARCHAR(20) NOT NULL,
`pozice` VARCHAR(20),
`telefon` VARCHAR(15),
`login` VARCHAR(20),
`heslo` VARCHAR(20),
PRIMARY KEY(`id_zamestnance`)
)
COLLATE utf8_czech_ci
ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS  `VYPUJCKA` (
 `id_vypujcky` INT NOT NULL AUTO_INCREMENT,
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
COLLATE utf8_czech_ci
ENGINE = INNODB;


CREATE TABLE IF NOT EXISTS `VYROBCE`(
`id_vyrobce` INT NOT NULL AUTO_INCREMENT,
`nazev_firmy` VARCHAR(15) UNIQUE,
`stat_firmy` VARCHAR(15),
PRIMARY KEY(`id_vyrobce`)
)
COLLATE utf8_czech_ci
ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `KATEGORIE`(
`id_kategorie` INT NOT NULL AUTO_INCREMENT,
`akce` VARCHAR(20),
PRIMARY KEY(`id_kategorie`)
)
COLLATE utf8_czech_ci
ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `KOSTYM`(
`id` INT NOT NULL AUTO_INCREMENT,
`nazev` VARCHAR(20) NOT NULL,
`barva` VARCHAR(20),
`velikost` VARCHAR(3),
`material` VARCHAR(20),
`cena` NUMERIC(6) NOT NULL,
`datum_vyroby` DATE,
`spravce` INT,
`vyrobce` INT,
`filepath` VARCHAR(50),
`pocet_kusu` int(5),
PRIMARY KEY (`id`),
KEY `spravce` (`spravce`),
KEY `vyrobce` (`vyrobce`),
CONSTRAINT `FK_kostym_spravce` FOREIGN KEY(`spravce`) REFERENCES `ZAMESTNANEC` (`id_zamestnance`) ON DELETE SET NULL,
CONSTRAINT `FK_kostym_vyrobce` FOREIGN KEY(`vyrobce`) REFERENCES `VYROBCE` (`id_vyrobce`)
)
COLLATE utf8_czech_ci
ENGINE=InnoDB;


CREATE TABLE `DOPLNEK`(
`id` INT NOT NULL AUTO_INCREMENT,
`nazev` VARCHAR(20) NOT NULL,
`barva` VARCHAR(20),
`material` VARCHAR(20),
`cena` NUMERIC(6) NOT NULL,
`datum_vyroby` DATE,
`spravce` INT,
`vyrobce` INT,
`kostym` INT,
`filepath` VARCHAR(50),
`pocet_kusu` INT,
PRIMARY KEY (`id`),
KEY `spravce` (`spravce`),
KEY `vyrobce` (`vyrobce`),
KEY `kostym` (`kostym`),
CONSTRAINT `FK_doplnek_kostym` FOREIGN KEY(`kostym`) REFERENCES `KOSTYM` (`id`) ON DELETE SET NULL,
CONSTRAINT `FK_doplnek_spravce` FOREIGN KEY(`spravce`) REFERENCES `ZAMESTNANEC` (`id_zamestnance`),
CONSTRAINT `FK_doplnek_vyrobce` FOREIGN KEY(`vyrobce`) REFERENCES `VYROBCE` (`id_vyrobce`)
)
COLLATE utf8_czech_ci
ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS`DODANI_KOSTYMU`(
`vypujcka` INT,
`kostym` INT,
PRIMARY KEY(`vypujcka`,`kostym`),
KEY `vypujcka` (`vypujcka`),
KEY `kostym` (`kostym`),
CONSTRAINT `FK_dodani_kostymu_kostym` FOREIGN KEY(`kostym`) REFERENCES `KOSTYM`(`id`) ON DELETE CASCADE,
CONSTRAINT `FK_dodani_kostymu_vypujcka` FOREIGN KEY(`vypujcka`) REFERENCES `VYPUJCKA`(`id_vypujcky`) ON DELETE CASCADE
)
COLLATE utf8_czech_ci
ENGINE=InnoDB;


CREATE TABLE `DODANI_DOPLNKU`(
`vypujcka` INT,
`doplnek` INT,
KEY `vypujcka` (`vypujcka`),
KEY `doplnek` (`doplnek`), 
CONSTRAINT `FK_dodani_doplnku_doplnek` FOREIGN KEY(`doplnek`) REFERENCES `DOPLNEK`(`id`) ON DELETE CASCADE,
CONSTRAINT `FK_dodani_doplnku_vypujcka` FOREIGN KEY(`vypujcka`) REFERENCES `VYPUJCKA`(`id_vypujcky`) ON DELETE CASCADE,
PRIMARY KEY(`vypujcka`,`doplnek`)
)
COLLATE utf8_czech_ci
ENGINE=InnoDB;


CREATE TABLE `DOPLNEK_KATEGORIE`(
`doplnek` INT,
`kategorie` INT,
PRIMARY KEY(`doplnek`,`kategorie`),
KEY `doplnek` (`doplnek`),
KEY `kategorie` (`kategorie`),
CONSTRAINT `FK_doplnek` FOREIGN KEY (`doplnek`) REFERENCES `DOPLNEK`(`id`) ON DELETE CASCADE,
CONSTRAINT `FK_doplnek_kategorie` FOREIGN KEY(`kategorie`) REFERENCES `KATEGORIE`(`id_kategorie`) ON DELETE CASCADE
)
COLLATE utf8_czech_ci
ENGINE=InnoDB;


CREATE TABLE `KOSTYM_KATEGORIE`(
`kostym` INT,
`kategorie` INT,
PRIMARY KEY(`kostym`,`kategorie`),
KEY `kostym` (`kostym`),
KEY `kategorie` (`kategorie`),
CONSTRAINT `FK_kostym_kategorie` FOREIGN KEY(`kategorie`) REFERENCES `KATEGORIE`(`id_kategorie`) ON DELETE CASCADE,
CONSTRAINT `FK_kostym` FOREIGN KEY(`kostym`)
REFERENCES `KOSTYM`(`id`) ON DELETE CASCADE
)
COLLATE utf8_czech_ci
ENGINE=InnoDB;

ALTER TABLE ZAMESTNANEC AUTO_INCREMENT = 1000;
ALTER TABLE KOSTYM AUTO_INCREMENT = 2000;
ALTER TABLE DOPLNEK AUTO_INCREMENT = 3000;
ALTER TABLE VYPUJCKA AUTO_INCREMENT = 4000;
ALTER TABLE VYROBCE AUTO_INCREMENT = 5000;


INSERT INTO `vyrobce` (`id_vyrobce`, `nazev_firmy`, `stat_firmy`) VALUES (null, 'Cosmos', 'Česká republika');
INSERT INTO `vyrobce` (`id_vyrobce`, `nazev_firmy`, `stat_firmy`) VALUES (null, 'Kikiri', 'Nemecko');


INSERT INTO `zamestnanec` (`id_zamestnance`, `jmeno`, `prijmeni`, `pozice`, `telefon`, `login`, `heslo`) VALUES (null, 'Vladimír', 'Novák', 'Správce', '+420978523624', 'xnovak', 'xnovak');
INSERT INTO `zamestnanec` (`id_zamestnance`, `jmeno`, `prijmeni`, `pozice`, `telefon`, `login`, `heslo`) VALUES (null, 'Peter', 'Petr', 'Správce', '+420978523624', 'xpetr', 'xpetr');
INSERT INTO `zamestnanec` (`id_zamestnance`, `jmeno`, `prijmeni`, `pozice`, `telefon`, `login`, `heslo`) VALUES (null, 'Admin', 'Admin', 'Správce', '+420978523624', 'admin', 'admin');

INSERT INTO `klient` (`rodne_cislo`, `jmeno`, `prijmeni`,`login`, `heslo`, `tel_cislo`,`ulice`, `mesto`, `vek`, `email`) VALUES ('9156090966', 'Honza','Hudák','honza','honza','0917358624', 'Grohova 45', 'Brno', '32', 'Honza@honza.cz' );
INSERT INTO `klient` (`rodne_cislo`, `jmeno`, `prijmeni`,`login`, `heslo`, `tel_cislo`,`ulice`, `mesto`, `vek`, `email`) VALUES ('1452536987', 'Admin','Admin','admin','admin','0908948622', 'Kounicova 82', 'Brno', '18', 'Admin@admin.cz' );

INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`, `pocet_kusu`) VALUES (null, 'Bart', 'žlutá', 'M', 'bavlna', '1500', '2014-10-10', '1000', '5000', 'images/costumes/bart.jpg', '5');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`,`pocet_kusu`) VALUES (null, 'Jeptiška', 'šedá', 'S', 'bavlna', '1500', '2014-11-11', '1001', '5000', 'images/costumes/mniska.jpg', '2');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`,`pocet_kusu`) VALUES (null, 'Carmen', 'černá', 'M', 'bavlna', '1250', '2014-02-05', '1001', '5001', 'images/costumes/carman.jpg', '3');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`,`pocet_kusu`) VALUES (null, 'Jahúdka', 'červená', 'S', 'bavlna', '1000', '2013-11-08', '1001', '5000', 'images/costumes/jahodka.jpg', '5');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`,`pocet_kusu`) VALUES (null, 'Kostra', 'šedá', 'L', 'bavlna', '950', '2016-07-11', '1001', '5001', 'images/costumes/kostra.jpg', '5');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`, `pocet_kusu`) VALUES (null, 'Mimoň', 'žlutá', 'S', 'bavlna', '850', '2017-12-06', '1001', '5000', 'images/costumes/mimon.jpg', '0');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`, `pocet_kusu`) VALUES (null, 'Shrek', 'zelená', 'XL', 'bavlna', '1350', '2012-05-11', '1001', '5000', 'images/costumes/shrek.jpg', '2');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`, `pocet_kusu`) VALUES (null, 'Pirát', 'zelená', 'L', 'bavlna', '750', '2013-07-11', '1000', '5000', 'images/costumes/pirate.jpg', '5');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`, `pocet_kusu`) VALUES (null, 'Lego postavička', 'žlutá', 'M', 'bavlna', '875', '2011-07-11', '1000', '5000', 'images/costumes/lego.jpg', '1');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`, `pocet_kusu`) VALUES (null, 'Aladin', 'bíla', 'M', 'bavlna', '1200', '2015-02-114', '1001', '5000', 'images/costumes/aladin.jpg', '4');




INSERT INTO `doplnek` (`id`, `nazev`, `barva`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `kostym`, `filepath`, `pocet_kusu`) VALUES (null, 'Rukavice', 'černá', 'bavlna', '250', '2014-10-29', '1000', '5000', '2002', 'images/accessories/gloves.jpg', '1');
INSERT INTO `doplnek` (`id`, `nazev`, `barva`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `kostym`, `filepath`, `pocet_kusu`) VALUES (null, 'Koruna', 'stříbrná', 'lehký kov', '400', '2017-10-07', '1001', '5000', '2003', 'images/accessories/koruna.jpg', '2');
INSERT INTO `doplnek` (`id`, `nazev`, `barva`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `kostym`, `filepath`, `pocet_kusu`) VALUES (null, 'Dlouhé rukavice', 'černá', 'bavlna', '350', '2018-08-07', '1000', '5001', '2002', 'images/accessories/long_gloves.jpg', '3');
INSERT INTO `doplnek` (`id`, `nazev`, `barva`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `kostym`, `filepath`, `pocet_kusu`) VALUES (null, 'Maska', 'zlatá', 'umělá hmota', '400', '2016-07-07', '1001', '5000', '2007', 'images/accessories/mask.jpg', '4');
INSERT INTO `doplnek` (`id`, `nazev`, `barva`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `kostym`, `filepath`, `pocet_kusu`) VALUES (null, 'Meč', 'šedá', 'umělá hmota', '200', '2018-07-07', '1000', '5001', '2007', 'images/accessories/mec.jpg', '5');



