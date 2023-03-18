-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2023 at 05:43 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nobelprize_db`
--
CREATE DATABASE IF NOT EXISTS `nobelprize_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `nobelprize_db`;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `addressid` int(11) NOT NULL,
  `streetname` varchar(30) NOT NULL,
  `city` varchar(25) NOT NULL,
  `country` varchar(25) NOT NULL,
  `state` varchar(30) NOT NULL,
  `zipcode` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='zip and postal code might need to be relooked';

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

DROP TABLE IF EXISTS `awards`;
CREATE TABLE `awards` (
  `awardid` int(11) NOT NULL,
  `fieldid` int(11) NOT NULL,
  `award_name` varchar(30) NOT NULL,
  `prize_amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `awards_received`
--

DROP TABLE IF EXISTS `awards_received`;
CREATE TABLE `awards_received` (
  `receivedid` int(11) NOT NULL,
  `laureateid` int(11) NOT NULL,
  `awardid` int(11) NOT NULL,
  `yearreceived` date NOT NULL,
  `reason` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

DROP TABLE IF EXISTS `fields`;
CREATE TABLE `fields` (
  `fieldid` int(11) NOT NULL,
  `field_name` varchar(30) NOT NULL,
  `field_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nominations`
--

DROP TABLE IF EXISTS `nominations`;
CREATE TABLE `nominations` (
  `nominatioid` int(11) NOT NULL,
  `laureateid` int(11) NOT NULL,
  `fieldid` int(11) NOT NULL,
  `nomination_reason` varchar(50) NOT NULL,
  `yearofnomination` date NOT NULL,
  `nominators` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
CREATE TABLE `organizations` (
  `orgid` int(11) NOT NULL,
  `laureateid` int(11) NOT NULL,
  `addressid` int(11) NOT NULL,
  `orgname` varchar(30) NOT NULL,
  `phonenumber` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
CREATE TABLE `people` (
  `laureateid` int(11) NOT NULL,
  `addressid` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `phonenumber` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `occupation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

DROP TABLE IF EXISTS `publications`;
CREATE TABLE `publications` (
  `publicationid` int(11) NOT NULL,
  `laureateid` int(11) NOT NULL,
  `fieldid` int(11) NOT NULL,
  `publication_name` varchar(50) NOT NULL,
  `publication_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`addressid`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`awardid`),
  ADD KEY `award_to_field` (`fieldid`);

--
-- Indexes for table `awards_received`
--
ALTER TABLE `awards_received`
  ADD PRIMARY KEY (`receivedid`),
  ADD KEY `awardreceived_to_people` (`laureateid`),
  ADD KEY `awardreceived_to_award` (`awardid`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`fieldid`);

--
-- Indexes for table `nominations`
--
ALTER TABLE `nominations`
  ADD PRIMARY KEY (`nominatioid`),
  ADD KEY `nominations_to_people` (`laureateid`),
  ADD KEY `nominations_to_field` (`fieldid`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`orgid`),
  ADD KEY `org_to_people` (`laureateid`),
  ADD KEY `org_to_address` (`addressid`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`laureateid`),
  ADD KEY `address_to_people` (`addressid`);

--
-- Indexes for table `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`publicationid`),
  ADD KEY `publication_to_people` (`laureateid`),
  ADD KEY `publication_to_field` (`fieldid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `award_to_field` FOREIGN KEY (`fieldid`) REFERENCES `fields` (`fieldid`) ON DELETE CASCADE;

--
-- Constraints for table `awards_received`
--
ALTER TABLE `awards_received`
  ADD CONSTRAINT `awardreceived_to_award` FOREIGN KEY (`awardid`) REFERENCES `awards` (`awardid`) ON DELETE CASCADE,
  ADD CONSTRAINT `awardreceived_to_people` FOREIGN KEY (`laureateid`) REFERENCES `people` (`laureateid`) ON DELETE CASCADE;

--
-- Constraints for table `nominations`
--
ALTER TABLE `nominations`
  ADD CONSTRAINT `nominations_to_field` FOREIGN KEY (`fieldid`) REFERENCES `fields` (`fieldid`) ON DELETE CASCADE,
  ADD CONSTRAINT `nominations_to_people` FOREIGN KEY (`laureateid`) REFERENCES `people` (`laureateid`) ON DELETE CASCADE;

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `org_to_address` FOREIGN KEY (`addressid`) REFERENCES `address` (`addressid`) ON DELETE CASCADE,
  ADD CONSTRAINT `org_to_people` FOREIGN KEY (`laureateid`) REFERENCES `people` (`laureateid`) ON DELETE CASCADE;

--
-- Constraints for table `people`
--
ALTER TABLE `people`
  ADD CONSTRAINT `address_to_people` FOREIGN KEY (`addressid`) REFERENCES `address` (`addressid`) ON DELETE CASCADE;

--
-- Constraints for table `publications`
--
ALTER TABLE `publications`
  ADD CONSTRAINT `publication_to_field` FOREIGN KEY (`fieldid`) REFERENCES `fields` (`fieldid`) ON DELETE CASCADE,
  ADD CONSTRAINT `publication_to_people` FOREIGN KEY (`laureateid`) REFERENCES `people` (`laureateid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
