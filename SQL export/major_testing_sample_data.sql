-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 10:30 PM
-- Server version: 8.0.41
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
  `dept_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
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
-- Table structure for table `missing_content_table`
--

CREATE TABLE `missing_content_table` (
  `pk` int NOT NULL,
  `dept_id` int DEFAULT NULL,
  `staff_id` int DEFAULT NULL,
  `current_year` int DEFAULT NULL,
  `sem_id` int DEFAULT NULL,
  `division` text,
  `subject` varchar(10) DEFAULT NULL,
  `missingcontent` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `missing_content_table`
--

INSERT INTO `missing_content_table` (`pk`, `dept_id`, `staff_id`, `current_year`, `sem_id`, `division`, `subject`, `missingcontent`) VALUES
(1, NULL, NULL, NULL, 8, 'B', 'ADS', '');

-- --------------------------------------------------------

--
-- Table structure for table `reference_table`
--

CREATE TABLE `reference_table` (
  `pk` int NOT NULL,
  `ref_code` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sub_id` int DEFAULT NULL,
  `division` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ref_content` text COLLATE utf8mb4_general_ci
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
(231, 'R1', 26, 'B', 'Jake VanderPlas. ―Python \r\nData Science Handbookǁ, \r\nO‘reilly Publications.'),
(232, 'R2', 26, 'B', 'Francesco Ricci, LiorRokach, \r\nBrachaShapira, Paul B. \r\nKantor, ―Recommender \r\nSystems Handbookǁ, \r\nSpringer.'),
(233, 'R3', 26, 'B', 'S.C. Gupta, V. K. Kapoor ―Fundamentals of \r\nMathematical Statisticsǁ, S. \r\nChand and Sons, New Delhi.'),
(234, 'R4', 26, 'B', 'B. L. Agrawal. ―Basic \r\nStatisticsǁ, New Age \r\nPublications, Delhi.'),
(235, 'R5', 26, 'B', NULL),
(236, 'T1', 26, 'B', 'Vijay Kotu, Bala Deshpande. ―Data Science Concepts \r\nand Practiceǁ, Elsevier, M.K. \r\nPublishers.'),
(237, 'T2', 26, 'B', 'Steven Skiena, ―Data \r\nScience Design Manualǁ, \r\nSpringer International \r\nPublishing AG'),
(238, 'T3', 26, 'B', 'Samir Madhavan. ―Mastering Python for \r\nData Scienceǁ, PACKT \r\nPublishing'),
(239, 'T4', 26, 'B', 'Dr. P. N. Arora, Sumeet Arora, \r\nS. Arora, Ameet Arora, ―Comprehensive Statistical \r\nMethodsǁ, S.Chand \r\nPublications, New Delhi.'),
(240, 'T5', 26, 'B', NULL),
(241, 'O1', 26, 'B', 'Analyticvidhya.com/Data \r\nscience'),
(242, 'O2', 26, 'B', 'Coursera.org/Statistics'),
(243, 'O3', 26, 'B', 'SWAYAM Courses'),
(244, 'O4', 26, 'B', 'Probability & Statistics \r\nTVK Iyengar, Krishnan \r\nGandhi'),
(245, 'O5', 26, 'B', NULL),
(246, 'R1', 27, 'B', 'Social Media Analy cs [2015], \r\nTechniques and Insights for Extrac ng \r\nBusiness Value Out of Social Media, \r\nMa hew Ganis, AvinashKohirkar, IBM \r\nPress'),
(247, 'R2', 27, 'B', 'Social Media Analy cs Strategy_ Using Data \r\nto Opmize Business Performance, Alex \r\nGonçalves, APress Business Team'),
(248, 'R3', 27, 'B', 'Social Media Data Mining and \r\nAnaly cs, Szabo, G., G. Polatkan, O. Boykin \r\n& A. Chalkiopoulus (2019), Wiley, ISBN \r\n978-1-118-82485-6'),
(249, 'R4', 27, 'B', NULL),
(250, 'R5', 27, 'B', NULL),
(251, 'T1', 27, 'B', '. Seven Layers of Social Media \r\nAnaly cs_ Mining Business Insights from \r\nSocial Media Text, Ac ons, Networks, \r\nHyperlinks, Apps, Search Engine, and \r\nLoca on Data, Gohar F. Khan'),
(252, 'T2', 27, 'B', 'Analyzing the Social Web 1st Edi on by \r\nJennifer Golbeck'),
(253, 'T3', 27, 'B', 'Mining the Social Web_ Analyzing \r\nData from Facebook, Twi er, LinkedIn, and \r\nOther Social Media Sites, Ma hew A \r\nRussell, O‘Reilly'),
(254, 'T4', 27, 'B', NULL),
(255, 'T5', 27, 'B', NULL),
(256, 'O1', 27, 'B', 'https://nptel.ac.in/noc21_cs28'),
(257, 'O2', 27, 'B', 'https://nptel.ac.in/noc22_cs117'),
(258, 'O3', 27, 'B', NULL),
(259, 'O4', 27, 'B', NULL),
(260, 'O5', 27, 'B', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sem`
--

CREATE TABLE `sem` (
  `sem_id` int NOT NULL,
  `sem` varchar(4) COLLATE utf8mb4_general_ci DEFAULT NULL
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
  `id` int NOT NULL,
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
  `staff_id` int NOT NULL,
  `staff_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
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
  `sub_id` int NOT NULL,
  `sub` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sem_id` int DEFAULT NULL
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
(24, 'NLP', 7),
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
  `exclude_dates` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teaching_dates`
--

INSERT INTO `teaching_dates` (`id`, `start_date`, `end_date`, `exclude_dates`, `created_at`) VALUES
(1, '2025-01-13', '2025-04-25', '{\"26-01-2025\":{\"reason\":\"Republic Day\",\"semester\":\"ALL\"},\"13-02-2025\":{\"reason\":\"etamax\",\"semester\":\"ALL\"},\"14-02-2025\":{\"reason\":\"etamax\",\"semester\":\"ALL\"},\"15-02-2025\":{\"reason\":\"etamax\",\"semester\":\"ALL\"},\"19-02-2025\":{\"reason\":\"Shivaji Jayanti\",\"semester\":\"ALL\"},\"26-02-2025\":{\"reason\":\"Maha Shivratri\",\"semester\":\"ALL\"},\"27-02-2025\":{\"reason\":\"IA 1\",\"semester\":\"ALL\"},\"28-02-2025\":{\"reason\":\"IA 1\",\"semester\":\"ALL\"},\"01-03-2025\":{\"reason\":\"IA 1\",\"semester\":\"ALL\"},\"14-03-2025\":{\"reason\":\"Holi\",\"semester\":\"ALL\"},\"31-03-2025\":{\"reason\":\"EID\",\"semester\":\"ALL\"},\"10-04-2025\":{\"reason\":\"Mahavir Jayanti\",\"semester\":\"ALL\"},\"14-04-2025\":{\"reason\":\"Ambedkar Jayanti\",\"semester\":\"ALL\"},\"18-04-2025\":{\"reason\":\"Good Friday\",\"semester\":\"ALL\"},\"22-04-2025\":{\"reason\":\"IA 2\",\"semester\":\"ALL\"},\"23-04-2025\":{\"reason\":\"IA 2\",\"semester\":\"ALL\"},\"24-04-2025\":{\"reason\":\"IA 2\",\"semester\":\"ALL\"}}', '2025-03-27 12:51:44'),
(2, '2025-01-13', '2025-04-25', '{\"26-01-2025\":{\"reason\":\"Republic Day\",\"semester\":\"ALL\"},\"13-02-2025\":{\"reason\":\"etamax\",\"semester\":\"ALL\"},\"14-02-2025\":{\"reason\":\"etamax\",\"semester\":\"ALL\"},\"15-02-2025\":{\"reason\":\"etamax\",\"semester\":\"ALL\"},\"19-02-2025\":{\"reason\":\"Shivaji Jayanti\",\"semester\":\"ALL\"},\"26-02-2025\":{\"reason\":\"Maha Shivratri\",\"semester\":\"ALL\"},\"27-02-2025\":{\"reason\":\"IA 1\",\"semester\":\"ALL\"},\"28-02-2025\":{\"reason\":\"IA 1\",\"semester\":\"ALL\"},\"01-03-2025\":{\"reason\":\"IA 1\",\"semester\":\"ALL\"},\"14-03-2025\":{\"reason\":\"Holi\",\"semester\":\"ALL\"},\"31-03-2025\":{\"reason\":\"EID\",\"semester\":\"ALL\"},\"10-04-2025\":{\"reason\":\"Mahavir Jayanti\",\"semester\":\"ALL\"},\"14-04-2025\":{\"reason\":\"Ambedkar Jayanti\",\"semester\":\"ALL\"},\"18-04-2025\":{\"reason\":\"Good Friday\",\"semester\":\"ALL\"},\"22-04-2025\":{\"reason\":\"IA 2\",\"semester\":\"ALL\"},\"23-04-2025\":{\"reason\":\"IA 2\",\"semester\":\"ALL\"},\"24-04-2025\":{\"reason\":\"IA 2\",\"semester\":\"ALL\"}}', '2025-03-31 10:11:28');

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
  `division` text COLLATE utf8mb4_general_ci,
  `subject` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `proposed_date` date DEFAULT NULL,
  `isNTD` tinyint(1) DEFAULT NULL,
  `content` text COLLATE utf8mb4_general_ci,
  `actual_date` text COLLATE utf8mb4_general_ci,
  `content_not_covered` text COLLATE utf8mb4_general_ci,
  `reference` text COLLATE utf8mb4_general_ci,
  `methodology` text COLLATE utf8mb4_general_ci,
  `co_mapping` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_general_ci,
  `Verified_by_hod` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teaching_plan`
--

INSERT INTO `teaching_plan` (`pk`, `dept_id`, `staff_id`, `current_year`, `sem_id`, `division`, `subject`, `proposed_date`, `isNTD`, `content`, `actual_date`, `content_not_covered`, `reference`, `methodology`, `co_mapping`, `remarks`, `Verified_by_hod`) VALUES
(48, NULL, NULL, NULL, 7, 'B', 'ML', '2024-07-15', 0, 'Teaching objective and learning outcome of Ml. Subjeet. CO. PO and PSO mapping', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO1', NULL, NULL),
(49, NULL, NULL, NULL, 7, 'B', 'ML', '2024-07-16', 0, 'Module\r\n1:Introduction\r\nto Machine Learning\r\nMachine Learning. types of ML', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO1', NULL, NULL),
(50, NULL, NULL, NULL, 7, 'B', 'ML', '2024-07-16', 0, 'Issues in Machine learning .Application of Machine Learning', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO1', NULL, NULL),
(51, NULL, NULL, NULL, 7, 'B', 'ML', '2024-07-18', 0, 'Steps in developing a Vachine Learning Appliention', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO1', NULL, NULL),
(52, NULL, NULL, NULL, 7, 'B', 'ML', '2024-07-19', 0, 'Training Error. Generalization error.\r\nOverfiting, under fiting. Bias-Variance trade-off.', NULL, '', 'T1, T2, R1, R2, O1, O2, O3', 'Board, PPT', 'CO3', NULL, NULL),
(53, NULL, NULL, NULL, 7, 'B', 'ML', '2024-07-22', 0, 'Module 2: Learning with\r\nRegression and trees: Lcurning with Regression:Introduction', NULL, '', 'T1, T2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(54, NULL, NULL, NULL, 7, 'B', 'ML', '2024-07-23', 0, 'Linear Regression-Problem Soling\r\n& Evaluation', NULL, '', 'T1, T2, R1, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(55, NULL, NULL, NULL, 7, 'B', 'ML', '2024-07-25', 0, 'Logistic Regression- Introdaction &\r\nConcept', NULL, '', 'T1, T2, R1, R2', 'Board, PPT', 'CO2', NULL, NULL),
(56, NULL, NULL, NULL, 7, 'B', 'ML', '2024-07-29', 0, 'Logistic Regression- Derivation and\r\nivaluation Method', NULL, '', 'T1, T2, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(57, NULL, NULL, NULL, 7, 'B', 'ML', '2024-07-30', 0, 'Learning with Trees: Decision Frees and Gini Index Concept', NULL, '', 'T1, T2, T3, R1, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(58, NULL, NULL, NULL, 7, 'B', 'ML', '2024-08-01', 1, 'Goa IV', NULL, '', '', '', '', NULL, NULL),
(59, NULL, NULL, NULL, 7, 'B', 'ML', '2024-08-05', 0, 'Constructing Decision Irees using\r\nGini Index -Problems', NULL, '', 'T1, T2, T3, R1, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(60, NULL, NULL, NULL, 7, 'B', 'ML', '2024-08-06', 0, 'Classification and Regression frees\r\n(CART).', NULL, '', 'T1, T2, T3, R1, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(61, NULL, NULL, NULL, 7, 'B', 'ML', '2024-08-08', 0, 'Performance Metries: Confusion\r\nMatrix. [Kappa Statisties|.\r\nSensitivity. Specificity. Precision.\r\nRecall. I-measure. ROC Curve', NULL, '', 'T4, O1, O2, O3', 'Board, PPT', 'CO3', NULL, NULL),
(62, NULL, NULL, NULL, 7, 'B', 'ML', '2024-08-12', 0, 'Module +: Learning with\r\nClassification: Constrained\r\nOplimization. Optimal decision\r\nboundary, margins and support vectors', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(63, NULL, NULL, NULL, 7, 'B', 'ML', '2024-08-13', 0, 'SVM as constrained Optimization\r\nProbiem-I', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(64, NULL, NULL, NULL, 7, 'B', 'ML', '2024-08-15', 1, 'Independence Day / Parsi New Year', NULL, '', '', '', '', NULL, NULL),
(65, NULL, NULL, NULL, 7, 'B', 'ML', '2024-08-19', 0, 'Assignment Test 1', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(66, NULL, NULL, NULL, 7, 'B', 'ML', '2024-08-20', 0, 'Quadrutic Programming', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(67, NULL, NULL, NULL, 7, 'B', 'ML', '2024-08-22', 1, 'Faces', NULL, '', '', '', '', NULL, NULL),
(68, NULL, NULL, NULL, 7, 'B', 'ML', '2024-08-26', 1, 'Gopalkala', NULL, '', '', '', '', NULL, NULL),
(69, NULL, NULL, NULL, 7, 'B', 'ML', '2024-08-27', 0, 'SVM for linear and nonlinear\r\nclassilication', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(70, NULL, NULL, NULL, 7, 'B', 'ML', '2024-08-29', 0, 'Basies of Kernel trick.', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(71, NULL, NULL, NULL, 7, 'B', 'ML', '2024-09-02', 1, 'Internal Assessment-1', NULL, '', '', '', '', NULL, NULL),
(72, NULL, NULL, NULL, 7, 'B', 'ML', '2024-09-03', 1, 'Internal Assessment-1', NULL, '', '', '', '', NULL, NULL),
(73, NULL, NULL, NULL, 7, 'B', 'ML', '2024-09-05', 0, 'Case Study: Identiting and analyzing Classification base Ml. Models\r\n(Innovative Teaching)', NULL, '', 'O1, O2, O3', 'Board, PPT', '', NULL, NULL),
(74, NULL, NULL, NULL, 7, 'B', 'ML', '2024-09-09', 1, 'Ganesh Chaturthi', NULL, '', '', '', '', NULL, NULL),
(75, NULL, NULL, NULL, 7, 'B', 'ML', '2024-09-10', 1, 'Ganesh Chaturthi', NULL, '', '', '', '', NULL, NULL),
(76, NULL, NULL, NULL, 7, 'B', 'ML', '2024-09-12', 0, 'Module 5: Learning with clustering.\r\nIntroduction to clustering with\r\noverview of distance metrics and\r\nmajor clustering approaches.', NULL, '', 'T1, T2, T3, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(77, NULL, NULL, NULL, 7, 'B', 'ML', '2024-09-16', 1, '16-E-Milad', NULL, '', 'T2, R2', '', '', NULL, NULL),
(78, NULL, NULL, NULL, 7, 'B', 'ML', '2024-09-17', 0, 'Graph Based Clustering: Clustering with minimal spanning tree - Part I', NULL, '', 'T2, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(79, NULL, NULL, NULL, 7, 'B', 'ML', '2024-09-19', 0, 'Graph Based Clustering: Clustering with minimal spanning tree -Pan 11', NULL, '', 'T2, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(80, NULL, NULL, NULL, 7, 'B', 'ML', '2024-09-23', 0, 'Model hased Clustering: Expectation\r\nMaximization Algorithm', NULL, '', 'T2, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(81, NULL, NULL, NULL, 7, 'B', 'ML', '2024-09-24', 0, 'Density Based Clustering: DBSCAN', NULL, '', 'T2, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(82, NULL, NULL, NULL, 7, 'B', 'ML', '2024-09-26', 0, 'Density Based Clustering: DBSCAN', NULL, '', 'T2, R2, O1, O2, O3', 'Board, PPT', 'CO2', NULL, NULL),
(83, NULL, NULL, NULL, 7, 'B', 'ML', '2024-09-30', 0, 'Module3: Ensemble Learning\r\nUnderstanding Ensembles. K-lold\r\ncross validation', NULL, '', 'T2, T4, O1, O2, O3', 'Board, PPT', 'CO4', NULL, NULL),
(84, NULL, NULL, NULL, 7, 'B', 'ML', '2024-10-01', 0, 'Boosting. Stumping. XGBoost', NULL, '', 'T2, T4, O1, O2, O3', 'Board, PPT', 'CO4', NULL, NULL),
(85, NULL, NULL, NULL, 7, 'B', 'ML', '2024-10-03', 0, 'Bagging. Subagging. Random Forest', NULL, '', 'T2, T4, O1, O2, O3', 'Board, PPT', 'CO4', NULL, NULL),
(86, NULL, NULL, NULL, 7, 'B', 'ML', '2024-10-07', 0, 'Comparison with Boosting. Different ways to combine classifier', NULL, '', 'T2, T4, O1, O2, O3', 'Board, PPT', 'CO4', NULL, NULL),
(87, NULL, NULL, NULL, 7, 'B', 'ML', '2024-10-08', 0, 'Module 6: Dimension Reduction\r\nDimensionality Reduction Techniques', NULL, '', 'T1, T4, O1, O2, O3', 'Board, PPT', 'CO5', NULL, NULL),
(88, NULL, NULL, NULL, 7, 'B', 'ML', '2024-10-10', 0, 'Assignment Test 2', NULL, '', 'O1, O2, O3', 'Board, PPT', '', NULL, NULL),
(89, NULL, NULL, NULL, 7, 'B', 'ML', '2024-10-14', 0, 'Principal T4 Component Analysis', NULL, '', 'T1, T2, O1, O2, O3', 'Board, PPT', 'CO5', NULL, NULL),
(90, NULL, NULL, NULL, 7, 'B', 'ML', '2024-10-15', 0, 'PCA-Problem Solving', NULL, '', 'T1, T2, O1, O2, O3', 'Board, PPT', 'CO5', NULL, NULL),
(91, NULL, NULL, NULL, 7, 'B', 'ML', '2024-10-17', 0, 'Linear Discriminant Analysis.', NULL, '', 'T1, T2, O1, O2, O3', 'Board, PPT', 'CO5', NULL, NULL),
(92, NULL, NULL, NULL, 7, 'B', 'ML', '2024-10-21', 1, 'Internal Assessment-2', NULL, '', '', '', '', NULL, NULL),
(93, NULL, NULL, NULL, 7, 'B', 'ML', '2024-10-22', 0, 'Singular Valued Decomposition', NULL, '', 'T1, T2, O1, O2, O3', 'Board, PPT', 'CO5', NULL, NULL),
(94, NULL, NULL, NULL, 7, 'B', 'ML', '2024-10-24', 0, 'Revision', NULL, '', 'T1, T2, O1, O2, O3', 'Board, PPT', 'CO5', NULL, NULL),
(95, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-07-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-07-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-07-29', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-08-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-08-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-08-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-08-26', 1, 'Gopalkala', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(102, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-09-02', 1, 'Internal Assessment-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-09-09', 1, 'Ganesh Chaturthi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-09-16', 1, '16-E-Milad', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-09-23', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-09-30', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-10-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-10-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-10-21', 1, 'Internal Assessment-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-07-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-07-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-07-29', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-08-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-08-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-08-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-08-26', 1, 'Gopalkala', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-09-02', 1, 'Internal Assessment-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-09-09', 1, 'Ganesh Chaturthi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-09-16', 1, '16-E-Milad', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-09-23', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-09-30', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-10-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-10-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, NULL, NULL, NULL, 3, 'B', 'EM-III', '2024-10-21', 1, 'Internal Assessment-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-07-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-07-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-07-16', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-07-18', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-07-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-07-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-07-23', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-07-26', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(133, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-07-29', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(134, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-07-30', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(135, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-08-02', 1, 'Goa IV', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(136, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-08-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(137, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-08-06', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(138, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-08-09', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(139, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-08-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(140, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-08-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(141, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-08-16', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(142, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-08-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(143, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-08-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(144, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-08-23', 1, 'Faces', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(145, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-08-26', 1, 'Gopalkala', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(146, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-08-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(147, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-08-30', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(148, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-09-02', 1, 'Internal Assessment-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(149, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-09-03', 1, 'Internal Assessment-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(150, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-09-06', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(151, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-09-09', 1, 'Ganesh Chaturthi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(152, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-09-10', 1, 'Ganesh Chaturthi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(153, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-09-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(154, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-09-16', 1, '16-E-Milad', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(155, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-09-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(156, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-09-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(157, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-09-23', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(158, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-09-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(159, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-09-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(160, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-09-30', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(161, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-10-01', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(162, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-10-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(163, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-10-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(164, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-10-08', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(165, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-10-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(166, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-10-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(167, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-10-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(168, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-10-18', 1, 'Internal Assessment-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(169, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-10-21', 1, 'Internal Assessment-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(170, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-10-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(171, NULL, NULL, NULL, 7, 'B', 'BDA', '2024-10-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(219, NULL, NULL, NULL, 8, 'B', 'DC', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(220, NULL, NULL, NULL, 8, 'B', 'DC', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(221, NULL, NULL, NULL, 8, 'B', 'DC', '2025-01-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(222, NULL, NULL, NULL, 8, 'B', 'DC', '2025-01-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(223, NULL, NULL, NULL, 8, 'B', 'DC', '2025-01-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(224, NULL, NULL, NULL, 8, 'B', 'DC', '2025-01-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(225, NULL, NULL, NULL, 8, 'B', 'DC', '2025-01-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(226, NULL, NULL, NULL, 8, 'B', 'DC', '2025-01-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(227, NULL, NULL, NULL, 8, 'B', 'DC', '2025-01-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(228, NULL, NULL, NULL, 8, 'B', 'DC', '2025-01-28', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(229, NULL, NULL, NULL, 8, 'B', 'DC', '2025-01-31', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(230, NULL, NULL, NULL, 8, 'B', 'DC', '2025-02-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(231, NULL, NULL, NULL, 8, 'B', 'DC', '2025-02-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(232, NULL, NULL, NULL, 8, 'B', 'DC', '2025-02-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(233, NULL, NULL, NULL, 8, 'B', 'DC', '2025-02-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(234, NULL, NULL, NULL, 8, 'B', 'DC', '2025-02-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(235, NULL, NULL, NULL, 8, 'B', 'DC', '2025-02-14', 1, 'etamax', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(236, NULL, NULL, NULL, 8, 'B', 'DC', '2025-02-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(237, NULL, NULL, NULL, 8, 'B', 'DC', '2025-02-18', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(238, NULL, NULL, NULL, 8, 'B', 'DC', '2025-02-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(239, NULL, NULL, NULL, 8, 'B', 'DC', '2025-02-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(240, NULL, NULL, NULL, 8, 'B', 'DC', '2025-02-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(241, NULL, NULL, NULL, 8, 'B', 'DC', '2025-02-28', 1, 'IA 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(242, NULL, NULL, NULL, 8, 'B', 'DC', '2025-03-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(243, NULL, NULL, NULL, 8, 'B', 'DC', '2025-03-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(244, NULL, NULL, NULL, 8, 'B', 'DC', '2025-03-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(245, NULL, NULL, NULL, 8, 'B', 'DC', '2025-03-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(246, NULL, NULL, NULL, 8, 'B', 'DC', '2025-03-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(247, NULL, NULL, NULL, 8, 'B', 'DC', '2025-03-14', 1, 'Holi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(248, NULL, NULL, NULL, 8, 'B', 'DC', '2025-03-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(249, NULL, NULL, NULL, 8, 'B', 'DC', '2025-03-18', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(250, NULL, NULL, NULL, 8, 'B', 'DC', '2025-03-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(251, NULL, NULL, NULL, 8, 'B', 'DC', '2025-03-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(252, NULL, NULL, NULL, 8, 'B', 'DC', '2025-03-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(253, NULL, NULL, NULL, 8, 'B', 'DC', '2025-03-28', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(254, NULL, NULL, NULL, 8, 'B', 'DC', '2025-03-31', 1, 'EID', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(255, NULL, NULL, NULL, 8, 'B', 'DC', '2025-04-01', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(256, NULL, NULL, NULL, 8, 'B', 'DC', '2025-04-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(257, NULL, NULL, NULL, 8, 'B', 'DC', '2025-04-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(258, NULL, NULL, NULL, 8, 'B', 'DC', '2025-04-08', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(259, NULL, NULL, NULL, 8, 'B', 'DC', '2025-04-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(260, NULL, NULL, NULL, 8, 'B', 'DC', '2025-04-14', 1, 'Ambedkar Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(261, NULL, NULL, NULL, 8, 'B', 'DC', '2025-04-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(262, NULL, NULL, NULL, 8, 'B', 'DC', '2025-04-18', 1, 'Good Friday', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(263, NULL, NULL, NULL, 8, 'B', 'DC', '2025-04-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(264, NULL, NULL, NULL, 8, 'B', 'DC', '2025-04-22', 1, 'IA 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(265, NULL, NULL, NULL, 8, 'B', 'DC', '2025-04-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(324, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(325, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-01-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(326, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-01-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(327, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-01-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(328, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-01-16', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(329, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-01-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(330, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-01-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(331, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-01-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(332, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-01-22', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(333, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-01-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(334, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-01-28', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(335, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-01-29', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(336, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-02-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(337, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-02-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(338, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-02-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(339, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-02-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(340, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-02-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(341, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-02-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(342, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-02-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(343, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-02-18', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(344, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-02-19', 1, 'Shivaji Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(345, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-02-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(346, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-02-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(347, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-02-26', 1, 'Maha Shivratri', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(348, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-03-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(349, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-03-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(350, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-03-05', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(351, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-03-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(352, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-03-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(353, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-03-12', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(354, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-03-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(355, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-03-18', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(356, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-03-19', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(357, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-03-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(358, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-03-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(359, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-03-26', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(360, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-03-31', 1, 'EID', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(361, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-04-01', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(362, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-04-02', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(363, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-04-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(364, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-04-08', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(365, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-04-09', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(366, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-04-14', 1, 'Ambedkar Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(367, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-04-15', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(368, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-04-16', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(369, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-04-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(370, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-04-22', 1, 'IA 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(371, NULL, NULL, NULL, 6, 'A', 'CSS', '2025-04-23', 1, 'IA 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(372, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(373, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(374, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-01-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(375, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-01-16', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(376, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-01-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(377, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-01-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(378, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-01-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(379, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-01-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(380, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-01-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(381, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-01-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(382, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-01-31', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(383, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-02-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(384, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-02-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(385, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-02-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(386, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-02-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(387, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-02-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(388, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-02-14', 1, 'etamax', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(389, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-02-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(390, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-02-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(391, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-02-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(392, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-02-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(393, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-02-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(394, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-02-28', 1, 'IA 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(395, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-03-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(396, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-03-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(397, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-03-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(398, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-03-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(399, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-03-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(400, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-03-14', 1, 'Holi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(401, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-03-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(402, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-03-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(403, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-03-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(404, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-03-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(405, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-03-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(406, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-03-28', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(407, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-03-31', 1, 'EID', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(408, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-04-04', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(409, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-04-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(410, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-04-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(411, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-04-11', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(412, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-04-14', 1, 'Ambedkar Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(413, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-04-18', 1, 'Good Friday', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(414, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-04-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(415, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-04-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(416, NULL, NULL, NULL, 8, 'B', 'SMA', '2025-04-25', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(417, NULL, NULL, NULL, 6, 'A', 'AI', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(418, NULL, NULL, NULL, 6, 'A', 'AI', '2025-01-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(419, NULL, NULL, NULL, 6, 'A', 'AI', '2025-01-14', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(420, NULL, NULL, NULL, 6, 'A', 'AI', '2025-01-16', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(421, NULL, NULL, NULL, 6, 'A', 'AI', '2025-01-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(422, NULL, NULL, NULL, 6, 'A', 'AI', '2025-01-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(423, NULL, NULL, NULL, 6, 'A', 'AI', '2025-01-23', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(424, NULL, NULL, NULL, 6, 'A', 'AI', '2025-01-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(425, NULL, NULL, NULL, 6, 'A', 'AI', '2025-01-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(426, NULL, NULL, NULL, 6, 'A', 'AI', '2025-01-30', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(427, NULL, NULL, NULL, 6, 'A', 'AI', '2025-02-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(428, NULL, NULL, NULL, 6, 'A', 'AI', '2025-02-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(429, NULL, NULL, NULL, 6, 'A', 'AI', '2025-02-06', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(430, NULL, NULL, NULL, 6, 'A', 'AI', '2025-02-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(431, NULL, NULL, NULL, 6, 'A', 'AI', '2025-02-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(432, NULL, NULL, NULL, 6, 'A', 'AI', '2025-02-13', 1, 'etamax', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(433, NULL, NULL, NULL, 6, 'A', 'AI', '2025-02-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(434, NULL, NULL, NULL, 6, 'A', 'AI', '2025-02-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(435, NULL, NULL, NULL, 6, 'A', 'AI', '2025-02-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(436, NULL, NULL, NULL, 6, 'A', 'AI', '2025-02-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(437, NULL, NULL, NULL, 6, 'A', 'AI', '2025-02-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(438, NULL, NULL, NULL, 6, 'A', 'AI', '2025-02-27', 1, 'IA 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(439, NULL, NULL, NULL, 6, 'A', 'AI', '2025-03-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(440, NULL, NULL, NULL, 6, 'A', 'AI', '2025-03-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(441, NULL, NULL, NULL, 6, 'A', 'AI', '2025-03-06', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(442, NULL, NULL, NULL, 6, 'A', 'AI', '2025-03-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(443, NULL, NULL, NULL, 6, 'A', 'AI', '2025-03-10', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(444, NULL, NULL, NULL, 6, 'A', 'AI', '2025-03-13', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(445, NULL, NULL, NULL, 6, 'A', 'AI', '2025-03-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(446, NULL, NULL, NULL, 6, 'A', 'AI', '2025-03-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(447, NULL, NULL, NULL, 6, 'A', 'AI', '2025-03-20', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(448, NULL, NULL, NULL, 6, 'A', 'AI', '2025-03-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(449, NULL, NULL, NULL, 6, 'A', 'AI', '2025-03-24', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(450, NULL, NULL, NULL, 6, 'A', 'AI', '2025-03-27', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(451, NULL, NULL, NULL, 6, 'A', 'AI', '2025-03-31', 1, 'EID', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(452, NULL, NULL, NULL, 6, 'A', 'AI', '2025-04-03', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(453, NULL, NULL, NULL, 6, 'A', 'AI', '2025-04-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(454, NULL, NULL, NULL, 6, 'A', 'AI', '2025-04-07', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(455, NULL, NULL, NULL, 6, 'A', 'AI', '2025-04-10', 1, 'Mahavir Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(456, NULL, NULL, NULL, 6, 'A', 'AI', '2025-04-14', 1, 'Ambedkar Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(457, NULL, NULL, NULL, 6, 'A', 'AI', '2025-04-17', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(458, NULL, NULL, NULL, 6, 'A', 'AI', '2025-04-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(459, NULL, NULL, NULL, 6, 'A', 'AI', '2025-04-21', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(460, NULL, NULL, NULL, 6, 'A', 'AI', '2025-04-24', 1, 'IA 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(848, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-01-13', 0, 'Discussion CO-PO-PSO-Tool-Course \r\ncontent, Introduction to Data Science', NULL, NULL, 'T1', 'PPT', 'CO1', NULL, NULL),
(849, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-01-13', 0, 'Module No: -1  \r\nIntroduction to Data Science \r\nData Science Process,', NULL, NULL, 'T1, T4', 'PPT', 'CO1', NULL, NULL),
(850, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-01-14', 0, 'Motivation to use Data Science \r\nTechniques: Volume, Dimensions and \r\nComplexity. Data Science Tasks and \r\nExamples', NULL, NULL, 'T1, T4', 'PPT', 'CO1', NULL, NULL),
(851, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-01-16', 0, 'Overview of Data Preparation, \r\nModeling, Difference between data \r\nscience and data analytics', NULL, NULL, 'T1', 'PPT', 'CO1', NULL, NULL),
(852, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-01-17', 0, 'Revision', NULL, NULL, NULL, 'PPT', 'CO2', NULL, NULL),
(853, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-01-20', 0, 'Module No: -2  \r\nData Exploration \r\nTypes of data, Properties of data', NULL, NULL, 'T4, R3, R4', 'PPT', 'CO2', NULL, NULL),
(854, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-01-21', 0, 'Descriptive Statistics: Univariate \r\nExploration: Measure of Central \r\nTendency', NULL, NULL, 'T4, R3, R4', 'Board, PPT', 'CO2', NULL, NULL),
(855, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-01-24', 0, 'Measure of Spread Symmetry, \r\nSkewness: Karl Pearson Coefficient of \r\nskewness', NULL, NULL, 'T4, R3, R4', 'Board, PPT', 'CO2', NULL, NULL),
(856, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-01-27', 0, 'Bowley ‘s Coefficient, Kurtosis', NULL, NULL, 'T4, R3, R4', 'Board, PPT', 'CO2', NULL, NULL),
(857, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-01-28', 0, 'Multivariate Exploration: Central Data \r\nPoint, Correlation, Different forms of \r\ncorrelation', NULL, NULL, 'T4, R3, R4', 'Board, PPT', 'CO2', NULL, NULL),
(858, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-01-31', 0, 'Karl Pearson Correlation Coefficient for \r\nbivariate', NULL, NULL, 'T4, R3, R4', 'Board, PPT', 'CO2', NULL, NULL),
(859, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-02-03', 0, 'Inferential Statistics: Overview of \r\nVarious forms of distributions: Normal', NULL, NULL, 'T4, R3, O4', 'Board, PPT', 'CO2', NULL, NULL),
(860, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-02-04', 0, 'Poisson distribution, Test Hypothesis, \r\nCentral limit theorem', NULL, NULL, 'T4, R3, O4', 'Board, PPT', 'CO2', NULL, NULL),
(861, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-02-07', 0, 'Confidence Interval', NULL, NULL, 'T4, R3, O4', 'Board, PPT', 'CO2', NULL, NULL),
(862, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-02-10', 0, 'Z-test', NULL, NULL, 'T4, R3, O4', 'Board, PPT', 'CO2', NULL, NULL),
(863, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-02-11', 0, 't-test, Type-I, Type-II Errors,', NULL, NULL, 'T4, R3, O4', 'Board, PPT', 'CO2', NULL, NULL),
(864, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-02-14', 1, 'etamax', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(865, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-02-17', 0, 'ANOVA', NULL, NULL, 'T4, R3, O4', 'Board, PPT', 'CO2', NULL, NULL),
(866, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-02-18', 0, 'ANOVA', NULL, NULL, 'T4, R3, O4', 'Board, PPT', 'CO2', NULL, NULL),
(867, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-02-21', 0, 'Revision', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(868, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-02-24', 0, 'Assignment Test-1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(869, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-02-25', 0, 'Module No:-3 \r\nMethodology & Data Visualization \r\nMethodology: Overview of model \r\nbuilding, Cross Validation, K-fold cross \r\nvalidation, leave-1 out, Bootstrapping', NULL, NULL, 'T1, T4', 'PPT', 'CO3', NULL, NULL),
(870, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-02-28', 1, 'IA 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(871, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-03-03', 0, 'Data Visualization Univariate \r\nVisualization: Histogram, Quartile, \r\nDistribution Chart', NULL, NULL, 'T1, T4', 'PPT', 'CO3', NULL, NULL),
(872, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-03-04', 0, 'Multivariate Visualization: Scatter Plot, \r\nScatter Matrix, Bubble chart, Density \r\nChart Roadmap for Data Exploration', NULL, NULL, 'T1, T4', 'PPT', 'CO3', NULL, NULL),
(873, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-03-07', 0, 'Visualizing high dimensional data: \r\nParallel chart, Deviation chart, Andrews \r\nCurves.', NULL, NULL, 'T1, T4', 'PPT', 'CO3', NULL, NULL),
(874, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-03-10', 0, 'Revision', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(875, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-03-11', 0, 'Module No: -4 \r\nAnomaly Detection \r\nOutliers, Causes of Outliers, Anomaly \r\ndetection techniques,', NULL, NULL, 'T1, T4', 'PPT', 'CO4', NULL, NULL),
(876, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-03-14', 1, 'Holi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(877, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-03-17', 0, 'Outlier Detection using Statistics', NULL, NULL, 'T1, T4', 'PPT', 'CO4', NULL, NULL),
(878, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-03-18', 0, 'Outlier Detection using Distance based \r\nmethod,', NULL, NULL, 'T1, T4', 'PPT', 'CO4', NULL, NULL),
(879, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-03-21', 0, 'Outlier detection using density-based \r\nmethods, SMOTE', NULL, NULL, 'T1, T4', 'PPT', 'CO4', NULL, NULL),
(880, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-03-24', 0, 'Module No: -5 \r\nTime Series Forecasting \r\nTaxonomy of Time Series Forecasting \r\nmethods, Time Series Decomposition', NULL, NULL, 'T1, T4', 'PPT', NULL, NULL, NULL),
(881, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-03-25', 0, 'Smoothening Methods: Average \r\nmethod, Moving Average smoothing,', NULL, NULL, 'T1, T4', 'Board', NULL, NULL, NULL),
(882, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-03-28', 0, 'Time series analysis using linear \r\nregression,', NULL, NULL, 'T1, T4', 'PPT', 'CO5', NULL, NULL),
(883, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-03-31', 1, 'EID', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(884, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-04-01', 0, 'ARIMA', NULL, NULL, 'R3, R4', 'Board', 'CO5', NULL, NULL),
(885, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-04-04', 0, 'Performance Evaluation: Mean Absolute \r\nError, Root Mean Square Error, Mean \r\nAbsolute Percentage Error, Mean \r\nAbsolute Scaled Error Absolute Scaled \r\nError', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(886, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-04-07', 0, 'Evaluation parameters for \r\nClassification, regression, and', NULL, NULL, 'R3, R4', 'PPT', 'CO5', NULL, NULL),
(887, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-04-08', 0, 'Assignment Test-2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(888, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-04-11', 0, 'Revision', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(889, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-04-14', 1, 'Ambedkar Jayanti', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(890, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-04-15', 0, 'Module no: -6 \r\nApplication of Data Science \r\nApplication of Data Science \r\nPredictive Modeling: House price \r\nprediction, Fraud Detection', NULL, NULL, 'T1, T4', 'PPT', 'CO6', NULL, NULL),
(891, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-04-18', 1, 'Good Friday', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(892, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-04-21', 0, 'Clustering: Customer Segmentation \r\nTime series forecasting: Weather \r\nForecasting, Recommendation engines: \r\nProduct recommendation', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(893, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-04-22', 1, 'IA 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(894, NULL, NULL, NULL, 8, 'B', 'ADS', '2025-04-25', 0, 'Revision', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dept`
--
ALTER TABLE `dept`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `missing_content_table`
--
ALTER TABLE `missing_content_table`
  ADD PRIMARY KEY (`pk`),
  ADD KEY `missing_content_fk_dept` (`dept_id`),
  ADD KEY `missing_content_fk_staff` (`staff_id`),
  ADD KEY `missing_content_fk_sem` (`sem_id`);

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
-- AUTO_INCREMENT for table `missing_content_table`
--
ALTER TABLE `missing_content_table`
  MODIFY `pk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reference_table`
--
ALTER TABLE `reference_table`
  MODIFY `pk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

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
  MODIFY `pk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=895;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `missing_content_table`
--
ALTER TABLE `missing_content_table`
  ADD CONSTRAINT `missing_content_fk_dept` FOREIGN KEY (`dept_id`) REFERENCES `dept` (`dept_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `missing_content_fk_sem` FOREIGN KEY (`sem_id`) REFERENCES `sem` (`sem_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `missing_content_fk_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON UPDATE CASCADE;

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
