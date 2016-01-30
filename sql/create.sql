##############################################################################################
## Creating the database and using it ########################################################

create database spark;
use spark;

drop table booking;
drop table parking;
drop table customer;

##############################################################################################
## Create the table for the customer #########################################################

create table customer (
    id int primary key auto_increment,
    userid varchar(20) unique,
    password varchar(32),
    balance int
);

##############################################################################################
## Create the table for the Parking Slots ####################################################

create table parking (
    id int primary key auto_increment,
    mallid int,
    occupied boolean default false
);

##############################################################################################
## Create the table for the Booking Transactions #############################################

create table booking (
    custid int unique,
    pid int unique,
    parkfrom int,
    parkend int,
    arrived boolean default false,
    foreign key (custid) references customer(id),
    foreign key (pid) references parking(id)
);

##############################################################################################
## Create the table for the Logging Transactions #############################################

create table logs (
    custid int unique,
    pid int unique,
    parkfrom int,
    parkend int,
    arrived boolean default false,
    foreign key (custid) references customer(id),
    foreign key (pid) references parking(id)
);

##############################################################################################
## Trial data for testing the database #######################################################

insert into customer(userid, password, balance) values('karthik1', 'helloworld', 1009);
insert into customer(userid, password, balance) values('karthik2', 'helloworld', 2009);
insert into customer(userid, password, balance) values('karthik3', 'helloworld', 3009);

insert into parking(mallid) values(2);
insert into parking(mallid) values(2);
insert into parking(mallid) values(3);
insert into parking(mallid) values(3);

insert into booking(custid, pid, parkfrom, parkend) values(1, 1, 23, 30);
insert into booking(custid, pid, parkfrom, parkend) values(2, 3, 23, 30);
insert into booking(custid, pid, parkfrom, parkend) values(3, 2, 23, 30);
