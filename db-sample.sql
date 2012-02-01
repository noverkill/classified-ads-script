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

USE classified;
-- --------------------------------------------------------

--
-- Table content: `ad`
--

INSERT INTO `ad` (`id`, `user_id`, `name`, `email`, `telephone`, `title`, `description`, `picture`, `category`, `price`, `city`, `region`, `postedon`, `expiry`, `webpage`, `order`, `active`, `code`, `activedon`, `sponsored`, `sponsoredon`, `expirednotice`, `ipaddr`, `lastmodified`) VALUES
(1, 2, 'Dummy User', 'user@test.com', '', 'Molestie velit consectetur', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam diam eros, adipiscing ac tristique non, fringilla sit amet est. Proin adipiscing congue fringilla. Nunc ac ullamcorper est. Nullam felis est, dignissim at faucibus lacinia, imperdiet quis urna. Suspendisse ornare pretium lacinia. Nunc laoreet venenatis sem ac imperdiet. Pellentesque porttitor pellentesque purus eu lacinia. Proin rhoncus scelerisque vulputate.', '', 1, '', '', 1, '2011-11-28', '2011-12-12', 'http://www.dummywebpage.com', 0, 1, 'bcff941a6c91cf3be101d0e00467fa50', '2011-11-28', 0, '0000-00-00', 0, '', '2011-12-02 15:45:20'),
(2, 0, 'Test user', 'teszt@teszt.com', '555 - 123456789', 'Sequi nesciunt', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.\r\n\r\nNemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.', '', 2, '123', 'London', 2, '2011-12-02', '2011-12-09', '', 0, 1, 'a84a6bea547b19b78ef7c2c961b96a97', '2011-12-02', 0, '0000-00-00', 0, '127.0.0.1', '2011-12-02 19:42:01');

-- --------------------------------------------------------

--
-- Table content: `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `order`, `parent`) VALUES
(1, 'Dummy Category', 'dummy-category', 1, 0),
(2, 'Sub Category', 'sub-category', 1, 1);

-- --------------------------------------------------------

--
-- Table content: `expiry`
--

INSERT INTO `expiry` (`id`, `name`, `period`, `order`) VALUES
(1, '1 week', '7', 1);

-- --------------------------------------------------------

--
-- Table content: `region`
--

INSERT INTO `region` (`id`, `name`, `slug`, `order`, `parent`) VALUES
(1, 'Dummy City', 'dummy-city', 1, 0),
(2, 'Sub City', 'sub-city', 1, 1);

-- --------------------------------------------------------

--
-- Table content: `static-content`
--

INSERT INTO `static-content` (`id`, `title`, `slug`, `content`) VALUES
(1, 'Ad activation email', 'ad-activation-email', 'Dear Addresse,\r\n     \r\n\r\nYou created an ad on the $site_url site. \r\n\r\nTo activate your ad please use the following link: \r\n\r\n$site_url/ad-activation.php?id=$last&code=$code\r\n\r\nYou can manage your ad by using the links below: \r\n\r\n- modify:  $site_url/ad-modification.php?id=$last&code=$code\r\n\r\n- expand:  $site_url/ad-extension.php?id=$last&code=$code\r\n\r\n- delete:  $site_url/ad-removal.php?id=$last&code=$code\r\n\r\nPlease note that if you are not registered user then you only can manage your ad from this email, so make sure keeping it whilst your ad active!\r\n \r\nIf you want to handle your ads in a more comfortable way then you can register using the following link:\r\n\r\n$site_url/user-registration.php\r\n\r\n\r\nKing Regards: \r\nThe team of the $site_title site'),
(2, 'Ad sending email', 'ad-sending-email', 'Dear $recipient,\r\n   \r\n\r\nI would like to recommend you the following ad found on the $site_url page:\r\n\r\n$site_url/ad-list.php?id=$r_id\r\n\r\n\r\nRegards:\r\n$sender '),
(3, 'Registration email', 'user-registration-email', 'Dear Adresse,\r\n     \r\nYou have registered on the $site_url site. \r\n\r\nPlease click on the link below to activate your account:\r\n$site_url/user-registration.php?id=$userid&code=$code \r\n\r\nOnce your account is active, you can log in using this email address or your username and password which are the following: \r\nusername: $username\r\npassword: $password \r\n\r\nKing Regards: \r\nThe team of the $site_title site'),
(4, 'Lost password email', 'user-lost-pasword-email', 'Dear ".ucfirst($username)."! \r\n\r\n\r\nThis is a password reminder.\r\n\r\nYou can log in using this email address or your username and password which are the following: \r\nusername: $username\r\npassword: $password \r\n\r\n\r\nKing Regards: \r\nThe team of the $site_title site'),
(5, 'Terms of Use', 'terms-of-use', '<h3>Term of Use</h3>\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam diam eros, adipiscing ac tristique non, fringilla sit amet est. Proin adipiscing congue fringilla. Nunc ac ullamcorper est. Nullam felis est, dignissim at faucibus lacinia, imperdiet quis urna. Suspendisse ornare pretium lacinia. Nunc laoreet venenatis sem ac imperdiet. Pellentesque porttitor pellentesque purus eu lacinia. Proin rhoncus scelerisque vulputate.\r\n\r\nNulla lorem lectus, interdum ac porttitor sed, ullamcorper nec nisi. Sed id erat quam. Phasellus sed nisi ante, vel adipiscing ligula. Sed at quam tellus, vel consequat archttp://localhost/classified/admin/static-content-edit.php?id=5u. Sed rhoncus dui a turpis varius vitae scelerisque arcu pharetra. Aenean faucibus varius nunc, ornare aliquam sem consectetur eu. Curabitur mattis, est et luctus lobortis, enim leo lacinia nulla, iaculis blandit neque odio vitae dui. Aenean ac leo ac quam imperdiet auctor. Curabitur elit tellus, egestas eget pretium lacinia, rhoncus nec lectus. Donec dapibus interdum urna, in molestie velit consectetur quis. Ut in ligula quis enim dignissim porttitor et ut est.\r\n\r\nDonec interdum mi sed urna pretium nec volutpat leo varius. Nulla elementum pretium mattis. Phasellus varius elit sit amet ipsum ultrices cursus. Integer at sapien et eros semper tempor vitae nec erat. Phasellus suscipit elementum facilisis. Sed risus turpis, cursus ac consequat at, dignissim quis velit. Vivamus sed diam vel sapien ultricies suscipit non quis diam. Cras sit amet interdum massa. Phasellus vulputate, magna vel suscipit mattis, erat nibh mollis leo, non fermentum tortor ligula sit amet metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec semper egestas orci at volutpat. Phasellus nibh justo, accumsan vel hendrerit sed, laoreet ut sem. Quisque fermentum, eros nec molestie consectetur, augue arcu aliquam enim, sed mollis est dolor id sem. Suspendisse potenti. Vestibulum malesuada euismod pellentesque. Vivamus hendrerit mauris at odio feugiat sit amet sollicitudin lorem pharetra. '),
(6, 'Privacy Policy', 'privacy-policy', '<h3>Privacy Policy</h3>\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam diam eros, adipiscing ac tristique non, fringilla sit amet est. Proin adipiscing congue fringilla. Nunc ac ullamcorper est. Nullam felis est, dignissim at faucibus lacinia, imperdiet quis urna. Suspendisse ornare pretium lacinia. Nunc laoreet venenatis sem ac imperdiet. Pellentesque porttitor pellentesque purus eu lacinia. Proin rhoncus scelerisque vulputate.\r\n\r\nNulla lorem lectus, interdum ac porttitor sed, ullamcorper nec nisi. Sed id erat quam. Phasellus sed nisi ante, vel adipiscing ligula. Sed at quam tellus, vel consequat archttp://localhost/classified/admin/static-content-edit.php?id=5u. Sed rhoncus dui a turpis varius vitae scelerisque arcu pharetra. Aenean faucibus varius nunc, ornare aliquam sem consectetur eu. Curabitur mattis, est et luctus lobortis, enim leo lacinia nulla, iaculis blandit neque odio vitae dui. Aenean ac leo ac quam imperdiet auctor. Curabitur elit tellus, egestas eget pretium lacinia, rhoncus nec lectus. Donec dapibus interdum urna, in molestie velit consectetur quis. Ut in ligula quis enim dignissim porttitor et ut est.\r\n\r\nDonec interdum mi sed urna pretium nec volutpat leo varius. Nulla elementum pretium mattis. Phasellus varius elit sit amet ipsum ultrices cursus. Integer at sapien et eros semper tempor vitae nec erat. Phasellus suscipit elementum facilisis. Sed risus turpis, cursus ac consequat at, dignissim quis velit. Vivamus sed diam vel sapien ultricies suscipit non quis diam. Cras sit amet interdum massa. Phasellus vulputate, magna vel suscipit mattis, erat nibh mollis leo, non fermentum tortor ligula sit amet metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec semper egestas orci at volutpat. Phasellus nibh justo, accumsan vel hendrerit sed, laoreet ut sem. Quisque fermentum, eros nec molestie consectetur, augue arcu aliquam enim, sed mollis est dolor id sem. Suspendisse potenti. Vestibulum malesuada euismod pellentesque. Vivamus hendrerit mauris at odio feugiat sit amet sollicitudin lorem pharetra. ');

-- --------------------------------------------------------

--
-- Table content: `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `email`, `telephone`, `city`, `region`, `category`, `webpage`, `createdon`, `password`, `code`, `active`, `ipaddr`) VALUES
(2, 'Dummy User', 'user', 'user@test.com', '', '', '2', '1', '', '2011-12-03 01:57:26', 'user12', '6895532aee734b7c176e40f737b7e58b', 1, '127.0.0.1');
