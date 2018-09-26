-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2018 at 03:55 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nobody`
--

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`ID`, `Categoria`) VALUES
(1, 2018),
(2, 2017),
(3, 2016),
(4, 2015),
(5, 2014),
(6, 2013),
(7, 2012),
(8, 2011),
(9, 2010),
(10, 2009),
(11, 2008),
(12, 2007),
(13, 2006);


INSERT INTO `lang` (`ID`, `Lang`) VALUES
(1, 'en'),
(2, 'it');


INSERT INTO `press` (`ID`, `FK_Categoria`, `Data`) VALUES
(11, 1, '2018-06-01 14:10:00'),
(12, 2, '2017-09-01 14:20:00'),
(13, 2, '2017-06-01 14:20:00'),
(14, 2, '2017-07-01 14:25:00'),
(15, 2, '2017-07-01 05:25:00');
COMMIT;



--
-- Dumping data for table `contenuto_press`
--

INSERT INTO `contenuto_press` (`ID`, `FK_Lang`, `FK_Press`, `Testo`) VALUES
(21, 1, 11, '.June. <br> Italia Icon Design 2018<br>.ITA.'),
(22, 2, 11, '.Giugno. <br> Italia Icon Design 2018<br>.ITA.'),
(23, 1, 12, '.September.<br>Il Sole 24 Ore ITA - Casa24 Plus<br>.ITA.'),
(24, 2, 12, '.Settembre.<br>Il Sole 24 Ore ITA - Casa24 Plus<br>.ITA.'),
(25, 1, 13, '.June. <br>HOME <br>.ITA.'),
(26, 2, 13, '.Giugno. <br>HOME <br>.ITA.'),
(27, 1, 14, '.July. <br>ELLE DECOR ITALIA <br>.ITA.'),
(28, 2, 14, '.Luglio. <br>ELLE DECOR ITALIA <br>.ITA.'),
(29, 1, 15, '.Luglio. <br>WALLPAPER <br>.UK.'),
(30, 2, 15, '.Luglio. <br>WALLPAPER <br>.UK.');

--
-- Dumping data for table `img_press`
--

INSERT INTO `img_press` (`ID`, `FK_Press`, `Percorso`, `Progressivo`) VALUES
(70, 11, '/794709514a02018.jpg', 0),
(71, 11, '/1336324707a12018.jpg', 1),
(72, 12, '/1017437163a02017.jpg', 0),
(73, 13, '/1337636812b02017.jpg', 0),
(74, 13, '/101079117b12017.jpg', 1),
(75, 13, '/604446008b22017.jpg', 2),
(76, 14, '/1775034281c02017.jpg', 0),
(77, 14, '/981717610c12017.jpg', 1),
(78, 14, '/1521008136c22017.jpg', 2),
(79, 15, '/712737785d02017.jpg', 0),
(80, 15, '/215749185d12017.jpg', 1);

--
-- Dumping data for table `lang`
--

--
-- Dumping data for table `press`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
