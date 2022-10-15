-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2022 at 01:09 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sample`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `userId` int(145) NOT NULL,
  `adminFirst_Name` varchar(145) DEFAULT NULL,
  `adminMiddle_Name` varchar(145) DEFAULT NULL,
  `adminLast_Name` varchar(145) DEFAULT NULL,
  `adminEmail` varchar(145) DEFAULT NULL,
  `adminPassword` varchar(145) DEFAULT NULL,
  `adminStatus` enum('Y','N') DEFAULT 'N',
  `tokencode` varchar(145) DEFAULT NULL,
  `adminProfile` varchar(1145) NOT NULL DEFAULT 'profile.png',
  `account_status` enum('active','disabled') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`userId`, `adminFirst_Name`, `adminMiddle_Name`, `adminLast_Name`, `adminEmail`, `adminPassword`, `adminStatus`, `tokencode`, `adminProfile`, `account_status`, `created_at`, `updated_at`) VALUES
(1, 'JOSE', 'DATU', 'SANTOS', 'fisheryapp092922@gmail.com', '42f749ade7f9e195bf475f37a44cafcb', 'Y', 'd5cbbb984afb41c1adf88a8e19740cc9', 'green-profile.png', 'active', '2022-07-07 05:19:44', '2022-10-15 03:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

CREATE TABLE `email_config` (
  `Id` int(145) NOT NULL,
  `email` varchar(145) DEFAULT NULL,
  `password` varchar(145) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email_config`
--

INSERT INTO `email_config` (`Id`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'fisheryapp092922@gmail.com', 'qwgjqojqbxywkcfq', '2022-07-08 04:41:51', '2022-10-15 04:28:36');

-- --------------------------------------------------------

--
-- Table structure for table `google_recaptcha_api`
--

CREATE TABLE `google_recaptcha_api` (
  `Id` int(11) NOT NULL,
  `site_key` varchar(145) DEFAULT NULL,
  `site_secret_key` varchar(145) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `google_recaptcha_api`
--

INSERT INTO `google_recaptcha_api` (`Id`, `site_key`, `site_secret_key`, `created_at`, `updated_at`) VALUES
(1, '6LfeHlkdAAAAABiHm93II8UuYYtIs8WFhSIiWQ-B', '6LfeHlkdAAAAAA3NYvNccc_FqzGi2Y6wiGGCOG1s', '2022-07-08 04:29:37', '2022-07-12 07:14:01');

-- --------------------------------------------------------

--
-- Table structure for table `superadmin`
--

CREATE TABLE `superadmin` (
  `superadminId` int(145) NOT NULL,
  `name` varchar(145) DEFAULT NULL,
  `email` varchar(145) DEFAULT NULL,
  `password` varchar(145) DEFAULT NULL,
  `tokencode` varchar(145) DEFAULT NULL,
  `profile` varchar(1145) NOT NULL DEFAULT 'profile.png',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `superadmin`
--

INSERT INTO `superadmin` (`superadminId`, `name`, `email`, `password`, `tokencode`, `profile`, `created_at`, `updated_at`) VALUES
(1, 'JUAN, DATU', 'fisheryapp092922@gmail.com', '42f749ade7f9e195bf475f37a44cafcb', '9e5a0cb44c4b0aa56e6bf74e3cda4d24', 'green-profile.png', '2022-07-03 00:09:13', '2022-10-15 06:45:47');

-- --------------------------------------------------------

--
-- Table structure for table `system_config`
--

CREATE TABLE `system_config` (
  `Id` int(14) NOT NULL,
  `system_name` varchar(145) DEFAULT NULL,
  `system_number` varchar(145) DEFAULT NULL,
  `system_email` varchar(145) DEFAULT NULL,
  `copy_right` varchar(145) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_config`
--

INSERT INTO `system_config` (`Id`, `system_name`, `system_number`, `system_email`, `copy_right`, `created_at`, `updated_at`) VALUES
(1, 'FSR - Fishery Supplier Recommender', '9776621929', 'fisheryapp092922@gmail.com', 'Copyright 2022 AMV. All right reserved', '2022-07-08 12:38:28', '2022-10-15 03:53:48');

-- --------------------------------------------------------

--
-- Table structure for table `system_logo`
--

CREATE TABLE `system_logo` (
  `Id` int(145) NOT NULL,
  `logo` varchar(1145) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_logo`
--

INSERT INTO `system_logo` (`Id`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'fish-favicon.png', '2022-07-08 08:11:27', '2022-10-15 00:44:39');

-- --------------------------------------------------------

--
-- Table structure for table `tb_logs`
--

CREATE TABLE `tb_logs` (
  `activityId` int(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `email` varchar(145) NOT NULL,
  `activity` varchar(145) NOT NULL,
  `date` varchar(145) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_logs`
--

INSERT INTO `tb_logs` (`activityId`, `user`, `email`, `activity`, `date`) VALUES
(1, 'User-fisheryapp092922@gmail.com', 'fisheryapp092922@gmail.com', 'Has successfully signed in', '2022-10-15 11:27:04 AM'),
(2, 'Superadmin-fisheryapp092922@gmail.com', 'fisheryapp092922@gmail.com', 'Has successfully signed in', '2022-10-15 11:27:25 AM'),
(3, 'Superadmin-fisheryapp092922@gmail.com', 'fisheryapp092922@gmail.com', 'Has successfully signed in', '2022-10-15 12:50:00 PM'),
(4, 'Admin-fisheryapp092922@gmail.com', 'fisheryapp092922@gmail.com', 'Has successfully signed in', '2022-10-15 01:01:45 PM'),
(5, 'User-fisheryapp092922@gmail.com', 'fisheryapp092922@gmail.com', 'Has successfully signed in', '2022-10-15 01:01:56 PM'),
(6, 'Superadmin-fisheryapp092922@gmail.com', 'fisheryapp092922@gmail.com', 'Has successfully signed in', '2022-10-15 01:03:06 PM'),
(7, 'Superadmin-fisheryapp092922@gmail.com', 'fisheryapp092922@gmail.com', 'Has successfully signed in', '2022-10-15 01:04:59 PM'),
(8, 'Admin-fisheryapp092922@gmail.com', 'fisheryapp092922@gmail.com', 'Has successfully signed in', '2022-10-15 01:05:38 PM'),
(9, 'User-fisheryapp092922@gmail.com', 'fisheryapp092922@gmail.com', 'Has successfully signed in', '2022-10-15 01:06:28 PM'),
(10, 'Superadmin-fisheryapp092922@gmail.com', 'fisheryapp092922@gmail.com', 'Has successfully signed in', '2022-10-15 01:06:37 PM'),
(11, 'Admin-fisheryapp092922@gmail.com', 'fisheryapp092922@gmail.com', 'Has successfully signed in', '2022-10-15 02:40:10 PM');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(255) NOT NULL,
  `employeeId` varchar(145) DEFAULT NULL,
  `userFirst_Name` varchar(145) DEFAULT NULL,
  `userMiddle_Name` varchar(145) DEFAULT NULL,
  `userLast_Name` varchar(145) DEFAULT NULL,
  `userPhone_Number` varchar(145) DEFAULT NULL,
  `userEmail` varchar(145) DEFAULT NULL,
  `userPassword` varchar(145) DEFAULT NULL,
  `userStatus` enum('Y','N') DEFAULT 'N',
  `tokencode` varchar(145) DEFAULT NULL,
  `userProfile` varchar(1145) NOT NULL DEFAULT 'profile.png',
  `uniqueID` varchar(145) DEFAULT NULL,
  `account_status` enum('active','disabled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `employeeId`, `userFirst_Name`, `userMiddle_Name`, `userLast_Name`, `userPhone_Number`, `userEmail`, `userPassword`, `userStatus`, `tokencode`, `userProfile`, `uniqueID`, `account_status`, `created_at`, `updated_at`) VALUES
(197, '20183473', 'JUAN', 'DATU', 'SANTOS', '9776621929', 'fisheryapp092922@gmail.com', '42f749ade7f9e195bf475f37a44cafcb', 'Y', 'b3c2dc375edf8a69d45bcbeac8f805a5', 'green-profile.png', '68414511', 'active', '2022-07-05 11:39:33', '2022-10-15 03:44:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `email_config`
--
ALTER TABLE `email_config`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `google_recaptcha_api`
--
ALTER TABLE `google_recaptcha_api`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `superadmin`
--
ALTER TABLE `superadmin`
  ADD PRIMARY KEY (`superadminId`);

--
-- Indexes for table `system_config`
--
ALTER TABLE `system_config`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `system_logo`
--
ALTER TABLE `system_logo`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tb_logs`
--
ALTER TABLE `tb_logs`
  ADD PRIMARY KEY (`activityId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `userId` int(145) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `email_config`
--
ALTER TABLE `email_config`
  MODIFY `Id` int(145) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `google_recaptcha_api`
--
ALTER TABLE `google_recaptcha_api`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `superadmin`
--
ALTER TABLE `superadmin`
  MODIFY `superadminId` int(145) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `system_config`
--
ALTER TABLE `system_config`
  MODIFY `Id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_logo`
--
ALTER TABLE `system_logo`
  MODIFY `Id` int(145) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_logs`
--
ALTER TABLE `tb_logs`
  MODIFY `activityId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
