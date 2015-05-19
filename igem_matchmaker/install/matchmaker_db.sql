-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 19, 2015 at 07:06 PM
-- Server version: 5.6.24-0ubuntu2
-- PHP Version: 5.6.4-4ubuntu6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `matchmaker_db`
--
CREATE DATABASE IF NOT EXISTS `matchmaker_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `matchmaker_db`;

-- --------------------------------------------------------

--
-- Table structure for table `mm_entries`
--

DROP TABLE IF EXISTS `mm_entries`;
CREATE TABLE IF NOT EXISTS `mm_entries` (
`id` int(5) NOT NULL,
  `team` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(500) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `year` int(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mm_news`
--

DROP TABLE IF EXISTS `mm_news`;
CREATE TABLE IF NOT EXISTS `mm_news` (
`id` int(5) NOT NULL,
  `heading` varchar(200) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `author` varchar(50) NOT NULL,
  `twitter_user` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mm_temp`
--

DROP TABLE IF EXISTS `mm_temp`;
CREATE TABLE IF NOT EXISTS `mm_temp` (
  `id` int(5) NOT NULL,
  `team` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(500) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `confirm_code` varchar(300) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mm_entries`
--
ALTER TABLE `mm_entries`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mm_news`
--
ALTER TABLE `mm_news`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mm_temp`
--
ALTER TABLE `mm_temp`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mm_entries`
--
ALTER TABLE `mm_entries`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `mm_news`
--
ALTER TABLE `mm_news`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
