DROP TABLE IF EXISTS Reservation;

create table Reservation(Code VARCHAR(50), 
			ReserveName VARCHAR(20), 
                        ReserveDate DATE, 
                        ReserveTime VARCHAR(7), 
                        PersonCount INT, 
                        FOREIGN KEY(Code) references Restaurant(Code));

# Reservation 테이블 테스트용 데이터 삽입
# 날짜 데이터 범위는 2023-11-01~2023-12-31 사이로 생성했습니다
INSERT INTO Reservation (Code, ReserveName, ReserveDate, ReserveTime, PersonCount)
VALUES
('3230000-101-2023-00343', 'John Doe', '2023-11-01', 'Brunch', 5),
('3230000-101-2023-00222', 'Jane Smith', '2023-11-05', 'Lunch', 3),
('3150000-101-2023-00052', 'Bob Johnson', '2023-11-10', 'Dinner', 8),
('3130000-101-2023-00288', 'Alice Brown', '2023-11-15', 'Brunch', 2),
('3150000-101-2023-00204', 'Charlie Davis', '2023-11-20', 'Lunch', 6),
('3220000-101-2023-00450', 'Eva White', '2023-11-25', 'Dinner', 4),
('3220000-101-2023-00454', 'David Lee', '2023-12-02', 'Brunch', 7),
('3110000-101-2023-00070', 'Sara Miller', '2023-12-07', 'Lunch', 5),
('3180000-101-2022-00409', 'Michael Chen', '2023-12-12', 'Dinner', 9),
('3060000-101-2022-00139', 'Olivia Kim', '2023-12-17', 'Brunch', 3),
('3050000-101-2022-00115', 'Ryan Wilson', '2023-12-22', 'Lunch', 8),
('3030000-101-2023-00210', 'Sophia Martin', '2023-12-27', 'Dinner', 6),
('3000000-101-1995-05197', 'Daniel Brown', '2023-11-02', 'Brunch', 4),
('3050000-101-2021-00370', 'Emily Davis', '2023-11-06', 'Lunch', 10),
('3150000-101-2021-00222', 'Matthew Smith', '2023-11-11', 'Dinner', 7),
('3030000-101-2019-00154', 'Grace Johnson', '2023-11-16', 'Brunch', 2),
('3120000-101-2018-00357', 'Jacob Lee', '2023-11-21', 'Lunch', 5),
('3240000-101-2018-00348', 'Ava White', '2023-11-26', 'Dinner', 8),
('3180000-101-2018-00102', 'Noah Miller', '2023-12-03', 'Brunch', 6),
('3220000-101-2017-01267', 'Lily Chen', '2023-12-08', 'Lunch', 4),
('3090000-101-2018-00051', 'Logan Kim', '2023-12-13', 'Dinner', 7),
('3150000-101-2017-00622', 'Emma Wilson', '2023-12-18', 'Brunch', 3),
('3150000-101-2017-00465', 'Christopher Martin', '2023-12-23', 'Lunch', 9),
('3210000-101-2017-00296', 'Madison Brown', '2023-11-03', 'Dinner', 5),
('3070000-101-2016-00320', 'Ethan Davis', '2023-11-08', 'Brunch', 8),
('3150000-101-2016-00357', 'Chloe Smith', '2023-11-13', 'Lunch', 6),
('3240000-101-2016-00281', 'Isaac Johnson', '2023-11-18', 'Dinner', 3),
('3230000-101-2023-00343', 'Zoe Lee', '2023-11-23', 'Brunch', 7),
('3230000-101-2023-00343', 'Nathan White', '2023-11-28', 'Lunch', 4);