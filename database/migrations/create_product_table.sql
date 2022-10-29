CREATE TABLE Product
(
    id int NOT NULL AUTO_INCREMENT,
    name  varchar(255),
    manufacture varchar(255),
    releaseDate  date,
    cost   int,
    PRIMARY KEY (id)
);