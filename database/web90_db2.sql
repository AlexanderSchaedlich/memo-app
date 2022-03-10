-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Erstellungszeit: 26. Apr 2021 um 18:38
-- Server-Version: 8.0.22
-- PHP-Version: 7.3.27-9+0~20210227.82+debian9~1.gbpa4a3d6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `web90_db2`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `authors`
--

CREATE TABLE `authors` (
  `id` int NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `active` enum('0','1') NOT NULL,
  `temporary_key` varchar(255) NOT NULL DEFAULT ''''''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `authors`
--

INSERT INTO `authors` (`id`, `first_name`, `last_name`, `email_address`, `password`, `role`, `active`, `temporary_key`) VALUES
(1, 'John', 'Doe', 'john@example.com', '$2y$10$38FAUXi40uOsOjWFnjO3vOQW1flJmnBZ4B2Ro93aqifaN1R0dVf0u', 'user', '1', '\'\''),
(9, 'Alexander', 'Schädlich', 'alexander.schaedlich@gmail.com', '$2y$10$VqErwbPUr/yX10moZDSbK.jQFnhtq75ylR5iCcal.kJQF5X0hKRhC', 'admin', '1', '\'\'');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `memos`
--

CREATE TABLE `memos` (
  `id` int NOT NULL,
  `fk_author` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(200) DEFAULT NULL,
  `text` text NOT NULL,
  `visibility` enum('private','public') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `memos`
--

INSERT INTO `memos` (`id`, `fk_author`, `title`, `text`, `visibility`) VALUES
(1, 1, 'test', '<script>alert(\"Hoist the colors!\");</script>', 'public'),
(2, 1, 'new test', 'dsfdgfhjklefgg bdfsewdfsgdfnggfasg dfhgjhjadafsgfdhgfgsda fdsfdgfhgjfhdgsfa SDSFDGFHGJFGDSASFDGFH', 'public');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `memos`
--
ALTER TABLE `memos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT für Tabelle `memos`
--
ALTER TABLE `memos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
