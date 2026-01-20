-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jan 11, 2026 at 12:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `autoaction`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorii`
--

CREATE TABLE `categorii` (
  `id` int(11) NOT NULL,
  `nume` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `licitatii`
--

CREATE TABLE `licitatii` (
  `id` int(11) NOT NULL,
  `id_masina` int(11) NOT NULL,
  `id_utilizator` int(11) NOT NULL,
  `suma_oferita` double NOT NULL,
  `data_licitatie` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `licitatii`
--

INSERT INTO `licitatii` (`id`, `id_masina`, `id_utilizator`, `suma_oferita`, `data_licitatie`) VALUES
(1, 2, 4, 30001, '2026-01-10 19:02:24'),
(2, 2, 4, 40, '2026-01-10 19:09:34'),
(3, 2, 5, 50, '2026-01-10 19:10:04'),
(4, 3, 4, 45, '2026-01-10 20:27:22'),
(5, 3, 5, 213, '2026-01-10 20:27:44'),
(6, 3, 2, 33333, '2026-01-10 21:56:55'),
(7, 3, 2, 40000, '2026-01-10 21:59:05'),
(8, 3, 2, 50000, '2026-01-10 21:59:16'),
(9, 3, 3, 60000, '2026-01-10 21:59:37'),
(10, 5, 2, 30002, '2026-01-10 22:04:32'),
(11, 3, 2, 60002, '2026-01-10 23:27:41');

-- --------------------------------------------------------

--
-- Table structure for table `masini`
--

CREATE TABLE `masini` (
  `id` int(11) NOT NULL,
  `firma` varchar(50) DEFAULT NULL,
  `id_categorie` int(11) DEFAULT NULL,
  `submodel` varchar(50) DEFAULT NULL,
  `an` int(4) DEFAULT NULL,
  `descriere` text DEFAULT NULL,
  `pret_pornire` double NOT NULL,
  `imagine` varchar(255) DEFAULT NULL,
  `data_finalizare` datetime DEFAULT NULL,
  `motorizare` enum('Benzina','Diesel','Electrica') DEFAULT 'Benzina',
  `kilometri` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masini`
--

INSERT INTO `masini` (`id`, `firma`, `id_categorie`, `submodel`, `an`, `descriere`, `pret_pornire`, `imagine`, `data_finalizare`, `motorizare`, `kilometri`) VALUES
(3, 'Toyota', NULL, 'Supra', 1987, 'Toyota Supra este un model legendar de performanță, recunoscut la nivel mondial pentru motorul său robust și potențialul uriaș de tuning. Designul său aerodinamic și sportiv îmbină perfect moștenirea istorică a mărcii cu tehnologia modernă de ultimă oră.', 60002, 'toyota-supra-mk4-1024x576.png', NULL, 'Benzina', 130000),
(4, 'Lamborghini', NULL, 'Miura', 1970, 'Lamborghini Miura este adesea considerat primul „supercar” adevărat din istorie, revoluționând lumea auto prin designul său curbat și motorul V12 amplasat central. Această capodoperă italiană rămâne un simbol etern al eleganței și vitezei, fiind una dintre cele mai frumoase mașini create vreodată.', 1000000, 'images.jfif', NULL, 'Benzina', 560000),
(5, 'Tesla ', NULL, 'Roadster', 2025, 'Tesla este pionierul mobilității electrice, transformând industria auto prin tehnologie software avansată și performanțe uluitoare de accelerație. Modelele sale redefinesc experiența condusului modern prin designul minimalist și sistemul inovator de condus autonom.', 30002, 'download.jfif', NULL, 'Electrica', 14000),
(6, 'BMW', NULL, 'Seria 3', 2004, 'BMW Seria 3 318i Touring este break-ul ideal care îmbină utilitatea unui spațiu generos de portbagaj cu manevrabilitatea sportivă specifică mărcii bavareze. Această variantă oferă un echilibru perfect între eficiența consumului și eleganța premium, fiind o alegere rafinată pentru familiile active.', 3600, '08d4f857aab9b71474aba2729ef7e0ea.jfif', NULL, 'Diesel', 300000),
(7, 'Opel', NULL, 'Astra`', 2003, 'Opel Astra 2003, cunoscută și sub numele de generația G, este apreciată pentru fiabilitatea sa remarcabilă și costurile de întreținere accesibile pe piața second-hand. Cu un design echilibrat și o gamă variată de motorizări, acest model rămâne una dintre cele mai practice soluții pentru transportul zilnic în oraș sau la drum lung.', 2500, 'images (1).jfif', NULL, 'Diesel', 234000);

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

CREATE TABLE `utilizatori` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('user','admin') DEFAULT 'user',
  `avatar` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`id`, `username`, `email`, `password`, `rol`, `avatar`) VALUES
(1, 'username', 'email@gmail.com', '$2y$10$ogHy4CF9l24VBPRTIoquT.Bekk5eV7WoPpfW3OR/L9g8/2gW8UY7.', 'admin', 'default.png'),
(2, 'username1', 'email1@gmail.com', '$2y$10$/XdNyN3sdsgiSsaOEN12vOeprexrwBua9cOel7Qte3JRNA90QBFHm', 'user', 'default.png'),
(3, 'username2', 'email2@gmail.com', '$2y$10$WSnsGLevpLTI78hUfNlxOO.ZliVGTCqQlspSCe8rSmm9s29qDpM.q', 'user', 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorii`
--
ALTER TABLE `categorii`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `licitatii`
--
ALTER TABLE `licitatii`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `masini`
--
ALTER TABLE `masini`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorii`
--
ALTER TABLE `categorii`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `licitatii`
--
ALTER TABLE `licitatii`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `masini`
--
ALTER TABLE `masini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
