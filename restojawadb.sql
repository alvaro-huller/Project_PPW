-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2025 at 03:46 PM
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
-- Database: `restojawadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `datalauk`
--

CREATE TABLE `datalauk` (
  `IDLauk` int(10) NOT NULL,
  `NamaLauk` varchar(30) NOT NULL,
  `HargaLauk` int(9) NOT NULL,
  `GambarLauk` varchar(30) NOT NULL,
  `Kategori` varchar(30) NOT NULL,
  `Stok` int(3) NOT NULL,
  `Deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `datalauk`
--

INSERT INTO `datalauk` (`IDLauk`, `NamaLauk`, `HargaLauk`, `GambarLauk`, `Kategori`, `Stok`, `Deskripsi`) VALUES
(0, '-', 0, '-', '-', 0, ''),
(1, 'Gudeg', 8000, 'Gudeg.jpg', 'Lauk', 10, ''),
(2, 'Rawon', 8000, 'Rawon.jpeg', 'Lauk', 10, ''),
(3, 'Sayur Lodeh', 8000, 'SayurLodeh.jpg', 'Lauk', 10, ''),
(4, 'Sayur Asem', 8000, 'SayurAsem.jpg', 'Lauk', 10, ''),
(5, 'Ayam Bakar Kalasan', 8000, 'AyamBakarKalasan.png', 'Lauk', 10, ''),
(6, 'Telur Balado', 8000, 'TelurBalado.png', 'Lauk', 10, '');

-- --------------------------------------------------------

--
-- Table structure for table `datameja`
--

CREATE TABLE `datameja` (
  `IDMeja` int(10) NOT NULL,
  `NoMeja` int(3) NOT NULL,
  `Jam` varchar(30) NOT NULL,
  `Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `datameja`
--

INSERT INTO `datameja` (`IDMeja`, `NoMeja`, `Jam`, `Status`) VALUES
(1, 1, '10.00-12.00', 'Penuh'),
(2, 1, '12.00-14.00', 'Kosong'),
(3, 1, '14.00-16.00', 'Kosong'),
(4, 1, '16.00-18.00', 'Kosong'),
(5, 1, '18.00-20.00', 'Kosong'),
(6, 2, '10.00-12.00', 'Kosong'),
(7, 2, '12.00-14.00', 'Kosong'),
(8, 2, '14.00-16.00', 'Kosong'),
(9, 2, '16.00-18.00', 'Penuh'),
(10, 2, '18.00-20.00', 'Kosong'),
(11, 3, '10.00-12.00', 'Kosong'),
(12, 3, '12.00-14.00', 'Kosong'),
(13, 3, '14.00-16.00', 'Kosong'),
(14, 3, '16.00-18.00', 'Kosong'),
(15, 3, '18.00-20.00', 'Kosong');

-- --------------------------------------------------------

--
-- Table structure for table `dataminuman`
--

CREATE TABLE `dataminuman` (
  `IDMinuman` int(10) NOT NULL,
  `NamaMinuman` varchar(30) NOT NULL,
  `HargaMinuman` int(10) NOT NULL,
  `GambarMinuman` varchar(30) NOT NULL,
  `Kategori` varchar(30) NOT NULL,
  `Stok` int(10) NOT NULL,
  `Deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dataminuman`
--

INSERT INTO `dataminuman` (`IDMinuman`, `NamaMinuman`, `HargaMinuman`, `GambarMinuman`, `Kategori`, `Stok`, `Deskripsi`) VALUES
(1, 'Wedang Jahe', 5000, 'WedangJahe.png', 'Minuman', 10, ''),
(2, 'Es Dawet', 5000, 'EsDawet.png', 'Minuman', 10, ''),
(3, 'Susu Jahe', 5000, 'SusuJahe.png', 'Minuman', 10, ''),
(4, 'Es Cincau', 5000, 'EsCincau.png', 'Minuman', 10, ''),
(5, 'Wedang Uwuh', 5000, 'WedangUwuh.png', 'Minuman', 10, ''),
(6, 'Es Teler', 5000, 'EsTeler.png', 'Minuman', 10, '');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `IDPegawai` int(10) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`IDPegawai`, `Username`, `Role`) VALUES
(1, 'MJiddan', 'Admin'),
(2, 'SAlva', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `IDPesanan` int(10) NOT NULL,
  `IDReservasi` varchar(30) NOT NULL,
  `IDMeja` int(10) NOT NULL,
  `IDLauk1` int(10) NOT NULL,
  `IDLauk2` int(10) NOT NULL,
  `IDLauk3` int(10) NOT NULL,
  `IDMinuman` int(10) NOT NULL,
  `Total` int(11) NOT NULL,
  `Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`IDPesanan`, `IDReservasi`, `IDMeja`, `IDLauk1`, `IDLauk2`, `IDLauk3`, `IDMinuman`, `Total`, `Status`) VALUES
(49, '69207a3ca8d58', 1, 1, 2, 3, 1, 29000, 'Proses'),
(50, '69207a3ca8d58', 1, 4, 5, 6, 2, 29000, 'Proses');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `IDReservasi` varchar(30) NOT NULL,
  `IDMeja` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`IDReservasi`, `IDMeja`) VALUES
('692067b153a44', 1),
('6920684b1b9b1', 1),
('69207a3ca8d58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `IDUser` int(10) NOT NULL,
  `IDReservasi` varchar(30) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`IDUser`, `IDReservasi`, `Username`, `Password`, `Role`) VALUES
(8, '69207a3ca8d58', 'raja jawa', 'projo02', 'Pelanggan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `datalauk`
--
ALTER TABLE `datalauk`
  ADD PRIMARY KEY (`IDLauk`);

--
-- Indexes for table `datameja`
--
ALTER TABLE `datameja`
  ADD PRIMARY KEY (`IDMeja`);

--
-- Indexes for table `dataminuman`
--
ALTER TABLE `dataminuman`
  ADD PRIMARY KEY (`IDMinuman`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`IDPegawai`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`IDPesanan`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`IDReservasi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`IDUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `datalauk`
--
ALTER TABLE `datalauk`
  MODIFY `IDLauk` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `datameja`
--
ALTER TABLE `datameja`
  MODIFY `IDMeja` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `dataminuman`
--
ALTER TABLE `dataminuman`
  MODIFY `IDMinuman` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `IDPegawai` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `IDPesanan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `IDUser` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
