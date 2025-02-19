-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2025 at 05:31 PM
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
-- Table structure for table `reference_table`
--

CREATE TABLE `reference_table` (
  `pk` int NOT NULL,
  `ref_code` text,
  `sub_id` int DEFAULT NULL,
  `ref_content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reference_table`
--

INSERT INTO `reference_table` (`pk`, `ref_code`, `sub_id`, `ref_content`) VALUES
(1, 'R1', 22, ''),
(2, 'R2', 22, ''),
(3, 'R3', 22, ''),
(4, 'R4', 22, 'sadfsadf'),
(5, 'R5', 22, ''),
(6, 'T1', 22, ''),
(7, 'T2', 22, ''),
(8, 'T3', 22, ''),
(9, 'T4', 22, 'sdasdf'),
(10, 'T5', 22, ''),
(11, 'R1', 22, ''),
(12, 'R2', 22, ''),
(13, 'R3', 22, ''),
(14, 'R4', 22, 'sadfsadf'),
(15, 'R5', 22, ''),
(16, 'T1', 22, ''),
(17, 'T2', 22, ''),
(18, 'T3', 22, ''),
(19, 'T4', 22, 'sdasdf'),
(20, 'T5', 22, ''),
(21, 'R1', 22, ''),
(22, 'R2', 22, ''),
(23, 'R3', 22, ''),
(24, 'R4', 22, 'sadfsadf'),
(25, 'R5', 22, ''),
(26, 'T1', 22, ''),
(27, 'T2', 22, ''),
(28, 'T3', 22, ''),
(29, 'T4', 22, 'sdasdf'),
(30, 'T5', 22, ''),
(31, 'R1', 22, ''),
(32, 'R2', 22, ''),
(33, 'R3', 22, ''),
(34, 'R4', 22, 'sadfsadf'),
(35, 'R5', 22, ''),
(36, 'T1', 22, ''),
(37, 'T2', 22, ''),
(38, 'T3', 22, ''),
(39, 'T4', 22, 'sdasdf'),
(40, 'T5', 22, ''),
(41, 'R1', 22, ''),
(42, 'R2', 22, ''),
(43, 'R3', 22, ''),
(44, 'R4', 22, 'sadfsadf'),
(45, 'R5', 22, ''),
(46, 'T1', 22, ''),
(47, 'T2', 22, ''),
(48, 'T3', 22, ''),
(49, 'T4', 22, 'sdasdf'),
(50, 'T5', 22, ''),
(51, 'R1', 22, ''),
(52, 'R2', 22, ''),
(53, 'R3', 22, ''),
(54, 'R4', 22, 'sadfsadf'),
(55, 'R5', 22, ''),
(56, 'T1', 22, ''),
(57, 'T2', 22, ''),
(58, 'T3', 22, ''),
(59, 'T4', 22, 'sdasdf'),
(60, 'T5', 22, ''),
(61, 'R1', 22, ''),
(62, 'R2', 22, ''),
(63, 'R3', 22, ''),
(64, 'R4', 22, 'sadfsadf'),
(65, 'R5', 22, ''),
(66, 'T1', 22, ''),
(67, 'T2', 22, ''),
(68, 'T3', 22, ''),
(69, 'T4', 22, 'sdasdf'),
(70, 'T5', 22, ''),
(71, 'R1', 22, ''),
(72, 'R2', 22, ''),
(73, 'R3', 22, ''),
(74, 'R4', 22, 'sadfsadf'),
(75, 'R5', 22, ''),
(76, 'T1', 22, ''),
(77, 'T2', 22, ''),
(78, 'T3', 22, ''),
(79, 'T4', 22, 'sdasdf'),
(80, 'T5', 22, ''),
(81, 'R1', 22, ''),
(82, 'R2', 22, ''),
(83, 'R3', 22, ''),
(84, 'R4', 22, ''),
(85, 'R5', 22, ''),
(86, 'T1', 22, ''),
(87, 'T2', 22, ''),
(88, 'T3', 22, ''),
(89, 'T4', 22, ''),
(90, 'T5', 22, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reference_table`
--
ALTER TABLE `reference_table`
  ADD PRIMARY KEY (`pk`),
  ADD KEY `sub_id` (`sub_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reference_table`
--
ALTER TABLE `reference_table`
  MODIFY `pk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reference_table`
--
ALTER TABLE `reference_table`
  ADD CONSTRAINT `reference_table_ibfk_1` FOREIGN KEY (`sub_id`) REFERENCES `subject_table` (`sub_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
