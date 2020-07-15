-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 15, 2020 at 10:14 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_movie`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `name`) VALUES
(1, 'action'),
(2, 'adventure'),
(3, 'comedy'),
(4, 'horror');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies` (
  `movie_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `year_of_release` date DEFAULT NULL,
  `poster` varchar(500) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `path` varchar(500) DEFAULT NULL,
  `sinopsis` text DEFAULT NULL,
  PRIMARY KEY (`movie_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `title`, `year_of_release`, `poster`, `cat_id`, `path`, `sinopsis`) VALUES
(1, 'Jurassic park', '1993-07-03', 'imgs/jurassicpark.jpg', 1, NULL, NULL),
(2, 'E.T', '1982-11-03', 'imgs/ET.jpg', 2, NULL, NULL),
(3, 'Star Wars: A New Hope', '1977-11-03', 'imgs/StarWarsANewHope.jpg', NULL, NULL, NULL),
(4, 'Raiders of the Lost Ark', '1981-11-03', 'imgs/RaidersOfTheLostArk.jpg', 2, NULL, NULL),
(5, 'Snatch', '2001-11-03', 'imgs/snatch.jpg', 3, NULL, NULL),
(6, 'Star Wars', '2000-11-03', 'imgs/starwars2000.jpg', 2, NULL, NULL),
(7, 'The Pianist', '2002-11-03', 'imgs/thePianist.jpg', 3, NULL, NULL),
(8, 'Jaws', '1975-11-03', 'imgs/jaws.jpg', 2, NULL, NULL),
(9, 'Star Wars: Revenge of the Sith', '1999-11-03', 'imgs/RevengeoftheSith.jpg', 1, NULL, NULL),
(10, 'Rosemary\'s Baby', '1968-11-03', 'imgs/rosemary.jpg', 2, NULL, NULL),
(11, 'Oliver Twist', '2005-11-03', 'imgs/oliver.jpg', 3, NULL, NULL),
(12, 'J\'accuse', '2019-11-03', 'imgs/jaccuse.jpg', 4, NULL, NULL),
(13, 'The Gentlemen', '2019-11-03', 'imgs/gentlemen.jpg', 3, NULL, NULL),
(14, 'The Man from U.N.C.L.E.', '2015-11-03', 'imgs/uncle.jpg', 2, NULL, NULL),
(15, 'Interesting movie', '2020-11-03', 'imgs/movie.jpg', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

DROP TABLE IF EXISTS `playlist`;
CREATE TABLE IF NOT EXISTS `playlist` (
  `playlist_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`playlist_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`playlist_id`, `name`, `user_id`) VALUES
(1, 'study', 1);

-- --------------------------------------------------------

--
-- Table structure for table `playlist_content`
--

DROP TABLE IF EXISTS `playlist_content`;
CREATE TABLE IF NOT EXISTS `playlist_content` (
  `playlist_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  PRIMARY KEY (`playlist_id`,`movie_id`),
  KEY `movie_id` (`movie_id`),
  KEY `playlist_id` (`playlist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `playlist_content`
--

INSERT INTO `playlist_content` (`playlist_id`, `movie_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `PHPSESSID` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `password`, `PHPSESSID`) VALUES
(1, 'mitchio', 'awesome', 'mitchio@mitchio.com', '$2y$10$FixIjpk91MNryNgrnbFHMOpcqbQt4lwiGTMu0Ku7wsbmZYj9T.zES', 'o7i1hotkptn88o4d9ttscj5on9');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`) ON UPDATE CASCADE;

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `playlist_content`
--
ALTER TABLE `playlist_content`
  ADD CONSTRAINT `playlist_content_ibfk_1` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`playlist_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `playlist_content_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
