-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 22, 2024 at 07:43 AM
-- Server version: 8.0.38
-- PHP Version: 8.1.10

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
-- Table structure for table `dosen_dpl`
--

CREATE TABLE `dosen_dpl` (
  `id_dosen_dpl` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nipdpl` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dosen_dpl`
--

INSERT INTO `dosen_dpl` (`id_dosen_dpl`, `nama`, `nipdpl`, `email`, `password`) VALUES
(2, 'Dosen DPL 3', '3333', '3333@gmail.com', '$2y$10$GKAqdOcFgGJ9/MmdcD0V/u06wYtDLlmsErFGMybjoKHFk.3i7.xFe');

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
(3, 'Dosen Kampus Merdeka 2', '2222', '2222@gmail.com', '$2y$10$sWttRViwbKZv9dFqYG88GuDVluXZ4LRUqVJx0iaRTZdhyAITc2ZOq');

-- --------------------------------------------------------

--
-- Table structure for table `kaprodi`
--

CREATE TABLE `kaprodi` (
  `id_kaprodi` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nipkp` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kaprodi`
--

INSERT INTO `kaprodi` (`id_kaprodi`, `nama`, `nipkp`, `email`, `password`) VALUES
(3, 'Dosen Kaprodi 4', '4444', '4444@gmail.com', '$2y$10$5AtDmmwBDc4.VvXaVVpI/e6XG.TxiOjfLUDt6jncSIA71GZtcMk..');

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
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `id_mahasiswa`, `id_dosen_kampusmerdeka`, `id_dosen_dpl`, `id_kaprodi`, `id_program`, `tanggal`, `deskripsi`, `status_dosen_kampusmerdeka`, `status_dosen_dpl`, `status_kaprodi`, `foto`) VALUES
(15, 3, 3, 2, 3, 5, '2024-07-23', 'Tambah Kegiatan', 'Diverifikasi', 'Diverifikasi', 'Divalidasi', NULL),
(16, 3, 3, 2, 3, 5, '2024-07-21', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.', 'Diverifikasi', 'Diverifikasi', 'Divalidasi', ''),
(17, 3, 3, 2, 3, 5, '2024-07-22', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe necessitatibus labore eos, nostrum neque maiores? Id cum dolore, nisi sequi dolores quibusdam nam, blanditiis quisquam, quidem magni corporis? Cum, quibusdam.', 'Diverifikasi', 'Diverifikasi', 'Divalidasi', ''),
(18, 3, 3, 2, 3, 5, '2024-07-24', 'Testing penambahan laporan', 'Diverifikasi', 'Pending', 'Pending', ''),
(19, 3, 3, 2, 3, 5, '2024-07-22', 'perbaikan Laporan kegiatan', 'Ditolak', 'Pending', 'Pending', '');

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
(3, 'Mahasiswa 1', '1111', '1111@gmail.com', '$2y$10$YEeCKuE0CQs2aIGTUHNyK.X8jMlA/EIHebPweV7kKbCmMGSjab.mW');

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
  `status` enum('Aktif','Tidak Aktif') DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(5, 'Kampus Mengajar', NULL, '2024-07-22', 120, 2, 3, 3, 3);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `dosen_dpl`
--
ALTER TABLE `dosen_dpl`
  MODIFY `id_dosen_dpl` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dosen_kampusmerdeka`
--
ALTER TABLE `dosen_kampusmerdeka`
  MODIFY `id_dosen_kampusmerdeka` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kaprodi`
--
ALTER TABLE `kaprodi`
  MODIFY `id_kaprodi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `monitoring_dpl`
--
ALTER TABLE `monitoring_dpl`
  MODIFY `id_monitoring` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programmbkm`
--
ALTER TABLE `programmbkm`
  MODIFY `id_program` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
