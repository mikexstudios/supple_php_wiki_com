-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Aug 30, 2007 at 02:57 AM
-- Server version: 5.0.38
-- PHP Version: 5.2.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `suppletextcom_site`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `sessions`
-- 

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) character set latin1 NOT NULL default '0',
  `session_start` int(10) unsigned NOT NULL default '0',
  `session_last_activity` int(10) unsigned NOT NULL default '0',
  `session_ip_address` varchar(16) character set latin1 NOT NULL default '0',
  `session_user_agent` varchar(50) character set latin1 NOT NULL,
  `session_data` text character set latin1 NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `sessions`
-- 

INSERT INTO `sessions` (`session_id`, `session_start`, `session_last_activity`, `session_ip_address`, `session_user_agent`, `session_data`) VALUES 
('d1abf21ef0cd940e6a8256e9d829a22e', 1188457041, 1188457041, '192.168.85.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv', 'a:3:{s:8:"username";s:4:"asdf";s:9:"logged_in";b:1;s:11:"redirect_to";s:1:"/";}');

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(100) NOT NULL auto_increment,
  `username` varchar(100) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `attribute` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`id`, `username`, `key`, `value`, `attribute`) VALUES 
(1, 'asdf', 'uid', '1', ''),
(2, 'asdf', 'password', '55677dbc3c1e1f9956ffc7e7c91c9d01483b823d', ''),
(3, 'asdf', 'email', 'asdf@asdf.com', ''),
(4, 'asdf', 'role', 'Administrator', '');
