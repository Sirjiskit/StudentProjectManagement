-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2019 at 12:57 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proj_2019_pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `senderid` int(11) NOT NULL,
  `sender` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `receiverid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inbox`
--

INSERT INTO `inbox` (`id`, `type`, `senderid`, `sender`, `message`, `receiverid`, `status`, `date`) VALUES
(1, 1, 2, 'COM/ND/15/002', 'Sir I have a problem', 2, 0, '2017-08-02 17:13:18'),
(2, 1, 2, 'COM/ND/15/002', 'uhui oirvm vkifv fmvnfiv fmviufvb mfvnfv fvifn vmfvyhfb vm fhvifbv fuvhbfj vfhvbf v hufv fmvhiufv fvihf mvfhvnkf mvhfvn fvihfv fhvfv f', 2, 0, '2017-08-02 17:17:24'),
(3, 2, 2, 'FPB/S/P/002', 'I want to see you tomorrow', 2, 0, '2017-08-02 18:02:27'),
(4, 2, 1, 'FPB/S/P/001', 'ssvf ddbb bb dbtrb g betbd', 1, 0, '2017-08-03 12:17:05'),
(5, 2, 1, 'FPB/S/P/001', 'Submit your chapter 1', 14, 0, '2019-10-01 18:18:36');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `data` varchar(100) NOT NULL,
  `sender` varchar(30) NOT NULL,
  `receiverid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `data`, `sender`, `receiverid`, `status`, `date`) VALUES
(1, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 2, 1, '2017-08-02 11:45:00'),
(2, 1, 'This is to notify you that COM/ND/15/002 have been assign to you', 'System Admin', 1, 0, '2017-08-02 11:45:00'),
(3, 2, 'This is to notify you that you have been assign to Usman Usman', 'System Admin', 4, 0, '2017-08-02 11:45:00'),
(4, 1, 'This is to notify you that COM/ND/15/004 have been assign to you', 'System Admin', 2, 0, '2017-08-02 11:45:00'),
(5, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 1, 0, '2017-08-02 11:45:00'),
(6, 1, 'This is to notify you that COM/ND/15/001 have been assign to you', 'System Admin', 1, 0, '2017-08-02 11:45:00'),
(7, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 3, 0, '2017-08-02 11:45:00'),
(8, 1, 'This is to notify you that COM/ND/15/003 have been assign to you', 'System Admin', 1, 0, '2017-08-02 11:45:00'),
(9, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 1, 1, '2017-08-02 11:45:00'),
(10, 1, 'This is to notify you that COM/ND/15/001 have been assign to you', 'System Admin', 1, 0, '2017-08-02 11:45:00'),
(11, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 2, 0, '2017-08-02 11:45:00'),
(12, 1, 'This is to notify you that COM/ND/15/002 have been assign to you', 'System Admin', 1, 0, '2017-08-02 11:45:00'),
(13, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 3, 0, '2017-08-02 11:45:00'),
(14, 1, 'This is to notify you that COM/ND/15/003 have been assign to you', 'System Admin', 1, 0, '2017-08-02 11:45:00'),
(15, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 4, 0, '2017-08-02 11:45:00'),
(16, 1, 'This is to notify you that COM/ND/15/004 have been assign to you', 'System Admin', 1, 0, '2017-08-02 11:45:00'),
(17, 2, 'This is to notify you that you have been re-assign to Usman Rasheedat Bello', 'System Admin', 2, 0, '2017-08-02 11:45:00'),
(18, 1, 'This is to notify you that COM/ND/15/002 have been re-assign to you', 'System Admin', 2, 0, '2017-08-02 11:45:00'),
(19, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 1, 1, '2017-08-02 11:45:00'),
(20, 1, 'This is to notify you that COM/ND/15/001 have been assign to you', 'System Admin', 1, 0, '2017-08-02 11:45:00'),
(21, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 2, 1, '2017-08-02 11:45:00'),
(22, 1, 'This is to notify you that COM/ND/15/002 have been assign to you', 'System Admin', 1, 0, '2017-08-02 11:45:00'),
(23, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 3, 0, '2017-08-02 11:45:00'),
(24, 1, 'This is to notify you that COM/ND/15/003 have been assign to you', 'System Admin', 1, 0, '2017-08-02 11:45:00'),
(25, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 4, 0, '2017-08-02 11:45:00'),
(26, 1, 'This is to notify you that COM/ND/15/004 have been assign to you', 'System Admin', 1, 0, '2017-08-02 11:45:00'),
(27, 2, 'This is to notify you that you have been assign to Usama Usama', 'System Admin', 5, 0, '2017-08-02 11:45:00'),
(28, 1, 'This is to notify you that ACC/ND/15/001 have been assign to you', 'System Admin', 3, 0, '2017-08-02 11:45:00'),
(29, 2, 'This is to notify you that you have been assign to Usama Usama', 'System Admin', 6, 0, '2017-08-02 11:45:00'),
(30, 1, 'This is to notify you that ACC/ND/15/002 have been assign to you', 'System Admin', 3, 0, '2017-08-02 11:45:00'),
(31, 2, 'This is to notify you that you have been assign to Usama Usama', 'System Admin', 7, 0, '2017-08-02 11:45:00'),
(32, 1, 'This is to notify you that ACC/ND/15/003 have been assign to you', 'System Admin', 3, 0, '2017-08-02 11:45:00'),
(33, 2, 'This is to notify you that you have been re-assign to Usman Rasheedat Bello', 'System Admin', 2, 1, '2017-08-02 11:45:00'),
(34, 1, 'This is to notify you that COM/ND/15/002 have been re-assign to you', 'System Admin', 2, 1, '2017-08-02 11:45:00'),
(35, 2, 'This is to notify you that you have been re-assign to Usman Rasheedat Bello', 'System Admin', 4, 0, '2017-08-02 11:45:00'),
(36, 1, 'This is to notify you that COM/ND/15/004 have been re-assign to you', 'System Admin', 2, 0, '2017-08-02 11:45:00'),
(37, 2, 'Your supervisor have sent you a message', 'Supervisor', 2, 1, '2017-08-02 18:02:27'),
(38, 2, 'Your project topic is been <span class=\"label label-danger\">Reject</span>', 'supervisor', 2, 0, '2017-08-02 21:09:51'),
(39, 2, 'Your project topic is been <span class=\"label label-danger\">Reject</span>', 'supervisor', 2, 0, '2017-08-02 21:10:07'),
(40, 1, ' Your student COM/ND/15/002 have success upload\r\n		 his/her project work', 'COM/ND/15/002', 2, 0, '2017-08-02 22:53:10'),
(41, 1, ' Your student COM/ND/15/002 have success upload\r\n		 his/her project work', 'COM/ND/15/002', 2, 0, '2017-08-02 23:06:47'),
(42, 2, 'Your supervisor have sent you a message', 'Supervisor', 1, 0, '2017-08-03 12:17:05'),
(43, 1, ' Your student have submitted his/her \r\n		Project Topic', 'COM/ND/15/001', 1, 0, '2017-08-03 12:18:26'),
(44, 2, 'Your project topic is been restructured and approved', 'supervisor', 1, 0, '2017-08-03 12:20:01'),
(45, 2, 'Welcome to Student project management and allocation system', 'System Admin', 14, 1, '2019-10-01 17:43:23'),
(46, 1, 'Welcome to Student project management and allocation system', 'System Admin', 4, 0, '2019-10-01 17:45:02'),
(47, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 12, 0, '2019-10-01 17:45:32'),
(48, 1, 'This is to notify you that COM/ND/17/002 have been assign to you', 'System Admin', 1, 0, '2019-10-01 17:45:32'),
(49, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 13, 0, '2019-10-01 17:45:32'),
(50, 1, 'This is to notify you that COM/ND/17/006 have been assign to you', 'System Admin', 1, 0, '2019-10-01 17:45:32'),
(51, 2, 'This is to notify you that you have been assign to Igbashio Igbashio', 'System Admin', 14, 0, '2019-10-01 17:45:33'),
(52, 1, 'This is to notify you that COM/ND/17/007 have been assign to you', 'System Admin', 1, 0, '2019-10-01 17:45:33'),
(53, 1, ' Your student have submitted his/her \r\n		Project Topic', 'COM/ND/17/007', 1, 0, '2019-10-01 18:07:51'),
(54, 2, 'Your project topic is been <span class=\"label label-danger\">Reject</span>', 'supervisor', 1, 0, '2019-10-01 18:17:23'),
(55, 2, 'Your supervisor have sent you a message', 'Supervisor', 14, 0, '2019-10-01 18:18:36');

-- --------------------------------------------------------

--
-- Table structure for table `projectwork`
--

CREATE TABLE `projectwork` (
  `id` int(11) NOT NULL,
  `studid` int(11) NOT NULL,
  `work` varchar(30) NOT NULL,
  `workfile` varchar(100) NOT NULL,
  `reworkfile` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `subdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `redate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projectwork`
--

INSERT INTO `projectwork` (`id`, `studid`, `work`, `workfile`, `reworkfile`, `status`, `comment`, `subdate`, `redate`) VALUES
(1, 2, '0', 'comnd15002ktoi.docx', 're-7hl6.docx', 1, 'Bring chapter one', '2017-08-02 22:50:05', '2017-08-03'),
(2, 2, 'Chapter One', 'comnd150024tqv.docx', 're-h6z2.docx', 2, 'jnvjkffvfnvn vnfd vfdk vdfk', '2017-08-02 22:53:10', '2017-08-03'),
(3, 2, 'Chapter Three', 'comnd15002eqxi.docx', 're-8tbj.docx', 2, 'ijvfd fjbngkb gknbkgb jgnf bkgfk,', '2017-08-02 23:06:47', '2017-08-03');

-- --------------------------------------------------------

--
-- Table structure for table `tb_schedulled`
--

CREATE TABLE `tb_schedulled` (
  `id` int(11) NOT NULL,
  `schid` int(11) NOT NULL,
  `dpmid` int(11) NOT NULL,
  `studid` int(11) NOT NULL,
  `supid` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_schedulled`
--

INSERT INTO `tb_schedulled` (`id`, `schid`, `dpmid`, `studid`, `supid`, `status`, `date`) VALUES
(1, 1, 1, 1, 1, 0, '2017-08-02 11:02:17'),
(2, 1, 1, 2, 2, 0, '2017-08-02 11:02:17'),
(3, 1, 1, 3, 1, 0, '2017-08-02 11:02:17'),
(4, 1, 1, 4, 2, 0, '2017-08-02 11:02:18'),
(5, 2, 1, 5, 3, 0, '2017-08-02 11:02:18'),
(6, 2, 1, 6, 3, 0, '2017-08-02 11:02:18'),
(7, 2, 1, 7, 3, 0, '2017-08-02 11:02:18'),
(8, 1, 1, 12, 1, 0, '2019-10-01 17:45:31'),
(9, 1, 1, 13, 1, 0, '2019-10-01 17:45:32'),
(10, 1, 1, 14, 1, 0, '2019-10-01 17:45:33');

-- --------------------------------------------------------

--
-- Table structure for table `tb_students`
--

CREATE TABLE `tb_students` (
  `id` int(11) NOT NULL,
  `studentid` varchar(15) NOT NULL,
  `firstname` varchar(15) NOT NULL,
  `othernames` varchar(30) NOT NULL,
  `school` int(1) NOT NULL,
  `department` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `isAssigned` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_students`
--

INSERT INTO `tb_students` (`id`, `studentid`, `firstname`, `othernames`, `school`, `department`, `status`, `isAssigned`) VALUES
(1, 'COM/ND/15/001', 'Gambo', 'Godiya Garba', 1, 1, 1, 1),
(2, 'COM/ND/15/002', 'Bello', 'Aminda', 1, 1, 1, 1),
(3, 'COM/ND/15/003', 'Shehu', 'Isa Ali', 1, 1, 1, 1),
(4, 'COM/ND/15/004', 'Ibrahim', 'Abdul', 1, 1, 1, 1),
(5, 'ACC/ND/15/001', 'Bala', 'Bemuwa', 2, 1, 1, 1),
(6, 'ACC/ND/15/002', 'Dangara', 'Godiya Umar', 2, 1, 1, 1),
(7, 'ACC/ND/15/003', 'Baba', 'Anna', 2, 1, 1, 1),
(8, 'STA/ND/15/001', 'Asoo', 'Ephraim', 1, 3, 1, 0),
(9, 'STA/ND/15/003', 'Manaseh', 'Joseph', 1, 3, 1, 0),
(10, 'STA/ND/15/004', 'Iorfa', 'Fanen', 1, 3, 1, 0),
(11, 'AGT/ND/15/001', 'Musa', 'Aliyu', 3, 1, 1, 0),
(12, 'COM/ND/17/002', 'Timothy', 'Umar', 1, 1, 1, 1),
(13, 'COM/ND/17/006', 'Manasseh', 'Umar', 1, 1, 1, 1),
(14, 'COM/ND/17/007', 'Abdulgaffer', 'Bello', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_supervisor`
--

CREATE TABLE `tb_supervisor` (
  `id` int(11) NOT NULL,
  `staffid` varchar(12) NOT NULL,
  `firstname` varchar(15) NOT NULL,
  `othernames` varchar(30) NOT NULL,
  `school` int(1) NOT NULL,
  `department` int(1) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_supervisor`
--

INSERT INTO `tb_supervisor` (`id`, `staffid`, `firstname`, `othernames`, `school`, `department`, `status`) VALUES
(1, 'FPB/S/P/001', 'Igbashio', 'Julius Iorlumun', 1, 1, 1),
(2, 'FPB/S/P/002', 'Usman', 'Rasheedat Bello', 1, 1, 2),
(3, 'FPB/S/P/003', 'Usama', 'Binta', 2, 1, 2),
(4, 'FPB/S/P/045', 'Timothy', 'Umar', 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `id` int(11) NOT NULL,
  `stuid` int(11) NOT NULL,
  `topic` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`id`, `stuid`, `topic`, `status`, `date`) VALUES
(1, 2, 'Expert system for financial Planning and budgeting system', 1, '2017-08-02 18:32:57'),
(2, 2, 'Automated Online payroll system for an organisation', 2, '2017-08-02 18:32:57'),
(3, 2, 'Online Love Distribution system', 2, '2017-08-02 18:32:57'),
(4, 1, 'Automation of online Banking system', 1, '2017-08-03 12:18:26'),
(5, 14, 'Ayatutu ka unu', 2, '2019-10-01 18:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `Fullname` varchar(50) NOT NULL,
  `userType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `Fullname`, `userType`) VALUES
(1, 'Admin', 'admin', 'Administrator', 1),
(2, 'Sirjiskit', '23354972', 'Igbashio Julius Iorlumun', 1),
(5, 'Akin', 'akin2014', 'Anyor Abraham', 2),
(6, 'Sunday', 'sunday', 'Sunday Daniel', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projectwork`
--
ALTER TABLE `projectwork`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_schedulled`
--
ALTER TABLE `tb_schedulled`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_students`
--
ALTER TABLE `tb_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staffid` (`studentid`);

--
-- Indexes for table `tb_supervisor`
--
ALTER TABLE `tb_supervisor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staffid` (`staffid`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `projectwork`
--
ALTER TABLE `projectwork`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_schedulled`
--
ALTER TABLE `tb_schedulled`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_students`
--
ALTER TABLE `tb_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_supervisor`
--
ALTER TABLE `tb_supervisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
