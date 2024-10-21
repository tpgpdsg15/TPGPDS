-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2020 at 07:00 AM
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
-- Database: `db_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` int(11) NOT NULL COMMENT 'role_id',
  `role` varchar(255) DEFAULT NULL COMMENT 'role_text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Editor'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `roleid` tinyint(4) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `username`, `email`, `password`, `mobile`, `roleid`, `isActive`, `created_at`, `updated_at`) VALUES

(21, 'Admin ', 'Admin', 'admin@gmail.com', '$2y$10$pYB9aKGA9susUsSWcdd5A.2Fu3pCSJaTTXhEkIIdhFB6GtVoZw3r2', '01145678912', 1, 0, '2024-10-21 00:11:02', '2020-03-13 00:11:02'),
(22, 'Pablo ', 'Pablo', 'pablo@gmail.com', '$2y$10$pYB9aKGA9susUsSWcdd5A.2Fu3pCSJaTTXhEkIIdhFB6GtVoZw3r2', '01145678912', 1, 0, '2024-10-21 00:13:25', '2020-03-13 00:13:25'),
(23, 'Diego ', 'Diego', 'diego@gmail.com', '$2y$10$pYB9aKGA9susUsSWcdd5A.2Fu3pCSJaTTXhEkIIdhFB6GtVoZw3r2', '01145678912', 1, 1, '2024-10-21 00:15:51', '2020-03-13 00:15:51'),
(24, 'Ariel ', 'Ariel', 'ariel@gmail.com', '$2y$10$pYB9aKGA9susUsSWcdd5A.2Fu3pCSJaTTXhEkIIdhFB6GtVoZw3r2', '01145678912', 3, 0, '2024-10-21 00:18:33', '2020-03-13 00:18:33');
--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'role_id', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
