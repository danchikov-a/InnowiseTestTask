CREATE TABLE Checkout
(
    id int NOT NULL AUTO_INCREMENT,
    name  varchar(255),
    phone varchar(255),
    address  varchar(255),
    userId   int,
    FOREIGN KEY (userId) REFERENCES Users(id),
    PRIMARY KEY (id)
);