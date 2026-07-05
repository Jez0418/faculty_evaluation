-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2026 at 04:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faculty_evaluation_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE `evaluations` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `knowledge` tinyint(4) NOT NULL,
  `communication` tinyint(4) NOT NULL,
  `professionalism` tinyint(4) NOT NULL,
  `punctuality` tinyint(4) NOT NULL,
  `teaching` tinyint(4) NOT NULL,
  `overall_rating` decimal(3,2) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `sentiment` varchar(20) DEFAULT 'Pending',
  `confidence` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluations`
--

INSERT INTO `evaluations` (`id`, `faculty_id`, `student_name`, `knowledge`, `communication`, `professionalism`, `punctuality`, `teaching`, `overall_rating`, `comment`, `sentiment`, `confidence`, `created_at`) VALUES
(1, 1, 'rodjean', 5, 5, 5, 5, 5, 5.00, 'well done', 'Pending', 0.00, '2026-06-28 13:27:22'),
(2, 1, 'rodjean', 5, 5, 5, 5, 5, 5.00, 'well done', 'Neutral', 50.00, '2026-06-28 13:39:43'),
(3, 1, 'rod', 2, 3, 3, 3, 4, 3.00, 'the teacher is good', 'Positive', 100.00, '2026-06-28 13:40:29'),
(4, 1, 'rod', 2, 3, 3, 3, 4, 3.00, 'the teacher is good', 'Positive', 100.00, '2026-06-28 13:43:33'),
(5, 1, 'rod', 2, 3, 3, 3, 4, 3.00, 'the teacher is good', 'Positive', 100.00, '2026-06-28 13:43:37'),
(6, 1, 'rodjean', 4, 5, 5, 3, 4, 4.20, 'the teach is bad', 'Negative', 100.00, '2026-06-28 13:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `faculty_code` varchar(20) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `faculty_code`, `fullname`, `department`, `email`, `status`, `created_at`) VALUES
(1, '001', 'Frank Johndelf Mangulad', 'CITE', 'frankmangulad@gmail.com', 'Active', '2026-06-28 13:10:10'),
(3, '002', 'testing bot', 'CITE', 'bot@gmail.com', 'Active', '2026-06-28 13:45:44');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_no` varchar(20) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `year_level` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','student') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'System Administrator', 'admin', '$2y$10$k5wOVPL/5U.jpjLMIGFyL.GHloso90.HpJuw63dvpJh9y/XG.mNtS', 'admin', '2026-06-28 12:48:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faculty_code` (`faculty_code`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_no` (`student_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `evaluations_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
