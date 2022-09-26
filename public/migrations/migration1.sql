CREATE DATABASE innowise;
USE innowise;
CREATE TABLE Users
(
    Email  varchar(255) primary key,
    Name   varchar(255),
    Gender Enum('male', 'female'),
    Status Enum('active', 'inactive')
);

INSERT INTO Users(Email, Name, Gender, Status)
VALUES ('qwe@gmail.com', 'qwe', 'male', 'active');
