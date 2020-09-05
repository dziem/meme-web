-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2017 at 08:07 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meme`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id_akun`, `username`, `password`) VALUES
(1, 'dude', 'dude'),
(6, 'geez', 'gez'),
(7, 'pumphrey', '502'),
(8, 'moore', 'moore'),
(10, 'asd', 'asd'),
(11, 'qwe', 'qwe'),
(12, 'jay', 'jays'),
(13, 'jaxx', 'jax'),
(14, 'vegas', 'cegas'),
(15, 'west', 'west');

-- --------------------------------------------------------

--
-- Table structure for table `meme`
--

CREATE TABLE `meme` (
  `id_meme` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `meme` varchar(255) NOT NULL,
  `nsfw` tinyint(1) NOT NULL,
  `upvote` int(11) NOT NULL,
  `downvote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meme`
--

INSERT INTO `meme` (`id_meme`, `id_akun`, `judul`, `meme`, `nsfw`, `upvote`, `downvote`) VALUES
(7, 1, 'Meme', '26112017105252meme2.png', 0, 0, 0),
(10, 6, 'Emem', '26112017105444meme1.png', 0, 0, 0),
(17, 6, 'Memos', '01122017111606meme2.png', 0, 1, 0),
(19, 1, 'New Meme', '28112017051901meme5.png', 1, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `id_vote` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `id_meme` int(11) NOT NULL,
  `vote` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`id_vote`, `id_akun`, `id_meme`, `vote`) VALUES
(8, 6, 19, 'u'),
(9, 6, 17, 'u'),
(10, 15, 19, 'u');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `meme`
--
ALTER TABLE `meme`
  ADD PRIMARY KEY (`id_meme`),
  ADD KEY `fk_id_akun` (`id_akun`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id_vote`),
  ADD KEY `fk_id_meme` (`id_meme`),
  ADD KEY `fk_id_akun2` (`id_akun`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `meme`
--
ALTER TABLE `meme`
  MODIFY `id_meme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vote`
--
ALTER TABLE `vote`
  MODIFY `id_vote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `meme`
--
ALTER TABLE `meme`
  ADD CONSTRAINT `fk_id_akun` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id_akun`);

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `fk_id_akun2` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id_akun`),
  ADD CONSTRAINT `fk_id_meme` FOREIGN KEY (`id_meme`) REFERENCES `meme` (`id_meme`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
