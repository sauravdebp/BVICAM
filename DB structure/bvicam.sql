-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2014 at 11:48 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bvicam`
--
CREATE DATABASE IF NOT EXISTS `bvicam` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `bvicam`;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_all`
--

CREATE TABLE IF NOT EXISTS `announcement_all` (
  `AnnouncementId` varchar(10) NOT NULL,
  `Content` varchar(100) NOT NULL DEFAULT 'No Announcement Content',
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `CategoryId` varchar(4) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`AnnouncementId`),
  KEY `CategoryId` (`CategoryId`),
  KEY `AnnouncementId` (`AnnouncementId`),
  KEY `CategoryId_2` (`CategoryId`),
  KEY `AnnouncementId_2` (`AnnouncementId`),
  KEY `CategoryId_3` (`CategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_category`
--

CREATE TABLE IF NOT EXISTS `announcement_category` (
  `CategoryId` varchar(4) NOT NULL,
  `CategoryName` varchar(20) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_group`
--

CREATE TABLE IF NOT EXISTS `announcement_group` (
  `GroupId` varchar(4) NOT NULL,
  `GroupName` varchar(20) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`GroupId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_group_dynamic`
--

CREATE TABLE IF NOT EXISTS `announcement_group_dynamic` (
  `GroupId` varchar(4) NOT NULL,
  `ScriptSource` varchar(100) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`GroupId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_group_static`
--

CREATE TABLE IF NOT EXISTS `announcement_group_static` (
  `GroupId` varchar(4) NOT NULL,
  `MembRollNo` int(11) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`GroupId`),
  KEY `MembRollNo` (`MembRollNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_map_all_group`
--

CREATE TABLE IF NOT EXISTS `announcement_map_all_group` (
  `AnnouncementId` varchar(10) NOT NULL,
  `GroupId` varchar(4) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`AnnouncementId`,`GroupId`),
  KEY `GroupId` (`GroupId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_map_all_tag`
--

CREATE TABLE IF NOT EXISTS `announcement_map_all_tag` (
  `AnnouncementId` varchar(10) NOT NULL,
  `TagId` varchar(4) NOT NULL,
  `Dirty` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`AnnouncementId`,`TagId`),
  KEY `TagId` (`TagId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_map_tag_group`
--

CREATE TABLE IF NOT EXISTS `announcement_map_tag_group` (
  `TagId` varchar(4) NOT NULL,
  `GroupId` varchar(4) NOT NULL,
  `Dirty` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TagId`,`GroupId`),
  KEY `GroupId` (`GroupId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_tag`
--

CREATE TABLE IF NOT EXISTS `announcement_tag` (
  `TagId` varchar(4) NOT NULL,
  `TagName` varchar(20) NOT NULL,
  `CategoryId` varchar(4) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TagId`),
  KEY `CategoryId` (`CategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `api_developer`
--

CREATE TABLE IF NOT EXISTS `api_developer` (
  `DeveloperId` varchar(10) NOT NULL,
  `API_Key` varchar(32) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`DeveloperId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `api_enduser`
--

CREATE TABLE IF NOT EXISTS `api_enduser` (
  `UserId` int(11) NOT NULL,
  `DeveloperId` varchar(10) NOT NULL,
  `LastAccess` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AccountStatus` tinyint(1) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserId`),
  KEY `DeveloperId` (`DeveloperId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_accumulated`
--

CREATE TABLE IF NOT EXISTS `attendance_accumulated` (
  `RollNo` int(11) NOT NULL,
  `SubCode` varchar(10) NOT NULL,
  `PresentCount` int(3) NOT NULL DEFAULT '0',
  `AbsentCount` int(3) NOT NULL DEFAULT '0',
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`RollNo`,`SubCode`),
  KEY `SubCode` (`SubCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_leaves`
--

CREATE TABLE IF NOT EXISTS `attendance_leaves` (
  `RollNo` int(11) NOT NULL,
  `SubCode` varchar(10) NOT NULL,
  `LeaveDate` date NOT NULL,
  `LeaveType` int(1) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`RollNo`,`SubCode`,`LeaveDate`),
  KEY `SubCode` (`SubCode`),
  KEY `LeaveType` (`LeaveType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_leave_count`
--

CREATE TABLE IF NOT EXISTS `attendance_leave_count` (
  `RollNo` int(11) NOT NULL,
  `LeaveType` int(1) NOT NULL,
  `UsedCount` int(2) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`RollNo`,`LeaveType`),
  KEY `LeaveType` (`LeaveType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_leave_type`
--

CREATE TABLE IF NOT EXISTS `attendance_leave_type` (
  `LeaveType` int(1) NOT NULL,
  `LeaveName` varchar(20) NOT NULL,
  `MaxLeaves` int(2) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`LeaveType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_student`
--

CREATE TABLE IF NOT EXISTS `master_student` (
  `RollNo` int(11) NOT NULL,
  `Batch` year(4) NOT NULL,
  `Semester` int(1) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `PhoneNo` int(12) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`RollNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_subject`
--

CREATE TABLE IF NOT EXISTS `master_subject` (
  `SubCode` varchar(10) NOT NULL,
  `SubName` varchar(50) NOT NULL,
  `Semester` int(1) NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SubCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `timetable_permanent`
--

CREATE TABLE IF NOT EXISTS `timetable_permanent` (
  `SubCode` varchar(10) NOT NULL,
  `Day` int(1) NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  KEY `SubCode` (`SubCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `timetable_temporary`
--

CREATE TABLE IF NOT EXISTS `timetable_temporary` (
  `SubCode` varchar(10) NOT NULL,
  `Date` date NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Dirty` tinyint(1) NOT NULL DEFAULT '0',
  KEY `SubCode` (`SubCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement_all`
--
ALTER TABLE `announcement_all`
  ADD CONSTRAINT `announcement_all_ibfk_1` FOREIGN KEY (`CategoryId`) REFERENCES `announcement_category` (`CategoryId`);

--
-- Constraints for table `announcement_group_dynamic`
--
ALTER TABLE `announcement_group_dynamic`
  ADD CONSTRAINT `announcement_group_dynamic_ibfk_1` FOREIGN KEY (`GroupId`) REFERENCES `announcement_group` (`GroupId`);

--
-- Constraints for table `announcement_group_static`
--
ALTER TABLE `announcement_group_static`
  ADD CONSTRAINT `announcement_group_static_ibfk_2` FOREIGN KEY (`MembRollNo`) REFERENCES `master_student` (`RollNo`),
  ADD CONSTRAINT `announcement_group_static_ibfk_1` FOREIGN KEY (`GroupId`) REFERENCES `announcement_group` (`GroupId`);

--
-- Constraints for table `announcement_map_all_group`
--
ALTER TABLE `announcement_map_all_group`
  ADD CONSTRAINT `announcement_map_all_group_ibfk_2` FOREIGN KEY (`GroupId`) REFERENCES `announcement_group` (`GroupId`),
  ADD CONSTRAINT `announcement_map_all_group_ibfk_1` FOREIGN KEY (`AnnouncementId`) REFERENCES `announcement_all` (`AnnouncementId`);

--
-- Constraints for table `announcement_map_all_tag`
--
ALTER TABLE `announcement_map_all_tag`
  ADD CONSTRAINT `announcement_map_all_tag_ibfk_2` FOREIGN KEY (`TagId`) REFERENCES `announcement_tag` (`TagId`),
  ADD CONSTRAINT `announcement_map_all_tag_ibfk_1` FOREIGN KEY (`AnnouncementId`) REFERENCES `announcement_all` (`AnnouncementId`);

--
-- Constraints for table `announcement_map_tag_group`
--
ALTER TABLE `announcement_map_tag_group`
  ADD CONSTRAINT `announcement_map_tag_group_ibfk_2` FOREIGN KEY (`GroupId`) REFERENCES `announcement_group` (`GroupId`),
  ADD CONSTRAINT `announcement_map_tag_group_ibfk_1` FOREIGN KEY (`TagId`) REFERENCES `announcement_tag` (`TagId`);

--
-- Constraints for table `announcement_tag`
--
ALTER TABLE `announcement_tag`
  ADD CONSTRAINT `announcement_tag_ibfk_1` FOREIGN KEY (`CategoryId`) REFERENCES `announcement_category` (`CategoryId`);

--
-- Constraints for table `api_enduser`
--
ALTER TABLE `api_enduser`
  ADD CONSTRAINT `api_enduser_ibfk_2` FOREIGN KEY (`DeveloperId`) REFERENCES `api_developer` (`DeveloperId`),
  ADD CONSTRAINT `api_enduser_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `master_student` (`RollNo`);

--
-- Constraints for table `attendance_accumulated`
--
ALTER TABLE `attendance_accumulated`
  ADD CONSTRAINT `attendance_accumulated_ibfk_2` FOREIGN KEY (`SubCode`) REFERENCES `master_subject` (`SubCode`),
  ADD CONSTRAINT `attendance_accumulated_ibfk_1` FOREIGN KEY (`RollNo`) REFERENCES `master_student` (`RollNo`);

--
-- Constraints for table `attendance_leaves`
--
ALTER TABLE `attendance_leaves`
  ADD CONSTRAINT `attendance_leaves_ibfk_3` FOREIGN KEY (`LeaveType`) REFERENCES `attendance_leave_type` (`LeaveType`),
  ADD CONSTRAINT `attendance_leaves_ibfk_1` FOREIGN KEY (`RollNo`) REFERENCES `master_student` (`RollNo`),
  ADD CONSTRAINT `attendance_leaves_ibfk_2` FOREIGN KEY (`SubCode`) REFERENCES `master_subject` (`SubCode`);

--
-- Constraints for table `attendance_leave_count`
--
ALTER TABLE `attendance_leave_count`
  ADD CONSTRAINT `attendance_leave_count_ibfk_2` FOREIGN KEY (`LeaveType`) REFERENCES `attendance_leave_type` (`LeaveType`),
  ADD CONSTRAINT `attendance_leave_count_ibfk_1` FOREIGN KEY (`RollNo`) REFERENCES `master_student` (`RollNo`);

--
-- Constraints for table `timetable_permanent`
--
ALTER TABLE `timetable_permanent`
  ADD CONSTRAINT `timetable_permanent_ibfk_1` FOREIGN KEY (`SubCode`) REFERENCES `master_subject` (`SubCode`);

--
-- Constraints for table `timetable_temporary`
--
ALTER TABLE `timetable_temporary`
  ADD CONSTRAINT `timetable_temporary_ibfk_1` FOREIGN KEY (`SubCode`) REFERENCES `master_subject` (`SubCode`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
