CREATE USER IF NOT EXISTS 'nerd'@'localhost' IDENTIFIED BY 'NerdyGadgets69420!@';
GRANT ALL PRIVILEGES ON nerdygadgets.* TO 'nerd'@'localhost';
USE nerdygadgets;
CREATE TABLE IF NOT EXISTS webshop_klant (
                               klantID INT(11) NOT NULL AUTO_INCREMENT,
                               voornaam VARCHAR(45) NOT NULL,
                               achternaam VARCHAR(45) NOT NULL,
                               email VARCHAR(45) NOT NULL,
                               telefoonnummer VARCHAR(15),
                               PRIMARY KEY (klantID));

CREATE TABLE IF NOT EXISTS webshop_order (
                               OrderID INT(11) NOT NULL AUTO_INCREMENT,
                               klantID INT(11) NOT NULL,
                               datum DATE,
                               land VARCHAR(60) NOT NULL,
                               straat VARCHAR(60) NOT NULL,
                               postcode VARCHAR(10) NOT NULL,
                               stad VARCHAR(50) NOT NULL,
                               PRIMARY KEY (`OrderID`),
                               FOREIGN KEY (`klantID`) REFERENCES webshop_klant (klantID),
                               FOREIGN KEY (land) REFERENCES countries (CountryName));

CREATE TABLE IF NOT EXISTS webshop_orderregel (
                                    OrderID INT(11) NOT NULL,
                                    ArtikelID INT(11) NOT NULL,
                                    aantal INT(11) NOT NULL,
                                    bedrag DECIMAL(18,2) NOT NULL,
                                    PRIMARY KEY (OrderID, ArtikelID),
                                    FOREIGN KEY (OrderID) REFERENCES webshop_order (OrderID),
                                    FOREIGN KEY (ArtikelID) REFERENCES stockitems (StockItemID));