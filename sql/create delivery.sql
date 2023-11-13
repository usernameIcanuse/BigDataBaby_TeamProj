-- restaurant 테이블 구조를 복사하여 rating 테이블 생성
CREATE TABLE delivery AS
SELECT * FROM restaurant WHERE 1=0;

-- rating 테이블에 restaurant 테이블의 데이터 복사
INSERT INTO delivery (CODE, NAME, TYPECODE)
SELECT CODE, NAME, TYPECODE FROM restaurant;

-- TYPECODE 컬럼 삭제
ALTER TABLE delivery
DROP COLUMN NAME;

ALTER TABLE delivery
DROP COLUMN TYPECODE;

ALTER TABLE delivery
DROP COLUMN hashtag_code;

-- RATE 컬럼 추가
ALTER TABLE DELIVERY
ADD COLUMN dlvy_avail BOOLEAN;

-- RATE 컬럼 추가
ALTER TABLE DELIVERY
ADD COLUMN  dlvy_price int;

-- RATE 컬럼 추가
ALTER TABLE DELIVERY
ADD COLUMN dlvy_ok_price int;

