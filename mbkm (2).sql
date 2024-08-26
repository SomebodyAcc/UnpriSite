-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 26, 2024 at 10:29 AM
-- Server version: 8.0.38
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mbkm`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `id_administrator` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nid` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id_administrator`, `username`, `email`, `password`, `nid`) VALUES
(3, 'admin2', 'admin', '$2y$10$BqKzR8Y.K6jVV/GkIeekieEELIIhDzk377v1boueQfO9xQZxASor.', 'admin2'),
(5, 'admin3 ', 'admin3', '$2y$10$PJK3jiiC/wuPmtTJoVeIL.UpeEbqrjFavsOQ7.LG8bhR2t0gh4j3e', 'admin3'),
(7, 'data2', 'data2@gmail.com', '$2y$10$KpPeJ1usZxPRKuNtuBTvnewoDmneVQnEI5oWST1q1TXHsaF2ZVTg.', 'data2');

-- --------------------------------------------------------

--
-- Table structure for table `dosen_dpl`
--

CREATE TABLE `dosen_dpl` (
  `id_dosen_dpl` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nipdpl` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dosen_dpl`
--

INSERT INTO `dosen_dpl` (`id_dosen_dpl`, `nama`, `nipdpl`, `email`, `password`, `foto_profil`) VALUES
(2, 'Jojo', '3333', 'Jojo@gmail.com', '$2y$10$wLYyzPIS9eCadGNJBZkhnujdYyMseO3noK5FtJWEepRAe7dnrVx5O', 'Jojo_20240826043448.jpg'),
(3, '6666', '6666', '6666@gmail.com', '$2y$10$6pixuUhtJwJwZdvYJal9luccznNkfHcjX7hKWm46WJYYOuFlDree6', '6666_20240826090402.png');

-- --------------------------------------------------------

--
-- Table structure for table `dosen_kampusmerdeka`
--

CREATE TABLE `dosen_kampusmerdeka` (
  `id_dosen_kampusmerdeka` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dosen_kampusmerdeka`
--

INSERT INTO `dosen_kampusmerdeka` (`id_dosen_kampusmerdeka`, `nama`, `nip`, `email`, `password`) VALUES
(3, 'Dosen Kampus Merdeka 2', '2222', '2222@gmail.com', '$2y$10$sWttRViwbKZv9dFqYG88GuDVluXZ4LRUqVJx0iaRTZdhyAITc2ZOq'),
(5, 'admin', '', 'admin@gmail.com', '$2y$10$rmaB6vTEdcduAHqoyc6Cjeif7vNIym.RJq2EHu7.V75IpeqA83aY6');

-- --------------------------------------------------------

--
-- Table structure for table `kaprodi`
--

CREATE TABLE `kaprodi` (
  `id_kaprodi` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nipkp` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kaprodi`
--

INSERT INTO `kaprodi` (`id_kaprodi`, `nama`, `nipkp`, `email`, `password`, `foto_profil`) VALUES
(3, 'Bobby', '4444', 'Bobby@gmail.com', '$2y$10$D4SrQjztgGoK/4HW4ExwcOU5Qln4qhiVti25/4KA64L9f9Iy4dCTS', 'Bobby_20240826044050.png');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int NOT NULL,
  `id_mahasiswa` int NOT NULL,
  `id_dosen_kampusmerdeka` int DEFAULT NULL,
  `id_dosen_dpl` int DEFAULT NULL,
  `id_kaprodi` int DEFAULT NULL,
  `id_program` int NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` text NOT NULL,
  `status_dosen_kampusmerdeka` enum('Pending','Diverifikasi','Ditolak') DEFAULT 'Pending',
  `status_dosen_dpl` enum('Pending','Diverifikasi','Ditolak') DEFAULT 'Pending',
  `status_kaprodi` enum('Pending','Divalidasi','Ditolak') DEFAULT 'Pending',
  `foto` varchar(255) DEFAULT NULL,
  `uploadat` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `id_mahasiswa`, `id_dosen_kampusmerdeka`, `id_dosen_dpl`, `id_kaprodi`, `id_program`, `tanggal`, `deskripsi`, `status_dosen_kampusmerdeka`, `status_dosen_dpl`, `status_kaprodi`, `foto`, `uploadat`) VALUES
(15, 3, 3, 2, 3, 5, '2024-07-23', 'Tambah Kegiatan', 'Diverifikasi', 'Diverifikasi', 'Divalidasi', NULL, '2024-08-26 12:01:40'),
(16, 3, 3, 2, 3, 5, '2024-07-21', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.', 'Diverifikasi', 'Diverifikasi', 'Divalidasi', '', '2024-08-26 12:01:40'),
(17, 3, 3, 2, 3, 5, '2024-07-22', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.', 'Diverifikasi', 'Diverifikasi', 'Divalidasi', '', '2024-08-26 12:01:40'),
(18, 3, 3, 2, 3, 5, '2024-07-24', 'Testing penambahan laporan', 'Diverifikasi', 'Diverifikasi', 'Divalidasi', '', '2024-08-26 12:01:40'),
(19, 3, 3, 2, 3, 5, '2024-07-24', 'perbaikan Laporan kegiatan v2', 'Diverifikasi', 'Diverifikasi', 'Divalidasi', '', '2024-08-26 12:01:40'),
(20, 4, 3, 2, 3, 6, '2024-07-23', 'Tambah kegiatan program PMM', 'Pending', 'Pending', 'Pending', NULL, '2024-08-26 12:01:40'),
(21, 4, 3, 2, 3, 6, '2024-07-24', 'Penambahan part 2', 'Pending', 'Pending', 'Pending', '', '2024-08-26 12:01:40'),
(22, 4, 3, 2, 3, 6, '2024-07-31', 'penambahan file part 3', 'Pending', 'Pending', 'Pending', '', '2024-08-26 12:01:40'),
(23, 3, 3, 2, 3, 5, '2024-07-24', 'Perbaiki laporan', 'Diverifikasi', 'Diverifikasi', 'Divalidasi', '', '2024-08-26 12:01:40'),
(24, 3, 3, 2, 3, 5, '2024-06-19', 'tambah tanggal', 'Diverifikasi', 'Pending', 'Pending', '', '2024-08-26 12:01:40'),
(25, 3, 3, 2, 3, 5, '2024-08-23', 'Kegiatan Ditambahkan', 'Diverifikasi', 'Diverifikasi', 'Divalidasi', '', '2024-08-26 12:01:40'),
(26, 3, 3, 2, 3, 5, '2024-08-25', 'Saya mencoba upload gambar', 'Diverifikasi', 'Pending', 'Pending', 'Mah_20240826.png', '2024-08-26 12:13:47');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pswrd` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nama`, `nim`, `email`, `pswrd`) VALUES
(3, 'Mahasiswa 1', '1111', '1111@gmail.com', '$2y$10$YEeCKuE0CQs2aIGTUHNyK.X8jMlA/EIHebPweV7kKbCmMGSjab.mW'),
(4, '5555', '5555', '5555@gmail.com', '$2y$10$ARvMRH8tvcbVirMdaNdw9.lTYR.2nFZWu.Vjk9i.XzgefDOdfs/86');

-- --------------------------------------------------------

--
-- Table structure for table `monitoring_dpl`
--

CREATE TABLE `monitoring_dpl` (
  `id_monitoring` int NOT NULL,
  `id_dosen_dpl` int NOT NULL,
  `id_kaprodi` int NOT NULL,
  `id_mahasiswa` int NOT NULL,
  `tanggal_monitoring` date NOT NULL,
  `status` enum('Aktif','Tidak Aktif') DEFAULT 'Aktif',
  `score` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `monitoring_dpl`
--

INSERT INTO `monitoring_dpl` (`id_monitoring`, `id_dosen_dpl`, `id_kaprodi`, `id_mahasiswa`, `tanggal_monitoring`, `status`, `score`) VALUES
(1, 2, 3, 3, '2024-08-07', 'Aktif', 80);

-- --------------------------------------------------------

--
-- Table structure for table `programmbkm`
--

CREATE TABLE `programmbkm` (
  `id_program` int NOT NULL,
  `nama_program` varchar(100) NOT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `tanggal_awal` date DEFAULT NULL,
  `lama_waktu` int DEFAULT NULL,
  `id_dosen_dpl` int DEFAULT NULL,
  `id_kaprodi` int DEFAULT NULL,
  `id_dosen_kampusmerdeka` int DEFAULT NULL,
  `id_mahasiswa` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `programmbkm`
--

INSERT INTO `programmbkm` (`id_program`, `nama_program`, `gambar`, `tanggal_awal`, `lama_waktu`, `id_dosen_dpl`, `id_kaprodi`, `id_dosen_kampusmerdeka`, `id_mahasiswa`) VALUES
(5, 'Kampus Mengajar', NULL, '2024-07-22', 120, 2, 3, 3, 3),
(6, 'PMM 3', NULL, '2024-07-22', 120, 2, 3, 3, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id_administrator`),
  ADD UNIQUE KEY `nid` (`nid`);

--
-- Indexes for table `dosen_dpl`
--
ALTER TABLE `dosen_dpl`
  ADD PRIMARY KEY (`id_dosen_dpl`),
  ADD UNIQUE KEY `nipdpl` (`nipdpl`);

--
-- Indexes for table `dosen_kampusmerdeka`
--
ALTER TABLE `dosen_kampusmerdeka`
  ADD PRIMARY KEY (`id_dosen_kampusmerdeka`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `kaprodi`
--
ALTER TABLE `kaprodi`
  ADD PRIMARY KEY (`id_kaprodi`),
  ADD UNIQUE KEY `nipkp` (`nipkp`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`),
  ADD KEY `id_dosen_kampusmerdeka` (`id_dosen_kampusmerdeka`),
  ADD KEY `id_dosen_dpl` (`id_dosen_dpl`),
  ADD KEY `id_kaprodi` (`id_kaprodi`),
  ADD KEY `id_program` (`id_program`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `monitoring_dpl`
--
ALTER TABLE `monitoring_dpl`
  ADD PRIMARY KEY (`id_monitoring`),
  ADD KEY `id_dosen_dpl` (`id_dosen_dpl`),
  ADD KEY `id_kaprodi` (`id_kaprodi`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`);

--
-- Indexes for table `programmbkm`
--
ALTER TABLE `programmbkm`
  ADD PRIMARY KEY (`id_program`),
  ADD KEY `id_dosen_dpl` (`id_dosen_dpl`),
  ADD KEY `id_kaprodi` (`id_kaprodi`),
  ADD KEY `id_dosen_mbkm` (`id_dosen_kampusmerdeka`),
  ADD KEY `fk_program_mahasiswa` (`id_mahasiswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id_administrator` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dosen_dpl`
--
ALTER TABLE `dosen_dpl`
  MODIFY `id_dosen_dpl` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dosen_kampusmerdeka`
--
ALTER TABLE `dosen_kampusmerdeka`
  MODIFY `id_dosen_kampusmerdeka` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kaprodi`
--
ALTER TABLE `kaprodi`
  MODIFY `id_kaprodi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `monitoring_dpl`
--
ALTER TABLE `monitoring_dpl`
  MODIFY `id_monitoring` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `programmbkm`
--
ALTER TABLE `programmbkm`
  MODIFY `id_program` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`),
  ADD CONSTRAINT `kegiatan_ibfk_2` FOREIGN KEY (`id_dosen_kampusmerdeka`) REFERENCES `dosen_kampusmerdeka` (`id_dosen_kampusmerdeka`),
  ADD CONSTRAINT `kegiatan_ibfk_3` FOREIGN KEY (`id_dosen_dpl`) REFERENCES `dosen_dpl` (`id_dosen_dpl`),
  ADD CONSTRAINT `kegiatan_ibfk_4` FOREIGN KEY (`id_kaprodi`) REFERENCES `kaprodi` (`id_kaprodi`),
  ADD CONSTRAINT `kegiatan_ibfk_5` FOREIGN KEY (`id_program`) REFERENCES `programmbkm` (`id_program`);

--
-- Constraints for table `monitoring_dpl`
--
ALTER TABLE `monitoring_dpl`
  ADD CONSTRAINT `monitoring_dpl_ibfk_1` FOREIGN KEY (`id_dosen_dpl`) REFERENCES `dosen_dpl` (`id_dosen_dpl`),
  ADD CONSTRAINT `monitoring_dpl_ibfk_2` FOREIGN KEY (`id_kaprodi`) REFERENCES `kaprodi` (`id_kaprodi`),
  ADD CONSTRAINT `monitoring_dpl_ibfk_3` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`);

--
-- Constraints for table `programmbkm`
--
ALTER TABLE `programmbkm`
  ADD CONSTRAINT `fk_program_mahasiswa` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`),
  ADD CONSTRAINT `programmbkm_ibfk_1` FOREIGN KEY (`id_dosen_dpl`) REFERENCES `dosen_dpl` (`id_dosen_dpl`),
  ADD CONSTRAINT `programmbkm_ibfk_2` FOREIGN KEY (`id_kaprodi`) REFERENCES `kaprodi` (`id_kaprodi`),
  ADD CONSTRAINT `programmbkm_ibfk_3` FOREIGN KEY (`id_dosen_kampusmerdeka`) REFERENCES `dosen_kampusmerdeka` (`id_dosen_kampusmerdeka`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
