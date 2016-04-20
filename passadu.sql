-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 20, 2016 at 10:36 PM
-- Server version: 5.5.31-log
-- PHP Version: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pure_passadu`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `major_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL COMMENT 'หน่วย',
  `serial_no` varchar(45) DEFAULT NULL COMMENT 'หมายเลข Serial',
  `item_code` varchar(45) DEFAULT NULL,
  `in_stock` int(11) NOT NULL COMMENT 'จำนวนคงเหลือ',
  `item_detail` text COMMENT 'รายละเอียด',
  `price` double NOT NULL,
  `item_status` enum('ใช้ได้','ใช้ไม่ได้','ยังไม่ตรวจรับ') NOT NULL DEFAULT 'ใช้ได้' COMMENT 'สถานะ',
  PRIMARY KEY (`id`),
  KEY `fk_item_unit1_idx` (`unit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='พัสดุ/วัสดุ' AUTO_INCREMENT=46 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `name`, `major_id`, `unit_id`, `serial_no`, `item_code`, `in_stock`, `item_detail`, `price`, `item_status`) VALUES
(1, 'กระดาษ A4', 1, 4, 'SE123456', 'พส0001', 99, 'รายละเอียดพัสดุ', 29000, 'ใช้ได้'),
(2, 'ปากกาลูกลื่น', 1, 6, 'SE123451', 'พส0002', 50, 'ปากกาลูกลื่น 0.5 มม 50ด้าม น้ำเงิน', 195, 'ใช้ได้'),
(3, 'ปากกาลูกลื่น', 1, 6, 'SE123452', 'พส0003', 50, 'ปากกาลูกลื่น 50 ด้ามแลนเซอร์', 125, 'ใช้ได้'),
(4, 'ปากกาไวท์บอร์ด', 1, 1, 'SE123453', 'พส0004', 100, 'ปากกาสีน้ำเงิน,สีแดง', 4000, 'ใช้ได้'),
(5, 'แปรงลบกระดาน', 1, 8, 'SE123454', 'พส0005', 100, 'แปรงลบกระดานสีขาว,ดำ', 45, 'ใช้ได้'),
(6, 'หมึกเติมไวท์บอร์ด', 1, 6, 'SE123455', 'พส0006', 1, 'หมึกเติมไวท์บอร์ด 28 ซีซี', 59, 'ใช้ได้'),
(7, 'หมึกเติมไวท์บอร์ด', 1, 1, 'SE123457', 'พส0007', 1, 'หมึกเติมไวท์บอร์ด 28 ซีซี ตราม้า', 59, 'ใช้ได้'),
(8, 'ปากกาลบคำผิด', 1, 6, 'SE123458', 'พส0008', 20, 'ปากกาลบคำผิด Paper', 400, 'ใช้ได้'),
(9, 'ไม้บรรทัด', 1, 8, 'SE123459', 'พส0009', 50, 'ไม้บรรทัตพลาสติก', 100, 'ใช้ได้'),
(10, 'ดินสอ', 1, 7, 'SE1234510', 'พส0010', 70, 'ดินสอไม้', 500, 'ใช้ได้'),
(11, 'ยางลบ', 1, 2, 'SE1234511', 'พส0011', 70, 'ยางลบตราม้า', 300, 'ใช้ได้'),
(12, 'เครื่องเหลาดินสอ', 1, 1, 'SE1234512', 'พส0012', 7, 'เครื่องเหลาดินสอ ตราช้าง', 230, 'ใช้ได้'),
(13, 'คลิปหนีบกระดาษ', 1, 7, 'SE1234513', 'พส0013', 60, 'คลิปหนีบกระดาษ ตราช้าง', 500, 'ใช้ได้'),
(14, 'แฟ้มใส่เอกสาร', 1, 5, 'SE1234514', 'พส0014', 32, 'แฟ้มตราช้าง', 84, 'ใช้ได้'),
(15, 'กระดาษหน้าปก', 1, 5, 'SE1234515', 'พส0015', 28, 'กระดาษสี', 300, 'ใช้ได้'),
(16, 'แล็คซีน1.5นิ้ว', 1, 8, 'SE1234516', 'พส0016', 22, 'แล็คซีนติดหนังสือ', 240, 'ใช้ได้'),
(17, 'แล็คซีน2นิ้ว', 1, 8, 'SE1234517', 'พส0017', 22, 'แล็คซีนติดหนังสือ', 260, 'ใช้ได้'),
(18, 'กาวแท่ง', 1, 2, 'SE1234518', 'พส0018', 33, 'กาวแทงยาฮู', 219, 'ใช้ได้'),
(19, 'ที่เย็บกระดาษ', 1, 8, 'SE1234519', 'พส0019', 45, 'ที่เย็บกระดาษตราช้าง', 89, 'ใช้ได้'),
(20, 'ลวดเย็บกระดาษ', 1, 7, 'SE1234520', 'พส0020', 80, 'ลวดเย็บกระดาษ ตราม้า', 150, 'ใช้ได้'),
(21, 'ทีเจาะกระดาษ2รู', 1, 1, 'SE1234521', 'พส0021', 29, 'ที่เจาะกระดาษ ตราสมอ', 129, 'ใช้ได้'),
(22, 'แฟ้มเอกสารหนาเจาะ2รู', 1, 1, 'SE1234522', 'พส0022', 33, 'แฟ้มเอกสารตราช้าง', 59, 'ใช้ได้'),
(23, 'ซองใส่เอกสารสีน้ำตาล', 1, 2, 'SE1234523', 'พส0023', 79, 'ซองตรานกเพนกวิน', 55, 'ใช้ได้'),
(24, 'คัตเตอร์', 1, 2, 'SE1234524', 'พส0024', 43, 'คัตเตอร์ขนาดกลาง', 25, 'ใช้ได้'),
(25, 'ใบมีดคัตเตอร์', 1, 2, 'SE1234525', 'พส0025', 35, 'ใบมีดคัตเตอร์ขนาดกลาง', 230, 'ใช้ได้'),
(26, 'กรรไกร', 1, 6, 'SE1234526', 'พส0026', 54, 'กรรไกรตราดาว', 350, 'ใช้ได้'),
(27, 'กาว Latex Toa', 1, 9, 'SE1234527', 'พส0027', 5, 'กาว toa', 50, 'ใช้ได้'),
(28, 'ฟุตเหล็ก', 1, 8, 'SE1234528', 'พส0028', 24, 'ฟุตเหล็กยาว 12 นิ้ว', 200, 'ใช้ได้'),
(29, 'แผ่นยางรองตัด', 1, 2, 'SE1234529', 'พส0029', 10, 'แผ่นยางขนาดกลาง', 250, 'ใช้ได้'),
(30, 'แท่นตัดสก๊อตเทป', 1, 1, 'SE1234530', 'พส0030', 5, 'สก๊อตเทปใสขนาดใหญ่', 500, 'ใช้ได้'),
(31, 'ปล๊กคอม', 0, 2, 'SE1234531', 'พส0031', 10, 'ปล๊ก3 ตา ยี่ห้อlaser', 850, 'ใช้ได้'),
(32, 'เทปโฟม', 0, 2, 'SE1234532', 'พส0032', 10, 'เทปโฟมกาว 2 หน้าขนาดกลาง', 200, 'ใช้ได้'),
(33, 'แผ่น cd', 0, 7, 'SE1234533', 'พส0033', 100, 'แผ่น cd sony', 500, 'ใช้ได้'),
(34, 'เครื่องยิงตราช้าง', 0, 1, 'SE1234534', 'พส0034', 5, 'เครืองยิงกระดาษตราช้าง', 2000, 'ใช้ได้'),
(35, 'สันรูด', 0, 2, 'SE1234535', 'พส0035', 50, 'สันรูดหน้าปกคละขนาด', 250, 'ใช้ได้'),
(36, 'เครื่องคิดเลข', 0, 1, 'SE1234536', 'พส0036', 5, 'เครื่องคิดเลข casio', 500, 'ใช้ได้'),
(37, 'ที่แขวนตรางยาง', 0, 2, 'SE1234537', 'พส0037', 50, 'ทีแขวนตรายางขนาดเล็ก', 100, 'ใช้ได้'),
(38, 'ตะปูเข็ม', 0, 8, 'SE1234538', 'พส0038', 48, 'ตะปูเข็ม ตราม้า', 120, 'ใช้ได้'),
(39, 'ป้ายตั้งโต๊ะ', 0, 2, 'SE1234539', 'พส0039', 10, 'ป้ายตั้งโต๊ะขนาดเล็ก', 120, 'ใช้ได้'),
(40, 'ตรายางเฉพาะชื่อ', 0, 2, 'SE1234540', 'พส0040', 1, 'ตรายางเฉพาะชื่อขนาดเล็ก', 250, 'ใช้ได้'),
(42, '5', 2, 2, '2', '2', 2, '2', 2, 'ใช้ได้'),
(45, 'TEST 1 Object', 1, 1, '1', '1', 1, '1', 1, 'ใช้ได้');

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE IF NOT EXISTS `major` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `major` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT 'แผนก',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`id`, `major`) VALUES
(1, 'การจัดการสารสนเทศ'),
(2, 'การบัญชี'),
(3, 'การตลาด'),
(4, 'การจัดการอุตสาหกรรม'),
(5, 'ธุรกิจระหว่างประเทศ');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `OrderID` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `OrderDate` datetime NOT NULL,
  `OrderName` varchar(100) NOT NULL,
  `Major` varchar(500) NOT NULL,
  `Tel` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  PRIMARY KEY (`OrderID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11130 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `OrderDate`, `OrderName`, `Major`, `Tel`, `Email`) VALUES
(00001, '2012-03-15 09:59:13', 'Weerachai Nukitram', '1234 Lapharo Bangkok Thailand', '0819876107', 'is_php@hotmail.com'),
(00002, '2012-03-15 10:15:03', 'Weerachai Nukitram', '1234 Latpharo Bangkok Thailand', '0819876107', 'is_php@hotmail.com'),
(11114, '2016-04-10 07:52:12', 'yyyyy', 'yyyy', 'yyyy', 'yyyy'),
(11115, '2016-04-18 06:12:00', '1', '1', '11', '1'),
(11125, '2016-04-18 07:30:10', '5', '5', '5', '5'),
(11123, '2016-04-18 07:01:24', '111', '1111', '1111', '11111'),
(11124, '2016-04-18 07:16:05', 'ชื่อรายการ', 'สาขา', '1', 'อีเมล'),
(11126, '2016-04-18 07:36:19', 'testระบบ', 'testระบบ', 'testระบบ', 'testระบบ'),
(11127, '2016-04-18 07:41:42', '9999', '9999', '9999', '9999'),
(11128, '2016-04-18 14:43:46', '888', '888', '888', '888'),
(11129, '2016-04-20 22:24:14', '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `orders_detail`
--

CREATE TABLE IF NOT EXISTS `orders_detail` (
  `DetailID` int(5) NOT NULL AUTO_INCREMENT,
  `OrderID` int(5) unsigned zerofill NOT NULL,
  `ID` int(4) NOT NULL,
  `Qty` int(3) NOT NULL,
  PRIMARY KEY (`DetailID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `orders_detail`
--

INSERT INTO `orders_detail` (`DetailID`, `OrderID`, `ID`, `Qty`) VALUES
(1, 00001, 4, 1),
(44, 11127, 40, 1),
(45, 11128, 39, 1),
(46, 11128, 38, 1),
(47, 11129, 45, 2);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(45) NOT NULL COMMENT 'หน่วย',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='หน่วย' AUTO_INCREMENT=10 ;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `unit`) VALUES
(1, 'เครื่อง'),
(2, 'ชิ้น'),
(4, 'เล่ม'),
(5, 'รีม'),
(6, 'แพ็ค'),
(7, 'กล่อง'),
(8, 'โหล'),
(9, 'กระปุก');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL COMMENT 'ชื่อ',
  `lastname` varchar(100) NOT NULL COMMENT 'นามสกุล',
  `username` varchar(45) NOT NULL COMMENT 'ชื่อผู้ใบ้',
  `password` varchar(45) NOT NULL COMMENT 'รหัสผ่าน',
  `address` text NOT NULL COMMENT 'ที่อยู่',
  `major_id` int(2) NOT NULL,
  `tel` varchar(20) DEFAULT NULL COMMENT 'เบอร์โทร',
  `user_type` enum('admin','user') CHARACTER SET utf8mb4 NOT NULL DEFAULT 'user' COMMENT 'กลุ่มผู้ใช้งาน',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  KEY `fk_user_major1` (`major_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='ผู้ใช้งาน' AUTO_INCREMENT=37 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `password`, `address`, `major_id`, `tel`, `user_type`) VALUES
(1, 'มานพ', 'กองอุ่น', 'admin', 'admin', 'ทดสอบที่อยู่', 1, '1234567890', 'admin'),
(2, 'Demo', 'Demo', 'demo', 'demo', 'demo', 5, '000', 'user'),
(3, 'test', 'test', 'test', 'test', 'test', 2, '00', 'user'),
(20, 'วุด', 'วุด', 'wut', 'wut', 'wut', 1, '0000000', 'user'),
(29, 'pure', 'pure', 'pure', 'pure', 'pure', 1, 'pure', 'admin'),
(33, 'Hello', 'Hello', 'Hello', 'Hello', 'Hello', 1, 'Hello', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `widen`
--

CREATE TABLE IF NOT EXISTS `widen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'ผู้เบิก/ยืม',
  `widen_date` datetime NOT NULL COMMENT 'วันที่เบิก/ยืม',
  PRIMARY KEY (`id`),
  KEY `fk_widen_user1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='การเบิก/ยืม' AUTO_INCREMENT=9 ;

--
-- Dumping data for table `widen`
--

INSERT INTO `widen` (`id`, `user_id`, `widen_date`) VALUES
(1, 1, '2015-01-21 07:29:36'),
(2, 2, '2015-01-21 07:31:14'),
(3, 2, '2015-01-21 08:41:41'),
(5, 20, '2016-04-18 14:21:02'),
(6, 2, '2016-04-18 14:37:17');

-- --------------------------------------------------------

--
-- Table structure for table `widen_detail`
--

CREATE TABLE IF NOT EXISTS `widen_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widen_id` int(11) NOT NULL COMMENT 'การเบิก/ยืม',
  `item_id` int(11) NOT NULL COMMENT 'วัสดุ/พัสดุ',
  `widen_amount` int(11) NOT NULL COMMENT 'จำนวนเบิก/ยืม',
  PRIMARY KEY (`id`),
  KEY `fk_widen_detail_widen1_idx` (`widen_id`),
  KEY `fk_widen_detail_item1_idx` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='รายละเอียดการเบิก/ยืม' AUTO_INCREMENT=12 ;

--
-- Dumping data for table `widen_detail`
--

INSERT INTO `widen_detail` (`id`, `widen_id`, `item_id`, `widen_amount`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 2),
(3, 2, 2, 3),
(4, 3, 1, 1),
(5, 3, 2, 5),
(10, 5, 1, 1),
(11, 6, 26, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `fk_item_unit1` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_major1` FOREIGN KEY (`major_id`) REFERENCES `major` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `widen`
--
ALTER TABLE `widen`
  ADD CONSTRAINT `fk_widen_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `widen_detail`
--
ALTER TABLE `widen_detail`
  ADD CONSTRAINT `fk_widen_detail_item1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_widen_detail_widen1` FOREIGN KEY (`widen_id`) REFERENCES `widen` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
