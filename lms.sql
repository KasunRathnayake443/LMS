-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2024 at 09:46 AM
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
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `A_id` int(11) NOT NULL,
  `A_email` varchar(100) NOT NULL,
  `A_name` varchar(100) NOT NULL,
  `A_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`A_id`, `A_email`, `A_name`, `A_password`) VALUES
(1, 'admin@gmail.com', 'Test Admin', 'admin'),
(3, 'admin2@gmail.com', 'admin test2', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `d_name` varchar(100) NOT NULL,
  `D_id` int(11) NOT NULL,
  `D_description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`d_name`, `D_id`, `D_description`) VALUES
('Finance', 1, ''),
('Marketing', 2, ''),
('HR', 5, ''),
('IT', 8, '');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `E_id` int(11) NOT NULL,
  `E_name` varchar(100) NOT NULL,
  `E_email` varchar(100) NOT NULL,
  `E_department` varchar(100) NOT NULL,
  `E_password` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`E_id`, `E_name`, `E_email`, `E_department`, `E_password`) VALUES
(4, 'Aron Black', 'black@gmail.com', 'Finance', 'black123'),
(5, 'abc', 'abc@gmail.com', 'Marketing', '123'),
(7, 'kasun', 'kasun@gmail.com', 'Marketing', '123'),
(8, 'Test Employee', 'test@gmail.com', 'Marketing', 'test123');

-- --------------------------------------------------------

--
-- Table structure for table `leave_list`
--

CREATE TABLE `leave_list` (
  `E_id` int(11) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `E_name` varchar(100) NOT NULL,
  `Leave_type` varchar(100) NOT NULL,
  `Start` varchar(100) NOT NULL,
  `End` varchar(100) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Comment` varchar(1000) NOT NULL,
  `A_id` int(11) NOT NULL,
  `a_remark` varchar(1000) NOT NULL,
  `seen` int(11) NOT NULL,
  `submission_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_list`
--

INSERT INTO `leave_list` (`E_id`, `leave_id`, `E_name`, `Leave_type`, `Start`, `End`, `Status`, `Comment`, `A_id`, `a_remark`, `seen`, `submission_date`) VALUES
(1, 1, 'Kasun Rathanayake', 'Sick leave', '2024-08-16', '2024-08-16', 'Declined', 'test', 0, 'change decline to pending', 0, '2024-08-12 12:09:55'),
(5, 11, 'abc', 'Casual leave', '2024-08-21', '2024-08-30', 'Declined', '22222', 3, 'change pending to declined', 0, '2024-08-12 12:09:55'),
(8, 14, 'Test Employee', 'Bereavement leave', '2024-08-24', '2024-08-10', 'Approved', 'test', 3, 'change pending to approved', 0, '2024-08-12 12:09:55'),
(7, 17, 'kasun', 'Unpaid leave', '2024-08-10', '2024-08-20', 'Approved', 'new test', 1, 'approved', 1, '2024-08-12 12:09:55'),
(4, 18, 'Aron Black', 'Unpaid leave', '2024-08-09', '2024-08-28', 'Approved', 'test employee requests', 0, 'testing the sort by', 0, '2024-08-12 12:09:55'),
(7, 19, 'kasun', 'Bereavement leave', '2024-08-13', '2024-08-15', 'Approved', 'test after employee notifications', 0, 'ok', 1, '2024-08-12 12:09:55'),
(7, 20, 'kasun', 'Sick leave', '2024-08-14', '2024-08-22', 'Approved', 'Test submission date and time', 0, 'testing sort', 1, '2024-08-12 08:43:35'),
(7, 21, 'kasun', 'Bereavement leave', '2024-08-16', '2024-08-18', 'Approved', 'time test', 0, 'testing time', 1, '2024-08-12 08:45:32');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `leave_name` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`leave_name`, `description`, `id`) VALUES
('Sick leave', 'Sick Leave (SL) Also called Medical Leaves (ML), these are provided on the grounds of sickness or in case of accidents.', 6),
('Casual leave', 'Casual leave, also known as unplanned leave, is a mandatory leave that employees can take for personal reasons.', 7),
('Unpaid leave', 'Employees may wish to (or need to) take unpaid leave for various reasons should they not have enough paid leave days to use or if unexpected events occur in their personal life. ', 8),
('Bereavement leave', 'An employee takes bereavement leave or funeral leave after the death of a loved one (usually a relative or close friend). This would typically be as long as the employee needs to attend the funeral and recover from immediate grief. ', 9),
('Other Reason', '', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`A_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`D_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`E_id`);

--
-- Indexes for table `leave_list`
--
ALTER TABLE `leave_list`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `A_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `D_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `E_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `leave_list`
--
ALTER TABLE `leave_list`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
