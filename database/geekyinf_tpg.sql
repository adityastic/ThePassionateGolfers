-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2018 at 11:32 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `geekyinf_tpg`
--

-- --------------------------------------------------------

--
-- Table structure for table `coursecity`
--

CREATE TABLE IF NOT EXISTS `coursecity` (
  `ccid` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(50) NOT NULL,
  PRIMARY KEY (`ccid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `coursecity`
--

INSERT INTO `coursecity` (`ccid`, `city`) VALUES
(1, 'Ahmedabad'),
(2, 'Mumbai'),
(3, 'Pune');

-- --------------------------------------------------------

--
-- Table structure for table `tbadmin`
--

CREATE TABLE IF NOT EXISTS `tbadmin` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobileno` bigint(10) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbadmin`
--

INSERT INTO `tbadmin` (`aid`, `fullname`, `email`, `password`, `mobileno`) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2y$11$Oe/uvQtFVR94wiECHueLeu1S9jBFwUMrXssNFmqiY4Zf.a/pITXKG', 9922992299);

-- --------------------------------------------------------

--
-- Table structure for table `tbcourse`
--

CREATE TABLE IF NOT EXISTS `tbcourse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coursename` varchar(50) NOT NULL,
  `courseshortname` varchar(50) NOT NULL,
  `courseimg` text NOT NULL,
  `ccid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ccid` (`ccid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbcourse`
--

INSERT INTO `tbcourse` (`id`, `coursename`, `courseshortname`, `courseimg`, `ccid`) VALUES
(1, 'Kharghar Valley Golf Course', 'KVGC', 'kvgc.jpg', 2),
(2, 'Pune Golf Course', 'PGC', 'pgcp.jpg', 3),
(3, 'Oxford Golf Resort', 'OXGC', 'of.jpg', 3),
(4, 'Kalhaar Blue & Green Golf Course', 'KGGGC', 'kbggc.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbgolfcourse`
--

CREATE TABLE IF NOT EXISTS `tbgolfcourse` (
  `gcid` int(11) NOT NULL AUTO_INCREMENT,
  `gcfullname` varchar(50) NOT NULL,
  `gcshortname` varchar(50) NOT NULL,
  `gcimage` text NOT NULL,
  `description` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `holes` text NOT NULL,
  `strokeindex` text NOT NULL,
  PRIMARY KEY (`gcid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `tbgolfcourse`
--

INSERT INTO `tbgolfcourse` (`gcid`, `gcfullname`, `gcshortname`, `gcimage`, `description`, `city`, `holes`, `strokeindex`) VALUES
(45, 'Kalhaar Blue Green Golf Club', 'KGGGC', 'kbggc.jpg', 'Kalhaar Blues & Greens is a legendary place â€“ envisaged to combine dramatic natural beauty with world-class accommodations, warm hospitality, expert service and grand recreation. In India it is the first golf course which is designed by â€˜Nicklaus Designâ€™ the leading golf course designing firm owned by the legendary golfer Jack Nicklaus.', 'Ahmedabad', '["3","4","5","3","4","5","3","4","5","3","4","5","3","4","5","3","4","5"]', '["17","15","18","17","16","15","14","13","12","12","11","10","9","8","7","13","16","18"]'),
(46, 'Kharghar Valley Golf Course', 'KVGC', 'kvgc.jpg', 'About 3.5 to 4 km from Kharghar Railway Station is 18 Holes Kharghar Valley Golf Course at Sector 22 of Navi Mumbai. First of its kind of luxurious Public Golf Course opened on 23rd December 2012 which was much awaited prior 9 Months. Membership Details, One day golfing charges, lifetime Membership Fees, Discounts for students and CIDCO employees and fees for Mumbai citizens and Foreign nationals etc.', 'Mumbai', '["3","4","5","3","4","5","3","4","5","3","4","5","3","4","5","3","4","5"]', '["20","19","18","20","19","18","20","19","18","16","14","13","19","18","10","14","17","14"]'),
(47, 'Oxford Golf Resort', 'OXGC', 'of.jpg', 'Oxford Group introduces Puneâ€™s first luxury hotel apartments â€“ â€˜The Residencesâ€™ located at the Oxford Golf Resort, rated as one of Asiaâ€™s top golf courses, clubhouse and hotel. The apartments overlook the lush green golf course and equips you with membership thereby giving you access to play, free golf lessons and numerous other perks.', 'Pune', '["3","4","5","3","4","5","3","4","5","3","4","5","3","4","5","3","4","5"]', '["20","19","18","20","19","18","20","19","18","17","16","15","14","12","10","14","16","18"]'),
(50, 'Kalhaar Blue & Green Golf Course', 'KGGGC', 'p.jpg', 'fgdg dfgd fg wewewe', 'Ahmedabad', '["3","4","3","5","3","4","4","5","3","0","0","0","0","0","0","0","0","0"]', '["20","18","18","16","15","17","18","11","7","0","0","0","0","0","0","0","0","0"]'),
(54, 'Kalhaar Blue & Green Golf Course', 'KGGGC', '', 'ssdf sfsdf sdf', 'Ahmedabad', '["3","4","5","","","","","","","","","","","","","","",""]', '["20","19","18","","","","","","","","","","","","","","",""]');

-- --------------------------------------------------------

--
-- Table structure for table `tbgolfmember`
--

CREATE TABLE IF NOT EXISTS `tbgolfmember` (
  `gmid` int(11) NOT NULL AUTO_INCREMENT,
  `gmfullname` varchar(50) NOT NULL,
  `gmshortname` varchar(5) NOT NULL,
  `gmpp` text,
  `city` varchar(50) NOT NULL,
  `area` varchar(50) NOT NULL,
  `handicap` int(3) NOT NULL,
  PRIMARY KEY (`gmid`),
  UNIQUE KEY `gmshortname` (`gmshortname`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `tbgolfmember`
--

INSERT INTO `tbgolfmember` (`gmid`, `gmfullname`, `gmshortname`, `gmpp`, `city`, `area`, `handicap`) VALUES
(33, 'Abhishek Shah', 'ASAM', 'as.jpg', 'Surat', 'Nanpura', 9),
(34, 'Manthan Bhatt', 'MBAM', 'pp.jpg', 'Surat', 'Athwaline', 18),
(35, 'Aditya Gupta', 'AGAM', '', 'Pune', 'Katrej', 14),
(36, 'Vivek Modi', 'VMAM', '', 'Pune', 'Katrej', 15),
(37, 'Burhan Mullamitha', 'BMAM', '', 'Pune', 'Katrej', 12),
(38, 'Ashutosh Mishra', 'AMAM', '', 'Pune', 'Katrej', 7),
(39, 'Rishabh Khandelwal', 'RKAM', '', 'Pune', 'Katrej', 12),
(40, 'Joy Basu', 'JBAM', '', 'Pune', 'FC Road', 15),
(41, 'Prashant Hinduja', 'PHAM', '', 'Pune', 'Hinjwadi', 4),
(43, 'Samar Desai', 'SDAM', '', 'Surat', 'Bhatar', 18),
(44, 'Parth Rathod', 'PRAM', '', 'Surat', 'Piplod', 6),
(45, 'Dishant Shah', 'DSAM', '', 'Surat', 'Vesu', 18),
(46, 'Sagar shah', 'SGSA', '', 'Pune', 'Katrej', 22),
(49, 'Vinayak Dudhe', 'VPD', '', 'Pune', 'Katraj', 30);

-- --------------------------------------------------------

--
-- Table structure for table `tbgolftournament`
--

CREATE TABLE IF NOT EXISTS `tbgolftournament` (
  `gtid` int(11) NOT NULL AUTO_INCREMENT,
  `gtname` text NOT NULL,
  `gtstartdate` date NOT NULL,
  `gtdate` date NOT NULL,
  `gttime` time NOT NULL,
  `gtmember` text NOT NULL,
  `gtcourse` varchar(50) NOT NULL,
  `scoreboard` text NOT NULL,
  PRIMARY KEY (`gtid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `tbgolftournament`
--

INSERT INTO `tbgolftournament` (`gtid`, `gtname`, `gtstartdate`, `gtdate`, `gttime`, `gtmember`, `gtcourse`, `scoreboard`) VALUES
(29, 'Golf Champions Tournament 2018', '2018-06-24', '2018-06-24', '06:00:00', '["33","37","34","35","38","40","41","39","36","46"]', 'Kalhaar Blue Green Golf Club', '[{"SGSA":[4,4,-1,-1,-1,-1,-1,-1,-1,4,-1,-1,-1,-1,-1,-1,-1,-1]},{"PHAM":[1,5,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]},{"VMAM":[9,5,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]},{"RKAM":[2,2,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]},{"JBAM":[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,1,3,-1,-1,-1,-1,-1,-1]},{"AMAM":[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,1,1,-1,-1,-1,-1,-1,-1]},{"AGAM":[-1,4,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]},{"ASAM":[2,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]},{"BMAM":[1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]},{"MBAM":[1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]}]'),
(30, '', '0000-00-00', '0000-00-00', '00:00:00', 'null', '', ''),
(31, 'Vin Tournament', '2018-06-06', '2018-06-08', '10:10:00', '["33","35","38","37"]', 'Kalhaar Blue Green Golf Club', ''),
(33, 'Test', '2018-06-22', '2018-06-25', '10:10:00', '["46","43","49","36"]', 'Oxford Golf Resort', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbcourse`
--
ALTER TABLE `tbcourse`
  ADD CONSTRAINT `tbcourse_ibfk_1` FOREIGN KEY (`ccid`) REFERENCES `coursecity` (`ccid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
