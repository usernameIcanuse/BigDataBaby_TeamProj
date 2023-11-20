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



