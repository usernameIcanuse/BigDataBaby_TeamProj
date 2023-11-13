create table Types(Code int NOT NULL PRIMARY KEY AUTO_INCREMENT, Type VARCHAR(13));

create table Restaurant(Code VARCHAR(25) primary key not null, Name VARCHAR(50), TypeCode INT, FOREIGN KEY(TypeCode) REFERENCES Types(Code));

create table Location(Code VARCHAR(25) NOT NULL PRIMARY KEY, Location VARCHAR(15), foreign key(Code) references Restaurant(Code));

create table Contact(Code Varchar(25) NOT NULL PRIMARY KEY, PhoneNum varchar(15), foreign key(Code) references Restaurant(Code));

create table Menu(Code Varchar(25) NOT NULL, Menu_Name varchar(50), Menu_Prices int, foreign key(Code) references Restaurant(Code));