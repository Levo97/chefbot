-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2019 at 09:08 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `szakdolgozat`
--
CREATE DATABASE IF NOT EXISTS `szakdolgozat` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `szakdolgozat`;

-- --------------------------------------------------------

--
-- Table structure for table `alapanyagok`
--

CREATE TABLE `alapanyagok` (
  `id` int(3) NOT NULL,
  `neve` text COLLATE utf8_hungarian_ci NOT NULL,
  `energia` double NOT NULL,
  `feherje` double NOT NULL,
  `szenhidrat` double NOT NULL,
  `zsir` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `alapanyagok`
--

INSERT INTO `alapanyagok` (`id`, `neve`, `energia`, `feherje`, `szenhidrat`, `zsir`) VALUES
(1, 'alma', 52, 0.26, 13.81, 0.17);

-- --------------------------------------------------------

--
-- Table structure for table `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_hungarian_ci NOT NULL,
  `jelszo` varchar(300) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `pont` int(5) NOT NULL DEFAULT '0',
  `bejelentkezve` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `username`, `jelszo`, `email`, `pont`, `bejelentkezve`) VALUES
(1, 'teszt', '123456', 'teszte@elek.hu', 0, '2019-03-13 04:25:00'),
(2, '.Teszt Elek.', '.1234556.', '.elek@teszt.hu.', 0, NULL),
(3, 'Teszt Péter', '23131414', 'peter@teszt.hu', 0, NULL),
(4, 'Teszt Tamás', '2412413131', 'tamas@teszt.hu', 0, NULL),
(5, 'Teszt Hash', 'cf43e029efe6476e1f7f84691f89c876818610c2eaeaeb881103790a48745b82', 'hesss@innen.hu', 0, NULL),
(6, 'Teszt Géza', 'd6ef367f781f23c039fcec3550650c8fa7a77a84fe480ac4994600a5d9c3fb2a', 'geza@hash.hu', 0, NULL),
(7, '', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', '', 0, NULL),
(8, '', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', '', 0, NULL),
(9, 'Bence', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'bence@kemence.banya', 0, NULL),
(10, 'tesztelek', 'da79250286f9dd54cb243147b7d4a92dd6891248801c2ad92fb16108374bf1f9', 'tesztelek@teszt.hu', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hozzaszolasok`
--

CREATE TABLE `hozzaszolasok` (
  `recept_id` int(11) DEFAULT NULL,
  `ki` int(11) DEFAULT NULL,
  `mit` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `hozzaszolasok`
--

INSERT INTO `hozzaszolasok` (`recept_id`, `ki`, `mit`) VALUES
(1, 1, 'jóféle'),
(1, 6, 'igen finom'),
(3, 5, 'Nagyon finom'),
(3, 5, 'Még mindig finom.'),
(3, 5, 'Még mindig finom.'),
(3, 5, 'jóféle'),
(2, 5, 'A másik jobban ízlett.'),
(3, 9, 'Kicsit furának tartom ezt a kaját.'),
(4, 5, 'Tetszik'),
(8, 10, 'Végre egy új recept'),
(4, 10, 'igen');

-- --------------------------------------------------------

--
-- Table structure for table `hozzavalok`
--

CREATE TABLE `hozzavalok` (
  `recept_id` int(11) DEFAULT NULL,
  `alapanyag_id` int(11) DEFAULT NULL,
  `mennyiseg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `hozzavalok`
--

INSERT INTO `hozzavalok` (`recept_id`, `alapanyag_id`, `mennyiseg`) VALUES
(1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `kategoria`
--

CREATE TABLE `kategoria` (
  `id` int(11) NOT NULL,
  `neve` varchar(20) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `kategoria`
--

INSERT INTO `kategoria` (`id`, `neve`) VALUES
(1, 'leves'),
(3, 'sütemény'),
(4, 'hús');

-- --------------------------------------------------------

--
-- Table structure for table `kategoriak`
--

CREATE TABLE `kategoriak` (
  `kategoria_id` int(11) NOT NULL,
  `recept_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `kategoriak`
--

INSERT INTO `kategoriak` (`kategoria_id`, `recept_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pontozas`
--

CREATE TABLE `pontozas` (
  `ki` int(11) DEFAULT NULL,
  `mit` int(11) DEFAULT NULL,
  `fel` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `pontozas`
--

INSERT INTO `pontozas` (`ki`, `mit`, `fel`) VALUES
(1, 1, b'1'),
(1, 1, b'1'),
(5, 3, b'1'),
(5, 2, b'1'),
(5, 1, b'1'),
(9, 3, b'0'),
(9, 2, b'1'),
(10, 8, b'1'),
(10, 4, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `recept`
--

CREATE TABLE `recept` (
  `id` int(11) NOT NULL,
  `szerzo_id` int(11) DEFAULT NULL,
  `neve` varchar(20) COLLATE utf8_hungarian_ci NOT NULL,
  `leiras` varchar(5000) COLLATE utf8_hungarian_ci NOT NULL,
  `energia` double DEFAULT NULL,
  `feherje` double DEFAULT NULL,
  `zsir` double DEFAULT NULL,
  `szenhidrat` double DEFAULT NULL,
  `mikor` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `recept`
--

INSERT INTO `recept` (`id`, `szerzo_id`, `neve`, `leiras`, `energia`, `feherje`, `zsir`, `szenhidrat`, `mikor`) VALUES
(1, 1, 'Teszt', 'nagyon finom', 1.1, 1.2, 1.3, 1.4, '2019-04-28 15:48:12'),
(2, 5, 'Finom recept', 'ez NAGYON finom', 1.5, 2, 1, 1.8, '2019-06-04 19:57:02'),
(3, 5, 'Mégfinomabb recept', 'ez már tényleg finom', 1.2, 2.8, 1.2, 1.6, '2019-06-04 19:57:02'),
(4, 6, 'Rácsos almás pite', 'Az átszitált lisztet elmorzsoljuk a hideg, felkockázott vajjal, majd a többi alapanyag hozzáadása után a tojással és a tejföllel összeállítjuk a tésztát.\r\n\r\nEgy kisebb és egy nagyobb cipóvá formázzuk. Hűtőszekrényben pihentetünk, amíg a töltelék elkészül és kihűl.\r\n\r\nA nagyobb tésztát 38 cm-es tészta koronggá nyújtjuk, majd egy 30 cm-es porcelán pitesütőbe terítjük, az oldalához igazítjuk a tésztát, hogy a formát felvegye. Az alját villával sűrűn megszurkáljuk, dióval megszórjuk.\r\n\r\nRáöntjük a kihűlt tölteléket.\r\nTetejére rácsozzuk a kisebb tésztából készült 2 cm széles tésztacsíkokat.\r\n\r\nMajd a felvert tojással lekenjük, és 190°C-ra előmelegített sütőben kb. 45 perc alatt megsütjük.', 2458, 40, 120, 304, '2019-06-06 09:29:14'),
(8, 5, 'Milánói', '<li>Víz</li><li>Tészta+husi</li>', NULL, NULL, NULL, NULL, '2019-06-06 22:21:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alapanyagok`
--
ALTER TABLE `alapanyagok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hozzaszolasok`
--
ALTER TABLE `hozzaszolasok`
  ADD KEY `ki` (`ki`),
  ADD KEY `recept_id` (`recept_id`);

--
-- Indexes for table `hozzavalok`
--
ALTER TABLE `hozzavalok`
  ADD KEY `recept_id` (`recept_id`),
  ADD KEY `alapanyag_id` (`alapanyag_id`);

--
-- Indexes for table `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategoriak`
--
ALTER TABLE `kategoriak`
  ADD KEY `kategoria_id` (`kategoria_id`),
  ADD KEY `recept_id` (`recept_id`);

--
-- Indexes for table `pontozas`
--
ALTER TABLE `pontozas`
  ADD KEY `ki` (`ki`),
  ADD KEY `mit` (`mit`);

--
-- Indexes for table `recept`
--
ALTER TABLE `recept`
  ADD PRIMARY KEY (`id`),
  ADD KEY `szerzo_id` (`szerzo_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alapanyagok`
--
ALTER TABLE `alapanyagok`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `recept`
--
ALTER TABLE `recept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hozzaszolasok`
--
ALTER TABLE `hozzaszolasok`
  ADD CONSTRAINT `hozzaszolasok_ibfk_1` FOREIGN KEY (`ki`) REFERENCES `felhasznalok` (`id`),
  ADD CONSTRAINT `hozzaszolasok_ibfk_2` FOREIGN KEY (`recept_id`) REFERENCES `recept` (`id`);

--
-- Constraints for table `hozzavalok`
--
ALTER TABLE `hozzavalok`
  ADD CONSTRAINT `hozzavalok_ibfk_1` FOREIGN KEY (`recept_id`) REFERENCES `recept` (`id`),
  ADD CONSTRAINT `hozzavalok_ibfk_2` FOREIGN KEY (`alapanyag_id`) REFERENCES `alapanyagok` (`id`);

--
-- Constraints for table `kategoriak`
--
ALTER TABLE `kategoriak`
  ADD CONSTRAINT `kategoriak_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`id`),
  ADD CONSTRAINT `kategoriak_ibfk_2` FOREIGN KEY (`recept_id`) REFERENCES `recept` (`id`);

--
-- Constraints for table `pontozas`
--
ALTER TABLE `pontozas`
  ADD CONSTRAINT `pontozas_ibfk_1` FOREIGN KEY (`ki`) REFERENCES `felhasznalok` (`id`),
  ADD CONSTRAINT `pontozas_ibfk_2` FOREIGN KEY (`mit`) REFERENCES `recept` (`id`);

--
-- Constraints for table `recept`
--
ALTER TABLE `recept`
  ADD CONSTRAINT `recept_ibfk_1` FOREIGN KEY (`szerzo_id`) REFERENCES `felhasznalok` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
