-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 01. Feb 2022 um 09:58
-- Server-Version: 10.4.13-MariaDB
-- PHP-Version: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ebanking`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `angestellte`
--

CREATE TABLE `angestellte` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwort` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `angestellte`
--

INSERT INTO `angestellte` (`id`, `email`, `passwort`) VALUES
(1, 'meili07@gmail.com', 'TestiTest'),
(2, 'test@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kunde`
--

CREATE TABLE `kunde` (
  `id` int(11) NOT NULL,
  `vorname` varchar(255) NOT NULL,
  `nachname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwort` varchar(255) NOT NULL,
  `kontostand` decimal(10,2) NOT NULL,
  `iban` varchar(255) NOT NULL,
  `bic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `kunde`
--

INSERT INTO `kunde` (`id`, `vorname`, `nachname`, `email`, `passwort`, `kontostand`, `iban`, `bic`) VALUES
(15, 'Julian', 'Meilinger', 'meilinger07@gmail.com', 'TestiTest', '66.36', 'AT53618714526159', 'AT'),
(16, 'Liuming', 'Xia', 'ming@gmx.at', 'TestiTest', '-20.97', 'AT18819844964363', 'AT'),
(17, 'Much', 'Jud', 'jmeilinger@tsn.at', '12345', '-35.02', 'AT61461848499312', 'AT');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `transaktionen`
--

CREATE TABLE `transaktionen` (
  `id` int(11) NOT NULL,
  `betrag` decimal(10,2) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `empfaenger_id` int(11) NOT NULL,
  `bic` varchar(256) NOT NULL,
  `zweck` varchar(256) NOT NULL,
  `zeitstempel` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `transaktionen`
--

INSERT INTO `transaktionen` (`id`, `betrag`, `sender_id`, `empfaenger_id`, `bic`, `zweck`, `zeitstempel`) VALUES
(22, '3.33', 16, 15, 'AT', 'Carta Blanca', '2022-01-30 23:00:00'),
(23, '10.12', 16, 15, 'AT', 'Klesch koite delikatess', '2022-01-30 23:00:00'),
(24, '10.12', 16, 15, 'AT', 'Hopfensmoothie', '2022-01-30 23:00:00'),
(28, '10.12', 15, 16, 'AT', 'LOL skins', '2022-01-30 23:00:00'),
(31, '3.33', 15, 16, 'AT', 'Dowsenbier', '2022-01-31 23:00:00'),
(33, '21.69', 17, 16, 'AT', 'Swingerparty', '2022-02-01 08:27:57');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zahlungen`
--

CREATE TABLE `zahlungen` (
  `id` int(11) NOT NULL,
  `kunde` int(11) NOT NULL,
  `angestellter` int(11) NOT NULL,
  `betrag` decimal(10,2) NOT NULL,
  `methode` tinyint(1) NOT NULL,
  `zeitstempel` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `zahlungen`
--

INSERT INTO `zahlungen` (`id`, `kunde`, `angestellter`, `betrag`, `methode`, `zeitstempel`) VALUES
(23, 15, 1, '128.43', 0, '2022-02-01 08:08:22'),
(24, 15, 1, '69.69', 1, '2022-02-01 08:09:06'),
(25, 16, 1, '13.33', 0, '2022-02-01 08:22:04'),
(26, 17, 1, '13.33', 0, '2022-02-01 08:27:03'),
(27, 16, 1, '3.33', 0, '2022-02-01 08:54:58'),
(28, 15, 1, '3.33', 0, '2022-02-01 08:57:07');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `angestellte`
--
ALTER TABLE `angestellte`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `kunde`
--
ALTER TABLE `kunde`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `transaktionen`
--
ALTER TABLE `transaktionen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `empfaenger_id` (`empfaenger_id`);

--
-- Indizes für die Tabelle `zahlungen`
--
ALTER TABLE `zahlungen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kunde` (`kunde`),
  ADD KEY `angestellter` (`angestellter`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `angestellte`
--
ALTER TABLE `angestellte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `kunde`
--
ALTER TABLE `kunde`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT für Tabelle `transaktionen`
--
ALTER TABLE `transaktionen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT für Tabelle `zahlungen`
--
ALTER TABLE `zahlungen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `transaktionen`
--
ALTER TABLE `transaktionen`
  ADD CONSTRAINT `transaktionen_ibfk_1` FOREIGN KEY (`empfaenger_id`) REFERENCES `kunde` (`id`),
  ADD CONSTRAINT `transaktionen_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `kunde` (`id`);

--
-- Constraints der Tabelle `zahlungen`
--
ALTER TABLE `zahlungen`
  ADD CONSTRAINT `zahlungen_ibfk_1` FOREIGN KEY (`angestellter`) REFERENCES `angestellte` (`id`),
  ADD CONSTRAINT `zahlungen_ibfk_2` FOREIGN KEY (`kunde`) REFERENCES `kunde` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
