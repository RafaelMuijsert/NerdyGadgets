create table webshop_kortingscodes (
	codenaam varchar(10) PRIMARY KEY,
	procent DOUBLE(4,2) NOT NULL,
	geldigtot date,
	uses int(4)
);

insert into webshop_kortingscodes (codenaam, procent, geldigtot)
values ('TEST', 20, '2023-01-01')

alter table webshop_orderregel
add procentKorting DOUBLE(4,2)