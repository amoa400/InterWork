-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 11, 2013 at 12:14 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `interview`
--

-- --------------------------------------------------------

--
-- Table structure for table `it_plugin_blackboard`
--

CREATE TABLE IF NOT EXISTS `it_plugin_blackboard` (
  `room_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`room_id`,`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `it_plugin_blackboard`
--

INSERT INTO `it_plugin_blackboard` (`room_id`, `id`, `content`, `user_id`) VALUES
(1, 1, '', 0),
(1, 18, '', 0),
(1, 84, '', 0),
(1, 1123, '', 0),
(1, 1266, '', 0),
(1, 1178, '', 0),
(1, 227, '', 0),
(1, 792, '', 0),
(1, 1059, '', 0),
(1, 1024, '', 0),
(1, 973, '', 0),
(1, 924, '', 0),
(1, 1205, '', 0),
(1, 993, '', 0),
(1, 863, '', 0),
(1, 1280, '', 0),
(1, 932, '', 0),
(1, 585, '', 0),
(1, 809, '', 0),
(1, 1710, '', 0),
(1, 561, '', 0),
(1, 1621, '', 0),
(1, 1718, '', 0),
(1, 1977, '', 0),
(1, 1537, '', 0),
(1, 2179, '', 0),
(1, 2071, '', 0),
(1, 2143, '', 0),
(1, 1934, '', 0),
(1, 1996, '', 0),
(1, 2115, '', 0),
(1, 2044, '', 0),
(1, 2230, '', 0),
(1, 1954, '', 0),
(1, 2032, '', 0),
(1, 2156, '', 0),
(1, 2087, '', 0),
(1, 1914, '', 0),
(1, 2037, '', 0),
(1, 2231, '0,0,clear;', 1),
(1, 1911, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `it_plugin_code`
--

CREATE TABLE IF NOT EXISTS `it_plugin_code` (
  `room_id` int(11) NOT NULL,
  `code` text NOT NULL,
  `identifier` int(11) NOT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `it_plugin_code`
--

INSERT INTO `it_plugin_code` (`room_id`, `code`, `identifier`) VALUES
(0, '#include <cstdio>#include <cstdlib>#include <ios...', 0),
(1, '#include <iostream>\nusing namespace std;\n\nint main() {\n    int a, b;\n    cin >> a >> b;\n    cout << a + b << endl;\n    return 0;\n}\n\n\n\n\n\n\n\n\n\n\n\n\n\n', 1917);

-- --------------------------------------------------------

--
-- Table structure for table `it_plugin_message`
--

CREATE TABLE IF NOT EXISTS `it_plugin_message` (
  `room_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(500) NOT NULL,
  `time` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`room_id`,`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `it_plugin_message`
--

INSERT INTO `it_plugin_message` (`room_id`, `id`, `content`, `time`, `user_id`) VALUES
(1, 1, '欢迎进入百姓网在线面试房间（BX1234）！', 0, 0),
(1, 2, '你好！', 0, 2),
(1, 3, '嗯，你好！', 0, 1),
(1, 4, '放大', 0, 2),
(1, 5, '方法', 0, 2),
(1, 6, '1', 1371900429, 1),
(1, 7, '2', 1371900429, 1),
(1, 8, '1', 1371900430, 1),
(1, 9, '2', 1371900430, 1),
(1, 10, '1', 1371900440, 1),
(1, 11, '2', 1371900440, 1),
(1, 12, 'ggg', 1371901079, 1),
(1, 13, 'dafsfa', 1371901119, 1),
(1, 14, 'ff', 1371901132, 2),
(1, 15, 'fff', 1371901177, 1),
(1, 16, 'dd', 1371901371, 2),
(1, 17, 'gg', 1371901382, 1),
(1, 18, 'ggg', 1371901394, 1),
(1, 19, 'hhh', 1371901398, 2),
(1, 20, 'ff', 1371901919, 2),
(1, 21, '你好啊', 1371901925, 2),
(1, 22, '你好不好', 1371901930, 1),
(1, 23, '阿的萨菲', 1371902157, 1),
(1, 24, '的萨菲撒大幅撒', 1371902165, 1),
(1, 25, '你说呢', 1371902168, 1),
(1, 26, 'hhh', 1372312802, 1),
(1, 27, 'ooo', 1372661257, 2),
(1, 28, 'aaa', 1372661260, 1),
(1, 29, '你好！', 1372754751, 1),
(1, 30, '你好啊！！', 1372754756, 1),
(1, 31, '请说话！', 1372754758, 1),
(1, 32, '同学', 1372754760, 1),
(1, 33, '你在干嘛呢？', 1372754763, 1),
(1, 34, 'meiyou', 1372754770, 2),
(1, 35, '看到了啊', 1372754774, 1),
(1, 36, '？？？', 1372754776, 1),
(1, 37, '没有', 1372754776, 2),
(1, 38, '神马都没有', 1372754785, 2),
(1, 39, 'hihi', 1372754997, 2),
(1, 40, '', 1372754998, 2),
(1, 41, '你好', 1372755145, 1),
(1, 42, 'hao ', 1372755149, 2),
(1, 43, '你多大啦', 1372755156, 1),
(1, 44, '21', 1372755159, 2),
(1, 45, '哦', 1372755163, 1),
(1, 46, '我们开始面试阿布', 1372755166, 1),
(1, 47, '吧', 1372755167, 1),
(1, 48, '好啊', 1372755168, 2),
(1, 49, '请帮我写个A+B的程序吧', 1372755177, 1),
(1, 50, '好坑爹啊', 1372755259, 2),
(1, 51, '好坑爹啊', 1372755274, 2),
(1, 52, '太坑爹啦', 1372755350, 2),
(1, 53, 'ddd', 1372900663, 1),
(1, 54, 'hello', 1373262026, 1),
(1, 55, 'hello', 1373262029, 1),
(1, 56, 'hello', 1373262029, 1),
(1, 57, 'hello', 1373262029, 1),
(1, 58, 'hello', 1373262030, 1),
(1, 59, 'hello', 1373262030, 1),
(1, 60, 'hello', 1373262030, 1),
(1, 61, 'hello', 1373262030, 1),
(1, 62, 'hello', 1373262030, 1),
(1, 63, 'hello', 1373262031, 1),
(1, 64, 'hello', 1373262031, 1),
(1, 65, 'hello', 1373262031, 1),
(1, 66, 'hello', 1373262031, 1),
(1, 67, 'hello', 1373262032, 1),
(1, 68, 'hello', 1373262032, 1),
(1, 69, 'hello', 1373262032, 1),
(1, 70, '', 1373262032, 1),
(1, 71, 'hello', 1373262032, 1),
(1, 72, 'hello', 1373262032, 1),
(1, 73, 'hello', 1373262033, 1),
(1, 74, 'hello', 1373262033, 1),
(1, 75, '', 1373262033, 1),
(1, 76, 'hello', 1373262033, 1),
(1, 77, '', 1373262039, 1),
(1, 78, '', 1373262041, 1),
(1, 79, 'hello', 1373262045, 1),
(1, 80, 'k', 1373262208, 2),
(1, 81, 'ni hao ', 1373262367, 1),
(1, 82, 'hao', 1373262379, 2),
(1, 83, '你好啊', 1373262382, 2),
(1, 84, '啊', 1373262387, 2),
(1, 85, 'dfds', 1373266568, 1),
(1, 86, 'a ', 1373266569, 2),
(1, 87, 'fg', 1373266629, 1),
(1, 88, 'daf ', 1373427072, 2),
(1, 89, '。。。。', 1373428699, 1),
(1, 90, '开声音', 1373439808, 3),
(1, 91, '', 1373439808, 3),
(1, 92, '-，-', 1373439816, 3),
(1, 93, '-，-', 1373439838, 1),
(1, 94, '可以从这里说话', 1373439891, 1),
(1, 95, '语音', 1373439899, 1),
(1, 96, '??', 1373440244, 2),
(1, 97, 'hi~~', 1373440252, 2),
(1, 98, '黄老板', 1373440257, 2),
(1, 99, '求收留啊', 1373440262, 2),
(1, 100, '人呢人呢', 1373440418, 1),
(1, 101, '为什么我看不到', 1373440427, 1),
(1, 102, '。。。', 1373440433, 4),
(1, 103, '考到了么', 1373440450, 2),
(1, 104, '看到了么', 1373440459, 2),
(1, 105, '没看到你啊', 1373440472, 1),
(1, 106, '猪蒙川', 1373440477, 2),
(1, 107, '我也是corome啊', 1373440482, 1),
(1, 108, '。。。', 1373440485, 4),
(1, 109, 'chrome好像不行啊', 1373440485, 2),
(1, 110, '我是chrome', 1373440492, 1),
(1, 111, '要点允许', 1373440496, 1),
(1, 112, '-,-', 1373441044, 4),
(1, 113, '＃号呢', 1373441269, 1),
(1, 114, 'dfdsf', 1373460322, 1);

-- --------------------------------------------------------

--
-- Table structure for table `it_plugin_webpage`
--

CREATE TABLE IF NOT EXISTS `it_plugin_webpage` (
  `room_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `url` varchar(8000) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`room_id`,`id`),
  KEY `name` (`name`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `it_plugin_webpage`
--

INSERT INTO `it_plugin_webpage` (`room_id`, `id`, `name`, `url`, `user_id`) VALUES
(1, 1, 9288452, 'http://', 1),
(1, 2, 9288452, 'http://www.baidu.com', 1),
(1, 3, 2114829, 'http://', 1),
(1, 4, 4587996, 'http://', 1),
(1, 5, 4587996, 'http://g.cn', 1),
(1, 6, 2754461, 'http://', 1),
(1, 7, 7182180, 'http://', 1),
(1, 8, 2754461, 'close', 1),
(1, 9, 2114829, 'http://qq.com', 1),
(1, 10, 3742843, 'http://', 2),
(1, 11, 3742843, 'http://www.baidu.com', 2),
(1, 12, 3742843, 'http://www.baidu.com', 2),
(1, 13, 6583631, 'http://', 2),
(1, 14, 7182180, 'close', 2),
(1, 15, 2114829, 'close', 1),
(1, 16, 6583631, 'close', 2),
(1, 17, 3742843, 'close', 2),
(1, 18, 4587996, 'close', 2),
(1, 19, 9288452, 'close', 2),
(1, 20, 3724510, 'http://', 2),
(1, 21, 3724510, 'http://www.baidu.com', 2),
(1, 22, 3724510, 'http://g.cn', 1),
(1, 23, 6681762, 'http://', 1),
(1, 24, 6681762, 'close', 1),
(1, 25, 3724510, 'close', 1),
(1, 26, 6018246, 'http://', 1),
(1, 27, 6018246, 'http://g.cn', 1),
(1, 28, 6863382, 'http://', 1),
(1, 29, 6863382, 'close', 1),
(1, 30, 6018246, 'close', 1),
(1, 31, 9318505, 'http://', 1),
(1, 32, 9318505, 'close', 1),
(1, 33, 2257958, 'http://www.g.cn', 2),
(1, 34, 2257958, 'http://wenku.baidu.com/view/2646e306ba1aa8114431d99b.html', 2),
(1, 35, 2257958, 'http://wenku.baidu.com/view/23ba0065a98271fe910ef9bb.html', 2),
(1, 36, 2257958, 'close', 2),
(1, 37, 5545552, 'http://baidu.com', 2),
(1, 38, 5545552, 'close', 2),
(1, 39, 7739935, 'http://g.cn', 2),
(1, 40, 5646434, 'http://', 1),
(1, 41, 5646434, 'close', 1),
(1, 42, 1247086, 'http://', 1),
(1, 43, 1247086, 'close', 1),
(1, 44, 7739935, 'close', 1),
(1, 45, 7520566, 'http://', 1),
(1, 46, 7520566, 'http://baidu.com', 1),
(1, 47, 7520566, 'close', 1),
(1, 48, 659993, 'http://', 1),
(1, 49, 659993, 'close', 1),
(1, 50, 9717024, 'http://', 1),
(1, 51, 9717024, 'close', 1),
(1, 52, 4393084, 'http://', 1),
(1, 53, 4393084, 'close', 1),
(1, 54, 8149078, 'http://', 1),
(1, 55, 8149078, 'http://www.baidu.com', 1),
(1, 56, 8149078, 'close', 1),
(1, 57, 4315976, 'http://', 1),
(1, 58, 4315976, 'http://www.baidu.com', 1),
(1, 59, 9678759, 'http://', 1),
(1, 60, 9678759, 'close', 1),
(1, 61, 4315976, 'http://www.baidu.com', 1),
(1, 62, 9526102, 'http://', 1),
(1, 63, 9526102, 'http://', 1),
(1, 64, 9526102, 'http://www.baidu.com', 1),
(1, 65, 9526102, 'close', 1),
(1, 66, 4315976, 'close', 1),
(1, 67, 4445, 'http://', 1),
(1, 68, 4445, 'close', 1),
(1, 69, 4889538, 'http://', 1),
(1, 70, 4889538, 'close', 1),
(1, 71, 2174075, 'http://', 3),
(1, 72, 2174075, 'http://www.baidu.com', 3),
(1, 73, 2174075, 'close', 3),
(1, 74, 1100830, 'http://', 3),
(1, 75, 1100830, 'close', 3),
(1, 76, 2742583, 'http://', 1),
(1, 77, 6194996, 'http://', 1),
(1, 78, 7792879, 'http://', 1),
(1, 79, 7792879, 'close', 1),
(1, 80, 6194996, 'close', 1),
(1, 81, 2742583, 'close', 1),
(1, 82, 1302040, 'http://g.cn', 1),
(1, 83, 6673037, 'http://', 1),
(1, 84, 6673037, 'close', 1),
(1, 85, 1302040, 'http://baidu.com', 1),
(1, 86, 1302040, 'http://www.baidu.com', 1),
(1, 87, 1350187, 'http://', 1),
(1, 88, 1302040, 'close', 1),
(1, 89, 1350187, 'http://', 1),
(1, 90, 1350187, 'http://baidu.com', 1),
(1, 91, 931910, 'http://', 1),
(1, 92, 931910, 'close', 2),
(1, 93, 9319873, 'http://', 2),
(1, 94, 9319873, 'close', 2),
(1, 95, 9675816, 'http://', 2),
(1, 96, 9675816, 'close', 2),
(1, 97, 1030388, 'http://', 2),
(1, 98, 1030388, 'close', 2),
(1, 99, 1350187, 'http://baidu.com', 1),
(1, 100, 1350187, 'http://baidu.comv', 2),
(1, 101, 1350187, 'http://baidu.com', 1),
(1, 102, 1350187, 'http://baidu.com', 1),
(1, 103, 1350187, 'http://g.cn', 1),
(1, 104, 1350187, 'http://baidu.com', 1),
(1, 105, 5484924, 'http://www.sjtu.edu.cn', 2),
(1, 106, 5484924, 'close', 1),
(1, 107, 1350187, 'http://g.cn', 1),
(1, 108, 1350187, 'http://g.cn', 2),
(1, 109, 4969361, 'http://', 1),
(1, 110, 4969361, 'http://', 1),
(1, 111, 4969361, 'http://xiaoqs.com', 1),
(1, 112, 4969361, 'http://www.baidu.com', 1),
(1, 113, 4969361, 'close', 1),
(1, 114, 6371143, 'http://', 2),
(1, 115, 6371143, 'http://xiaoqs.com', 1),
(1, 116, 6371143, 'http://xiaoqs.com/Room/show?room_id=1&user_id=3', 1),
(1, 117, 6371143, 'close', 1),
(1, 118, 1350187, 'close', 1),
(1, 119, 3844101, 'http://g.cn', 1),
(1, 120, 3629362, 'http://', 2),
(1, 121, 3629362, 'close', 2),
(1, 122, 3094047, 'http://', 2),
(1, 123, 3094047, 'close', 1),
(1, 124, 3844101, 'http://g.cn', 2),
(1, 125, 1334824, 'http://', 2),
(1, 126, 1334824, 'http://baidu.com', 2),
(1, 127, 1289974, 'http://', 2),
(1, 128, 1289974, 'http://163.com', 2),
(1, 129, 9583953, 'http://', 2),
(1, 130, 9583953, 'close', 2),
(1, 131, 1289974, 'close', 2),
(1, 132, 1334824, 'close', 2),
(1, 133, 3844101, 'close', 2),
(1, 134, 830263, 'http://', 1),
(1, 135, 7783520, 'http://', 1),
(1, 136, 7293812, 'http://', 1),
(1, 137, 7293812, 'http://g.cn', 1);

-- --------------------------------------------------------

--
-- Table structure for table `it_session`
--

CREATE TABLE IF NOT EXISTS `it_session` (
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(10) NOT NULL,
  `server_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`room_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `it_session`
--

INSERT INTO `it_session` (`room_id`, `user_id`, `session_id`, `server_id`) VALUES
(1, 1, 'xxxxxxxxxx', 4),
(1, 2, 'xxxxxxxxxx', 4),
(1, 3, 'xxxxxxxxxx', 1),
(1, 4, '4543094907', 1);

-- --------------------------------------------------------

--
-- Table structure for table `it_variable`
--

CREATE TABLE IF NOT EXISTS `it_variable` (
  `room_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`room_id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `it_variable`
--

INSERT INTO `it_variable` (`room_id`, `name`, `content`) VALUES
(1, 'start_time', '1373259600');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
