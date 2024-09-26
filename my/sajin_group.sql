-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- 생성 시간: 24-04-03 12:57
-- 서버 버전: 10.2.38-MariaDB
-- PHP 버전: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `ailinkapp`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `sajin_group`
--

CREATE TABLE `sajin_group` (
  `no` int(10) NOT NULL,
  `g_code` varchar(30) DEFAULT NULL,
  `g_name` varchar(30) NOT NULL DEFAULT '',
  `g_class_code` varchar(30) DEFAULT NULL,
  `g_class_name` varchar(30) DEFAULT NULL,
  `userid` varchar(15) DEFAULT NULL,
  `lev` char(3) NOT NULL DEFAULT '0',
  `up_day` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `sajin_group`
--

INSERT INTO `sajin_group` (`no`, `g_code`, `g_name`, `g_class_code`, `g_class_name`, `userid`, `lev`, `up_day`) VALUES
(9, 'dao1542526769', 'etc', NULL, NULL, 'dao', '0', '2018-11-18 16:39:29'),
(10, 'dao1542527409', '여행', NULL, NULL, 'dao', '0', '2018-11-18 16:50:09'),
(11, 'cracan10041542600728', 'etc', NULL, NULL, 'cracan1004', '0', '2018-11-19 13:12:08'),
(12, 'dao1543472665', '개인사진', NULL, NULL, 'dao', '0', '2018-11-29 15:24:25'),
(13, 'naverkan1545530876', 'etc', NULL, NULL, 'naverkan', '0', '2018-12-23 02:07:56'),
(14, 'solpakan891637630508', 'new', NULL, NULL, 'solpakan89', '0', '2021-11-23 10:21:48');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `sajin_group`
--
ALTER TABLE `sajin_group`
  ADD PRIMARY KEY (`no`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `sajin_group`
--
ALTER TABLE `sajin_group`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
