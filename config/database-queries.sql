#The following queries need to be executed for the website to work properly
ALTER TABLE webshop_klant CHANGE COLUMN geboortedatum geboortedatum DATE DEFAULT NULL;
ALTER TABLE webshop_order CHANGE COLUMN postcode postcode VARCHAR(7) NOT NULL;