drop table if exists webshop_kortingcodes;

create table if not exists webshop_kortingscodes (
	kortingID int auto_increment primary key,
    codenaam varchar(10) unique NOT NULL,
    procent DOUBLE(4,2) NOT NULL,
    geldigtot date,
    uses int(4)
);
create table webshop_admininstellingen (
    instellingID int PRIMARY KEY auto_increment,
    instellingNaam VARCHAR(255) NOT NULL unique,
    aantal double(4,2)
    );
insert into webshop_admininstellingen (instellingNaam, aantal)
values ('verzendKostenGrens', 25.99);
insert into webshop_admininstellingen (instellingNaam, aantal)
values ('verzendKostenAantal', 5.99);