-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2020. Máj 11. 16:20
-- Kiszolgáló verziója: 10.4.11-MariaDB
-- PHP verzió: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `szakdolgozat`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `alapanyagok`
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
-- A tábla adatainak kiíratása `alapanyagok`
--

INSERT INTO `alapanyagok` (`id`, `neve`, `energia`, `feherje`, `szenhidrat`, `zsir`) VALUES
(1, 'Búza finomliszt', 3.37, 0.098, 0.71, 0.01),
(2, 'Tehéntej (1,5%)', 0.44, 0.03, 0.047, 0.015),
(3, 'Cukor (kristály)', 3.87, 0, 0.9998, 0),
(4, 'vaj', 7.17, 0.0085, 0.0006, 0.8111),
(5, 'Asztali só', 0, 0, 0, 0),
(6, 'Tojássárgája', 3.22, 0.1586, 0.0359, 0.2654),
(7, 'Tejföl (élőflórás)', 1.93, 0.0207, 0.0288, 19.73),
(8, 'burgonya', 0.77, 0.021, 0.001, 0.0154),
(9, 'szerecsendió (őrölt)', 5.25, 0.058, 0.363, 0.285),
(10, 'fehér bors', 2.96, 0.104, 0.021, 0.424),
(11, 'Csirke felsőcomb', 1.21, 0.197, 0.041, 0),
(12, 'vöröshagyma', 0.4, 0.011, 0.001, 0.076),
(13, 'fokhagyma', 1.49, 0.064, 0.005, 0.31),
(14, 'víz', 0, 0, 0, 0),
(15, 'karalábé', 0.27, 0.017, 0.001, 0.026),
(16, 'zeller', 0.42, 0.015, 0.003, 0.074),
(17, 'paradicsom', 0.018, 0.09, 0.002, 0.013),
(18, 'paprika', 0.27, 0.01, 0.002, 0.054),
(19, 'sárgarépa', 0.41, 0.009, 0.002, 0.068),
(20, 'fehérrépa', 0.36, 0.03, 0.008, 0.03),
(21, 'halványító zeller', 0.16, 0.0069, 0.0017, 0.0297),
(22, 'Fekete bors', 2.51, 0.104, 0.387, 0.0033),
(23, 'főzőtejszín', 2.08, 0.03, 0.2, 0.04),
(24, 'zöldségleveskocka', 3, 0.1, 0.26, 0.14),
(25, 'búzadara', 3.6, 0.127, 0.011, 0.689),
(26, 'kakaópor (cukrozatlan)', 3.59, 0.19, 0.22, 0.11),
(27, 'szalonna (füstölt)', 7.16, 0.09, 0.73, 0),
(28, 'kolbász', 3.16, 0.283, 0.224, 0.002),
(29, 'erős paprika', 3.94, 0.96, 0, 0),
(30, 'sűrített paradicsom', 0.38, 0.0165, 0.0021, 0.0898),
(31, 'sonka (sertés)', 1.47, 0.223, 0.057, 0.001),
(32, 'gomba (csiperke)', 0.4, 0.059, 0.002, 0.033),
(33, 'oregánó (szárított)', 2.65, 0.09, 0.043, 0.26),
(34, 'bazsalikom (szárított)', 2.33, 0.23, 0.041, 0.101),
(35, 'spagetti tészta', 1.58, 0.058, 0.0093, 0.3086),
(36, 'napraforgó olaj', 8.13, 0, 0.92, 0),
(37, 'trappista sajt', 3.52, 0.238, 0.282, 0.006),
(38, 'olívaolaj', 8.13, 0, 0.92, 0),
(39, 'sertészsír', 8.97, 0, 9.95, 0),
(40, 'marhanyak', 5.35, 0.2175, 0.045, 0.0016),
(41, 'fejtett bab', 1.67, 0.108, 0.004, 0.29),
(42, 'tv  paprika  (étkezési paprika)', 35.1, 1.3, 0.27, 8.22),
(43, 'fűszerpaprika', 3, 0.1, 0.1, 0.2),
(44, 'kakukkfű (szárított)', 3, 0.1, 0.1, 0.3),
(45, 'babérlevél', 0, 0, 0, 0),
(47, 'élesztő', 3, 0.4, 0.1, 0.1),
(48, 'tojás', 76, 6.7, 5, 0.4),
(49, 'tehéntúró', 1, 0.14, 0.03, 0.04),
(50, 'lekvár', 2.6, 0, 0, 0.65);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `alapanyagok_meretekegyseg`
--

CREATE TABLE `alapanyagok_meretekegyseg` (
  `alapanyagok_id` int(11) DEFAULT NULL,
  `mertekegyseg_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `alapanyagok_meretekegyseg`
--

INSERT INTO `alapanyagok_meretekegyseg` (`alapanyagok_id`, `mertekegyseg_id`) VALUES
(1, 3),
(2, 2),
(3, 3),
(5, 3),
(4, 3),
(6, 1),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(13, 3),
(16, 3),
(17, 3),
(22, 3),
(12, 3),
(14, 2),
(15, 3),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(23, 2),
(24, 3),
(25, 3),
(26, 3),
(27, 3),
(28, 3),
(29, 1),
(30, 3),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(36, 2),
(37, 3),
(38, 2),
(39, 3),
(40, 3),
(41, 3),
(42, 1),
(43, 3),
(44, 3),
(45, 1),
(47, 3),
(48, 1),
(49, 3),
(50, 3);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_hungarian_ci NOT NULL,
  `jelszo` varchar(300) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `bejelentkezve` datetime DEFAULT NULL,
  `tiltott` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `username`, `jelszo`, `email`, `bejelentkezve`, `tiltott`) VALUES
(1, 'teszt', 'da79250286f9dd54cb243147b7d4a92dd6891248801c2ad92fb16108374bf1f9', 'teszt.elek@test.hu', '2020-05-10 22:20:51', 1),
(2, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin@admin.hu', '2020-05-11 14:23:21', NULL),
(3, 'anna', '55579b557896d0ce1764c47fed644f9b35f58bad620674af23f356d80ed0c503', 'anna@email.hu', '2020-04-12 14:12:32', NULL),
(4, 'istvan01', '18f77af858951d820099eb09ea9f1d722838db7fad4f7eb895051af648dc8be9', 'istvan@email.com', '2020-04-12 14:12:32', NULL),
(5, 'Ferenc', '0e1e7a8fc98e7cfaf7e095853fb28780d112a7a16c57265dc5c734a10dceace3', 'ferenc@mail.hu', '2020-04-12 14:12:32', NULL),
(6, 'bela32', 'e3e194d697d189eaf36c4851a7318e6743bebf3b523c636f1da7ee16fa84ad4e', 'bela@gmail.com', '2020-04-23 20:12:04', NULL),
(7, 'adam42', '82ab421ef5f728bdfb4ee8b9fd31adb3187d688dfe6506843f56623437ca5e4a', 'adam42@gmail.com', '2020-04-15 21:45:44', NULL),
(8, 'Marta1', '28a52e3684fc58f415087341106a82a916d41dfbfcfe7bf9bbc01b4ac605bfe8', 'marta@gamial.com', '2020-04-25 19:50:05', NULL),
(9, 'adamchef', '14b04a9a059f2459201c5f3f02915cfcd3f7dd1b162c4f931c9bc9d2e34e2b62', 'adam@adam.com', '2020-05-03 13:44:20', NULL),
(10, 'peterfiPal', 'd1f9fefbbe45c0d1d531875b97f36b58f1aa231e4fa156730fdc987dc40d4ac0', 'peter@fi.pal', NULL, NULL),
(11, 'nagyPeter', '79dfc2a6e5dd3214eff9d848f6226f26f905416f00269545f6c2ed73b29c4f36', 'nagypeter@a.hu', '2020-04-28 20:18:10', NULL),
(12, 'kelemenNóra', '6531d0d3dfb61a7881f2e3fd0b39a7ce474a3f74e101042607912b56cefaa881', 'nora@alma.hu', NULL, NULL),
(13, 'FerencT', '26cf3ce6230971c04ee496edcca17b65347af7d32d403ef1b01dfbb9a6925bc5', 'ferenc@ferenc.hu', NULL, 1),
(14, 'KissE', '3fa90b827513e1c85b0011a54662eb2a905b0ab88027ba8392eb30eb1c4b0b24', 'Kisse@e.hu', NULL, NULL),
(15, 'petertamas', 'c0beb7642823885b03655ae6d01484dc9d2149d5d7023c3cbce7083156237948', 'petertamas@asd.hu', NULL, NULL),
(16, 'TesztElekPeter', '9993c6a9b116812a55deba5ab2c0e6ba8c7542e6ab235b76ce506beba70020de', 'teszt@teszt.hu', NULL, NULL),
(17, 'ChefMester001', '9f957529032cd8cc1fcd6e048e5e00359b868f82ec8b7817126b04c1daea9edd', 'alma@alma.hu', NULL, NULL),
(18, 'HathaJo', '9b59b562a0438d91e0d69099f900caa0a7e18e381366453ec40a962d5bd888b9', 'hathajo@remele.hu', NULL, NULL),
(19, 'teszt2', '039f71a7848d6a9e05f1bb74ffeb36994db6a57af5ee9af987468639e836ee65', 'teszt2@teszt.hu', NULL, NULL),
(20, 'teszt3', 'd12ca13d911549b1cccfa5012619da04fd5d94324c891dce7d8bf6efd85cfa89', 'teszt3@teszt.hu', '2020-04-28 20:20:20', NULL),
(21, 'jacsekd', 'b33716fbd03c64ab1b97cb684c080059d7ff62a9d2ea12ac71988352df4a1e08', 'jacsekd@freemail.hu', '2020-05-03 13:48:30', NULL),
(22, 'chefteszt', 'e087f04c02058aaf23e046e74fd8e4db39b555292349364bd688a0cbb67b1b96', 'teszt.tesz@teszt.hu', '2020-05-04 13:14:26', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hozzaszolasok`
--

CREATE TABLE `hozzaszolasok` (
  `recept_id` int(11) DEFAULT NULL,
  `ki` int(11) DEFAULT NULL,
  `mit` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `moderated` tinyint(1) DEFAULT 0,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `hozzaszolasok`
--

INSERT INTO `hozzaszolasok` (`recept_id`, `ki`, `mit`, `moderated`, `id`) VALUES
(7, 1, 'sasasasasasasasasasasasasasasasasasasasasasasa', 1, 63),
(6, 22, 'Nekem ez a recept nem tetszik', 0, 64),
(9, 1, 'Ez nem jó. Nekem nem ízlet', 1, 65);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hozzaszolasok_report`
--

CREATE TABLE `hozzaszolasok_report` (
  `hozzaszolas_id` int(11) NOT NULL,
  `ki` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `hozzaszolasok_report`
--

INSERT INTO `hozzaszolasok_report` (`hozzaszolas_id`, `ki`) VALUES
(65, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hozzavalok`
--

CREATE TABLE `hozzavalok` (
  `recept_id` int(11) DEFAULT NULL,
  `alapanyag_id` int(11) DEFAULT NULL,
  `mennyiseg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `hozzavalok`
--

INSERT INTO `hozzavalok` (`recept_id`, `alapanyag_id`, `mennyiseg`) VALUES
(1, 1, 450),
(1, 3, 150),
(1, 4, 200),
(1, 5, 7),
(1, 6, 2),
(1, 7, 30),
(3, 8, 1000),
(3, 4, 50),
(3, 2, 300),
(3, 9, 13),
(3, 10, 13),
(7, 12, 550),
(7, 13, 14),
(7, 14, 2000),
(7, 23, 200),
(7, 24, 20),
(8, 2, 500),
(8, 25, 90),
(8, 3, 45),
(8, 26, 15),
(9, 27, 150),
(9, 28, 120),
(9, 12, 500),
(9, 18, 2000),
(9, 29, 1),
(9, 17, 1000),
(10, 38, 60),
(10, 12, 30),
(10, 13, 28),
(10, 30, 500),
(10, 31, 300),
(10, 32, 150),
(10, 33, 20),
(10, 34, 10),
(10, 36, 50),
(10, 35, 500),
(10, 37, 150),
(10, 5, 30),
(6, 11, 150),
(6, 12, 40),
(6, 13, 10),
(6, 14, 2000),
(6, 15, 250),
(6, 16, 250),
(6, 19, 245),
(6, 20, 70),
(6, 21, 200),
(11, 39, 30),
(11, 41, 1000),
(11, 12, 40),
(11, 13, 12),
(11, 42, 2),
(11, 29, 1),
(11, 17, 40),
(11, 19, 30),
(11, 16, 40),
(11, 43, 34),
(11, 45, 4),
(38, 8, 2),
(38, 45, 3),
(39, 25, 2),
(40, 11, 3),
(42, 25, 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jogok`
--

CREATE TABLE `jogok` (
  `felhasznalok_id` int(11) NOT NULL,
  `hozzaszolasok_moderate` tinyint(1) DEFAULT 0,
  `alapanyagok_moderate` tinyint(1) DEFAULT 0,
  `felhasznalok_moderate` tinyint(1) DEFAULT 0,
  `kategoriak_moderate` tinyint(1) DEFAULT 0,
  `mertekegyseg_moderate` tinyint(1) DEFAULT 0,
  `recept_moderate` tinyint(1) DEFAULT 0,
  `rights_manage` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `jogok`
--

INSERT INTO `jogok` (`felhasznalok_id`, `hozzaszolasok_moderate`, `alapanyagok_moderate`, `felhasznalok_moderate`, `kategoriak_moderate`, `mertekegyseg_moderate`, `recept_moderate`, `rights_manage`) VALUES
(2, 1, 1, 1, 1, 1, 1, 1),
(1, 0, 0, 0, 0, 0, 0, 0),
(6, 1, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kategoria`
--

CREATE TABLE `kategoria` (
  `id` int(11) NOT NULL,
  `neve` varchar(20) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `kategoria`
--

INSERT INTO `kategoria` (`id`, `neve`) VALUES
(1, 'húsimádó'),
(2, 'halétel'),
(3, 'sütemény'),
(4, 'desszert'),
(5, 'leves'),
(6, 'vegán'),
(7, 'krumplis'),
(8, 'édes'),
(9, 'sós'),
(10, 'reggeli'),
(11, 'ebéd'),
(12, 'tésztás');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kategoriak`
--

CREATE TABLE `kategoriak` (
  `kategoria_id` int(11) NOT NULL,
  `recept_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `kategoriak`
--

INSERT INTO `kategoriak` (`kategoria_id`, `recept_id`) VALUES
(4, 1),
(3, 1),
(6, 3),
(7, 3),
(5, 7),
(8, 8),
(10, 8),
(1, 9),
(11, 9),
(1, 10),
(11, 10),
(12, 10),
(5, 6),
(1, 11),
(5, 11),
(11, 11),
(1, 38),
(5, 38),
(4, 39),
(2, 40),
(3, 41),
(4, 42);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `mertekegyseg`
--

CREATE TABLE `mertekegyseg` (
  `id` int(11) NOT NULL,
  `neve` varchar(255) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `mertekegyseg`
--

INSERT INTO `mertekegyseg` (`id`, `neve`) VALUES
(1, 'db'),
(2, 'ml'),
(3, 'g');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `pontozas`
--

CREATE TABLE `pontozas` (
  `ki` int(11) NOT NULL,
  `mit` int(11) NOT NULL,
  `pont` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `pontozas`
--

INSERT INTO `pontozas` (`ki`, `mit`, `pont`) VALUES
(5, 1, 1),
(2, 1, -1),
(6, 1, 1),
(2, 3, 1),
(20, 7, 1),
(2, 7, -1),
(22, 1, 1),
(22, 7, 1),
(2, 10, 1),
(2, 9, 1),
(1, 10, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `recept`
--

CREATE TABLE `recept` (
  `id` int(11) NOT NULL,
  `szerzo_id` int(11) DEFAULT NULL,
  `neve` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `leiras` varchar(5000) COLLATE utf8_hungarian_ci NOT NULL,
  `mikor` datetime NOT NULL DEFAULT current_timestamp(),
  `hidden` tinyint(1) DEFAULT 1,
  `missing_data` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `recept`
--

INSERT INTO `recept` (`id`, `szerzo_id`, `neve`, `leiras`, `mikor`, `hidden`, `missing_data`) VALUES
(1, 3, 'Rácsos almás pite', '<li>Az átszitált lisztet elmorzsoljuk a hideg, felkockázott vajjal, majd a többi alapanyag hozzáadása után a tojással és a tejföllel összeállítjuk a tésztát. </li><li>Egy kisebb és egy nagyobb cipóvá formázzuk. Hűtőszekrényben pihentetünk, amíg a töltelék elkészül és kihűl.</li><li>A nagyobb tésztát 38 cm-es tészta koronggá nyújtjuk, majd egy 30 cm-es porcelán pitesütőbe terítjük, az oldalához igazítjuk a tésztát, hogy a formát felvegye. Az alját villával sűrűn megszurkáljuk, dióval megszórjuk.</li><li>Ráöntjük a kihűlt tölteléket.</li><li>Tetejére rácsozzuk a kisebb tésztából készült 2 cm széles tésztacsíkokat.</li><li>Majd a felvert tojással lekenjük, és 190°C-ra előmelegített sütőben kb. 45 perc alatt megsütjük.</li>', '2020-04-10 17:44:04', 0, NULL),
(3, 8, 'Klasszikus burgonyapüré', '<li>A krumplikat megpucoljuk, és kockára vágjuk. Majd sós vízbe téve megfőzzük őket.</li><li>Ezután egy szűrő segítségével krémesre passzírozzuk a krumplit, ez benne a nagy titok!</li><li>Közben míg a krumplit passzírozzuk, a tejet felmelegítjük, és hozzáöntjük a burgonyamasszához, plusz a kockára vágott vajdarabokat is dobjuk rá.</li><li>Sózzuk, borsozzuk, és egy kevés szerecsendiót reszeljünk rá.</li><li>Nincs más dolgunk, mint nagyon jól elkeverni, és már fogyaszthatjuk is.</li>', '2020-04-25 19:52:37', 0, NULL),
(6, 9, 'Nem tökéletes karantén-húsleves', '<li>A csirkecombokat (vagy amilyen húst kapunk), a vöröshagymát és a fokhagymagerezdeket egy nagyobb lábasba tesszük. Felöntjük annyi vízzel, amennyi bőven ellepi - mivel az én lábasom nem éppen hatalmas, ez nálam 2 liter volt, de nyugodtan mehet bele több is.</li><li>Felforraljuk az egészet, majd takarékra vesszük a lángot, és épp csak gyöngyöztetve főzzük 30-40 percet.</li><li>Ezután jöhet bele a karalábé, a zellergumó, a paradicsom és a paprika. Gyöngyöztetve további 40 percet főzögetjük.</li><li>Végül hozzáadjuk a sárga- és fehérrépákat, valamint a szárzellert. Sózzuk, beleszórunk egy pár szem borsot, majd (még mindig gyöngyöztetve) további 1-1,5 órát főzzük.</li><li>Amikor már késznek ítéljük a levest, kiszedjük a húst és a zöldségeket. A húst lefejtjük a csontokról, és a répákkal együtt félretesszük tálaláshoz. </li><li>A levet ezután egy szűrő (és ha van otthon, akkor egy gézlap) segítségével leszűrjük. Tálaláskor mindenki kedve szerint szed húst és répát, de főzhetünk ki hozzá cérnametéltet is, majd a még forró levest rámerjük, és már fogyaszthatjuk is.</li>', '2020-04-27 19:22:45', 0, NULL),
(7, 9, 'Hagymakrémleves kenyérkockákkal', '<li>Megpucoljuk a hagymákat. A vöröshagymát vastag karikákra vágjuk, szétszedjük rétegekre. A fokhagymát kisebb darabokra vágjuk.</li><li>Felrakjuk őket a leveskockákkal főni.</li><li>Ha puhára főttek a hagymák, hozzáadjuk a tejszínt. Még kb. 10 percig főzzük kis lángon. Kóstoljuk, ha szükséges. pótoljunk a fűszerekbe.</li><li>Ha kicsit hűlt a leves, bormixerrel krémesítjük.</li>', '2020-04-27 20:10:40', 0, NULL),
(8, 22, 'Tejbegríz', '<li>Felforraljuk a tejet, majd belerakjuk a búzadarát és a cukrot. Közepes lángon, állandó kevergetés mellett főzzük, amíg besűrűsödik.</li><li>A tetejét megszórjuk kakaóporral vagy csokidarabokat teszünk rá, de finom üresen is.</li>', '2020-05-04 10:16:59', 0, NULL),
(9, 22, 'Hagyományos lecsó sült kolbászkarikákkal', '<li>A hagymát félbe vágjuk, majd vékony szeletekre. A paprikát karikázzuk, a paradicsomot kockázzuk.</li><li>A kolbászt karikázzuk, a szalonnát lapocskákra vágjuk.</li><li>Egy nagy fazékba tesszük a szalonnát és a kolbászt. Gyakran kevergetve addig pirítjuk, míg a kolbász roppanós lesz, és míg a szalonna üveges nem lesz. Szűrőkanállal eltávolítjuk őket.</li><li>A visszamaradt zsírra dobjuk a hagymát, és pár percig kevergetjük míg enyhén üveges lesz. Hozzáadjuk a paprikákat, és kb. 10 percig főzzük, míg kicsit összeesik. Akkor mehet rá a felkockázott paradicsom, só-bors, majd időnként a lábost megrázogatva 15-20 percig főzzük, míg a paradicsom összeesik, de még nem szószos.</li><li>Ha kész, visszaöntjük bele a kolbászt és a szalonnát, majd még egyet rottyantunk rjta, és azonnal tálaljuk.</li>', '2020-05-04 13:36:14', 0, NULL),
(10, 22, 'Milánói spagetti', '<li>Egy nagy edényben felteszünk vizet forrni.</li><li>Míg a víz felforr, összevágjuk a hozzávalókat: nagyon  apróra a hagymát és a fokhagymát, kis kockákra (kb 1x1 cm) a sonkát (ezért egybe kérjük a boltban, ne szeletelve), és cikkekre a gombát.</li><li>Kevés olívaolajon megpároljuk a hagymákat, rátesszük a gombát (párolás közben a gomba veszíteni fog nagyságából, melyet a szeleteléskor vegyünk figyelembe) majd nem sokkal később a sonkát is.</li><li>Öntsük fel a paradicsom-sűrítménnyel, fűszerezzük ízlés szerint (a javasolt fűszer mennyiségek a paradicsom sűrítmény összetétele miatt eltérő lehet, ezért gyakran kóstoljuk a ragut).</li><li>Amikor a víz felforrt, sózzuk annyira, hogy tengervíz sós legyen. Újraforrás után tegyük bele a tésztát (ne törjük el!), és keverjük meg, hogy minél hamarabb ellepje a víz. Főzzük ¾ puhára, mely lépés az olasz tészták esetén nagyon fontos.</li><li>Amennyiben nem fogyasztjuk azonnal, a tésztát bő, hideg vízben hűtsük le teljesen, kevés étolajjal locsoljuk meg, és így tároljuk fogyasztásig.</li><li>Reszelt trappista sajttal szórjuk meg étkezés előtt a tésztára tálalt ragut, esetleg friss oregánólevéllel díszítsük!</li><li>Jó étvágyat!</li>', '2020-05-04 15:38:56', 0, NULL),
(11, 22, 'Babgulyás', '<li>A zsíron üvegesre pároljuk a hagymát és a fokhagymát. </li><li>A marhanyakat kockákra vágjuk fel, és tegyük a hagymára. Keverjük jól össze, és hagyjuk, hogy kicsit megpiruljon a hús.</li><li>Ezután jöhet a kockára vágott erős és sima paprika. Utána a paradicsom, sárgarépa, fehérrépa és a zeller is. Keverjük össze, és hagyjuk pár percet párolódni.</li><li>Szórjuk a fűszerpaprikát és a borsot a zöldségekre, a friss kakukkfüvet pedig tépkedjük rá.</li><li>Öntsük fel vízzel az egészet, majd sózzuk meg, és hagyjuk felforrni a levest.</li><li>Forrás után öntsük bele az előzőleg beáztatott babot, és ha a babhoz nem adtunk az áztatás idején babérlevelet, akkor azt is tegyük a levesbe.</li><li>Ezután lassú tűzön, addig főzzük a babot, amíg meg nem puhul. Ez körülbelül másfél-két óra lesz, de közben azért figyeljük.</li><li>A kész levest kevés tejföllel a tetején tálalhatjuk is.</li>', '2020-05-04 16:08:46', 1, NULL),
(38, 1, 'dsadsa', '<li>sadsdasd</li>', '2020-05-04 18:30:39', 1, NULL),
(39, 1, 'eeqweq', '<li>qwe</li>', '2020-05-04 18:31:08', 1, NULL),
(40, 1, 'retret', '<li>eqweq</li><li>qwe</li>', '2020-05-04 18:35:59', 1, NULL),
(41, 1, 'qweqwe', '<li>qwe</li>', '2020-05-04 18:36:18', 1, NULL),
(42, 1, 'sdasd', '<li>asd</li>', '2020-05-04 18:38:24', 1, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `uzenetek`
--

CREATE TABLE `uzenetek` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_boolean` tinyint(1) DEFAULT 0,
  `uzenet` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `mikor` datetime NOT NULL,
  `olvasott` tinyint(1) NOT NULL DEFAULT 0,
  `visszavonhato` int(1) DEFAULT 0,
  `comment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `uzenetek`
--

INSERT INTO `uzenetek` (`id`, `ticket_id`, `user_boolean`, `uzenet`, `mikor`, `olvasott`, `visszavonhato`, `comment`) VALUES
(222, 72, 0, 'A Hagymakrémleves kenyérkockákkal recepthez való hozzászólásod nem helyénvaló, ezért töröltük. Hozzászzólásod: sasasasasasasasasasasasasasasasasasasasasasasa ', '2020-05-03 14:43:36', 1, 0, 63),
(223, 73, 0, 'Szia!\r\nA hozzászólásodat levettük az üzenőfalról, mivel többen jelezték hogy nem helyénvaló.\r\n Ha felvetésed van ezzel kapcsoladban, kérlek írd meg nekünk itt.', '2020-05-03 14:43:43', 1, 0, NULL),
(224, 73, 1, 'sasasasasasasasasasasasasasasasasasa', '2020-05-03 14:43:43', 1, 0, 63),
(225, 73, 0, 'Köszönjük, hogy jelezted felénk. Amint feldolgozásra kerűl az a felvetésed jelezni fogjuk a döntést.', '2020-05-03 14:43:43', 1, 0, NULL),
(226, 72, 0, 'Nem megfelelő viselkedés miatt letiltottuk a felhasználódat. A továbbiakban a hozzászólás és arecep létrehozás funkció nem áll rendelkezésedre.', '2020-05-03 14:43:55', 1, 0, NULL),
(227, 74, 0, 'Szia!\r\nA moderátoraink letiltották a felhasználódat. A tiltás a többszörös helytelen viselkedés okából adódhat.\r\n Ha felvetésed van ezzel kapcsoladban, kérlek írd meg nekünk itt.', '2020-05-03 14:44:11', 1, 0, NULL),
(228, 74, 1, 'werrrrrrrrrrrrrrrrrrrrrrrr', '2020-05-03 14:44:11', 1, 0, NULL),
(229, 74, 0, 'Köszönjük, hogy jelezted felénk. Amint feldolgozásra kerűl az a felvetésed jelezni fogjuk a döntést.', '2020-05-03 14:44:11', 1, 0, NULL),
(232, 72, 0, 'A felhasználód tiltását visszavontuk.', '2020-05-03 14:46:45', 1, 0, NULL),
(233, 72, 0, 'Nem megfelelő viselkedés miatt letiltottuk a felhasználódat. A továbbiakban a hozzászólás és arecep létrehozás funkció nem áll rendelkezésedre.', '2020-05-03 14:46:50', 1, 0, NULL),
(234, 75, 0, 'Szia!\r\nA moderátoraink letiltották a felhasználódat. A tiltás a többszörös helytelen viselkedés okából adódhat.\r\n Ha felvetésed van ezzel kapcsoladban, kérlek írd meg nekünk itt.', '2020-05-03 14:46:59', 1, 0, NULL),
(235, 75, 1, 'wqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq', '2020-05-03 14:46:59', 1, 0, NULL),
(236, 75, 0, 'Köszönjük, hogy jelezted felénk. Amint feldolgozásra kerűl az a felvetésed jelezni fogjuk a döntést.', '2020-05-03 14:46:59', 1, 0, NULL),
(237, 72, 0, 'A felhasználód tiltására adott vétódat visszautasítottuk.', '2020-05-03 14:49:45', 1, 0, NULL),
(238, 72, 0, 'A felhasználód tiltását visszavontuk.', '2020-05-03 14:49:59', 1, 0, NULL),
(239, 72, 0, 'Nem megfelelő viselkedés miatt letiltottuk a felhasználódat. A továbbiakban a hozzászólás és arecep létrehozás funkció nem áll rendelkezésedre.', '2020-05-03 14:50:05', 1, 0, NULL),
(240, 76, 0, 'Szia!\r\nA moderátoraink letiltották a felhasználódat. A tiltás a többszörös helytelen viselkedés okából adódhat.\r\n Ha felvetésed van ezzel kapcsoladban, kérlek írd meg nekünk itt.', '2020-05-03 14:50:11', 1, 0, NULL),
(241, 76, 1, 'sdddddddddddddddddddddddddd', '2020-05-03 14:50:11', 1, 0, NULL),
(242, 76, 0, 'Köszönjük, hogy jelezted felénk. Amint feldolgozásra kerűl az a felvetésed jelezni fogjuk a döntést.', '2020-05-03 14:50:11', 1, 0, NULL),
(243, 72, 0, 'A felhasználód tiltását visszavettük.', '2020-05-03 14:50:15', 1, 0, NULL),
(244, 77, 0, 'Üdv a ChefBot-on!', '2020-05-04 10:00:47', 1, 0, NULL),
(246, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 10:58:25', 1, 0, NULL),
(247, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 11:02:17', 1, 0, NULL),
(248, 77, 0, 'A Nem tökéletes karantén-húsleves recepthez való hozzászólásod nem helyénvaló, ezért töröltük. Hozzászzólásod: Nekem ez a recept nem tetszik', '2020-05-04 11:27:54', 1, 0, 64),
(249, 78, 0, 'Szia!\r\nA hozzászólásodat levettük az üzenőfalról, mivel többen jelezték hogy nem helyénvaló.\r\n Ha felvetésed van ezzel kapcsoladban, kérlek írd meg nekünk itt.', '2020-05-04 11:28:25', 1, 0, NULL),
(250, 78, 1, 'Csak elmondtam a véleményem. Szerintem ez nem korrekt döntés', '2020-05-04 11:28:25', 1, 0, 64),
(251, 78, 0, 'Köszönjük, hogy jelezted felénk. Amint feldolgozásra kerűl az a felvetésed jelezni fogjuk a döntést.', '2020-05-04 11:28:25', 1, 0, NULL),
(252, 77, 0, 'A moderált hozzászólásodat visszaállítottuk.', '2020-05-04 13:11:23', 1, 0, NULL),
(253, 72, 0, 'A moderált hozzászólásodra küldött kérvényedet elutasították..', '2020-05-04 13:11:33', 1, 0, NULL),
(254, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 13:14:04', 1, 0, NULL),
(255, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:31:31', 1, 0, NULL),
(256, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:31:40', 1, 0, NULL),
(257, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:33:27', 1, 0, NULL),
(258, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:33:50', 1, 0, NULL),
(259, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:34:52', 1, 0, NULL),
(260, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:35:35', 1, 0, NULL),
(261, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:35:44', 1, 0, NULL),
(262, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:38:40', 1, 0, NULL),
(263, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:39:30', 1, 0, NULL),
(264, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:39:38', 1, 0, NULL),
(265, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:40:18', 1, 0, NULL),
(266, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:40:35', 1, 0, NULL),
(267, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:43:20', 1, 0, NULL),
(268, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:45:37', 1, 0, NULL),
(269, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:46:40', 1, 0, NULL),
(270, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:47:22', 1, 0, NULL),
(271, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:48:12', 1, 0, NULL),
(272, 77, 0, 'Recepted lekerűlt az étlapról!', '2020-05-04 14:48:33', 1, 0, NULL),
(273, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 14:49:04', 1, 0, NULL),
(274, 77, 0, 'Recepted felkerűlt az étlapra!', '2020-05-04 15:49:01', 1, 0, NULL),
(275, 72, 0, 'Sikeresen rögzítetted a sdasd receptet. Amint a séf jóváhagyja megy a menüre.', '2020-05-04 18:38:24', 1, 0, NULL),
(276, 72, 0, 'A Hagyományos lecsó sült kolbászkarikákkal recepthez való hozzászólásod nem helyénvaló, ezért töröltük. Hozzászzólásod: Ez nem jó. Nekem nem ízlet', '2020-05-07 20:50:53', 1, 1, 65),
(277, 72, 0, 'Nem megfelelő viselkedés miatt letiltottuk a felhasználódat. A továbbiakban a hozzászólás és arecep létrehozás funkció nem áll rendelkezésedre.', '2020-05-10 22:21:19', 1, 0, NULL),
(278, 79, 0, 'Szia!\r\nA moderátoraink letiltották a felhasználódat. A tiltás a többszörös helytelen viselkedés okából adódhat.\r\n Ha felvetésed van ezzel kapcsoladban, kérlek írd meg nekünk itt.', '2020-05-10 22:26:22', 1, 0, NULL),
(279, 79, 1, 'Szerintem ez nem jogos', '2020-05-10 22:26:22', 1, 0, NULL),
(280, 79, 0, 'Köszönjük, hogy jelezted felénk. Amint feldolgozásra kerűl az a felvetésed jelezni fogjuk a döntést.', '2020-05-10 22:26:22', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `uzenetek_temak`
--

CREATE TABLE `uzenetek_temak` (
  `ID` int(11) NOT NULL,
  `tema` varchar(50) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `uzenetek_temak`
--

INSERT INTO `uzenetek_temak` (`ID`, `tema`) VALUES
(0, 'Rendszerüzenet'),
(1, 'Hozzászólás Moderálás'),
(2, 'Felhasználó Tiltás');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `uzenetek_ticket`
--

CREATE TABLE `uzenetek_ticket` (
  `id` int(11) NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `tema_id` int(11) NOT NULL DEFAULT 0,
  `closed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `uzenetek_ticket`
--

INSERT INTO `uzenetek_ticket` (`id`, `felhasznalo_id`, `tema_id`, `closed`) VALUES
(72, 1, 0, 0),
(73, 1, 1, 1),
(74, 1, 2, 1),
(75, 1, 2, 1),
(76, 1, 2, 1),
(77, 22, 0, 0),
(78, 22, 1, 1),
(79, 1, 2, 0);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `alapanyagok`
--
ALTER TABLE `alapanyagok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `alapanyagok_meretekegyseg`
--
ALTER TABLE `alapanyagok_meretekegyseg`
  ADD KEY `alapanyagok_id` (`alapanyagok_id`),
  ADD KEY `mertekegyseg_id` (`mertekegyseg_id`);

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `hozzaszolasok`
--
ALTER TABLE `hozzaszolasok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ki` (`ki`),
  ADD KEY `recept_id` (`recept_id`);

--
-- A tábla indexei `hozzaszolasok_report`
--
ALTER TABLE `hozzaszolasok_report`
  ADD KEY `hozzaszolas_id` (`hozzaszolas_id`),
  ADD KEY `ki` (`ki`);

--
-- A tábla indexei `hozzavalok`
--
ALTER TABLE `hozzavalok`
  ADD KEY `recept_id` (`recept_id`),
  ADD KEY `alapanyag_id` (`alapanyag_id`);

--
-- A tábla indexei `jogok`
--
ALTER TABLE `jogok`
  ADD KEY `felhasznalok_id` (`felhasznalok_id`);

--
-- A tábla indexei `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `kategoriak`
--
ALTER TABLE `kategoriak`
  ADD KEY `kategoria_id` (`kategoria_id`),
  ADD KEY `recept_id` (`recept_id`);

--
-- A tábla indexei `mertekegyseg`
--
ALTER TABLE `mertekegyseg`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `pontozas`
--
ALTER TABLE `pontozas`
  ADD KEY `ki` (`ki`),
  ADD KEY `mit` (`mit`);

--
-- A tábla indexei `recept`
--
ALTER TABLE `recept`
  ADD PRIMARY KEY (`id`),
  ADD KEY `szerzo_id` (`szerzo_id`);

--
-- A tábla indexei `uzenetek`
--
ALTER TABLE `uzenetek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- A tábla indexei `uzenetek_temak`
--
ALTER TABLE `uzenetek_temak`
  ADD PRIMARY KEY (`ID`);

--
-- A tábla indexei `uzenetek_ticket`
--
ALTER TABLE `uzenetek_ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`),
  ADD KEY `tema_id` (`tema_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `alapanyagok`
--
ALTER TABLE `alapanyagok`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT a táblához `hozzaszolasok`
--
ALTER TABLE `hozzaszolasok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT a táblához `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT a táblához `mertekegyseg`
--
ALTER TABLE `mertekegyseg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `recept`
--
ALTER TABLE `recept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT a táblához `uzenetek`
--
ALTER TABLE `uzenetek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT a táblához `uzenetek_temak`
--
ALTER TABLE `uzenetek_temak`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `uzenetek_ticket`
--
ALTER TABLE `uzenetek_ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `alapanyagok_meretekegyseg`
--
ALTER TABLE `alapanyagok_meretekegyseg`
  ADD CONSTRAINT `alapanyagok_meretekegyseg_ibfk_1` FOREIGN KEY (`alapanyagok_id`) REFERENCES `alapanyagok` (`id`),
  ADD CONSTRAINT `alapanyagok_meretekegyseg_ibfk_2` FOREIGN KEY (`mertekegyseg_id`) REFERENCES `mertekegyseg` (`id`);

--
-- Megkötések a táblához `hozzaszolasok`
--
ALTER TABLE `hozzaszolasok`
  ADD CONSTRAINT `hozzaszolasok_ibfk_1` FOREIGN KEY (`ki`) REFERENCES `felhasznalok` (`id`),
  ADD CONSTRAINT `hozzaszolasok_ibfk_2` FOREIGN KEY (`recept_id`) REFERENCES `recept` (`id`);

--
-- Megkötések a táblához `hozzaszolasok_report`
--
ALTER TABLE `hozzaszolasok_report`
  ADD CONSTRAINT `hozzaszolasok_report_ibfk_1` FOREIGN KEY (`hozzaszolas_id`) REFERENCES `hozzaszolasok` (`id`),
  ADD CONSTRAINT `hozzaszolasok_report_ibfk_2` FOREIGN KEY (`ki`) REFERENCES `felhasznalok` (`id`);

--
-- Megkötések a táblához `hozzavalok`
--
ALTER TABLE `hozzavalok`
  ADD CONSTRAINT `hozzavalok_ibfk_1` FOREIGN KEY (`recept_id`) REFERENCES `recept` (`id`),
  ADD CONSTRAINT `hozzavalok_ibfk_2` FOREIGN KEY (`alapanyag_id`) REFERENCES `alapanyagok` (`id`);

--
-- Megkötések a táblához `jogok`
--
ALTER TABLE `jogok`
  ADD CONSTRAINT `jogok_ibfk_1` FOREIGN KEY (`felhasznalok_id`) REFERENCES `felhasznalok` (`id`);

--
-- Megkötések a táblához `kategoriak`
--
ALTER TABLE `kategoriak`
  ADD CONSTRAINT `kategoriak_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`id`),
  ADD CONSTRAINT `kategoriak_ibfk_2` FOREIGN KEY (`recept_id`) REFERENCES `recept` (`id`);

--
-- Megkötések a táblához `pontozas`
--
ALTER TABLE `pontozas`
  ADD CONSTRAINT `pontozas_ibfk_1` FOREIGN KEY (`ki`) REFERENCES `felhasznalok` (`id`),
  ADD CONSTRAINT `pontozas_ibfk_2` FOREIGN KEY (`mit`) REFERENCES `recept` (`id`);

--
-- Megkötések a táblához `recept`
--
ALTER TABLE `recept`
  ADD CONSTRAINT `recept_ibfk_1` FOREIGN KEY (`szerzo_id`) REFERENCES `felhasznalok` (`id`);

--
-- Megkötések a táblához `uzenetek`
--
ALTER TABLE `uzenetek`
  ADD CONSTRAINT `uzenetek_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `uzenetek_ticket` (`id`);

--
-- Megkötések a táblához `uzenetek_ticket`
--
ALTER TABLE `uzenetek_ticket`
  ADD CONSTRAINT `uzenetek_ticket_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalok` (`id`),
  ADD CONSTRAINT `uzenetek_ticket_ibfk_2` FOREIGN KEY (`tema_id`) REFERENCES `uzenetek_temak` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
