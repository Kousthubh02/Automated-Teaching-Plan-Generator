-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2025 at 12:20 PM
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
-- Table structure for table `reference_table`
--

CREATE TABLE `reference_table` (
  `pk` int NOT NULL,
  `ref_code` varchar(10) DEFAULT NULL,
  `sub_id` int DEFAULT NULL,
  `division` varchar(50) DEFAULT NULL,
  `ref_content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reference_table`
--

INSERT INTO `reference_table` (`pk`, `ref_code`, `sub_id`, `division`, `ref_content`) VALUES
(1, 'R1', 22, 'A', 'kkk'),
(2, 'R2', 22, 'A', NULL),
(3, 'R3', 22, 'A', NULL),
(4, 'R4', 22, 'A', NULL),
(5, 'R5', 22, 'A', NULL),
(6, 'T1', 22, 'A', NULL),
(7, 'T2', 22, 'A', 'kkkkkk'),
(8, 'T3', 22, 'A', NULL),
(9, 'T4', 22, 'A', NULL),
(10, 'T5', 22, 'A', NULL),
(11, 'O1', 22, 'A', NULL),
(12, 'O2', 22, 'A', NULL),
(13, 'O3', 22, 'A', 'kkk'),
(14, 'O4', 22, 'A', NULL),
(15, 'O5', 22, 'A', NULL),
(16, 'R1', 22, 'B', NULL),
(17, 'R2', 22, 'B', NULL),
(18, 'R3', 22, 'B', NULL),
(19, 'R4', 22, 'B', NULL),
(20, 'R5', 22, 'B', 'pppp'),
(21, 'T1', 22, 'B', NULL),
(22, 'T2', 22, 'B', NULL),
(23, 'T3', 22, 'B', NULL),
(24, 'T4', 22, 'B', 'pppp'),
(25, 'T5', 22, 'B', NULL),
(26, 'O1', 22, 'B', NULL),
(27, 'O2', 22, 'B', NULL),
(28, 'O3', 22, 'B', 'ppppp'),
(29, 'O4', 22, 'B', NULL),
(30, 'O5', 22, 'B', NULL);

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
(1, '2025-03-03', '2025-03-31', '{\"06-03-2025\":{\"reason\":\"Republic Day\",\"semester\":\"ALL\"},\"07-03-2025\":{\"reason\":\"Chhatrapati Shivaji Maharaj Jayanti\",\"semester\":\"7\"},\"08-03-2025\":{\"reason\":\"Mahashivratri\",\"semester\":\"2,4,6\"}}', '2025-03-13 11:11:59');

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
  `division` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
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
(1, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-03', 0, 'kk', NULL, 'kk', 'T1, R2, O3', 'Board', 'CO1', NULL, NULL),
(2, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-10', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-17', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-24', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-31', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, NULL, NULL, NULL, 7, 'B', 'ML', '2025-03-05', 0, NULL, NULL, NULL, 'T5, R4, O3', 'PPT', 'CO1', NULL, NULL),
(7, NULL, NULL, NULL, 7, 'B', 'ML', '2025-03-05', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, NULL, NULL, NULL, 7, 'B', 'ML', '2025-03-06', 1, 'Republic Day', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, NULL, NULL, NULL, 7, 'B', 'ML', '2025-03-06', 1, 'Republic Day', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, NULL, NULL, NULL, 7, 'B', 'ML', '2025-03-07', 1, 'Chhatrapati Shivaji Maharaj Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, NULL, NULL, NULL, 7, 'B', 'ML', '2025-03-07', 1, 'Chhatrapati Shivaji Maharaj Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, NULL, NULL, NULL, 7, 'B', 'ML', '2025-03-10', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, NULL, NULL, NULL, 7, 'B', 'ML', '2025-03-17', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, NULL, NULL, NULL, 7, 'B', 'ML', '2025-03-24', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, NULL, NULL, NULL, 7, 'B', 'ML', '2025-03-31', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dept`
--
ALTER TABLE `dept`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `reference_table`
--
ALTER TABLE `reference_table`
  ADD PRIMARY KEY (`pk`),
  ADD UNIQUE KEY `unique_subid_refcode_division` (`sub_id`,`ref_code`,`division`);

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
-- AUTO_INCREMENT for table `reference_table`
--
ALTER TABLE `reference_table`
  MODIFY `pk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subject_table`
--
ALTER TABLE `subject_table`
  MODIFY `sub_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `teaching_dates`
--
ALTER TABLE `teaching_dates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teaching_plan`
--
ALTER TABLE `teaching_plan`
  MODIFY `pk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reference_table`
--
ALTER TABLE `reference_table`
  ADD CONSTRAINT `reference_table_ibfk_1` FOREIGN KEY (`sub_id`) REFERENCES `subject_table` (`sub_id`);

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
