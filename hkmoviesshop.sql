-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2022 at 04:11 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hkmoviesshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `idgenre` int(11) NOT NULL,
  `namegenre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`idgenre`, `namegenre`) VALUES
(1, 'action'),
(2, 'comedy'),
(3, 'romantic'),
(4, 'dramatic'),
(5, 'horror'),
(6, 'biography'),
(7, 'documentary ');

-- --------------------------------------------------------

--
-- Table structure for table `jobrequest`
--

CREATE TABLE `jobrequest` (
  `iddemande` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `experience` tinyint(1) NOT NULL,
  `cv` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobrequest`
--



-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_movie` int(11) NOT NULL,
  `garbage` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--



-- --------------------------------------------------------

--
-- Table structure for table `likes_shows`
--

CREATE TABLE `likes_shows` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_show` int(11) NOT NULL,
  `garbage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes_shows`
--



-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `idmovie` int(11) NOT NULL,
  `movie_name` varchar(250) NOT NULL,
  `director` varchar(100) NOT NULL,
  `descripition` varchar(100) NOT NULL,
  `link` varchar(250) NOT NULL,
  `length` int(100) NOT NULL,
  `poster` varchar(250) NOT NULL,
  `idgenre` int(11) NOT NULL,
  `idemploye` int(11) NOT NULL,
  `garbage` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movies`
--



-- --------------------------------------------------------

--
-- Table structure for table `tvshows`
--

CREATE TABLE `tvshows` (
  `idtvshow` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `director` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `link` varchar(250) NOT NULL,
  `poster` varchar(250) NOT NULL,
  `idgenre` int(11) NOT NULL,
  `idemploye` int(11) NOT NULL,
  `garbage` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tvshows`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `iduser` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `isEmploye` tinyint(1) NOT NULL,
  `createdate` date NOT NULL,
  `token_verified` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`iduser`, `username`, `email`, `password`, `avatar`, `isAdmin`, `isEmploye`, `createdate`, `token_verified`, `verified`) VALUES
(1, 'hkimi amin', 'hkimiamin02@gmail.com', '202cb962ac59075b964b07152d234b70', '../storage/53b3bf878da5da7fbaa5c4609334e57c.jpg', 1, 0, '2022-11-22', NULL, 1),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`idgenre`);

--
-- Indexes for table `jobrequest`
--
ALTER TABLE `jobrequest`
  ADD PRIMARY KEY (`iddemande`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`id_user`),
  ADD KEY `id_movie` (`id_movie`);

--
-- Indexes for table `likes_shows`
--
ALTER TABLE `likes_shows`
  ADD KEY `show` (`id_show`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`idmovie`),
  ADD KEY `idgenre` (`idgenre`),
  ADD KEY `id_employe` (`idemploye`);

--
-- Indexes for table `tvshows`
--
ALTER TABLE `tvshows`
  ADD PRIMARY KEY (`idtvshow`),
  ADD KEY `idgenre` (`idgenre`),
  ADD KEY `idemploye` (`idemploye`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `idgenre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jobrequest`
--
ALTER TABLE `jobrequest`
  MODIFY `iddemande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `idmovie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tvshows`
--
ALTER TABLE `tvshows`
  MODIFY `idtvshow` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `id_movie` FOREIGN KEY (`id_movie`) REFERENCES `movies` (`idmovie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`id_user`) REFERENCES `users` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes_shows`
--
ALTER TABLE `likes_shows`
  ADD CONSTRAINT `show` FOREIGN KEY (`id_show`) REFERENCES `tvshows` (`idtvshow`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `id_employe` FOREIGN KEY (`idemploye`) REFERENCES `users` (`iduser`),
  ADD CONSTRAINT `idgenre` FOREIGN KEY (`idgenre`) REFERENCES `genre` (`idgenre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tvshows`
--
ALTER TABLE `tvshows`
  ADD CONSTRAINT `tvshows_ibfk_1` FOREIGN KEY (`idemploye`) REFERENCES `users` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tvshows_ibfk_2` FOREIGN KEY (`idgenre`) REFERENCES `genre` (`idgenre`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
