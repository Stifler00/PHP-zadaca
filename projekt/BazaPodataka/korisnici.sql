-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2024 at 09:04 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php-zadaca`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `korisnicko_ime` varchar(128) NOT NULL,
  `ime` varchar(32) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `email_adresa` varchar(128) NOT NULL,
  `drzava` char(2) NOT NULL,
  `grad` varchar(32) NOT NULL,
  `ulica` varchar(128) NOT NULL,
  `datum_rodjenja` date DEFAULT NULL,
  `lozinka` varchar(255) NOT NULL,
  `rola` set('user','editor','administrator','') DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `korisnicko_ime`, `ime`, `prezime`, `email_adresa`, `drzava`, `grad`, `ulica`, `datum_rodjenja`, `lozinka`, `rola`, `approved`) VALUES
(1, 'admin', 'Jan', 'Tovernić', 'jan.tovernic@gmail.com', 'HR', 'Zagreb', 'Ulica', '2000-11-03', '$2y$10$lec7Ihw3H8LLF1tFj1p/2OGpCYr0jZpIlP8vy9H.bDPpoR1Ty26D.', 'administrator', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
