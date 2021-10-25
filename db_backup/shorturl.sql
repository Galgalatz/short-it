-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2021 at 08:53 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shorturl`
--

-- --------------------------------------------------------

--
-- Table structure for table `short_urls`
--

CREATE TABLE `short_urls` (
  `id` int(11) NOT NULL,
  `long_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_code` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `hits` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Truncate table before insert `short_urls`
--

TRUNCATE TABLE `short_urls`;
--
-- Dumping data for table `short_urls`
--

INSERT INTO `short_urls` (`id`, `long_url`, `short_code`, `hits`, `created`) VALUES
(1, 'https://github.com/Galgalatz', 'MdwjJcTO', 0, '2021-09-27 16:39:14'),
(2, 'https://www.yahoo.com/', 'qTeULWbq', 7, '2021-10-08 18:08:37'),
(3, 'http://www.ynet.co.il', 'YyMGZ4OD', 0, '2021-10-08 19:53:58'),
(4, 'http://www.google.com', 'Gal', 2, '2021-10-08 19:58:57'),
(6, 'https://shop.super-pharm.co.il/kiehls', 'AliasTest', 0, '2021-10-08 20:06:24'),
(7, 'https://www.ynet.co.il', '0GfhVKqG', 2, '2021-10-25 18:40:13'),
(8, 'https://www.youtbe.com', 'YouTube', 0, '2021-10-25 19:49:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `short_urls`
--
ALTER TABLE `short_urls`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `short_urls`
--
ALTER TABLE `short_urls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
