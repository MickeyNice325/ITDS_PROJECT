-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2025 at 06:46 AM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itds_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment_tb`
--

CREATE TABLE `comment_tb` (
  `time` time NOT NULL,
  `message` mediumtext NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `img_tb`
--

CREATE TABLE `img_tb` (
  `img_id` int(11) NOT NULL,
  `img_name` varchar(255) NOT NULL,
  `img_detail` text NOT NULL,
  `imge` varchar(255) NOT NULL,
  `width` varchar(255) NOT NULL,
  `height` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `news_tb`
--

CREATE TABLE `news_tb` (
  `news_id` int(11) NOT NULL,
  `news_name` varchar(255) NOT NULL,
  `news_detail` text NOT NULL,
  `image_id` int(11) NOT NULL,
  `news_stats` varchar(50) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `news_delay` float(5,2) NOT NULL,
  `layout_select` int(4) NOT NULL,
  `img_id_1` int(11) DEFAULT NULL,
  `img_id_2` int(11) DEFAULT NULL,
  `img_id_3` int(11) DEFAULT NULL,
  `img_id_4` int(11) DEFAULT NULL,
  `img_id_5` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `comments_enabled` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`comments_enabled`) VALUES
(1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `img_tb`
--
ALTER TABLE `img_tb`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `news_tb`
--
ALTER TABLE `news_tb`
  ADD PRIMARY KEY (`news_id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `img_id_1` (`img_id_1`),
  ADD KEY `img_id_2` (`img_id_2`),
  ADD KEY `img_id_3` (`img_id_3`),
  ADD KEY `img_id_4` (`img_id_4`),
  ADD KEY `img_id_5` (`img_id_5`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `img_tb`
--
ALTER TABLE `img_tb`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news_tb`
--
ALTER TABLE `news_tb`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `news_tb`
--
ALTER TABLE `news_tb`
  ADD CONSTRAINT `news_tb_ibfk_1` FOREIGN KEY (`img_id_1`) REFERENCES `img_tb` (`img_id`),
  ADD CONSTRAINT `news_tb_ibfk_2` FOREIGN KEY (`img_id_2`) REFERENCES `img_tb` (`img_id`),
  ADD CONSTRAINT `news_tb_ibfk_3` FOREIGN KEY (`img_id_3`) REFERENCES `img_tb` (`img_id`),
  ADD CONSTRAINT `news_tb_ibfk_4` FOREIGN KEY (`img_id_4`) REFERENCES `img_tb` (`img_id`),
  ADD CONSTRAINT `news_tb_ibfk_5` FOREIGN KEY (`img_id_5`) REFERENCES `img_tb` (`img_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
