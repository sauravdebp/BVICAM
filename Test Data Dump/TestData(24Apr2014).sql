-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2014 at 05:37 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `bvicam`
--
CREATE DATABASE IF NOT EXISTS `bvicam` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `bvicam`;

--
-- Dumping data for table `announcement_all`
--

INSERT INTO `announcement_all` (`AnnouncementId`, `Content`, `Date`, `Time`, `CategoryId`, `Dirty`) VALUES
('ANN1123', 'Another Announcement', '2014-04-24', '20:58:57', 'C002', 0),
('Ann123', 'Sample COntetn', '2014-04-24', '20:58:38', 'C001', 0),
('Ann2323', 'Gosh another announcement', '2014-04-24', '21:03:11', 'C001', 0),
('Ann23233', 'Ya right! Its an announcement', '2014-04-24', '22:51:23', 'C003', 0),
('Ann3434', 'Still an announcement', '2014-04-24', '21:02:00', 'C002', 0),
('Annn232', 'Yet another annoucnement', '2014-04-24', '21:00:23', 'C001', 0);

--
-- Dumping data for table `announcement_category`
--

INSERT INTO `announcement_category` (`CategoryId`, `CategoryName`, `Dirty`) VALUES
('C001', 'Placements', 0),
('C002', 'Academics', 0),
('C003', 'Extra Curricular', 0),
('C004', 'NUES', 0);

--
-- Dumping data for table `announcement_group`
--

INSERT INTO `announcement_group` (`GroupId`, `GroupName`, `Dirty`) VALUES
('DG01', 'Semester2', 0),
('DG02', 'Shalini Mam Mentees', 0);

--
-- Dumping data for table `announcement_map_all_group`
--

INSERT INTO `announcement_map_all_group` (`AnnouncementId`, `GroupId`, `Dirty`) VALUES
('ANN1123', 'DG01', 0),
('ANN1123', 'DG02', 0),
('Ann123', 'DG02', 0);

--
-- Dumping data for table `announcement_map_all_tag`
--

INSERT INTO `announcement_map_all_tag` (`AnnouncementId`, `TagId`, `Dirty`) VALUES
('ANN1123', 'T001', 0),
('ANN1123', 'T002', 0);

--
-- Dumping data for table `announcement_tag`
--

INSERT INTO `announcement_tag` (`TagId`, `TagName`, `CategoryId`, `Dirty`) VALUES
('T001', 'DS', 'C002', 0),
('T002', 'Results', 'C001', 0);

--
-- Dumping data for table `api_developer`
--

INSERT INTO `api_developer` (`DeveloperId`, `API_Key`, `Dirty`) VALUES
('abc dvlupr', 'a77sdns666dsd8ds', 0),
('sysmax', 'sads776sd6asdsd', 0);

--
-- Dumping data for table `api_enduser`
--

INSERT INTO `api_enduser` (`UserId`, `DeveloperId`, `LastAccess`, `AccountStatus`, `Dirty`) VALUES
(911604413, 'abc dvlupr', '0000-00-00 00:00:00', 0, 0);

--
-- Dumping data for table `master_student`
--

INSERT INTO `master_student` (`RollNo`, `Batch`, `Semester`, `FirstName`, `LastName`, `Email`, `PhoneNo`, `Dirty`) VALUES
(911604413, 2013, 2, 'Saurabh', 'Sharma', 'lavishlibra0810@gmail.com', 9953533981, 0),
(4011604413, 2013, 2, 'Jitin', 'Dominic', 'jitin.dominic@gmail.com', 9560365906, 0),
(4511604413, 2013, 2, 'Pavithra', 'Gurumurthy', 'pavi@gmail.com', 91212121212, 0),
(4611604413, 2013, 2, 'Akshay', 'Rana', 'aksh@gmail.com', 98281212222, 0),
(5411604413, 2013, 2, 'Saurav', 'Deb Purkayastha', 'sauravdebp@gmail.com', 9818865297, 0);
