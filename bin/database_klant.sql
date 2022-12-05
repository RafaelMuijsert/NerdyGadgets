use nerdygadgets;

drop table webshop_orderregel;

drop table webshop_order;

drop table webshop_klant;

CREATE TABLE webshop_klant (
	klantID INT (11) NOT NULL AUTO_INCREMENT,
	voornaam VARCHAR (45) NOT NULL,
	tussenvoegsel VARCHAR (10),
	achternaam VARCHAR (45) NOT NULL,
	email VARCHAR (255) NOT NULL CHECK (email like '_%@_%.__%'),
	telefoonnummer VARCHAR (15),
	PRIMARY KEY (klantID)
);

CREATE TABLE webshop_order (
OrderID INT(11) NOT NULL AUTO_INCREMENT,
klantID INT(11) NOT NULL,
datum timestamp,
straat VARCHAR(60) NOT NULL,
postcode VARCHAR(6) NOT NULL CHECK (postcode LIKE '[0-9][0-9][0-9][0-9][A-Z][A-Z]'),
stad VARCHAR(50) NOT NULL,
PRIMARY KEY (`OrderID`),
FOREIGN KEY (`klantID`) REFERENCES webshop_klant (klantID)
);

CREATE TABLE webshop_orderregel (
OrderID INT(11) NOT NULL,
ArtikelID INT(11) NOT NULL,
aantal INT(11) NOT NULL,
bedrag DECIMAL(18,2) NOT NULL,
PRIMARY KEY (OrderID, ArtikelID),
FOREIGN KEY (OrderID) REFERENCES webshop_order (OrderID),
FOREIGN KEY (ArtikelID) REFERENCES stockitems (StockItemID)
);