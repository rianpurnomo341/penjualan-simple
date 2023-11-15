-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2023 at 02:10 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_penjualan_simple`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `display` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` bigint(20) UNSIGNED DEFAULT NULL,
  `satuan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `diskon` int(11) DEFAULT NULL,
  `harga_before_diskon` int(11) NOT NULL,
  `harga_after_diskon` int(11) NOT NULL,
  `tgl_kadaluarsa` date NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `display`, `kode_barang`, `nama_barang`, `kategori_id`, `satuan_id`, `qty`, `diskon`, `harga_before_diskon`, `harga_after_diskon`, `tgl_kadaluarsa`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'display1', 'KD-BR-1', 'Teh', 1, 1, 3, 10, 1000, 2000, '2023-02-02', 'deskripsi1', '2023-11-14 06:41:25', '2023-11-15 13:03:34'),
(2, 'display1221', 'KD-BR-2', 'Ayam', 1, 1, -2, 102, 10002, 20002, '2023-02-12', 'deskripsi12', '2023-11-14 06:41:29', '2023-11-15 13:03:34'),
(3, 'display1', 'KD-BR-3', 'Sapi', 1, 1, 10, 10, 1000, 2000, '2023-02-02', 'deskripsi1', '2023-11-14 06:42:27', '2023-11-15 13:03:34');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id_detail_pembelian` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pembelian_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `harga_pembelian` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`id_detail_pembelian`, `barang_id`, `pembelian_id`, `qty`, `harga_pembelian`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 10, 20000, '2023-11-14 07:17:17', '2023-11-14 07:17:17'),
(2, 1, 8, 20, 10000, '2023-11-14 07:17:17', '2023-11-14 07:17:17'),
(3, 1, 8, 30, 55000, '2023-11-14 07:17:17', '2023-11-14 07:17:17'),
(4, 1, 9, 10, 20000, '2023-11-14 07:17:35', '2023-11-14 07:17:35'),
(5, 1, 9, 20, 10000, '2023-11-14 07:17:35', '2023-11-14 07:17:35'),
(6, 1, 9, 30, 55000, '2023-11-14 07:17:35', '2023-11-14 07:17:35'),
(7, 1, 18, 10, 20000, '2023-11-14 12:35:25', '2023-11-14 12:35:25'),
(8, 1, 18, 20, 10000, '2023-11-14 12:35:25', '2023-11-14 12:35:25'),
(9, 1, 18, 30, 55000, '2023-11-14 12:35:25', '2023-11-14 12:35:25'),
(10, 1, 20, 10, 20000, '2023-11-15 12:18:28', '2023-11-15 12:18:28'),
(11, 1, 20, 20, 10000, '2023-11-15 12:18:28', '2023-11-15 12:18:28'),
(12, 1, 20, 30, 55000, '2023-11-15 12:18:28', '2023-11-15 12:18:28'),
(13, 1, 21, 5, 20000, '2023-11-15 12:18:54', '2023-11-15 12:18:54'),
(14, 1, 21, 10, 10000, '2023-11-15 12:18:54', '2023-11-15 12:18:54'),
(15, 1, 21, 15, 55000, '2023-11-15 12:18:54', '2023-11-15 12:18:54'),
(16, 1, 22, 5, 20000, '2023-11-15 12:19:09', '2023-11-15 12:19:09'),
(17, 1, 22, 10, 10000, '2023-11-15 12:19:09', '2023-11-15 12:19:09'),
(18, 1, 22, 15, 55000, '2023-11-15 12:19:09', '2023-11-15 12:19:09'),
(19, 1, 23, 5, 20000, '2023-11-15 12:19:18', '2023-11-15 12:19:18'),
(20, 1, 23, 10, 10000, '2023-11-15 12:19:18', '2023-11-15 12:19:18'),
(21, 1, 23, 0, 55000, '2023-11-15 12:19:18', '2023-11-15 12:19:18'),
(22, 1, 24, 5, 20000, '2023-11-15 12:19:28', '2023-11-15 12:19:28'),
(23, 1, 24, 10, 10000, '2023-11-15 12:19:28', '2023-11-15 12:19:28'),
(24, 1, 24, 5, 55000, '2023-11-15 12:19:28', '2023-11-15 12:19:28'),
(25, 1, 25, 5, 20000, '2023-11-15 12:22:37', '2023-11-15 12:22:37'),
(26, 1, 25, 10, 10000, '2023-11-15 12:22:37', '2023-11-15 12:22:37'),
(27, 1, 25, 5, 55000, '2023-11-15 12:22:37', '2023-11-15 12:22:37'),
(28, 1, 26, 5, 20000, '2023-11-15 12:22:55', '2023-11-15 12:22:55'),
(29, 1, 26, 10, 10000, '2023-11-15 12:22:55', '2023-11-15 12:22:55'),
(30, 1, 26, 5, 55000, '2023-11-15 12:22:55', '2023-11-15 12:22:55'),
(31, 1, 27, 5, 20000, '2023-11-15 12:23:34', '2023-11-15 12:23:34'),
(32, 1, 27, 10, 10000, '2023-11-15 12:23:34', '2023-11-15 12:23:34'),
(33, 1, 27, 5, 55000, '2023-11-15 12:23:34', '2023-11-15 12:23:34'),
(34, 1, 28, 5, 20000, '2023-11-15 12:23:45', '2023-11-15 12:23:45'),
(35, 1, 28, 10, 10000, '2023-11-15 12:23:45', '2023-11-15 12:23:45'),
(36, 1, 28, 5, 55000, '2023-11-15 12:23:45', '2023-11-15 12:23:45'),
(37, 1, 30, 5, 20000, '2023-11-15 12:26:59', '2023-11-15 12:26:59'),
(38, 1, 30, 10, 10000, '2023-11-15 12:26:59', '2023-11-15 12:26:59'),
(39, 1, 30, 5, 55000, '2023-11-15 12:26:59', '2023-11-15 12:26:59'),
(40, 1, 31, 5, 20000, '2023-11-15 12:27:12', '2023-11-15 12:27:12'),
(41, 1, 31, 10, 10000, '2023-11-15 12:27:12', '2023-11-15 12:27:12'),
(42, 1, 31, 15, 55000, '2023-11-15 12:27:12', '2023-11-15 12:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail_penjualan` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `penjualan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `harga_penjualan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_detail_penjualan`, `barang_id`, `penjualan_id`, `qty`, `harga_penjualan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 6000, '2023-11-14 07:34:29', '2023-11-14 07:34:29'),
(2, 1, 1, 2, 7000, '2023-11-14 07:34:29', '2023-11-14 07:34:29'),
(3, 1, 1, 3, 4000, '2023-11-14 07:34:29', '2023-11-14 07:34:29'),
(4, 1, 2, 1, 6000, '2023-11-14 11:36:01', '2023-11-14 11:36:01'),
(5, 1, 2, 2, 7000, '2023-11-14 11:36:01', '2023-11-14 11:36:01'),
(6, 1, 2, 3, 4000, '2023-11-14 11:36:01', '2023-11-14 11:36:01'),
(7, 1, 3, 1, 6000, '2023-11-15 12:28:33', '2023-11-15 12:28:33'),
(8, 1, 3, 2, 7000, '2023-11-15 12:28:33', '2023-11-15 12:28:33'),
(9, 1, 3, 7, 4000, '2023-11-15 12:28:33', '2023-11-15 12:28:33'),
(10, 1, 4, 1, 6000, '2023-11-15 12:37:34', '2023-11-15 12:37:34'),
(11, 2, 4, 2, 7000, '2023-11-15 12:37:34', '2023-11-15 12:37:34'),
(12, 1, 4, 7, 4000, '2023-11-15 12:37:35', '2023-11-15 12:37:35'),
(13, 1, 5, 1, 6000, '2023-11-15 12:38:10', '2023-11-15 12:38:10'),
(14, 2, 5, 2, 7000, '2023-11-15 12:38:10', '2023-11-15 12:38:10'),
(15, 1, 5, 7, 4000, '2023-11-15 12:38:10', '2023-11-15 12:38:10'),
(16, 1, 6, 1, 6000, '2023-11-15 12:39:26', '2023-11-15 12:39:26'),
(17, 2, 6, 2, 7000, '2023-11-15 12:39:26', '2023-11-15 12:39:26'),
(18, 1, 6, 7, 4000, '2023-11-15 12:39:26', '2023-11-15 12:39:26'),
(19, 1, 7, 1, 6000, '2023-11-15 12:47:17', '2023-11-15 12:47:17'),
(20, 2, 7, 2, 7000, '2023-11-15 12:47:17', '2023-11-15 12:47:17'),
(21, 1, 7, 7, 4000, '2023-11-15 12:47:17', '2023-11-15 12:47:17'),
(22, 1, 8, 1, 6000, '2023-11-15 12:47:29', '2023-11-15 12:47:29'),
(23, 2, 8, 2, 7000, '2023-11-15 12:47:29', '2023-11-15 12:47:29'),
(24, 1, 8, 7, 4000, '2023-11-15 12:47:29', '2023-11-15 12:47:29'),
(25, 1, 9, 1, 6000, '2023-11-15 12:54:25', '2023-11-15 12:54:25'),
(26, 2, 9, 2, 7000, '2023-11-15 12:54:25', '2023-11-15 12:54:25'),
(27, 3, 9, 7, 4000, '2023-11-15 12:54:25', '2023-11-15 12:54:25'),
(28, 1, 10, 1, 6000, '2023-11-15 12:54:57', '2023-11-15 12:54:57'),
(29, 2, 10, 2, 7000, '2023-11-15 12:54:57', '2023-11-15 12:54:57'),
(30, 3, 10, 7, 4000, '2023-11-15 12:54:57', '2023-11-15 12:54:57'),
(31, 1, 11, 1, 6000, '2023-11-15 12:55:51', '2023-11-15 12:55:51'),
(32, 2, 11, 2, 7000, '2023-11-15 12:55:51', '2023-11-15 12:55:51'),
(33, 3, 11, 7, 4000, '2023-11-15 12:55:51', '2023-11-15 12:55:51'),
(34, 1, 12, 1, 6000, '2023-11-15 12:58:22', '2023-11-15 12:58:22'),
(35, 2, 12, 2, 7000, '2023-11-15 12:58:22', '2023-11-15 12:58:22'),
(36, 3, 12, 7, 4000, '2023-11-15 12:58:22', '2023-11-15 12:58:22'),
(37, 1, 13, 1, 6000, '2023-11-15 13:01:09', '2023-11-15 13:01:09'),
(38, 2, 13, 2, 7000, '2023-11-15 13:01:09', '2023-11-15 13:01:09'),
(39, 3, 13, 7, 4000, '2023-11-15 13:01:09', '2023-11-15 13:01:09'),
(40, 1, 14, 1, 6000, '2023-11-15 13:03:27', '2023-11-15 13:03:27'),
(41, 2, 14, 2, 7000, '2023-11-15 13:03:27', '2023-11-15 13:03:27'),
(42, 3, 14, 7, 4000, '2023-11-15 13:03:27', '2023-11-15 13:03:27'),
(43, 1, 15, 1, 6000, '2023-11-15 13:03:34', '2023-11-15 13:03:34'),
(44, 2, 15, 2, 7000, '2023-11-15 13:03:34', '2023-11-15 13:03:34'),
(45, 3, 15, 7, 4000, '2023-11-15 13:03:34', '2023-11-15 13:03:34');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket_kategori` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `ket_kategori`, `created_at`, `updated_at`) VALUES
(1, 'kategori 3', 'keterangan 3', '2023-11-14 06:29:02', '2023-11-14 06:29:02');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` bigint(20) UNSIGNED NOT NULL,
  `pembelian_id` bigint(20) UNSIGNED DEFAULT NULL,
  `penjualan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kode_laporan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_operasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_laporan` date NOT NULL,
  `waktu` time NOT NULL,
  `credit` int(11) NOT NULL,
  `debit` int(11) NOT NULL,
  `saldo` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `pembelian_id`, `penjualan_id`, `kode_laporan`, `nama_operasi`, `tgl_laporan`, `waktu`, `credit`, `debit`, `saldo`, `created_at`, `updated_at`) VALUES
(1, 8, NULL, 'LB-IN-1', 'Pembelian', '2023-11-14', '14:17:17', 400, 0, 400, '2023-11-14 07:17:17', '2023-11-14 07:17:17'),
(2, 9, NULL, 'LB-IN-2', 'Pembelian', '2023-11-14', '14:17:35', 400, 0, 800, '2023-11-14 07:17:35', '2023-11-14 07:17:35'),
(3, NULL, 1, 'LB-OUT-3', 'Penjualan', '2023-11-14', '14:34:28', 0, 400, 400, '2023-11-14 07:34:29', '2023-11-14 07:34:29'),
(4, NULL, 2, 'LB-OUT-4', 'Penjualan', '2023-11-14', '18:36:00', 0, 400, 0, '2023-11-14 11:36:01', '2023-11-14 11:36:01'),
(5, 13, NULL, 'LB-IN-5', 'Pembelian', '2023-11-14', '19:30:10', 400, 0, 400, '2023-11-14 12:30:10', '2023-11-14 12:30:10'),
(6, 16, NULL, 'LB-IN-6', 'Pembelian', '2023-11-14', '19:31:07', 400, 0, 800, '2023-11-14 12:31:07', '2023-11-14 12:31:07'),
(7, 17, NULL, 'LB-IN-7', 'Pembelian', '2023-11-14', '19:31:14', 400, 0, 1200, '2023-11-14 12:31:14', '2023-11-14 12:31:14'),
(8, 18, NULL, 'LB-IN-8', 'Pembelian', '2023-11-14', '19:35:25', 400, 0, 1600, '2023-11-14 12:35:25', '2023-11-14 12:35:25'),
(9, 20, NULL, 'LB-IN-9', 'Pembelian', '2023-11-15', '19:18:28', 400, 0, 2000, '2023-11-15 12:18:29', '2023-11-15 12:18:29'),
(10, 21, NULL, 'LB-IN-10', 'Pembelian', '2023-11-15', '19:18:54', 400, 0, 2400, '2023-11-15 12:18:54', '2023-11-15 12:18:54'),
(11, 22, NULL, 'LB-IN-11', 'Pembelian', '2023-11-15', '19:19:09', 400, 0, 2800, '2023-11-15 12:19:09', '2023-11-15 12:19:09'),
(12, 23, NULL, 'LB-IN-12', 'Pembelian', '2023-11-15', '19:19:18', 400, 0, 3200, '2023-11-15 12:19:18', '2023-11-15 12:19:18'),
(13, 24, NULL, 'LB-IN-13', 'Pembelian', '2023-11-15', '19:19:28', 400, 0, 3600, '2023-11-15 12:19:28', '2023-11-15 12:19:28'),
(14, 26, NULL, 'LB-IN-14', 'Pembelian', '2023-11-15', '19:22:55', 400, 0, 4000, '2023-11-15 12:22:55', '2023-11-15 12:22:55'),
(15, 27, NULL, 'LB-IN-15', 'Pembelian', '2023-11-15', '19:23:34', 400, 0, 4400, '2023-11-15 12:23:34', '2023-11-15 12:23:34'),
(16, 28, NULL, 'LB-IN-16', 'Pembelian', '2023-11-15', '19:23:45', 400, 0, 4800, '2023-11-15 12:23:45', '2023-11-15 12:23:45'),
(17, 29, NULL, 'LB-IN-17', 'Pembelian', '2023-11-15', '19:24:13', 400, 0, 5200, '2023-11-15 12:24:13', '2023-11-15 12:24:13'),
(18, 30, NULL, 'LB-IN-18', 'Pembelian', '2023-11-15', '19:26:59', 400, 0, 5600, '2023-11-15 12:26:59', '2023-11-15 12:26:59'),
(19, 31, NULL, 'LB-IN-19', 'Pembelian', '2023-11-15', '19:27:11', 400, 0, 6000, '2023-11-15 12:27:12', '2023-11-15 12:27:12'),
(20, NULL, 3, 'LB-OUT-20', 'Penjualan', '2023-11-15', '19:28:33', 0, 400, 5600, '2023-11-15 12:28:33', '2023-11-15 12:28:33'),
(21, NULL, 4, 'LB-OUT-21', 'Penjualan', '2023-11-15', '19:37:34', 0, 400, 5200, '2023-11-15 12:37:35', '2023-11-15 12:37:35'),
(22, NULL, 5, 'LB-OUT-22', 'Penjualan', '2023-11-15', '19:38:10', 0, 400, 4800, '2023-11-15 12:38:10', '2023-11-15 12:38:10'),
(23, NULL, 6, 'LB-OUT-23', 'Penjualan', '2023-11-15', '19:39:26', 0, 400, 4400, '2023-11-15 12:39:26', '2023-11-15 12:39:26'),
(24, NULL, 7, 'LB-OUT-24', 'Penjualan', '2023-11-15', '19:47:17', 0, 400, 4000, '2023-11-15 12:47:17', '2023-11-15 12:47:17'),
(25, NULL, 8, 'LB-OUT-25', 'Penjualan', '2023-11-15', '19:47:28', 0, 400, 3600, '2023-11-15 12:47:29', '2023-11-15 12:47:29'),
(26, NULL, 9, 'LB-OUT-26', 'Penjualan', '2023-11-15', '19:54:25', 0, 400, 3200, '2023-11-15 12:54:25', '2023-11-15 12:54:25'),
(27, NULL, 10, 'LB-OUT-27', 'Penjualan', '2023-11-15', '19:54:57', 0, 400, 2800, '2023-11-15 12:54:57', '2023-11-15 12:54:57'),
(28, NULL, 11, 'LB-OUT-28', 'Penjualan', '2023-11-15', '19:55:50', 0, 400, 2400, '2023-11-15 12:55:51', '2023-11-15 12:55:51'),
(29, NULL, 12, 'LB-OUT-29', 'Penjualan', '2023-11-15', '19:58:22', 0, 400, 2000, '2023-11-15 12:58:22', '2023-11-15 12:58:22'),
(30, NULL, 13, 'LB-OUT-30', 'Penjualan', '2023-11-15', '20:01:08', 0, 400, 1600, '2023-11-15 13:01:09', '2023-11-15 13:01:09'),
(31, NULL, 14, 'LB-OUT-31', 'Penjualan', '2023-11-15', '20:03:26', 0, 400, 1200, '2023-11-15 13:03:27', '2023-11-15 13:03:27'),
(32, NULL, 15, 'LB-OUT-32', 'Penjualan', '2023-11-15', '20:03:34', 0, 400, 800, '2023-11-15 13:03:34', '2023-11-15 13:03:34');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_10_02_222548_create_kategoris_table', 1),
(6, '2023_10_02_222559_create_satuans_table', 1),
(7, '2023_10_02_222604_create_supliers_table', 1),
(8, '2023_10_02_222613_create_pembelian_table', 1),
(9, '2023_10_02_222614_create_barangs_table', 1),
(10, '2023_11_08_225600_create_detail_pembelians_table', 1),
(11, '2023_11_12_074006_create_penjualans_table', 1),
(12, '2023_11_12_074744_create_detail_penjualans_table', 1),
(13, '2023_11_12_075620_create_laporans_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` bigint(20) UNSIGNED NOT NULL,
  `suplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal_pembelian` date NOT NULL,
  `total_pembelian` int(11) NOT NULL,
  `jml_bayar_pembelian` int(11) NOT NULL,
  `jml_kembalian_pembelian` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `suplier_id`, `tanggal_pembelian`, `total_pembelian`, `jml_bayar_pembelian`, `jml_kembalian_pembelian`, `created_at`, `updated_at`) VALUES
(8, 1, '2023-11-14', 300, 400, 100, '2023-11-14 07:17:17', '2023-11-14 07:17:17'),
(9, 1, '2023-11-14', 300, 400, 100, '2023-11-14 07:17:35', '2023-11-14 07:17:35'),
(10, 1, '2023-11-14', 300, 400, 100, '2023-11-14 12:29:00', '2023-11-14 12:29:00'),
(11, 1, '2023-11-14', 300, 400, 100, '2023-11-14 12:29:39', '2023-11-14 12:29:39'),
(12, 1, '2023-11-14', 300, 400, 100, '2023-11-14 12:29:51', '2023-11-14 12:29:51'),
(13, 1, '2023-11-14', 300, 400, 100, '2023-11-14 12:30:10', '2023-11-14 12:30:10'),
(14, 1, '2023-11-14', 300, 400, 100, '2023-11-14 12:30:39', '2023-11-14 12:30:39'),
(15, 1, '2023-11-14', 300, 400, 100, '2023-11-14 12:30:59', '2023-11-14 12:30:59'),
(16, 1, '2023-11-14', 300, 400, 100, '2023-11-14 12:31:07', '2023-11-14 12:31:07'),
(17, 1, '2023-11-14', 300, 400, 100, '2023-11-14 12:31:14', '2023-11-14 12:31:14'),
(18, 1, '2023-11-14', 300, 400, 100, '2023-11-14 12:35:25', '2023-11-14 12:35:25'),
(19, 1, '2023-11-15', 300, 400, 100, '2023-11-15 12:18:00', '2023-11-15 12:18:00'),
(20, 1, '2023-11-15', 300, 400, 100, '2023-11-15 12:18:28', '2023-11-15 12:18:28'),
(21, 1, '2023-11-15', 300, 400, 100, '2023-11-15 12:18:54', '2023-11-15 12:18:54'),
(22, 1, '2023-11-15', 300, 400, 100, '2023-11-15 12:19:09', '2023-11-15 12:19:09'),
(23, 1, '2023-11-15', 300, 400, 100, '2023-11-15 12:19:18', '2023-11-15 12:19:18'),
(24, 1, '2023-11-15', 300, 400, 100, '2023-11-15 12:19:28', '2023-11-15 12:19:28'),
(25, 1, '2023-11-15', 300, 400, 100, '2023-11-15 12:22:37', '2023-11-15 12:22:37'),
(26, 1, '2023-11-15', 300, 400, 100, '2023-11-15 12:22:55', '2023-11-15 12:22:55'),
(27, 1, '2023-11-15', 300, 400, 100, '2023-11-15 12:23:34', '2023-11-15 12:23:34'),
(28, 1, '2023-11-15', 300, 400, 100, '2023-11-15 12:23:45', '2023-11-15 12:23:45'),
(29, 1, '2023-11-15', 300, 400, 100, '2023-11-15 12:24:13', '2023-11-15 12:24:13'),
(30, 1, '2023-11-15', 300, 400, 100, '2023-11-15 12:26:59', '2023-11-15 12:26:59'),
(31, 1, '2023-11-15', 300, 400, 100, '2023-11-15 12:27:12', '2023-11-15 12:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` bigint(20) UNSIGNED NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `total_penjualan` int(11) NOT NULL,
  `jml_bayar_penjualan` int(11) NOT NULL,
  `jml_kembalian_penjualan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `tanggal_penjualan`, `total_penjualan`, `jml_bayar_penjualan`, `jml_kembalian_penjualan`, `created_at`, `updated_at`) VALUES
(1, '2023-11-14', 300, 400, 100, '2023-11-14 07:34:29', '2023-11-14 07:34:29'),
(2, '2023-11-14', 300, 400, 100, '2023-11-14 11:36:01', '2023-11-14 11:36:01'),
(3, '2023-11-15', 300, 400, 100, '2023-11-15 12:28:33', '2023-11-15 12:28:33'),
(4, '2023-11-15', 300, 400, 100, '2023-11-15 12:37:34', '2023-11-15 12:37:34'),
(5, '2023-11-15', 300, 400, 100, '2023-11-15 12:38:10', '2023-11-15 12:38:10'),
(6, '2023-11-15', 300, 400, 100, '2023-11-15 12:39:26', '2023-11-15 12:39:26'),
(7, '2023-11-15', 300, 400, 100, '2023-11-15 12:47:17', '2023-11-15 12:47:17'),
(8, '2023-11-15', 300, 400, 100, '2023-11-15 12:47:28', '2023-11-15 12:47:28'),
(9, '2023-11-15', 300, 400, 100, '2023-11-15 12:54:25', '2023-11-15 12:54:25'),
(10, '2023-11-15', 300, 400, 100, '2023-11-15 12:54:57', '2023-11-15 12:54:57'),
(11, '2023-11-15', 300, 400, 100, '2023-11-15 12:55:51', '2023-11-15 12:55:51'),
(12, '2023-11-15', 300, 400, 100, '2023-11-15 12:58:22', '2023-11-15 12:58:22'),
(13, '2023-11-15', 300, 400, 100, '2023-11-15 13:01:09', '2023-11-15 13:01:09'),
(14, '2023-11-15', 300, 400, 100, '2023-11-15 13:03:27', '2023-11-15 13:03:27'),
(15, '2023-11-15', 300, 400, 100, '2023-11-15 13:03:34', '2023-11-15 13:03:34');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` bigint(20) UNSIGNED NOT NULL,
  `nama_satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket_satuan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`, `ket_satuan`, `created_at`, `updated_at`) VALUES
(1, 'satuan 1', 'keterangan 1', '2023-11-14 06:30:54', '2023-11-14 06:30:54');

-- --------------------------------------------------------

--
-- Table structure for table `suplier`
--

CREATE TABLE `suplier` (
  `id_suplier` bigint(20) UNSIGNED NOT NULL,
  `kode_suplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_suplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_tlp` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket_suplier` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suplier`
--

INSERT INTO `suplier` (`id_suplier`, `kode_suplier`, `nama_suplier`, `no_tlp`, `alamat`, `ket_suplier`, `created_at`, `updated_at`) VALUES
(1, 'KD-SP-1', 'nama suplier 2', 'no tlp suplier 2', 'alamat suplier 2', NULL, '2023-11-14 06:37:39', '2023-11-14 06:40:31'),
(4, 'KD-SP-2', 'nama suplier', 'no tlp suplier', 'alamat suplier', NULL, '2023-11-14 06:38:24', '2023-11-14 06:38:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `barang_kode_barang_unique` (`kode_barang`),
  ADD KEY `barang_kategori_id_foreign` (`kategori_id`),
  ADD KEY `barang_satuan_id_foreign` (`satuan_id`);

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`id_detail_pembelian`),
  ADD KEY `detail_pembelian_barang_id_foreign` (`barang_id`),
  ADD KEY `detail_pembelian_pembelian_id_foreign` (`pembelian_id`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail_penjualan`),
  ADD KEY `detail_penjualan_barang_id_foreign` (`barang_id`),
  ADD KEY `detail_penjualan_penjualan_id_foreign` (`penjualan_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD UNIQUE KEY `laporan_kode_laporan_unique` (`kode_laporan`),
  ADD KEY `laporan_pembelian_id_foreign` (`pembelian_id`),
  ADD KEY `laporan_penjualan_id_foreign` (`penjualan_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `pembelian_suplier_id_foreign` (`suplier_id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `suplier`
--
ALTER TABLE `suplier`
  ADD PRIMARY KEY (`id_suplier`),
  ADD UNIQUE KEY `suplier_kode_suplier_unique` (`kode_suplier`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  MODIFY `id_detail_pembelian` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail_penjualan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suplier`
--
ALTER TABLE `suplier`
  MODIFY `id_suplier` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id_kategori`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id_satuan`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `detail_pembelian_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pembelian_pembelian_id_foreign` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelian` (`id_pembelian`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_penjualan_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualan` (`id_penjualan`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_pembelian_id_foreign` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelian` (`id_pembelian`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualan` (`id_penjualan`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_suplier_id_foreign` FOREIGN KEY (`suplier_id`) REFERENCES `suplier` (`id_suplier`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
