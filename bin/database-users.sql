USE nerdygadgets;
CREATE TABLE webshop_user (
      id INT PRIMARY KEY AUTO_INCREMENT,
      email VARCHAR(256),
      password varchar(255)
          voornaam VARCHAR(256),
      tussenvoegsel VARCHAR(256),
      achternaam VARCHAR(256),
      geboortedatum DATE,
      telefoonnummer VARCHAR(256),
      stad VARCHAR(256),
      straat VARCHAR(256),
      huisnummer VARCHAR(256),
      postcode VARCHAR(256)
);

alter TABLE webshop_user
    ADD CONSTRAINT emailadresCheck CHECK(email LIKE '%___@___%');

ALTER TABLE webshop_user
    ADD CONSTRAINT postcodeCheck CHECK (postcode REGEXP '^[0-9]{4}[A-Za-z]{2}$');

ALTER TABLE webshop_user
    ADD CONSTRAINT dateCheck CHECK (geboortedatum REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$');

ALTER TABLE webshop_user
    ADD CONSTRAINT emailUnique UNIQUE(email);

ALTER TABLE webshop_user
    ADD role varchar(255) DEFAULT 'Gebruiker';

