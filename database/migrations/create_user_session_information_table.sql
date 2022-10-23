CREATE TABLE UserSessionInformation
(
    Id int NOT NULL AUTO_INCREMENT,
    Ip  varchar(255) unique,
    Attempts   int,
    BlockTime   int,
    PRIMARY KEY (Id)
);