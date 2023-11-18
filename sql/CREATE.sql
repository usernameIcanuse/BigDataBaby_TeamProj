/* CREATE DATABASE */
CREATE DATABASE team05;
USE team05;

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
                        
CREATE INDEX idx_Code ON Review (review_code);

CREATE TABLE delivery AS
SELECT * FROM restaurant WHERE 1=0;

INSERT INTO delivery (CODE, NAME, TYPECODE)
SELECT CODE, NAME, TYPECODE FROM restaurant;

ALTER TABLE delivery
DROP COLUMN NAME;

ALTER TABLE delivery
DROP COLUMN TYPECODE;

ALTER TABLE delivery
DROP COLUMN hashtag_code;

ALTER TABLE DELIVERY
ADD COLUMN dlvy_avail BOOLEAN;

ALTER TABLE DELIVERY
ADD COLUMN  dlvy_price int;

ALTER TABLE DELIVERY
ADD COLUMN dlvy_ok_price int;

UPDATE DELIVERY
SET DLVY_PRICE = FLOOR(RAND()*10)*1000;

UPDATE DELIVERY
SET DLVY_OK_PRICE = FLOOR(RAND()*10)*1000 + 5000;

UPDATE DELIVERY
SET DLVY_AVAIL = ROUND(RAND());

UPDATE delivery
SET dlvy_price = FLOOR(RAND() * (15 - 8 + 1) + 8) * 1000
WHERE dlvy_price BETWEEN 8000 AND 15000;


UPDATE DELIVERY
SET DLVY_PRICE = NULL, DLVY_OK_PRICE = NULL
WHERE DLVY_AVAIL = 0;

-- restaurant 테이블 구조를 복사하여 rating 테이블 생성
CREATE TABLE rating AS
SELECT * FROM restaurant WHERE 1=0;

-- rating 테이블에 restaurant 테이블의 데이터 복사
INSERT INTO rating (CODE, NAME, TYPECODE)
SELECT CODE, NAME, TYPECODE FROM restaurant;

-- TYPECODE 컬럼 삭제
ALTER TABLE RATING
DROP COLUMN TYPECODE;

ALTER TABLE RATING
DROP COLUMN NAME;

ALTER TABLE RATING
DROP COLUMN hashtag_code;
-- RATE 컬럼 추가
ALTER TABLE RATING
ADD COLUMN RATE FLOAT;

-- RATE 컬럼의 값을 0부터 10까지 랜덤 소수점 값으로 업데이트
UPDATE RATING
SET RATE = ROUND(RAND() * 10, 1);

ALTER TABLE rating
ADD COLUMN total_rating INT(4);

UPDATE rating
SET total_rating = FLOOR(100 + RAND() * (9999 - 100 + 1));





