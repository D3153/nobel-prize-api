-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2023 at 05:18 PM
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
  `streetname` varchar(75) NOT NULL,
  `city` varchar(25) NOT NULL,
  `country` varchar(25) NOT NULL,
  `state` varchar(30) NOT NULL,
  `zipcode` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='zip and postal code might need to be relooked';

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`addressid`, `streetname`, `city`, `country`, `state`, `zipcode`) VALUES
(1, '21 Albemarle St', 'London', 'United Kingdom', 'England', 'W1S4BS'),
(2, 'Face of Academician Lebedev lit. F', 'St Petersburg', 'Russia', 'Leningrad Oblast', '194044'),
(3, 'Geschwister-Scholl-Platz 1', 'Maxvorstadt', 'Germany', 'Munich', '80539'),
(4, '20 Sagamore Hill Rd', 'Oyster Bay', 'United States', 'New York', '11771'),
(5, 'Piazza Giosuè Carducci, 5', 'Bologna', 'Italy', 'Emilia-Romagna', '40125 ');

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

DROP TABLE IF EXISTS `awards`;
CREATE TABLE `awards` (
  `awardid` int(11) NOT NULL,
  `fieldid` int(11) NOT NULL,
  `award_name` varchar(75) NOT NULL,
  `award_desc` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `awards`
--

INSERT INTO `awards` (`awardid`, `fieldid`, `award_name`, `award_desc`) VALUES
(1, 1, 'Nobel Prize in Physics', 'A yearly award given by the Royal Swedish Academy of Sciences for those who have made the most outstanding contributions for humankind in the field of physics.'),
(2, 2, 'Nobel Prize in Chemistry', 'A yearly award given by the Royal Swedish Academy of Sciences to scientists in the various fields of chemistry.'),
(3, 3, 'Nobel Prize in Physiology or Medicine', 'A yearly award given by the Nobel Assembly at the Karolinska Institute for outstanding discoveries in physiology or medicine.'),
(4, 4, 'Nobel Prize in Literature', 'A Swedish literature prize that is awarded annually to an author from any country who has produced the most outstanding work in an idealistic direction in the field of literature.'),
(5, 5, 'Nobel Peace Prize', 'It has been awarded annually (with some exceptions) to those who have done the most or the best work for fraternity between nations, for the abolition or reduction of standing armies and for the holding and promotion of peace congresses.'),
(6, 6, 'Nobel Prize in Economics', 'It is an award funded by Sveriges Riksbank and is annually awarded by the Royal Swedish Academy of Sciences to researchers in the field of economic sciences.');

-- --------------------------------------------------------

--
-- Table structure for table `awards_received`
--

DROP TABLE IF EXISTS `awards_received`;
CREATE TABLE `awards_received` (
  `receivedid` int(11) NOT NULL,
  `laureateid` int(11) NOT NULL,
  `awardid` int(11) NOT NULL,
  `yearreceived` varchar(8) NOT NULL,
  `reason` varchar(250) NOT NULL,
  `prize_amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `awards_received`
--

INSERT INTO `awards_received` (`receivedid`, `laureateid`, `awardid`, `yearreceived`, `reason`, `prize_amount`) VALUES
(1, 1, 1, '1904', 'For his investigations of the densities of the most important gases and for his discovery of argon in connection with these studies.', 0),
(2, 3, 2, '1905', 'In recognition of his services in the advancement of organic chemistry and the chemical industry through his work on organic dyes and hydroaromatic compounds.', 0),
(3, 2, 3, '1904', 'In recognition of his work on the physiology of digestion through which knowledge on vital aspects of the subject has been transformed and enlarged.', 0),
(4, 5, 4, '1906', 'Not only in consideration of his deep learning and critical research but above all as a tribute to the creative energy freshness of style and lyrical force which characterize his poetic masterpieces.', 0),
(5, 4, 5, '1906', 'For his role in bringing to an end the bloody war recently waged between two of the world\'s great powers Japan and Russia.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

DROP TABLE IF EXISTS `fields`;
CREATE TABLE `fields` (
  `fieldid` int(11) NOT NULL,
  `field_name` varchar(30) NOT NULL,
  `field_desc` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`fieldid`, `field_name`, `field_desc`) VALUES
(1, 'Physics', 'The branch of science concerned with the nature and properties of matter and energy.'),
(2, 'Chemistry', 'The branch of science that deals with the identification of the substances of which matter is composed; the investigation of their properties and the ways in which they interact, combine, and change; and the use of these processes to form new substances'),
(3, 'Physiology/Medicine', 'The branch of science that deals with the normal functions of living organisms and their parts and/or contributes to disease prevention.'),
(4, 'Literature', 'The branch of knowledge for written works, especially those considered of superior or lasting artistic merit.'),
(5, 'Peace', 'The field where fraternity between nations, for the abolition or reduction of standing armies and for the holding and promotion of peace congresses are acknowledged.'),
(6, 'Economics', 'The branch of knowledge concerned with the production, consumption, and transfer of wealth.');

-- --------------------------------------------------------

--
-- Table structure for table `nominations`
--

DROP TABLE IF EXISTS `nominations`;
CREATE TABLE `nominations` (
  `nominationid` int(11) NOT NULL,
  `laureateid` int(11) NOT NULL,
  `fieldid` int(11) NOT NULL,
  `nomination_reason` varchar(350) NOT NULL,
  `yearofnomination` varchar(8) NOT NULL,
  `nominators` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `nominations`
--

INSERT INTO `nominations` (`nominationid`, `laureateid`, `fieldid`, `nomination_reason`, `yearofnomination`, `nominators`) VALUES
(1, 1, 1, 'For his investigations of the densities of the most important gases and for his discovery of argon in connection with these studies.', '1904', 'Wilhelm Hallwachs, Max Planck, Friedrich Kohlrausch, Norman Lockyer, Oliver Lodge, John Lubbock, Simon Thompson, Sir Joseph Thomson, William Thomson, Lord Kelvin, Jacobus van´t Hoff, Emil Warburg'),
(2, 3, 2, 'In recognition of his services in the advancement of organic chemistry and the chemical industry through his work on organic dyes and hydroaromatic compounds.', '1905', 'Robert Behrend, Emil Erlenmeyer, Rudolf Nietzki, Hermann Ost, Hans Rupe, Karl Seubert, Johannes Thiele, Theodore Richards, Eduard Schaer, Jacob Volhard'),
(3, 2, 3, 'In recognition of his work on the physiology of digestion through which knowledge on vital aspects of the subject has been transformed and enlarged.', '1904', 'Vincenz Czerny, V Podwyssocki, Carl Santesson, Johan Johansson'),
(4, 5, 4, 'Not only in consideration of his deep learning and critical research but above all as a tribute to the creative energy freshness of style and lyrical force which characterize his poetic masterpieces.', '1906', 'Ugo Balzani, Carl Bildt, Johan Vising, Rodolfo Renier'),
(5, 4, 5, 'For his role in bringing to an end the bloody war recently waged between two of the world\'s great powers Japan and Russia.', '1906', 'Simeon Baldwin, Heinrich Harburger, Pratt Judson, 3 American professors');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
CREATE TABLE `organizations` (
  `orgid` int(11) NOT NULL,
  `laureateid` int(11) NOT NULL,
  `addressid` int(11) NOT NULL,
  `orgname` varchar(75) NOT NULL,
  `phonenumber` varchar(30) NOT NULL,
  `email` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`orgid`, `laureateid`, `addressid`, `orgname`, `phonenumber`, `email`) VALUES
(1, 1, 1, 'Royal Institution of Great Britain', '+44 20 7670 2955', 'ri@ri.ac.uk'),
(2, 2, 2, 'S. M. Kirov Military Medical Academy', '+7 812 292-32-63', NULL),
(3, 3, 3, 'Munich University', '+49 8921803156', NULL);

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

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`laureateid`, `addressid`, `first_name`, `last_name`, `dob`, `phonenumber`, `email`, `occupation`) VALUES
(1, 1, 'John William', 'Strutt', '1842-11-12', NULL, NULL, 'British Mathematician'),
(2, 2, 'Ivan Petrovich', 'Pavlov', '1849-09-26', NULL, NULL, 'Russian-Soviet Experimenter'),
(3, 3, 'Adolf', 'von Baeyer', '1835-10-31', NULL, NULL, 'German Chemist'),
(4, 4, 'Theodore', 'Roosevelt', '1858-10-27', NULL, NULL, '26th President of the United States'),
(5, 5, 'Giosuè', 'Carducci', '1835-07-27', NULL, NULL, 'Italian Poet, Writer, Literary Critic, Teacher');

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

DROP TABLE IF EXISTS `publications`;
CREATE TABLE `publications` (
  `publicationid` int(11) NOT NULL,
  `laureateid` int(11) NOT NULL,
  `fieldid` int(11) NOT NULL,
  `publication_name` varchar(100) NOT NULL,
  `publication_desc` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `publications`
--

INSERT INTO `publications` (`publicationid`, `laureateid`, `fieldid`, `publication_name`, `publication_desc`) VALUES
(1, 1, 1, 'Argon, a New Constituent of the Atmosphere', 'The discovery of Argon and how to Isolate it from Air.'),
(2, 3, 2, 'Preparation of blue indigo from o-nitrobenzaldehyde', 'The steps of how to make the indigo dye, without extracting it from plants, for dye manufacturing. '),
(3, 2, 3, 'The Work of the Digestive Glands', 'Finding and understanding how the digestive glands work through experiments.'),
(4, 5, 4, 'Hymn to Satan', 'A collection of poems that criticizes Christianity.');

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
  ADD PRIMARY KEY (`nominationid`),
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `addressid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `awardid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `awards_received`
--
ALTER TABLE `awards_received`
  MODIFY `receivedid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `fieldid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nominations`
--
ALTER TABLE `nominations`
  MODIFY `nominationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `orgid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `laureateid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `publications`
--
ALTER TABLE `publications`
  MODIFY `publicationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `award_to_field` FOREIGN KEY (`fieldid`) REFERENCES `fields` (`fieldid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `awards_received`
--
ALTER TABLE `awards_received`
  ADD CONSTRAINT `awardreceived_to_award` FOREIGN KEY (`awardid`) REFERENCES `awards` (`awardid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `awardreceived_to_people` FOREIGN KEY (`laureateid`) REFERENCES `people` (`laureateid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nominations`
--
ALTER TABLE `nominations`
  ADD CONSTRAINT `nomination_to_field` FOREIGN KEY (`fieldid`) REFERENCES `fields` (`fieldid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nomination_to_people` FOREIGN KEY (`laureateid`) REFERENCES `people` (`laureateid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `org_to_address` FOREIGN KEY (`addressid`) REFERENCES `address` (`addressid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `org_to_people` FOREIGN KEY (`laureateid`) REFERENCES `people` (`laureateid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `people`
--
ALTER TABLE `people`
  ADD CONSTRAINT `people_to_address` FOREIGN KEY (`addressid`) REFERENCES `address` (`addressid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `publications`
--
ALTER TABLE `publications`
  ADD CONSTRAINT `publication_to_field` FOREIGN KEY (`fieldid`) REFERENCES `fields` (`fieldid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_to_people` FOREIGN KEY (`laureateid`) REFERENCES `people` (`laureateid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
