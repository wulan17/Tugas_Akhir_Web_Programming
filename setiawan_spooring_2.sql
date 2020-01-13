-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 04, 2020 at 02:17 PM
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
-- Database: `setiawan_spooring_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `idBarang` int(11) NOT NULL,
  `Barang_nama` varchar(45) DEFAULT NULL,
  `Barang_harga` int(45) DEFAULT NULL,
  `tersedia` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`idBarang`, `Barang_nama`, `Barang_harga`, `tersedia`) VALUES
(1, 'Knalpot Mobil Stainless Steel', 850000, 1),
(2, 'Bola Lampu Mobil', 50000, 1),
(3, 'Knalpot Mobil', 450000, 1),
(4, 'Audio & Video Mobil', 1250000, 1),
(5, 'Baterai Mobil', 250000, 1),
(6, 'Spidometer Mobil', 375000, 1),
(7, 'GPS Mobil', 550000, 1),
(8, 'Handle GPS Mobil', 50000, 1),
(9, 'Pipa Knalpot Mobil', 450000, 1),
(10, 'Wiper', 45000, 1),
(11, 'Casing Lampu Mobil', 850000, 1),
(12, 'Kaca Mobil', 170000, 1),
(13, 'Klakson Mobil', 125000, 1),
(14, 'Dongkrak Mobil', 800000, 1),
(15, 'Bagasi Mobil', 1250000, 1),
(16, 'Ball Joint', 75000, 1),
(17, 'test', 500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `idcustomer` int(11) NOT NULL,
  `customer_deskripsi` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`idcustomer`, `customer_deskripsi`) VALUES
(1, 'UMUM'),
(2, 'KELOPISIAN RI'),
(3, 'MITRA PERUSAHAAN'),
(4, 'MILIK SENDIRI');

-- --------------------------------------------------------

--
-- Table structure for table `faktur`
--

CREATE TABLE `faktur` (
  `idFaktur` int(11) NOT NULL,
  `Faktur_tgl` text DEFAULT NULL,
  `Faktur_total_transaksi` bigint(20) DEFAULT NULL,
  `no_polisi` varchar(10) DEFAULT NULL,
  `idpembayaran` int(11) DEFAULT NULL,
  `idcustomer` int(11) DEFAULT NULL,
  `operator` int(11) DEFAULT NULL,
  `Faktur_jumlah_dibayar` bigint(20) DEFAULT NULL,
  `Faktur_uang_kembalian` int(11) DEFAULT NULL,
  `diperiksa_oleh` int(11) DEFAULT NULL,
  `sales` int(11) DEFAULT NULL,
  `pembelian_total_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faktur`
--

INSERT INTO `faktur` (`idFaktur`, `Faktur_tgl`, `Faktur_total_transaksi`, `no_polisi`, `idpembayaran`, `idcustomer`, `operator`, `Faktur_jumlah_dibayar`, `Faktur_uang_kembalian`, `diperiksa_oleh`, `sales`, `pembelian_total_item`) VALUES
(0, '10/14/2019 09:35:00 AM', 600000, 'AB 4235 KL', 3, 3, 5, 600000, 0, 6, 7, 2),
(1, '05/05/2019 10:00:00 AM', 645000, 'AA 4689 CM', 1, 1, 5, 700000, 55000, 6, 7, 4),
(2, '06/18/2019 2:40:00 PM', 900000, 'AA 1111 FC', 2, 1, 1, 900000, 0, 6, 7, 2),
(3, '09/16/2019 10:45:00 AM', 1250000, 'F 3555 TYT', 1, 4, 5, 1300000, 50000, 6, 7, 1),
(4, '09/02/2019 11:35:00 AM', 950000, 'AA 1238 BG', 3, 2, 1, 950000, 0, 6, 7, 4),
(5, '01/03/2020 10:32:27 AM', 3400000, 'AA 1111 FC', 1, 1, 10, 5000000, 1600000, 10, 7, 1),
(6, '01/03/2020 10:54:31 AM', 7300000, 'AA 1238 BG', 3, 2, 10, 7300000, 0, 10, 8, 2),
(7, '01/03/2020 11:08:16 AM', 1000000, 'AA 4689 CM', 3, 4, 2, 1000000, 0, 11, 8, 2),
(8, '01/03/2020 11:19:07 AM', 2600000, 'AB 4235 KL', 4, 1, 1, 2600000, 0, 11, 8, 1),
(9, '01/03/2020 11:18:40 AM', 2400000, 'AA 3245 RM', 2, 1, 1, 2400000, 0, 11, 8, 1),
(10, '01/03/2020 11:17:21 AM', 432000, 'AB 4561 CV', 2, 1, 1, 432000, 0, 11, 8, 1),
(11, '01/04/2020 11:21:56 AM', 4320000, 'AA 1111 FC', 2, 1, 11, 4320000, 0, 11, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `faktur_temp`
--

CREATE TABLE `faktur_temp` (
  `idFaktur_temp` int(11) NOT NULL,
  `Faktur_tgl` text DEFAULT NULL,
  `Faktur_total_transaksi` bigint(20) DEFAULT NULL,
  `no_polisi` varchar(10) DEFAULT NULL,
  `idpembayaran` int(11) DEFAULT NULL,
  `idcustomer` int(11) DEFAULT NULL,
  `operator` int(11) DEFAULT NULL,
  `Faktur_jumlah_dibayar` bigint(20) DEFAULT NULL,
  `Faktur_uang_kembalian` int(11) DEFAULT NULL,
  `sales` int(11) DEFAULT NULL,
  `pembelian_total_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faktur_temp`
--

INSERT INTO `faktur_temp` (`idFaktur_temp`, `Faktur_tgl`, `Faktur_total_transaksi`, `no_polisi`, `idpembayaran`, `idcustomer`, `operator`, `Faktur_jumlah_dibayar`, `Faktur_uang_kembalian`, `sales`, `pembelian_total_item`) VALUES
(10, '01/04/2020 11:59:09 AM', 0, 'AA 1111 FC', 0, 2, 11, 0, 0, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `idjabatan` int(11) NOT NULL,
  `jabatan_deskripsi` varchar(45) DEFAULT NULL,
  `akses` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`idjabatan`, `jabatan_deskripsi`, `akses`) VALUES
(1, 'Kasir', 2),
(2, 'Customer Service', 3),
(3, 'Supervisor', 7),
(4, 'Sales', 4),
(5, 'Marketing', 5),
(6, 'Owner', 8),
(7, 'Admin Sistem', 6),
(8, 'Teknisi', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menjabat_sebagai`
--

CREATE TABLE `menjabat_sebagai` (
  `idmenjabat_sebagai` int(11) NOT NULL,
  `idjabatan` int(11) DEFAULT NULL,
  `idpegawai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menjabat_sebagai`
--

INSERT INTO `menjabat_sebagai` (`idmenjabat_sebagai`, `idjabatan`, `idpegawai`) VALUES
(1, 1, 5),
(2, 1, 1),
(3, 1, 4),
(4, 2, 2),
(5, 3, 3),
(6, 3, 6),
(7, 4, 7),
(8, 4, 8),
(9, 7, 9),
(10, 5, 3),
(11, 6, 10),
(12, 6, 11);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `idpegawai` int(11) NOT NULL,
  `pegawai_nama` varchar(45) DEFAULT NULL,
  `pegawaialamat` varchar(45) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`idpegawai`, `pegawai_nama`, `pegawaialamat`, `username`, `password`, `email`) VALUES
(1, 'Iis Dahlia', 'srumbung', 'kasir1', '$2y$10$J84HZ8ZyjxLvTVXclV4ijeIO7MLhHwuYFYefUwm0T4Xo26OYCldMG', ''),
(2, 'Sumartono', 'kramat utara', 'customer_services', '$2y$10$TPhDEP8.lEeU9P6246IUyeO4lN8FdE6h5WAqmvKbUlfVvQRqutcrm', ''),
(3, 'Pasalindo S', 'mertoyudan', 'supervisor1', '$2y$10$/Lic6mspYwOd89MDUNTVkuefUFJWON1RExCfGWJ.fcJkLYYSJilhu', ''),
(4, 'Hatta Siahaan', 'dukun', 'kasir3', '$2y$10$YBBV8ZjNtooBu.cdswwoP.NwLV0AFTLiuiY8CMtlJgOumx0cySzsO', ''),
(5, 'Martino H', 'srumbung', 'kasir2', '$2y$10$sT.bxMkZcOYiZ4qWKHeuiuEszMoE.KrlEdCPwsA53pjTTk.bUnVjO', ''),
(6, 'Betty Lavea', 'srumbung', 'supervisor2', '$2y$10$F9raWpcyIrkAlwynGuYDou3LoKac7nHsJaOQ7CD/FRUiFY.q6.mB6', ''),
(7, 'Bekti Subekti', 'tidar karajan', 'sales1', '$2y$10$sAYDJSfFw/T7r6Smyi7k1egYZAcOwxin/GD1s02z38IvdrCwcnb3i', ''),
(8, 'Marlini Yumanis', 'tidar warung', 'sales2', '$2y$10$h3J2E8pblv9mgJQAXSTbNuESgMr7.I3w81o1U9/hzNMB6jQSxsi..', ''),
(9, 'Bowo Adi Saputro', 'mantenan', 'admin', '$2y$10$nNsr70oSq9iF6f2MosDPmO2zeZfgNAH.OAIrAzINKjWykmCVqGGQi', ''),
(10, 'Galih Gusti Priatna', 'Temanggung', 'owner1', '$2y$10$dQ9VUy2iNLL3pxgRIsoPhutk5wmvX8sSG/I01zcy/dnUnTGqclZgq', 'galihgustip@gmail.com'),
(11, 'Dinda Silvia Fara Diba', 'Magelang', 'owner2', '$2y$10$AVE36mwjjuNVygJ3bWW5pu6PjOxudRHLFK0czpSBzFTzvQwyVsTxy', '');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `No_polisi` varchar(12) NOT NULL,
  `Pelanggan_nama` varchar(45) DEFAULT NULL,
  `Pelanggan_alamat` varchar(45) DEFAULT NULL,
  `Pelanggan_km` int(11) DEFAULT NULL,
  `Pelanggan_jenis_mobil` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`No_polisi`, `Pelanggan_nama`, `Pelanggan_alamat`, `Pelanggan_km`, `Pelanggan_jenis_mobil`) VALUES
('AA 1111 FC', 'Gusti Ngabei', 'Perum Cendana Kiara', 140800, 'Honda Jazz'),
('AA 1238 BG', 'Maryati Setyana', 'Cluster Gardenia', 234000, 'Toyota Yaris'),
('AA 2345 HD', 'Bobby Harsendi', 'Armada Estate', 140000, 'Innova Venturer'),
('AA 3245 RM', 'Mulyawan', 'Kaponan Pakis', 130000, 'Honda Brio'),
('AA 4689 CM', 'Heru S', 'Dusun Glagah', 167000, 'Honda Brio'),
('AB 4235 KL', 'Malik Arsetya', 'Perum Korpri', 150000, 'Innova'),
('AB 4561 CV', 'Singodimejo', 'Cluster Edelweis', 140890, 'Daihatsu Zebra'),
('F 3555 TYT', 'Cerry Andana', 'Cluster Mertoyudan Asri', 179000, 'Honda Freed'),
('K 5778 FG', 'Harsono Mulyo', 'Perum Griya Mulia', 310000, 'Honda Brio');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `idpembayaran` int(11) NOT NULL,
  `pembayaran_deskripsi` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`idpembayaran`, `pembayaran_deskripsi`) VALUES
(1, 'CASH'),
(2, 'CREDIT CARD'),
(3, 'SPK PERUSAHAAN'),
(4, 'DEPOSIT');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `idpembelian` int(11) NOT NULL,
  `idfaktur` int(11) DEFAULT NULL,
  `idbarang` int(11) DEFAULT NULL,
  `pembelian_jumlah_barang` int(11) DEFAULT NULL,
  `pembelian_sub_jumlah` bigint(20) DEFAULT NULL,
  `pembelian_diskon` int(11) DEFAULT NULL,
  `pembelian_jumlah_kotor` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`idpembelian`, `idfaktur`, `idbarang`, `pembelian_jumlah_barang`, `pembelian_sub_jumlah`, `pembelian_diskon`, `pembelian_jumlah_kotor`) VALUES
(1, 1, 1, 1, 450000, 0, 450000),
(2, 1, 16, 2, 150000, 0, 150000),
(3, 1, 10, 1, 45000, 0, 45000),
(4, 2, 3, 1, 450000, 0, 450000),
(5, 2, 9, 1, 450000, 0, 450000),
(6, 3, 15, 1, 1250000, 0, 1250000),
(7, 4, 2, 2, 100000, 0, 100000),
(8, 4, 11, 1, 850000, 0, 850000),
(9, 0, 7, 1, 550000, 0, 550000),
(10, 0, 8, 1, 50000, 0, 50000),
(11, 5, 1, 5, 4250000, 850000, 3400000),
(12, 6, 1, 10, 8500000, 1700000, 6800000),
(13, 6, 2, 10, 500000, 0, 500000),
(14, 7, 2, 10, 500000, 0, 500000),
(15, 7, 8, 10, 500000, 0, 500000),
(16, 8, 5, 13, 3250000, 650000, 2600000),
(17, 9, 5, 12, 3000000, 600000, 2400000),
(18, 10, 10, 12, 540000, 108000, 432000),
(19, 11, 3, 12, 5400000, 1080000, 4320000);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_temp`
--

CREATE TABLE `pembelian_temp` (
  `idpembelian` int(11) NOT NULL,
  `idFaktur_temp` int(11) DEFAULT NULL,
  `idbarang` int(11) DEFAULT NULL,
  `pembelian_jumlah_barang` int(11) DEFAULT NULL,
  `pembelian_sub_jumlah` bigint(20) DEFAULT NULL,
  `pembelian_diskon` int(11) DEFAULT NULL,
  `pembelian_jumlah_kotor` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`idBarang`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`idcustomer`);

--
-- Indexes for table `faktur`
--
ALTER TABLE `faktur`
  ADD PRIMARY KEY (`idFaktur`),
  ADD KEY `fk_pelanggan_idx` (`no_polisi`),
  ADD KEY `fk_pembayaran_idx` (`idpembayaran`),
  ADD KEY `fk_customer_idx` (`idcustomer`),
  ADD KEY `fk_menjabat_idx` (`operator`),
  ADD KEY `fk_diperiksa_idx` (`diperiksa_oleh`),
  ADD KEY `fk_sales_idx` (`sales`);

--
-- Indexes for table `faktur_temp`
--
ALTER TABLE `faktur_temp`
  ADD PRIMARY KEY (`idFaktur_temp`),
  ADD KEY `fk_pelanggan_idx` (`no_polisi`),
  ADD KEY `fk_pembayaran_idx` (`idpembayaran`),
  ADD KEY `fk_customer_idx` (`idcustomer`),
  ADD KEY `fk_menjabat_idx` (`operator`),
  ADD KEY `fk_sales_idx` (`sales`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`idjabatan`);

--
-- Indexes for table `menjabat_sebagai`
--
ALTER TABLE `menjabat_sebagai`
  ADD PRIMARY KEY (`idmenjabat_sebagai`),
  ADD KEY `fk_jabatan_idx` (`idjabatan`),
  ADD KEY `fk_pegawai_idx` (`idpegawai`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`idpegawai`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`No_polisi`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`idpembayaran`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`idpembelian`),
  ADD KEY `fk_faktur_idx` (`idfaktur`),
  ADD KEY `fk_barang_idx` (`idbarang`);

--
-- Indexes for table `pembelian_temp`
--
ALTER TABLE `pembelian_temp`
  ADD PRIMARY KEY (`idpembelian`),
  ADD KEY `fk_barang_idx` (`idbarang`),
  ADD KEY `idfaktur_temp` (`idFaktur_temp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faktur_temp`
--
ALTER TABLE `faktur_temp`
  MODIFY `idFaktur_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `idpembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pembelian_temp`
--
ALTER TABLE `pembelian_temp`
  MODIFY `idpembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `faktur`
--
ALTER TABLE `faktur`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`idcustomer`) REFERENCES `customer` (`idcustomer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_diperiksa` FOREIGN KEY (`diperiksa_oleh`) REFERENCES `menjabat_sebagai` (`idmenjabat_sebagai`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_operator` FOREIGN KEY (`operator`) REFERENCES `menjabat_sebagai` (`idmenjabat_sebagai`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pelanggan` FOREIGN KEY (`no_polisi`) REFERENCES `pelanggan` (`No_polisi`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pembayaran` FOREIGN KEY (`idpembayaran`) REFERENCES `pembayaran` (`idpembayaran`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sales` FOREIGN KEY (`sales`) REFERENCES `menjabat_sebagai` (`idmenjabat_sebagai`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `menjabat_sebagai`
--
ALTER TABLE `menjabat_sebagai`
  ADD CONSTRAINT `fk_jabatan` FOREIGN KEY (`idjabatan`) REFERENCES `jabatan` (`idjabatan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pegawai` FOREIGN KEY (`idpegawai`) REFERENCES `pegawai` (`idpegawai`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `fk_barang` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idBarang`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_faktur` FOREIGN KEY (`idfaktur`) REFERENCES `faktur` (`idFaktur`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
