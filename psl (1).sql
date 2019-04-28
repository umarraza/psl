-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2019 at 12:21 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psl`
--

-- --------------------------------------------------------

--
-- Table structure for table `apps_commands`
--

CREATE TABLE `apps_commands` (
  `id` int(10) NOT NULL,
  `command_name` varchar(255) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cric-series`
--

CREATE TABLE `cric-series` (
  `id` int(10) NOT NULL,
  `seriesName` varchar(30) NOT NULL,
  `status` varchar(20) NOT NULL,
  `type` varchar(30) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cric-series`
--

INSERT INTO `cric-series` (`id`, `seriesName`, `status`, `type`, `createdAt`, `updatedAt`) VALUES
(24, 'West Indies Vs Kenya', 'Un-Active', 'Tests', '2019-04-21 07:20:30', '2019-04-21 07:20:30'),
(25, 'West Indies Vs Ireland', 'Un-Active', 'ODI', '2019-04-23 07:40:44', '2019-04-23 07:40:44'),
(29, 'Pakistan Vs India', 'Active', 'ODI', '2019-04-28 21:52:34', '2019-04-28 21:52:34');

-- --------------------------------------------------------

--
-- Table structure for table `leagues`
--

CREATE TABLE `leagues` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leagues_psl`
--

CREATE TABLE `leagues_psl` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `league_members`
--

CREATE TABLE `league_members` (
  `id` int(10) NOT NULL,
  `memberId` int(10) NOT NULL,
  `memberRole` varchar(50) NOT NULL,
  `leagueId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `league_members_psl`
--

CREATE TABLE `league_members_psl` (
  `id` int(10) NOT NULL,
  `memberId` int(10) NOT NULL,
  `memberRole` varchar(50) NOT NULL,
  `leagueId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `id` int(11) NOT NULL,
  `teamA` varchar(100) NOT NULL,
  `teamB` varchar(100) NOT NULL,
  `unique_id` int(20) NOT NULL,
  `date` varchar(50) NOT NULL,
  `dateTimeGMT` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  `squad` tinyint(3) NOT NULL,
  `matchStarted` tinyint(3) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `matchespsl`
--

CREATE TABLE `matchespsl` (
  `id` int(11) NOT NULL,
  `teamA` varchar(100) NOT NULL,
  `teamB` varchar(100) NOT NULL,
  `unique_id` int(20) NOT NULL,
  `date` varchar(50) NOT NULL,
  `dateTimeGMT` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  `squad` tinyint(3) NOT NULL,
  `matchStarted` tinyint(3) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `matchesq`
--

CREATE TABLE `matchesq` (
  `id` int(11) NOT NULL,
  `teamA` varchar(100) NOT NULL,
  `teamB` varchar(100) NOT NULL,
  `unique_id` int(20) NOT NULL,
  `date` varchar(50) NOT NULL,
  `dateTimeGMT` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `squad` tinyint(3) NOT NULL,
  `matchStarted` tinyint(3) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `match_team_members`
--

CREATE TABLE `match_team_members` (
  `id` int(10) NOT NULL,
  `matchId` int(10) NOT NULL DEFAULT '0',
  `ownerId` int(10) NOT NULL,
  `playerData` varchar(2000) NOT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `match_team_members`
--

INSERT INTO `match_team_members` (`id`, `matchId`, `ownerId`, `playerData`, `createdAt`, `updatedAt`) VALUES
(1, 39, 1022, '[{\"playerId\":\"1\",\"matchRole\":\"captain\",\"points\":500,\"pid\":\"1\"},{\"playerId\":2,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"2\"},{\"playerId\":\"3\",\"matchRole\":\"regular\",\"points\":0,\"pid\":\"3\"},{\"playerId\":4,\"matchRole\":\"Man Of Match\",\"points\":40500,\"pid\":\"4\"},{\"playerId\":\"5\",\"matchRole\":\"regular\",\"points\":0,\"pid\":\"5\"},{\"playerId\":6,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"6\"},{\"playerId\":\"7\",\"matchRole\":\"regular\",\"points\":0,\"pid\":\"7\"},{\"playerId\":8,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"8\"},{\"playerId\":\"9\",\"matchRole\":\"regular\",\"points\":0,\"pid\":\"9\"},{\"playerId\":10,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"10\"},{\"playerId\":\"11\",\"matchRole\":\"regular\",\"points\":0,\"pid\":\"11\"}]', '2019-04-17 02:05:38', '2019-04-17 07:56:12'),
(2, 39, 1023, '[{\"playerId\":\"1\",\"matchRole\":\"captain\",\"points\":500,\"pid\":\"1\"},{\"playerId\":2,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"2\"},{\"playerId\":\"3\",\"matchRole\":\"Man Of Match\",\"points\":500,\"pid\":\"3\"},{\"playerId\":4,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"4\"},{\"playerId\":\"5\",\"matchRole\":\"regular\",\"points\":0,\"pid\":\"5\"},{\"playerId\":6,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"6\"},{\"playerId\":\"7\",\"matchRole\":\"regular\",\"points\":0,\"pid\":\"7\"},{\"playerId\":8,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"8\"},{\"playerId\":\"9\",\"matchRole\":\"regular\",\"points\":300,\"pid\":\"14\"},{\"playerId\":10,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"10\"},{\"playerId\":\"11\",\"matchRole\":\"regular\",\"points\":0,\"pid\":\"11\"}]', '2019-04-17 07:32:09', '2019-04-17 05:32:12'),
(3, 39, 1024, '[{\"playerId\":\"1\",\"matchRole\":\"captain\",\"points\":500,\"pid\":\"1\"},{\"playerId\":2,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"2\"},{\"playerId\":\"3\",\"matchRole\":\"regular\",\"points\":0,\"pid\":\"3\"},{\"playerId\":4,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"4\"},{\"playerId\":\"5\",\"matchRole\":\"regular\",\"points\":0,\"pid\":\"5\"},{\"playerId\":6,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"6\"},{\"playerId\":\"7\",\"matchRole\":\"regular\",\"points\":0,\"pid\":\"7\"},{\"playerId\":8,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"8\"},{\"playerId\":\"9\",\"matchRole\":\"regular\",\"points\":0,\"pid\":\"9\"},{\"playerId\":10,\"matchRole\":\"regular\",\"points\":0,\"pid\":\"10\"},{\"playerId\":\"11\",\"matchRole\":\"Man Of Match\",\"points\":500,\"pid\":\"11\"}]', '2019-04-17 10:08:40', '2019-04-17 05:32:12');

-- --------------------------------------------------------

--
-- Table structure for table `match_team_membersbk`
--

CREATE TABLE `match_team_membersbk` (
  `id` int(10) NOT NULL,
  `matchId` int(10) NOT NULL DEFAULT '0',
  `playerId` int(10) NOT NULL,
  `ownerId` int(10) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `matchRole` varchar(50) NOT NULL,
  `pid` int(20) NOT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `match_team_membersbk2`
--

CREATE TABLE `match_team_membersbk2` (
  `id` int(10) NOT NULL,
  `matchId` int(10) NOT NULL DEFAULT '0',
  `playerId` int(10) NOT NULL,
  `ownerId` int(10) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `matchRole` varchar(50) NOT NULL,
  `pid` int(20) NOT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `match_team_members_psl`
--

CREATE TABLE `match_team_members_psl` (
  `id` int(10) NOT NULL,
  `matchId` int(10) NOT NULL DEFAULT '0',
  `playerId` int(10) NOT NULL,
  `ownerId` int(10) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `matchRole` varchar(50) NOT NULL,
  `pid` int(20) NOT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `pid` int(20) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `nameOfTeam` varchar(250) DEFAULT NULL,
  `matchId` int(10) NOT NULL,
  `seriesId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `name`, `designation`, `pid`, `image`, `nameOfTeam`, `matchId`, `seriesId`, `createdAt`, `updatedAt`) VALUES
(32, 'Umar Raza', 'Bowler', NULL, NULL, 'Pakistan', 24, 24, '2019-04-28 21:22:59', '2019-04-28 21:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `players_psl`
--

CREATE TABLE `players_psl` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(10) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pid` int(20) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `nameOfTeam` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) NOT NULL,
  `description` varchar(200) NOT NULL,
  `label` varchar(50) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `description`, `label`, `createdAt`, `updatedAt`) VALUES
(3, 'Super Admin', 'super_admin', '2019-04-01 06:45:24', '0000-00-00 00:00:00'),
(4, 'Amdmin', 'admin', '2019-04-01 06:45:24', '0000-00-00 00:00:00'),
(5, 'Team Owner', 'team_owner', '2019-04-01 06:46:19', '0000-00-00 00:00:00'),
(6, 'Service Provider', 'service_provider', '2019-04-01 06:46:19', '0000-00-00 00:00:00'),
(7, 'Student', 'student', '2019-04-01 06:46:42', '0000-00-00 00:00:00'),
(8, 'Secondary Admin', 'secondary_admin', '2019-04-01 06:46:42', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `id` int(10) NOT NULL,
  `condition` varchar(100) NOT NULL,
  `points` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `condition`, `points`, `createdAt`, `updatedAt`) VALUES
(1, 'runs>50', 100, '2019-04-28 18:52:03', '2019-04-29 03:40:57'),
(2, 'runs>100', 100, '2019-04-28 18:52:03', '2019-04-29 04:23:23');

-- --------------------------------------------------------

--
-- Table structure for table `series_matches`
--

CREATE TABLE `series_matches` (
  `id` int(10) NOT NULL,
  `teamA` varchar(20) NOT NULL,
  `teamB` varchar(20) NOT NULL,
  `dateTimeGMT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `startingTime` varchar(40) NOT NULL,
  `endingTime` varchar(40) NOT NULL,
  `format` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `seriesId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `series_matches`
--

INSERT INTO `series_matches` (`id`, `teamA`, `teamB`, `dateTimeGMT`, `startingTime`, `endingTime`, `format`, `status`, `seriesId`, `createdAt`, `updatedAt`) VALUES
(35, 'Pakistan', 'India', '2019-04-19 10:55:29', '04:00:00', '03:55:29', 'ODI', 'Un-Active', 24, '2019-04-21 07:55:00', '2019-04-21 07:55:00'),
(40, 'Pakistan', 'Canada', '2019-04-19 10:55:29', '03:55:29', '03:55:29', 'ODI', 'Un-Active', 24, '2019-04-28 21:22:23', '2019-04-28 21:22:23'),
(41, 'Austrailia', 'Inida', '2019-04-19 07:00:00', '03:55:29', '03:55:29', 'ODI', 'Un-Active', 24, '2019-04-28 21:22:44', '2019-04-28 21:22:44'),
(42, 'Pakistan', 'Canada', '2019-04-19 10:55:29', '03:55:29', '03:55:29', 'ODI', 'Un-Active', 24, '2019-04-28 22:00:31', '2019-04-28 22:00:31'),
(43, 'Austrailia', 'Inida', '2019-04-19 10:55:29', '04:00:00', '03:55:29', 'ODI', 'Active', 24, '2019-04-28 22:00:43', '2019-04-28 22:00:43');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(10) NOT NULL,
  `ownerId` int(10) NOT NULL,
  `playerData` varchar(2000) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `ownerId`, `playerData`, `createdAt`, `updatedAt`) VALUES
(39, 1022, '[{\"playerId\":\"1\",\"matchRole\":\"captain\",\"points\":\"0\",\"pid\":\"1\"},{\"playerId\":2,\"matchRole\":\"regular\",\"points\":\"0\",\"pid\":\"1\"},{\"playerId\":\"3\",\"matchRole\":\"regular\",\"points\":\"0\",\"pid\":\"1\"},{\"playerId\":4,\"matchRole\":\"regular\",\"points\":\"0\",\"pid\":\"1\"},{\"playerId\":\"5\",\"matchRole\":\"regular\",\"points\":\"0\",\"pid\":\"1\"},{\"playerId\":6,\"matchRole\":\"regular\",\"points\":\"0\",\"pid\":\"1\"},{\"playerId\":\"7\",\"matchRole\":\"regular\",\"points\":\"0\",\"pid\":\"1\"},{\"playerId\":8,\"matchRole\":\"regular\",\"points\":\"0\",\"pid\":\"1\"},{\"playerId\":\"9\",\"matchRole\":\"regular\",\"points\":\"0\",\"pid\":\"1\"},{\"playerId\":10,\"matchRole\":\"regular\",\"points\":\"0\",\"pid\":\"1\"},{\"playerId\":\"11\",\"matchRole\":\"regular\",\"points\":\"0\",\"pid\":\"1\"}]', '2019-04-16 04:56:48', '2019-04-16 04:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `team_members_testversion`
--

CREATE TABLE `team_members_testversion` (
  `id` int(10) NOT NULL,
  `matchId` int(10) NOT NULL DEFAULT '0',
  `playerId` int(10) NOT NULL,
  `ownerId` int(10) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `matchRole` varchar(50) NOT NULL,
  `pid` int(20) NOT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `team_owners`
--

CREATE TABLE `team_owners` (
  `id` int(10) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `mobileNumber` varchar(100) NOT NULL,
  `teamMembers` varchar(150) DEFAULT NULL,
  `moves` int(10) NOT NULL,
  `amountInAccount` varchar(500) NOT NULL,
  `userId` int(10) NOT NULL,
  `total_points` int(10) DEFAULT '0',
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team_owners`
--

INSERT INTO `team_owners` (`id`, `firstName`, `lastName`, `mobileNumber`, `teamMembers`, `moves`, `amountInAccount`, `userId`, `total_points`, `createdAt`, `updatedAt`) VALUES
(1021, 'Umar', 'Raza', '0303132432', NULL, 120, '1100000000', 1031, 0, '2019-04-01 01:46:52', '2019-04-01 01:46:52'),
(1022, 'Numan', 'Hashmi', '03334545623', NULL, 66, '12000000', 1032, 0, '2019-04-16 09:56:49', '2019-04-16 04:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `team_owners_psl`
--

CREATE TABLE `team_owners_psl` (
  `id` int(10) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `mobileNumber` varchar(100) NOT NULL,
  `teamMembers` varchar(150) DEFAULT NULL,
  `moves` int(10) NOT NULL,
  `amountInAccount` varchar(500) NOT NULL,
  `userId` int(10) NOT NULL,
  `total_points` int(10) DEFAULT '0',
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `roleId` int(10) NOT NULL,
  `resetPasswordToken` varchar(255) DEFAULT NULL,
  `createdResetPToken` timestamp NULL DEFAULT NULL,
  `avatarFilePath` varchar(200) DEFAULT NULL,
  `deviceToken` varchar(200) DEFAULT NULL,
  `onlineStatus` tinyint(3) NOT NULL DEFAULT '0',
  `verified` tinyint(3) NOT NULL,
  `googleLogin` varchar(250) DEFAULT NULL,
  `facebookLogin` varchar(250) DEFAULT NULL,
  `language` varchar(20) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `remember_token`, `roleId`, `resetPasswordToken`, `createdResetPToken`, `avatarFilePath`, `deviceToken`, `onlineStatus`, `verified`, `googleLogin`, `facebookLogin`, `language`, `createdAt`, `updatedAt`) VALUES
(1031, 'super.admin@admin.com', 'super.admin@admin.com', '$2y$10$sf9teTeJIIgYoOESzaj35Os7qRUHvOIHInnaz3EtueBaH5/dsojY6', 'O1pIZIaqdRFMSvjbmiey3B9JaPYQqSJPfKbMs1WdloVgb3ZmnAjsz4JiQgpS', 3, '123456', NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-04-28 21:21:31', '2019-04-01 01:46:52'),
(1032, 'numan11@gmail.com', 'numan11@gmail.com', '$2y$10$cN2caxzXyd0361aXfXq1O.fIWPyIISEpaYhZwl7k/DvAsEzK02oya', NULL, 5, '123456', NULL, NULL, NULL, 0, 1, NULL, NULL, 'Urdu', '2019-04-18 10:11:46', '2019-04-16 00:12:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apps_commands`
--
ALTER TABLE `apps_commands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cric-series`
--
ALTER TABLE `cric-series`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leagues`
--
ALTER TABLE `leagues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leagues_psl`
--
ALTER TABLE `leagues_psl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `league_members`
--
ALTER TABLE `league_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `league_members_psl`
--
ALTER TABLE `league_members_psl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matchespsl`
--
ALTER TABLE `matchespsl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matchesq`
--
ALTER TABLE `matchesq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `match_team_members`
--
ALTER TABLE `match_team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `match_team_membersbk`
--
ALTER TABLE `match_team_membersbk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `match_team_membersbk2`
--
ALTER TABLE `match_team_membersbk2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `match_team_members_psl`
--
ALTER TABLE `match_team_members_psl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `players_psl`
--
ALTER TABLE `players_psl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `series_matches`
--
ALTER TABLE `series_matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members_testversion`
--
ALTER TABLE `team_members_testversion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_owners`
--
ALTER TABLE `team_owners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_detail_k1` (`userId`);

--
-- Indexes for table `team_owners_psl`
--
ALTER TABLE `team_owners_psl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_detail_k1` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_k1` (`roleId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apps_commands`
--
ALTER TABLE `apps_commands`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cric-series`
--
ALTER TABLE `cric-series`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `leagues`
--
ALTER TABLE `leagues`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leagues_psl`
--
ALTER TABLE `leagues_psl`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `league_members`
--
ALTER TABLE `league_members`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `league_members_psl`
--
ALTER TABLE `league_members_psl`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `matchespsl`
--
ALTER TABLE `matchespsl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `matchesq`
--
ALTER TABLE `matchesq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `match_team_members`
--
ALTER TABLE `match_team_members`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `match_team_membersbk`
--
ALTER TABLE `match_team_membersbk`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `match_team_membersbk2`
--
ALTER TABLE `match_team_membersbk2`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `match_team_members_psl`
--
ALTER TABLE `match_team_members_psl`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `players_psl`
--
ALTER TABLE `players_psl`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `series_matches`
--
ALTER TABLE `series_matches`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `team_members_testversion`
--
ALTER TABLE `team_members_testversion`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_owners`
--
ALTER TABLE `team_owners`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1023;

--
-- AUTO_INCREMENT for table `team_owners_psl`
--
ALTER TABLE `team_owners_psl`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1033;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
