CREATE TABLE UserSessionInformation
(
    id int NOT NULL AUTO_INCREMENT,
    ip  varchar(255) unique,
    attempts   int,
    blockTime   int,
    PRIMARY KEY (id)
);