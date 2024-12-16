-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 07:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brofolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `personal_id` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `course` enum('bscs','bsit','act-ad','act-nt') NOT NULL,
  `year` enum('1','2','3','4') NOT NULL,
  `birthday` date DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `link` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`personal_id`, `firstname`, `lastname`, `course`, `year`, `birthday`, `address`, `contact`, `email`, `bio`, `link`, `user_id`, `profile_image`) VALUES
(1, 'Wynry', 'Perian', 'bscs', '2', '2001-05-08', 'Mampang, Zamboanga City', '88888888888', 'wynryperian@gmail.com', 'Programmerist', 'https://www.facebook.com/', 1, '1_profile.jpg'),
(3, 'Quiana Mae', 'Alvarez', 'act-ad', '2', '2003-12-13', 'Maasin, Zamboanga City', '09363721304', 'quianamae069913@gmail.com', 'Fav Color Pink', 'https://quianamaealvarez.netlify.app/?fbclid=IwZXh0bgNhZW0CMTEAAR2iaMIlpAbWvLhObK1ymng2JMdximigXYQ-IguZMw6X5tBNODii8e3vUEs_aem_x3nvTQJiqCyuGEJZNOQtGw', 3, NULL),
(5, 'wen', 'rii', 'bsit', '2', '2024-12-09', 'testing', '99999999999', 'wynryperian@gmail.com', 'sufayuksa', 'https://www.facebook.com/', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `is_admin`) VALUES
(1, 'admin', '$2y$10$CV9xjvtTLIqLU2SpQh9vTuYmaeGPOL6yV/hac0Qfo87nBy192ZbUS', 0),
(2, 'user', '$2y$10$oOaitA4MOcFvOjbSD6jsmO.WAN8N9pTg9JmDvfobfd4XOzW2QUa1a', 0),
(3, 'quiana', '$2y$10$5mTUvlXnE3hxvPyjJFvpsOUw8ZOhGlw4dLm7oUfQo3TQBU4GC7K7.', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`personal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `personal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
