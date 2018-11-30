-- INSERT COSTUMES
INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`) VALUES ('1', 'bart', 'žlutá', 'M', 'bavlna', '1500', '2014-10-10', '1', '1', 'images/costumes/bart.jpg');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`) VALUES ('2', 'jeptiška', 'šedá', 'S', 'bavlna', '1500', '2014-11-11', '1', '2', 'images/costumes/mniska.jpg');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`) VALUES ('3', 'carmen', 'černá', 'M', 'bavlna', '1250', '2014-02-05', '1', '2', 'images/costumes/carman.jpg');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`) VALUES ('4', 'jahúdka', 'červená', 'S', 'bavlna', '1000', '2013-11-08', '1', '2', 'images/costumes/jahodka.jpg');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`) VALUES ('5', 'kostra', 'šedá', 'L', 'bavlna', '950', '2016-07-11', '1', '1', 'images/costumes/kostra.jpg');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`) VALUES ('6', 'mimoň', 'žlutá', 'S', 'bavlna', '850', '2017-12-06', '1', '1', 'images/costumes/mimon.jpg');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`) VALUES ('7', 'shrek', 'zelená', 'XL', 'bavlna', '1350', '2012-05-11', '1', '1', 'images/costumes/shrek.jpg');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`) VALUES ('8', 'pirát', 'zelená', 'L', 'bavlna', '750', '2013-07-11', '1', '2', 'images/costumes/pirate.jpg');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`) VALUES ('9', 'lego postavička', 'žlutá', 'M', 'bavlna', '875', '2011-07-11', '1', '2', 'images/costumes/lego.jpg');
 INSERT INTO `kostym` (`id`, `nazev`, `barva`, `velikost`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `filepath`) VALUES ('10', 'aladin', 'bíla', 'M', 'bavlna', '1200', '2015-02-114', '1', '1', 'images/costumes/aladin.jpg');



-- INSERT ACCESSORIES
INSERT INTO `doplnek` (`id`, `nazev`, `barva`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `kostym`, `filepath`) VALUES ('200', 'rukavice', 'černá', 'bavlna', '250', '2014-10-29', '1', '2', '3', 'images/accessories/gloves.jpg');
INSERT INTO `doplnek` (`id`, `nazev`, `barva`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `kostym`, `filepath`) VALUES ('201', 'koruna', 'stříbrná', 'lehký kov', '400', '2017-10-07', '1', '1', '3', 'images/accessories/koruna.jpg');
INSERT INTO `doplnek` (`id`, `nazev`, `barva`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `kostym`, `filepath`) VALUES ('202', 'dluhé rukavice', 'černá', 'bavlna', '350', '2018-08-07', '1', '2', '3', 'images/accessories/long_gloves.jpg');
INSERT INTO `doplnek` (`id`, `nazev`, `barva`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `kostym`, `filepath`) VALUES ('203', 'maska', 'zlatá', 'umělá hmota', '400', '2016-07-07', '1', '1', '3', 'images/accessories/mask.jpg');
INSERT INTO `doplnek` (`id`, `nazev`, `barva`, `material`, `cena`, `datum_vyroby`, `spravce`, `vyrobce`, `kostym`, `filepath`) VALUES ('204', 'mec', 'šedá', 'umělá hmota', '200', '2018-07-07', '1', '2', '3', 'images/accessories/mec.jpg');






-- INSERT VYROBCU
INSERT INTO `vyrobce` (`id_vyrobce`, `nazev_firmy`, `stat_firmy`) VALUES ('1', 'Cosmos', 'Česká republika')
INSERT INTO `vyrobce` (`id_vyrobce`, `nazev_firmy`, `stat_firmy`) VALUES ('2', 'Kikiri', 'Nemecko')


-- INSERT ZAMESTANCA
INSERT INTO `zamestnanec` (`id_zamestnance`, `jmeno`, `prijmeni`, `pozice`, `telefon`) VALUES ('1', 'Vladimír', 'Smutný', 'Správce', '+420978523624')