-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 03:12 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: blog_post_fullstack
--

-- --------------------------------------------------------

--
-- Table structure for table contacts
--

CREATE TABLE contacts (
  id INT(11) NOT NULL AUTO_INCREMENT,
  NAME VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table contacts
--

INSERT INTO contacts (NAME, email, message, created_at) VALUES
('siddhesh wagh', 'siddhesh@gmail.com', 'aa', '2025-04-29 07:55:08');

-- --------------------------------------------------------

--
-- Table structure for table posts
--

CREATE TABLE posts (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  reported TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  CONSTRAINT posts_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table posts
--

INSERT INTO posts (user_id, title, content, reported, created_at) VALUES
(5, 'web', 'web development', 0, '2025-04-29 08:03:39'),
(4, 'web dev', 'webb dev', 1, '2025-04-29 08:13:47');

-- --------------------------------------------------------

--
-- Table structure for table reports
--

CREATE TABLE reports (
  id INT(11) NOT NULL AUTO_INCREMENT,
  post_id INT(11) NOT NULL,
  user_id INT(11) NOT NULL,
  reason TEXT DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY post_id (post_id),
  KEY user_id (user_id),
  CONSTRAINT reports_ibfk_1 FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE,
  CONSTRAINT reports_ibfk_2 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table reports
--

INSERT INTO reports (post_id, user_id, reason, created_at) VALUES
(6, 4, 'Reported by user.', '2025-04-29 08:14:08');

-- --------------------------------------------------------

--
-- Table structure for table users
--

CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  PASSWORD VARCHAR(255) NOT NULL,
  role ENUM('user','admin') DEFAULT 'user',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  admin_requested TINYINT(1) DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE KEY username (username),
  UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table users
--

INSERT INTO users (username, email, PASSWORD, role, created_at, admin_requested) VALUES
('siddhesh', 'admin@gmail.com', '$2y$10$WZPpt48t4RWmsrAQcocyIe3z3txIRuU3Mge2ERPQP92/cx85KyWX.', 'admin', '2025-04-29 08:03:06', 0),
('mangesh', 'mangesh@gmail.com', '$2y$10$454kd89WZFLYKkVaLv451O.1/NgGaa1IL0r2IPlouQalblKIg.2jW', 'user', '2025-04-29 08:03:28', 0),
('sunita', 'sunita@gmail.com', '$2y$10$.P0X9MHgePbfr4ZxozYUeeGDJ8OMCFfuSHLDf5fRvzPcqvXqwJI4q', 'user', '2025-04-29 08:04:11', 0);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table contacts
--
ALTER TABLE contacts AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table posts
--
ALTER TABLE posts AUTO_INCREMENT = 7;

--
-- AUTO_INCREMENT for table reports
--
ALTER TABLE reports AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT for table users
--
ALTER TABLE users AUTO_INCREMENT = 7;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
