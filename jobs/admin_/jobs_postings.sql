-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2022 at 10:41 AM
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
-- Database: `chescote_lendmepay_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs_postings`
--

CREATE TABLE `jobs_postings` (
  `id` int(11) NOT NULL,
  `title` varchar(222) NOT NULL,
  `dep_id` int(11) NOT NULL,
  `vacancies` int(50) NOT NULL,
  `type` varchar(222) NOT NULL,
  `experience` varchar(222) NOT NULL,
  `salary_min` varchar(222) NOT NULL,
  `salary_max` varchar(222) NOT NULL,
  `qualifications` text NOT NULL,
  `status` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires` varchar(50) NOT NULL,
  `salary_period` varchar(222) NOT NULL,
  `currency` varchar(222) NOT NULL,
  `country` varchar(222) NOT NULL,
  `region` varchar(222) NOT NULL,
  `city` varchar(222) NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_postings`
--

INSERT INTO `jobs_postings` (`id`, `title`, `dep_id`, `vacancies`, `type`, `experience`, `salary_min`, `salary_max`, `qualifications`, `status`, `date`, `expires`, `salary_period`, `currency`, `country`, `region`, `city`, `description`, `requirements`) VALUES
(4, 'test one on me', 40, 2, 'Contract', '2', '10000', '15000', 'cert', 'Unpublished', '2022-04-28 22:00:00', '2022-04-30', 'monthly', 'kwacha', 'Zambia', 'Lusaka', 'lusaka', '@ljharb I\'m adding eslint first, like development dependency, after I run yarn eslint --init, I choose the options and when ask to downgrade, I put yes and install everything. Until then, works fine but in the repository I was working, master doesn\'t have .eslintrc because of .gitignore. After a merge and push, eslintrc was deleted. I removed .eslintrc from .gitignore, installed again in my branch, and master had eslint again. Everything works fine until I did a git push.\r\nAgain, I thought it was because of my mistake in master repo. I deleted node_modules, .eslintrc, removed from package.json, make from the start and still not working. I don\'t know why it is happening even I make installation from start.', 'this is Job requirements');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs_postings`
--
ALTER TABLE `jobs_postings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs_postings`
--
ALTER TABLE `jobs_postings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
