CREATE TABLE `News` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`FK_Categoria` bigint NOT NULL,
	`Data` DATETIME NOT NULL,
	PRIMARY KEY (`ID`)
);

CREATE TABLE `Categoria` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`Categoria` smallint NOT NULL,
	PRIMARY KEY (`ID`)
);

CREATE TABLE `Img_News` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`FK_News` bigint NOT NULL,
	`Percorso` varchar(255) NOT NULL,
	`Progressivo` tinyint NOT NULL,
	PRIMARY KEY (`ID`)
);

CREATE TABLE `Press` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`FK_Categoria` bigint NOT NULL,
	`Data` DATETIME NOT NULL,
	PRIMARY KEY (`ID`)
);

CREATE TABLE `Negozi` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`Testo` blob NOT NULL,
	PRIMARY KEY (`ID`)
);

CREATE TABLE `Img_Negozi` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`Path` varchar(255) NOT NULL,
	`Progressivo` tinyint NOT NULL,
	PRIMARY KEY (`ID`)
);

CREATE TABLE `Immagini_Negozi` (
	`FK_Negozi` bigint NOT NULL,
	`FK_Immagine` bigint NOT NULL
);

CREATE TABLE `Img_Press` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`FK_Press` bigint NOT NULL,
	`Percorso` varchar(255) NOT NULL,
	`Progressivo` tinyint NOT NULL,
	PRIMARY KEY (`ID`)
);

CREATE TABLE `Users` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`Username` varchar(255) NOT NULL,
	`Password` char(32) NOT NULL,
	PRIMARY KEY (`ID`)
);

CREATE TABLE `Lang` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`Lang` varchar(255) NOT NULL,
	PRIMARY KEY (`ID`)
);

CREATE TABLE `Contenuto_News` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`FK_Lang` bigint NOT NULL,
	`FK_News` bigint NOT NULL,
	`Titolo` varchar(255) NOT NULL,
	`Descrizione` blob NOT NULL,
	PRIMARY KEY (`ID`,`FK_Lang`,`FK_News`)
);

CREATE TABLE `Contenuto_Press` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`FK_Lang` bigint NOT NULL,
	`FK_Press` bigint NOT NULL,
	`Testo` varchar(255) NOT NULL,
	PRIMARY KEY (`ID`,`FK_Lang`,`FK_Press`)
);

ALTER TABLE `News` ADD CONSTRAINT `News_fk0` FOREIGN KEY (`FK_Categoria`) REFERENCES `Categoria`(`ID`);

ALTER TABLE `Img_News` ADD CONSTRAINT `Img_News_fk0` FOREIGN KEY (`FK_News`) REFERENCES `News`(`ID`);

ALTER TABLE `Press` ADD CONSTRAINT `Press_fk0` FOREIGN KEY (`FK_Categoria`) REFERENCES `Categoria`(`ID`);

ALTER TABLE `Immagini_Negozi` ADD CONSTRAINT `Immagini_Negozi_fk0` FOREIGN KEY (`FK_Negozi`) REFERENCES `Negozi`(`ID`);

ALTER TABLE `Immagini_Negozi` ADD CONSTRAINT `Immagini_Negozi_fk1` FOREIGN KEY (`FK_Immagine`) REFERENCES `Img_Negozi`(`ID`);

ALTER TABLE `Img_Press` ADD CONSTRAINT `Img_Press_fk0` FOREIGN KEY (`FK_Press`) REFERENCES `Press`(`ID`);

ALTER TABLE `Contenuto_News` ADD CONSTRAINT `Contenuto_News_fk0` FOREIGN KEY (`FK_Lang`) REFERENCES `Lang`(`ID`);

ALTER TABLE `Contenuto_News` ADD CONSTRAINT `Contenuto_News_fk1` FOREIGN KEY (`FK_News`) REFERENCES `News`(`ID`);

ALTER TABLE `Contenuto_Press` ADD CONSTRAINT `Contenuto_Press_fk0` FOREIGN KEY (`FK_Lang`) REFERENCES `Lang`(`ID`);

ALTER TABLE `Contenuto_Press` ADD CONSTRAINT `Contenuto_Press_fk1` FOREIGN KEY (`FK_Press`) REFERENCES `Press`(`ID`);

