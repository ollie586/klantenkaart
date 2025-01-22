-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2025 at 09:10 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `_dpc_klant-kaart_12524`
--

-- --------------------------------------------------------

--
-- Table structure for table `aanbieding`
--

CREATE TABLE `aanbieding` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `prijs` double NOT NULL,
  `punten` int(11) NOT NULL,
  `actief` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aanbieding`
--

INSERT INTO `aanbieding` (`id`, `product_id`, `categorie`, `prijs`, `punten`, `actief`) VALUES
(1, 1, '1', 5, 300, 'actief'),
(3, 9, '1', 10, 500, 'actief'),
(4, 10, '1', 20, 400, 'actief'),
(5, 11, '1', 5, 200, 'actief'),
(6, 12, '1', 5, 300, 'actief');

-- --------------------------------------------------------

--
-- Table structure for table `bestelling`
--

CREATE TABLE `bestelling` (
  `id` int(11) NOT NULL,
  `aanbiedingid` int(11) NOT NULL,
  `gebruikerid` int(11) NOT NULL,
  `gebruikt` varchar(255) NOT NULL,
  `datum` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bestelling`
--

INSERT INTO `bestelling` (`id`, `aanbiedingid`, `gebruikerid`, `gebruikt`, `datum`) VALUES
(28, 5, 1, 'nee', '2023-06-02 12:21:58'),
(29, 6, 1, 'nee', '2023-06-02 12:24:43'),
(30, 4, 1, 'nee', '2023-06-02 12:24:59'),
(31, 6, 2, 'nee', '2023-06-02 12:26:05'),
(32, 4, 2, 'nee', '2023-06-02 12:26:11'),
(33, 3, 2, 'nee', '2023-06-02 12:26:20'),
(34, 5, 5, 'nee', '2023-06-02 12:27:45'),
(35, 4, 5, 'nee', '2023-06-02 12:27:51'),
(36, 3, 5, 'nee', '2023-06-02 12:27:57'),
(37, 3, 6, 'nee', '2023-06-02 12:28:15'),
(38, 6, 6, 'nee', '2023-06-02 12:28:20'),
(39, 5, 6, 'nee', '2023-06-02 12:28:28'),
(40, 6, 1, 'nee', '2023-06-02 12:30:10'),
(41, 4, 1, 'nee', '2023-06-02 12:30:17');

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `actief` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id`, `naam`, `actief`) VALUES
(1, 'korting', 'actief'),
(2, 'gratis', 'actief'),
(3, 'service', 'actief'),
(4, 'cadeaubon', 'actief');

-- --------------------------------------------------------

--
-- Table structure for table `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` int(111) NOT NULL,
  `voornaam` varchar(255) NOT NULL,
  `achternaam` varchar(255) NOT NULL,
  `bedrijf` varchar(255) NOT NULL,
  `huisnummer` varchar(255) NOT NULL,
  `straat` varchar(255) NOT NULL,
  `plaats` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ww` varchar(255) NOT NULL,
  `telefoon` varchar(255) NOT NULL,
  `punten` int(111) NOT NULL,
  `rol` int(11) NOT NULL,
  `actief` varchar(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `voornaam`, `achternaam`, `bedrijf`, `huisnummer`, `straat`, `plaats`, `postcode`, `email`, `ww`, `telefoon`, `punten`, `rol`, `actief`) VALUES
(1, 'Roy', 'Bulten', 'dPCsolutions', '1', 'smidsstraat', 'Zelhem', '7021AB', 'admin@gmail.com', '1', '0314620144', 10000, 1, 'actief'),
(2, 'John', 'Doe', 'Bedrijf', '4', 'teststraat', 'Teststad', '6420XD', 'klant@gmail.com', '2', '0675476566', 800, 0, 'inactief'),
(5, 'pietje', 'mulders', 'bedrijf2', '4', 'de witstraat', 'Pasen', '6921XD', 'kaas@gmail.com', '3', '0314620144', 1023, 0, 'actief'),
(6, 'Jaap', 'Schaap', 'Wol', '18', 'zeddam', 'Pasen', '6921XD', 'wol@gmail.com', '4', '0314620144', 1050, 0, 'actief');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `prijs` double NOT NULL,
  `omschrijving` varchar(255) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `onderdeel` varchar(255) NOT NULL,
  `merk` varchar(255) NOT NULL,
  `fabriekscode` varchar(255) NOT NULL,
  `conditie` varchar(255) NOT NULL,
  `foto1` varchar(255) DEFAULT NULL,
  `foto2` varchar(255) DEFAULT NULL,
  `foto3` varchar(255) DEFAULT NULL,
  `foto4` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `naam`, `prijs`, `omschrijving`, `categorie`, `onderdeel`, `merk`, `fabriekscode`, `conditie`, `foto1`, `foto2`, `foto3`, `foto4`) VALUES
(1, 'Titanum TM116W Draadloze muis', 6.5, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea laborum quo architecto reiciendis laboriosam, magnam quae tempora commodi atque nulla illo voluptatem! Officiis odio, qui cumque deleniti quaerat iste dignissimos.', 'invoer', 'muizen', 'Esperanza', '8047567', 'goed', 'https://m.media-amazon.com/images/I/51VmZjSTWWL._AC_SL1001_.jpg', 'https://m.media-amazon.com/images/I/51UqEJ9uq0L._AC_SL1000_.jpg', 'https://m.media-amazon.com/images/I/61WOtsZ2qBL._AC_SL1000_.jpg', ''),
(9, 'M185', 15, 'M185 staat altijd voor u klaar. Sluit de ontvanger aan op de USB-poort van uw apparaat om binnen enkele seconden te beginnen met werken. Het kleine formaat en de soepele cursorbesturing maken hem uiterst geschikt voor kleine werkruimtes en volle bureaus.', 'invoer', 'muizen', 'Logitech', '4224', 'goed', 'https://cdn.webshopapp.com/shops/327610/files/376257268/890x820x2/logitech-logitech-m185-wireless-grijs.jpg', 'https://cdn.webshopapp.com/shops/327610/files/376257281/890x820x2/logitech-logitech-m185-wireless-grijs.jpg', 'https://cdn.webshopapp.com/shops/327610/files/376257284/890x820x2/logitech-logitech-m185-wireless-grijs.jpg', 'https://cdn.webshopapp.com/shops/327610/files/376257282/890x820x2/logitech-logitech-m185-wireless-grijs.jpg'),
(10, 'Wireless optical mouse', 30, 'Kenmerken:\r\nDraadloze optische 4-knops muis met USB Nano ontvanger\r\nHandige CPI knop voor het snel aanpassen van de gevoeligheid van de muis (800 - 1600 DPI)\r\n\r\nSpecificaties:\r\nWireless technology: 2.4 GHz, GFSK RF modulation, 80 channels, 32 bit device I', 'invoer', 'muizen', 'Gembird', '6969', 'nieuw', 'https://media.s-bol.com/71yyyDXjn1Mw/124x96.jpg', 'https://media.s-bol.com/r8qqqEV9o404/124x91.jpg', 'https://media.s-bol.com/nxmmmY6Ok4ZW/124x131.jpg', 'https://media.s-bol.com/K6PEBXY5OOOY/124x48.jpg'),
(11, 'Optimum Headphone In-Ear Black', 10, 'Te gebruiken in combinatie met smartphones of andere apparatuur met een audioaansluiting. Met zachte oorcaps voor een optimale pasvorm en draagcomfort.\r\n\r\nDriver unit: 10mm.\r\nMaximale power: 3mW.\r\nFrequentie: 20 - 20kHz.\r\nLengte: 1,2 meter (kabellengte).\r', 'audio', 'oordopjes', 'Grixx', '520420', 'nieuw', 'https://cdn.webshopapp.com/shops/300966/files/404255485/grixx-optimum-headphone-in-ear-black.jpg', 'https://cdn.webshopapp.com/shops/300966/files/404255487/700x700x2/grixx-optimum-headphone-in-ear-black.jpg', 'https://cdn.webshopapp.com/shops/300966/files/404255489/grixx-optimum-headphone-in-ear-black.jpg', ''),
(12, 'Capacitive Stylus incl. Ballpoint White', 10, 'Met deze multifunctionele stylus kunt u uw smartphone en tablet veel nauwkeuriger bedienen dan dat u met uw vingers kunt. Daarnaast voorkomt het gebruik van deze stylus dat er vette vingerafdrukken op het scherm van uw toestel komen. Met deze stylus kunt ', 'accesoire', 'stylus', 'Xccess', '123456', 'nieuw', 'https://www.ubuy.co.in/productimg/?image=aHR0cHM6Ly9pbWFnZXMtbmEuc3NsLWltYWdlcy1hbWF6b24uY29tL2ltYWdlcy9JLzQxeHFsJTJCbVVnSEwuX1NTNDAwXy5qcGc.jpg', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aanbieding`
--
ALTER TABLE `aanbieding`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bestelling`
--
ALTER TABLE `bestelling`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aanbieding`
--
ALTER TABLE `aanbieding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bestelling`
--
ALTER TABLE `bestelling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
