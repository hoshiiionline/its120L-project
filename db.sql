CREATE DATABASE HotelBookingDB;
USE HotelBookingDB;

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
    dateType VARCHAR(50) NOT NULL,
    pricingRate DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (roomID) REFERENCES Room(roomID) ON DELETE CASCADE,
    FOREIGN KEY (occupancyID) REFERENCES Occupancy(occupancyID) ON DELETE CASCADE
);

CREATE TABLE Address (
    addressID INT AUTO_INCREMENT PRIMARY KEY,
    addressLine VARCHAR(255) NOT NULL,
    barangay VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    region VARCHAR(100) NOT NULL,
    postalCode VARCHAR(20) NOT NULL
);

CREATE TABLE Customer (
    customerID INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    addressID INT,
    emailAddress VARCHAR(100) UNIQUE NOT NULL,
    mobileNo VARCHAR(20) UNIQUE NOT NULL,
    FOREIGN KEY (addressID) REFERENCES Address(addressID) ON DELETE SET NULL
);

CREATE TABLE Booking (
    bookingID INT AUTO_INCREMENT PRIMARY KEY,
    pricingID INT,
    customerID INT,
    bookingDate DATE NOT NULL,
    paymentMethod VARCHAR(50) NOT NULL,
    FOREIGN KEY (pricingID) REFERENCES Pricing(pricingID) ON DELETE CASCADE,
    FOREIGN KEY (customerID) REFERENCES Customer(customerID) ON DELETE CASCADE
);

INSERT INTO Room (roomType, roomPackage) VALUES
('Batcave 1', 'Nature Villa Package'),
('Batcave 2', 'Nature Villa Package'),
('Ledge Bed', 'Nature Villa Package'),
('Double Room', 'Nature Villa Package'),
('Twin Room', 'Nature Villa Package'),
('Cave Dorm', 'Nature Villa Package'),
('Whole House', 'Nature Villa Package'),
('Ground Floor', 'Art House Stay Package'),
('2/4 Main House', 'Art House Stay Package'),
('Complete Art House Rental', 'Art House Stay Package');

INSERT INTO Occupancy (occupancyType, occupancyMin, occupancyMax) VALUES
('Solo', 1, 1),
('2 Persons', 1, 2),
('3 Persons', 1, 3),
('Single Bed Space', 1, 1),
('Family LW', 1, 4),
('Family RW', 1, 6),
('5 Persons', 1, 5),
('10 Persons', 1, 10),
('15 Persons', 1, 15),
('Whole House', 1, 30);

INSERT INTO Pricing (roomID, occupancyID, dateType, pricingRate) VALUES
(1, 1, 'Weekday', 5370),
(1, 1, 'Weekend', 6030),
(1, 1, 'Holiday', 6270),
(1, 2, 'Weekday', 6740),
(1, 2, 'Weekend', 7620),
(1, 2, 'Holiday', 7955),
(1, 3, 'Weekday', 8130),
(1, 3, 'Weekend', 9236),
(1, 3, 'Holiday', 9630),
(2, 1, 'Weekday', 5370),
(2, 1, 'Weekend', 6030),
(2, 1, 'Holiday', 6270),
(2, 2, 'Weekday', 6740),
(2, 2, 'Weekend', 7620),
(2, 2, 'Holiday', 7955),
(3, 4, 'Weekday', 4170),
(3, 4, 'Weekend', 4698),
(3, 4, 'Holiday', 4890),
(3, 5, 'Weekday', 2170),
(3, 5, 'Weekend', 2478),
(3, 5, 'Holiday', 2590),
(4, 1, 'Weekday', 4170),
(4, 1, 'Weekend', 4698),
(4, 1, 'Holiday', 4890),
(5, 1, 'Weekday', 4170),
(5, 1, 'Weekend', 4698),
(5, 1, 'Holiday', 4890),
(5, 2, 'Weekday', 5540),
(5, 2, 'Weekend', 6288),
(5, 2, 'Holiday', 7520),
(6, 6, 'Weekday', 2530),
(6, 6, 'Weekend', 2670),
(6, 6, 'Holiday', 2722),
(6, 7, 'Weekday', 2170),
(6, 7, 'Weekend', 2478),
(6, 7, 'Holiday', 2590),
(7, 9, 'Weekday', 57000),
(7, 9, 'Weekend', 65000),
(7, 9, 'Holiday', 70000),
(8, 1, 'Weekday', 5370),
(8, 1, 'Weekend', 6030),
(8, 1, 'Holiday', 6270),
(8, 2, 'Weekday', 6740),
(8, 2, 'Weekend', 7620),
(8, 2, 'Holiday', 7955),
(8, 3, 'Weekday', 8310),
(8, 3, 'Weekend', 9236),
(8, 3, 'Holiday', 9630),
(9, 8, 'Weekday', 12500),
(9, 8, 'Weekend', 13750),
(9, 8, 'Holiday', 15000),
(10, 9, 'Weekday', 15400),
(10, 9, 'Weekend', 16900),
(10, 9, 'Holiday', 18000);
