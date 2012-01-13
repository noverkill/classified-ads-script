-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Created on: 03. dec. 2011. 02:51
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

-- --------------------------------------------------------

--
-- Table: `ad`
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
-- Table: `category`
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
-- Table: `expiry`
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
-- Table: `favourite`
--

CREATE TABLE IF NOT EXISTS `favourite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ad_id` (`ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 ;

-- --------------------------------------------------------

--
-- Table: `region`
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
-- Table: `static-content`
--

CREATE TABLE IF NOT EXISTS `static-content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET ascii NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- --------------------------------------------------------

--
-- Table: `user`
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Table content: `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `email`, `telephone`, `city`, `region`, `category`, `webpage`, `createdon`, `password`, `code`, `active`, `ipaddr`) VALUES
(1, 'Admin', 'admin', '', '', '', '1', '1', '', '2011-11-27 00:00:00', 'admin12', '', 1, '');
