-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 26, 2024 at 09:48 AM
-- Server version: 11.6.2-MariaDB-ubu2404
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coba`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_siswa`
--

CREATE TABLE `login_siswa` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `login_siswa`
--

INSERT INTO `login_siswa` (`id`, `email`, `username`, `password`) VALUES
(1, 'mii@gmail.com', 'kazuo', '$2y$10$D8yoMWr9P9GlxrRs3CPfcOXq2SVvr1.UYaWBCX47mnCIPVoeW5nBy'),
(2, 'intul3423@gmail.com', 'inayGemoy', '$2y$10$Z5YA2.UDo9lZfKtFaDKZGekJQd6OS6sWLZT1dp1yWUL0H9b6rLL66'),
(3, 'indah@gmail.com', 'indah', '$2y$10$QQheI23HB7euFaOkWKYa0ejy73fH857owFe5skDeQTuPcjYEE5inm'),
(4, 'kazuo71@gmail.com', 'kazuo-mii', '$2y$10$Qz0vUl3Yvq6E6eM4wMj.2.j2m02l0I.1iwUUbNQdhDl9NJXpR6rEi');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `nilai` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `kelas`, `nilai`, `alamat`, `no_hp`) VALUES
(26, 'Danish Raihan S', 'xi rpl 2', 90, 'bunga rampai, malaka', '089557869380'),
(32, 'Faris Hilmi Al - Iza', 'xi rpl 2', 90, 'ky tinggi', '0934580345'),
(40, 'Inayatul Kamila', 'xi rpl 2', 90, 'pulo gebang', '093458034590'),
(41, 'Faiz Dhiya Al - Iza', 'xi rpl 1', 90, 'ky tinggi', '089557889323');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_siswa`
--
ALTER TABLE `login_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_siswa`
--
ALTER TABLE `login_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
