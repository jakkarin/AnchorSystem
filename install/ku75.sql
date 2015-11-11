-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 23, 2015 at 08:02 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ku75`
--

-- --------------------------------------------------------

--
-- Table structure for table `bl_department`
--

-- CREATE TABLE IF NOT EXISTS `bl_department` (
--   `id` mediumint(8) NOT NULL,
--   `name` varchar(255) NOT NULL,
--   `faculty` mediumint(8) NOT NULL,
--   `major` varchar(255) NOT NULL,
--   `total` mediumint(8) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bl_faculty`
--

CREATE TABLE IF NOT EXISTS `bl_faculty` (
  `id` mediumint(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total` mediumint(8) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `bl_gbnews`
--

CREATE TABLE IF NOT EXISTS `bl_gbnews` (
  `id` int(11) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bl_major`
--

CREATE TABLE IF NOT EXISTS `bl_major` (
  `id` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `faculty` mediumint(8) NOT NULL,
  `users` text NOT NULL,
  `total` mediumint(8) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bl_news`
--

CREATE TABLE IF NOT EXISTS `bl_news` (
  `id` int(11) unsigned NOT NULL,
  `major_id` mediumint(8) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `readIn` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bl_role_user`
--

-- CREATE TABLE IF NOT EXISTS `bl_role_user` (
--   `id` smallint(3) NOT NULL,
--   `role_name` varchar(255) NOT NULL
-- ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bl_user`
--

CREATE TABLE IF NOT EXISTS `bl_user` (
  `id` int(11) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(24) NOT NULL,
  `password` varchar(60) NOT NULL,
  `token` varchar(40) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bl_user_detail`
--

CREATE TABLE IF NOT EXISTS `bl_user_detail` (
  `id` int(11) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` smallint(3) NOT NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `nickname` varchar(24) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `major` mediumint(8) NOT NULL,
  `phone` varchar(24) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `line` varchar(255) NOT NULL,
  `signature` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bl_department`
--
-- ALTER TABLE `bl_department`
--   ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bl_faculty`
--
ALTER TABLE `bl_faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bl_gbnews`
--
ALTER TABLE `bl_gbnews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bl_major`
--
ALTER TABLE `bl_major`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bl_news`
--
ALTER TABLE `bl_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bl_role_user`
--
-- ALTER TABLE `bl_role_user`
--   ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bl_user`
--
ALTER TABLE `bl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bl_user_detail`
--
ALTER TABLE `bl_user_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bl_department`
--
-- ALTER TABLE `bl_department`
--   MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bl_faculty`
--
ALTER TABLE `bl_faculty`
  MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `bl_gbnews`
--
ALTER TABLE `bl_gbnews`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `bl_major`
--
ALTER TABLE `bl_major`
  MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `bl_news`
--
ALTER TABLE `bl_news`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `bl_role_user`
--
-- ALTER TABLE `bl_role_user`
--   MODIFY `id` smallint(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `bl_user`
--
ALTER TABLE `bl_user`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `bl_user_detail`
--
ALTER TABLE `bl_user_detail`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
