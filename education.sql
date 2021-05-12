-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2021 at 04:30 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `education`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen`
--

CREATE TABLE `absen` (
  `id` int(10) NOT NULL,
  `siswa_id` int(10) NOT NULL,
  `materi_id` int(10) DEFAULT 0,
  `pelajaran_id` int(10) DEFAULT 0,
  `file_tugas` varchar(100) NOT NULL,
  `keterangan` varchar(30) NOT NULL,
  `hari` varchar(10) NOT NULL,
  `tanggal_hadir` date DEFAULT NULL,
  `pukul` varchar(5) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absen`
--

INSERT INTO `absen` (`id`, `siswa_id`, `materi_id`, `pelajaran_id`, `file_tugas`, `keterangan`, `hari`, `tanggal_hadir`, `pukul`, `status`) VALUES
(1, 14, 8, 1, 'Lorem_ipsum_dolor_sit_amet4.docx', '', 'Monday', '2021-03-22', '16:16', 1),
(2, 9, 0, 0, '', '', '', NULL, '', 0),
(3, 15, 6, 3, 'Lorem_ipsum_dolor_sit_amet1.docx', '', 'Sunday', '2021-03-21', '22:15', 1),
(4, 16, 0, 0, '', '', '', NULL, '', 0),
(5, 17, 0, 0, '', '', '', NULL, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `avatar` varchar(150) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`, `user_id`, `name`, `avatar`, `updated_at`) VALUES
(1, 1, 'Ekky Ridyanto', 'boy.png', NULL),
(2, 7, 'Nia Kurniasih', 'default.png', '2021-03-19 18:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `name` varchar(60) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `number_phone` varchar(15) NOT NULL,
  `gender` enum('P','L') NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `user_id`, `name`, `avatar`, `number_phone`, `gender`, `updated_at`) VALUES
(2, 5, 'Ardiansyah', 'Guru4.png', '081280135405', 'L', '2021-03-20 16:19:20'),
(3, 6, 'Widodo Saputra', 'Guru1.png', '081294633864', 'L', '2021-03-20 16:26:10'),
(4, 8, 'Ade Afitoni', 'default.png', '089630351820', 'L', '2021-03-20 16:28:50'),
(5, 13, 'Ri\'fat Dinillah', 'default.png', '087788606795', 'L', '2021-03-20 16:31:58');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(10) NOT NULL,
  `kode_kelas` varchar(5) NOT NULL,
  `nama_kelas` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `kode_kelas`, `nama_kelas`) VALUES
(1, 'IV A', 'IV'),
(2, 'V A', 'V');

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id` int(10) NOT NULL,
  `pelajaran_id` int(10) NOT NULL,
  `bab` int(5) NOT NULL,
  `title` varchar(60) NOT NULL,
  `slug` varchar(60) NOT NULL,
  `document` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `is_publish` tinyint(1) NOT NULL,
  `precondition` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id`, `pelajaran_id`, `bab`, `title`, `slug`, `document`, `description`, `is_publish`, `precondition`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Pug template engine', 'pug-template-engine', 'screencapture-hackerrank-test-7sptj22i6hg-questions-darskct0ror-2020-11-11-19_28_25.pdf', '<p>Lorem ipsum, atau ringkasnya lipsum, adalah teks standar yang ditempatkan untuk mendemostrasikan elemen grafis atau presentasi visual seperti font, tipografi, dan tata letak.</p>', 1, 'Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.', '2020-12-12 12:06:00', NULL),
(5, 5, 1, 'Tata Cara Sholat', 'tata-cara-sholat', 'panduan_sholat.pdf', '<p>Membahas tentang sholat</p>', 1, 'harus menghafal rukun islam', '0000-00-00 00:00:00', '2021-03-19 19:03:33'),
(7, 3, 1, 'Olahraga', 'olahraga', 'Lorem_ipsum_dolor_sit_amet.docx', '<p>Gerakan senam</p>', 1, '-', '2021-03-17 01:00:00', NULL),
(8, 1, 1, 'Matematika', 'matematika', 'Lorem_ipsum_dolor_sit_amet1.docx', '<p>aljabar</p>', 1, '-', '2021-03-22 09:14:00', NULL),
(9, 1, 2, 'Annabele', 'annabele', 'Lorem_ipsum_dolor_sit_amet2.docx', '<p>tg</p>', 1, '-', '2021-03-11 09:23:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mengajar`
--

CREATE TABLE `mengajar` (
  `id` int(10) NOT NULL,
  `guru_id` int(10) NOT NULL,
  `pelajaran_id` int(10) NOT NULL,
  `kelas_id` int(10) NOT NULL,
  `hari` varchar(10) NOT NULL,
  `waktu_mulai` varchar(10) NOT NULL,
  `waktu_selesai` varchar(10) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mengajar`
--

INSERT INTO `mengajar` (`id`, `guru_id`, `pelajaran_id`, `kelas_id`, `hari`, `waktu_mulai`, `waktu_selesai`, `status`) VALUES
(1, 5, 1, 1, 'Kamis', '14:00', '16:30', 1),
(2, 6, 3, 1, 'Rabu', '10:30', '11:30', 1),
(3, 8, 2, 1, 'Selasa', '14:00', '16:30', 1),
(7, 13, 5, 1, 'Jumat', '13.00', '14.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pelajaran`
--

CREATE TABLE `pelajaran` (
  `id` int(10) NOT NULL,
  `nama_pelajaran` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelajaran`
--

INSERT INTO `pelajaran` (`id`, `nama_pelajaran`, `slug`, `status`) VALUES
(1, 'Tematik', 'tematik', 1),
(2, 'Komputer', 'komputer', 1),
(3, 'PJOK', 'pjok', 1),
(4, 'Bahasa Inggris', 'bahasa-inggris', 0),
(5, 'Agama', 'agama', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'Tata Usaha'),
(2, 'Guru'),
(3, 'Murid'),
(4, 'Kepala Sekolah');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `kelas_id` int(10) NOT NULL,
  `tahun_ajaran_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number_phone` varchar(15) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `gender` enum('P','L') NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `user_id`, `kelas_id`, `tahun_ajaran_id`, `name`, `number_phone`, `avatar`, `address`, `gender`, `updated_at`) VALUES
(7, 14, 1, 2, 'Fabian', '082194140174', 'Murid2.png', 'Kelurahan Tugu Utara.', 'L', '2021-03-20 05:10:19'),
(8, 15, 1, 2, 'Alika', '087833383780', 'Murid3.jpg', 'Kelurahan papanggo', 'P', NULL),
(10, 17, 1, 2, 'Luthfi', '089502666502', 'boy.png', 'Kelurahan Tugu Utara', 'L', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id` int(10) NOT NULL,
  `year` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `year`) VALUES
(1, '2019/2020'),
(2, '2020/2021');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  `username` varchar(70) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `is_active`, `created_at`, `is_login`) VALUES
(1, 1, 'tatausaha', '$2y$10$iDsgZiMnhA08oCZOJiLHheT4jF2DPRmqp2jLRfRMomr2MACP.DUZm', 1, '2020-11-28 06:12:19', '2021-03-22 10:18:36'),
(5, 2, 'G001', '$2y$10$oJDdj0pJ4sWrs1nTle.n7.L8Dv7xo2.POfcHRuF5Qr0KEtmyYrM7u', 1, '2020-12-12 09:39:48', '2021-03-22 10:23:06'),
(6, 2, 'G002', '$2y$10$lM1YYdz.lE3VjPluL9xQ7.Dii3PrWdVr8ZnMYlXOJZAo1qmiv23Ou', 1, '2020-12-12 09:40:46', '2021-03-21 16:20:56'),
(7, 4, 'kepalasekolah', '$2y$10$PtGh4Qx5GrzFAfJ.oogsiuWH5qcDwKoX3BCxJgJk5DC.pNRDp45ay', 1, '2021-01-30 17:16:51', '2021-03-22 06:38:00'),
(8, 2, 'G003', '$2y$10$XdYp5ybN80I9ELz7O8E0ruZ8cAVdJZozrzvwtO7qm6IVq1aJAd5lS', 1, '2021-03-18 03:39:04', '2021-03-18 15:59:48'),
(13, 2, 'G004', '$2y$10$.f.jc.latFdGZKhz51.40.C1BBK31o6If8tzOwPmkK/75kAAXAg6S', 1, '2021-03-19 08:18:44', '2021-03-20 07:27:18'),
(14, 3, 'S001', '$2y$10$N5V2xYNO/olJLiKCu6/bFepkuRUbo59kQtQPU0hIPcKi1SVUFlk0a', 1, '2021-03-19 17:54:51', '2021-03-22 10:25:12'),
(15, 3, 'S002', '$2y$10$1NxC66Z6spT/1mgFPUay3OUwhSXQL1ZEWp/jHuHLRC0fcBRkXVoUC', 1, '2021-03-20 16:02:59', '2021-03-21 16:03:42'),
(17, 3, 'S003', '$2y$10$Ux6UPeLLzBAZYY5iqgbpjeu9Rlomwzx3GZS.4B./ikwaAdchxAx1m', 1, '2021-03-21 14:53:11', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(3, 1, 3),
(4, 1, 4),
(6, 1, 7),
(8, 3, 6),
(9, 3, 5),
(10, 2, 6),
(12, 4, 6),
(13, 1, 2),
(14, 1, 6),
(15, 1, 8),
(16, 6, 6),
(17, 6, 8),
(18, 3, 8),
(19, 2, 9),
(20, 1, 9),
(21, 1, 10),
(22, 2, 11),
(25, 7, 6),
(31, 1, 12),
(32, 7, 12),
(33, 4, 12);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(50) NOT NULL,
  `numrow` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`, `numrow`) VALUES
(1, 'Menu', 3),
(2, 'Tata Usaha', 1),
(3, 'Data User', 2),
(4, 'Data Master', 6),
(5, 'Siswa', 4),
(6, 'Profile', 5),
(11, 'Guru', 7),
(12, 'Laporan', 8);

-- --------------------------------------------------------

--
-- Table structure for table `user_submenu`
--

CREATE TABLE `user_submenu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_submenu`
--

INSERT INTO `user_submenu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 2, 'Dashboard', 'administrador/admin', 'fas fa-fw fa-tachometer-alt', 1),
(3, 6, 'Edit Profile', 'administrador/user/edit', 'fas fa-fw fa-user-edit', 1),
(4, 6, 'My Profile', 'administrador/user', 'fas fa-fw fa-user', 1),
(5, 1, 'Menu', 'administrador/menu', 'fas fa-fw fa-folder', 1),
(6, 1, 'Submenu', 'administrador/menu/submenu', 'fas fa-fw fa-folder-open', 1),
(7, 4, 'Pelajaran', 'administrador/pelajaran', 'fas fw fa-archive', 1),
(11, 6, 'Ubah Password', 'administrador/user/change-password', 'fas fw fa-key', 1),
(12, 2, 'Role', 'administrador/admin/role', 'fas fw fa-user-tie', 1),
(13, 3, 'Murid', 'administrador/siswa', 'fas fa-fw fa-id-card', 1),
(24, 3, 'Guru', 'administrador/guru', 'fas fa-fw fa-user-tie', 1),
(51, 4, 'Kelas', 'administrador/kelas', 'fas fa-fw fa-city', 1),
(52, 4, 'Tahun Belajar', 'administrador/tahun-studi', 'fas fw fa-bookmark', 1),
(53, 11, 'Materi', 'administrador/materi', 'fas fa-fw fa-store', 1),
(54, 5, 'Tugas', 'administrador/tugas', 'fas fa-fw fa-file-upload', 1),
(55, 11, 'Rekap Absen', 'administrador/guru/absen', 'fas fa-fw fa-tablet-alt', 1),
(56, 12, 'Data Guru', 'administrador/guru/laporan', 'fas fa-fw fa-file-alt', 1),
(57, 12, 'Data Siswa', 'administrador/siswa/laporan', 'fas fa-fw fa-file-word', 1),
(58, 11, 'Jadwal', 'administrador/guru/jadwal', 'fas fa-fw fa-clock', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mengajar`
--
ALTER TABLE `mengajar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelajaran`
--
ALTER TABLE `pelajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_submenu`
--
ALTER TABLE `user_submenu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absen`
--
ALTER TABLE `absen`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mengajar`
--
ALTER TABLE `mengajar`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pelajaran`
--
ALTER TABLE `pelajaran`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_submenu`
--
ALTER TABLE `user_submenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
