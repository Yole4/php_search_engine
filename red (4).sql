-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2023 at 03:42 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `red`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_research_data`
--

CREATE TABLE `all_research_data` (
  `id` int(11) NOT NULL,
  `authors` varchar(500) NOT NULL,
  `research` varchar(200) NOT NULL,
  `status` varchar(20) NOT NULL,
  `proposed` varchar(20) NOT NULL,
  `started` varchar(20) NOT NULL,
  `completed` varchar(20) NOT NULL,
  `RorE` varchar(20) NOT NULL,
  `campus` varchar(20) NOT NULL,
  `college` varchar(20) NOT NULL,
  `rank` varchar(20) NOT NULL,
  `added_by` varchar(50) NOT NULL,
  `notification` int(1) NOT NULL DEFAULT '0',
  `date` varchar(50) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `document` varchar(100) NOT NULL,
  `id_sign` varchar(30) NOT NULL,
  `publicize` varchar(50) NOT NULL DEFAULT 'not',
  `getname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `all_research_data`
--

INSERT INTO `all_research_data` (`id`, `authors`, `research`, `status`, `proposed`, `started`, `completed`, `RorE`, `campus`, `college`, `rank`, `added_by`, `notification`, `date`, `file_name`, `document`, `id_sign`, `publicize`, `getname`) VALUES
(18, 'sd', 'JRMSU Research Development and Extension Portal with Plagiarism Detector', 'Proposed', 'January 1, 1970', '', '', 'Research', 'Dapitan', 'CCS', '', 'Admin', 0, 'April 25, 2023 6:22:pm', 'swimlane acitivity diagram.docx', '../../users/unit head/attributes/research documents/6447a9d1bdfc09.42216234.docx', 'RngjqlOzwL', 'not', '6447a9d1bdfc09.42216234.docx'),
(19, 'sample', 'research title', 'Proposed', 'January 1, 1970', '', '', 'Research', 'Dapitan', 'CCS', '', 'Admin', 0, 'April 25, 2023 6:23:pm', 'Chapter 3.docx', '../../users/unit head/attributes/research documents/6447aa09075b86.21387763.docx', '4SFm97iA0W', 'not', '6447aa09075b86.21387763.docx');

-- --------------------------------------------------------

--
-- Table structure for table `research_secretary`
--

CREATE TABLE `research_secretary` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `RorE` varchar(20) NOT NULL,
  `campus` varchar(20) NOT NULL,
  `college` varchar(20) NOT NULL,
  `rank` varchar(20) NOT NULL,
  `added_by` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `notification` int(1) NOT NULL DEFAULT '0',
  `id_sign` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `research_secretary`
--

INSERT INTO `research_secretary` (`id`, `fullname`, `password`, `email`, `phone_number`, `RorE`, `campus`, `college`, `rank`, `added_by`, `date`, `image`, `notification`, `id_sign`) VALUES
(43, 'Shelo Mora Paglinawan', '123', 'shelomora13@gmail.com', '09094991331', '', '', '', 'Admin', '', '', 'givenProfile.png', 1, ''),
(55, 'Mary Mae M. Paglinawan', '123', 'mary@gmail.com', '', 'Research', 'Dipolog', '', 'Unit Head', 'Admin', 'April 23, 2023 10:58:pm', 'givenProfile.png', 0, ''),
(56, 'Ronel A. Sta. Ana', '123', 'shelomora@gmail.com', '', 'Research', 'Dipolog', 'CAS', 'Chairperson', 'Unit Head', 'April 23, 2023 10:59:pm', 'givenProfile.png', 0, ''),
(66, 'sd', 'k10GDryh', 'sd@gmail.com', '', 'Research', 'Dapitan', 'CCS', 'Author', 'Admin', 'April 25, 2023 6:22:pm', 'givenProfile.png', 0, 'RngjqlOzwL'),
(67, 'sample', 'pNuaCVKs', 'sample@gmail.com', '', 'Research', 'Dapitan', 'CCS', 'Author', 'Admin', 'April 25, 2023 6:23:pm', 'givenProfile.png', 0, '4SFm97iA0W');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_presentation`
--

CREATE TABLE `schedule_presentation` (
  `id` int(11) NOT NULL,
  `authors` varchar(255) NOT NULL,
  `request_file` varchar(255) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `RorE` varchar(50) NOT NULL,
  `campus` varchar(50) NOT NULL,
  `college` varchar(50) NOT NULL,
  `chairperson` varchar(50) NOT NULL DEFAULT 'Pending',
  `unit_head` varchar(50) NOT NULL DEFAULT 'Pending',
  `admin` varchar(50) NOT NULL DEFAULT 'Pending',
  `date` varchar(50) NOT NULL,
  `research` varchar(255) NOT NULL,
  `send_chairperson` varchar(50) NOT NULL,
  `send_unit_head` varchar(50) NOT NULL,
  `send_admin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_research_data`
--
ALTER TABLE `all_research_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `research_secretary`
--
ALTER TABLE `research_secretary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_presentation`
--
ALTER TABLE `schedule_presentation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_research_data`
--
ALTER TABLE `all_research_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `research_secretary`
--
ALTER TABLE `research_secretary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `schedule_presentation`
--
ALTER TABLE `schedule_presentation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
