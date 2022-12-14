USE nerdygadgets;
CREATE TABLE IF NOT EXISTS webshop_kortingscodes (
	codenaam varchar(10) PRIMARY KEY,
	procent DOUBLE(4,2) NOT NULL,
	geldigtot DATE,
	uses INT(4)
);

INSERT INTO webshop_kortingscodes (codenaam, procent, geldigtot)
VALUES ('TEST', 20, '2023-01-01');

ALTER TABLE webshop_orderregel
ADD procentKorting DOUBLE(4,2);