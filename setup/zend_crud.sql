-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 01 okt 2015 om 11:14
-- Serverversie: 5.6.17
-- PHP-versie: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `zend_crud`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `cid` int(9) NOT NULL AUTO_INCREMENT,
  `uid` int(9) NOT NULL,
  `post` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=251 ;

--
-- Gegevens worden geëxporteerd voor tabel `chat`
--

INSERT INTO `chat` (`cid`, `uid`, `post`, `date`) VALUES
(242, 7, '"<h1> hallo </h1>"', '2015-06-10 11:05:06'),
(243, 7, '"<script>alert(\\"hallo\\")</script>"', '2015-06-10 11:05:29'),
(244, 7, '"hallo"', '2015-06-10 12:11:48'),
(245, 7, 'hallo', '2015-06-10 12:12:22'),
(246, 7, '<h1> hallo </h1>', '2015-06-10 12:12:28'),
(247, 7, '<script>alert("hallo")</script>', '2015-06-10 12:12:54'),
(248, 7, 'echo ', '2015-06-10 12:13:03'),
(249, 7, 'blabla', '2015-06-10 14:37:55'),
(250, 7, 'kmjk', '2015-09-09 15:18:08');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `pid` int(9) NOT NULL AUTO_INCREMENT,
  `uid` int(9) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Gegevens worden geëxporteerd voor tabel `pictures`
--

INSERT INTO `pictures` (`pid`, `uid`, `image`, `title`, `description`, `link`, `path`) VALUES
(4, 7, 'kappa.jpg', 'Kappa', 'Dit is KAPPA', NULL, NULL),
(5, 7, 'tigre.jpg', 'Tigre', 'Nummero uno', NULL, NULL),
(6, 7, 'tigre-2.jpg', 'El'' Tigre', 'Numerro uno', NULL, NULL),
(7, 7, 'Fire Emblem - The Sacred Stones (USA, Australia)_03.png', 'HueHue', 'Le muertokaiser', NULL, NULL),
(8, 7, 'Fire Emblem (USA, Australia)_04.png', 'Fire', 'Emblem', NULL, NULL),
(9, 7, '0845 - Medabots - Metabee Version (E)(GBATemp)_61.png', 'Fier', 'Eblmn', NULL, NULL),
(10, 7, 'Fire Emblem (USA, Australia)_01.png', 'Fasd', 'eqwewq', NULL, NULL),
(11, 8, 'Fire Emblem - The Sacred Stones (USA, Australia)_01.png', 'asdqwe', 'asdasd', NULL, NULL),
(12, 8, '0845 - Medabots - Metabee Version (E)(GBATemp)_104.png', 'qweqwe', 'qweqwe', NULL, NULL),
(13, 8, '0845 - Medabots - Metabee Version (E)(GBATemp)_80.png', 'asdasd', 'asdasdasd', NULL, NULL),
(14, 7, 'Doesnt show.PNG', 'adasd', 'qweqeqwe', NULL, NULL),
(15, 7, 'youtube.PNG', 'qwrqweq', 'qwewqeeqwe', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `r_user_id`
--

CREATE TABLE IF NOT EXISTS `r_user_id` (
  `ruid` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `riot_id` int(20) NOT NULL,
  PRIMARY KEY (`ruid`),
  UNIQUE KEY `username` (`username`,`riot_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden geëxporteerd voor tabel `r_user_id`
--

INSERT INTO `r_user_id` (`ruid`, `username`, `riot_id`) VALUES
(1, 'asd', 1234),
(3, 'littletigerz', 44693764),
(4, 'pressurev7', 40860015),
(2, 'TigerzHead', 23181685);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`uid`, `firstname`, `lastname`) VALUES
(7, 'Cliff', 'Sestig'),
(8, 'Daniel', 'Bavel');

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat > users` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `pictures - users` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
