-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2015 at 08:26 AM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spadatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `Appointment_Id` int(7) NOT NULL,
  `Employee_Id` int(7) DEFAULT NULL,
  `Client_Id` int(7) DEFAULT NULL,
  `Duration` varchar(20) DEFAULT NULL,
  `Appointment_Date` date DEFAULT NULL,
  `Treatment_Type` varchar(50) DEFAULT NULL,
  `Price` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `Client_Id` int(7) NOT NULL,
  `Last_Name` varchar(50) DEFAULT NULL,
  `First_Name` varchar(50) DEFAULT NULL,
  `Phone_Number` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Address` varchar(50) DEFAULT NULL,
  `Gender` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`Client_Id`, `Last_Name`, `First_Name`, `Phone_Number`, `Email`, `Address`, `Gender`) VALUES
(12, 'Mohammed', 'Jawad', '514-444-6666', 'jawad@hotmail.com', '998 saint-denis', 'Male'),
(18, 'Toan', 'Thai', '514-495-2957', 'thai@hotmail.com', '8585 fabre', 'Male'),
(20, 'Mario', 'Bienvenu', '514-635-6565', 'mario@gmail.com', 'mario@hotmail.com', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `Employee_Id` int(7) NOT NULL,
  `Last_Name` varchar(50) DEFAULT NULL,
  `First_Name` varchar(50) DEFAULT NULL,
  `Hired_Date` date DEFAULT NULL,
  `Salary` int(10) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Phone_Number` varchar(20) DEFAULT NULL,
  `Address` varchar(50) DEFAULT NULL,
  `Birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`Employee_Id`, `Last_Name`, `First_Name`, `Hired_Date`, `Salary`, `Email`, `Phone_Number`, `Address`, `Birthday`) VALUES
(124, 'Teodor', 'Jose', '2015-11-05', 12000000, 'joseT@gmail.com', '514-969-6363', '2365 agona', '1992-11-11'),
(126, 'Alexander', 'Rodriguez', '2015-01-13', 120000, 'alex.r@gmail.com', '514-987-8888', '6 saint michel', '2015-11-05'),
(127, 'Neeham', 'Khalid', '2015-06-02', 54666, 'Neeham@gmail.com', '514-789-4568', '213 eglise', '1993-10-20'),
(130, 'Brenda', 'Flores', '2015-11-05', 15, 'brenda@hotmail.com', '450-555-4444', '7, avenue 8', '2015-11-05');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `Inventory_Id` int(7) NOT NULL,
  `Item_Id` int(7) DEFAULT NULL,
  `Quantity` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`Inventory_Id`, `Item_Id`, `Quantity`) VALUES
(1, 1, 50),
(2, 2, 50),
(3, 3, 50),
(4, 4, 50),
(5, 5, 50),
(6, 6, 50),
(7, 7, 100);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `Item_Id` int(7) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Price` int(7) DEFAULT NULL,
  `Description` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`Item_Id`, `Name`, `Price`, `Description`) VALUES
(1, 'Gel', 10, 'Gel to remove hair (30 ml)'),
(2, 'Pure Cleansing Cream', 30, '20 ml'),
(3, 'Serum Absolut Control', 30, '30 ml'),
(4, 'Serum Absolut WE3 ', 136, '30ml'),
(5, 'Force de Vie Lotion ', 85, '30ml'),
(6, 'Force de Vie CrÃ¨me Luxe', 143, '60 ml'),
(7, 'Glamorous on the Go', 90, 'The kit');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_Id` int(7) NOT NULL,
  `Username` varchar(72) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `Password` varchar(72) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_Id`, `Username`, `Password`) VALUES
(1, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`Appointment_Id`),
  ADD KEY `Employee_Id_Index` (`Employee_Id`),
  ADD KEY `Client_Id_Index` (`Client_Id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`Client_Id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`Employee_Id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`Inventory_Id`),
  ADD KEY `Item_Id_Index` (`Item_Id`),
  ADD KEY `Item_Id` (`Item_Id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`Item_Id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `Appointment_Id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `Client_Id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `Employee_Id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `Inventory_Id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `Item_Id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_Id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `Appointment_Client_Id_Fk` FOREIGN KEY (`Client_Id`) REFERENCES `clients` (`Client_Id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `Appointment_Employee_Id_Fk` FOREIGN KEY (`Employee_Id`) REFERENCES `employees` (`Employee_Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `item_id_fk` FOREIGN KEY (`Item_Id`) REFERENCES `item` (`Item_Id`) ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
