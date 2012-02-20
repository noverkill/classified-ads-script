-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Created on: 2012. febr. 20.
-- Server version: 5.5.8
-- PHP version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `classified`
--

CREATE DATABASE IF NOT EXISTS classified CHARACTER SET utf8 COLLATE utf8_general_ci;
USE classified;

-- --------------------------------------------------------

--
-- Table structure: `ad`
--

CREATE TABLE IF NOT EXISTS `ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(10) unsigned NOT NULL,
  `price` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `region` int(10) unsigned NOT NULL,
  `postedon` date NOT NULL,
  `expiry` date NOT NULL,
  `webpage` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(10) unsigned NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `activedon` date NOT NULL,
  `sponsored` int(1) NOT NULL DEFAULT '0',
  `sponsoredon` date NOT NULL,
  `expirednotice` int(1) NOT NULL DEFAULT '0',
  `ipaddr` varchar(50) CHARACTER SET ascii NOT NULL,
  `lastmodified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  KEY `region` (`region`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Table structure: `ad_review`
--

CREATE TABLE IF NOT EXISTS `ad_review` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `rate` int(1) unsigned NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ad_id` (`ad_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Table structure: `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET ascii NOT NULL,
  `order` int(10) unsigned NOT NULL,
  `parent` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Table structure: `expiry`
--

CREATE TABLE IF NOT EXISTS `expiry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `period` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'in day',
  `order` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Table structure: `favourite`
--

CREATE TABLE IF NOT EXISTS `favourite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ad_id` (`ad_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Tábla szerkezet: `region`
--

CREATE TABLE IF NOT EXISTS `region` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET ascii NOT NULL,
  `order` int(10) unsigned NOT NULL,
  `parent` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Tábla szerkezet: `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ad_id` (`ad_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Table structure: `response`
--

CREATE TABLE IF NOT EXISTS `response` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ad_id` (`ad_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Tábla structure: `static-content`
--

CREATE TABLE IF NOT EXISTS `static-content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET ascii NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

--
-- Table content: `static-content`
--

INSERT INTO `static-content` (`id`, `title`, `slug`, `content`) VALUES
(1, 'Ad activation email', 'ad-activation-email', 'Dear $username,\r\n\r\n\r\nYou have posted an ad on the $site_url site.\r\n\r\nTo activate your ad please use the following link:\r\n\r\n$site_url/ad-activation.php?id=$last&code=$code\r\n\r\n\r\nOnce you have activated your ad, you can manage it with the following links:\r\n\r\n- modify:  $site_url/ad-modification.php?id=$last&code=$code\r\n\r\n- expand:  $site_url/ad-extension.php?id=$last&code=$code\r\n\r\n- delete:  $site_url/ad-removal.php?id=$last&code=$code\r\n\r\n\r\nKing Regards:\r\nThe team of the $site_title site\r\n$site_url'),
(2, 'Ad sending email', 'ad-sending-email', 'Dear $recipient,\r\n\r\n\r\nI would like to recommend you the following ad found on the $site_url page:\r\n\r\n$site_url/ad-list.php?id=$r_id\r\n\r\n\r\nRegards:\r\n$sender '),
(3, 'Registration email', 'user-registration-email', 'Dear $username,\r\n\r\nThis is an autogenerated message that you have received, either because you registered on the $site_url site, or because you posted an ad at the frist time, so our system automatically generated a username and password for you.\r\n\r\nPlease click on the link below to activate your account:\r\n$site_url/user-registration.php?id=$userid&code=$code\r\n\r\nIf you have posted an ad at the first time, then your account become active when you activate your ad.\r\n\r\nOnce your account is active, you can log in using the following username and password.\r\n\r\nusername: $username\r\npassword: $password\r\n\r\nWhen you first log in, you can change this autogenerated password to one of your choice.\r\n\r\nKing Regards:\r\nThe team of the $site_title site\r\n$site_url'),
(4, 'Lost password email', 'user-lost-pasword-email', 'Dear ".ucfirst($username)."!\r\n\r\n\r\nThis is a password reminder.\r\n\r\nYou can log in using this email address or your username and password which are the following:\r\nusername: $username\r\npassword: $password\r\n\r\n\r\nKing Regards:\r\nThe team of the $site_title site\r\n$site_url'),
(5, 'Ad response email', 'ad-response-email', 'You have got a response to your ad:\r\n\r\n$response\r\n\r\nYou can check your related ad here: $site_url/ad.php?id=$adid\r\n\r\nKing Regards:\r\nThe team of the $site_title site\r\n$site_url'),
(6, 'Abuse report', 'abuse-report', 'Abuse report:\r\n\r\n$site_url/ad.php?id=$adid\r\n\r\n$report');

-- --------------------------------------------------------

--
-- Table structure: `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(10) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `telephone` varchar(100) NOT NULL DEFAULT '',
  `city` varchar(100) NOT NULL DEFAULT '',
  `region` varchar(100) NOT NULL DEFAULT '',
  `category` varchar(100) NOT NULL DEFAULT '',
  `webpage` varchar(100) NOT NULL DEFAULT '',
  `createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `password` varchar(10) NOT NULL DEFAULT '',
  `code` varchar(100) NOT NULL DEFAULT '',
  `active` int(11) NOT NULL DEFAULT '0',
  `ipaddr` varchar(20) CHARACTER SET armscii8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `nev` (`name`),
  KEY `bejnev` (`username`),
  KEY `jelszo` (`password`),
  KEY `aktiv` (`active`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

--
-- Table content: `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `email`, `telephone`, `city`, `region`, `category`, `webpage`, `createdon`, `password`, `code`, `active`, `ipaddr`) VALUES
(1, 'Admin', 'admin', '', '', '', '1', '1', '', '2011-11-27 00:00:00', 'admin12', '', 1, '');

-- --------------------------------------------------------

--
-- Table structure: `user_ban`
--

CREATE TABLE IF NOT EXISTS `user_ban` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(10) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `telephone` varchar(100) NOT NULL DEFAULT '',
  `city` varchar(100) NOT NULL DEFAULT '',
  `region` varchar(100) NOT NULL DEFAULT '',
  `category` varchar(100) NOT NULL DEFAULT '',
  `webpage` varchar(100) NOT NULL DEFAULT '',
  `createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `password` varchar(10) NOT NULL DEFAULT '',
  `code` varchar(100) NOT NULL DEFAULT '',
  `active` int(11) NOT NULL DEFAULT '0',
  `ipaddr` varchar(20) CHARACTER SET armscii8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `nev` (`name`),
  KEY `bejnev` (`username`),
  KEY `jelszo` (`password`),
  KEY `aktiv` (`active`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Table structure: `user_review`
--

CREATE TABLE IF NOT EXISTS `user_review` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reviewed_user` int(10) unsigned NOT NULL COMMENT 'The reviewed user''s id.',
  `user_id` int(10) unsigned NOT NULL,
  `rate` int(1) unsigned NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ad_id` (`reviewed_user`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;
