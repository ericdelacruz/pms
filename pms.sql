-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 31, 2013 at 06:46 AM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `artist`, `title`) VALUES
(1, 'The  Military  Wives', 'In  My  Dreams'),
(2, 'Adele', '21'),
(3, 'Bruce  Springsteen', 'Wrecking Ball (Deluxe)'),
(4, 'Lana  Del  Rey', 'Born  To  Die'),
(5, 'Gotye', 'Making  Mirrors');

-- --------------------------------------------------------

--
-- Table structure for table `finance`
--

CREATE TABLE `finance` (
  `financeId` int(6) NOT NULL AUTO_INCREMENT,
  `sssContribution` float NOT NULL DEFAULT '0',
  `eccContribution` float NOT NULL DEFAULT '0',
  `phicContribution` float NOT NULL DEFAULT '0',
  `hmdfContribution` float NOT NULL DEFAULT '0',
  `medicare` float NOT NULL DEFAULT '0',
  `pamperDayBenefit` float NOT NULL DEFAULT '0',
  `programsAndEvents` float NOT NULL DEFAULT '0',
  `equipmentAndFurniture` float NOT NULL DEFAULT '0',
  `softwareAndRelated` float NOT NULL DEFAULT '0',
  `bandwidth` float NOT NULL DEFAULT '0',
  `rentAndUtilities` float NOT NULL DEFAULT '0',
  `suppliesAndSharedServices` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`financeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `finance`
--

INSERT INTO `finance` (`financeId`, `sssContribution`, `eccContribution`, `phicContribution`, `hmdfContribution`, `medicare`, `pamperDayBenefit`, `programsAndEvents`, `equipmentAndFurniture`, `softwareAndRelated`, `bandwidth`, `rentAndUtilities`, `suppliesAndSharedServices`) VALUES
(1, 1060, 30, 375, 100, 1500, 450, 1650, 8656, 3675, 7350, 7088, 10500);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `mediaId` int(6) NOT NULL AUTO_INCREMENT,
  `processId` int(6) NOT NULL,
  `originalFilename` varchar(100) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `path` varchar(100) NOT NULL,
  PRIMARY KEY (`mediaId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`mediaId`, `processId`, `originalFilename`, `filename`, `path`) VALUES
(1, 1, 'IMG_9763.JPG', '5146d270a67db_1.jpg', '/images/process/1'),
(2, 2, 'IMG_9763.JPG', '5146d270a67db_1.jpg', '/images/process/1'),
(3, 4, 'IMG_9763.JPG', '5146d270a67db_1.jpg', '/images/process/1'),
(4, 4, 'IMG_9777.JPG', '5146d2b449cca_4.jpg', '/images/process/4'),
(5, 6, 'IMG_9763.JPG', '5146d270a67db_1.jpg', '/images/process/1'),
(6, 7, 'IMG_9763.JPG', '5146d270a67db_1.jpg', '/images/process/1'),
(7, 9, 'IMG_9763.JPG', '5146d270a67db_1.jpg', '/images/process/1'),
(8, 10, 'IMG_9763.JPG', '5146d270a67db_1.jpg', '/images/process/1'),
(9, 11, 'IMG_9763.JPG', '5146d270a67db_1.jpg', '/images/process/1'),
(19, 39, 'IMG_9763.JPG', '5146d270a67db_1.jpg', '/images/process/1');

-- --------------------------------------------------------

--
-- Table structure for table `processes`
--

CREATE TABLE `processes` (
  `processId` int(6) NOT NULL AUTO_INCREMENT,
  `parentId` int(6) NOT NULL DEFAULT '0',
  `userId` int(6) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1',
  `clientName` varchar(200) NOT NULL,
  `contactPerson` varchar(200) NOT NULL,
  `contactEmail` varchar(60) NOT NULL,
  `contactNumber` varchar(16) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `teams` varchar(100) NOT NULL,
  `lastUpdateDate` datetime NOT NULL,
  `deliverables` varchar(200) NOT NULL,
  `overview` varchar(200) NOT NULL,
  `scope` varchar(200) NOT NULL,
  `outOfScope` varchar(200) NOT NULL,
  `metrics` varchar(200) NOT NULL,
  `itResources` varchar(200) NOT NULL,
  `marginRate` float NOT NULL DEFAULT '0',
  `costPerHour` float NOT NULL DEFAULT '0',
  `costPerStep` float NOT NULL DEFAULT '0',
  `dailyRate` float NOT NULL DEFAULT '0',
  `costInPesos` float NOT NULL DEFAULT '0',
  `totalInPhp` float NOT NULL DEFAULT '0',
  `totalInDollars` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`processId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `processes`
--

INSERT INTO `processes` (`processId`, `parentId`, `userId`, `name`, `status`, `clientName`, `contactPerson`, `contactEmail`, `contactNumber`, `owner`, `teams`, `lastUpdateDate`, `deliverables`, `overview`, `scope`, `outOfScope`, `metrics`, `itResources`, `marginRate`, `costPerHour`, `costPerStep`, `dailyRate`, `costInPesos`, `totalInPhp`, `totalInDollars`) VALUES
(1, 0, 7, 'Process A', '1', 'client', 'contact person', 'email@email.com', '123456', 'owner', '["2"]', '2013-03-19 11:53:11', 'Deliverables', '', '', '', '', '', 20, 0, 0, 0, 0, 0, 0),
(2, 1, 7, 'Process A', '1', 'client', 'contact person', 'email@email.com', '123456', 'owner', '["2"]', '2013-03-19 12:01:12', 'Deliverables', '', '', '', '', '', 20, 0, 0, 0, 0, 0, 0),
(3, 1, 7, 'Process A', '1', 'client', 'contact person', 'email@email.com', '123456', 'owner', '["2"]', '2013-03-19 12:02:50', 'Deliverables', '', '', '', '', '', 20, 0, 0, 0, 0, 0, 0),
(4, 1, 7, 'Process A', '1', 'client', 'contact person', 'email@email.com', '123456', 'owner', '["2"]', '2013-03-19 12:04:21', 'Deliverables', '', '', '', '', '', 20, 0, 0, 0, 0, 0, 0),
(5, 1, 7, 'Process A', '1', 'client', 'contact person', 'email@email.com', '123456', 'owner', '["2"]', '2013-03-19 12:04:51', 'Deliverables', '', '', '', '', '', 20, 0, 0, 0, 0, 0, 0),
(6, 1, 7, 'Process A', '1', 'client', 'contact person', 'email@email.com', '123456', 'owner', '["2"]', '2013-03-19 12:07:53', 'Deliverables', '', '', '', '', '', 20, 0, 0, 0, 0, 0, 0),
(7, 1, 7, 'Process A', '1', 'client', 'contact person', 'email@email.com', '123456', 'owner', '["2"]', '2013-03-19 12:46:17', 'Deliverables', '', '', '', '', '', 20, 0, 0, 0, 0, 0, 0),
(8, 1, 7, 'Process A', '1', 'client', 'contact person', 'email@email.com', '123456', 'owner', '["2"]', '2013-03-19 12:48:00', 'Deliverables', '', '', '', '', '', 20, 0, 0, 0, 0, 0, 0),
(9, 1, 7, 'Process A', '1', 'client', 'contact person', 'email@email.com', '123456', 'owner', '["2"]', '2013-03-19 12:48:37', 'Deliverables', '', '', '', '', '', 20, 0, 0, 0, 0, 0, 0),
(39, 1, 7, 'Process A', '1', 'client', 'contact person', 'email@email.com', '123456', 'owner', '["2"]', '2013-03-20 09:30:53', 'Deliverables', '', '', '', '', '', 20, 10906.4, 380078, 87251.4, 380078, 475099, 11877.5),
(40, 0, 15, 'ttttt', '1', 'ttttt', 'ttt', 'tttt', 'ttttt', 'tttttt', '["1"]', '2013-04-08 13:34:40', '', '', '', '', '', '', 2222, 0, 0, 0, 0, 0, 0),
(41, 0, 15, 'ttttt', '1', 'ttttt', 'ttt', 'tttt', 'ttttt', 'tttttt', '["1"]', '2013-04-08 13:36:59', '', '', '', '', '', '', 2222, 0, 0, 0, 0, 0, 0),
(42, 0, 15, 'ttttt', '1', 'ttttt', 'ttt', 'tttt', 'ttttt', 'tttttt', '["1"]', '2013-04-08 13:40:06', '', '', '', '', '', '', 2222, 0, 0, 0, 0, 0, 0),
(43, 0, 15, 'ttttt', '1', 'ttttt', 'ttt', 'tttt', 'ttttt', 'tttttt', '["1"]', '2013-04-08 13:40:23', '', '', '', '', '', '', 2222, 0, 0, 0, 0, 0, 0),
(44, 0, 15, 'ttttt', '1', 'ttttt', 'ttt', 'tttt', 'ttttt', 'tttttt', '["1"]', '2013-04-08 13:40:30', '', '', '', '', '', '', 2222, 0, 0, 0, 0, 0, 0),
(45, 0, 15, 'ttttt', '1', 'ttttt', 'ttt', 'tttt', 'ttttt', 'tttttt', '["1"]', '2013-04-08 13:42:44', '', '', '', '', '', '', 2222, 0, 0, 0, 0, 0, 0),
(46, 0, 15, 'ttttt', '1', 'ttttt', 'ttt', 'tttt', 'ttttt', 'tttttt', '["1"]', '2013-04-08 13:47:12', '', '', '', '', '', '', 2222, 0, 0, 0, 0, 0, 0),
(47, 0, 15, 'ttttt', '1', 'ttttt', 'ttt', 'tttt', 'ttttt', 'tttttt', '["1"]', '2013-04-08 13:47:22', '', '', '', '', '', '', 2222, 0, 0, 0, 0, 0, 0),
(48, 0, 15, 'ttttt', '1', 'ttttt', 'ttt', 'tttt', 'ttttt', 'tttttt', '["1"]', '2013-04-08 14:03:32', '', '', '', '', '', '', 2222, 0, 0, 0, 0, 0, 0),
(49, 47, 15, 'ttttt', '1', 'ttttt', 'ttt', 'tttt', 'ttttt', 'tttttt', '["1"]', '2013-05-09 15:45:23', '', '', '', '', '', '', 2222, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `resourceId` int(6) NOT NULL AUTO_INCREMENT,
  `teamId` int(6) NOT NULL,
  `salaryGradeId` int(6) NOT NULL,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`resourceId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`resourceId`, `teamId`, `salaryGradeId`, `description`) VALUES
(1, 2, 1, 'Designer'),
(2, 1, 1, 'Designer 2');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `roleId` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`roleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleId`, `name`) VALUES
(1, 'Admin'),
(2, 'Client');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `salaryId` int(6) NOT NULL AUTO_INCREMENT,
  `grade` varchar(32) NOT NULL,
  `band` varchar(60) NOT NULL,
  `tier` varchar(60) NOT NULL,
  `salaryMinimum` float NOT NULL,
  `midpoint` float NOT NULL,
  `salaryMaximum` float NOT NULL,
  `mealAllowance` float NOT NULL,
  `transportationAllowance` float NOT NULL,
  `variableAllowance` varchar(60) NOT NULL,
  `nightDifferential` varchar(60) NOT NULL,
  `overtimeHolidayPremium` varchar(60) NOT NULL,
  `monthPay` enum('0','1') NOT NULL DEFAULT '0',
  `vacationLeaves` int(3) NOT NULL,
  `sickLeaves` int(3) NOT NULL,
  `creditsAccruedPerHour` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`salaryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`salaryId`, `grade`, `band`, `tier`, `salaryMinimum`, `midpoint`, `salaryMaximum`, `mealAllowance`, `transportationAllowance`, `variableAllowance`, `nightDifferential`, `overtimeHolidayPremium`, `monthPay`, `vacationLeaves`, `sickLeaves`, `creditsAccruedPerHour`) VALUES
(1, 'A1', 'Band', 'Tier', 3000, 5000, 6000, 500, 300, '2341', '1203', '1234', '1', 11, 21, '1'),
(2, 'A2', 'Band 2', 'Tier 2', 20000, 22000, 25000, 2000, 2000, '412', '111', '231', '0', 4, 2, '0'),
(3, 'B1', 'vxcv', 'cvxcvcx', 10000, 50000, 80000, 10129, 123, '5234', '32423', '32423', '0', 1, 1, '1'),
(4, 'B2', '2', '3', 4000, 5000, 6000, 7000, 8000, '9000', '10000', '11000', '0', 12, 13, '0');

-- --------------------------------------------------------

--
-- Table structure for table `stepResources`
--

CREATE TABLE `stepResources` (
  `stepResourceId` int(6) NOT NULL AUTO_INCREMENT,
  `stepId` int(6) NOT NULL,
  `resourceId` int(6) NOT NULL,
  `userId` int(6) NOT NULL,
  `basicSalary` float NOT NULL DEFAULT '0',
  `deMinimis` float NOT NULL DEFAULT '0',
  `transportAllowance` float NOT NULL DEFAULT '0',
  `mealAllowance` float NOT NULL DEFAULT '0',
  `nightDifferential` float NOT NULL DEFAULT '0',
  `overtimeAndHolidayPay` float NOT NULL DEFAULT '0',
  `nthMonthPay` float NOT NULL DEFAULT '0',
  `sssContribution` float NOT NULL DEFAULT '0',
  `eccContribution` float NOT NULL DEFAULT '0',
  `phicContribution` float NOT NULL DEFAULT '0',
  `hmdfContribution` float NOT NULL DEFAULT '0',
  `medicare` float NOT NULL DEFAULT '0',
  `pamperDayBenefit` float NOT NULL DEFAULT '0',
  `programsAndEvents` float NOT NULL DEFAULT '0',
  `equipmentAndFurniture` float NOT NULL DEFAULT '0',
  `softwareAndRelated` float NOT NULL DEFAULT '0',
  `bandwidth` float NOT NULL DEFAULT '0',
  `rentAndUtilities` float NOT NULL DEFAULT '0',
  `suppliesAndSharedServices` float NOT NULL DEFAULT '0',
  `daysNeeded` float NOT NULL DEFAULT '0',
  `totalBenefitsInitial` float NOT NULL,
  `taxOnAllowance` float NOT NULL,
  `totalBenefits` float NOT NULL,
  `totalManpowerCost` float NOT NULL,
  `totalSGACost` float NOT NULL,
  `monthlyRate` float NOT NULL,
  `dailyRate` float NOT NULL,
  `hourlyRate` float NOT NULL,
  `costInPHP` float NOT NULL,
  `totalBillingPHP` float NOT NULL,
  `costMargin` float NOT NULL,
  `totalBillingUSD` float NOT NULL,
  PRIMARY KEY (`stepResourceId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=249 ;

--
-- Dumping data for table `stepResources`
--

INSERT INTO `stepResources` (`stepResourceId`, `stepId`, `resourceId`, `userId`, `basicSalary`, `deMinimis`, `transportAllowance`, `mealAllowance`, `nightDifferential`, `overtimeAndHolidayPay`, `nthMonthPay`, `sssContribution`, `eccContribution`, `phicContribution`, `hmdfContribution`, `medicare`, `pamperDayBenefit`, `programsAndEvents`, `equipmentAndFurniture`, `softwareAndRelated`, `bandwidth`, `rentAndUtilities`, `suppliesAndSharedServices`, `daysNeeded`, `totalBenefitsInitial`, `taxOnAllowance`, `totalBenefits`, `totalManpowerCost`, `totalSGACost`, `monthlyRate`, `dailyRate`, `hourlyRate`, `costInPHP`, `totalBillingPHP`, `costMargin`, `totalBillingUSD`) VALUES
(1, 4, 2, 13, 111, 2222, 333, 444, 555, 444, 5555, 5666, 3000, 3000, 3000, 3000, 3000, 3000, 3000, 3000, 3000, 23, 222, 3, 33220, 1620.24, 34840.2, 38505.2, 9245, 47750.2, 2170.47, 271.31, 6511.41, 8139.26, 1627.85, 203.48),
(2, 5, 2, 1, 29000, 1300, 3200, 410, 170, 5201, 293, 23189, 213, 5423, 54, 546, 658, 856, 2342, 23423, 552, 23423, 222, 6, 37261, 4758.12, 42019.1, 76099.1, 49962, 126061, 5730.05, 716.26, 34380.3, 42975.4, 8595.08, 1074.38),
(3, 4, 2, 1, 29000, 1300, 3200, 410, 170, 5201, 293, 23189, 213, 5423, 54, 546, 658, 856, 2342, 23423, 552, 23423, 222, 2, 37261, 4758.12, 42019.1, 76099.1, 49962, 126061, 5730.05, 716.26, 11460.1, 14325.1, 2865.03, 358.13),
(4, 4, 1, 7, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 500, 500, 500, 500, 500, 500, 500, 500, 0, 0, 7, 153000, 56470.6, 209471, 359471, 1500, 360971, 16407.8, 2050.97, 114854, 143568, 28713.6, 3589.2),
(6, 5, 2, 1, 29000, 1300, 3200, 410, 170, 5201, 293, 23189, 213, 5423, 54, 546, 658, 856, 2342, 23423, 552, 23423, 222, 2, 37261, 4758.12, 42019.1, 76099.1, 49962, 126061, 5730.05, 716.26, 11460.1, 14325.1, 2865.03, 358.13),
(7, 6, 1, 7, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 500, 500, 500, 500, 500, 500, 500, 500, 0, 0, 7, 153000, 56470.6, 209471, 359471, 1500, 360971, 16407.8, 2050.97, 114854, 143568, 28713.6, 3589.2),
(9, 8, 2, 1, 29000, 1300, 3200, 410, 170, 5201, 293, 23189, 213, 5423, 54, 546, 658, 856, 2342, 23423, 552, 23423, 222, 2, 37261, 4758.12, 42019.1, 76099.1, 49962, 126061, 5730.05, 716.26, 11460.1, 14325.1, 2865.03, 358.13),
(12, 11, 2, 1, 29000, 1300, 3200, 410, 170, 5201, 293, 23189, 213, 5423, 54, 546, 658, 856, 2342, 23423, 552, 23423, 222, 2, 37261, 4758.12, 42019.1, 76099.1, 49962, 126061, 5730.05, 716.26, 11460.1, 14325.1, 2865.03, 358.13),
(13, 12, 1, 7, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 500, 500, 500, 500, 500, 500, 500, 500, 0, 0, 7, 153000, 56470.6, 209471, 359471, 1500, 360971, 16407.8, 2050.97, 114854, 143568, 28713.6, 3589.2),
(154, 4, 1, 7, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 500, 500, 500, 500, 500, 500, 500, 500, 0, 0, 2, 153000, 56470.6, 209471, 359471, 1500, 360971, 16407.8, 2050.97, 32815.5, 41019.4, 8203.88, 1025.48),
(155, 5, 1, 14, 15000, 1000, 1000, 1000, 1000, 0, 15000, 200, 200, 200, 200, 1000, 500, 1000, 1000, 2000, 4000, 2500, 0, 2, 19800, 1411.76, 21211.8, 40211.8, 9500, 49711.8, 2259.63, 282.45, 4519.26, 5649.08, 1129.82, 141.23),
(156, 6, 1, 7, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 500, 500, 500, 500, 500, 500, 500, 500, 0, 0, 3, 153000, 56470.6, 209471, 359471, 1500, 360971, 16407.8, 2050.97, 49223.2, 61529.1, 12305.8, 1538.23),
(238, 76, 2, 13, 111, 2222, 333, 444, 555, 444, 5555, 5666, 3000, 3000, 3000, 3000, 3000, 3000, 3000, 3000, 3000, 23, 222, 3, 33220, 1620.24, 34840.2, 38505.2, 9245, 47750.2, 2170.47, 271.31, 6511.41, 8139.26, 1627.85, 203.48),
(240, 76, 1, 7, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 500, 500, 500, 500, 500, 500, 500, 500, 0, 0, 7, 153000, 56470.6, 209471, 359471, 1500, 360971, 16407.8, 2050.97, 114854, 143568, 28713.6, 3589.2),
(241, 76, 1, 7, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 500, 500, 500, 500, 500, 500, 500, 500, 0, 0, 2, 153000, 56470.6, 209471, 359471, 1500, 360971, 16407.8, 2050.97, 32815.5, 41019.4, 8203.88, 1025.48),
(242, 77, 2, 1, 29000, 1300, 3200, 410, 170, 5201, 293, 23189, 213, 5423, 54, 546, 658, 856, 2342, 23423, 552, 23423, 222, 6, 37261, 4758.12, 42019.1, 76099.1, 49962, 126061, 5730.05, 716.26, 34380.3, 42975.4, 8595.08, 1074.38),
(243, 77, 2, 1, 29000, 1300, 3200, 410, 170, 5201, 293, 23189, 213, 5423, 54, 546, 658, 856, 2342, 23423, 552, 23423, 222, 2, 37261, 4758.12, 42019.1, 76099.1, 49962, 126061, 5730.05, 716.26, 11460.1, 14325.1, 2865.03, 358.13),
(244, 77, 1, 14, 15000, 1000, 1000, 1000, 1000, 0, 15000, 200, 200, 200, 200, 1000, 500, 1000, 1000, 2000, 4000, 2500, 0, 2, 19800, 1411.76, 21211.8, 40211.8, 9500, 49711.8, 2259.63, 282.45, 4519.26, 5649.08, 1129.82, 141.23),
(245, 78, 1, 7, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 500, 500, 500, 500, 500, 500, 500, 500, 0, 0, 7, 153000, 56470.6, 209471, 359471, 1500, 360971, 16407.8, 2050.97, 114854, 143568, 28713.6, 3589.2),
(246, 78, 1, 7, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 500, 500, 500, 500, 500, 500, 500, 500, 0, 0, 3, 153000, 56470.6, 209471, 359471, 1500, 360971, 16407.8, 2050.97, 49223.2, 61529.1, 12305.8, 1538.23),
(248, 78, 2, 0, 6000, 2341, 300, 500, 1203, 1234, 500, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2937, 2058.82, 4995.82, 15339.8, 0, 15339.8, 697.26, 87.16, 697.26, 871.58, 174.32, 21.79);

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `stepId` int(6) NOT NULL AUTO_INCREMENT,
  `processId` int(6) NOT NULL,
  `steps` varchar(200) NOT NULL,
  `details` varchar(300) NOT NULL,
  `turnaroundTime` varchar(200) NOT NULL DEFAULT '0',
  `costPerHour` float NOT NULL DEFAULT '0',
  `costPerStep` float NOT NULL DEFAULT '0',
  `dailyRate` float NOT NULL DEFAULT '0',
  `costInPesos` float NOT NULL DEFAULT '0',
  `margin` float NOT NULL DEFAULT '0',
  `totalInPhp` float NOT NULL DEFAULT '0',
  `totalInDollars` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`stepId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `steps`
--

INSERT INTO `steps` (`stepId`, `processId`, `steps`, `details`, `turnaroundTime`, `costPerHour`, `costPerStep`, `dailyRate`, `costInPesos`, `margin`, `totalInPhp`, `totalInDollars`) VALUES
(1, 7, 'aaaa', 'dsadasdas', '0', 0, 0, 0, 0, 0, 0, 0),
(2, 7, 'cccc', '21312312321', '0', 0, 0, 0, 0, 0, 0, 0),
(3, 7, 'new', 'desc', '0', 0, 0, 0, 0, 0, 0, 0),
(4, 9, 'aaaa', 'dsadasdas', '14', 5089.51, 165641, 40716.1, 165641, 41410.4, 207052, 5176.29),
(5, 9, 'cccc', '21312312321', '10', 1714.97, 50359.7, 13719.7, 50359.7, 12589.9, 62949.6, 1573.74),
(6, 9, 'new', 'desc', '10', 4101.94, 164077, 32815.6, 164077, 41019.4, 205097, 5127.43),
(7, 10, 'new', 'new', '0', 0, 0, 0, 0, 0, 0, 0),
(8, 10, 'aaaa', 'aaa', '0', 0, 0, 0, 0, 0, 0, 0),
(9, 10, 'sssss', 'ssss', '0', 0, 0, 0, 0, 0, 0, 0),
(10, 11, 'new', 'new', '0', 0, 0, 0, 0, 0, 0, 0),
(11, 11, 'aaaa', 'aaa', '0', 0, 0, 0, 0, 0, 0, 0),
(12, 11, 'sssss', 'ssss', '0', 0, 0, 0, 0, 0, 0, 0),
(76, 39, 'aaaa', 'dsadasdas', '14', 5089.51, 165641, 40716.1, 165641, 41410.4, 207052, 5176.29),
(77, 39, 'cccc', '21312312321', '10', 1714.97, 50359.7, 13719.7, 50359.7, 12589.9, 62949.6, 1573.74),
(78, 39, 'new', 'desc', '13', 4276.26, 166169, 34210.1, 166169, 41542.4, 207712, 5192.8);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `teamId` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET latin1 NOT NULL,
  `overheadCost` float NOT NULL,
  `itResources` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`teamId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`teamId`, `name`, `overheadCost`, `itResources`) VALUES
(1, 'Team A', 11, 'resource'),
(2, 'Team B', 0, 'resource b');

-- --------------------------------------------------------

--
-- Table structure for table `team_process`
--

CREATE TABLE `team_process` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `teamId` int(6) NOT NULL,
  `processId` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(6) NOT NULL AUTO_INCREMENT,
  `teamId` int(6) NOT NULL,
  `resourceId` int(6) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(64) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `firstName` varchar(32) NOT NULL,
  `lastName` varchar(32) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `hiringDate` date DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `state` smallint(6) DEFAULT '0',
  `basicSalary` float NOT NULL DEFAULT '0',
  `deMinimis` float NOT NULL DEFAULT '0',
  `transportAllowance` float NOT NULL DEFAULT '0',
  `mealAllowance` float NOT NULL DEFAULT '0',
  `nightDifferential` float NOT NULL DEFAULT '0',
  `overtimeAndHolidayPay` float NOT NULL DEFAULT '0',
  `nthMonthPay` float NOT NULL DEFAULT '0',
  `sssContribution` float NOT NULL DEFAULT '0',
  `eccContribution` float NOT NULL DEFAULT '0',
  `phicContribution` float NOT NULL DEFAULT '0',
  `hmdfContribution` float NOT NULL DEFAULT '0',
  `medicare` float NOT NULL DEFAULT '0',
  `pamperDayBenefit` float NOT NULL DEFAULT '0',
  `programsAndEvents` float NOT NULL DEFAULT '0',
  `equipmentAndFurniture` float NOT NULL DEFAULT '0',
  `softwareAndRelated` float NOT NULL DEFAULT '0',
  `bandwidth` float NOT NULL DEFAULT '0',
  `rentAndUtilities` float NOT NULL DEFAULT '0',
  `suppliesAndSharedServices` float NOT NULL DEFAULT '0',
  `available` enum('0','1') NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `teamId`, `resourceId`, `username`, `password`, `display_name`, `email`, `firstName`, `lastName`, `title`, `hiringDate`, `address`, `state`, `basicSalary`, `deMinimis`, `transportAllowance`, `mealAllowance`, `nightDifferential`, `overtimeAndHolidayPay`, `nthMonthPay`, `sssContribution`, `eccContribution`, `phicContribution`, `hmdfContribution`, `medicare`, `pamperDayBenefit`, `programsAndEvents`, `equipmentAndFurniture`, `softwareAndRelated`, `bandwidth`, `rentAndUtilities`, `suppliesAndSharedServices`, `available`, `deleted`) VALUES
(1, 2, 2, 'test', '', '', 'ssss', 'firstname', 'lastname', 'junior', NULL, 'address1', NULL, 29000, 1300, 3200, 410, 170, 5201, 293, 23189, 213, 5423, 54, 546, 658, 856, 2342, 23423, 552, 23423, 222, '1', '0'),
(7, 1, 1, 'first', '', NULL, 'firslasdas@dsad.com', 'first', 'first', '', NULL, 'falsalasl', NULL, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 30000, 500, 500, 500, 500, 500, 500, 500, 500, 0, 0, '1', '0'),
(13, 2, 2, 'aaaaa', '', NULL, '', 'sdasdasdsaddasd', 'sad', 'title', NULL, 'asdsadsad', NULL, 111, 2222, 333, 444, 555, 444, 5555, 5666, 3000, 3000, 3000, 3000, 3000, 3000, 3000, 3000, 3000, 23, 222, '0', '1'),
(14, 1, 1, 'designer1', '', NULL, 'email@email.com', 'first name', 'last name', 'title', NULL, '', NULL, 15000, 1000, 1000, 1000, 1000, 0, 15000, 200, 200, 200, 200, 1000, 500, 1000, 1000, 2000, 4000, 2500, 0, '1', '0'),
(15, 0, 0, 'admin', '$2y$14$AB94QjQV4BQBhg2w1LE7xuKgn4Q7kJxMVrOu1sukPpluZGMvURWgy', NULL, 'admin@admin.com', 'admin', 'admin', NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `userId` int(6) NOT NULL,
  `roleId` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `userId`, `roleId`) VALUES
(1, 1, 1);
