-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 05, 2020 at 11:13 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techtalks`
--

-- --------------------------------------------------------

--
-- Table structure for table `developers`
--

CREATE TABLE `developers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `image_link` varchar(20) NOT NULL,
  `short_bio` text NOT NULL,
  `email` varchar(70) NOT NULL,
  `dob` date NOT NULL,
  `location` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `developers`
--

INSERT INTO `developers` (`id`, `full_name`, `image_link`, `short_bio`, `email`, `dob`, `location`) VALUES
(1, 'Aleksandar Stankovic', 'author.jpg', 'The author was born and raised in Mladenovac, Belgrade district, Central Serbia. He curses the day he decided to make this forum because it took hell of a lot of work. Yet, he knew that making a forum would be a great test of his skills. He studies at ICT college in Belgrade, and he is a freelance ESL teacher.', 'aleksandar.stankovic95@protonmail.com', '1995-11-25', 'Serbia');

-- --------------------------------------------------------

--
-- Table structure for table `event_categories`
--

CREATE TABLE `event_categories` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `category_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forum_sections`
--

CREATE TABLE `forum_sections` (
  `id` int(2) NOT NULL,
  `title` varchar(40) NOT NULL,
  `created_by` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_sections`
--

INSERT INTO `forum_sections` (`id`, `title`, `created_by`) VALUES
(1, 'General', 1),
(2, 'Computer hardware', 1),
(3, 'Software', 1),
(4, 'Phones', 1),
(5, 'Computers', 1),
(6, 'Internet', 1),
(7, 'Software development', 1),
(8, 'System administration', 1),
(9, 'Network administration', 1),
(11, 'Robotics', 1),
(12, 'Automated systems', 1),
(14, 'Other', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(2) NOT NULL,
  `text` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `menu` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `text`, `link`, `menu`) VALUES
(1, 'Home', 'index.php?page=home', 'nav'),
(2, 'Author', 'index.php?page=author', 'nav'),
(3, 'Log out', 'models/logout.php', 'nav'),
(4, 'Account', 'index.php?page=account_settings', 'dashboard'),
(5, 'Admin', 'index.php?page=admin', 'dashboard'),
(6, 'Credits', 'index.php?page=credits', 'footer'),
(7, 'Documentation', 'data/dokumentacija.php', 'footer'),
(8, 'Sitemap', 'data/sitemap.xml', 'footer'),
(9, '<i class=\"fab fa-facebook-f\"></i>', 'https://www.facebook.com', 'social'),
(10, '<i class=\"fab fa-linkedin-in\"></i>', 'https://www.linkedin.com', 'social'),
(11, '<i class=\"fab fa-github\"></i>', 'https://github.com', 'social'),
(12, '<i class=\"fab fa-discord\"></i>', 'https://discordapp.com', 'social');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(7) NOT NULL,
  `content` text NOT NULL,
  `time_posted` timestamp(4) NOT NULL DEFAULT CURRENT_TIMESTAMP(4),
  `created_by` int(6) DEFAULT NULL,
  `thread_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `content`, `time_posted`, `created_by`, `thread_id`) VALUES
(47, 'Diskusija debata ovo ono', '2019-06-14 10:05:57.1462', 1, 17),
(73, 'Da li konacno radi?', '2019-06-14 16:37:04.5378', 1, 23);

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `id` int(6) NOT NULL,
  `title` varchar(30) NOT NULL,
  `created_by` int(6) DEFAULT NULL,
  `topic_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `title`, `created_by`, `topic_id`) VALUES
(17, 'Djokina tema', 1, 1),
(23, 'Proba 2', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(3) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` text,
  `created_by` int(6) DEFAULT NULL,
  `section_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `title`, `description`, `created_by`, `section_id`) VALUES
(1, 'Forum rules', 'Forum rules and permissions', 1, 1),
(2, 'About forum', 'Brief history and basic info about forum', 1, 1),
(3, 'Processors', 'Discussing computer processors', 1, 2),
(4, 'Graphic cards', 'All about graphic cards', 1, 2),
(5, 'Motherboards', 'Here we talk about motherboards', 1, 2),
(6, 'Storage', 'Data storing devices', 1, 2),
(7, 'Power supplies', 'Which to buy, how to fix, and so on...', 1, 2),
(8, 'Optical drives', 'Discussing optical drives', 1, 2),
(9, 'Productivity', 'Programs which help you with work', 1, 3),
(10, 'Games', 'All about games and gaming', 1, 3),
(11, 'Antivirus', 'System defending software', 1, 3),
(12, 'Operating systems', 'Windows, linux, android, iOS and others...', 1, 3),
(13, 'Classic', 'Good old phones with keyboards', 1, 4),
(14, 'Smartphones', 'Debating smartphones', 1, 4),
(15, 'Laptop', 'Laptop comuters', 1, 5),
(16, 'Desktop', 'Desktop computers', 1, 5),
(17, 'Social networks', 'A place to talk about social media', 1, 6),
(18, 'Security', 'All about cyber security', 1, 6),
(19, 'Desktop', 'Learn desktop software development', 1, 7),
(20, 'Mobile', 'Learn to program for android and iOS', 1, 7),
(21, 'Web', 'How to make cool and secure websites', 1, 7),
(22, 'Databases', 'Designing and building databases', 1, 7),
(23, 'Linux', 'Learn linux sys. administration', 1, 8),
(24, 'Windows', 'Learn windows sys. administration', 1, 8),
(25, 'Networking devices', 'Devices which make the internet work', 1, 9),
(26, 'Networking protocols', 'How devices communicate', 1, 9),
(27, 'Building robots', 'Learn how to build simple robots', 1, 11),
(28, 'Programming robots', 'Learn how to automate them', 1, 11),
(29, 'A.I', 'Start learning about artificial intelligence', 1, 11),
(30, 'Drones', 'Come here if you wanna build and program drones', 1, 12),
(31, 'Self-driving cars', 'The future is here. Be part of it', 1, 12),
(32, 'Other stuff', 'Unrelated to technology', 1, 14);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password_hash` varchar(200) NOT NULL,
  `role` int(1) NOT NULL DEFAULT '3',
  `register_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `banned` int(1) NOT NULL DEFAULT '0',
  `avatar` varchar(10) DEFAULT 'user.png',
  `short_bio` text,
  `online_status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Basic user data';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `role`, `register_time`, `banned`, `avatar`, `short_bio`, `online_status`) VALUES
(1, 'Catman95', 'aleksandar.stankovic95@protonmail.com', '$2y$10$TnZauARkq7B55LbQ8sMCOek83CMj8jqo6FDyD1KS8W1mPwfKNmYL.', 1, '2019-06-05 14:58:41', 0, '1.jpg', 'Proba', 0),
(18, 'Zevs', 'admin@bogotac.com', '$2y$10$KNDpBPS.lvARLxuhRE71JuEmGS4FtrrH4VCbHZWPlbCEtF3ErWF6e', 1, '2019-06-05 17:57:06', 0, '18.png', NULL, 0),
(20, 'adminTest', 'admin@test.com', '$2y$10$0SS9MtIPpKtb21PQQQITq.oRDECZOenzd6Zy7g2iYW4rP3j3/WiL.', 1, '2019-06-06 10:06:02', 0, '20.jpg', NULL, 0),
(22, 'cvarkov', 'djoka@gmail.com', '$2y$10$y7gzWJDsDw3BYdDqWgLyduLC3/ibV34ao4m/Ah4GExtY9q/Pazb/.', 3, '2019-06-09 22:52:02', 1, '22.jpg', 'Born in Titel. Raised by grandma in Vilovo with Frau Å iloviÄ‡\'s helping hand. ', 0),
(23, 'test2', 'test2@gmail.com', '$2y$10$LrYbd.YV4Dkr.uW.rxE86Od45jPTWN7sM3a5.31w9rDV4DvSE/Klu', 3, '2019-06-12 14:14:22', 1, 'user.png', NULL, 0),
(28, 'test10', 'test10@gmail.com', '$2y$10$pmR80Fq46g19eqlBT35fTOjH6kxarYt3iTxc4GLgXOCavfOZTTh3C', 1, '2019-06-13 18:55:29', 0, 'user.png', NULL, 0),
(29, 'test11', 'test11@gmail.com', '$2y$10$a6e25d.MPkWqX413lkdsZOepY5z88MfZcgfIcPRZTK6ba2v/RVqT6', 3, '2019-06-14 15:25:42', 0, 'user.png', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(1) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'moderator'),
(3, 'mortal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `developers`
--
ALTER TABLE `developers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_categories`
--
ALTER TABLE `event_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_sections`
--
ALTER TABLE `forum_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `developers`
--
ALTER TABLE `developers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_categories`
--
ALTER TABLE `event_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_sections`
--
ALTER TABLE `forum_sections`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forum_sections`
--
ALTER TABLE `forum_sections`
  ADD CONSTRAINT `forum_sections_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `threads`
--
ALTER TABLE `threads`
  ADD CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `threads_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `forum_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `user_roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
