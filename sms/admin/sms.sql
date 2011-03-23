-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5+lenny3
-- http://www.phpmyadmin.net
--
-- Host: aldebaran
-- Generation Time: Jun 23, 2010 at 01:23 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6-1+lenny4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `playsms`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `ID` int(4) NOT NULL auto_increment,
  `Name` char(30) NOT NULL,
  `Number` char(30) NOT NULL,
  `Email` char(50) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`ID`, `Name`, `Number`, `Email`) VALUES
(2, 'Markus Dorn', '+4915774733679', ''),
(9, 'Andreas Kaetsch', '+491703000352', ''),
(11, 'Raimund Kohlmann', '+491794726849', ''),
(12, 'Heike Held', '+4916090128639', ''),
(13, 'Angelika Nachmann', '+4917637503617', ''),
(14, 'Esther Stolte', '+491712243555', ''),
(15, 'Susanne Knoll', '+491715539453', ''),
(16, 'Sabine Krauss', '+491719745471', '');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `MessageID` int(11) NOT NULL auto_increment,
  `Name` char(40) default NULL,
  `Number` char(30) NOT NULL,
  `Message` tinytext NOT NULL,
  `Datum` char(20) default NULL,
  PRIMARY KEY  (`MessageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `messages`
--

