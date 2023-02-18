-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: us-cdbr-east-06.cleardb.net
-- Generation Time: Feb 18, 2023 at 05:16 AM
-- Server version: 5.6.50-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `heroku_f92e6718b416bf8`
--
CREATE DATABASE IF NOT EXISTS `heroku_f92e6718b416bf8` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `heroku_f92e6718b416bf8`;

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `ID` int(10) UNSIGNED NOT NULL,
  `BILLINGDATE` date DEFAULT NULL,
  `HOMEOWNER` int(10) UNSIGNED NOT NULL,
  `COMPANY` int(10) UNSIGNED NOT NULL,
  `SERVICE` int(10) UNSIGNED DEFAULT NULL,
  `AMOUNT` float DEFAULT NULL,
  `PAYMENT` int(10) DEFAULT NULL,
  `PAIDDATE` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`ID`, `BILLINGDATE`, `HOMEOWNER`, `COMPANY`, `SERVICE`, `AMOUNT`, `PAYMENT`, `PAIDDATE`) VALUES
(4, '2023-02-17', 14, 14, 4, 200, 64, '2023-02-18'),
(34, '2021-01-01', 14, 14, 54, 6880, 14, '2021-01-02'),
(44, '2021-02-01', 14, 14, 54, 3200, 14, '2021-02-02'),
(54, '2021-03-01', 14, 14, 54, 2880, 14, '2021-03-02'),
(64, '2021-04-01', 14, 14, 54, 4089.6, 14, '2021-04-02'),
(74, '2021-05-01', 14, 14, 54, 3984, 14, '2021-05-02'),
(84, '2021-06-01', 14, 14, 54, 4704, 14, '2021-06-02'),
(94, '2021-07-01', 14, 14, 54, 3984, 14, NULL),
(104, '2021-08-01', 14, 14, 54, 3948.8, 14, NULL),
(114, '2021-09-01', 14, 14, 54, 4787.2, 14, NULL),
(124, '2021-10-01', 14, 14, 54, 3977.6, 14, NULL),
(134, '2021-11-01', 14, 14, 54, 4665.6, 14, NULL),
(144, '2021-12-01', 14, 14, 54, 3996.8, 14, NULL),
(154, '2022-01-01', 14, 14, 54, 4646.4, 14, NULL),
(164, '2022-02-01', 14, 14, 54, 4560, 14, NULL),
(174, '2022-03-01', 14, 14, 54, 4745.6, 14, NULL),
(184, '2022-04-01', 14, 14, 54, 4595.2, 14, NULL),
(194, '2022-05-01', 14, 14, 54, 3977.6, 14, NULL),
(204, '2022-06-01', 14, 14, 54, 4758.4, 14, '2022-06-01'),
(214, '2022-07-01', 14, 14, 54, 4019.2, 14, NULL),
(224, '2022-08-01', 14, 14, 54, 4662.4, 14, NULL),
(234, '2022-09-01', 14, 14, 54, 4560, 14, NULL),
(244, '2022-10-01', 14, 14, 54, 4310.4, 14, NULL),
(254, '2022-11-01', 14, 14, 54, 4710.4, 14, NULL),
(264, '2022-12-01', 14, 14, 54, 4313.6, 14, NULL),
(274, '2023-01-01', 14, 14, 54, 4563.2, 14, NULL),
(284, '2023-02-01', 14, 14, 54, 4569.6, 14, NULL),
(294, '2023-03-01', 14, 14, 54, 4736, 14, NULL),
(304, '2023-03-01', 14, 14, 54, 4736, 14, NULL),
(314, '2023-01-01', 14, 14, 54, 4595.2, 14, NULL),
(324, '2023-02-01', 14, 14, 54, 4560, 14, NULL),
(334, '2023-02-17', 144, 14, 4, 2, NULL, NULL),
(344, '2023-03-01', 234, 14, 54, 3968, NULL, NULL),
(354, '2023-02-18', 14, 14, 4, 2, 44, '2023-02-17'),
(374, '2023-02-18', 144, 14, 4, 2, NULL, NULL),
(384, '2023-03-01', 14, 14, 54, 4736, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `CREATEDATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TICKET` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `SENDER` int(10) UNSIGNED DEFAULT NULL,
  `TEXT` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`CREATEDATE`, `TICKET`, `SENDER`, `TEXT`) VALUES
('2023-02-17 19:08:56', 124, 124, 'hiii'),
('2023-02-17 19:27:14', 84, 124, 'hii'),
('2023-02-17 20:48:59', 364, 424, 'Hello, please help'),
('2023-02-18 03:09:06', 44, 14, 'Please help with uninstall');

-- --------------------------------------------------------

--
-- Table structure for table `chemical`
--

CREATE TABLE `chemical` (
  `ID` int(10) UNSIGNED NOT NULL,
  `NAME` varchar(30) DEFAULT NULL,
  `DESCRIPTION` varchar(30) DEFAULT NULL,
  `AMOUNT` int(11) DEFAULT NULL,
  `USAGETIME` int(11) DEFAULT NULL,
  `COMPANY` int(10) UNSIGNED DEFAULT NULL,
  `MEASUREMENT` varchar(50) NOT NULL,
  `PER1LWATER` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chemical`
--

INSERT INTO `chemical` (`ID`, `NAME`, `DESCRIPTION`, `AMOUNT`, `USAGETIME`, `COMPANY`, `MEASUREMENT`, `PER1LWATER`) VALUES
(4, 'chlorine', NULL, 247, NULL, 14, 'gram(g)', 4),
(24, 'chlorine', NULL, 187, NULL, 44, 'Litre(l)', 12),
(34, 'sodium', NULL, 120, NULL, 14, 'kilogram(kg)', 12),
(44, 'magnesium', NULL, 98, NULL, 14, 'centimetercube(cm3)', 6);

-- --------------------------------------------------------

--
-- Table structure for table `chemicalused`
--

CREATE TABLE `chemicalused` (
  `CHEMICAL` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `AMOUNT` int(11) DEFAULT NULL,
  `USEDATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chemicalused`
--

INSERT INTO `chemicalused` (`CHEMICAL`, `AMOUNT`, `USEDATE`) VALUES
(4, 6, '2023-02-16 15:34:54'),
(24, 12, '2023-02-17 07:35:14'),
(4, 47, '2023-02-17 17:43:27'),
(34, 3, '2023-02-17 17:43:42');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `COMPANY` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `HOMEOWNER` int(10) UNSIGNED DEFAULT NULL,
  `RATING` int(11) DEFAULT NULL,
  `COMMENT` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `ID` int(10) UNSIGNED NOT NULL,
  `NAME` varchar(30) DEFAULT NULL,
  `STREET` varchar(30) DEFAULT NULL,
  `POSTALCODE` int(11) DEFAULT NULL,
  `DESCRIPTION` varchar(50) DEFAULT NULL,
  `ACRAPATH` varchar(50) NOT NULL,
  `PHOTOPATH` varchar(50) NOT NULL,
  `ADMIN` int(10) UNSIGNED DEFAULT NULL,
  `NOOFSTAR` int(11) DEFAULT NULL,
  `NOOFRATE` int(11) DEFAULT NULL,
  `NUMBER` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`ID`, `NAME`, `STREET`, `POSTALCODE`, `DESCRIPTION`, `ACRAPATH`, `PHOTOPATH`, `ADMIN`, `NOOFSTAR`, `NOOFRATE`, `NUMBER`) VALUES
(14, 'company1', 'company3 street', 987654, 'company3', '74.pdf', '74.jpg', 74, 4, 5, NULL),
(34, 'company2', '123 street', 789657, 'company2', '154.pdf', 'company2.jpg', 154, 4, 1, NULL),
(44, 'company3', 'company3 street', 567432, 'company3', '164.pdf', 'company3.jpg', 164, NULL, NULL, NULL),
(114, 'comp0217', 'comp0217', 897657, 'comp0217 description', '434.pdf', 'imgnotfound.jpg', 434, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `ID` int(10) UNSIGNED NOT NULL,
  `EQUIPMENT` varchar(20) DEFAULT NULL,
  `HOMEOWNER` int(10) UNSIGNED DEFAULT NULL,
  `INSTALLTASK` int(10) UNSIGNED DEFAULT NULL,
  `UNINSTALLTASK` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`ID`, `EQUIPMENT`, `HOMEOWNER`, `INSTALLTASK`, `UNINSTALLTASK`) VALUES
(4, 'ee111', 14, 4, 0),
(14, '0216equip10', 144, 74, 0),
(24, 'ee1112', 14, NULL, 4),
(34, '0216equip11', 14, 104, 0),
(44, '0216equip15', 144, 114, 0);

-- --------------------------------------------------------

--
-- Table structure for table `equipstock`
--

CREATE TABLE `equipstock` (
  `TYPE` int(10) UNSIGNED DEFAULT NULL,
  `SERIAL` varchar(20) NOT NULL DEFAULT '',
  `PURCHASEDATE` date DEFAULT NULL,
  `COMPANY` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `equipstock`
--

INSERT INTO `equipstock` (`TYPE`, `SERIAL`, `PURCHASEDATE`, `COMPANY`) VALUES
(4, '0216equip10', '2023-02-16', 14),
(4, '0216equip11', '2023-02-16', 14),
(4, '0216equip12', '2023-02-16', 14),
(4, '0216equip13', '2023-02-16', 14),
(4, '0216equip14', '2023-02-16', 14),
(4, '0216equip15', '2023-02-16', 14),
(4, '0216equip16', '2023-02-16', 14),
(4, '0216equip17', '2023-02-16', 14),
(4, '0216equip18', '2023-02-16', 14),
(4, '0216equip19', '2023-02-16', 14),
(4, '0216equip2', '2023-02-16', 14),
(4, '0216equip20', '2023-02-16', 14),
(14, '0216equip21', '2023-02-17', 44),
(14, '0216equip22', '2023-02-17', 44),
(14, '0216equip23', '2023-02-17', 44),
(14, '0216equip24', '2023-02-17', 44),
(14, '0216equip25', '2023-02-17', 44),
(14, '0216equip26', '2023-02-17', 44),
(14, '0216equip27', '2023-02-17', 44),
(14, '0216equip28', '2023-02-17', 44),
(14, '0216equip29', '2023-02-17', 44),
(4, '0216equip3', '2023-02-16', 14),
(14, '0216equip30', '2023-02-17', 44),
(14, '0216equip31', '2023-02-17', 44),
(14, '0216equip32', '2023-02-17', 44),
(14, '0216equip33', '2023-02-17', 44),
(14, '0216equip34', '2023-02-17', 44),
(4, '0216equip4', '2023-02-16', 14),
(4, '0216equip5', '2023-02-16', 14),
(4, '0216equip6', '2023-02-16', 14),
(4, '0216equip7', '2023-02-16', 14),
(4, '0216equip8', '2023-02-16', 14),
(4, '0216equip9', '2023-02-16', 14),
(4, '0217equipment1', '2023-02-17', 14),
(4, '0217equipment10', '2023-02-17', 14),
(4, '0217equipment11', '2023-02-17', 14),
(4, '0217equipment12', '2023-02-17', 14),
(4, '0217equipment13', '2023-02-17', 14),
(4, '0217equipment3', '2023-02-17', 14),
(4, '0217equipment4', '2023-02-17', 14),
(4, '0217equipment5', '2023-02-17', 14),
(4, '0217equipment6', '2023-02-17', 14),
(4, '0217equipment7', '2023-02-17', 14),
(4, '0217equipment8', '2023-02-17', 14),
(4, '0217equipment9', '2023-02-17', 14),
(4, 'ee111', '2023-02-16', 14),
(14, 'ee1112', '2023-02-17', 44),
(4, 'ï»¿0216equip1', '2023-02-16', 14),
(4, 'ï»¿0217equipment2', '2023-02-17', 14),
(14, 'prem1', '2023-02-17', 44),
(14, 'tryyyy1', '2023-02-17', 44);

-- --------------------------------------------------------

--
-- Table structure for table `equiptype`
--

CREATE TABLE `equiptype` (
  `ID` int(10) UNSIGNED NOT NULL,
  `NAME` varchar(30) DEFAULT NULL,
  `DESCRIPTION` varchar(30) DEFAULT NULL,
  `AMOUNT` int(11) DEFAULT NULL,
  `REPLACEMENTPERIOD` int(11) DEFAULT NULL,
  `DEVICEGUARANTEE` int(11) DEFAULT NULL,
  `COMPANY` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `equiptype`
--

INSERT INTO `equiptype` (`ID`, `NAME`, `DESCRIPTION`, `AMOUNT`, `REPLACEMENTPERIOD`, `DEVICEGUARANTEE`, `COMPANY`) VALUES
(4, 'water meter', 'water meter', NULL, NULL, NULL, 14),
(14, 'water meter', 'water meter', NULL, NULL, NULL, 44);

-- --------------------------------------------------------

--
-- Table structure for table `homeowner`
--

CREATE TABLE `homeowner` (
  `ID` int(10) UNSIGNED NOT NULL,
  `STREET` varchar(30) DEFAULT NULL,
  `BLOCKNO` varchar(5) DEFAULT NULL,
  `UNITNO` varchar(6) DEFAULT NULL,
  `POSTALCODE` int(11) DEFAULT NULL,
  `AREA` varchar(10) DEFAULT NULL,
  `HOUSETYPE` varchar(50) DEFAULT NULL,
  `NOOFPEOPLE` int(11) DEFAULT NULL,
  `CARD` varchar(4) DEFAULT NULL,
  `SUBSCRIBE` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `homeowner`
--

INSERT INTO `homeowner` (`ID`, `STREET`, `BLOCKNO`, `UNITNO`, `POSTALCODE`, `AREA`, `HOUSETYPE`, `NOOFPEOPLE`, `CARD`, `SUBSCRIBE`) VALUES
(14, 'Serangoon Street 10', '195', '12-12', 357674, 'central', '3-Room Flat', 5, NULL, 14),
(144, 'Siglap Street 11', NULL, NULL, 113456, 'west', 'Bungalow House', 15, NULL, 14),
(234, 'Serangoon ave 1', '123', '12-34', 351234, 'central', '3-Room Flat', 4, NULL, 34),
(344, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14),
(354, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14),
(364, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14),
(374, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14),
(384, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14),
(394, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14),
(404, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14),
(414, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14),
(424, 'Serangoon ave 2', '123', '12-34', 351212, 'central', '3-Room Flat', 4, NULL, NULL),
(454, 'aswo3j', '123', '12-09', 301847, 'central', '5-Room Flat', 1, NULL, NULL),
(464, 'wjsjd', '12', '11-11', 103810, 'central', '1-Room Flat', 1, NULL, NULL),
(484, 'aksj', '1020', '11-03', 401930, 'central', '1-Room Flat', 1, NULL, NULL),
(494, '123 street', '12', '12', 123321, 'WEST', 'oneRoomFlat', 3, NULL, NULL),
(504, 'serangoon', '123', '12-34', 360192, 'central', '3-Room Flat', 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `ID` int(10) UNSIGNED NOT NULL,
  `METHOD` varchar(30) DEFAULT NULL,
  `HOMEOWNER` int(10) UNSIGNED DEFAULT NULL,
  `CARDNO` int(11) DEFAULT NULL,
  `CVV` int(11) DEFAULT NULL,
  `BILLINGADDRESS` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `paymentmethods`
--

CREATE TABLE `paymentmethods` (
  `ID` int(10) NOT NULL,
  `CUSTOMER` int(11) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `COUNTRY` varchar(20) NOT NULL,
  `ADDRESS` varchar(50) NOT NULL,
  `CITY` varchar(20) NOT NULL,
  `POSTALCODE` int(11) NOT NULL,
  `BRAND` varchar(10) NOT NULL,
  `EXPMONTH` int(2) NOT NULL,
  `EXPYEAR` int(2) NOT NULL,
  `CVC` int(3) NOT NULL,
  `CARDNO` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `paymentmethods`
--

INSERT INTO `paymentmethods` (`ID`, `CUSTOMER`, `NAME`, `COUNTRY`, `ADDRESS`, `CITY`, `POSTALCODE`, `BRAND`, `EXPMONTH`, `EXPYEAR`, `CVC`, `CARDNO`) VALUES
(64, 14, 'John', 'singapore', 'Toa payph', 'singapore', 123426, 'AMEX', 11, 24, 311, 412341234123);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ID` int(10) UNSIGNED NOT NULL,
  `HOMEOWNER` int(10) UNSIGNED DEFAULT NULL,
  `COMPANY` int(10) UNSIGNED DEFAULT NULL,
  `REVIEW` varchar(100) DEFAULT NULL,
  `NOOFSTAR` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`ID`, `HOMEOWNER`, `COMPANY`, `REVIEW`, `NOOFSTAR`) VALUES
(4, 14, 14, 'Thats some meh service', 4),
(14, 144, 14, 'pretty gud', 5),
(24, 234, 14, 'Good company', 4),
(44, 424, 14, 'Not good', 2),
(54, 14, 34, 'This is good', 4);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `ID` int(10) UNSIGNED NOT NULL,
  `NAME` varchar(30) DEFAULT NULL,
  `DESCRIPTION` varchar(50) DEFAULT NULL,
  `REGISTER` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`ID`, `NAME`, `DESCRIPTION`, `REGISTER`) VALUES
(4, 'homeowner', 'customer', 1),
(14, 'companyadmin', 'admin of the company', 1),
(24, 'technician', 'Staff of the company', 0),
(34, 'customerservice', 'Staff of the company', 0),
(44, 'superadmin', 'website owner', 0),
(54, 'rolletry', 'roletry', 1),
(64, 'role0217', 'role0217', 1);

-- --------------------------------------------------------

--
-- Table structure for table `servicerate`
--

CREATE TABLE `servicerate` (
  `EFFECTDATE` date NOT NULL DEFAULT '0000-00-00',
  `SERVICE` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `RATE` double DEFAULT NULL,
  `COMPANY` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `servicerate`
--

INSERT INTO `servicerate` (`EFFECTDATE`, `SERVICE`, `RATE`, `COMPANY`) VALUES
('2023-02-22', 94, 4.25, 74),
('2023-03-04', 4, 2, 74),
('2023-03-04', 54, 3.2, 74),
('2023-03-05', 74, 25, 74),
('2023-03-05', 94, 2, 74);

-- --------------------------------------------------------

--
-- Table structure for table `servicetype`
--

CREATE TABLE `servicetype` (
  `ID` int(10) UNSIGNED NOT NULL,
  `NAME` varchar(30) DEFAULT NULL,
  `DESCRIPTION` varchar(100) DEFAULT NULL,
  `CREATEDBY` int(10) UNSIGNED DEFAULT NULL,
  `TOTECH` tinyint(1) DEFAULT NULL,
  `STATUS` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `servicetype`
--

INSERT INTO `servicetype` (`ID`, `NAME`, `DESCRIPTION`, `CREATEDBY`, `TOTECH`, `STATUS`) VALUES
(4, 'installation', 'installation service such as water meter', 24, 1, ''),
(24, 'uninstallation', 'uninstallation service', 24, 1, ''),
(54, 'water supply', 'provision of water for homeowners', 24, 0, ''),
(64, 'others', 'default other servicetype', 24, 0, ''),
(74, 'plumbing', 'general plumbing', 24, 1, 'ACTIVE'),
(84, 'service0217', 'service0217', 24, 0, 'ACTIVE'),
(94, 'servicecomp0217', 'service0217', 74, 0, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `ID` int(10) UNSIGNED NOT NULL,
  `WORKLOAD` int(11) DEFAULT NULL,
  `COMPANY` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`ID`, `WORKLOAD`, `COMPANY`) VALUES
(14, 0, 14),
(124, 13, 14),
(134, 11, 14),
(174, 0, 44),
(184, 13, 44),
(314, 10, 14),
(444, 13, 14);

-- --------------------------------------------------------

--
-- Table structure for table `subscribe`
--

CREATE TABLE `subscribe` (
  `COMPANY` int(10) UNSIGNED DEFAULT NULL,
  `HOMEOWNER` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `DATE` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CATEGORY` varchar(50) NOT NULL,
  `TICKET` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subscribe`
--

INSERT INTO `subscribe` (`COMPANY`, `HOMEOWNER`, `DATE`, `CATEGORY`, `TICKET`) VALUES
(14, 14, '2023-02-17 00:00:00', 'unsubscribe', 74),
(14, 14, '2023-02-18 00:00:00', 'subscribe', 54),
(14, 14, '2023-02-19 00:00:00', 'subscribe', 94),
(34, 14, '2023-02-21 00:00:00', 'subscribe', 304),
(34, 14, '2023-02-22 00:00:00', 'subscribe', 284),
(14, 14, '2023-02-25 00:00:00', 'unsubscribe', 284),
(34, 14, '2023-02-27 00:00:00', 'unsubscribe', 304),
(34, 14, '2023-03-01 00:00:00', 'unsubscribe', 324),
(14, 14, '2023-03-02 00:00:00', 'subscribe', 324),
(34, 14, '2023-03-18 00:00:00', 'subscribe', 414),
(14, 14, '2023-03-30 00:00:00', 'subscribe', 434),
(34, 14, '2023-03-31 00:00:00', 'unsubscribe', 434),
(14, 14, '2023-04-01 00:00:00', 'unsubscribe', 414),
(14, 144, '2023-02-17 00:00:00', 'subscribe', 114),
(14, 344, '2022-02-01 00:00:00', 'subscribe', NULL),
(14, 354, '2022-02-01 00:00:00', 'subscribe', NULL),
(14, 364, '2022-03-01 00:00:00', 'subscribe', NULL),
(14, 374, '2022-03-01 00:00:00', 'subscribe', NULL),
(14, 384, '2022-03-01 00:00:00', 'subscribe', NULL),
(14, 384, '2023-01-01 00:00:00', 'unsubscribe', NULL),
(14, 394, '2022-04-01 00:00:00', 'subscribe', NULL),
(14, 404, '2022-05-01 00:00:00', 'subscribe', NULL),
(14, 414, '2022-07-01 00:00:00', 'subscribe', NULL),
(14, 424, '2023-02-19 00:00:00', 'subscribe', 344),
(14, 424, '2023-02-20 00:00:00', 'unsubscribe', 384);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `ID` int(10) UNSIGNED NOT NULL,
  `TECHNICIAN` int(10) UNSIGNED DEFAULT NULL,
  `TICKET` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`ID`, `TECHNICIAN`, `TICKET`) VALUES
(4, 134, 64),
(14, 134, 124),
(74, 134, 114),
(84, 134, 74),
(94, 314, 94),
(104, 314, 94),
(114, 314, 124),
(124, 314, 354),
(134, 134, 294),
(144, 314, 284),
(154, 314, 284),
(164, 314, 284),
(174, 314, 284),
(184, 314, 284),
(194, 314, 284),
(204, 314, 284),
(214, 134, 354),
(224, 314, 324),
(234, 314, 324),
(244, 134, 314),
(254, 134, 444),
(264, 134, 404);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `CREATEDATE` datetime DEFAULT CURRENT_TIMESTAMP,
  `ID` int(10) UNSIGNED NOT NULL,
  `HOMEOWNER` int(10) UNSIGNED DEFAULT NULL,
  `CUSTOMERSERVICE` int(10) UNSIGNED DEFAULT NULL,
  `STATUS` varchar(10) DEFAULT NULL,
  `TYPE` int(10) UNSIGNED DEFAULT NULL,
  `DESCRIPTION` varchar(50) DEFAULT NULL,
  `SERVICEDATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`CREATEDATE`, `ID`, `HOMEOWNER`, `CUSTOMERSERVICE`, `STATUS`, `TYPE`, `DESCRIPTION`, `SERVICEDATE`) VALUES
('2023-02-16 16:34:13', 44, 14, 124, 'OPEN', 4, 'homeowner installation when subscribed please', '2023-02-18'),
('2023-02-16 16:35:07', 54, 14, 124, 'OPEN', 4, 'homeowner installation when subscribed', '2023-02-18'),
('2023-02-16 16:36:03', 64, 14, 124, 'close', 4, 'homeowner installation when subscribed', '2023-02-17'),
('2023-02-16 16:40:11', 74, 14, 124, 'close', 24, 'homeowner uninstallation when unsubscribed', '2023-02-17'),
('2023-02-16 16:52:55', 84, 14, 124, 'CLOSE', 54, 'homeowner installation when subscribed', '2023-02-17'),
('2023-02-16 16:53:00', 94, 14, 124, 'close', 4, 'homeowner installation when subscribed', '2023-02-17'),
('2023-02-16 18:01:07', 114, 144, 124, 'close', 4, 'homeowner installation when subscribed', '2023-02-17'),
('2023-02-16 18:02:10', 124, 144, 124, 'close', 4, 'plumb', '2023-02-18'),
('2023-02-17 18:09:52', 284, 14, 444, 'open', 24, 'homeowner uninstallation when unsubscribed', '2023-02-25'),
('2023-02-17 18:10:07', 294, 14, 444, 'open', 4, 'homeowner installation when subscribed', '2023-02-22'),
('2023-02-17 18:13:13', 304, 14, 444, 'pending', 24, 'homeowner uninstallation when unsubscribed', '2023-02-27'),
('2023-02-17 18:13:30', 314, 14, 444, 'open', 4, 'homeowner installation when subscribed', '2023-02-21'),
('2023-02-17 19:24:30', 324, 14, 444, 'open', 24, 'homeowner uninstallation when unsubscribed', '2023-02-18'),
('2023-02-17 19:24:40', 334, 14, 444, 'open', 4, 'homeowner installation when subscribed', '2023-02-18'),
('2023-02-17 19:25:03', 344, 14, 444, 'open', 74, 'plumbing service', '2023-02-18'),
('2023-02-17 20:47:06', 354, 424, 444, 'open', 4, 'homeowner installation when subscribed', '2023-02-18'),
('2023-02-17 20:48:32', 364, 424, 444, 'pending', 74, 'Please help my pipe', '2023-02-18'),
('2023-02-17 20:49:51', 374, 424, 444, 'pending', 24, 'homeowner uninstallation when unsubscribed', '2023-02-19'),
('2023-02-17 20:50:01', 384, 424, 444, 'pending', 24, 'homeowner uninstallation when unsubscribed', '2023-02-20'),
('2023-02-18 03:00:57', 394, 14, 444, 'pending', 24, 'homeowner uninstallation when unsubscribed', '2023-02-17'),
('2023-02-18 03:01:05', 404, 14, 444, 'open', 24, 'homeowner uninstallation when unsubscribed', '2023-02-19'),
('2023-02-18 03:01:18', 414, 14, 444, 'pending', 24, 'homeowner uninstallation when unsubscribed', '2023-04-01'),
('2023-02-18 03:01:38', 424, 14, 124, 'pending', 4, 'homeowner installation when subscribed', '2023-03-18'),
('2023-02-18 03:02:46', 434, 14, 184, 'pending', 24, 'homeowner uninstallation when unsubscribed', '2023-03-31'),
('2023-02-18 03:04:46', 444, 14, 444, 'open', 4, 'homeowner installation when subscribed', '2023-03-30'),
('2023-02-18 03:06:01', 454, 14, 124, 'pending', 74, 'Please help me plumb', '2023-03-18');

-- --------------------------------------------------------

--
-- Table structure for table `tickettype`
--

CREATE TABLE `tickettype` (
  `ID` int(10) UNSIGNED NOT NULL,
  `NAME` varchar(50) DEFAULT NULL,
  `DESCRIPTION` varchar(100) DEFAULT NULL,
  `TOTECH` tinyint(1) DEFAULT NULL,
  `COMPANY` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(10) UNSIGNED NOT NULL,
  `NAME` varchar(30) DEFAULT NULL,
  `NUMBER` varchar(30) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  `TYPE` int(10) UNSIGNED DEFAULT NULL,
  `STATUS` varchar(10) DEFAULT NULL,
  `CODE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `NAME`, `NUMBER`, `EMAIL`, `PASSWORD`, `TYPE`, `STATUS`, `CODE`) VALUES
(14, 'homeowner1', '91234567', 'jtmw1012@gmail.com', '$2y$10$KLyjqlm54fq6RuxOkCUcb.5nEElDYYKUeRhz6W0ldXXCiG0Rjf2jG', 4, 'ACTIVE', 107626),
(24, 'Admin1', NULL, 'admin@gmail.com', '$2y$10$PcZAv5TzBWzVswRuZctE4OONjVa5mJjOiVT7/rqxL8zz9liFzclcK', 44, 'ACTIVE', NULL),
(74, 'companyadmin1', '87654321', 'limminxian316@gmail.com', '$2y$10$u7Ij.lNt.Yc.29ex3RXTduXcnmfV8f6C.cWTlCp/PyXDXJaB6K16S', 14, 'ACTIVE', NULL),
(94, 'technician1', '87654321', 'technician1@gmail.com', '$2y$10$W9Fm5L56/2/q5VAZ1hyAOOyIpSLekU1IjY5WeqGnM6jkaYvgMhuQ6', 24, 'ACTIVE', NULL),
(124, 'customerservice1', '87654321', 'customerservice1@gmail.com', '$2y$10$fxJsVvAkaqGyMDlj8ElqYO2nRiGHPitbc.J1bDEyl85jHF.6gNJV6', 34, 'ACTIVE', NULL),
(134, 'technician2', '87654321', 'technician2@gmail.com', '$2y$10$osKUrLit45ztVJkRrTGiC.L7/M7qGlB8TUsq8bnpAoKfODPy/JyyC', 24, 'ACTIVE', NULL),
(144, 'homeowner2', '96977707', 'watersupply02@gmail.com', '$2y$10$jlQ5m06wqWx/R0xaHcyhRecd6Rgj/USK27m95UEmQxoTxhKxGk7SG', 4, 'ACTIVE', 446887),
(154, 'companyadmin2', '87654321', 'minxianlim316@gmail.com', '$2y$10$I6/iS4JW.HHGEx4THCJnWumStuWov7m1XNhpvJP.lrye.q99NCyXW', 14, 'ACTIVE', NULL),
(164, 'companyadmin3', '87654321', 'company3@gmail.com', '$2y$10$dEe.I.Tr9btWCvrh5197wOdGP1QNGAfQtVSPdx8MR8Xh5ZHTndG2.', 14, 'SUSPEND', NULL),
(174, 'technician1comp3', '87654321', 'technician1comp3@gmail.com', '$2y$10$mhlAi1abaX3mTL75/Jm6xOUVUXgoUl0BOjdIA2MQY/M5gZ6uJhxFG', 24, 'ACTIVE', NULL),
(184, 'customerservice1company3', '87654321', 'customerservice1comp3@gmail.com', '$2y$10$UdpwyT3qlC1LNhpzcmra6uZJDmIuYMm.ORKJ7a9wFTd2JPc4Mo8TO', 34, 'PENDING', NULL),
(234, 'JohnDoe', '91234567', 'jmwtan001@mymail.sim.edu.sg', '$2y$10$/QJOP/yy4A7md6uRfh11c.6vamhDMJvewaYTDEdaiJxoKe3ZOWuom', 4, 'ACTIVE', 968332),
(314, 'technician0217', '87654321', 'technician0217@gmail.com', '$2y$10$X2/NL3w1aElAQR0ZUMMkOuAi.3WX0lkTobmHF5PGITEiJwzesmWZ.', 24, 'ACTIVE', NULL),
(344, 'home02171', '87654321', 'home02171@gmail.com', NULL, 4, 'ACTIVE', NULL),
(354, 'home02172', '87654321', 'home02172@gmail.com', NULL, 4, 'ACTIVE', NULL),
(364, 'home02173', '87654321', 'home02173@gmail.com', NULL, 4, 'ACTIVE', NULL),
(374, 'home02174', '87654321', 'home02174@gmail.com', NULL, 4, 'ACTIVE', NULL),
(384, 'home02175', '87654321', 'home02175@gmail.com', NULL, 4, 'ACTIVE', NULL),
(394, 'home02176', '87654321', 'home02176@gmail.com', NULL, 4, 'ACTIVE', NULL),
(404, 'home02177', '87654321', 'home02177@gmail.com', NULL, 4, 'ACTIVE', NULL),
(414, 'home02178', '87654321', 'home02178@gmail.com', NULL, 4, 'ACTIVE', NULL),
(424, 'John', '91234567', 'jtmw1012@hotmail.com', '$2y$10$soUgzAtey9e8ihyFOarOZO1ZEOMq.EDosd0SS7pyrMCi/Nhp15elS', 4, 'ACTIVE', 169591),
(434, 'compadmin0217', '87654321', 'mxlim011@mymail.sim.edu.sg', '$2y$10$W/QReOhRNwk7UuvShat4rOth3gYLySzWoBzvmTe5Qy9hJTo7v9XlS', 14, 'ACTIVE', NULL),
(444, 'customerservice0217', '87654321', 'customerservice0217@gmail.com', '$2y$10$u.ASkO5Fso0dQOefPwjupuTGjquC4y.XEMKIS.Yq8F7ls0hKu75gu', 34, 'ACTIVE', NULL),
(454, 'test', '97700881', 'watersupply03@gmail.com', '$2y$10$Ds2b.F2YNtOU2WKMA3W4Y.4nsvRNY5vxHY1aczrj.H8H3knirLcO.', 4, 'PENDING', 161156),
(464, 'leyon', '91356124', 'leyonan408@aosod.com', '$2y$10$VSKrVUX17sjoODYRc.MaLO6LfdI0DWIqzlfvJ0RtYO6YV8GdbnBDa', 4, 'PENDING', 893536),
(484, 'q', '91322356', 'daxabor562@jobsfeel.com', '$2y$10$ipcsQp2UdHuY1kjIV.mXTe.A53FKZhIcWrqFg08gwvGtxma4Vjmte', 4, 'ACTIVE', 512313),
(494, 'home0218', '87654321', 'minxian316@gmail.com', '$2y$10$ifua9e.BR.CpSasJGJbrY.eJxA165/OvTlrD3x4wtrIi5i6XwNnH2', 4, 'PENDING', 269502),
(504, 'jon', '91234567', 'lesapa8006@aosod.com', '$2y$10$Hfe1.dEyDrxcIpHfXBLvMeToiRFikUCXyQKImraGWVN6I69tKvzEq', 4, 'ACTIVE', 148330);

-- --------------------------------------------------------

--
-- Table structure for table `waterusage`
--

CREATE TABLE `waterusage` (
  `RECORDDATE` date NOT NULL DEFAULT '0000-00-00',
  `HOMEOWNER` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `WATERUSAGE(L)` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `waterusage`
--

INSERT INTO `waterusage` (`RECORDDATE`, `HOMEOWNER`, `WATERUSAGE(L)`) VALUES
('2020-12-31', 14, 2150),
('2021-01-31', 14, 1000),
('2021-02-28', 14, 900),
('2021-03-31', 14, 1278),
('2021-04-30', 14, 1245),
('2021-05-31', 14, 1470),
('2021-06-30', 14, 1245),
('2021-07-31', 14, 1234),
('2021-08-31', 14, 1496),
('2021-09-30', 14, 1243),
('2021-10-31', 14, 1458),
('2021-11-30', 14, 1249),
('2021-12-31', 14, 1452),
('2022-01-31', 14, 1425),
('2022-02-28', 14, 1483),
('2022-03-31', 14, 1436),
('2022-04-30', 14, 1243),
('2022-05-31', 14, 1487),
('2022-06-30', 14, 1256),
('2022-07-31', 14, 1457),
('2022-08-31', 14, 1425),
('2022-09-30', 14, 1347),
('2022-10-31', 14, 1472),
('2022-11-30', 14, 1348),
('2022-12-31', 14, 1436),
('2023-01-31', 14, 1425),
('2023-02-28', 14, 1480),
('2023-02-28', 144, 1200);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `HOMEOWNER` (`HOMEOWNER`),
  ADD KEY `SERVICE` (`SERVICE`),
  ADD KEY `PAYMENT` (`PAYMENT`),
  ADD KEY `COMPANY` (`COMPANY`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`CREATEDATE`,`TICKET`),
  ADD KEY `TICKET` (`TICKET`),
  ADD KEY `SENDER` (`SENDER`);

--
-- Indexes for table `chemical`
--
ALTER TABLE `chemical`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `NAME` (`NAME`,`COMPANY`),
  ADD KEY `COMPANY` (`COMPANY`);

--
-- Indexes for table `chemicalused`
--
ALTER TABLE `chemicalused`
  ADD PRIMARY KEY (`USEDATE`,`CHEMICAL`),
  ADD KEY `CHEMICAL` (`CHEMICAL`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`COMPANY`),
  ADD KEY `HOMEOWNER` (`HOMEOWNER`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ADMIN` (`ADMIN`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `EQUIPMENT` (`EQUIPMENT`),
  ADD KEY `HOMEOWNER` (`HOMEOWNER`),
  ADD KEY `TASK` (`INSTALLTASK`),
  ADD KEY `UNINSTALLTASK` (`UNINSTALLTASK`);

--
-- Indexes for table `equipstock`
--
ALTER TABLE `equipstock`
  ADD PRIMARY KEY (`SERIAL`),
  ADD KEY `TYPE` (`TYPE`),
  ADD KEY `COMPANY` (`COMPANY`);

--
-- Indexes for table `equiptype`
--
ALTER TABLE `equiptype`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `NAME` (`NAME`,`COMPANY`),
  ADD KEY `COMPANY` (`COMPANY`);

--
-- Indexes for table `homeowner`
--
ALTER TABLE `homeowner`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SUBSCRIBE` (`SUBSCRIBE`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `HOMEOWNER` (`HOMEOWNER`);

--
-- Indexes for table `paymentmethods`
--
ALTER TABLE `paymentmethods`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `HOMEOWNER` (`HOMEOWNER`),
  ADD KEY `COMPANY` (`COMPANY`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `NAME` (`NAME`);

--
-- Indexes for table `servicerate`
--
ALTER TABLE `servicerate`
  ADD PRIMARY KEY (`EFFECTDATE`,`SERVICE`,`COMPANY`),
  ADD KEY `SERVICE` (`SERVICE`),
  ADD KEY `COMPANY` (`COMPANY`);

--
-- Indexes for table `servicetype`
--
ALTER TABLE `servicetype`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `NAME` (`NAME`,`CREATEDBY`) USING BTREE,
  ADD KEY `CREATEDBY` (`CREATEDBY`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `COMPANY` (`COMPANY`);

--
-- Indexes for table `subscribe`
--
ALTER TABLE `subscribe`
  ADD PRIMARY KEY (`HOMEOWNER`,`DATE`),
  ADD KEY `COMPANY` (`COMPANY`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `TECHNICIAN` (`TECHNICIAN`),
  ADD KEY `TICKET` (`TICKET`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `HOMEOWNER` (`HOMEOWNER`),
  ADD KEY `CUSTOMERSERVICE` (`CUSTOMERSERVICE`),
  ADD KEY `TYPE` (`TYPE`);

--
-- Indexes for table `tickettype`
--
ALTER TABLE `tickettype`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `COMPANY` (`COMPANY`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`),
  ADD KEY `TYPE` (`TYPE`);

--
-- Indexes for table `waterusage`
--
ALTER TABLE `waterusage`
  ADD PRIMARY KEY (`RECORDDATE`,`HOMEOWNER`) USING BTREE,
  ADD KEY `HOMEOWNER` (`HOMEOWNER`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=394;

--
-- AUTO_INCREMENT for table `chemical`
--
ALTER TABLE `chemical`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `equiptype`
--
ALTER TABLE `equiptype`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `homeowner`
--
ALTER TABLE `homeowner`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=505;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paymentmethods`
--
ALTER TABLE `paymentmethods`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `servicetype`
--
ALTER TABLE `servicetype`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=445;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=464;

--
-- AUTO_INCREMENT for table `tickettype`
--
ALTER TABLE `tickettype`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=514;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`HOMEOWNER`) REFERENCES `homeowner` (`ID`),
  ADD CONSTRAINT `bill_ibfk_2` FOREIGN KEY (`SERVICE`) REFERENCES `servicerate` (`SERVICE`),
  ADD CONSTRAINT `bill_ibfk_3` FOREIGN KEY (`HOMEOWNER`) REFERENCES `homeowner` (`ID`),
  ADD CONSTRAINT `bill_ibfk_4` FOREIGN KEY (`SERVICE`) REFERENCES `servicerate` (`SERVICE`);

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`TICKET`) REFERENCES `ticket` (`ID`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`SENDER`) REFERENCES `users` (`ID`);

--
-- Constraints for table `chemical`
--
ALTER TABLE `chemical`
  ADD CONSTRAINT `chemical_ibfk_1` FOREIGN KEY (`COMPANY`) REFERENCES `company` (`ID`);

--
-- Constraints for table `chemicalused`
--
ALTER TABLE `chemicalused`
  ADD CONSTRAINT `chemicalused_ibfk_1` FOREIGN KEY (`CHEMICAL`) REFERENCES `chemical` (`ID`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`COMPANY`) REFERENCES `company` (`ID`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`HOMEOWNER`) REFERENCES `homeowner` (`ID`);

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`ADMIN`) REFERENCES `users` (`ID`);

--
-- Constraints for table `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`EQUIPMENT`) REFERENCES `equipstock` (`SERIAL`),
  ADD CONSTRAINT `equipment_ibfk_2` FOREIGN KEY (`HOMEOWNER`) REFERENCES `homeowner` (`ID`),
  ADD CONSTRAINT `equipment_ibfk_3` FOREIGN KEY (`INSTALLTASK`) REFERENCES `task` (`ID`);

--
-- Constraints for table `equipstock`
--
ALTER TABLE `equipstock`
  ADD CONSTRAINT `equipstock_ibfk_1` FOREIGN KEY (`TYPE`) REFERENCES `equiptype` (`ID`),
  ADD CONSTRAINT `equipstock_ibfk_2` FOREIGN KEY (`COMPANY`) REFERENCES `company` (`ID`);

--
-- Constraints for table `equiptype`
--
ALTER TABLE `equiptype`
  ADD CONSTRAINT `equiptype_ibfk_1` FOREIGN KEY (`COMPANY`) REFERENCES `company` (`ID`);

--
-- Constraints for table `homeowner`
--
ALTER TABLE `homeowner`
  ADD CONSTRAINT `homeowner_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `homeowner_ibfk_2` FOREIGN KEY (`SUBSCRIBE`) REFERENCES `company` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`HOMEOWNER`) REFERENCES `homeowner` (`ID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`HOMEOWNER`) REFERENCES `homeowner` (`ID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`COMPANY`) REFERENCES `company` (`ID`);

--
-- Constraints for table `servicerate`
--
ALTER TABLE `servicerate`
  ADD CONSTRAINT `servicerate_ibfk_1` FOREIGN KEY (`SERVICE`) REFERENCES `servicetype` (`ID`),
  ADD CONSTRAINT `servicerate_ibfk_2` FOREIGN KEY (`COMPANY`) REFERENCES `users` (`ID`);

--
-- Constraints for table `servicetype`
--
ALTER TABLE `servicetype`
  ADD CONSTRAINT `servicetype_ibfk_1` FOREIGN KEY (`CREATEDBY`) REFERENCES `users` (`ID`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`COMPANY`) REFERENCES `company` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `subscribe`
--
ALTER TABLE `subscribe`
  ADD CONSTRAINT `subscribe_ibfk_1` FOREIGN KEY (`COMPANY`) REFERENCES `company` (`ID`),
  ADD CONSTRAINT `subscribe_ibfk_2` FOREIGN KEY (`HOMEOWNER`) REFERENCES `homeowner` (`ID`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`TECHNICIAN`) REFERENCES `staff` (`ID`),
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`TICKET`) REFERENCES `ticket` (`ID`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`HOMEOWNER`) REFERENCES `homeowner` (`ID`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`CUSTOMERSERVICE`) REFERENCES `staff` (`ID`),
  ADD CONSTRAINT `ticket_ibfk_4` FOREIGN KEY (`TYPE`) REFERENCES `servicetype` (`ID`);

--
-- Constraints for table `tickettype`
--
ALTER TABLE `tickettype`
  ADD CONSTRAINT `tickettype_ibfk_1` FOREIGN KEY (`COMPANY`) REFERENCES `company` (`ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`TYPE`) REFERENCES `role` (`ID`);

--
-- Constraints for table `waterusage`
--
ALTER TABLE `waterusage`
  ADD CONSTRAINT `waterusage_ibfk_1` FOREIGN KEY (`HOMEOWNER`) REFERENCES `homeowner` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
