CREATE TABLE Files
(
    id int NOT NULL AUTO_INCREMENT,
    filePath  varchar(255) unique,
    PRIMARY KEY (id)
);