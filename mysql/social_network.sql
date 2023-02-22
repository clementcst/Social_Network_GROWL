-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:7077
-- Generation Time: Feb 22, 2023 at 12:24 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_network`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `AnswerID` varchar(50) NOT NULL DEFAULT 'NaC',
  `Answer_DateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Content` varchar(2048) NOT NULL DEFAULT '',
  `PostedBy_UserID` varchar(50) NOT NULL,
  `ReplyTo_CommentID` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `CommentID` varchar(50) NOT NULL DEFAULT 'NaC',
  `Comment_DateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Content` varchar(2048) NOT NULL DEFAULT '',
  `PostedBy_UserID` varchar(50) NOT NULL,
  `ReplyTo_PostID` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `UserID_1` varchar(50) NOT NULL,
  `UserID_2` varchar(50) NOT NULL,
  `Level` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `liked_post`
--

CREATE TABLE `liked_post` (
  `UserID` varchar(50) NOT NULL,
  `PostID` varchar(50) NOT NULL,
  `Liked_DateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `PostID` varchar(50) NOT NULL DEFAULT 'NaP',
  `Posted_DateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `NumberOfLikes` int(11) NOT NULL DEFAULT '0',
  `NumberOfShares` int(11) NOT NULL DEFAULT '0',
  `NumberOfMedia` int(11) NOT NULL DEFAULT '0',
  `Content` varchar(2048) NOT NULL DEFAULT '',
  `PostedBy_UserID` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`PostID`, `Posted_DateTime`, `NumberOfLikes`, `NumberOfShares`, `NumberOfMedia`, `Content`, `PostedBy_UserID`) VALUES
('P1', '2023-02-20 10:30:00', 0, 0, 1, 'Ceci est mon premier post!', 'U1'),
('P2', '2023-02-20 10:30:00', 0, 0, 1, 'Ceci est mon deuxième post!', 'U1');

-- --------------------------------------------------------

--
-- Table structure for table `shared_post`
--

CREATE TABLE `shared_post` (
  `UserID` varchar(50) NOT NULL,
  `PostID` varchar(50) NOT NULL,
  `Shared_DateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` varchar(50) NOT NULL DEFAULT 'NaU',
  `Username` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Mail` varchar(256) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `BirthDate` date NOT NULL DEFAULT '1999-01-01',
  `PhoneNumber` varchar(50) DEFAULT '0836656565',
  `Sex` int(11) NOT NULL DEFAULT '-1',
  `IsAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `Theme` int(11) NOT NULL DEFAULT '0',
  `IsPremium` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Name`, `Firstname`, `Mail`, `Country`, `City`, `BirthDate`, `PhoneNumber`, `Sex`, `IsAdmin`, `Theme`, `IsPremium`) VALUES
('U1', 'Jo âne', 'Legrand', 'Joan', 'joan.legrand@gmail.com', 'France', 'Paris', '1999-01-01', '0836656565', 1, 1, 0, 0),
('U10', 'Clef Man', 'Cassiet', 'Clement', 'clemDu78@yes.fr', 'Venezuela', 'Zibaboue', '1999-01-01', '0836656565', 1, 0, 0, 0),
('U11', 'Clef Man', 'Cassiet', 'Clement', 'clemDu78@yes.fr', 'Venezuela', 'Zibaboue', '1999-01-01', '0836656565', 1, 0, 0, 0),
('U12', 'Clef Man', 'Cassiet', 'Clement', 'clemDu78@yes.fr', 'Venezuela', 'Zibaboue', '1999-01-01', '0836656565', 1, 0, 0, 0),
('U13', 'Clef Man', 'Cassiet', 'Clement', 'clemDu78@yes.fr', 'Venezuela', 'Zibaboue', '1999-01-01', '0836656565', 1, 0, 0, 0),
('U14', 'Clef Man', 'Cassiet', 'Clement', 'clemDu78@yes.fr', 'Venezuela', 'Zibaboue', '1999-01-01', '0836656565', 1, 0, 0, 0),
('U15', 'Clef Man', 'Cassiet', 'Clement', 'clemDu78@yes.fr', 'Venezuela', 'Zibaboue', '1999-01-01', '7777777', 1, 0, 0, 0),
('U2', 'A Dent', 'Bouhrara', 'Adam', 'adam.oui@gmail.com', 'France', 'Cergy', '1999-01-01', '0836656565', 1, 1, 0, 0),
('U3', 'Jean Rdane', 'Gautier', 'Jordan', 'jordan.gautier@gmail.com', 'Perou', 'Lima', '1999-01-01', '0836656565', 2, 1, 0, 0),
('U4', 'Fa PasBien', 'Cerf', 'Fabien', 'cerffabien@cy-tech.fr', 'Perou', 'Perouland', '1999-01-01', '0836656565', 0, 0, 0, 0),
('U5', 'Clef Man', 'Cassiet', 'Clement', 'clemDu78@yes.fr', 'Venezuela', 'Zibaboue', '1999-01-01', '0836656565', 1, 0, 0, 0),
('U6', 'Clef Man', 'Cassiet', 'Clement', 'clemDu78@yes.fr', 'Venezuela', 'Zibaboue', '1999-01-01', '0836656565', 1, 0, 0, 0),
('U7', 'Clef Man', 'Cassiet', 'Clement', 'clemDu78@yes.fr', 'Venezuela', 'Zibaboue', '1999-01-01', '0836656565', 1, 0, 0, 0),
('U8', 'Clef Man', 'Cassiet', 'Clement', 'clemDu78@yes.fr', 'Venezuela', 'Zibaboue', '1999-01-01', '0836656565', 1, 0, 0, 0),
('U9', 'Clef Man', 'Cassiet', 'Clement', 'clemDu78@yes.fr', 'Venezuela', 'Zibaboue', '1999-01-01', '0836656565', 1, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`AnswerID`),
  ADD KEY `PostedBy_UserID` (`PostedBy_UserID`),
  ADD KEY `ReplyTo_CommentID` (`ReplyTo_CommentID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `PostedBy_UserID` (`PostedBy_UserID`),
  ADD KEY `ReplyTo_PostID` (`ReplyTo_PostID`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`UserID_1`,`UserID_2`),
  ADD KEY `UserID_2` (`UserID_2`);

--
-- Indexes for table `liked_post`
--
ALTER TABLE `liked_post`
  ADD PRIMARY KEY (`UserID`,`PostID`),
  ADD KEY `PostID` (`PostID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `PostedBy_UserID` (`PostedBy_UserID`);

--
-- Indexes for table `shared_post`
--
ALTER TABLE `shared_post`
  ADD PRIMARY KEY (`UserID`,`PostID`),
  ADD KEY `PostID` (`PostID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`PostedBy_UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`ReplyTo_CommentID`) REFERENCES `comment` (`CommentID`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`PostedBy_UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`ReplyTo_PostID`) REFERENCES `post` (`PostID`);

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`UserID_1`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`UserID_2`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `liked_post`
--
ALTER TABLE `liked_post`
  ADD CONSTRAINT `liked_post_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `liked_post_ibfk_2` FOREIGN KEY (`PostID`) REFERENCES `post` (`PostID`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`PostedBy_UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `shared_post`
--
ALTER TABLE `shared_post`
  ADD CONSTRAINT `shared_post_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `shared_post_ibfk_2` FOREIGN KEY (`PostID`) REFERENCES `post` (`PostID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
