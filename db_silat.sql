-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2024 at 04:23 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_silat`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` int(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `departemen` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `password`, `nama`, `prodi`, `departemen`, `tgl_lahir`) VALUES
(123, '123', 'Muhammad Najib Pradana', 'S1 - Teknik Komputer', 'Teknik Komputer', '2004-08-06'),
(1234, '1234', 'Ucup Surucup', 'S1 - Informatika', 'Teknik', '2019-04-03');

-- --------------------------------------------------------

--
-- Table structure for table `surat_izin_kp`
--

CREATE TABLE `surat_izin_kp` (
  `id` int(11) NOT NULL,
  `nim` int(16) NOT NULL,
  `nama_mhs` varchar(255) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `departemen` varchar(255) NOT NULL,
  `semester` int(11) NOT NULL,
  `ipk` varchar(5) NOT NULL,
  `sksk` varchar(255) DEFAULT NULL,
  `domisili` varchar(255) NOT NULL,
  `no_wa` varchar(13) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `keperluan` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `instansi` varchar(255) NOT NULL,
  `kota` varchar(255) NOT NULL,
  `alamat_instansi` varchar(255) NOT NULL,
  `surat_permohonan` varchar(255) NOT NULL,
  `krs` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `surat_jadi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `surat_ket_mhs`
--

CREATE TABLE `surat_ket_mhs` (
  `id` int(11) NOT NULL,
  `nim` int(16) NOT NULL,
  `nama_mhs` varchar(255) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `departemen` varchar(255) NOT NULL,
  `semester` int(11) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `domisili` varchar(255) NOT NULL,
  `no_wa` varchar(13) NOT NULL,
  `tahun_akademik` varchar(255) NOT NULL,
  `tujuan_surat` varchar(255) NOT NULL,
  `tujuan_surat_eng` varchar(255) DEFAULT NULL,
  `tgl_pengajuan` date NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `surat_jadi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `surat_tugas`
--

CREATE TABLE `surat_tugas` (
  `id` int(11) NOT NULL,
  `nim` int(16) NOT NULL,
  `nama_mhs` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `semester` int(11) NOT NULL,
  `domisili` varchar(255) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `pimpinan` varchar(255) NOT NULL,
  `lembaga` varchar(255) NOT NULL,
  `kota` varchar(255) NOT NULL,
  `alamat_lembaga` varchar(255) NOT NULL,
  `surat_balasan` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `surat_jadi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `surat_izin_kp`
--
ALTER TABLE `surat_izin_kp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`);

--
-- Indexes for table `surat_ket_mhs`
--
ALTER TABLE `surat_ket_mhs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`);

--
-- Indexes for table `surat_tugas`
--
ALTER TABLE `surat_tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `surat_izin_kp`
--
ALTER TABLE `surat_izin_kp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `surat_ket_mhs`
--
ALTER TABLE `surat_ket_mhs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `surat_tugas`
--
ALTER TABLE `surat_tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `surat_izin_kp`
--
ALTER TABLE `surat_izin_kp`
  ADD CONSTRAINT `surat_izin_kp_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE;

--
-- Constraints for table `surat_ket_mhs`
--
ALTER TABLE `surat_ket_mhs`
  ADD CONSTRAINT `surat_ket_mhs_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE;

--
-- Constraints for table `surat_tugas`
--
ALTER TABLE `surat_tugas`
  ADD CONSTRAINT `surat_tugas_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
