-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Oct 13, 2020 at 06:27 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_calendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `second_appointment`
--

CREATE TABLE `second_appointment` (
  `id` int(11) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `second_appointment`
--

INSERT INTO `second_appointment` (`id`, `start_datetime`, `end_datetime`, `customer_email`, `customer_name`, `customer_phone_number`) VALUES
(1, '2020-10-21 14:00:00', '2020-10-21 15:00:00', 'gustavo@echelonwebsites.com', 'Gustavo Amezcua', '555-555-5555'),
(2, '2020-10-21 15:00:00', '2020-10-21 15:30:00', 'gustavo@echelonwebsites.com', 'Rick James', '555-555-5555'),
(3, '2020-10-09 14:00:00', '2020-10-09 15:00:00', 'gustavo@echelonwebsites.com', 'Gustavo Amezcua', '555-555-5555'),
(4, '2020-10-08 15:00:00', '2020-10-08 15:30:00', 'gustavo@echelonwebsites.com', 'Rick James', '555-555-5555');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `second_appointment`
--
ALTER TABLE `second_appointment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `second_appointment`
--
ALTER TABLE `second_appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
