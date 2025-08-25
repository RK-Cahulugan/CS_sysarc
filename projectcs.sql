-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2025 at 12:44 AM
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
-- Database: `projectcs`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendancetbl`
--

CREATE TABLE `attendancetbl` (
  `attendanceID` int(10) UNSIGNED NOT NULL,
  `studentID` varchar(20) NOT NULL,
  `timeIN` datetime NOT NULL,
  `timeOUT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendancetbl`
--

INSERT INTO `attendancetbl` (`attendanceID`, `studentID`, `timeIN`, `timeOUT`) VALUES
(1, '2023-07-00668', '2025-08-24 10:04:39', '2025-08-24 10:05:24'),
(2, '2023-07-00668', '2025-08-24 10:06:16', '2025-08-24 10:24:43'),
(3, '2023-06-00672', '2025-08-24 10:25:57', '2025-08-24 10:27:36'),
(4, '2023-07-00668', '2025-08-24 10:59:51', NULL),
(5, '2023-07-00668', '2025-08-25 14:14:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studentID` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `course` varchar(50) NOT NULL,
  `year_level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentID`, `name`, `course`, `year_level`) VALUES
('2022-06-00221', 'Jasmin Aladdin', 'BSBA', '4th year'),
('2022-06-00771', 'Maxine Dela Cruz', 'BSBA', '4th year'),
('2023-06-00672', 'Christian Mark Regacho', 'BSIT', '3rd year'),
('2023-07-00668', 'Ranzie Kirth Cahulugan', 'BSIT', '3rd year'),
('2023-08-00666', 'KenKevin Cabanalan', 'BSIT', '2nd year');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendancetbl`
--
ALTER TABLE `attendancetbl`
  ADD PRIMARY KEY (`attendanceID`),
  ADD KEY `idx_studentID` (`studentID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`studentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendancetbl`
--
ALTER TABLE `attendancetbl`
  MODIFY `attendanceID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendancetbl`
--
ALTER TABLE `attendancetbl`
  ADD CONSTRAINT `fk_attendance_student` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
