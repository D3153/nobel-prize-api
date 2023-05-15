-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2023 at 09:29 PM
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
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '2022-12-01 08:11:50'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Ollo', 'oLLO', 'validemail@realemail.com', '$2y$15$q49pvGiUW1VN2xiiyID1EexqCLD0QKRQ03lVzMSFw5WqM3utaHSmO', '', '2023-04-28 15:19:51'),
(2, 'Craig', 'Justin', 'notfakeemail@realemail.com', '$2y$15$tL9BcsXMcmeFnPk/k/ijXODJkdRew3rMsAou.DjMdd8/sHSmsKAGm', 'admin', '2023-05-05 07:19:32'),
(3, 'Justin', 'Craig', 'veryrealemail@realemail.com', '$2y$15$sY25QSPp4tBE2ziF/q987e1Q.jLiOD/fPpboZj85L3/orUHXf9sg2', 'general', '2023-05-05 07:22:37'),
(14, 'Ollo', 'oLLO', 'email@email.com', '$2y$15$vLWECsi.SwECnNOdQp0YKeEtk29Dmjypzf8Z9gEdmzWlcKiL4ZqZG', '', '2023-05-12 14:53:37'),
(15, 'Ollo', 'oLLO', 'test@email.com', '$2y$15$IBNUBC5zxMmG5DsThTzhC.FP2CHEAdVjQY2tSLD7rduXEwl.4freK', '', '2023-05-12 14:55:16'),
(16, 'Ollo', 'oLLO', 'tester@email.com', '$2y$15$.koK4q2qYsIk2smRmQX0du4d/ze5n3s.Ja2zng3FckAfpBv7ERFQW', '', '2023-05-12 15:04:56'),
(17, 'Ollo', 'oLLO', 'testers@email.com', '$2y$15$atph7r38pCCbrgEVV0CWvOolXmTgrSi4vGtyRZd4tEPiqEXrPRXeu', '', '2023-05-12 15:08:02'),
(18, 'Ollo', 'oLLO', 'oioioi@email.com', '$2y$15$yxM2MwOIuxb4FQUlOPRl3.APOyG5LXnT.7ICDw697ASDi4GCK2Vz6', '', '2023-05-12 15:09:08'),
(19, 'Ollo', 'oLLO', 'anotheroioioi@email.com', '$2y$15$S3eqpjn01VaqhQSC55gON.wiAYnihLn9NJkSY0ogvtFfHrMnY.WNO', '', '2023-05-12 15:12:04'),
(20, 'Ollo', 'oLLO', 'bleh@email.com', '$2y$15$XXYwImvEs/844j0Cv7h.vOtr4jno2bDud3R7XToQYs98AaoqACI6a', '', '2023-05-12 15:14:00'),
(21, 'Ollo', 'oLLO', 'hgh@email.com', '$2y$15$i4HO4cUCqbtZjH5aEXEwLep6JmXxTrONyfMNneSCPVDypoV2R1Rse', '', '2023-05-12 15:18:18'),
(22, 'Ollo', 'oLLO', 'blahhh@email.com', '$2y$15$JOOMFAikbFKVpS0PkZhpNeq30KXl0vmvqPzisbkjyf4opEYchywPC', '', '2023-05-12 15:21:35'),
(23, 'Ollo', 'oLLO', 'cragino@email.com', '$2y$15$5hqzCh5UbRpLogbSjbjacOXuG3BikpMk1xw2MScLWg8eIfL7zurni', '', '2023-05-12 15:22:08'),
(24, 'Ollo', 'oLLO', 'jo@email.com', '$2y$15$GdzDxkpmHNgsE9Ts9Xsi/.6cUBog8usD57dqyxoded4.kNJ.yvh/m', '', '2023-05-12 15:24:02'),
(25, 'Frosty', 'Bee', 'sleiman@email.com', '$2y$15$LyXowfXzke7entNcRIyNeeAD9ooUcMPuTijsp4lr/pH6LABGrqa8m', 'general', '2023-05-15 06:22:57');

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
(5, 'Piazza Giosuè Carducci, 5', 'Bologna', 'Italy', 'Emilia-Romagna', '40125 '),
(6, 'street name', 'shity', 'country', 'state', 'o4j7d2'),
(7, '2', '1', '122', '24@gmail.com', '45k7k6');

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
(6, 6, 'Nobel Prize in Economics', 'It is an award funded by Sveriges Riksbank and is annually awarded by the Royal Swedish Academy of Sciences to researchers in the field of economic sciences.'),
(7, 5, 'Updated Name', 'Test Desc');

-- --------------------------------------------------------

--
-- Table structure for table `awards_received`
--

DROP TABLE IF EXISTS `awards_received`;
CREATE TABLE `awards_received` (
  `receivedid` int(11) NOT NULL,
  `laureateid` int(11) NOT NULL,
  `awardid` int(11) NOT NULL,
  `yearreceived` int(8) NOT NULL,
  `reason` varchar(250) NOT NULL,
  `prize_amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `awards_received`
--

INSERT INTO `awards_received` (`receivedid`, `laureateid`, `awardid`, `yearreceived`, `reason`, `prize_amount`) VALUES
(1, 1, 1, 1904, 'For his investigations of the densities of the most important gases and for his discovery of argon in connection with these studies.', 0),
(2, 3, 2, 1905, 'In recognition of his services in the advancement of organic chemistry and the chemical industry through his work on organic dyes and hydroaromatic compounds.', 0),
(3, 2, 3, 1904, 'In recognition of his work on the physiology of digestion through which knowledge on vital aspects of the subject has been transformed and enlarged.', 0),
(4, 5, 4, 1906, 'Not only in consideration of his deep learning and critical research but above all as a tribute to the creative energy freshness of style and lyrical force which characterize his poetic masterpieces.', 0),
(5, 4, 5, 1906, 'For his role in bringing to an end the bloody war recently waged between two of the world\'s great powers Japan and Russia.', 0);

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
(1, 'Chemistry', 'The branch of science concerned with the nature and properties of matter and energy.'),
(2, 'Chemistry', 'The branch of science that deals with the identification of the substances of which matter is composed; the investigation of their properties and the ways in which they interact, combine, and change; and the use of these processes to form new substances'),
(3, 'Physiology/Medicine', 'The branch of science that deals with the normal functions of living organisms and their parts and/or contributes to disease prevention.'),
(4, 'Literature', 'The branch of knowledge for written works, especially those considered of superior or lasting artistic merit.'),
(5, 'Chemistry', 'The branch of science concerned with the nature and properties of matter and energy.'),
(6, 'Economics', 'The branch of knowledge concerned with the production, consumption, and transfer of wealth.');

-- --------------------------------------------------------

--
-- Table structure for table `logging`
--

DROP TABLE IF EXISTS `logging`;
CREATE TABLE `logging` (
  `log_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(150) NOT NULL,
  `user_action` varchar(255) NOT NULL,
  `logged_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `logging`
--

INSERT INTO `logging` (`log_id`, `email`, `user_action`, `logged_at`, `user_id`) VALUES
(1, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-08 07:10:01', 2),
(2, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-08 07:10:21', 2),
(3, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-08 07:10:22', 2),
(4, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-08 07:10:22', 2),
(5, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-08 07:10:22', 2),
(6, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-08 07:10:22', 2),
(7, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/token', '2023-05-08 07:21:28', 2),
(8, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/token', '2023-05-08 07:21:45', 2),
(9, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/token', '2023-05-08 07:22:22', 2),
(10, 'validemail@realemail.com', '127.0.0.1 /nobel-prize-api/account', '2023-05-08 07:32:00', 1),
(11, 'validemail@realemail.com', '127.0.0.1 /nobel-prize-api/account', '2023-05-08 07:46:19', 1),
(12, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-08 07:47:13', 2),
(13, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/token', '2023-05-10 05:31:40', 2),
(14, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-10 05:31:56', 2),
(15, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-10 05:33:22', 2),
(16, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-10 05:33:28', 2),
(17, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-10 05:33:32', 2),
(18, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-10 05:33:38', 2),
(19, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-10 05:33:47', 2),
(20, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-10 05:34:07', 2),
(21, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-10 05:36:17', 2),
(22, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-10 05:36:20', 2),
(23, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/nominations', '2023-05-10 05:36:35', 2),
(24, 'validemail@realemail.com', '127.0.0.1 /nobel-prize-api/account', '2023-05-12 14:53:19', 1),
(25, 'test@email.com', '127.0.0.1 /nobel-prize-api/account', '2023-05-12 15:04:51', 15),
(26, 'tester@email.com', '127.0.0.1 /nobel-prize-api/account', '2023-05-12 15:07:47', 16),
(27, 'tester@email.com', '127.0.0.1 /nobel-prize-api/account', '2023-05-12 15:07:50', 16),
(28, 'tester@email.com', '127.0.0.1 /nobel-prize-api/account', '2023-05-12 15:07:55', 16),
(29, 'tester@email.com', '127.0.0.1 /nobel-prize-api/account', '2023-05-12 15:07:58', 16),
(30, 'tester@email.com', '127.0.0.1 /nobel-prize-api/account', '2023-05-12 15:07:59', 16),
(31, 'cragino@email.com', '127.0.0.1 /nobel-prize-api/account', '2023-05-12 15:22:10', 23),
(32, 'jo@email.com', '127.0.0.1 /nobel-prize-api/account', '2023-05-12 15:24:04', 24),
(33, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/token', '2023-05-15 06:08:51', 2),
(34, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/', '2023-05-15 06:09:20', 2),
(35, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/', '2023-05-15 06:09:27', 2),
(36, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:09:58', 2),
(37, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:10:03', 2),
(38, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:10:08', 2),
(39, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:10:11', 2),
(40, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/nominations', '2023-05-15 06:15:19', 2),
(41, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/publications', '2023-05-15 06:15:30', 2),
(42, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/awards', '2023-05-15 06:17:50', 2),
(43, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/organizations', '2023-05-15 06:17:51', 2),
(44, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/fields', '2023-05-15 06:17:56', 2),
(45, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/account', '2023-05-15 06:22:58', 25),
(46, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/token', '2023-05-15 06:23:21', 25),
(47, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:23:37', 25),
(48, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:24:02', 25),
(49, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:24:47', 25),
(50, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:25:00', 25),
(51, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:25:16', 25),
(52, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:25:19', 25),
(53, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:25:23', 25),
(54, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:25:25', 25),
(55, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:25:30', 25),
(56, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:25:32', 25),
(57, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:25:36', 25),
(58, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:25:38', 25),
(59, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/nominations', '2023-05-15 06:28:18', 25),
(60, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people/date', '2023-05-15 06:28:42', 2),
(61, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:31:11', 25),
(62, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/people/date', '2023-05-15 06:39:27', 2),
(63, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:43:25', 25),
(64, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:43:30', 25),
(65, 'sleiman@email.com', '127.0.0.1 /nobel-prize-api/people', '2023-05-15 06:44:08', 25),
(66, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/token', '2023-05-15 06:49:54', 2),
(67, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/publications', '2023-05-15 06:50:02', 2),
(68, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/publications', '2023-05-15 07:01:14', 2),
(69, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/publications', '2023-05-15 07:01:38', 2),
(70, 'notfakeemail@realemail.com', '127.0.0.1 /nobel-prize-api/publications', '2023-05-15 07:10:08', 2);

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
  `yearofnomination` int(8) NOT NULL,
  `nominators` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `nominations`
--

INSERT INTO `nominations` (`nominationid`, `laureateid`, `fieldid`, `nomination_reason`, `yearofnomination`, `nominators`) VALUES
(1, 1, 1, 'For his investigations of the densities of the most important gases and for his discovery of argon in connection with these studies.', 1904, 'Wilhelm Hallwachs, Max Planck, Friedrich Kohlrausch, Norman Lockyer, Oliver Lodge, John Lubbock, Simon Thompson, Sir Joseph Thomson, William Thomson, Lord Kelvin, Jacobus van´t Hoff, Emil Warburg'),
(2, 3, 2, 'In recognition of his services in the advancement of organic chemistry and the chemical industry through his work on organic dyes and hydroaromatic compounds.', 1905, 'Robert Behrend, Emil Erlenmeyer, Rudolf Nietzki, Hermann Ost, Hans Rupe, Karl Seubert, Johannes Thiele, Theodore Richards, Eduard Schaer, Jacob Volhard'),
(3, 2, 3, 'In recognition of his work on the physiology of digestion through which knowledge on vital aspects of the subject has been transformed and enlarged.', 1904, 'Vincenz Czerny, V Podwyssocki, Carl Santesson, Johan Johansson'),
(4, 5, 4, 'Not only in consideration of his deep learning and critical research but above all as a tribute to the creative energy freshness of style and lyrical force which characterize his poetic masterpieces.', 1906, 'Ugo Balzani, Carl Bildt, Johan Vising, Rodolfo Renier'),
(5, 4, 5, 'For his role in bringing to an end the bloody war recently waged between two of the world\'s great powers Japan and Russia.', 1906, 'Simeon Baldwin, Heinrich Harburger, Pratt Judson, 3 American professors'),
(6, 4, 3, 'reason', 2020, 'me, you, Craig, Jo'),
(12, 2, 4, 'North America', 2312, 'asjkdhsajkh'),
(13, 2, 4, 'North America', 2132131, 'asjkdhsajkh'),
(14, 1, 5, 'Reason', 1969, 'me, you, Jo, Craig');

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
(3, 3, 3, 'Munich University', '+49 8921803156', NULL),
(4, 2, 3, 'notfakeorg', '123456789', 'notfakeemail@realemail.com'),
(7, 2, 1, '122', '24@gmail.com', '24@gmail.com');

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
(5, 5, 'Giosuè', 'Carducci', '1835-07-27', NULL, NULL, 'Italian Poet, Writer, Literary Critic, Teacher'),
(6, 1, 'Bob', 'Bobster', '6969-01-10', '123456789', 'notfakeemail@realemail.com', 'Gangster'),
(7, 1, 'Bob', 'Bobby', '6969-01-10', NULL, NULL, 'Gangster'),
(8, 2, '4', 'North America', '0000-00-00', NULL, NULL, '21312');

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
(1, 1, 1, 'name', 'The discovery of Argon and how to Isolate it from Air.'),
(2, 2, 2, 'Preparation of the blue indigo from o-nitrobenzaldehyde', 'The steps of how to make the indigo dye, without extracting it from plants, for dye manufacturing. '),
(3, 2, 3, 'The Work of the Digestive Glands', 'Finding and understanding how the digestive glands work through experiments.'),
(4, 5, 4, 'Hymn to Satan', 'A collection of poems that criticizes Christianity.'),
(25, 4, 4, 'name', 'new desc'),
(30, 1, 3, 'name', 'desc'),
(31, 1, 3, 'name', 'desc'),
(32, 1, 3, 'name', 'desc'),
(33, 1, 3, 'name', 'desc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

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
-- Indexes for table `logging`
--
ALTER TABLE `logging`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_to_logging` (`user_id`);

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
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `addressid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `awardid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- AUTO_INCREMENT for table `logging`
--
ALTER TABLE `logging`
  MODIFY `log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `nominations`
--
ALTER TABLE `nominations`
  MODIFY `nominationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `orgid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `laureateid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `publications`
--
ALTER TABLE `publications`
  MODIFY `publicationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=908;

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
-- Constraints for table `logging`
--
ALTER TABLE `logging`
  ADD CONSTRAINT `user_to_logging` FOREIGN KEY (`user_id`) REFERENCES `account` (`user_id`);

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
