-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2025 at 07:25 PM
-- Server version: 8.0.32
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `major_testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `dept`
--

CREATE TABLE `dept` (
  `dept_id` int NOT NULL,
  `dept_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dept`
--

INSERT INTO `dept` (`dept_id`, `dept_name`) VALUES
(1, 'Department of Mechanical Enginnering'),
(2, 'Department of Electrical Engineering'),
(3, 'Department of Electronics and Telecommunications'),
(4, 'Department of Computer Engineering'),
(5, 'Department of Information Technology');

-- --------------------------------------------------------

--
-- Table structure for table `sem`
--

CREATE TABLE `sem` (
  `sem_id` int NOT NULL,
  `sem` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sem`
--

INSERT INTO `sem` (`sem_id`, `sem`) VALUES
(1, 'I'),
(2, 'II'),
(3, 'III'),
(4, 'IV'),
(5, 'V'),
(6, 'VI'),
(7, 'VII'),
(8, 'VIII');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `editable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `editable`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int NOT NULL,
  `staff_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_name`) VALUES
(1, 'abc'),
(2, 'def'),
(3, 'ghi'),
(4, 'jkl'),
(5, 'mno');

-- --------------------------------------------------------

--
-- Table structure for table `subject_table`
--

CREATE TABLE `subject_table` (
  `sub_id` int NOT NULL,
  `sub` varchar(200) DEFAULT NULL,
  `sem_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subject_table`
--

INSERT INTO `subject_table` (`sub_id`, `sub`, `sem_id`) VALUES
(1, 'EM-III', 3),
(2, 'DSGT', 3),
(3, 'DS', 3),
(4, 'DBMS', 3),
(5, 'DLCOA', 3),
(6, 'PYTHON', 3),
(7, 'EM-IV', 4),
(8, 'AOA', 4),
(9, 'OS', 4),
(10, 'CN', 4),
(11, 'MP', 4),
(12, 'EVS', 4),
(13, 'TOC', 5),
(14, 'SE', 5),
(15, 'CN', 5),
(16, 'DWM', 5),
(17, 'BCA', 5),
(18, 'SPCC', 6),
(19, 'CSS', 6),
(20, 'MC', 6),
(21, 'AI', 6),
(22, 'ML', 7),
(23, 'BDA', 7),
(24, 'NLP', 8),
(25, 'DC', 8),
(26, 'ADS', 8),
(27, 'SMA', 8);

-- --------------------------------------------------------

--
-- Table structure for table `teaching_dates`
--

CREATE TABLE `teaching_dates` (
  `id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `exclude_dates` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teaching_dates`
--

INSERT INTO `teaching_dates` (`id`, `start_date`, `end_date`, `exclude_dates`, `created_at`) VALUES
(1, '2025-01-13', '2025-04-25', '{\"13-02-2025\":\"diwali\",\"14-02-2025\":\"dussehra\",\"19-02-2025\":\"holi\",\"26-02-2025\":\"janmashtami\",\"27-02-2025\":\"ram navami\",\"28-02-2025\":\"lohri\",\"14-03-2025\":\"christmas\",\"26-03-2025\":\"new year\",\"10-04-2025\":\"etamax\",\"14-04-2025\":\"etamax\",\"18-04-2025\":\"etamax\",\"22-04-2025\":\"faces\",\"23-04-2025\":\"faces\",\"24-04-2025\":\"faces\"}', '2025-02-02 15:41:19');

-- --------------------------------------------------------

--
-- Table structure for table `teaching_plan`
--

CREATE TABLE `teaching_plan` (
  `pk` int NOT NULL,
  `dept_id` int DEFAULT NULL,
  `staff_id` int DEFAULT NULL,
  `current_year` int DEFAULT NULL,
  `sem_id` int DEFAULT NULL,
  `division` varchar(1) DEFAULT NULL,
  `subject` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `proposed_date` date DEFAULT NULL,
  `isNTD` tinyint(1) DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `actual_date` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `content_not_covered` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `reference` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `methodology` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `co_mapping` varchar(10) DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `Verified_by_hod` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teaching_plan`
--

INSERT INTO `teaching_plan` (`pk`, `dept_id`, `staff_id`, `current_year`, `sem_id`, `division`, `subject`, `proposed_date`, `isNTD`, `content`, `actual_date`, `content_not_covered`, `reference`, `methodology`, `co_mapping`, `remarks`, `Verified_by_hod`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-01-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-01-29', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-02-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-02-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-02-19', 1, 'holi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-02-26', 1, 'janmashtami', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-03-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-03-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-03-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-03-26', 1, 'new year', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-04-02', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-04-09', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-04-16', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-04-23', 1, 'faces', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-01-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-01-29', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-02-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-02-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-02-19', 1, 'holi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-02-26', 1, 'janmashtami', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-03-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-03-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-03-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-03-26', 1, 'new year', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-04-02', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-04-09', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-04-16', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-04-23', 1, 'faces', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-01-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-01-29', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-02-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-02-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-02-19', 1, 'holi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-02-26', 1, 'janmashtami', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-03-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-03-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-03-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-03-26', 1, 'new year', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-04-02', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-04-09', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-04-16', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, NULL, NULL, NULL, NULL, NULL, 'OS', '2025-04-23', 1, 'faces', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dept`
--
ALTER TABLE `dept`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `sem`
--
ALTER TABLE `sem`
  ADD PRIMARY KEY (`sem_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `subject_table`
--
ALTER TABLE `subject_table`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `sem_id` (`sem_id`);

--
-- Indexes for table `teaching_dates`
--
ALTER TABLE `teaching_dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teaching_plan`
--
ALTER TABLE `teaching_plan`
  ADD PRIMARY KEY (`pk`),
  ADD KEY `fk_dept` (`dept_id`),
  ADD KEY `fk_staff` (`staff_id`),
  ADD KEY `fk_sem` (`sem_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subject_table`
--
ALTER TABLE `subject_table`
  MODIFY `sub_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `teaching_dates`
--
ALTER TABLE `teaching_dates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teaching_plan`
--
ALTER TABLE `teaching_plan`
  MODIFY `pk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subject_table`
--
ALTER TABLE `subject_table`
  ADD CONSTRAINT `subject_table_ibfk_1` FOREIGN KEY (`sem_id`) REFERENCES `sem` (`sem_id`);

--
-- Constraints for table `teaching_plan`
--
ALTER TABLE `teaching_plan`
  ADD CONSTRAINT `fk_dept` FOREIGN KEY (`dept_id`) REFERENCES `dept` (`dept_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sem` FOREIGN KEY (`sem_id`) REFERENCES `sem` (`sem_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
