CREATE DATABASE banahawCircleDB;
USE banahawCircleDB;

CREATE TABLE Room (
    roomID INT AUTO_INCREMENT PRIMARY KEY,
    roomType VARCHAR(50) NOT NULL,
    roomPackage VARCHAR(100) NOT NULL
);

CREATE TABLE Occupancy (
    occupancyID INT AUTO_INCREMENT PRIMARY KEY,
    occupancyType VARCHAR(50) NOT NULL,
    occupancyMin INT NOT NULL,
    occupancyMax INT NOT NULL
);

CREATE TABLE Pricing (
    pricingID INT AUTO_INCREMENT PRIMARY KEY,
    roomID INT,
    occupancyID INT,
    pricingRatePackage DECIMAL(10,2) NOT NULL,
    pricingRateRoom DECIMAL(10,2) NOT NULL,
    rateRoom BOOLEAN NOT NULL,
    FOREIGN KEY (roomID) REFERENCES Room(roomID) ON DELETE CASCADE,
    FOREIGN KEY (occupancyID) REFERENCES Occupancy(occupancyID) ON DELETE CASCADE
);

CREATE TABLE Customer (
    customerID INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    emailAddress VARCHAR(100) UNIQUE NOT NULL,
    mobileNo VARCHAR(20) UNIQUE NOT NULL,
    mealPreference VARCHAR(50) NOT NULL,
    allergyList TEXT NOT NULL
);

CREATE TABLE Booking (
    bookingID INT AUTO_INCREMENT PRIMARY KEY,
    referenceNo VARCHAR(20) NOT NULL,
    pricingID INT,
    customerID INT,
    dateReservedStart DATE NOT NULL,
    dateReservedEnd DATE NOT NULL,
    status ENUM('PENDING', 'FOR APPROVAL', 'DECLINED', 'CANCEL', 'APPROVED') NOT NULL DEFAULT 'PENDING',
    additionalRequests TEXT,
    FOREIGN KEY (pricingID) REFERENCES Pricing(pricingID) ON DELETE CASCADE,
    FOREIGN KEY (customerID) REFERENCES Customer(customerID) ON DELETE CASCADE
);


INSERT INTO Room (roomType, roomPackage) VALUES
('Batcave 1', 'Nature Villa'),
('Batcave 2', 'Nature Villa'),
('Ledge Bed', 'Nature Villa'),
('Double Room', 'Nature Villa'),
('Twin Room', 'Nature Villa'),
('Cave Dorm', 'Nature Villa'),
('Whole House', 'Nature Villa'),
('Ground Floor', 'Art House'),
('2/4 Main House', 'Art House'),
('Complete Art House Rental', 'Art House');

INSERT INTO Occupancy (occupancyType, occupancyMin, occupancyMax) VALUES
('Solo', 1, 1),
('Twin', 1, 2),
('Triple', 1, 3),
('Single Bed', 1, 1),
('LW Group', 1, 6),
('RW Group', 1, 4),
('5 Persons', 5, 5),
('10 Persons', 5, 10),
('15 Persons', 12, 15),
('Whole House', 24, 30);

INSERT INTO Pricing (roomID, occupancyID, pricingRateRoom, pricingRatePackage, rateRoom)
VALUES
  (1, 1, 5183, 7625.4, 0),
  (1, 2, 4686, 9570.8, 1),
  (1, 3, 4217.4, 11544.6, 1),
  (2, 1, 5183, 7625.4, 0),
  (2, 2, 4686, 9570.8, 1),
  (3, 1, 639, 5921.4, 0),
  (3, 6, 3479, 3081.4, 0),
  (3, 1, 639, 5921.4, 0),
  (3, 5, 3479, 3081.4, 0),
  (5, 1, 3479, 5921.4, 0),
  (5, 2, 2982, 7866.8, 1),
  (6, 1, 3749, 5921.4, 0),
  (6, 2, 2982, 7866.8, 1),
  (7, 7, 1150, 3592.6, 1),
  (7, 8, 639, 3081.4, 1),
  (8, 10, 80490, 710000, 0);


