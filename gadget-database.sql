CREATE DATABASE DeviceManagement;
USE DeviceManagement;

CREATE TABLE DeviceOwner (
    ID INT AUTO_INCREMENT PRIMARY KEY, 
    Name VARCHAR(100) NOT NULL
);

CREATE TABLE Person (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    Phone VARCHAR(15),
    Active BOOLEAN DEFAULT TRUE
);

CREATE TABLE DeviceType (
    ID INT AUTO_INCREMENT PRIMARY KEY, 
    Name VARCHAR(50) NOT NULL
);

CREATE TABLE Device (
    ID INT AUTO_INCREMENT PRIMARY KEY, 
    Name VARCHAR(100) NOT NULL,
    AssetTag VARCHAR(50) UNIQUE NOT NULL,
    Description TEXT,
    OwnerID INT,
    DType INT NOT NULL,
    Notes TEXT,
    Active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (OwnerID) REFERENCES DeviceOwner(ID) ON DELETE SET NULL,
    FOREIGN KEY (DType) REFERENCES DeviceType(ID) ON DELETE CASCADE
);

CREATE TABLE DeviceAttachment (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    DeviceID INT NOT NULL,
    Description TEXT,
    FilePath VARCHAR(255),
    FOREIGN KEY (DeviceID) REFERENCES Device(ID) ON DELETE CASCADE
);

CREATE TABLE Reservation (
    ID INT AUTO_INCREMENT PRIMARY KEY, 
    DeviceID INT NOT NULL,
    PersonID INT NOT NULL,
    BeginDate DATETIME NOT NULL,
    EndDate DATETIME,
    ReturnedDate DATETIME,
    Notes TEXT,
    FOREIGN KEY (DeviceID) REFERENCES Device(ID) ON DELETE CASCADE,
    FOREIGN KEY (PersonID) REFERENCES Person(ID) ON DELETE CASCADE
);
