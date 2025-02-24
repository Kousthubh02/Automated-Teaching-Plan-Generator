-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 05:52 PM
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
  `ref_content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reference_table`
--

INSERT INTO `reference_table` (`pk`, `ref_code`, `sub_id`, `ref_content`) VALUES
(81, 'R1', 22, 'ab'),
(82, 'R2', 22, 'cfsdfasdfasdfsd'),
(83, 'R3', 22, 'fasfsda'),
(84, 'R4', 22, 'sfsdfsdfsfsddsfsdf'),
(85, 'R5', 22, 'sd'),
(86, 'T1', 22, 'bsdfas'),
(87, 'T2', 22, 'dfsdfsdafasdfsdf'),
(88, 'T3', 22, 'fs'),
(89, 'T4', 22, 'sfsdfsd'),
(90, 'T5', 22, 'sdfsdf'),
(211, 'O1', 22, 'www.deepseek.com'),
(212, 'O2', 22, 'www.chatgpt.com'),
(213, 'O3', 22, ''),
(214, 'O4', 22, ''),
(215, 'O5', 22, '');

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
(27, 'SMA', 8),
(28, 'ADS', 8);

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
(2, '2024-07-15', '2024-10-25', '{\"26-01-2024\":\"Republic Day\",\"19-02-2024\":\"Chhatrapati Shivaji Maharaj Jayanti\",\"08-03-2024\":\"Mahashivratri\",\"25-03-2024\":\"Holi (Second Day)\",\"29-03-2024\":\"Good Friday\",\"09-04-2024\":\"Gudi Padwa\",\"11-04-2024\":\"Ramzan-Id (Eid-ul-Fitr)\",\"17-04-2024\":\"Ram Navami\",\"01-05-2024\":\"Maharashtra Day\",\"23-05-2024\":\"Buddha Pournima\",\"17-06-2024\":\"Bakri Eid (Eid-ul-Adha)\",\"17-08-2024\":\"Moharrum\",\"15-08-2024\":\"Independence Day \\/ Parsi New Year\",\"21-08-2024\":\"Faces\",\"22-08-2024\":\"Faces\",\"23-08-2024\":\"Faces\",\"26-08-2024\":\"Gopalkala\",\"07-09-2024\":\"Ganesh Chaturthi\",\"09-09-2024\":\"Ganesh Chaturthi\",\"10-09-2024\":\"Ganesh Chaturthi\",\"11-09-2024\":\"Ganesh Chaturthi\",\"16-09-2024\":\"16-E-Milad\",\"02-10-2024\":\"Mahatma Gandhi Jayanti\",\"02-09-2024\":\"Internal Assessment-1\",\"03-09-2024\":\"Internal Assessment-1\",\"01-08-2024\":\"Goa IV\",\"02-08-2024\":\"Goa IV\",\"03-08-2024\":\"Goa IV\",\"04-08-2024\":\"Goa IV\",\"21-10-2024\":\"Internal Assessment-2\",\"31-10-2024\":\"Diwali (Kali Chaudas) \\/ 1st Day of Diwali\",\"01-11-2024\":\"Diwali (Laxmi Pujan)\",\"02-11-2024\":\"Diwali (Bali Pratipada)\",\"15-11-2024\":\"Guru Nanak Jayanti\",\"24-12-2024\":\"Christmas Eve\",\"25-12-2024\":\"Christmas\",\"14-04-2024\":\"Dr. Babasaheb Ambedkar Jayanti\",\"21-04-2024\":\"Mahavir Janmakalyanak\",\"12-10-2024\":\"Dasara\",\"03-11-2024\":\"Diwali (Bhaiduj)\"}', '2025-02-06 08:29:05');

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
(48, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-07-15', 0, 'htftf', NULL, 'y', 'T1, T2, T3, T5, R3, R4, O4, O5', 'Board', 'CO1', NULL, NULL),
(49, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-07-16', 0, '', NULL, '', '', 'Board, PPT', 'CO2', NULL, NULL),
(50, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-07-16', 0, '', NULL, '', '', '', '', NULL, NULL),
(51, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-07-18', 0, '', NULL, '', '', '', '', NULL, NULL),
(52, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-07-19', 0, '', NULL, '', '', '', '', NULL, NULL),
(53, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-07-22', 0, '', NULL, '', '', '', '', NULL, NULL),
(54, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-07-23', 0, '', NULL, '', '', '', '', NULL, NULL),
(55, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-07-25', 0, '', NULL, '', '', '', '', NULL, NULL),
(56, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-07-29', 0, '', NULL, '', '', '', '', NULL, NULL),
(57, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-07-30', 0, '', NULL, '', '', '', '', NULL, NULL),
(58, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-08-01', 1, 'Goa IV', NULL, '', '', '', '', NULL, NULL),
(59, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-08-05', 0, '', NULL, '', '', '', '', NULL, NULL),
(60, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-08-06', 0, '', NULL, '', '', '', '', NULL, NULL),
(61, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-08-08', 0, '', NULL, '', '', '', '', NULL, NULL),
(62, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-08-12', 0, '', NULL, '', '', '', '', NULL, NULL),
(63, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-08-13', 0, '', NULL, '', '', '', '', NULL, NULL),
(64, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-08-15', 1, 'Independence Day / Parsi New Year', NULL, '', '', '', '', NULL, NULL),
(65, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-08-19', 0, '', NULL, '', '', '', '', NULL, NULL),
(66, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-08-20', 0, '', NULL, '', '', '', '', NULL, NULL),
(67, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-08-22', 1, 'Faces', NULL, '', '', '', '', NULL, NULL),
(68, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-08-26', 1, 'Gopalkala', NULL, '', '', '', '', NULL, NULL),
(69, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-08-27', 0, '', NULL, '', '', '', '', NULL, NULL),
(70, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-08-29', 0, '', NULL, '', '', '', '', NULL, NULL),
(71, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-09-02', 1, 'Internal Assessment-1', NULL, '', '', '', '', NULL, NULL),
(72, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-09-03', 1, 'Internal Assessment-1', NULL, '', '', '', '', NULL, NULL),
(73, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-09-05', 0, '', NULL, '', '', '', '', NULL, NULL),
(74, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-09-09', 1, 'Ganesh Chaturthi', NULL, '', '', '', '', NULL, NULL),
(75, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-09-10', 1, 'Ganesh Chaturthi', NULL, '', '', '', '', NULL, NULL),
(76, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-09-12', 0, '', NULL, '', '', '', '', NULL, NULL),
(77, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-09-16', 1, '16-E-Milad', NULL, '', '', '', '', NULL, NULL),
(78, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-09-17', 0, '', NULL, '', '', '', '', NULL, NULL),
(79, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-09-19', 0, '', NULL, '', '', '', '', NULL, NULL),
(80, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-09-23', 0, '', NULL, '', '', '', '', NULL, NULL),
(81, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-09-24', 0, '', NULL, '', '', '', '', NULL, NULL),
(82, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-09-26', 0, '', NULL, '', '', '', '', NULL, NULL),
(83, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-09-30', 0, '', NULL, '', '', '', '', NULL, NULL),
(84, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-10-01', 0, '', NULL, '', '', '', '', NULL, NULL),
(85, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-10-03', 0, '', NULL, '', '', '', '', NULL, NULL),
(86, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-10-07', 0, '', NULL, '', '', '', '', NULL, NULL),
(87, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-10-08', 0, '', NULL, '', 'T1, R1, R2', '', '', NULL, NULL),
(88, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-10-10', 0, '', NULL, '', '', '', '', NULL, NULL),
(89, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-10-14', 0, '', NULL, '', '', '', '', NULL, NULL),
(90, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-10-15', 0, '', NULL, '', '', '', '', NULL, NULL),
(91, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-10-17', 0, '', NULL, 'sadfs', '', '', '', NULL, NULL),
(92, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-10-21', 1, 'Internal Assessment-2', NULL, '', '', '', '', NULL, NULL),
(93, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-10-22', 0, 'dasd', NULL, 'asdas', '', '', '', NULL, NULL),
(94, NULL, NULL, NULL, NULL, NULL, 'ML', '2024-10-24', 0, 'sdff', NULL, 'dff', '', '', '', NULL, NULL),
(95, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-07-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-07-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-07-29', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-08-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-08-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-08-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-08-26', 1, 'Gopalkala', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(102, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-09-02', 1, 'Internal Assessment-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-09-09', 1, 'Ganesh Chaturthi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-09-16', 1, '16-E-Milad', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-09-23', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-09-30', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-10-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-10-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-10-21', 1, 'Internal Assessment-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-07-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-07-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-07-29', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-08-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-08-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-08-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-08-26', 1, 'Gopalkala', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-09-02', 1, 'Internal Assessment-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-09-09', 1, 'Ganesh Chaturthi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-09-16', 1, '16-E-Milad', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-09-23', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-09-30', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-10-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-10-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, NULL, NULL, NULL, NULL, NULL, 'EM-III', '2024-10-21', 1, 'Internal Assessment-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  ADD UNIQUE KEY `unique_subid_refcode` (`sub_id`,`ref_code`);

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
  MODIFY `pk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=396;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teaching_plan`
--
ALTER TABLE `teaching_plan`
  MODIFY `pk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

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
