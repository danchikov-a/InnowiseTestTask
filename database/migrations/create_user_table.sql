CREATE TABLE Users
(
    id int NOT NULL AUTO_INCREMENT,
    email  varchar(255) unique,
    name   varchar(255),
    password   varchar(255),
    gender Enum('male', 'female'),
    status Enum('active', 'inactive'),
    PRIMARY KEY (id)
);
