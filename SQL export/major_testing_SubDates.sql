-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2025 at 03:03 PM
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
-- Database: `major_testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `dept`
--

CREATE TABLE `dept` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `pk` int(11) NOT NULL,
  `ref_code` varchar(10) DEFAULT NULL,
  `sub_id` int(11) DEFAULT NULL,
  `division` varchar(50) DEFAULT NULL,
  `ref_content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reference_table`
--

INSERT INTO `reference_table` (`pk`, `ref_code`, `sub_id`, `division`, `ref_content`) VALUES
(81, 'R1', 22, 'B', 'Han Kamber. —Data Mining Concepts and Techniquest. Morgan Kaufmann Publishers'),
(82, 'R2', 22, 'B', 'Margaret. H. Dunham, —Data Mining Introductory and Advanced Topics\r\nPearson Education'),
(83, 'R3', 22, 'B', ''),
(84, 'R4', 22, 'B', ''),
(85, 'R5', 22, 'B', ''),
(86, 'T1', 22, 'B', 'Peter Harrington. —Machine Learning in Action!. Dream Tech Press'),
(87, 'T2', 22, 'B', 'Ethem Alpaydin. —Introduction to Machine Learningi. MIT Press'),
(88, 'T3', 22, 'B', 'Tom M.Mitchell -Machine\r\nLearning! McGraw Hill'),
(89, 'T4', 22, 'B', ''),
(90, 'T5', 22, 'B', ''),
(211, 'O1', 22, 'B', 'https://towardsdatascience.com'),
(212, 'O2', 22, 'B', 'https://medium.com'),
(213, 'O3', 22, 'B', 'https://machinelearningmastery.com/start-here'),
(214, 'O4', 22, 'B', ''),
(215, 'O5', 22, 'B', ''),
(216, 'R1', 22, 'A', NULL),
(217, 'R2', 22, 'A', 'dfhhg'),
(218, 'R3', 22, 'A', NULL),
(219, 'R4', 22, 'A', NULL),
(220, 'R5', 22, 'A', NULL),
(221, 'T1', 22, 'A', NULL),
(222, 'T2', 22, 'A', 'tgh'),
(223, 'T3', 22, 'A', 'tdgh'),
(224, 'T4', 22, 'A', NULL),
(225, 'T5', 22, 'A', NULL),
(226, 'O1', 22, 'A', NULL),
(227, 'O2', 22, 'A', NULL),
(228, 'O3', 22, 'A', NULL),
(229, 'O4', 22, 'A', 'tghd'),
(230, 'O5', 22, 'A', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sem`
--

CREATE TABLE `sem` (
  `sem_id` int(11) NOT NULL,
  `sem` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id` int(11) NOT NULL,
  `editable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `sub_id` int(11) NOT NULL,
  `sub` varchar(200) DEFAULT NULL,
  `sem_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `exclude_dates` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `pk` int(11) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `current_year` int(11) DEFAULT NULL,
  `sem_id` int(11) DEFAULT NULL,
  `division` text DEFAULT NULL,
  `subject` varchar(10) DEFAULT NULL,
  `proposed_date` date DEFAULT NULL,
  `isNTD` tinyint(1) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `actual_date` text DEFAULT NULL,
  `content_not_covered` text DEFAULT NULL,
  `reference` text DEFAULT NULL,
  `methodology` text DEFAULT NULL,
  `co_mapping` varchar(10) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `Verified_by_hod` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teaching_plan`
--

INSERT INTO `teaching_plan` (`pk`, `dept_id`, `staff_id`, `current_year`, `sem_id`, `division`, `subject`, `proposed_date`, `isNTD`, `content`, `actual_date`, `content_not_covered`, `reference`, `methodology`, `co_mapping`, `remarks`, `Verified_by_hod`) VALUES
(48, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-07-15', 0, 'Teaching objective and learning outcome of Ml. Subjeet. CO. PO and PSO mapping', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO1', NULL, NULL),
(49, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-07-16', 0, 'Module\r\n1:Introduction\r\nto Machine Learning\r\nMachine Learning. types of ML', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO1', NULL, NULL),
(50, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-07-16', 0, 'Issues in Machine learning .Application of Machine Learning', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO1', NULL, NULL),
(51, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-07-18', 0, 'Steps in developing a Vachine Learning Appliention', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO1', NULL, NULL),
(52, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-07-19', 0, 'Training Error. Generalization error.\r\nOverfiting, under fiting. Bias-Variance trade-off.', NULL, '', 'T1, T2, R1, R2, O1, O2, O3', 'Board, PPT', 'CO3', NULL, NULL),
(53, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-07-22', 0, 'Module 2: Learning with\r\nRegression and trees: Lcurning with Regression:Introduction', NULL, '', 'T1, T2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(54, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-07-23', 0, 'Linear Regression-Problem Soling\r\n& Evaluation', NULL, '', 'T1, T2, R1, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(55, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-07-25', 0, 'Logistic Regression- Introdaction &\r\nConcept', NULL, '', 'T1, T2, R1, R2', 'Board, PPT', 'CO2', NULL, NULL),
(56, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-07-29', 0, 'Logistic Regression- Derivation and\r\nivaluation Method', NULL, '', 'T1, T2, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(57, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-07-30', 0, 'Learning with Trees: Decision Frees and Gini Index Concept', NULL, '', 'T1, T2, T3, R1, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(58, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-08-01', 1, 'Goa IV', NULL, '', '', '', '', NULL, NULL),
(59, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-08-05', 0, 'Constructing Decision Irees using\r\nGini Index -Problems', NULL, '', 'T1, T2, T3, R1, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(60, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-08-06', 0, 'Classification and Regression frees\r\n(CART).', NULL, '', 'T1, T2, T3, R1, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(61, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-08-08', 0, 'Performance Metries: Confusion\r\nMatrix. [Kappa Statisties|.\r\nSensitivity. Specificity. Precision.\r\nRecall. I-measure. ROC Curve', NULL, '', 'T4, O1, O2, O3', 'Board, PPT', 'CO3', NULL, NULL),
(62, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-08-12', 0, 'Module +: Learning with\r\nClassification: Constrained\r\nOplimization. Optimal decision\r\nboundary, margins and support vectors', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(63, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-08-13', 0, 'SVM as constrained Optimization\r\nProbiem-I', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(64, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-08-15', 1, 'Independence Day / Parsi New Year', NULL, '', '', '', '', NULL, NULL),
(65, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-08-19', 0, 'Assignment Test 1', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(66, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-08-20', 0, 'Quadrutic Programming', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(67, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-08-22', 1, 'Faces', NULL, '', '', '', '', NULL, NULL),
(68, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-08-26', 1, 'Gopalkala', NULL, '', '', '', '', NULL, NULL),
(69, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-08-27', 0, 'SVM for linear and nonlinear\r\nclassilication', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(70, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-08-29', 0, 'Basies of Kernel trick.', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(71, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-09-02', 1, 'Internal Assessment-1', NULL, '', '', '', '', NULL, NULL),
(72, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-09-03', 1, 'Internal Assessment-1', NULL, '', '', '', '', NULL, NULL),
(73, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-09-05', 0, 'Case Study: Identiting and analyzing Classification base Ml. Models\r\n(Innovative Teaching)', NULL, '', 'O1, O2, O3', 'Board, PPT', '', NULL, NULL),
(74, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-09-09', 1, 'Ganesh Chaturthi', NULL, '', '', '', '', NULL, NULL),
(75, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-09-10', 1, 'Ganesh Chaturthi', NULL, '', '', '', '', NULL, NULL),
(76, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-09-12', 0, 'Module 5: Learning with clustering.\r\nIntroduction to clustering with\r\noverview of distance metrics and\r\nmajor clustering approaches.', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(77, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-09-16', 1, '16-E-Milad', NULL, '', 'T2, R2', '', '', NULL, NULL),
(78, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-09-17', 0, 'Graph Based Clustering: Clustering with minimal spanning tree - Part I', NULL, '', 'T2, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(79, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-09-19', 0, 'Graph Based Clustering: Clustering with minimal spanning tree -Pan 11', NULL, '', 'T2, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(80, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-09-23', 0, 'Model hased Clustering: Expectation\r\nMaximization Algorithm', NULL, '', 'T2, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(81, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-09-24', 0, 'Density Based Clustering: DBSCAN', NULL, '', 'T2, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(82, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-09-26', 0, 'Density Based Clustering: DBSCAN', NULL, '', 'T2, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(83, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-09-30', 0, 'Module3: Ensemble Learning\r\nUnderstanding Ensembles. K-lold\r\ncross validation', NULL, '', 'T2, T4, O1, O2, O3', 'Board, PPT', 'CO4', NULL, NULL),
(84, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-10-01', 0, 'Boosting. Stumping. XGBoost', NULL, '', 'T2, T4, O1, O2, O3', 'Board, PPT', 'CO4', NULL, NULL),
(85, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-10-03', 0, 'Bagging. Subagging. Random Forest', NULL, '', 'T2, T4, O1, O2, O3', 'Board, PPT', 'CO4', NULL, NULL),
(86, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-10-07', 0, 'Comparison with Boosting. Different ways to combine classifier', NULL, '', 'T2, T4, O1, O2, O3', 'Board, PPT', 'CO4', NULL, NULL),
(87, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-10-08', 0, 'Module 6: Dimension Reduction\r\nDimensionality Reduction Techniques', NULL, '', 'T1, T4, O1, O2, O3', 'Board, PPT', 'CO5', NULL, NULL),
(88, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-10-10', 0, 'Assignment Test 2', NULL, '', 'O1, O2, O3', 'Board, PPT', '', NULL, NULL),
(89, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-10-14', 0, 'Principal T4 Component Analysis', NULL, '', 'T1, T2, O1, O2, O3', 'Board, PPT', 'CO5', NULL, NULL),
(90, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-10-15', 0, 'PCA-Problem Solving', NULL, '', 'T1, T2, O1, O2, O3', 'Board, PPT', 'CO5', NULL, NULL),
(91, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-10-17', 0, 'Linear Discriminant Analysis.', NULL, '', 'T1, T2, O1, O2, O3', 'Board, PPT', 'CO5', NULL, NULL),
(92, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-10-21', 1, 'Internal Assessment-2', NULL, '', '', '', '', NULL, NULL),
(93, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-10-22', 0, 'Singular Valued Decomposition', NULL, '', 'T1, T2, O1, O2, O3', 'Board, PPT', 'CO5', NULL, NULL),
(94, NULL, NULL, NULL, NULL, 'B', 'ML', '2024-10-24', 0, 'Revision', NULL, '', 'T1, T2, O1, O2, O3', 'Board, PPT', 'CO5', NULL, NULL),
(95, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-07-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-07-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-07-29', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-08-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-08-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-08-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-08-26', 1, 'Gopalkala', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(102, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-09-02', 1, 'Internal Assessment-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-09-09', 1, 'Ganesh Chaturthi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-09-16', 1, '16-E-Milad', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-09-23', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-09-30', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-10-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-10-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-10-21', 1, 'Internal Assessment-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-07-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-07-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-07-29', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-08-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-08-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-08-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-08-26', 1, 'Gopalkala', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-09-02', 1, 'Internal Assessment-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-09-09', 1, 'Ganesh Chaturthi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-09-16', 1, '16-E-Milad', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-09-23', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-09-30', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-10-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-10-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, NULL, NULL, NULL, NULL, 'B', 'EM-III', '2024-10-21', 1, 'Internal Assessment-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-07-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-07-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-07-16', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-07-18', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-07-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-07-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-07-23', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-07-26', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(133, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-07-29', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(134, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-07-30', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(135, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-08-02', 1, 'Goa IV', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(136, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-08-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(137, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-08-06', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(138, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-08-09', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(139, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-08-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(140, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-08-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(141, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-08-16', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(142, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-08-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(143, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-08-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(144, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-08-23', 1, 'Faces', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(145, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-08-26', 1, 'Gopalkala', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(146, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-08-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(147, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-08-30', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(148, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-09-02', 1, 'Internal Assessment-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(149, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-09-03', 1, 'Internal Assessment-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(150, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-09-06', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(151, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-09-09', 1, 'Ganesh Chaturthi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(152, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-09-10', 1, 'Ganesh Chaturthi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(153, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-09-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(154, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-09-16', 1, '16-E-Milad', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(155, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-09-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(156, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-09-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(157, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-09-23', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(158, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-09-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(159, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-09-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(160, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-09-30', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(161, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-10-01', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(162, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-10-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(163, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-10-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(164, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-10-08', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(165, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-10-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(166, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-10-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(167, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-10-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(168, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-10-18', 1, 'Internal Assessment-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(169, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-10-21', 1, 'Internal Assessment-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(170, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-10-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(171, NULL, NULL, NULL, NULL, 'B', 'BDA', '2024-10-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(172, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(173, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(174, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-01-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(175, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-01-16', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(176, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-01-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(177, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-01-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(178, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-01-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(179, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-01-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(180, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-01-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(181, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-01-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(182, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-01-31', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(183, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-02-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(184, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-02-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(185, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-02-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(186, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-02-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(187, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-02-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(188, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-02-14', 1, 'etamax', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(189, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-02-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(190, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-02-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(191, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-02-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(192, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-02-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(193, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-02-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(194, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-02-28', 1, 'IA 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(195, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(196, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(197, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(198, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(199, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(200, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-14', 1, 'Holi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(201, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(202, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(203, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(204, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(205, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(206, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-28', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(207, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-31', 1, 'EID', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(208, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-03-31', 1, 'EID', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(209, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-04-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(210, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-04-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-04-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(212, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-04-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(213, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-04-14', 1, 'Ambedkar Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(214, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-04-14', 1, 'Ambedkar Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(215, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-04-18', 1, 'Good Friday', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(216, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-04-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(217, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-04-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(218, NULL, NULL, NULL, NULL, 'B', 'SMA', '2025-04-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(219, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(220, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(221, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-01-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(222, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-01-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(223, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-01-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(224, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-01-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(225, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-01-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(226, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-01-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(227, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-01-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(228, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-01-28', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(229, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-01-31', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(230, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-02-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(231, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-02-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(232, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-02-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(233, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-02-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(234, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-02-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(235, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-02-14', 1, 'etamax', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(236, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-02-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(237, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-02-18', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(238, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-02-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(239, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-02-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(240, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-02-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(241, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-02-28', 1, 'IA 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(242, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-03-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(243, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-03-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(244, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-03-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(245, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-03-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(246, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-03-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(247, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-03-14', 1, 'Holi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(248, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-03-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(249, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-03-18', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(250, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-03-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(251, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-03-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(252, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-03-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(253, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-03-28', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(254, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-03-31', 1, 'EID', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(255, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-04-01', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(256, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-04-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(257, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-04-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(258, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-04-08', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(259, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-04-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(260, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-04-14', 1, 'Ambedkar Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(261, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-04-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(262, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-04-18', 1, 'Good Friday', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(263, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-04-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(264, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-04-22', 1, 'IA 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(265, NULL, NULL, NULL, NULL, 'B', 'DC', '2025-04-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(266, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(267, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(268, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-01-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(269, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-01-16', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(270, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-01-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(271, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-01-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(272, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-01-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(273, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-01-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(274, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-01-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(275, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-01-28', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(276, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-01-31', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(277, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-02-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(278, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-02-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(279, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-02-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(280, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-02-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(281, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-02-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(282, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-02-14', 1, 'etamax', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(283, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-02-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(284, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-02-18', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(285, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-02-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(286, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-02-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(287, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-02-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(288, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-02-28', 1, 'IA 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(289, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-03-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(290, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-03-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(291, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-03-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(292, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-03-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(293, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-03-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(294, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-03-14', 1, 'Holi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(295, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-03-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(296, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-03-18', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(297, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-03-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(298, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-03-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(299, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-03-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(300, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-03-28', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(301, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-03-31', 1, 'EID', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(302, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-04-01', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(303, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-04-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(304, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-04-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(305, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-04-08', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(306, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-04-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(307, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-04-14', 1, 'Ambedkar Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(308, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-04-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(309, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-04-18', 1, 'Good Friday', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(310, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-04-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(311, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-04-22', 1, 'IA 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(312, NULL, NULL, NULL, NULL, 'B', 'ADS', '2025-04-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(313, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-05', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(314, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-06', 1, 'Republic Day', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(315, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-07', 1, 'Chhatrapati Shivaji Maharaj Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(316, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-10', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(317, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-10', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(318, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-17', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(319, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-17', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(320, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-24', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(321, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-24', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-31', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(323, NULL, NULL, NULL, 7, 'A', 'ML', '2025-03-31', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  MODIFY `pk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subject_table`
--
ALTER TABLE `subject_table`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `teaching_dates`
--
ALTER TABLE `teaching_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teaching_plan`
--
ALTER TABLE `teaching_plan`
  MODIFY `pk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=324;

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
