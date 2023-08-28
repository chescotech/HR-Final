-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2022 at 12:33 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `allowances_tb`
--

CREATE TABLE `allowances_tb` (
  `id` int(12) NOT NULL,
  `company_id` int(12) NOT NULL,
  `house_allowance` int(12) NOT NULL,
  `transport_allowance` int(12) NOT NULL,
  `lunch_allowance` int(12) NOT NULL,
  `emp_no` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allowances_tb`
--

INSERT INTO `allowances_tb` (`id`, `company_id`, `house_allowance`, `transport_allowance`, `lunch_allowance`, `emp_no`) VALUES
(2, 4, 1723, 450, 400, 'FAB371'),
(3, 4, 2142, 450, 400, 'FAB317'),
(4, 4, 3850, 2272, 500, 'FAB327'),
(5, 4, 5075, 2272, 500, 'FAB181'),
(6, 4, 5390, 2272, 500, 'FAB344'),
(7, 4, 2299, 450, 400, 'FAB210'),
(8, 4, 5180, 2272, 500, 'FAB192'),
(9, 4, 3080, 1818, 500, 'FAB396'),
(10, 4, 8900, 1818, 500, 'FAB389'),
(11, 4, 1723, 450, 400, 'FAB364'),
(12, 4, 4900, 1818, 500, 'FAB132'),
(13, 4, 2012, 450, 400, 'FAB325'),
(14, 4, 2155, 450, 400, 'FAB339'),
(15, 4, 1154, 450, 400, 'FAB407'),
(16, 4, 1880, 450, 400, 'FAB212'),
(17, 4, 2180, 450, 400, 'FAB290'),
(18, 4, 3150, 1818, 500, 'FAB297'),
(19, 4, 4725, 1818, 500, 'FAB338'),
(20, 4, 1802, 450, 400, 'FAB307'),
(21, 4, 14700, 10000, 500, 'FAB345'),
(22, 4, 5285, 2272, 500, 'FAB187'),
(23, 4, 1583, 450, 400, 'FAB379'),
(24, 4, 6195, 4544, 500, 'FAB072'),
(25, 4, 29000, 10700, 0, 'FAB406'),
(26, 4, 2107, 450, 400, 'FAB340'),
(27, 4, 1513, 450, 400, 'FAB373'),
(28, 4, 2919, 450, 400, 'FAB404'),
(29, 4, 1677, 450, 400, 'FAB398'),
(30, 4, 5145, 2727, 500, 'FAB320'),
(31, 4, 1723, 450, 400, 'FAB362'),
(32, 4, 4375, 1818, 500, 'FAB205'),
(33, 4, 3430, 1818, 500, 'FAB410'),
(34, 4, 2975, 1818, 500, 'FAB411'),
(35, 4, 0, 40000, 0, 'FAB413'),
(36, 4, 1817, 600, 500, 'FAB378'),
(37, 4, 3570, 1818, 500, 'FAB380'),
(38, 4, 2625, 600, 500, 'FAB415'),
(39, 4, 2325, 600, 500, 'FAB416'),
(40, 4, 4200, 1818, 500, 'FAB422'),
(41, 4, 2625, 600, 500, 'FAB423'),
(42, 4, 3325, 2272, 500, 'FAB424'),
(43, 4, 0, 115250, 0, 'FAB425'),
(44, 4, 3325, 1818, 500, 'FAB395'),
(45, 4, 8085, 4544, 500, 'FAB039'),
(46, 4, 1750, 900, 500, 'FAB421'),
(47, 4, 350, 450, 400, 'FAB431'),
(48, 4, 2800, 1818, 500, 'FAB432'),
(49, 4, 2800, 1818, 500, 'FAB433'),
(50, 4, 6475, 2272, 500, 'FAB067'),
(51, 4, 1723, 450, 400, 'FAB349'),
(52, 4, 1723, 450, 400, 'FAB365'),
(53, 4, 1232, 335, 310, 'FAB393'),
(54, 4, 3500, 1818, 500, 'FAB399'),
(55, 4, 2835, 1818, 500, 'FAB055'),
(56, 4, 1372, 450, 400, 'FAB401'),
(57, 4, 1723, 450, 400, 'FAB363'),
(58, 4, 3955, 1818, 500, 'FAB186'),
(59, 4, 1723, 450, 400, 'FAB368'),
(60, 4, 1697, 450, 400, 'FAB376'),
(61, 4, 5600, 2272, 500, 'FAB324'),
(62, 4, 2380, 1818, 500, 'FAB321'),
(63, 4, 1971, 450, 400, 'FAB332'),
(64, 4, 3395, 1818, 500, 'FAB087'),
(65, 4, 1830, 450, 400, 'FAB286'),
(66, 4, 4918, 2272, 500, 'FAB158'),
(67, 4, 1858, 450, 400, 'FAB356'),
(68, 4, 2054, 450, 400, 'FAB299'),
(69, 4, 3500, 1818, 500, 'FAB259'),
(70, 4, 1872, 450, 400, 'FAB223'),
(71, 4, 1817, 600, 500, 'FAB377'),
(72, 4, 1972, 450, 400, 'FAB354'),
(73, 4, 1014, 450, 400, 'FAB412'),
(74, 4, 1014, 450, 400, 'FAB408'),
(75, 4, 1014, 450, 400, 'FAB409'),
(76, 4, 1014, 450, 400, 'FAB402'),
(77, 4, 1014, 450, 400, 'FAB417'),
(78, 4, 1014, 450, 400, 'FAB420'),
(79, 4, 1723, 450, 400, 'FAB056'),
(80, 4, 2070, 450, 400, 'FAB128'),
(81, 4, 2485, 1818, 500, 'FAB219'),
(82, 4, 2033, 450, 400, 'FAB309'),
(83, 4, 2096, 450, 400, 'FAB273'),
(84, 4, 1846, 450, 400, 'FAB314'),
(85, 4, 3395, 1818, 500, 'FAB263'),
(86, 4, 1991, 450, 400, 'FAB343'),
(87, 4, 6615, 2726, 500, 'FAB078'),
(88, 4, 2555, 1818, 500, 'FAB252'),
(89, 4, 1214, 450, 400, 'FAB385'),
(90, 4, 1372, 450, 400, 'FAB392'),
(91, 4, 2229, 450, 400, 'FAB204'),
(92, 4, 1014, 450, 400, 'FAB419'),
(93, 4, 2975, 1817, 500, 'FAB153'),
(94, 4, 2159, 450, 400, 'FAB189'),
(95, 4, 2000, 450, 400, 'FAB304'),
(96, 4, 1900, 450, 400, 'FAB179'),
(97, 4, 1564, 450, 400, 'FAB387'),
(98, 4, 2012, 450, 400, 'FAB329'),
(99, 4, 5005, 1818, 500, 'FAB045'),
(100, 4, 2084, 450, 400, 'FAB020'),
(101, 4, 2474, 450, 400, 'FAB047'),
(102, 4, 1858, 450, 400, 'FAB351'),
(103, 4, 5110, 2272, 500, 'FAB092'),
(104, 4, 1723, 450, 400, 'FAB360'),
(105, 4, 2167, 450, 400, 'FAB272'),
(106, 4, 1372, 335, 310, 'FAB388'),
(107, 4, 2250, 450, 400, 'FAB337'),
(108, 4, 2012, 450, 400, 'FAB334'),
(109, 4, 2016, 450, 400, 'FAB091'),
(110, 4, 1858, 450, 400, 'FAB250'),
(111, 4, 4130, 1817, 500, 'FAB150'),
(112, 4, 2159, 450, 400, 'FAB200'),
(113, 4, 2096, 450, 400, 'FAB279'),
(114, 4, 2167, 450, 400, 'FAB266'),
(115, 4, 2012, 450, 400, 'FAB331'),
(116, 4, 2222, 450, 400, 'FAB220'),
(117, 4, 1014, 450, 400, 'FAB418'),
(118, 4, 2500, 0, 0, 'CT01'),
(119, 4, 1000, 0, 0, 'CT02'),
(120, 4, 1000, 1000, 0, 'CT03'),
(121, 4, 2000, 1000, 1000, 'CT04'),
(122, 4, 2500, 0, 0, 'CT05'),
(123, 4, 3000, 2000, 0, 'CT06'),
(124, 4, 0, 0, 0, 'CT07'),
(125, 4, 6000, 2000, 2000, 'CT08');

-- --------------------------------------------------------

--
-- Table structure for table `appeal_notices`
--

CREATE TABLE `appeal_notices` (
  `id` int(11) NOT NULL,
  `appeal_notice` text NOT NULL,
  `empno` varchar(22) NOT NULL,
  `bossno` varchar(22) NOT NULL,
  `bossmail` varchar(222) NOT NULL,
  `app_id` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `posting_id` int(11) NOT NULL,
  `name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `mobile` varchar(222) NOT NULL,
  `cover` varchar(222) NOT NULL,
  `cv` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `appover_groups`
--

CREATE TABLE `appover_groups` (
  `id` int(12) NOT NULL,
  `work_flow_id` int(12) NOT NULL,
  `level` int(12) NOT NULL,
  `date_created` date NOT NULL,
  `empno` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appover_groups`
--

INSERT INTO `appover_groups` (`id`, `work_flow_id`, `level`, `date_created`, `empno`) VALUES
(20, 1, 3, '0000-00-00', 'LMP03'),
(21, 2, 1, '0000-00-00', 'LMP05'),
(23, 3, 1, '0000-00-00', 'LMP07'),
(24, 3, 2, '0000-00-00', 'LMP05'),
(25, 19, 1, '0000-00-00', 'LMP07'),
(26, 1, 1, '0000-00-00', 'ps'),
(27, 1, 2, '0000-00-00', 'LMP05'),
(28, 4, 1, '0000-00-00', 'FAB406'),
(29, 4, 1, '0000-00-00', 'CT06');

-- --------------------------------------------------------

--
-- Table structure for table `app_rating`
--

CREATE TABLE `app_rating` (
  `id` int(11) NOT NULL,
  `from_` varchar(50) NOT NULL,
  `to_` varchar(50) NOT NULL,
  `rank` varchar(222) NOT NULL,
  `recommendation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ass_appraisals`
--

CREATE TABLE `ass_appraisals` (
  `id` int(11) NOT NULL,
  `bossno` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `params_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `factor_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `ass_group` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ass_appraisals`
--

INSERT INTO `ass_appraisals` (`id`, `bossno`, `date`, `params_id`, `period_id`, `factor_id`, `dept_id`, `ass_group`) VALUES
(7, 'CT06', '2022-04-30 11:18:26', 4, 1, 6, 38, 'Business Development Team'),
(8, 'CT06', '2022-04-30 11:18:46', 6, 1, 3, 38, 'Business Development Team'),
(9, 'CT06', '2022-04-30 11:19:13', 8, 1, 4, 38, 'Business Development Team'),
(11, 'CT06', '2022-04-30 11:20:23', 9, 1, 4, 38, 'Business Development Team'),
(22, 'CT06', '2022-05-06 15:24:17', 4, 2, 6, 38, 'Business Development Team'),
(23, 'CT06', '2022-05-06 15:24:36', 6, 2, 3, 38, 'Business Development Team'),
(24, 'CT06', '2022-05-06 15:24:50', 8, 2, 7, 38, 'Business Development Team'),
(25, 'CT06', '2022-05-06 15:25:06', 9, 2, 4, 38, 'Business Development Team'),
(26, 'CT06', '2022-05-06 15:25:23', 7, 2, 7, 38, 'Business Development Team'),
(27, 'CT06', '2022-05-06 15:27:11', 4, 3, 5, 38, 'May IT Group'),
(28, 'CT06', '2022-05-06 15:27:23', 5, 3, 5, 38, 'May IT Group'),
(29, 'CT06', '2022-05-06 15:29:50', 7, 3, 7, 38, 'May IT Group'),
(30, 'CT06', '2022-05-06 15:37:05', 8, 3, 7, 38, 'May IT Group'),
(31, 'CT06', '2022-05-06 15:37:23', 9, 3, 4, 38, 'May IT Group');

-- --------------------------------------------------------

--
-- Table structure for table `ass_emp_appraisals`
--

CREATE TABLE `ass_emp_appraisals` (
  `id` int(11) NOT NULL,
  `ass_app_id` int(11) NOT NULL,
  `empno` varchar(50) NOT NULL,
  `own_score` varchar(55) NOT NULL,
  `boss_score` varchar(55) NOT NULL,
  `total_score` varchar(55) NOT NULL,
  `comment` text NOT NULL,
  `boss_comment` text NOT NULL,
  `emp_expectation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ass_factors`
--

CREATE TABLE `ass_factors` (
  `id` int(11) NOT NULL,
  `name` varchar(222) NOT NULL,
  `target` varchar(50) NOT NULL,
  `dept` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ass_factors`
--

INSERT INTO `ass_factors` (`id`, `name`, `target`, `dept`) VALUES
(3, 'Business Development', '10 ', 0),
(4, 'Innovation', '10', 0),
(5, 'Time Management', '10', 0),
(6, 'Attendance', '10', 0),
(7, 'Learning and Growth', '10', 0),
(9, 'ok', '20', 38);

-- --------------------------------------------------------

--
-- Table structure for table `ass_group`
--

CREATE TABLE `ass_group` (
  `id` int(11) NOT NULL,
  `name` varchar(222) NOT NULL,
  `empno` varchar(20) NOT NULL,
  `bossno` varchar(20) NOT NULL,
  `dept` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ass_group`
--

INSERT INTO `ass_group` (`id`, `name`, `empno`, `bossno`, `dept`) VALUES
(20, 'test', 'CT05', 'CT06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ass_params`
--

CREATE TABLE `ass_params` (
  `id` int(11) NOT NULL,
  `name` varchar(222) NOT NULL,
  `weight` varchar(222) NOT NULL,
  `dept` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ass_params`
--

INSERT INTO `ass_params` (`id`, `name`, `weight`, `dept`) VALUES
(4, 'Reporting to work on Time.', '10', 0),
(5, 'Ability to meet Deadlines and complete work within the required period of time.', '10', 0),
(6, 'Ability to meet Targets given to you per month, per Quoter or Annually. ', '10', 0),
(7, 'Accuracy of your work, consistency and ability to work smart.', '10', 0),
(8, 'Learning new things, new technologies, new business development skills or others', '10', 0),
(9, 'Innovation and bringing new ideas to products , procedures and company activities.', '10', 0),
(11, 'test', '2', 38);

-- --------------------------------------------------------

--
-- Table structure for table `ass_periods`
--

CREATE TABLE `ass_periods` (
  `id` int(11) NOT NULL,
  `name` varchar(222) NOT NULL,
  `status` varchar(222) NOT NULL,
  `date` varchar(50) NOT NULL,
  `date_from` varchar(50) NOT NULL,
  `dept` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ass_periods`
--

INSERT INTO `ass_periods` (`id`, `name`, `status`, `date`, `date_from`, `dept`) VALUES
(2, 'Business Development May Appraisal 2022', 'Open', '2022-05-31', '2022-05-01', 0),
(3, 'Software Developers May Appraisal', 'Open', '2022-05-31', '2022-05-01', 0),
(4, 'choolwe ngandu', 'Open', '2022-07-29', '2022-07-29', 50),
(5, 'Cima Zambia', 'Open', '2022-07-31', '2022-07-25', 38);

-- --------------------------------------------------------

--
-- Table structure for table `attendance_logs`
--

CREATE TABLE `attendance_logs` (
  `id` int(12) NOT NULL,
  `log_date` text NOT NULL,
  `login_time` text NOT NULL,
  `logout_time` text NOT NULL,
  `empno` text NOT NULL,
  `company_id` text NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_logs`
--

INSERT INTO `attendance_logs` (`id`, `log_date`, `login_time`, `logout_time`, `empno`, `company_id`, `comment`) VALUES
(1, '2022/04/29', '2022-04-29 14:40:59', '', 'CT06', '4', ''),
(2, '2022/05/09', '2022-05-09 09:05:01', '', 'CT03', '4', ''),
(3, '2022/05/10', '2022-05-10 08:15:50', '2022-05-10 17:01:03', 'CT01', '4', ''),
(4, '2022/05/10', '2022-05-10 08:31:52', '2022-05-10 17:21:10', 'CT05', '4', ''),
(5, '2022/05/10', '2022-05-10 08:53:26', '2022-05-10 17:13:04', 'CT04', '4', ''),
(6, '2022/05/11', '2022-05-11 08:07:04', '2022-05-11 17:10:31', 'CT03 ', '4', ''),
(7, '2022/05/11', '2022-05-11 08:18:55', '', 'CT04', '4', ''),
(8, '2022/05/11', '2022-05-11 08:19:35', '2022-05-11 17:06:16', 'CT05', '4', ''),
(9, '2022/05/11', '2022-05-11 08:53:56', '', 'CT01', '4', 'Forgot to log out on the 11th of May and forgot to check in on the 12th of May but will be checking in and checking out shortly'),
(10, '2022/05/12', '2022-05-12 08:03:54', '2022-05-12 17:23:20', 'CT03 ', '4', ''),
(11, '2022/05/12', '2022-05-12 08:26:19', '2022-05-12 17:02:04', 'CT04', '4', ''),
(12, '2022/05/12', '2022-05-12 08:44:42', '2022-05-12 17:09:18', 'CT05', '4', ''),
(13, '2022/05/12', '2022-05-12 08:44:42', '2022-05-12 17:09:18', 'CT05', '4', ''),
(14, '2022/05/12', '2022-05-12 09:39:59', '2022-05-12 17:06:55', 'CT02', '4', ''),
(15, '2022/05/12', '2022-05-12 17:03:36', '', 'CT01', '4', 'experienced challenge with the system'),
(16, '2022/05/12', '2022-05-12 17:03:52', '', 'CT01', '4', 'experienced challenge with the system'),
(17, '2022/05/13', '2022-05-13 07:52:54', '', 'CT04', '4', ''),
(18, '2022/05/13', '2022-05-13 07:58:42', '', 'CT02', '4', ''),
(19, '2022/05/13', '2022-05-13 08:04:53', '2022-05-13 17:28:06', 'CT03 ', '4', ''),
(20, '2022/05/13', '2022-05-13 08:38:09', '2022-05-13 17:03:56', 'CT05', '4', ''),
(21, '2022/05/14', '2022-05-14 08:06:23', '', 'CT04', '4', ''),
(22, '2022/05/14', '2022-05-14 08:15:01', '2022-05-14 13:02:41', 'CT05', '4', ''),
(23, '2022/05/14', '2022-05-14 08:23:49', '2022-05-14 14:13:12', 'CT03 ', '4', ''),
(24, '2022/05/16', '2022-05-16 07:44:12', '2022-05-16 17:11:25', 'CT02', '4', ''),
(25, '2022/05/16', '2022-05-16 07:46:19', '2022-05-16 18:24:31', 'CT04', '4', ''),
(26, '2022/05/16', '2022-05-16 08:36:57', '2022-05-16 17:09:05', 'CT05', '4', ''),
(27, '2022/05/16', '2022-05-16 08:56:17', '2022-05-16 17:59:46', 'CT03', '4', ''),
(28, '2022/05/16', '2022-05-16 09:19:16', '2022-05-16 17:05:07', 'CT01', '4', 'did not login on 17th as i was experiencing challenges to log in\r\n'),
(29, '2022/05/17', '2022-05-17 07:18:39', '2022-05-17 17:29:27', 'CT04', '4', ''),
(30, '2022/05/17', '2022-05-17 08:28:59', '2022-05-17 17:30:23', 'CT03', '4', ''),
(31, '2022/05/17', '2022-05-17 08:31:49', '2022-05-17 17:14:50', 'CT05', '4', ''),
(32, '2022/05/18', '2022-05-18 07:53:14', '2022-05-18 17:08:59', 'CT02', '4', ''),
(33, '2022/05/18', '2022-05-18 08:04:30', '2022-05-18 18:14:02', 'CT04', '4', ''),
(34, '2022/05/18', '2022-05-18 08:20:12', '2022-05-18 17:41:28', 'CT03 ', '4', ''),
(35, '2022/05/18', '2022-05-18 08:41:45', '2022-05-18 17:10:44', 'CT05', '4', ''),
(36, '2022/05/18', '2022-05-18 08:58:46', '2022-05-18 17:55:43', 'CT01', '4', ''),
(37, '2022/05/19', '2022-05-19 07:36:19', '2022-05-19 16:11:38', 'CT02', '4', ''),
(38, '2022/05/19', '2022-05-19 08:04:34', '', 'CT04', '4', ''),
(39, '2022/05/19', '2022-05-19 08:19:37', '2022-05-19 17:10:23', 'CT05', '4', ''),
(40, '2022/05/19', '2022-05-19 08:22:24', '', 'CT03 ', '4', ''),
(41, '2022/05/19', '2022-05-19 08:38:01', '', 'CT01', '4', 'forgot to check out'),
(42, '2022/05/20', '2022-05-20 07:24:31', '2022-05-20 17:59:58', 'CT04', '4', ''),
(43, '2022/05/20', '2022-05-20 08:19:34', '2022-05-20 16:52:54', 'CT03 ', '4', ''),
(44, '2022/05/20', '2022-05-20 08:24:39', '2022-05-20 17:14:53', 'CT05', '4', ''),
(45, '2022/05/20', '2022-05-20 08:27:19', '2022-05-20 17:31:56', 'CT01', '4', ''),
(46, '2022/05/21', '2022-05-21 07:55:51', '', 'CT04', '4', ''),
(47, '2022/05/21', '2022-05-21 08:16:58', '', 'CT03', '4', ''),
(48, '2022/05/21', '2022-05-21 08:35:26', '', 'CT05', '4', ''),
(49, '2022/05/21', '2022-05-21 10:42:29', '', 'CT01', '4', ''),
(50, '2022/07/06', '2022-07-06 13:52:01', '', 'CT06', '4', '');

-- --------------------------------------------------------

--
-- Table structure for table `band_tb`
--

CREATE TABLE `band_tb` (
  `id` int(12) NOT NULL,
  `top_band` int(12) NOT NULL,
  `band_percentage` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `band_tb`
--

INSERT INTO `band_tb` (`id`, `top_band`, `band_percentage`) VALUES
(1, 3000, 0),
(2, 3800, 0.25),
(3, 5900, 0.3),
(4, 6000, 0.35);

-- --------------------------------------------------------

--
-- Table structure for table `certificates_tb`
--

CREATE TABLE `certificates_tb` (
  `id` int(12) NOT NULL,
  `cv` text NOT NULL,
  `qualifications` text NOT NULL,
  `date_uploaded` text NOT NULL,
  `status` text NOT NULL,
  `empno` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `certificates_tb`
--

INSERT INTO `certificates_tb` (`id`, `cv`, `qualifications`, `date_uploaded`, `status`, `empno`) VALUES
(4, 'ctl015-cv_choolwe_ngandu.pdf', 'ctl015-degree-choolwe-ngandu.pdf', '2017-01-09', 'pending', 'CTL015'),
(5, 'ctl015-belina-inspire-brochure-zambia.pdf', 'ctl015-belina-time-control-brochure-zambia.pdf', '2017-01-14', 'pending', 'CTL015'),
(6, 'ctl015-invoice.pdf', 'ctl015-invoice.pdf', '2017-08-19', 'pending', 'CTL015'),
(7, 'ps-pending-cbf-issues.pdf', 'ps-pending-cbf-issues.pdf', '2022-02-25', 'pending', 'ps');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `class_coment`
--

CREATE TABLE `class_coment` (
  `content_id` int(11) NOT NULL,
  `generated_time` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `content_by` int(11) NOT NULL,
  `published` int(11) NOT NULL DEFAULT '0',
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_gid`
--

CREATE TABLE `class_gid` (
  `clgid` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `gid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_ID` int(10) NOT NULL,
  `name` varchar(90) NOT NULL,
  `address` varchar(90) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(20) NOT NULL,
  `logo` text NOT NULL,
  `date_registration` text NOT NULL,
  `status` text NOT NULL,
  `_key` text NOT NULL,
  `lati` text NOT NULL,
  `longi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_ID`, `name`, `address`, `phone`, `email`, `username`, `password`, `logo`, `date_registration`, `status`, `_key`, `lati`, `longi`) VALUES
(4, 'Chesco Technologies ', 'lusaka', '00', 'alliance@com', 'Samis', 'inn0v8', 'mobile_champ.png', '', 'active', '5913-1950-0012-0155-2702-2022', '15.4140672', '28.3017216');

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `ded_id` int(6) NOT NULL,
  `deduction_name` varchar(90) DEFAULT NULL,
  `company_ID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`ded_id`, `deduction_name`, `company_ID`) VALUES
(1, 'Medical', 0),
(2, 'Personal Loan', 0),
(3, 'Car Loan', 0),
(4, 'Salary Advance', 0),
(5, 'Medical', 0),
(6, 'Personal Loan', 0),
(7, 'Car Loan', 0),
(8, 'Salary Advance', 0);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dep_id` int(7) NOT NULL,
  `department` varchar(50) NOT NULL,
  `company_ID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dep_id`, `department`, `company_ID`) VALUES
(38, 'Information Technology Department', '4'),
(50, 'MARKETING', '4'),
(52, 'Call Centre', '4');

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `ID` int(6) NOT NULL,
  `earning_name` varchar(90) DEFAULT NULL,
  `company_ID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `earnings`
--

INSERT INTO `earnings` (`ID`, `earning_name`, `company_ID`) VALUES
(1, 'Basic Pay', '4'),
(2, 'Transport Allowance', '4'),
(3, 'Housing Allowance', '4'),
(4, 'Commission Earned', '4'),
(5, 'Basic Pay', '5'),
(6, 'Transport Allowance', '5'),
(7, 'Housing Allowance', '5'),
(8, 'Commission Earned', '5');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(90) NOT NULL,
  `empno` varchar(100) NOT NULL,
  `pay` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `dayswork` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `otrate` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `othrs` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `allow` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `advances` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `insurance` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `time` date NOT NULL,
  `comission` decimal(10,0) NOT NULL,
  `company_id` varchar(20) NOT NULL,
  `health_insurance` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `empno`, `pay`, `dayswork`, `otrate`, `othrs`, `allow`, `advances`, `insurance`, `time`, `comission`, `company_id`, `health_insurance`) VALUES
(87, 'CT05', '5000.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-07-31', '0', '4', '25'),
(86, 'CT02', '3500.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-07-31', '0', '4', '25'),
(85, 'CT01', '7500.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-07-31', '0', '4', '50'),
(84, 'CT03', '5000.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-07-31', '0', '4', '30'),
(83, 'CT04', '7000.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-07-31', '0', '4', '30'),
(75, 'CT04', '7000.00', 26, '1000.00', 1, '0.00', '0.00', '0.00', '2022-06-30', '0', '4', '30'),
(76, 'CT03', '5000.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-06-30', '0', '4', '30'),
(77, 'CT01', '7500.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-06-30', '0', '4', '50'),
(78, 'CT02', '3500.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-06-30', '0', '4', '25'),
(79, 'CT05', '5000.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-06-30', '0', '4', '25'),
(80, 'CT06', '10000.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-06-30', '0', '4', '50'),
(81, 'CT07', '1500.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-06-30', '0', '4', '15'),
(82, 'CT08', '12300.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-06-30', '0', '4', '23'),
(58, 'CT06', '10000.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-05-31', '0', '4', '50'),
(57, 'CT05', '5000.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-05-31', '0', '4', '25'),
(56, 'CT02', '3500.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-05-31', '0', '4', '25'),
(55, 'CT01', '7500.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-05-31', '0', '4', '50'),
(54, 'CT03', '5000.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-05-31', '0', '4', '30'),
(53, 'CT04', '7000.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-05-31', '0', '4', '30'),
(88, 'CT06', '10000.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-07-31', '0', '4', '50'),
(89, 'CT07', '1500.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-07-31', '0', '4', '15'),
(90, 'CT08', '12300.00', 26, '0.00', 0, '0.00', '0.00', '0.00', '2022-07-31', '0', '4', '23');

-- --------------------------------------------------------

--
-- Table structure for table `employee_discplinary_records`
--

CREATE TABLE `employee_discplinary_records` (
  `id` int(12) NOT NULL,
  `empno` text NOT NULL,
  `date_charged` text NOT NULL,
  `charged_til` varchar(50) NOT NULL,
  `offence_commited` text NOT NULL,
  `case_status` text NOT NULL,
  `close_date` text NOT NULL,
  `punishment` text NOT NULL,
  `charged_by` text NOT NULL,
  `file` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_discplinary_records`
--

INSERT INTO `employee_discplinary_records` (`id`, `empno`, `date_charged`, `charged_til`, `offence_commited`, `case_status`, `close_date`, `punishment`, `charged_by`, `file`) VALUES
(1, 'FAB421', '03/31/2022', '03/31/2022', 'Some offence', 'expired', '', '1212s', '1212saa', 'UAT.pdf'),
(2, 'FAB421', '03/31/2022', '03/31/2022', 'Some offence', 'expired', '', '1212s', '1212saa', 'UAT.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `employee_exits_tb`
--

CREATE TABLE `employee_exits_tb` (
  `id` int(12) NOT NULL,
  `empno` text NOT NULL,
  `reason_for_exit` text NOT NULL,
  `date_of_exit` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_exits_tb`
--

INSERT INTO `employee_exits_tb` (`id`, `empno`, `reason_for_exit`, `date_of_exit`) VALUES
(1, 'LMP02', 'Dismissed', '09/01/2021'),
(2, 'LMP030', 'Dismissed', '09/01/2021'),
(3, 'LMP01', 'Dismissed', '09/01/2021'),
(4, 'LMP026', 'Dismissed', '09/01/2021'),
(5, 'LMP04', 'Dismissed', '09/01/2021'),
(6, 'LMP03', 'Dismissed', '09/01/2021'),
(7, 'FAB317', 'Discharge', '04/10/2022');

-- --------------------------------------------------------

--
-- Table structure for table `emp_edu_info_tb`
--

CREATE TABLE `emp_edu_info_tb` (
  `id` int(12) NOT NULL,
  `emp_id` text NOT NULL,
  `highest_qualifications` text NOT NULL,
  `qualifications` text NOT NULL,
  `university` text NOT NULL,
  `secondary_school` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_edu_info_tb`
--

INSERT INTO `emp_edu_info_tb` (`id`, `emp_id`, `highest_qualifications`, `qualifications`, `university`, `secondary_school`, `status`) VALUES
(1, 'CTL015', 'Degree', 'Bachelor Computer Science', 'Mulungushi University ', 'Mkushi High school ', 'Approved'),
(2, 'ps', 'Diploma', 'Diploma cool', 'Colw', 'Qwe', 'Approved'),
(3, 'ps', 'Masters Degree', 'Degrees cool', 'Uni', 'Same Old', 'Approved'),
(4, 'LMP07', 'Grade 12', 'Degree Computer Science', '', '', 'Approved'),
(5, 'LMP07', 'Diploma', 'Degree Computer Science ZCAS', '', '', 'Approved'),
(6, 'LMP07', 'Masters Degrees', 'Degree Computer Science', '', '', 'Approved'),
(7, 'LMP07', 'Professorship', 'Degree Computer Science', '', '', 'Approved'),
(8, 'FAB349', 'DIPLOMA', 'BANKING AND FINANCE', 'ZAMBIA INSTITUTE OF BANKING AND FINANCIAL SERVICES', 'NKUMBI INTERNATIONAL COLLEGE', ''),
(9, 'FAB349', 'Degree', 'BACHELORS DEGREE IN BUSINESS ADMINISTRATION', 'UNIVERSITY OF LUSAKA', 'NKUMBI INTERNATIONAL COLLEGE', ''),
(10, 'FAB363', '--select your highest qualification--', 'BUSINESS ADMINISTRATION ', '', '', ''),
(11, 'FAB378', 'Degree', 'Bachelor of Accounting and Finance', 'University of Zambia', 'Mpelembe Secondary School', '');

-- --------------------------------------------------------

--
-- Table structure for table `emp_history_tb`
--

CREATE TABLE `emp_history_tb` (
  `id` int(12) NOT NULL,
  `emp_id` text NOT NULL,
  `employer_one` text NOT NULL,
  `position_one` text NOT NULL,
  `date_start_one` text NOT NULL,
  `date_end_one` text NOT NULL,
  `employer_two` text NOT NULL,
  `position_two` text NOT NULL,
  `date_start_two` text NOT NULL,
  `date_end_two` text NOT NULL,
  `employer_three` text NOT NULL,
  `position_three` text NOT NULL,
  `date_start_three` text NOT NULL,
  `date_end_three` text NOT NULL,
  `employer_four` varchar(222) NOT NULL,
  `position_four` varchar(222) NOT NULL,
  `date_start_four` varchar(222) NOT NULL,
  `date_end_four` varchar(222) NOT NULL,
  `employer_five` varchar(222) NOT NULL,
  `position_five` varchar(222) NOT NULL,
  `date_start_five` varchar(222) NOT NULL,
  `date_end_five` varchar(222) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_history_tb`
--

INSERT INTO `emp_history_tb` (`id`, `emp_id`, `employer_one`, `position_one`, `date_start_one`, `date_end_one`, `employer_two`, `position_two`, `date_start_two`, `date_end_two`, `employer_three`, `position_three`, `date_start_three`, `date_end_three`, `employer_four`, `position_four`, `date_start_four`, `date_end_four`, `employer_five`, `position_five`, `date_start_five`, `date_end_five`, `status`) VALUES
(1, 'ps', 'Comp 1', 'Intern', '01/01/2020', '02/01/2020', 'Comp 2', 'Junior Assistant', '01/02/2020', '02/25/2022', 'Comp 3', 'Senior Assistant', '02/01/2022', '02/15/2022', '', '', '', '', 'Comp 5', 'Executive Assistant', '02/01/2022', '02/25/2022', 'Approved'),
(2, 'LMP07', 'Examinations Council of Zambia', 'CEO', '02/25/2022', '02/25/2022', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Approved'),
(3, 'FAB349', 'BENCHMARK INSURANCE BROKER', 'ASSISTANT ACCOUNTANT', '01/01/2013', '01/31/2014', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `emp_info`
--

CREATE TABLE `emp_info` (
  `id` int(90) NOT NULL,
  `empno` varchar(90) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `init` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `bdate` date NOT NULL,
  `dept` varchar(30) NOT NULL,
  `position` varchar(45) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `address` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `personal_email` varchar(222) NOT NULL,
  `bank` varchar(20) NOT NULL,
  `account` text NOT NULL,
  `date_joined` date NOT NULL,
  `date_left` text NOT NULL,
  `employee_grade` varchar(20) NOT NULL,
  `marital_status` varchar(10) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `leave_days` int(90) NOT NULL,
  `company_id` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `basic_pay` text NOT NULL,
  `gross_pay` text NOT NULL,
  `nok_phone` varchar(222) NOT NULL,
  `nok_name` varchar(222) NOT NULL,
  `nok_relationship` varchar(222) NOT NULL,
  `nok_email` varchar(222) NOT NULL,
  `nok_address` varchar(222) NOT NULL,
  `NRC` text NOT NULL,
  `employment_type` text NOT NULL,
  `probation_deadline` text NOT NULL,
  `employee_type` text NOT NULL,
  `social` text NOT NULL,
  `branch_code` text NOT NULL,
  `has_gratuity` text NOT NULL,
  `gatuity_amount` text NOT NULL,
  `leaveworkflow_id` int(12) NOT NULL,
  `nrc_file` text NOT NULL,
  `next_kin_phone` text NOT NULL,
  `status` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_info`
--

INSERT INTO `emp_info` (`id`, `empno`, `photo`, `lname`, `fname`, `init`, `gender`, `bdate`, `dept`, `position`, `phone`, `address`, `email`, `personal_email`, `bank`, `account`, `date_joined`, `date_left`, `employee_grade`, `marital_status`, `payment_method`, `leave_days`, `company_id`, `password`, `basic_pay`, `gross_pay`, `nok_phone`, `nok_name`, `nok_relationship`, `nok_email`, `nok_address`, `NRC`, `employment_type`, `probation_deadline`, `employee_type`, `social`, `branch_code`, `has_gratuity`, `gatuity_amount`, `leaveworkflow_id`, `nrc_file`, `next_kin_phone`, `status`) VALUES
(121, 'CT04', '', 'Chipimo', 'Melvin', ' Mr', 'male', '2022-04-29', '38', 'Software Engineer', '260 97 21602', 'Lusaka', 'melvin@chesco-tech.com', '', 'FNb', '00', '2022-04-29', '2022-04-29', 'CTL', 'Married', 'EFT', 0, '4', 'ba21817627bf2368e0bd2db2c4742847', '3000', '7000', 'Permanent', '.', 'na', 'na', '0975704991', 'na', 'Choolwe Ngandu', '', 'Full Time', '000', '000', '--Is Employee Eligible for Gratuity ?--', '', 4, '', '', ''),
(120, 'CT03', '', 'Kunda', 'Gift', ' Mr', 'male', '2022-04-29', '38', 'Software Engineer', '260 96 51570', 'Lusaka', 'gift@chesco-tech.com', '', 'Standard Charted Ban', '00', '2020-04-30', '2020-04-30', 'CTL', 'Single', 'EFT', 0, '4', '628631f07321b22d8c176c200c855e1b', '3000', '5000', 'Permanent', '.', 'na', 'na', '0975704991', 'NA', 'Choolwe Ngandu', '', 'Full Time', '000', '000', '--Is Employee Eligible for Gratuity ?--', '', 4, '', '', ''),
(118, 'CT01', '', 'Chilombe', 'Mainza', ' Mr', 'female', '2022-04-28', '50', ' Chief Operations Officer', '260 96 79424', 'Lusaka', 'mainza@chesco-tech.com', '', 'FNB', '000', '2022-01-31', '2022-01-31', 'CTL', 'Married', 'Bank Transfer', 0, '4', 'ba21817627bf2368e0bd2db2c4742847', '5000', '7500', 'Permanent', '.', 'na', 'na', '0975704991', 'NA', 'Choolwe Ngandu', '', 'Full Time', ' 00', '000', '--Is Employee Eligible for Gratuity ?--', '', 4, '', '', ''),
(119, 'CT02', '', 'Mwenda', 'Martin', ' Mr', 'male', '2022-04-29', '38', ' Client Support Specialist.', '260 97 68098', 'Lusaka', 'martin@chesco-tech.com', '', 'FNB', '000', '2020-01-01', '2020-01-01', 'CTL', 'Single', 'EFT', 0, '4', '9996535e07258a7bbfd8b132435c5962', '2500', '3500', 'Contract', '.', 'na', 'na', '0975704991', 'na', 'Choolwe Ngandu', '', 'Full Time', ' 0000', '000', 'No', '0', 4, '', '', ''),
(122, 'CT05', '', 'Zulu', 'Joseph', ' Mr', 'male', '2022-04-29', '38', 'Business Development Officer', '260 97 43012', 'Lusaka', 'joseph@chesco-tech.com', '', 'Stanbic Bank', '00', '2022-04-29', '2022-04-29', 'CTL', 'Single', 'EFT', 0, '4', 'ba21817627bf2368e0bd2db2c4742847', '2500', '5000', 'Permanent', '.', 'na', 'na', '0975704991', 'NA', 'Choolwe Ngandu', '', 'Full Time', '000', '000', '--Is Employee Eligible for Gratuity ?--', '', 4, '', '', ''),
(123, 'CT06', '', 'Ngandu', 'Choolwe', ' Mr', 'male', '1992-02-06', '38', 'Chief Executive Officer', '0975704991', 'Lusaka', 'choolwe@chesco-tech.com', '', 'choolwe ngandu', '00', '2012-04-29', '1970-01-01', 'CTL', 'Married', 'EFT', 0, '4', '21232f297a57a5a743894a0e4a801fc3', '5000', '10000', 'Permanent', '.', 'na', 'na', '0975704991', '256276/13/1', 'Choolwe Ngandu', '', 'Full Time', '000', '000', '--Is Employee Eligible for Gratuity ?--', '', 0, '', '', ''),
(124, 'CT07', '', 'Ngandu', 'Musa', ' Mr', 'male', '2022-06-22', '38', 'TEST ', '0955104708', 'Ndeke House Haile Salassie Avenue Longacres Lusaka', 'akashoka@moh.gov.zm', '', 'FNB', '2121', '2022-06-22', '1970-01-01', 'CTL', 'Married', 'C', 0, '4', 'ba21817627bf2368e0bd2db2c4742847', '1500', '1500', 'Permanent', 'Brother', 'choolwe1992@gmail.com', 'Lusaka.', '0000', '212121', 'choolwe ngandu', '', 'Full Time', '12121', '2121', '--Is Employee Eligible for Gratuity ?--', '', 0, '', '', ''),
(125, 'CT08', '', 'ngandun', 'choolwen', ' Mr', 'male', '2022-06-22', '50', 'Driver', '+26097570499', 'Lusaka.', 'choolwe1992@gmail.com', '', 'FNb', '2121212121', '2022-06-22', '2022-06-22', 'CTL', 'Married', 'Bank Transfer', 0, '4', 'ba21817627bf2368e0bd2db2c4742847', '2300', '12300', '12121', 'choolwe ngandu', 'Brother', 'choolwe1992@gmail.com', 'Lusaka.', '359939/10/1', 'Contract', '', 'Full Time', '2121', '000001', 'No', '', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `grade_id` int(10) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `maximum` int(20) NOT NULL,
  `minimum` int(20) NOT NULL,
  `company_ID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`grade_id`, `grade`, `maximum`, `minimum`, `company_ID`) VALUES
(14, 'CTL', 50000, 0, '4');

-- --------------------------------------------------------

--
-- Table structure for table `gratuity_settings_tb`
--

CREATE TABLE `gratuity_settings_tb` (
  `grat_id` int(12) NOT NULL,
  `rating` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gratuity_settings_tb`
--

INSERT INTO `gratuity_settings_tb` (`grat_id`, `rating`) VALUES
(1, '25');

-- --------------------------------------------------------

--
-- Table structure for table `hod_tb`
--

CREATE TABLE `hod_tb` (
  `id` int(12) NOT NULL,
  `empno` text NOT NULL,
  `departmentId` text NOT NULL,
  `companyID` int(12) NOT NULL,
  `parent_supervisor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hod_tb`
--

INSERT INTO `hod_tb` (`id`, `empno`, `departmentId`, `companyID`, `parent_supervisor`) VALUES
(14, 'CT06', '38', 4, 'CT06'),
(15, 'CT06', '50', 4, 'CT06'),
(16, 'CT06', '38', 4, 'CT06'),
(17, 'CT01', '50', 4, 'CT01');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(11) NOT NULL,
  `name` varchar(222) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `name`, `date`) VALUES
(4, 'New Year', '*-01-01'),
(5, 'International Womens Day', '*-03-08'),
(6, 'Youth Day', '*-03-12'),
(7, 'Good Friday', '2022-02-22'),
(8, 'Easter Monday', '*-04-18'),
(9, 'Labour Day', '*-05-01'),
(10, 'African Freedom Day', '*-05-25'),
(11, 'Heroes Day', '*-07-04'),
(12, 'Unity Day', '*-07-05'),
(13, 'Farmers Day', '*-08-01'),
(14, 'National Day of Prayer', '*-10-18'),
(15, 'Independence Day', '*-10-24'),
(16, 'Christmas Day', '*-12-25');

-- --------------------------------------------------------

--
-- Table structure for table `jobs_logs`
--

CREATE TABLE `jobs_logs` (
  `id` int(11) NOT NULL,
  `trans_name` text NOT NULL,
  `trans_by` int(11) NOT NULL,
  `trans_on` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_logs`
--

INSERT INTO `jobs_logs` (`id`, `trans_name`, `trans_by`, `trans_on`, `date`) VALUES
(1, 'Offer', 1, 0, '2022-04-23 14:23:28'),
(2, 'Phone Interview', 4, 4, '2022-04-25 17:38:03'),
(3, '1', 4, 4, '2022-04-26 16:37:47'),
(4, 'Hired', 4, 4, '2022-04-26 16:37:54');

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
(4, 'Call Centre Agent', 52, 1, 'Contract', '1', '2500', '5000', 'A college diploma or university degree. ', 'Unpublished', '2022-05-20 22:00:00', '2022-10-30', 'none', 'kwacha', 'Afganistan', 'Lusaka', 'lusaka', 'Job Requirements\nâ€¢ Customer relations:\nâ€¢ Managing conversations with customers in line with FIFâ€™s customer management standards in order to achieve satisfactory resolutions for both parties.\nâ€¢ Listening effectively to customers, and probing to understand their issues/objections, in order to overcome customersâ€™ objections by means of effective negotiations to achieve the desired result of promises to pay.\nâ€¢ Building a rapport with clients by\nâ€¢ Call Centre employees:\nâ€¢ Ensuring a harmonious working relationship with Call Centre employees (both peers and other employees irrespective of level if seniority) and working effectively in a team-based and highly regulated work environment by working accurately and towards clearly defined goals', 'Job Requirements\r\nâ€¢ Customer relations:\r\nâ€¢ Managing conversations with customers in line with FIFâ€™s customer management standards in order to achieve satisfactory resolutions for both parties.\r\nâ€¢ Listening effectively to customers, and probing to understand their issues/objections, in order to overcome customersâ€™ objections by means of effective negotiations to achieve the desired result of promises to pay.\r\nâ€¢ Building a rapport with clients by\r\nâ€¢ Call Centre employees:\r\nâ€¢ Ensuring a harmonious working relationship with Call Centre employees (both peers and other employees irrespective of level if seniority) and working effectively in a team-based and highly regulated work environment by working accurately and towards clearly defined goals');

-- --------------------------------------------------------

--
-- Table structure for table `jobs_posting_qualifications`
--

CREATE TABLE `jobs_posting_qualifications` (
  `id` int(11) NOT NULL,
  `job_posting_id` int(11) NOT NULL,
  `qualification` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_posting_qualifications`
--

INSERT INTO `jobs_posting_qualifications` (`id`, `job_posting_id`, `qualification`) VALUES
(2, 4, 'Diploma'),
(3, 4, 'BA'),
(4, 4, 'BSc'),
(5, 4, 'del');

-- --------------------------------------------------------

--
-- Table structure for table `jobs_posting_requirements`
--

CREATE TABLE `jobs_posting_requirements` (
  `id` int(11) NOT NULL,
  `job_posting_id` int(11) NOT NULL,
  `requirement` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_posting_requirements`
--

INSERT INTO `jobs_posting_requirements` (`id`, `job_posting_id`, `requirement`) VALUES
(1, 4, 'PHP'),
(2, 4, 'Nodejs'),
(3, 4, 'del');

-- --------------------------------------------------------

--
-- Table structure for table `jobs_users`
--

CREATE TABLE `jobs_users` (
  `id` int(11) NOT NULL,
  `fname` varchar(222) NOT NULL,
  `lname` varchar(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `dob` varchar(222) NOT NULL,
  `gender` varchar(22) NOT NULL,
  `phone` varchar(22) NOT NULL,
  `user_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_users`
--

INSERT INTO `jobs_users` (`id`, `fname`, `lname`, `username`, `email`, `password`, `dob`, `gender`, `phone`, `user_type`) VALUES
(1, 'John', 'Doe', 'admin', 'email@gmail.com', '7215ee9c7d9dc229d2921a40e899ec5f', '2007-02-05', 'Male', '0975704991', 'user'),
(2, 'Jane', 'Doe', 'janny', 'jenny@gmail.com', 'a01610228fe998f515a72dd730294d87', '2017-07-05', 'Female', '0976893431', ''),
(3, 'jay', 'bally', 'secure', 'email@gmail.com11', '7215ee9c7d9dc229d2921a40e899ec5f', '2022-04-05', 'Male', '122344354', ''),
(4, 'choolwe', 'ngandu', 'choolwe', 'choolwe1992@gmail.com', '7215ee9c7d9dc229d2921a40e899ec5f', '2022-04-30', 'Male', '0975704991', 'admin'),
(5, 'melvin chipimo', 'zambia', 'melvin', 'chipimo31@gmail.com', '202cb962ac59075b964b07152d234b70', '2022-04-30', 'Male', '+260972160250', 'admin'),
(7, 'melvin', 'chipimo', 'mel', 'chipimo31@gmail.com', '202cb962ac59075b964b07152d234b70', '2022-01-06', 'Male', '+260972160250', 'admin'),
(8, 'Gii', 'Kii', 'ttt', 'd@gmail.com', '7215ee9c7d9dc229d2921a40e899ec5f', '2022-04-18', 'Male', '54354356', ''),
(10, 'chesco', 'ngandu', 'chesco', 'choolwe1992@gmail.com', '7215ee9c7d9dc229d2921a40e899ec5f', '2022-04-25', 'Male', '0975704991', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `jobs_user_applications`
--

CREATE TABLE `jobs_user_applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jobs_job_id` int(11) NOT NULL,
  `job_status` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `talent_pool_id` int(12) NOT NULL,
  `disqualify_reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_user_applications`
--

INSERT INTO `jobs_user_applications` (`id`, `user_id`, `jobs_job_id`, `job_status`, `date`, `talent_pool_id`, `disqualify_reason`) VALUES
(3, 3, 4, 'Applied', '2022-07-08 07:26:59', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `jobs_user_attachments`
--

CREATE TABLE `jobs_user_attachments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(222) NOT NULL,
  `file` varchar(222) NOT NULL,
  `type` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_user_attachments`
--

INSERT INTO `jobs_user_attachments` (`id`, `user_id`, `name`, `file`, `type`) VALUES
(1, 3, 'Grade 7 School Certificate', 'UAT.pdf', 'Certification');

-- --------------------------------------------------------

--
-- Table structure for table `jobs_user_experience`
--

CREATE TABLE `jobs_user_experience` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `employer` varchar(222) NOT NULL,
  `comp_name` varchar(222) NOT NULL,
  `phone` varchar(22) NOT NULL,
  `position` varchar(222) NOT NULL,
  `starts` varchar(50) NOT NULL,
  `ends` varchar(50) NOT NULL,
  `duties` text NOT NULL,
  `achievement` text NOT NULL,
  `reasons_for_leavng` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_user_experience`
--

INSERT INTO `jobs_user_experience` (`id`, `user_id`, `employer`, `comp_name`, `phone`, `position`, `starts`, `ends`, `duties`, `achievement`, `reasons_for_leavng`) VALUES
(1, 3, 'Exodus Software Ltd.', 'Xandi Entech', '09787878', 'Soft Dev', '2022-04-02', '2022-04-27', 'Everything', 'A s!t load', 'I dont jnow'),
(2, 3, 'Chesco Tech', 'Chesco Tech', '1212121', 'Software Engineer', '2009-01-28', '2022-04-28', 'Development of Software Solutions,', '', 'no increments');

-- --------------------------------------------------------

--
-- Table structure for table `jobs_user_info`
--

CREATE TABLE `jobs_user_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `location` varchar(222) NOT NULL,
  `lang1` varchar(222) NOT NULL,
  `lang2` varchar(222) NOT NULL,
  `lang3` varchar(222) NOT NULL,
  `marital_status` varchar(22) NOT NULL,
  `disabilities` text NOT NULL,
  `memberships` text NOT NULL,
  `awards` text NOT NULL,
  `links` text NOT NULL,
  `salary` varchar(22) NOT NULL,
  `currency` varchar(22) NOT NULL,
  `expected_benefits` varchar(222) NOT NULL,
  `can_relocate` varchar(22) NOT NULL,
  `can_travel` varchar(22) NOT NULL,
  `notice_period` varchar(222) NOT NULL,
  `ex_salary` varchar(22) DEFAULT NULL,
  `ex_salary_period` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_user_info`
--

INSERT INTO `jobs_user_info` (`id`, `user_id`, `location`, `lang1`, `lang2`, `lang3`, `marital_status`, `disabilities`, `memberships`, `awards`, `links`, `salary`, `currency`, `expected_benefits`, `can_relocate`, `can_travel`, `notice_period`, `ex_salary`, `ex_salary_period`) VALUES
(2, 3, 'Lusaka, Zambia', 'English', 'Chewa', 'Nyanja', 'Single', 'Non, thankfully', 'ZAWA (1232)', 'Some Award, A trophy too', 'www.my journal.com', '2000', 'ZMK', '5000', 'Yes', 'Yes', '7 days', NULL, NULL),
(3, 4, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(4, 5, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(5, 6, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(6, 7, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(7, 8, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(8, 8, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(9, 9, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_user_qualifications`
--

CREATE TABLE `jobs_user_qualifications` (
  `id` int(11) NOT NULL,
  `qualification` varchar(222) NOT NULL,
  `award` varchar(222) NOT NULL,
  `school` varchar(222) NOT NULL,
  `starts` varchar(222) NOT NULL,
  `ends` varchar(222) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_user_qualifications`
--

INSERT INTO `jobs_user_qualifications` (`id`, `qualification`, `award`, `school`, `starts`, `ends`, `user_id`) VALUES
(1, 'Degree.', 'Computer Science', 'UNZA.', '2018-01-05', '2020-12-18', 3),
(2, 'GCE', 'O-levels', 'LSS', '2022-03-29', '2022-05-27', 3);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_user_refs`
--

CREATE TABLE `jobs_user_refs` (
  `id` int(11) NOT NULL,
  `user_id` int(222) NOT NULL,
  `name` varchar(222) NOT NULL,
  `position` varchar(222) NOT NULL,
  `company` varchar(222) NOT NULL,
  `country` varchar(222) NOT NULL,
  `province` varchar(222) NOT NULL,
  `town` varchar(222) NOT NULL,
  `gender` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `address` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_user_refs`
--

INSERT INTO `jobs_user_refs` (`id`, `user_id`, `name`, `position`, `company`, `country`, `province`, `town`, `gender`, `phone`, `email`, `address`) VALUES
(1, 3, 'Jesh Boele', 'Boss', '', 'Zambia', 'Lusaka', 'Kafue', 'Female', '09787878', 'email@gmail.com1', 'right here'),
(2, 3, 'Sam Carly', 'GM', 'Goods dealers', 'Angola', 'Dar', 'Winds', 'Female', '0965157033', 'hotmail@gmail.com', '306785311 10865 chilimbulu road, chilenje');

-- --------------------------------------------------------

--
-- Table structure for table `jobs_user_skills`
--

CREATE TABLE `jobs_user_skills` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category` varchar(222) NOT NULL,
  `name` varchar(222) NOT NULL,
  `level` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_user_skills`
--

INSERT INTO `jobs_user_skills` (`id`, `user_id`, `category`, `name`, `level`) VALUES
(1, 3, 'ML/AI', 'Tensorflow', 'Beginner'),
(3, 3, 'IT', 'Java', 'Intermediate'),
(4, 3, 'Software', 'GoLang', 'Expert'),
(5, 3, 'Software Development', 'PHP', 'Expert');

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications_tb`
--

CREATE TABLE `leave_applications_tb` (
  `application_id` int(12) NOT NULL,
  `leave_start_date` date NOT NULL,
  `leave_end_date` date NOT NULL,
  `leave_type` text NOT NULL,
  `reason_leave` text NOT NULL,
  `empno` text NOT NULL,
  `status` text NOT NULL,
  `contact` text NOT NULL,
  `contact_person` text NOT NULL,
  `address_on_leave` text NOT NULL,
  `file_proof` text NOT NULL,
  `parent_supervisor_notified` text NOT NULL,
  `application_date` text NOT NULL,
  `level` int(12) NOT NULL,
  `days` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_applications_tb`
--

INSERT INTO `leave_applications_tb` (`application_id`, `leave_start_date`, `leave_end_date`, `leave_type`, `reason_leave`, `empno`, `status`, `contact`, `contact_person`, `address_on_leave`, `file_proof`, `parent_supervisor_notified`, `application_date`, `level`, `days`) VALUES
(13, '2022-07-07', '2022-07-07', 'Mothers Day', 'ok', 'CT06', 'Pending Approval', '+260975704991', 'choolwe ngandu', 'Lusaka.\r\nChilenge', '', '', '2022-07-07', 1, '1'),
(14, '2022-07-11', '2022-07-13', 'COMMUTATION', 'ok', 'CT06', 'Pending Approval', '+260975704991', 'ds ngandu', 'Lusaka.', '', '', '2022-07-11', 1, '3'),
(15, '2022-07-10', '2022-07-13', 'COMMUTATION', 'ok', 'CT05', 'Approved', '+260975704991', 'dsds ngandu', 'Lusaka.', '', '', '2022-07-11', 1, '3');

-- --------------------------------------------------------

--
-- Table structure for table `leave_application_levels`
--

CREATE TABLE `leave_application_levels` (
  `id` int(12) NOT NULL,
  `application_id` int(12) NOT NULL,
  `emp_no` text NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leave_days`
--

CREATE TABLE `leave_days` (
  `ID` int(6) NOT NULL,
  `available` int(90) DEFAULT NULL,
  `empno` varchar(90) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_days`
--

INSERT INTO `leave_days` (`ID`, `available`, `empno`) VALUES
(1, 2, 'CT04'),
(2, 2, 'CT03'),
(3, 2, 'CT01'),
(4, 2, 'CT02'),
(5, 2, 'CT05'),
(6, 2, 'CT06'),
(7, 2, ''),
(8, 2, 'CT07'),
(9, 2, 'CT08');

-- --------------------------------------------------------

--
-- Table structure for table `leave_ratings_tb`
--

CREATE TABLE `leave_ratings_tb` (
  `grade_id` int(11) NOT NULL,
  `monthly_leave_days` text NOT NULL,
  `id` int(11) NOT NULL,
  `companyID` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_ratings_tb`
--

INSERT INTO `leave_ratings_tb` (`grade_id`, `monthly_leave_days`, `id`, `companyID`) VALUES
(1, '2', 4, 4),
(2, '2', 5, 4),
(3, '2', 6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `leave_tb`
--

CREATE TABLE `leave_tb` (
  `id` int(12) NOT NULL,
  `leave_type` text NOT NULL,
  `max_leave_days` int(11) NOT NULL,
  `companyID` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_tb`
--

INSERT INTO `leave_tb` (`id`, `leave_type`, `max_leave_days`, `companyID`) VALUES
(8, 'Maternity ', 90, 9),
(16, 'Maternity Leave	', 120, 4),
(17, 'Paternity Leave', 5, 4),
(18, 'Compassionate Leave	', 12, 4),
(19, 'Family Responsibility', 7, 4),
(20, 'Speacial Leave', 365, 4),
(21, 'Sick Leave	', 365, 4),
(22, 'Annual leave', 365, 4),
(23, 'study leave', 365, 4),
(24, 'Mothers Day', 10, 4),
(25, 'COMMUTATION', 20, 4);

-- --------------------------------------------------------

--
-- Table structure for table `live_class`
--

CREATE TABLE `live_class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(1000) NOT NULL,
  `initiated_by` int(11) NOT NULL,
  `initiated_time` int(11) NOT NULL,
  `closed_time` int(11) NOT NULL,
  `content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `LOAN_NO` int(6) NOT NULL,
  `empno` varchar(90) NOT NULL,
  `loan_amt` int(200) NOT NULL,
  `monthly_deduct` text NOT NULL,
  `duration` int(200) NOT NULL,
  `company_ID` varchar(20) NOT NULL,
  `principle` int(20) NOT NULL,
  `interest_rate` float NOT NULL,
  `interest` int(20) NOT NULL,
  `loan_date` text NOT NULL,
  `date_completion` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`LOAN_NO`, `empno`, `loan_amt`, `monthly_deduct`, `duration`, `company_ID`, `principle`, `interest_rate`, `interest`, `loan_date`, `date_completion`, `status`) VALUES
(1, 'CT04', 3000, '3000', 0, '4', 0, 0, 0, '2022-05-01', '2022-05-31', 'Cleared');

-- --------------------------------------------------------

--
-- Table structure for table `nhima_tb`
--

CREATE TABLE `nhima_tb` (
  `nhima_id` int(12) NOT NULL,
  `amount` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nhima_tb`
--

INSERT INTO `nhima_tb` (`nhima_id`, `amount`, `date_added`, `status`) VALUES
(1, '1', '2021-01-28 18:16:45', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `overtime`
--

CREATE TABLE `overtime` (
  `ID` int(6) NOT NULL,
  `hours` int(90) DEFAULT NULL,
  `rate` int(90) DEFAULT NULL,
  `h_rate` int(90) DEFAULT NULL,
  `empno` int(90) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payslip_uploads`
--

CREATE TABLE `payslip_uploads` (
  `id` int(12) NOT NULL,
  `empno` text NOT NULL,
  `payslip` text NOT NULL,
  `date_period` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `postings`
--

CREATE TABLE `postings` (
  `id` int(11) NOT NULL,
  `title` varchar(222) NOT NULL,
  `dep_id` int(11) NOT NULL,
  `vacancies` int(50) NOT NULL,
  `type` varchar(222) NOT NULL,
  `experience` varchar(222) NOT NULL,
  `salary` varchar(222) NOT NULL,
  `info` text NOT NULL,
  `qualifications` text NOT NULL,
  `status` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postings`
--

INSERT INTO `postings` (`id`, `title`, `dep_id`, `vacancies`, `type`, `experience`, `salary`, `info`, `qualifications`, `status`, `date`, `expires`) VALUES
(3, 'Software developer', 35, 1, 'Contract', '3', 'NA', 'test Job', 'Degree Computer Science', 'Published', '2022-02-01 03:00:00', '2022-02-28'),
(4, 'Devlon', 40, 22, 'Full Time', '2', '2000', 'whatever mahnnn', 'Degree', 'Published', '2022-04-13 02:00:00', '2022-04-30'),
(5, 'Another ', 39, 34, 'Part Time', '4', '2322', 'well', 'things', 'Published', '2022-04-07 02:00:00', '2022-09-30'),
(6, 'Gig', 42, 3, 'Full Time', '3', '18000', 'stuff', 'sklw', 'Published', '2022-04-06 02:00:00', '2022-10-27');

-- --------------------------------------------------------

--
-- Table structure for table `prefix`
--

CREATE TABLE `prefix` (
  `id` int(20) NOT NULL,
  `prefix` varchar(20) NOT NULL,
  `company_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prefix`
--

INSERT INTO `prefix` (`id`, `prefix`, `company_id`) VALUES
(1, 'CT', '4');

-- --------------------------------------------------------

--
-- Table structure for table `savsoft_answers`
--

CREATE TABLE `savsoft_answers` (
  `aid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `q_option` text NOT NULL,
  `uid` int(11) NOT NULL,
  `score_u` float NOT NULL DEFAULT '0',
  `rid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `savsoft_answers`
--

INSERT INTO `savsoft_answers` (`aid`, `qid`, `q_option`, `uid`, `score_u`, `rid`) VALUES
(4, 14, 'C___D', 7, 0.25, 1),
(5, 16, '56', 7, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `savsoft_category`
--

CREATE TABLE `savsoft_category` (
  `cid` int(11) NOT NULL,
  `category_name` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `savsoft_category`
--

INSERT INTO `savsoft_category` (`cid`, `category_name`) VALUES
(1, 'General knowledge'),
(2, 'Math');

-- --------------------------------------------------------

--
-- Table structure for table `savsoft_group`
--

CREATE TABLE `savsoft_group` (
  `gid` int(11) NOT NULL,
  `group_name` varchar(1000) NOT NULL,
  `price` float NOT NULL,
  `valid_for_days` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `savsoft_group`
--

INSERT INTO `savsoft_group` (`gid`, `group_name`, `price`, `valid_for_days`, `description`) VALUES
(1, 'Free', 0, 0, '10 Free quiz'),
(3, 'Premium-1', 100, 90, '100 Quizzes'),
(4, 'Group 3', 2500, 90, '<p>Unlimites quizzes.</p>\r\n<p>Phone support</p>');

-- --------------------------------------------------------

--
-- Table structure for table `savsoft_level`
--

CREATE TABLE `savsoft_level` (
  `lid` int(11) NOT NULL,
  `level_name` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `savsoft_level`
--

INSERT INTO `savsoft_level` (`lid`, `level_name`) VALUES
(1, 'Easy'),
(2, 'Difficult');

-- --------------------------------------------------------

--
-- Table structure for table `savsoft_notification`
--

CREATE TABLE `savsoft_notification` (
  `nid` int(11) NOT NULL,
  `notification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `click_action` varchar(100) DEFAULT NULL,
  `notification_to` varchar(1000) DEFAULT NULL,
  `response` text,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `savsoft_options`
--

CREATE TABLE `savsoft_options` (
  `oid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `q_option` text NOT NULL,
  `q_option_match` varchar(1000) DEFAULT NULL,
  `score` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `savsoft_options`
--

INSERT INTO `savsoft_options` (`oid`, `qid`, `q_option`, `q_option_match`, `score`) VALUES
(46, 6, 'Good Morning', 'Good Night', 0.25),
(47, 6, 'Honda', 'BMW', 0.25),
(48, 6, 'Keyboard', 'CPU', 0.25),
(49, 6, 'Red', 'Green', 0.25),
(51, 7, 'Blue, Sky Blue', NULL, 1),
(52, 3, '4', NULL, 0.5),
(53, 3, '5', NULL, 0),
(54, 3, 'Four', NULL, 0.5),
(55, 3, 'Six', NULL, 0),
(56, 1, 'Patiala', NULL, 0),
(57, 1, 'New Delhi', NULL, 1),
(58, 1, 'Chandigarh', NULL, 0),
(59, 1, 'Mumbai', NULL, 0),
(76, 14, 'A', 'B', 0.25),
(77, 14, 'C', 'D', 0.25),
(78, 14, 'E', 'F', 0.25),
(79, 14, 'G', 'H', 0.25),
(81, 15, 'Washington, Washington D.C', NULL, 1),
(82, 13, '<p>five</p>', NULL, 0),
(83, 13, '<p>40</p>', NULL, 0.5),
(84, 13, '<p>fourty</p>', NULL, 0.5),
(85, 13, '<p>six</p>', NULL, 0),
(86, 12, '<p>five</p>', NULL, 0),
(87, 12, '<p>14</p>', NULL, 1),
(88, 12, '<p>three</p>', NULL, 0),
(89, 12, '<p>six</p>', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `savsoft_payment`
--

CREATE TABLE `savsoft_payment` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `amount` float NOT NULL,
  `paid_date` int(11) NOT NULL,
  `payment_gateway` varchar(100) NOT NULL DEFAULT 'Paypal',
  `payment_status` varchar(100) NOT NULL DEFAULT 'Pending',
  `transaction_id` varchar(1000) NOT NULL,
  `other_data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `savsoft_qbank`
--

CREATE TABLE `savsoft_qbank` (
  `qid` int(11) NOT NULL,
  `question_type` varchar(100) NOT NULL DEFAULT 'Multiple Choice Single Answer',
  `question` text NOT NULL,
  `description` text NOT NULL,
  `cid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `no_time_served` int(11) NOT NULL DEFAULT '0',
  `no_time_corrected` int(11) NOT NULL DEFAULT '0',
  `no_time_incorrected` int(11) NOT NULL DEFAULT '0',
  `no_time_unattempted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `savsoft_qbank`
--

INSERT INTO `savsoft_qbank` (`qid`, `question_type`, `question`, `description`, `cid`, `lid`, `no_time_served`, `no_time_corrected`, `no_time_incorrected`, `no_time_unattempted`) VALUES
(1, 'Multiple Choice Single Answer', 'What is the capital of INDIA?', 'New Delhi', 2, 1, 15, 11, 2, 2),
(3, 'Multiple Choice Multiple Answer', 'What is 2+2=?', '4', 2, 1, 15, 10, 2, 3),
(6, 'Match the Column', 'Match the Following', '', 1, 1, 10, 5, 1, 4),
(7, 'Short Answer', 'What is the color of sky?', '', 1, 1, 10, 4, 1, 5),
(8, 'Long Answer', 'Write an essay on INDIA. (250 words )', '', 1, 1, 4, 0, 0, 3),
(12, 'Multiple Choice Single Answer', '<p>What is 12+2 = ?</p>', '<p>Here is description or explanation</p>', 1, 2, 5, 2, 1, 2),
(13, 'Multiple Choice Multiple Answer', '<p>What is 32+8 = ?&nbsp;</p>', '<p>Here is description or explanation</p>', 1, 2, 5, 2, 0, 3),
(14, 'Match the Column', 'Match the column', 'Here is description or explanation', 1, 2, 2, 0, 1, 1),
(15, 'Short Answer', '<p>What is the capital of USA</p>', '<p>Here is description or explanation</p>', 1, 2, 0, 0, 0, 0),
(16, 'Long Answer', '<p>Write about Globalization in 250 words</p>', '<p>Here is description or explanation</p>', 2, 2, 2, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `savsoft_qcl`
--

CREATE TABLE `savsoft_qcl` (
  `qcl_id` int(11) NOT NULL,
  `quid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `noq` int(11) NOT NULL,
  `i_correct` text NOT NULL,
  `i_incorrect` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `savsoft_qcl`
--

INSERT INTO `savsoft_qcl` (`qcl_id`, `quid`, `cid`, `lid`, `noq`, `i_correct`, `i_incorrect`) VALUES
(71, 2, 1, 1, 3, '1', '0'),
(72, 2, 3, 1, 1, '1', '0'),
(73, 2, 2, 1, 1, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `savsoft_quiz`
--

CREATE TABLE `savsoft_quiz` (
  `quid` int(11) NOT NULL,
  `quiz_name` varchar(1000) NOT NULL,
  `description` text NOT NULL,
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL,
  `gids` text NOT NULL,
  `qids` text NOT NULL,
  `noq` int(11) NOT NULL,
  `correct_score` text NOT NULL,
  `incorrect_score` text NOT NULL,
  `ip_address` text NOT NULL,
  `duration` int(11) NOT NULL DEFAULT '10',
  `maximum_attempts` int(11) NOT NULL DEFAULT '1',
  `pass_percentage` float NOT NULL DEFAULT '50',
  `view_answer` int(11) NOT NULL DEFAULT '1',
  `camera_req` int(11) NOT NULL DEFAULT '1',
  `question_selection` int(11) NOT NULL DEFAULT '1',
  `gen_certificate` int(11) NOT NULL DEFAULT '0',
  `certificate_text` text,
  `with_login` int(11) NOT NULL DEFAULT '1',
  `quiz_template` varchar(100) NOT NULL DEFAULT 'Default'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `savsoft_quiz`
--

INSERT INTO `savsoft_quiz` (`quid`, `quiz_name`, `description`, `start_date`, `end_date`, `gids`, `qids`, `noq`, `correct_score`, `incorrect_score`, `ip_address`, `duration`, `maximum_attempts`, `pass_percentage`, `view_answer`, `camera_req`, `question_selection`, `gen_certificate`, `certificate_text`, `with_login`, `quiz_template`) VALUES
(1, 'Sample Quiz', '<p>Sample Quiz Sample Quiz</p>', 1460344840, 1522502169, '3,1', '1,3,12,13', 4, '1', '0', '', 1000, 10, 50, 1, 0, 0, 0, NULL, 1, 'Default'),
(3, 'Quiz with advance template', '', 1659205800, 1672492569, '1,3,4', '1,3,6,7', 4, '1,1,1,1', '-0.33,-0.33,-0.33,-0.33', '', 10, 10, 50, 1, 0, 0, 0, NULL, 1, 'Advance'),
(4, 'Deeloper', '', 1650699127, 1682235127, '1', '14,16', 2, '1', '0', '', 10, 10, 100, 0, 0, 0, 0, NULL, 1, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `savsoft_result`
--

CREATE TABLE `savsoft_result` (
  `rid` int(11) NOT NULL,
  `quid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `result_status` varchar(100) NOT NULL DEFAULT 'Open',
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `categories` text NOT NULL,
  `category_range` text NOT NULL,
  `r_qids` text NOT NULL,
  `individual_time` text NOT NULL,
  `total_time` int(11) NOT NULL DEFAULT '0',
  `score_obtained` float NOT NULL DEFAULT '0',
  `percentage_obtained` float NOT NULL DEFAULT '0',
  `attempted_ip` varchar(100) NOT NULL,
  `score_individual` text NOT NULL,
  `photo` varchar(100) NOT NULL,
  `manual_valuation` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `savsoft_result`
--

INSERT INTO `savsoft_result` (`rid`, `quid`, `uid`, `result_status`, `start_time`, `end_time`, `categories`, `category_range`, `r_qids`, `individual_time`, `total_time`, `score_obtained`, `percentage_obtained`, `attempted_ip`, `score_individual`, `photo`, `manual_valuation`) VALUES
(1, 4, 7, 'Fail', 1650699529, 1650699582, 'General knowledge,Math', '1,1', '14,16', '30,19', 49, 1, 50, '::1', '2,1', '', 0),
(2, 4, 9, 'Fail', 1650895802, 1650895831, 'General knowledge,Math', '1,1', '14,16', '15,10', 25, 0, 0, '::1', '0,0', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `savsoft_users`
--

CREATE TABLE `savsoft_users` (
  `uid` int(11) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `contact_no` varchar(1000) DEFAULT NULL,
  `connection_key` varchar(1000) DEFAULT NULL,
  `gid` int(11) NOT NULL DEFAULT '1',
  `su` int(11) NOT NULL DEFAULT '0',
  `subscription_expired` int(11) NOT NULL DEFAULT '0',
  `verify_code` int(11) NOT NULL DEFAULT '0',
  `wp_user` varchar(100) DEFAULT NULL,
  `registered_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `photo` varchar(1000) DEFAULT NULL,
  `user_status` varchar(100) NOT NULL DEFAULT 'Active',
  `web_token` varchar(1000) DEFAULT NULL,
  `android_token` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `savsoft_users`
--

INSERT INTO `savsoft_users` (`uid`, `password`, `email`, `first_name`, `last_name`, `contact_no`, `connection_key`, `gid`, `su`, `subscription_expired`, `verify_code`, `wp_user`, `registered_date`, `photo`, `user_status`, `web_token`, `android_token`) VALUES
(1, '21232f297a57a5a743894a0e4a801fc3', 'admin@example.com', 'Admin', 'Admin', '1234567890', NULL, 1, 1, 1776290400, 0, '', '2017-04-20 15:22:38', NULL, 'Active', 'dnwIpQWkxyA:APA91bFZLhdxZnPcNareTyHnJRikJGqaT7qh9DF4jSmyKSOq1rv6k7uwgmaQ4_K7jT3WNNUeKRdRQYsNf_OZaQZ7i5nKI_CjA6QGPwPsL5_D7ShPTtsuIwTkr0CuGx0RS7oAVNg_bImc', NULL),
(5, 'e10adc3949ba59abbe56e057f20f883e', 'user@example.com', 'User', 'User', '1234567890', '123', 1, 0, 2122569000, 0, '', '2017-04-20 15:22:38', NULL, 'Active', NULL, NULL),
(7, '202cb962ac59075b964b07152d234b70', 'chipimo31@gmail.com', 'melvin', 'chipimo', '+260972160250', NULL, 1, 1, 2122569000, 0, NULL, '2022-04-22 16:08:38', NULL, 'Active', NULL, NULL),
(8, 'f885a14eaf260d7d9f93c750e1174228', 'choolwe1992@gmail.com', 'chesco', 'ngandu', '0975704991', NULL, 1, 1, 2122569000, 0, NULL, '2022-04-25 17:53:25', NULL, 'Active', NULL, NULL),
(9, '7215ee9c7d9dc229d2921a40e899ec5f', 'choolwe1992@gmail.com', 'chesco', 'ngandu', '0975704991', NULL, 1, 1, 2122569000, 0, NULL, '2022-04-25 18:09:16', NULL, 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sms_credits_tb`
--

CREATE TABLE `sms_credits_tb` (
  `id` int(12) NOT NULL,
  `credit_balance` text NOT NULL,
  `company_id` int(12) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `talent_pool`
--

CREATE TABLE `talent_pool` (
  `id` int(12) NOT NULL,
  `title` text NOT NULL,
  `department_id` int(12) NOT NULL,
  `description` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `talent_pool`
--

INSERT INTO `talent_pool` (`id`, `title`, `department_id`, `description`, `date_created`) VALUES
(2, 'Next Software Engineers recruitment ', 36, '                                  Candidates that are interested in joining us, but we couldnt hire in Q2 because there were no open positions. We should check if we have any good fits for them in Q3.                                                                ', '2022-04-10 18:58:44');

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `id` int(6) NOT NULL,
  `taxable_to_date` text,
  `tax_paid_to_date` text,
  `empno` text,
  `company_id` varchar(11) NOT NULL,
  `social` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`id`, `taxable_to_date`, `tax_paid_to_date`, `empno`, `company_id`, `social`, `date`) VALUES
(13, '13500', '4087.5', 'CT04', '4', '0', '2022-05-31'),
(14, '2500', '675', 'CT03', '4', '0', '2022-05-31'),
(15, '15000', '4650', 'CT01', '4', '0', '2022-05-31'),
(16, '875', '0', 'CT02', '4', '0', '2022-05-31'),
(17, '2500', '675', 'CT05', '4', '0', '2022-05-31'),
(18, '27500', '9337.5', 'CT06', '4', '0', '2022-05-31'),
(19, '300', '0', 'CT07', '4', '0', '2022-06-30'),
(20, '31200', '10920', 'CT08', '4', '0', '2022-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `tax_bands`
--

CREATE TABLE `tax_bands` (
  `id` int(6) NOT NULL,
  `band_top1` text NOT NULL,
  `band_top2` text NOT NULL,
  `band_top3` text NOT NULL,
  `band_rate1` text NOT NULL,
  `band_rate2` text NOT NULL,
  `band_rate3` text NOT NULL,
  `band_rate4` text NOT NULL,
  `company_ID` varchar(20) NOT NULL,
  `napsa_ceiling` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tax_bands`
--

INSERT INTO `tax_bands` (`id`, `band_top1`, `band_top2`, `band_top3`, `band_rate1`, `band_rate2`, `band_rate3`, `band_rate4`, `company_ID`, `napsa_ceiling`) VALUES
(3, '4500', '4800', '6900', '0', '25', '30', '37.5', '4', '1221.80');

-- --------------------------------------------------------

--
-- Table structure for table `users_tb`
--

CREATE TABLE `users_tb` (
  `id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `password` text NOT NULL,
  `company_id` int(11) NOT NULL,
  `empno` text NOT NULL,
  `user_type` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_tb`
--

INSERT INTO `users_tb` (`id`, `user_name`, `password`, `company_id`, `empno`, `user_type`, `firstname`, `lastname`, `email_address`) VALUES
(1, 'superadmin', '21232f297a57a5a743894a0e4a801fc3', 4, '', 'superadmin', 'Choolwe', 'Ngandu', 'choolwe@crystaline.co.zm'),
(10, 'boss', '21232f297a57a5a743894a0e4a801fc3 ', 4, '', 'HR Admin', 'Isabella', 'Mulima', 'choolwe1992@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `workflows`
--

CREATE TABLE `workflows` (
  `id` int(12) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `workflows`
--

INSERT INTO `workflows` (`id`, `name`) VALUES
(4, 'Chesco Tech Leave Workflow');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowances_tb`
--
ALTER TABLE `allowances_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appeal_notices`
--
ALTER TABLE `appeal_notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appover_groups`
--
ALTER TABLE `appover_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_rating`
--
ALTER TABLE `app_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ass_appraisals`
--
ALTER TABLE `ass_appraisals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ass_emp_appraisals`
--
ALTER TABLE `ass_emp_appraisals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ass_factors`
--
ALTER TABLE `ass_factors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ass_group`
--
ALTER TABLE `ass_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ass_params`
--
ALTER TABLE `ass_params`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ass_periods`
--
ALTER TABLE `ass_periods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `band_tb`
--
ALTER TABLE `band_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates_tb`
--
ALTER TABLE `certificates_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_coment`
--
ALTER TABLE `class_coment`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `class_gid`
--
ALTER TABLE `class_gid`
  ADD PRIMARY KEY (`clgid`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_ID`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`ded_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dep_id`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_discplinary_records`
--
ALTER TABLE `employee_discplinary_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_exits_tb`
--
ALTER TABLE `employee_exits_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_edu_info_tb`
--
ALTER TABLE `emp_edu_info_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_history_tb`
--
ALTER TABLE `emp_history_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_info`
--
ALTER TABLE `emp_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`grade_id`);

--
-- Indexes for table `gratuity_settings_tb`
--
ALTER TABLE `gratuity_settings_tb`
  ADD PRIMARY KEY (`grat_id`);

--
-- Indexes for table `hod_tb`
--
ALTER TABLE `hod_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_logs`
--
ALTER TABLE `jobs_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_postings`
--
ALTER TABLE `jobs_postings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_posting_qualifications`
--
ALTER TABLE `jobs_posting_qualifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_posting_requirements`
--
ALTER TABLE `jobs_posting_requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_users`
--
ALTER TABLE `jobs_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_user_applications`
--
ALTER TABLE `jobs_user_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_user_attachments`
--
ALTER TABLE `jobs_user_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_user_experience`
--
ALTER TABLE `jobs_user_experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_user_info`
--
ALTER TABLE `jobs_user_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_user_qualifications`
--
ALTER TABLE `jobs_user_qualifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_user_refs`
--
ALTER TABLE `jobs_user_refs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_user_skills`
--
ALTER TABLE `jobs_user_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_applications_tb`
--
ALTER TABLE `leave_applications_tb`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `leave_application_levels`
--
ALTER TABLE `leave_application_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_days`
--
ALTER TABLE `leave_days`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `leave_ratings_tb`
--
ALTER TABLE `leave_ratings_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_tb`
--
ALTER TABLE `leave_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_class`
--
ALTER TABLE `live_class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`LOAN_NO`);

--
-- Indexes for table `nhima_tb`
--
ALTER TABLE `nhima_tb`
  ADD PRIMARY KEY (`nhima_id`);

--
-- Indexes for table `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `payslip_uploads`
--
ALTER TABLE `payslip_uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postings`
--
ALTER TABLE `postings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prefix`
--
ALTER TABLE `prefix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `savsoft_answers`
--
ALTER TABLE `savsoft_answers`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `savsoft_category`
--
ALTER TABLE `savsoft_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `savsoft_group`
--
ALTER TABLE `savsoft_group`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `savsoft_level`
--
ALTER TABLE `savsoft_level`
  ADD PRIMARY KEY (`lid`);

--
-- Indexes for table `savsoft_notification`
--
ALTER TABLE `savsoft_notification`
  ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `savsoft_options`
--
ALTER TABLE `savsoft_options`
  ADD PRIMARY KEY (`oid`);

--
-- Indexes for table `savsoft_payment`
--
ALTER TABLE `savsoft_payment`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `savsoft_qbank`
--
ALTER TABLE `savsoft_qbank`
  ADD PRIMARY KEY (`qid`);

--
-- Indexes for table `savsoft_qcl`
--
ALTER TABLE `savsoft_qcl`
  ADD PRIMARY KEY (`qcl_id`);

--
-- Indexes for table `savsoft_quiz`
--
ALTER TABLE `savsoft_quiz`
  ADD PRIMARY KEY (`quid`);

--
-- Indexes for table `savsoft_result`
--
ALTER TABLE `savsoft_result`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `savsoft_users`
--
ALTER TABLE `savsoft_users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `sms_credits_tb`
--
ALTER TABLE `sms_credits_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `talent_pool`
--
ALTER TABLE `talent_pool`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_bands`
--
ALTER TABLE `tax_bands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_tb`
--
ALTER TABLE `users_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workflows`
--
ALTER TABLE `workflows`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowances_tb`
--
ALTER TABLE `allowances_tb`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
--
-- AUTO_INCREMENT for table `appeal_notices`
--
ALTER TABLE `appeal_notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `appover_groups`
--
ALTER TABLE `appover_groups`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `app_rating`
--
ALTER TABLE `app_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ass_appraisals`
--
ALTER TABLE `ass_appraisals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `ass_emp_appraisals`
--
ALTER TABLE `ass_emp_appraisals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ass_factors`
--
ALTER TABLE `ass_factors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `ass_group`
--
ALTER TABLE `ass_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `ass_params`
--
ALTER TABLE `ass_params`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `ass_periods`
--
ALTER TABLE `ass_periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `band_tb`
--
ALTER TABLE `band_tb`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `certificates_tb`
--
ALTER TABLE `certificates_tb`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `class_coment`
--
ALTER TABLE `class_coment`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `class_gid`
--
ALTER TABLE `class_gid`
  MODIFY `clgid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `ded_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dep_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(90) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `employee_discplinary_records`
--
ALTER TABLE `employee_discplinary_records`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `employee_exits_tb`
--
ALTER TABLE `employee_exits_tb`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `emp_edu_info_tb`
--
ALTER TABLE `emp_edu_info_tb`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `emp_history_tb`
--
ALTER TABLE `emp_history_tb`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `emp_info`
--
ALTER TABLE `emp_info`
  MODIFY `id` int(90) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `grade_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `gratuity_settings_tb`
--
ALTER TABLE `gratuity_settings_tb`
  MODIFY `grat_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hod_tb`
--
ALTER TABLE `hod_tb`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `jobs_logs`
--
ALTER TABLE `jobs_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `jobs_postings`
--
ALTER TABLE `jobs_postings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `jobs_posting_qualifications`
--
ALTER TABLE `jobs_posting_qualifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `jobs_posting_requirements`
--
ALTER TABLE `jobs_posting_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `jobs_users`
--
ALTER TABLE `jobs_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `jobs_user_applications`
--
ALTER TABLE `jobs_user_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `jobs_user_attachments`
--
ALTER TABLE `jobs_user_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `jobs_user_experience`
--
ALTER TABLE `jobs_user_experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jobs_user_info`
--
ALTER TABLE `jobs_user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `jobs_user_qualifications`
--
ALTER TABLE `jobs_user_qualifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jobs_user_refs`
--
ALTER TABLE `jobs_user_refs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jobs_user_skills`
--
ALTER TABLE `jobs_user_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `leave_applications_tb`
--
ALTER TABLE `leave_applications_tb`
  MODIFY `application_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `leave_application_levels`
--
ALTER TABLE `leave_application_levels`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_days`
--
ALTER TABLE `leave_days`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `leave_ratings_tb`
--
ALTER TABLE `leave_ratings_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `leave_tb`
--
ALTER TABLE `leave_tb`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `live_class`
--
ALTER TABLE `live_class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `LOAN_NO` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `nhima_tb`
--
ALTER TABLE `nhima_tb`
  MODIFY `nhima_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `overtime`
--
ALTER TABLE `overtime`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payslip_uploads`
--
ALTER TABLE `payslip_uploads`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `postings`
--
ALTER TABLE `postings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `prefix`
--
ALTER TABLE `prefix`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `savsoft_answers`
--
ALTER TABLE `savsoft_answers`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `savsoft_category`
--
ALTER TABLE `savsoft_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `savsoft_group`
--
ALTER TABLE `savsoft_group`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `savsoft_level`
--
ALTER TABLE `savsoft_level`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `savsoft_notification`
--
ALTER TABLE `savsoft_notification`
  MODIFY `nid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `savsoft_options`
--
ALTER TABLE `savsoft_options`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT for table `savsoft_payment`
--
ALTER TABLE `savsoft_payment`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `savsoft_qbank`
--
ALTER TABLE `savsoft_qbank`
  MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `savsoft_qcl`
--
ALTER TABLE `savsoft_qcl`
  MODIFY `qcl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `savsoft_quiz`
--
ALTER TABLE `savsoft_quiz`
  MODIFY `quid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `savsoft_result`
--
ALTER TABLE `savsoft_result`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `savsoft_users`
--
ALTER TABLE `savsoft_users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `sms_credits_tb`
--
ALTER TABLE `sms_credits_tb`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `talent_pool`
--
ALTER TABLE `talent_pool`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `tax_bands`
--
ALTER TABLE `tax_bands`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users_tb`
--
ALTER TABLE `users_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `workflows`
--
ALTER TABLE `workflows`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
