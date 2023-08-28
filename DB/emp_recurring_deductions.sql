-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2023 at 02:07 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hr_fab`
--

-- --------------------------------------------------------

--
-- Table structure for table `emp_recurring_deductions`
--

CREATE TABLE `emp_recurring_deductions` (
  `id` int(6) NOT NULL,
  `employee_id` int(90) NOT NULL,
  `deduction_total` int(200) NOT NULL,
  `monthly_deduct` text NOT NULL,
  `duration` int(200) NOT NULL,
  `company_ID` int(20) NOT NULL,
  `deduction_date` text NOT NULL,
  `date_completion` text NOT NULL,
  `status` text NOT NULL,
  `deduction_type` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_recurring_deductions`
--

INSERT INTO `emp_recurring_deductions` (`id`, `employee_id`, `deduction_total`, `monthly_deduct`, `duration`, `company_ID`, `deduction_date`, `date_completion`, `status`, `deduction_type`) VALUES
(1, 0, 10000, '2500', 4, 4, '', '', 'Pending', 2),
(2, 153, 10000, '2500', 4, 4, '', '', 'Pending', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emp_recurring_deductions`
--
ALTER TABLE `emp_recurring_deductions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emp_recurring_deductions`
--
ALTER TABLE `emp_recurring_deductions`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
