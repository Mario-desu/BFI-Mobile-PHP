-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 22. Dez 2020 um 08:50
-- Server-Version: 10.4.16-MariaDB
-- PHP-Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `projekt`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellungen`
--

CREATE TABLE `bestellungen` (
  `bestellID` int(11) NOT NULL,
  `bestTarifBID` int(11) NOT NULL,
  `bestUserBID` int(11) NOT NULL,
  `bestDatum` timestamp NOT NULL DEFAULT current_timestamp(),
  `bestNotiz` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `bestellungen`
--

INSERT INTO `bestellungen` (`bestellID`, `bestTarifBID`, `bestUserBID`, `bestDatum`, `bestNotiz`) VALUES
(6, 7, 8, '2020-12-16 08:30:56', ''),
(7, 10, 14, '2020-12-16 08:53:51', ''),
(8, 19, 2, '2020-12-16 08:59:45', ''),
(9, 15, 3, '2020-12-16 09:01:05', ''),
(10, 11, 5, '2020-12-16 09:01:43', ''),
(11, 7, 8, '2020-12-16 09:27:09', ''),
(12, 7, 2, '2020-12-16 10:01:06', ''),
(13, 15, 14, '2020-12-16 16:07:49', ''),
(14, 8, 3, '2020-12-20 17:16:43', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tarife`
--

CREATE TABLE `tarife` (
  `tarifID` int(11) NOT NULL,
  `tarifName` varchar(255) NOT NULL,
  `tarifKategorie` varchar(255) NOT NULL,
  `datenvolumenGB` int(11) NOT NULL,
  `freiMinuten` int(11) NOT NULL,
  `freiSMS` int(11) NOT NULL,
  `tarifPreis` decimal(10,2) NOT NULL,
  `beschreibung` text NOT NULL,
  `tarifStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tarife`
--

INSERT INTO `tarife` (`tarifID`, `tarifName`, `tarifKategorie`, `datenvolumenGB`, `freiMinuten`, `freiSMS`, `tarifPreis`, `beschreibung`, `tarifStatus`) VALUES
(1, 'Fair XS 5 GB', 'Standard', 5, 300, 300, '6.99', '<p><strong>Sonderaktion!</strong></p>', 1),
(3, 'Fair S 10 GB\r\n', 'Standard', 10, 500, 500, '9.99', '', 1),
(4, 'Fair M 15 GB', 'Standard', 15, 500, 500, '13.99', '', 1),
(5, 'Fair L 30 GB', 'Standard', 30, 1000, 1000, '17.99', '', 0),
(6, 'Fair XL 50 GB', 'Standard', 50, 1000, 1000, '24.99', '', 1),
(7, 'Fair XXL 100 GB', 'Standard', 100, 1000, 1000, '34.99', '<p><strong>Tarif veraltet</strong></p>', 1),
(8, 'Fair SIM 5 GB\r\n', 'Sim Only', 5, 300, 300, '5.99', '', 1),
(10, 'Fair SIM 15 GB\r\n\r\n', 'Sim Only', 15, 500, 500, '11.99', '', 1),
(11, 'Fair SIM 30 GB\r\n\r\n\r\n', 'Sim Only', 30, 1000, 1000, '14.99', '', 1),
(12, 'Fair TEL 1000\r\n\r\n\r\n\r\n', 'Telefonieren\r\n', 10, 1000, 1000, '11.99', '', 1),
(13, 'Fair TEL 2000\r\n\r\n\r\n\r\n\r\n', 'Telefonieren', 30, 2000, 2000, '19.99', '', 1),
(14, 'Fair Data 50 GB\r\n\r\n\r\n\r\n\r\n', 'Data Only', 50, 0, 0, '15.99', '', 1),
(15, 'Fair Data 100 GB', 'Data Only', 100, 0, 0, '26.99', '', 1),
(16, 'Fair Data No Limit\r\n\r\n\r\n\r\n\r\n\r\n', 'Data Only', 10000, 0, 0, '34.99', '', 1),
(17, 'Fair Data 200 GB', 'Data Only', 200, 0, 0, '25.99', '', 1),
(18, 'Fairmobil Xmas', 'Standard', 20, 1000, 1000, '14.99', '', 1),
(19, 'Fairmobil XmasL', 'Standard', 35, 1000, 1000, '23.99', '', 1),
(20, 'Fair SiM Xmas', 'SIM Only', 20, 1000, 1000, '12.99', '', 1),
(22, 'Fair TEL XMAS', 'Telefonieren', 20, 2000, 2000, '17.99', '', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `anrede` varchar(255) NOT NULL,
  `familienName` varchar(255) NOT NULL,
  `vorName` varchar(255) NOT NULL,
  `userRole` int(11) NOT NULL,
  `strasse` varchar(255) NOT NULL,
  `hausNummer` varchar(255) NOT NULL,
  `plz` int(255) NOT NULL,
  `ort` varchar(255) NOT NULL,
  `telefonNummer` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userToken` varchar(255) NOT NULL,
  `userText` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`userID`, `anrede`, `familienName`, `vorName`, `userRole`, `strasse`, `hausNummer`, `plz`, `ort`, `telefonNummer`, `userEmail`, `userPassword`, `userToken`, `userText`) VALUES
(2, 'Herr', 'Oberlechner', 'Otto', 2, 'Wagramer Straße', '22', 1220, 'Wien', '0677/12345678', 'otto@oberlechner.at', '$2y$10$stKPMemeJpxrei48x3W3n.bcBU.bYKbjCvIw0mjkTrqm7EFpD4xqm', 'd0b769dc89cccecd1e614b16b1cebfc9', 'Stammkunde seit 10 Jahren!'),
(3, 'Herr', 'Steiner ', 'Emil', 1, 'Hauptplatz', '15', 2130, 'Mistelbach', '0660/9876543', 'emil@steiner.at', '$2y$10$1Uvw7lscqfztkZvnBbOX2OXucrb8Vp0ARL5etcnTW9uUzVbpG6KsO', 'd77b145b785d01dcac972b9963eff407', ''),
(4, 'Herr', 'Wurst', 'Hans', 1, 'Rennweg', '15/20', 1030, 'Wien', '0660/3456432', 'hans@wurst.at', '$2y$10$madcRv/V4BIH2ZAEI/w72eeFCpJUvdbU9N8kZZe/PAH8StBi7ZnNu', 'c21586f018595b095055e0b33565c6af', 'Anstrengender Kunde! Nett sein.'),
(5, 'Herr', 'Notnagel', 'Norbert', 1, 'Kärntner Straße', '19/3', 1010, 'Wien', '0680/3536663', 'norbert@notnagel.at', '$2y$10$kjZt3b6r1SgVhgChaoW2B.Ai4DHSLemWv1LG3OhFHiy8xpTHCWx5q', '785aa4bfd0cbe4dab10f9fb4bf60941a', 'Will kündigen! Angebot machen.'),
(6, 'Frau', 'Igel', 'Inge', 1, 'Stadionstraße', '30', 8750, 'Judenburg', '0677/7654321', 'inge@igel.at', '$2y$10$pnbSEYiuwVM.XTd9qoRNrO9NGf1CGRj0csuan/F8f6/E1yymv3C.S', '6edc3631d6807fd372f44cfc0758a34a', ''),
(8, 'Herr', 'Jovic', 'Luca', 2, 'Lachsweg', '2', 1220, 'Wien', '0664/2020211', 'luca@jovic.at', '$2y$12$FEuNBhOYpu6AjEkIGpiNneIsQAmPaC/o/lFulJ8F18U06CA7a87am', '14ee4b1eea54c1659f45350bdf07402b', ''),
(9, 'Frau', 'Nakamura', 'Akiko', 1, 'Severinstraße', '9/8', 3430, 'Tulln', '0677/9813210', 'nakamura@akiko.at', '$2y$12$w9I5YWHWBEqGFALzgyhMDe6iMe85GvUpllgaLx78AMa67/ekf3sr6', '35335f0eb0b2b04d2e0e89de77b10072', ''),
(10, 'Frau', 'Bernard', 'Paul', 1, 'Glögglweg ', '7', 4020, 'Linz', '0660/5013004', 'paul@bernard.at', '$2y$12$e95RYTh2OEekgIFznFjBAetlxNxw/XhUO3rfjezMcoYH/2.tZjkBK', '5349c10ccd159036d11532510ad4cd53', ''),
(11, 'Herr', 'Moosthaler', 'Anton', 1, 'Florianiweg', '3', 8731, 'Bischoffeld', '0664/8910234', 'anton@moosthaler.at', '$2y$12$djjxmjasoF93g5b303KUT.OSrOUdO6HN6SLhztiWAUSJFzxvD60CC', '86e4daedc1f54507c0d6b6612b51dbee', ''),
(12, 'Frau', 'Antosch', 'Maria', 1, 'Mozartstraße ', '7/21', 9800, 'Spittal an der Drau', '0667/4123879', 'maria@antosch.at', '$2y$12$v15nIhgJ9ImnXieZGZu.jOiqq4MKBVem2C01RYuEXdG50Y6XazsjK', '21f1a492e97b89b9ff202abbcbb4e0a0', ''),
(13, 'Frau', 'Chen', 'Lin', 0, 'Wohlfahrtstraße', '10', 6450, 'Sölden', '0660/7359754', 'lin@chen.at', '$2y$12$ssBeugs7O9kdxLy810AO0u2ez7657HcroK1dAKPQ/6Jyg0uxzuYr6', '80805626451ca25bf8126c3173c67d15', ''),
(14, 'Frau', 'Rodriguez', 'Jose', 1, 'Wassergrund', '6', 7111, 'Parndorf', '0664/99978131', 'jose@rodriguez.at', '$2y$12$Zyu/v9JHhFEZA0wVmSRBBucWmp38OcNPUwIXpQxOaw3Re1KbtViKW', '8d60b093eeaea0d6156775cc4b223fa1', ''),
(15, 'Frau', 'Carter', 'Evelyn', 1, 'Universitätsplatz', '14/7', 5020, 'Salzburg', '0660/2109150', 'evelyn@carter.at', '$2y$12$Uuqq3fRYqr79cqGhg0XSNOlUez/6g3q7gAu.ytfOPN6nkMavaCloi', 'a583be762fe2ec3a23a9f7ac012ea5e5', ''),
(16, 'Herr', 'Matei', 'Dumitru', 1, 'Moosmahdstraße', '8', 6850, 'Dornbirn', '0660/72116203', 'dumitru@matei.at', '$2y$12$o.vY732Ro01QZ6hMlDdXLef8OaUzOikI0FlscoVO/d5z00F8BhPJS', '1c35801f178655ee4196b8a092f97d19', ''),
(17, 'Frau', 'Murphy', 'Hannah', 1, 'Heiligenstädter Straße', '109/7/19', 1190, 'Wien', '0667/2212512', 'hannah@murphy.at', '$2y$12$H0AWGcS2jx.dj6oblZeXzeLUPIzqJyvyaPfE8kug/WejY7XZpZZLi', 'f18c13e69131f52522d16066252151f1', ''),
(18, 'Frau', 'Maier', 'Karl', 1, 'Maierstr.', '1', 1010, 'Wien', '0664/11111111', 'karl@maier.at', '$2y$12$RooLkufiSG7/diYiPGMoG.NnmJAQEw4seDRyjGNf4NzV3jZkRxxHu', 'c72f5eaffc2e5a8992dacf200e694281', ''),
(19, 'Frau', 'Bauer', 'Helene', 1, 'Austr.', '1', 5020, 'Salzburg', '0664/1234444', 'helene@bauer.at', '$2y$12$lH3sJssOk1KZ46mMsZch6.5i24dmKKq1IxpKXVRZ34onyIRJnFx6C', 'cfa11d4a6841b67f0a587428e0a34581', ''),
(20, 'Frau', 'Masuda', 'Toshiaki', 0, 'Nippongasse', '7', 1220, 'Wien', '0665/7777797', 'toshiaki@masuda.jp', '$2y$12$K7Za8I8iF83C4PPu3J11SuVPDLoRW2xVKlrSFQBF/v49APfR73FIy', 'd69ef658efb306cdf6f4ee7bc6729be5', '');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  ADD PRIMARY KEY (`bestellID`);

--
-- Indizes für die Tabelle `tarife`
--
ALTER TABLE `tarife`
  ADD PRIMARY KEY (`tarifID`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  MODIFY `bestellID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT für Tabelle `tarife`
--
ALTER TABLE `tarife`
  MODIFY `tarifID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
