-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2022 at 04:37 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_iv_controll`
--

-- --------------------------------------------------------

--
-- Table structure for table `patients_current_data`
--

CREATE TABLE `patients_current_data` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(20) NOT NULL,
  `admit_date` datetime NOT NULL,
  `room_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients_current_data`
--

INSERT INTO `patients_current_data` (`id`, `patient_id`, `patient_name`, `admit_date`, `room_no`) VALUES
(1, 1023, 'jimit patel', '2022-10-17 00:00:00', 101),
(2, 1024, 'saurabh mishra', '2022-10-18 04:11:10', 103),
(3, 1025, 'abc dsf', '2022-10-16 07:41:36', 104);

-- --------------------------------------------------------

--
-- Table structure for table `patients_history`
--

CREATE TABLE `patients_history` (
  `id` int(11) NOT NULL,
  `room_no` int(10) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `fluid_level` float DEFAULT NULL,
  `temp` float DEFAULT NULL,
  `bpm` int(11) DEFAULT NULL,
  `spo2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients_history`
--

INSERT INTO `patients_history` (`id`, `room_no`, `date`, `time`, `fluid_level`, `temp`, `bpm`, `spo2`) VALUES
(1, 104, '2022-10-11', '10:32:30', 200, 97, 78, 95),
(2, 103, '2022-10-19', '17:33:30', 435, 96, 76, 98),
(3, 101, '2022-10-17', '00:00:00', 101, 99, 55, 98),
(4, 102, '2022-10-18', '00:00:00', 200, 98, 75, 98),
(5, 105, '2022-10-17', '12:30:00', 500, 97, 78, 94),
(6, 101, '2022-10-17', '12:45:20', 500, 97, 78, 94),
(7, 102, '2022-10-17', '12:45:26', 500, 97, 78, 94),
(8, 105, '2022-10-17', '12:46:31', 1000, 97, 78, 94);

-- --------------------------------------------------------

--
-- Table structure for table `patients_record`
--

CREATE TABLE `patients_record` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(20) NOT NULL,
  `admit_date` date NOT NULL,
  `admit_time` time DEFAULT NULL,
  `leave_date` date NOT NULL,
  `leave_time` time DEFAULT NULL,
  `room_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients_record`
--

INSERT INTO `patients_record` (`id`, `patient_id`, `patient_name`, `admit_date`, `admit_time`, `leave_date`, `leave_time`, `room_no`) VALUES
(1, 1028, 'poonam patel', '2022-10-06', '04:49:14', '2022-10-11', '07:24:14', 102),
(2, 1026, 'charu latta', '2022-10-02', '07:38:43', '2022-10-09', '15:50:43', 104),
(3, 1030, 'jons bosso', '2022-09-01', '06:51:22', '2022-10-10', '17:51:22', 101),
(4, 1017, 'sandra bosso', '2022-10-01', '15:51:22', '2022-10-10', '20:51:22', 105);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patients_current_data`
--
ALTER TABLE `patients_current_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients_history`
--
ALTER TABLE `patients_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients_record`
--
ALTER TABLE `patients_record`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patients_current_data`
--
ALTER TABLE `patients_current_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patients_history`
--
ALTER TABLE `patients_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `patients_record`
--
ALTER TABLE `patients_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
