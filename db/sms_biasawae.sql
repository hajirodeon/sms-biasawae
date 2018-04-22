-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 30, 2011 at 10:24 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1biasawae4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sms_biasawae`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE IF NOT EXISTS `absensi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pbkID` int(11) NOT NULL,
  `ket` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `pbkID`, `ket`) VALUES
(1, 10, 'vmvmmgmgxxxx'),
(2, 9, 'nncnnbfdbd'),
(3, 7, 'jvhvjhv');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `daemons`
--

CREATE TABLE IF NOT EXISTS `daemons` (
  `Start` text NOT NULL,
  `Info` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `daemons`
--


-- --------------------------------------------------------

--
-- Table structure for table `gammu`
--

CREATE TABLE IF NOT EXISTS `gammu` (
  `Version` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gammu`
--

INSERT INTO `gammu` (`Version`) VALUES
(11);

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE IF NOT EXISTS `inbox` (
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ReceivingDateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Text` text NOT NULL,
  `SenderNumber` varchar(20) NOT NULL DEFAULT '',
  `Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression',
  `UDH` text NOT NULL,
  `SMSCNumber` varchar(20) NOT NULL DEFAULT '',
  `Class` int(11) NOT NULL DEFAULT '-1',
  `TextDecoded` text NOT NULL,
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `RecipientID` text NOT NULL,
  `Processed` enum('false','true') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `inbox`
--

INSERT INTO `inbox` (`UpdatedInDB`, `ReceivingDateTime`, `Text`, `SenderNumber`, `Coding`, `UDH`, `SMSCNumber`, `Class`, `TextDecoded`, `ID`, `RecipientID`, `Processed`) VALUES
('2011-07-25 11:04:51', '2011-07-24 22:08:28', '005900650073002E', '+62818298854', 'Default_No_Compression', '', '+62818445009', -1, 'Yes.', 7, '', 'true'),
('2011-07-25 11:04:51', '2011-07-24 22:08:13', '004F006B002E', '+62818298854', 'Default_No_Compression', '', '+62818445009', -1, 'Ok.', 6, '', 'true'),
('2011-07-25 11:04:51', '2011-07-24 11:10:54', '005900650073002E', '+62818298854', 'Default_No_Compression', '', '+62818445009', -1, 'Yes.', 3, '', 'true'),
('2011-07-25 11:04:51', '2011-07-24 11:18:01', '004F006B002E', '+62818298854', 'Default_No_Compression', '', '+62818445009', -1, 'Ok.', 4, '', 'true'),
('2011-07-25 11:04:51', '2011-07-24 21:21:49', '004F006B002E0020004700700070002E', '+62818298854', 'Default_No_Compression', '', '+62818445009', -1, 'Ok. Gpp.', 5, '', 'true'),
('2011-07-25 11:04:51', '2011-07-25 02:20:17', '00420065007200650073002000790061002E0020002E', '+62818298854', 'Default_No_Compression', '', '+62818445009', -1, 'Beres ya. .', 10, '', 'true'),
('2011-07-25 11:04:51', '2011-07-25 02:05:05', '004F006B002E', '+62818298854', 'Default_No_Compression', '', '+62818445009', -1, 'Ok.', 9, '', 'true'),
('2011-07-25 11:10:56', '2011-07-25 03:10:04', '00520045004700230034002300480041004A00490052', '+62818298854', 'Default_No_Compression', '', '+62818445009', -1, 'REG#4#HAJIR', 11, '', 'true'),
('2011-07-25 11:15:54', '2011-07-25 03:13:14', '004F006B002E0020005400680061006E006B0073002E', '+62818298854', 'Default_No_Compression', '', '+62818445009', -1, 'Ok. Thanks.', 12, '', 'true'),
('2011-07-25 11:15:56', '2011-07-25 03:14:34', '00520045004700230037003200230053004F0042005200490032', '+62818298854', 'Default_No_Compression', '', '+62818445009', -1, 'REG#72#SOBRI2', 13, '', 'true'),
('2011-07-25 11:15:56', '2011-07-25 03:16:06', '00520045004700230037003200230053004F0042005200490032', '+62818298854', 'Default_No_Compression', '', '+62818445009', -1, 'REG#72#SOBRI2', 14, '', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `outbox`
--

CREATE TABLE IF NOT EXISTS `outbox` (
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `InsertIntoDB` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `SendingDateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Text` text,
  `DestinationNumber` varchar(20) NOT NULL DEFAULT '',
  `Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression',
  `UDH` text,
  `Class` int(11) DEFAULT '-1',
  `TextDecoded` text NOT NULL,
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MultiPart` enum('false','true') DEFAULT 'false',
  `RelativeValidity` int(11) DEFAULT '-1',
  `SenderID` varchar(255) DEFAULT NULL,
  `SendingTimeOut` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `DeliveryReport` enum('default','yes','no') DEFAULT 'default',
  `CreatorID` text NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `outbox_date` (`SendingDateTime`,`SendingTimeOut`),
  KEY `outbox_sender` (`SenderID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `outbox`
--


-- --------------------------------------------------------

--
-- Table structure for table `outbox_multipart`
--

CREATE TABLE IF NOT EXISTS `outbox_multipart` (
  `Text` text,
  `Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression',
  `UDH` text,
  `Class` int(11) DEFAULT '-1',
  `TextDecoded` text,
  `ID` int(10) unsigned NOT NULL DEFAULT '0',
  `SequencePosition` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`,`SequencePosition`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `outbox_multipart`
--


-- --------------------------------------------------------

--
-- Table structure for table `pbk`
--

CREATE TABLE IF NOT EXISTS `pbk` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `GroupID` int(11) NOT NULL DEFAULT '-1',
  `nis` varchar(10) NOT NULL,
  `Name` text NOT NULL,
  `Number` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `pbk`
--

INSERT INTO `pbk` (`ID`, `GroupID`, `nis`, `Name`, `Number`) VALUES
(10, 1, '344', '543', '818298854'),
(9, 1, '72', 'agus', '818298854'),
(7, 2, '4', 'hajir', '818298854'),
(11, 5, '12348', 'biasawae', '818298854');

-- --------------------------------------------------------

--
-- Table structure for table `pbk_groups`
--

CREATE TABLE IF NOT EXISTS `pbk_groups` (
  `Name` text NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pbk_groups`
--

INSERT INTO `pbk_groups` (`Name`, `ID`) VALUES
('Ixgmringxa', 1),
('Ixgmringxb', 2),
('Ixgmringxc', 5);

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--

CREATE TABLE IF NOT EXISTS `phones` (
  `ID` text NOT NULL,
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `InsertIntoDB` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `TimeOut` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Send` enum('yes','no') NOT NULL DEFAULT 'no',
  `Receive` enum('yes','no') NOT NULL DEFAULT 'no',
  `IMEI` varchar(35) NOT NULL,
  `Client` text NOT NULL,
  `Battery` int(11) NOT NULL DEFAULT '0',
  `Signal` int(11) NOT NULL DEFAULT '0',
  `Sent` int(11) NOT NULL DEFAULT '0',
  `Received` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IMEI`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phones`
--

INSERT INTO `phones` (`ID`, `UpdatedInDB`, `InsertIntoDB`, `TimeOut`, `Send`, `Receive`, `IMEI`, `Client`, `Battery`, `Signal`, `Sent`, `Received`) VALUES
('', '2011-07-25 11:19:27', '2011-07-25 05:20:49', '2011-07-25 11:19:37', 'yes', 'yes', '352965040243782', 'Gammu 1.28.0, Linux, kernel 2.6.39-biasawae, GCC 4.5', 0, 72, 14, 10);

-- --------------------------------------------------------

--
-- Table structure for table `sentitems`
--

CREATE TABLE IF NOT EXISTS `sentitems` (
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `InsertIntoDB` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `SendingDateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DeliveryDateTime` timestamp NULL DEFAULT NULL,
  `Text` text NOT NULL,
  `DestinationNumber` varchar(20) NOT NULL DEFAULT '',
  `Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression',
  `UDH` text NOT NULL,
  `SMSCNumber` varchar(20) NOT NULL DEFAULT '',
  `Class` int(11) NOT NULL DEFAULT '-1',
  `TextDecoded` text NOT NULL,
  `ID` int(10) unsigned NOT NULL DEFAULT '0',
  `SenderID` varchar(255) NOT NULL,
  `SequencePosition` int(11) NOT NULL DEFAULT '1',
  `Status` enum('SendingOK','SendingOKNoReport','SendingError','DeliveryOK','DeliveryFailed','DeliveryPending','DeliveryUnknown','Error') NOT NULL DEFAULT 'SendingOK',
  `StatusError` int(11) NOT NULL DEFAULT '-1',
  `TPMR` int(11) NOT NULL DEFAULT '-1',
  `RelativeValidity` int(11) NOT NULL DEFAULT '-1',
  `CreatorID` text NOT NULL,
  PRIMARY KEY (`ID`,`SequencePosition`),
  KEY `sentitems_date` (`DeliveryDateTime`),
  KEY `sentitems_tpmr` (`TPMR`),
  KEY `sentitems_dest` (`DestinationNumber`),
  KEY `sentitems_sender` (`SenderID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sentitems`
--

INSERT INTO `sentitems` (`UpdatedInDB`, `InsertIntoDB`, `SendingDateTime`, `DeliveryDateTime`, `Text`, `DestinationNumber`, `Coding`, `UDH`, `SMSCNumber`, `Class`, `TextDecoded`, `ID`, `SenderID`, `SequencePosition`, `Status`, `StatusError`, `TPMR`, `RelativeValidity`, `CreatorID`) VALUES
('2011-07-25 06:06:57', '0000-00-00 00:00:00', '2011-07-25 06:06:57', NULL, '0079006F002E002E002E', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'yo...', 27, '', 1, 'SendingOKNoReport', -1, 153, 255, 'gammu'),
('2011-07-24 18:58:31', '0000-00-00 00:00:00', '2011-07-24 18:58:31', NULL, '0061007000610061006E0020007400750068002E002E002E003F', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'apaan tuh...?', 20, '', 1, 'SendingOKNoReport', -1, 144, 255, 'gammu'),
('2011-07-24 19:10:10', '0000-00-00 00:00:00', '2011-07-24 19:10:10', NULL, '007300690061007000200061006A00610020007300690068002E002E002E', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'siap aja sih...', 21, '', 1, 'SendingOKNoReport', -1, 145, 255, 'gammu'),
('2011-07-25 06:06:52', '0000-00-00 00:00:00', '2011-07-25 06:06:52', NULL, '006100790075006B006B002E002E002E002E', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'ayukk....', 26, '', 1, 'SendingOKNoReport', -1, 152, 255, 'gammu'),
('2011-07-25 05:20:54', '0000-00-00 00:00:00', '2011-07-25 05:20:54', NULL, '0063006F006200610020006C006100670069002E002E002E', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'coba lagi...', 23, '', 1, 'SendingOKNoReport', -1, 149, 255, 'gammu'),
('2011-07-25 06:20:36', '0000-00-00 00:00:00', '2011-07-25 06:20:36', NULL, '00610061006100610073', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'aaaas', 29, '', 1, 'SendingOKNoReport', -1, 154, 255, 'gammu'),
('2011-07-25 06:21:09', '0000-00-00 00:00:00', '2011-07-25 06:21:09', NULL, '00610061006100610073', '+62812', 'Default_No_Compression', '', '+628315000032', -1, 'aaaas', 28, '', 1, 'SendingError', -1, -1, 255, 'gammu'),
('2011-07-25 06:21:15', '0000-00-00 00:00:00', '2011-07-25 06:21:15', NULL, '00670064006700640067006400670064', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'gdgdgdgd', 30, '', 1, 'SendingOKNoReport', -1, 156, 255, 'gammu'),
('2011-07-25 09:56:25', '0000-00-00 00:00:00', '2011-07-25 09:56:25', NULL, '004B00650074002E0041006200730065006E007300690020003D0020006A007600680076006A00680076002E00200075006E00740075006B0020004E00490053003A0034002E', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'Ket.Absensi = jvhvjhv. untuk NIS:4.', 31, '', 1, 'SendingOKNoReport', -1, 158, 255, 'gammu'),
('2011-07-25 10:04:17', '0000-00-00 00:00:00', '2011-07-25 10:04:17', NULL, '0053004F0050002000420075006C0061006E0020003D0020006A0075006E006900200032003000310031002E00200075006E00740075006B0020004E00490053003A003300340034002E', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'SOP Bulan = juni 2011. untuk NIS:344.', 32, '', 1, 'SendingOKNoReport', -1, 160, 255, 'gammu'),
('2011-07-25 10:04:23', '0000-00-00 00:00:00', '2011-07-25 10:04:23', NULL, '0053004F0050002000420075006C0061006E0020003D0020006A0075006E006900200032003000310031002E00200075006E00740075006B0020004E00490053003A003300340034002E', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'SOP Bulan = juni 2011. untuk NIS:344.', 33, '', 1, 'SendingOKNoReport', -1, 161, 255, 'gammu'),
('2011-07-25 10:19:29', '0000-00-00 00:00:00', '2011-07-25 10:19:29', NULL, '00680061006C006F002E002E002E', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'halo...', 34, '', 1, 'SendingOKNoReport', -1, 162, 255, 'gammu'),
('2011-07-25 11:11:46', '0000-00-00 00:00:00', '2011-07-25 11:11:46', NULL, '00530065006C0061006D00610074002C00200041006E00640061002000540065006C0061006800200042006500720068006100730069006C00200052006500670069007300740072006100730069', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'Selamat, Anda Telah Berhasil Registrasi', 42, '', 1, 'SendingOKNoReport', -1, 165, 255, 'Gammu'),
('2011-07-25 11:15:59', '0000-00-00 00:00:00', '2011-07-25 11:15:59', NULL, '004D006100610066002C002000520065006700690073007400720061007300690020005400650072006A0061006400690020004B00650067006100670061006C0061006E002E0020004800610072006100700020004400690070006500720068006100740069006B0061006E002E002E002E00210021002E', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'Maaf, Registrasi Terjadi Kegagalan. Harap Diperhatikan...!!.', 43, '', 1, 'SendingOKNoReport', -1, 168, 255, 'Gammu'),
('2011-07-25 11:16:05', '0000-00-00 00:00:00', '2011-07-25 11:16:05', NULL, '00530065006C0061006D00610074002C00200041006E00640061002000540065006C0061006800200042006500720068006100730069006C00200052006500670069007300740072006100730069002E', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'Selamat, Anda Telah Berhasil Registrasi.', 45, '', 1, 'SendingOKNoReport', -1, 169, 255, 'Gammu'),
('2011-07-25 11:16:11', '0000-00-00 00:00:00', '2011-07-25 11:16:11', NULL, '00530065006C0061006D00610074002C00200041006E00640061002000540065006C0061006800200042006500720068006100730069006C00200052006500670069007300740072006100730069002E', '+62818298854', 'Default_No_Compression', '', '+628315000032', -1, 'Selamat, Anda Telah Berhasil Registrasi.', 44, '', 1, 'SendingOKNoReport', -1, 170, 255, 'Gammu');

-- --------------------------------------------------------

--
-- Table structure for table `sop`
--

CREATE TABLE IF NOT EXISTS `sop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pbkID` int(11) NOT NULL,
  `bulan` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sop`
--

INSERT INTO `sop` (`id`, `pbkID`, `bulan`) VALUES
(1, 10, 'juni 2011');
