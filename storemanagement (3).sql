-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2024 at 05:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `storemanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AID` int(100) NOT NULL,
  `ANAME` varchar(100) NOT NULL,
  `AEMAIL` varchar(100) NOT NULL,
  `APASS` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AID`, `ANAME`, `AEMAIL`, `APASS`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `UID` int(100) NOT NULL,
  `CID` int(100) NOT NULL,
  `CIMAGE` varchar(255) NOT NULL,
  `CPNAME` varchar(255) NOT NULL,
  `CNAME` varchar(255) NOT NULL,
  `CCODE` varchar(100) NOT NULL,
  `CTIME` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`UID`, `CID`, `CIMAGE`, `CPNAME`, `CNAME`, `CCODE`, `CTIME`) VALUES
(1, 3, '', 'Pen (Blue, Ballpoint)', 'Stationery', 'PEN123', '2024-03-02 18:26:38'),
(1, 4, '', 'Pencil (HB, Wooden)', 'Stationery', 'PEN001', '2024-03-02 18:27:42'),
(1, 5, '', 'Marker (Permanent, Black)', 'Stationery', 'MRK987', '2024-03-02 18:28:19'),
(1, 6, '', 'Eraser (Vinyl, White)', 'Stationery', 'ERS456', '2024-03-02 18:28:37'),
(1, 7, '', 'Notebook (A5, Lined)', 'Stationery', 'NTBK123', '2024-03-02 18:28:58'),
(1, 8, '', 'Stapler (Standard)', 'Office Supplies', 'STP789', '2024-03-02 18:29:38'),
(1, 9, '', 'Ruler (Plastic, 15 cm)', 'Office Supplies', 'RLR456', '2024-03-02 18:30:31'),
(1, 10, '', 'Laptop (15.6\" i5 Processor)', 'Electronics', 'LAP123', '2024-03-02 18:31:01'),
(1, 11, '', 'Phone (Android Smartphone)', 'Electronics', 'PHN456', '2024-03-02 18:31:30'),
(1, 12, '', 'Tablet (8\" Android)', 'Electronics', 'TAB789', '2024-03-02 18:31:49'),
(1, 13, '', 'Headphones (Wireless)', 'Electronics', 'HPN123', '2024-03-02 18:35:50'),
(1, 14, '', 'Speaker (Bluetooth)', 'Electronics', 'SPK456', '2024-03-02 18:38:09'),
(2, 15, '', 'Marker (Permanent, Black)', 'Stationery', 'MRK987', '2024-03-16 16:16:30');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `UID` int(100) NOT NULL,
  `CSTID` int(100) NOT NULL,
  `CSTNAME` varchar(255) NOT NULL,
  `CSTEMAIL` varchar(255) NOT NULL,
  `CSTNUM` varchar(50) NOT NULL,
  `CSTADDRESS` varchar(500) NOT NULL,
  `CSTCITY` varchar(100) NOT NULL,
  `CSTSTATE` varchar(100) NOT NULL,
  `SCTTIME` varchar(100) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`UID`, `CSTID`, `CSTNAME`, `CSTEMAIL`, `CSTNUM`, `CSTADDRESS`, `CSTCITY`, `CSTSTATE`, `SCTTIME`) VALUES
(1, 1, 'Raviraj', 'raviraj@gmail.com', '2147483647', 'Amroli', 'Surat', 'Gujarat', '2024-03-02 15:26:03'),
(1, 2, 'Monajit', 'monajit@gmail.com', '2147483647', 'Tarsadi, Bardoli', 'Surat', 'Gujarat', '2024-03-02 15:28:46'),
(1, 3, 'Jemin', 'jemin@gmail.com', '8945786954', 'Varachha', 'Surat', 'Guj', '2024-03-02 15:30:39');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `UID` int(100) NOT NULL,
  `PID` int(100) NOT NULL,
  `PNAME` varchar(100) NOT NULL,
  `PCODE` varchar(100) NOT NULL,
  `PCATEGORY` varchar(100) NOT NULL,
  `PCOST` int(100) NOT NULL,
  `PPRICE` int(100) NOT NULL,
  `PQUANTITY` int(100) NOT NULL,
  `PDESC` varchar(255) NOT NULL,
  `PIMAGE` varchar(1000) NOT NULL,
  `PTIME` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`UID`, `PID`, `PNAME`, `PCODE`, `PCATEGORY`, `PCOST`, `PPRICE`, `PQUANTITY`, `PDESC`, `PIMAGE`, `PTIME`) VALUES
(1, 1, 'Milk', '101', 'Liquid', 11, 20, 75, '', 'D:/xamp/htdocs/SMS/uploads/Milk.jpg', '2024-03-02 12:22:43'),
(1, 2, 'Chhas', '111', 'Liquid', 9, 16, 20, '', 'D:/xamp/htdocs/SMS/uploads/Milk.jpg', '2024-03-02 12:22:43'),
(2, 4, 'Marker (Permanent, Black)', 'MRK101', 'Stationery', 13, 30, 22, '', '', '2024-03-16 16:17:59');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `UID` int(100) NOT NULL,
  `PRID` int(100) NOT NULL,
  `PRDATE` varchar(100) NOT NULL,
  `PRPRODUCT` varchar(255) NOT NULL,
  `PRSUPPLIER` varchar(255) NOT NULL,
  `PRRECEIVE` varchar(255) NOT NULL,
  `PRTAX` varchar(100) NOT NULL,
  `PRQUANTITY` varchar(100) NOT NULL,
  `PRPAYSTATUS` varchar(100) NOT NULL,
  `PRPAYMENT` varchar(100) NOT NULL,
  `PRTIME` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`UID`, `PRID`, `PRDATE`, `PRPRODUCT`, `PRSUPPLIER`, `PRRECEIVE`, `PRTAX`, `PRQUANTITY`, `PRPAYSTATUS`, `PRPAYMENT`, `PRTIME`) VALUES
(1, 1, '2024-02-18', 'Milk', 'Test Supplier', 'Received', 'No Tax', '25', 'Paid', '275/-', '2024-03-02 12:22:23'),
(1, 2, '2024-02-18', 'Pepsi', 'Test Supplier', 'Received', 'No Tax', '58', 'Paid', '1158/-', '2024-03-02 12:22:23'),
(1, 3, '2024-02-18', 'Pepsi', 'Select Supplier', 'Received', 'No Tax', '50', 'Paid', '521/-', '2024-03-02 12:22:23'),
(1, 4, '2024-02-18', 'Pepsi', 'Select Supplier', 'Received', 'No Tax', '50', 'Paid', '521/-', '2024-03-02 12:22:23'),
(1, 5, '2024-02-18', 'Pepsi', 'Select Supplier', 'Received', 'No Tax', '50', 'Paid', '521/-', '2024-03-02 12:22:23'),
(1, 6, '2024-02-18', 'Pepsi', 'Select Supplier', 'Received', 'No Tax', '50', 'Paid', '521/-', '2024-03-02 12:22:23'),
(1, 7, '2024-02-18', 'Pepsi', 'Select Supplier', 'Received', 'No Tax', '50', 'Paid', '521/-', '2024-03-02 12:22:23'),
(1, 8, '2024-02-18', 'Pepsi', 'Select Supplier', 'Received', 'No Tax', '50', 'Paid', '521/-', '2024-03-02 12:22:23'),
(1, 9, '2024-02-18', 'Pepsi', 'Select Supplier', 'Received', 'No Tax', '50', 'Paid', '521/-', '2024-03-02 12:22:23'),
(1, 10, '2024-02-18', 'Pepsi', 'Select Supplier', 'Received', 'No Tax', '50', 'Paid', '521/-', '2024-03-02 12:22:23');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `UID` int(100) NOT NULL,
  `RID` int(100) NOT NULL,
  `RDATE` date NOT NULL,
  `RBILLER` varchar(255) NOT NULL,
  `RCUSTOMER` varchar(255) NOT NULL,
  `RPRODUCT` varchar(255) NOT NULL,
  `RTOTAL` varchar(255) NOT NULL,
  `RGST` varchar(100) NOT NULL,
  `RIMAGE` varchar(255) NOT NULL,
  `RTIME` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`UID`, `RID`, `RDATE`, `RBILLER`, `RCUSTOMER`, `RPRODUCT`, `RTOTAL`, `RGST`, `RIMAGE`, `RTIME`) VALUES
(1, 2, '2024-03-02', 'Test Biller', 'Ravi', 'Milk', '19', 'No Tax', 'D:/xamp/htdocs/SMS/uploads/2023-11-05 (3).png', '2024-03-02 14:38:18');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `UID` int(100) NOT NULL,
  `SLID` int(100) NOT NULL,
  `SLDATE` date NOT NULL,
  `SLBILLER` varchar(255) NOT NULL,
  `SLPRODUCT` varchar(255) NOT NULL,
  `SLCUSTOMER` varchar(255) NOT NULL,
  `SLTAX` varchar(100) NOT NULL,
  `SLQUANTITY` varchar(100) NOT NULL,
  `SLSTATUS` varchar(100) NOT NULL,
  `SLTOTALPAY` int(100) NOT NULL,
  `SLPAYSTATUS` varchar(100) NOT NULL,
  `SLIMAGE` varchar(255) NOT NULL,
  `SLTIME` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`UID`, `SLID`, `SLDATE`, `SLBILLER`, `SLPRODUCT`, `SLCUSTOMER`, `SLTAX`, `SLQUANTITY`, `SLSTATUS`, `SLTOTALPAY`, `SLPAYSTATUS`, `SLIMAGE`, `SLTIME`) VALUES
(1, 1, '2024-02-17', 'Monu', 'Milk', 'Ravi', 'No Tax', '5', 'Completed', 90, 'Paid', 'D:/xamp/htdocs/SMS/uploads/Milk.jpg', '2024-03-02 12:21:22'),
(1, 2, '2024-02-17', 'Monu', 'Milk', 'Ravi', 'No Tax', '5', 'Completed', 80, 'Paid', 'D:/xamp/htdocs/SMS/uploads/Milk.jpg', '2024-03-02 12:21:22'),
(1, 3, '2024-02-17', 'Monu', 'Milk', 'Ravi', 'No Tax', '5', 'Completed', 53, 'Paid', 'D:/xamp/htdocs/SMS/uploads/Milk.jpg', '2024-03-02 12:21:22'),
(1, 4, '2024-02-17', 'Monu', 'Milk', 'Ravi', 'No Tax', '5', 'Completed', 84, 'Paid', 'D:/xamp/htdocs/SMS/uploads/Milk.jpg', '2024-03-02 12:21:22'),
(1, 5, '2024-02-18', 'Monu', 'Chhas', 'Ravi', 'No Tax', '5', 'Completed', 75, 'Paid', 'D:/xamp/htdocs/SMS/uploads/Milk.jpg', '2024-03-02 12:21:22'),
(1, 6, '2024-02-18', 'Monu', 'Chhas', 'Ravi', 'No Tax', '5', 'Completed', 65, 'Paid', '', '2024-03-02 12:21:22'),
(2, 7, '2024-03-16', 'Monu', 'Marker (Permanent, Black)', 'Ravi', 'No Tax', '5', 'Completed', 130, 'Paid', '', '2024-03-16 16:18:50'),
(2, 8, '2024-03-16', 'Monu', 'Marker (Permanent, Black)', 'Sonu', 'No Tax', '3', 'Completed', 90, 'Paid', '', '2024-03-16 16:19:27');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `SID` int(100) NOT NULL,
  `SNAME` varchar(100) NOT NULL,
  `STNAME` varchar(100) NOT NULL,
  `SEMAIL` varchar(100) NOT NULL,
  `SPHONE` varchar(50) NOT NULL,
  `SBDATE` varchar(100) NOT NULL,
  `SADDRESS` varchar(255) NOT NULL,
  `SPASS` varchar(100) NOT NULL,
  `OTP` int(100) NOT NULL,
  `STIME` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`SID`, `SNAME`, `STNAME`, `SEMAIL`, `SPHONE`, `SBDATE`, `SADDRESS`, `SPASS`, `OTP`, `STIME`) VALUES
(1, 'Ishan Mahida', 'Imart', 'ishansinhmahida95@gmail.com', '9988778899', '2005-12-13', 'Surat, Gujarat', '$2y$10$VImsuTtwcFcpEeFWeMH2zuTiD5/4DRutTAKXTyvVloIhhvIRGvUom', 701746, '2024-03-02 12:19:58'),
(2, 'Ishu', 'Smart Store', 'ishanmahida123@gmail.com', '8320998870', '', '', '$2y$10$VImsuTtwcFcpEeFWeMH2zuTiD5/4DRutTAKXTyvVloIhhvIRGvUom', 0, '2024-03-02 12:19:58');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `UID` int(100) NOT NULL,
  `SPID` int(100) NOT NULL,
  `SPCOMPNAME` varchar(100) NOT NULL,
  `SPNAME` varchar(100) NOT NULL,
  `SPEMAIL` varchar(100) NOT NULL,
  `SPNUMBER` varchar(50) NOT NULL,
  `SPGST` varchar(100) NOT NULL,
  `SPADD` varchar(255) NOT NULL,
  `SPCITY` varchar(100) NOT NULL,
  `SPSTATE` varchar(100) NOT NULL,
  `SPCOUNTRY` varchar(100) NOT NULL,
  `SPTIME` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`UID`, `SPID`, `SPCOMPNAME`, `SPNAME`, `SPEMAIL`, `SPNUMBER`, `SPGST`, `SPADD`, `SPCITY`, `SPSTATE`, `SPCOUNTRY`, `SPTIME`) VALUES
(1, 1, 'Pepsi', 'Monu', 'monu@gmail.com', '2147483647', 'FTISO154', 'Tarsadi', 'Surat', 'Gujarat', 'India', '2024-03-02 12:22:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CID`),
  ADD KEY `fk3_user_id` (`UID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CSTID`),
  ADD KEY `fk_user_id6` (`UID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`PID`),
  ADD KEY `fk_user_id` (`UID`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`PRID`),
  ADD KEY `fk2_user_id` (`UID`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`RID`),
  ADD KEY `fk_user_id5` (`UID`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`SLID`),
  ADD KEY `fk1_user_id` (`UID`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`SID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SPID`),
  ADD KEY `fk_user_id4` (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CSTID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `PID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `PRID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `RID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `SLID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `SID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `SPID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `fk3_user_id` FOREIGN KEY (`UID`) REFERENCES `store` (`SID`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk_user_id6` FOREIGN KEY (`UID`) REFERENCES `store` (`SID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`UID`) REFERENCES `store` (`SID`);

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `fk2_user_id` FOREIGN KEY (`UID`) REFERENCES `store` (`SID`);

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `fk_user_id5` FOREIGN KEY (`UID`) REFERENCES `store` (`SID`);

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `fk1_user_id` FOREIGN KEY (`UID`) REFERENCES `store` (`SID`);

--
-- Constraints for table `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `fk_user_id4` FOREIGN KEY (`UID`) REFERENCES `store` (`SID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
