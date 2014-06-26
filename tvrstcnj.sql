-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: mysql-tvrs.immtcnj.com
-- Generation Time: Jun 26, 2014 at 08:38 AM
-- Server version: 5.1.56
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tvrstcnj`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` text NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `clients`
--


-- --------------------------------------------------------

--
-- Table structure for table `dosage`
--

CREATE TABLE IF NOT EXISTS `dosage` (
  `entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `providerName` text NOT NULL,
  `clientName` text NOT NULL,
  `services` text NOT NULL,
  `receiver` text NOT NULL,
  `elapsedTime` text NOT NULL,
  `method` text NOT NULL,
  `activity_date` datetime NOT NULL,
  PRIMARY KEY (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `dosage`
--


-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE IF NOT EXISTS `providers` (
  `provider_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_name` text NOT NULL,
  PRIMARY KEY (`provider_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `providers`
--

INSERT INTO `providers` (`provider_id`, `provider_name`) VALUES
(1, 'Ayana Abdul-Raheem'),
(2, 'Wayne Council'),
(3, 'Darren Green'),
(4, 'Lee Hood'),
(5, 'Earl Lester'),
(6, 'Hawwah Momolu'),
(7, 'Errick Wiggins'),
(8, 'Abdul Muhammad'),
(9, 'Jason Rodgers'),
(10, 'Isles');

-- --------------------------------------------------------

--
-- Table structure for table `receiver`
--

CREATE TABLE IF NOT EXISTS `receiver` (
  `receiver_id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver` text NOT NULL,
  PRIMARY KEY (`receiver_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `receiver`
--

INSERT INTO `receiver` (`receiver_id`, `receiver`) VALUES
(1, 'Client'),
(2, 'Partner/Spouse'),
(3, 'Child'),
(4, 'Sibling'),
(5, 'Parent'),
(6, 'Extended Family');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_code` int(11) NOT NULL,
  `service_text` text NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `service_code`, `service_text`) VALUES
(1, 1, 'Risk Reduction and/or Resiliency Strength Assessment and Counseling'),
(2, 2, 'Psychosocial Counseling'),
(3, 3, 'Substance Abuse Counseling'),
(4, 4, 'Mentoring (peer or other)'),
(5, 5, 'Case Management Services'),
(6, 6, 'Medical Services'),
(7, 7, 'Career Counseling / Job Training'),
(8, 8, 'Life Skills'),
(9, 9, 'Parenting Skills'),
(10, 10, 'Crisis Counseling'),
(11, 11, 'Legal Assistance'),
(12, 12, 'Mental Health Counseling'),
(13, 13, 'English Language Skills Assistance'),
(14, 14, 'Family Counseling'),
(15, 15, 'Other Services');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email` text NOT NULL,
  `userpass` text NOT NULL,
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`firstname`, `lastname`, `email`, `userpass`, `user_id`) VALUES
('John', 'Smith', 'test@aol.com', '206c80413b9a96c1312cc346b7d2517b84463edd', 1);
