-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 05, 2018 at 08:07 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chating`
--

-- --------------------------------------------------------

--
-- Table structure for table `cover`
--

CREATE TABLE IF NOT EXISTS `cover` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `path` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `cover`
--

INSERT INTO `cover` (`id`, `username`, `path`) VALUES
(29, 'BlackJack', 'upload/171120170858.jpg'),
(45, 'loannt13', 'upload/17112017153004.jpg'),
(61, 'choxurunglong', 'upload/23112017140948.jpg'),
(66, 'ThanhLN6', 'upload/23112017154126.jpg'),
(67, 'ThanhLN6', 'upload/24112017084831.jpg'),
(68, 'ThanhLN6', 'upload/24112017090851.jpg'),
(69, 'loannt13', 'upload/24112017092310.JPG'),
(70, 'loannt13', 'upload/24112017092314.JPG'),
(71, 'loannt13', 'upload/24112017092318.JPG'),
(72, 'ThanhLN6', 'upload/24112017113614.jpg'),
(73, 'ThanhLN6', 'upload/24112017113638.jpg'),
(74, 'ThanhLN6', 'upload/24112017113757.jpg'),
(75, 'ThanhLN6', 'upload/24112017113804.jpg'),
(76, 'ThanhLN6', 'upload/19012018090852.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `messager`
--

CREATE TABLE IF NOT EXISTS `messager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userfrom` text NOT NULL,
  `userto` text NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `date_create` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `messager`
--

INSERT INTO `messager` (`id`, `userfrom`, `userto`, `body`, `date_create`) VALUES
(1, 'ThanhLN6', 'Junlexo', 0x3f3f, '2018-01-19 08:44:50'),
(2, 'ThanhLN6', 'Junlexo', 0x3f68616861, '2018-01-19 08:44:59');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_bin NOT NULL,
  `userfrom` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin AUTO_INCREMENT=11 ;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `body`, `userfrom`, `date_create`) VALUES
(1, 0x3f, 'ThanhLN6', '2018-01-16 14:48:34'),
(2, 0x3f, 'ThanhLN6', '2018-01-16 14:48:34'),
(3, 0x58696e, 'Junlexo', '2018-01-19 08:33:54'),
(4, 0x48c3a279, 'Junlexo', '2018-01-19 08:34:02'),
(5, 0x48616861, 'Junlexo', '2018-01-19 08:34:11'),
(6, 0x48616861, 'Junlexo', '2018-01-19 08:34:11'),
(7, 0x37373737, 'ThanhLN6', '2018-01-19 08:34:18'),
(8, 0x58696e206368616f, 'Junlexo', '2018-01-19 08:34:52'),
(9, 0x58696e206368616f, 'Junlexo', '2018-01-19 08:34:52'),
(10, 0x78696e206368616f, 'ThanhLN6', '2018-01-19 09:08:37');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `date_create` date NOT NULL,
  `singal` text NOT NULL,
  `ip_last` text NOT NULL,
  `clientSocket` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `is_active`, `date_create`, `singal`, `ip_last`, `clientSocket`) VALUES
(21, 'ThanhLN6', 'd1347cd3b29fab302104d66d8e11f090', 1, '2018-01-16', 'Junlexo', '127.0.0.1', 'Resource id #23'),
(22, 'Junlexo', '4297f44b13955235245b2497399d7a93', 1, '2018-01-19', 'Carlos', '192.168.137.191', 'Resource id #9');
