DROP DATABASE IF EXISTS DB;
CREATE DATABASE IF NOT EXISTS DB;
USE DB;

CREATE TABLE Users (
    `Email` varchar(255) PRIMARY KEY,
    `Name` varchar(255),
    `Password` varchar(255),
    `AccountId` varchar(255)
);
    
INSERT INTO Users (`Email`, `Name`, `Password`, `AccountId`)
VALUES
    ('user1@gmail.com', 'User1', 'pass1', '1'),
    ('user2@gmail.com', 'User2', 'pass2', '2'),
    ('user3@gmail.com', 'User3', 'pass3', '3'),
    ('user4@gmail.com', 'User4', 'pass4', '4'),
    ('user5@gmail.com', 'User5', 'pass5', '5')
;

CREATE TABLE News (
    `Id` int PRIMARY KEY,
    `Title` varchar(255),
    `Body` varchar(255),
    `Datetime` datetime
);

INSERT INTO News (`Id`, `Title`, `Body`, `Datetime`)
VALUES
    (1, 'News 1', 'Body 1 Body 1 Body 1 Body 1 Body 1 Body 1 ', '2022-01-01 00:00:00'),
    (2, 'News 2', 'Body 2 Body 2 Body 2 Body 2 Body 2 Body 2 ', '2022-01-02 00:00:00'),
    (3, 'News 3', 'Body 3 Body 3 Body 3 Body 3 Body 3 Body 3 ', '2022-01-03 00:00:00'),
    (4, 'News 4', 'Body 4 Body 4 Body 4 Body 4 Body 4 Body 4 ', '2022-01-04 00:00:00'),
    (5, 'News 5', 'Body 5 Body 5 Body 5 Body 5 Body 5 Body 5 ', '2022-01-05 00:00:00')
;