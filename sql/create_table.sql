/* CREATE DATABASE */
CREATE DATABASE RESTAURANT;
USE RESTAURANT;

/* CREATE TABLE */
create table Types(Code int NOT NULL PRIMARY KEY AUTO_INCREMENT, 
					Type VARCHAR(13));

create table Restaurant(Code VARCHAR(25) primary key not null, 
						Name VARCHAR(100), 
						TypeCode INT, 
						FOREIGN KEY(TypeCode) REFERENCES Types(Code));

create table Location(Code VARCHAR(25) NOT NULL PRIMARY KEY, 
						Location VARCHAR(15), 
						foreign key(Code) references Restaurant(Code));

create table Contact(Code Varchar(25) NOT NULL PRIMARY KEY, 
						PhoneNum varchar(15), 
						foreign key(Code) references Restaurant(Code));

create table Menu(Code Varchar(25) NOT NULL, 
					Menu_Name varchar(100), 
					Menu_Prices int, 
					foreign key(Code) references Restaurant(Code));

CREATE TABLE hashtag (
    hashtag_code INT(2) PRIMARY KEY,
    hashtag VARCHAR(10));

ALTER TABLE restaurant
ADD COLUMN hashtag_code INT(2);

UPDATE restaurant
SET hashtag_code = FLOOR(1 + RAND() * 12);

ALTER TABLE restaurant
ADD FOREIGN KEY (hashtag_code) REFERENCES hashtag(hashtag_code);

create table Reservation(Code VARCHAR(50), 
						ReserveName VARCHAR(20), 
                        ReserveDate DATE, 
                        ReserveTime VARCHAR(7), 
                        PersonCount INT, 
                        FOREIGN KEY(Code) references Restaurant(Code));

create table Available(Code VARCHAR(25) NOT NULL PRIMARY KEY, 
						Start varchar(8), 
						End varchar(8), 
						foreign key(Code) references Restaurant(Code));

create table BreakTime(Code VARCHAR(25) NOT NULL PRIMARY KEY, 
						BreakStart varchar(13), 
						BreakEnd varchar(13), 
						foreign key(Code) references Restaurant(Code));

CREATE TABLE Review (Code VARCHAR(25),
						review_code INT AUTO_INCREMENT PRIMARY KEY,
						rating INT,
						review VARCHAR(255),
						password VARCHAR(50),
						FOREIGN KEY (Code) REFERENCES restaurant(Code));
                        
