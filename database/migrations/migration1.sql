CREATE DATABASE innowise;
USE innowise;
CREATE TABLE Users
(
    Id int NOT NULL AUTO_INCREMENT,
    Email  varchar(255) unique,
    Name   varchar(255),
    Password   varchar(255),
    Gender Enum('male', 'female'),
    Status Enum('active', 'inactive'),
    PRIMARY KEY (Id)
);

INSERT INTO Users(Email, Name, Gender, Status)
VALUES ('qwe@gmail.com', 'qwe', 'male', 'active');
