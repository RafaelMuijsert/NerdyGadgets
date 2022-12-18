drop table if exists webshop_kortingcodes;

create table if not exists webshop_kortingscodes (
	kortingID int auto_increment primary key,
    codenaam varchar(10) unique NOT NULL,
    procent DOUBLE(4,2) NOT NULL,
    geldigtot date,
    uses int(4)
);
create table if not exists webshop_admininstellingen (
    instelling varchar(255) PRIMARY KEY,
    aantal double(4,2) NOT NULL,
    bijschrift varchar(255)
);
insert into webshop_admininstellingen (instelling, aantal)
values (verzendKostenAantal, 5.99)