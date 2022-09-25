CREATE DATABASE innowise;
USE innowise;
CREATE TABLE Users
(
    Email  varchar(255) primary key,
    Name varchar(255),
    Gender   varchar(255),
    Status      varchar(255)
);

INSERT INTO Users(Email, Name, Gender, Status) VALUES ('qwe@gmail.com', 'qwe', 'male', 'active');
