-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2018 at 04:58 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `class`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id` int(11) UNSIGNED NOT NULL,
  `board` varchar(256) DEFAULT NULL,
  `player_id` int(11) UNSIGNED DEFAULT NULL,
  `player_sign` char(1) DEFAULT NULL,
  `flag` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 - Spectator, 1 - Player'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `moves`
--

CREATE TABLE `moves` (
  `id` int(11) UNSIGNED NOT NULL,
  `board` varchar(20) NOT NULL,
  `cell_00` char(1) DEFAULT NULL,
  `cell_01` char(1) DEFAULT NULL,
  `cell_02` char(1) DEFAULT NULL,
  `cell_10` char(1) DEFAULT NULL,
  `cell_11` char(1) DEFAULT NULL,
  `cell_12` char(1) DEFAULT NULL,
  `cell_20` char(1) DEFAULT NULL,
  `cell_21` char(1) DEFAULT NULL,
  `cell_22` char(1) DEFAULT NULL,
  `play` char(1) NOT NULL DEFAULT 'X',
  `win` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `email_id` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_game_user_id` (`player_id`);

--
-- Indexes for table `moves`
--
ALTER TABLE `moves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_id` (`email_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `moves`
--
ALTER TABLE `moves`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `fk_game_user_id` FOREIGN KEY (`player_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
