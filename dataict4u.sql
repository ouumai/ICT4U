-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2026 at 12:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.5.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dataict4u`
--

-- --------------------------------------------------------

--
-- Table structure for table `aict4u103dperincianmodul`
--

CREATE TABLE `aict4u103dperincianmodul` (
  `id` int(10) UNSIGNED NOT NULL,
  `idservis` int(10) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aict4u103dperincianmodul`
--

INSERT INTO `aict4u103dperincianmodul` (`id`, `idservis`, `description`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `uploaded_by`) VALUES
(1, 15, '', '2026-04-24 19:16:50', '2026-04-24 19:17:43', NULL, NULL, NULL),
(2, 7, 'hanya untuk staff warga UKM', '2026-04-25 00:18:40', '2026-04-25 00:28:35', NULL, NULL, NULL),
(3, 1, '', '2026-04-25 01:35:46', '2026-04-25 01:43:14', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aict4u103dservis`
--

CREATE TABLE `aict4u103dservis` (
  `idservis` int(11) NOT NULL,
  `namaservis` varchar(145) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `infourl` varchar(500) DEFAULT NULL,
  `mohonurl` varchar(500) DEFAULT NULL,
  `kodkump` varchar(45) DEFAULT NULL,
  `kodservis` varchar(5) DEFAULT NULL,
  `infoperincian` mediumtext DEFAULT NULL,
  `imejkad` varchar(45) DEFAULT NULL,
  `imejheader` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aict4u103dservis`
--

INSERT INTO `aict4u103dservis` (`idservis`, `namaservis`, `status`, `infourl`, `mohonurl`, `kodkump`, `kodservis`, `infoperincian`, `imejkad`, `imejheader`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `uploaded_by`) VALUES
(1, 'Permohonan IP', 1, 'https://appsmu.ukm.my/mohonip', 'https://appsmu.ukm.my/mohonip', '1', '', NULL, 'icon-ip.png', NULL, NULL, '2026-04-25 01:43:14', NULL, NULL, NULL),
(2, 'Permohonan Elaun Komputer ', 1, 'https://sistem.ukm.my/khidmat', 'https://sistem.ukm.my/khidmat', '1', '', NULL, 'icon-elaunpc.png', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Permohonan Pemasangan Talian Internet', 1, 'http://appsmu.ukm.my/etalian/', 'http://appsmu.ukm.my/etalian/', '1', NULL, 'Perincian Talian Internet', 'icon-talian.png', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Permohonan Perkhidmatan Telesidang / Streaming / Teknikal Acara', 1, 'https://docs.google.com/forms/d/e/1FAIpQLSeag5nAwSVTg_kKLn0yJzP6GfIwAwnQlDzn7eM3lbJbU-VQAQ/viewform', NULL, '1', NULL, NULL, 'icon-acara.png', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Permohonan Perisian', 1, 'https://docs.google.com/forms/d/e/1FAIpQLSdV1A1dsD-su-3SJu7amKYu5bo7iepjV4PfpweF-3vjR8cYuQ/viewform', NULL, '3', NULL, NULL, 'icon-perisian.png', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Permohonan Pengenalan ID SMU (iSIP)', 1, 'https://appsmu.ukm.my/isip/', 'https://appsmu.ukm.my/isip/', '1', NULL, NULL, 'icon-mohonid.png', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Penamatan Pengenalan ID SMU', 1, 'https://spdukm.ukm.my/spk/spkppp/_layouts/WordViewer.aspx?id=/spk/spkppp/ptm/UKM-SPKPPP-PT(P)03-PTM-AK02-GP06-BO01 Borang Penamatan Pengenalan SMU.docx&Source=https%3A%2F%2Fspdukm%2Eukm%2Emy%2Fspk%2Fspkppp%2Fptm%2FForms%2FMain%2Easpx%3FGroupString%3D%253B%2523AK02%2520Arahan%2520Kerja%2520Perkhidmatan%2520ICT%253B%252303%252E%2520Borang%253B%2523%26IsGroupRender%3DTRUE&DefaultItemOpen=1', NULL, '1', NULL, NULL, 'icon-tamatid.png', NULL, NULL, '2026-04-25 00:28:35', NULL, NULL, NULL),
(8, 'Permohonan Pinjaman Peralatan ICT', 1, NULL, 'https://ict4u.ukm.my/pinjaman/utama', '1', NULL, 'Perincian Pinjaman Peralatan ICT', 'icon-pinjamalat.png', NULL, NULL, '2026-03-25 07:00:16', NULL, NULL, NULL),
(9, 'Permohonan Multimedia', 1, 'https://forms.gle/q8XRLtEW1ALJQUH7A', NULL, '1', NULL, NULL, 'icon-mmedia.png', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Permohonan Laluan Khas', 1, NULL, 'https://ict4u.ukm.my/vpn', '1', NULL, 'Perincian Permohonan Laluan Khas', 'icon-vpn.png', 'header-vpn.jpg', NULL, '2026-03-25 07:00:52', NULL, NULL, NULL),
(11, 'Permohonan PEKA (Penyelenggaraan Aplikasi)', 1, 'https://smk.ukm.my/peka/', 'http://smk.ukm.my/peka', '1', NULL, NULL, 'icon-peka.png', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Permohonan E-mel Kakitangan', 1, 'https://appsmu.ukm.my/spek/', 'https://appsmu.ukm.my/spek', '1', NULL, NULL, 'icon-emelkktgn.png', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Permohonan E-mel Pelajar', 1, 'https://appsmu.ukm.my/speep', 'https://appsmu.ukm.my/speep', '2', NULL, NULL, 'icon-emelpelajar.png', NULL, NULL, '2026-03-27 15:34:54', NULL, NULL, NULL),
(14, 'Permohonan Pengwujudan Pangkalan Data', 1, NULL, 'https://spdukm.ukm.my/spk/isms/_layouts/WordViewer.aspx?id=/spk/isms/ptm/UKM-ISMS-PTM-PK03-GP05-BO01%20Borang%20Permohonan%20Pengwujudan%20Pengemaskinian%20Pangkalan%20Data.docx&Source=https%3A%2F%2Fspdukm%2Eukm%2Emy%2Fspk%2Fisms%2Fptm%2FForms%2FUtama%2Easpx%3FGroupString%3D%253B%252307%252E%2520UKM%252DISMS%252DPTM%252DPK03%2520Pengurusan%2520Ketersediaan%2520Capaian%2520Aplikasi%2520SMU%253B%252304%252DBorang%253B%2523%26IsGroupRender%3DTRUE&DefaultItemOpen=1&DefaultItemOpen=1', '1', NULL, NULL, 'icon-db.png', NULL, NULL, '2026-03-27 08:32:22', NULL, NULL, NULL),
(15, 'Permohonan Data', 1, 'https://glory-ruby-12a.notion.site/Carta-Alir-Permohonan-Data-28758b6ad56680799b0ac7443968dc70', NULL, '1', NULL, NULL, 'icon-data.png', NULL, NULL, '2026-04-24 19:17:43', NULL, NULL, NULL),
(16, 'Permohonan Tapak Web', 1, 'http://www.ukm.my/daftarweb', NULL, '3', NULL, NULL, 'icon-tapakweb.png', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Permohonan Penyediaan Server Dalaman', 1, NULL, 'https://spdukm.ukm.my/spk/isms/_layouts/WordViewer.aspx?id=/spk/isms/ptm/UKM-ISMS-PTM-PK03-GP01-BO01%20Borang%20Permohonan%20Penyediaan%20Server.docx&Source=https%3A%2F%2Fspdukm%2Eukm%2Emy%2Fspk%2Fisms%2Fptm%2FForms%2FUtama%2Easpx%3FGroupString%3D%253B%252307%252E%2520UKM%252DISMS%252DPTM%252DPK03%2520Pengurusan%2520Ketersediaan%2520Capaian%2520Aplikasi%2520SMU%253B%252304%252DBorang%253B%2523%26IsGroupRender%3DTRUE&DefaultItemOpen=1', '1', NULL, NULL, 'icon-server.png', NULL, NULL, '2026-03-27 08:32:44', NULL, NULL, NULL),
(18, 'Permohonan DNS', 1, 'https://spdukm.ukm.my/spk/isms/_layouts/WordViewer.aspx?id=/spk/isms/ptm/UKM-ISMS-PTM-PK03-GP01-BO03%20Borang%20Permohonan%20DNS.docx&Source=https%3A%2F%2Fspdukm%2Eukm%2Emy%2Fspk%2Fisms%2Fptm%2FForms%2FUtama%2Easpx%3FGroupString%3D%253B%252307%252E%2520UKM%252DISMS%252DPTM%252DPK03%2520Pengurusan%2520Ketersediaan%2520Capaian%2520Aplikasi%2520SMU%253B%252304%252DBorang%253B%2523%26IsGroupRender%3DTRUE&DefaultItemOpen=1&DefaultItemOpen=1', NULL, '1', NULL, NULL, 'icon-dns.png', NULL, NULL, '2026-04-17 16:07:54', NULL, NULL, NULL),
(19, 'Permohonan UAT', 1, NULL, NULL, '1', NULL, NULL, 'icon-uat.png', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Permohonan Kelulusan Teknikal Perolehan ICT UKM', 1, 'https://docs.google.com/forms/d/e/1FAIpQLSf49bsniiwZKM7PbWNJ4OUMQwy7YWrYqeKlRpCmZ0HtB6bJXw/viewform', NULL, '1', NULL, NULL, 'icon-teknikal.png', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'Permohonan VPN UKM', 1, NULL, 'https://ict4u.ukm.my/vpn', '1', NULL, 'Perincian VPN', 'icon-vpn.png', NULL, NULL, '2026-03-25 07:01:06', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aict4u106mdoc`
--

CREATE TABLE `aict4u106mdoc` (
  `idservis` int(11) NOT NULL,
  `folder_name` varchar(255) DEFAULT NULL,
  `iddoc` int(11) NOT NULL,
  `nama` varchar(145) DEFAULT NULL,
  `namafail` varchar(145) DEFAULT NULL,
  `file_original_name` varchar(255) DEFAULT NULL,
  `mime` varchar(50) DEFAULT NULL,
  `descdoc` text DEFAULT NULL,
  `tkhkemas` datetime DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `uploaded_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aict4u106m_approval_dokumen`
--

CREATE TABLE `aict4u106m_approval_dokumen` (
  `id` int(11) NOT NULL,
  `iddoc` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by` varchar(100) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aict4u108mdes`
--

CREATE TABLE `aict4u108mdes` (
  `iddesc` int(11) NOT NULL,
  `108idservis` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(150) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `entity_type` varchar(100) NOT NULL,
  `entity_id` varchar(50) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `changes` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`id`, `user_id`, `group`, `created_at`) VALUES
(1, 1, 'user', '2026-04-23 16:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `auth_identities`
--

CREATE TABLE `auth_identities` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `secret` varchar(255) NOT NULL,
  `secret2` varchar(255) DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text DEFAULT NULL,
  `force_reset` tinyint(1) NOT NULL DEFAULT 0,
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_identities`
--

INSERT INTO `auth_identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'email_password', NULL, 'n.umairahsabri@gmail.com', '$2y$12$ROrPQDicsaA.USYnKSCv5uW75z6XR5YY0T/XqKvbtTZbkGM5DWJqi', NULL, NULL, 0, '2026-04-27 12:30:37', '2026-04-23 16:58:26', '2026-04-27 12:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `user_agent`, `id_type`, `identifier`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'email_password', 'n.umairahsabri@gmail.com', 1, '2026-04-23 16:59:07', 1),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'magic-link', 'ea13d6e118a7a2944fee', 1, '2026-04-23 17:06:38', 1),
(3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'email_password', 'n.umairahsabri@gmail.com', 1, '2026-04-23 17:10:12', 1),
(4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'email_password', 'n.umairahsabri@gmail.com', 1, '2026-04-23 17:10:58', 1),
(5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'email_password', 'n.umairahsabri@gmail.com', 1, '2026-04-24 16:20:26', 1),
(6, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'email_password', 'n.umairahsabri@gmail.com', 1, '2026-04-25 18:41:01', 1),
(7, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'email_password', 'n.umairahsabri@gmail.com', 1, '2026-04-27 07:50:28', 1),
(8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'email_password', 'n.umairahsabri@gmail.com', 1, '2026-04-27 12:30:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions_users`
--

CREATE TABLE `auth_permissions_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `permission` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_remember_tokens`
--

CREATE TABLE `auth_remember_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_remember_tokens`
--

INSERT INTO `auth_remember_tokens` (`id`, `selector`, `hashedValidator`, `user_id`, `expires`, `created_at`, `updated_at`) VALUES
(5, 'd5590d8893444ef050ceae61', '29316ccd8630165aa6c39252852b41a6774b106d554a3c9c4b2f1c1a06fdb534', 1, '2026-05-27 15:57:02', '2026-04-27 12:30:37', '2026-04-27 15:57:02');

-- --------------------------------------------------------

--
-- Table structure for table `auth_token_logins`
--

CREATE TABLE `auth_token_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `idservis` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_pinned` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `idservis`, `question`, `answer`, `created_at`, `updated_at`, `is_pinned`, `sort_order`) VALUES
(1, 1, 'Siapa yang layak memohon IP?', 'Kakitangan UKM yang memerlukan IP untuk sistem, server atau peranti khas sahaja', '2026-01-06 14:27:39', '2026-04-15 02:32:58', 0, 0),
(2, 1, 'Berapa lama proses kelulusan?', 'Kebiasaannya 1–3 hari bekerja selepas permohonan lengkap.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(3, 1, 'Adakah IP ini kekal?', 'Tidak, IP akan disemak semula secara berkala mengikut keperluan.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(4, 2, 'Siapa layak memohon elaun komputer?', 'Kakitangan tetap UKM mengikut syarat yang ditetapkan.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(5, 2, 'Dokumen apa diperlukan?', 'Borang permohonan dan dokumen sokongan pembelian.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(6, 2, 'Berapa lama proses tuntutan?', 'Bergantung kepada kelulusan kewangan, biasanya 14–30 hari.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(7, 3, 'Lokasi mana boleh dipasang?', 'Bangunan dan ruang rasmi UKM sahaja.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(8, 3, 'Siapa menanggung kos pemasangan?', 'Bergantung kepada kelulusan dan bajet jabatan.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(9, 3, 'Adakah penyelenggaraan disediakan?', 'Ya, penyelenggaraan disediakan oleh pihak ICT.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(10, 4, 'Perlu mohon berapa awal?', 'Sekurang-kurangnya 3 hari sebelum acara.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(11, 4, 'Peralatan apa disediakan?', 'Kamera, audio, streaming dan sokongan teknikal.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(12, 4, 'Adakah sokongan semasa acara?', 'Ya, bergantung kepada skop permohonan.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(13, 5, 'Perisian apa boleh dimohon?', 'Perisian rasmi, berlesen dan diluluskan UKM.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(14, 5, 'Adakah perisian percuma disokong?', 'Ya, tertakluk kepada kesesuaian penggunaan.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(15, 5, 'Siapa yang meluluskan?', 'Unit ICT dan pihak pengurusan berkaitan.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(16, 6, 'Siapa perlu ID SMU?', 'Kakitangan baharu atau pengguna sistem UKM.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(17, 6, 'Berapa lama ID diaktifkan?', 'Biasanya dalam 1 hari bekerja.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(18, 6, 'Boleh guna untuk semua sistem?', 'Ya, untuk sistem dalaman UKM.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(19, 7, 'Bila perlu buat penamatan?', 'Apabila kakitangan tamat perkhidmatan.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(20, 7, 'Siapa bertanggungjawab mohon?', 'Ketua jabatan / pentadbir.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(21, 7, 'Apa risiko jika tidak ditamatkan?', 'Risiko keselamatan dan akses tanpa kebenaran.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(22, 8, 'Peralatan apa boleh dipinjam?', 'Laptop, projektor, kamera dan peralatan ICT terhad.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(23, 8, 'Tempoh pinjaman maksimum?', 'Bergantung kepada kelulusan, biasanya 1–7 hari.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(24, 8, 'Jika rosak atau hilang?', 'Peminjam bertanggungjawab sepenuhnya.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(25, 9, 'Apakah skop multimedia?', 'Video, grafik, fotografi dan suntingan.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(26, 9, 'Perlu brief awal?', 'Ya, untuk elak salah faham hasil akhir.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(27, 9, 'Boleh minta pindaan?', 'Ya, bergantung kepada masa dan skop.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(28, 10, 'Apa itu laluan khas?', 'Akses rangkaian khas untuk sistem tertentu.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(29, 10, 'Siapa layak memohon?', 'Kakitangan dengan keperluan rasmi.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(30, 10, 'Adakah akses kekal?', 'Tidak, tertakluk kepada semakan.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(31, 11, 'Apa itu PEKA?', 'Penyelenggaraan dan sokongan aplikasi UKM.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(32, 11, 'Siapa boleh mohon?', 'Pemilik atau pentadbir sistem.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(33, 11, 'Adakah melibatkan kos?', 'Bergantung kepada skop kerja.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(34, 12, 'Bila akaun dibuat?', 'Selepas kelulusan HR dan ICT.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(35, 12, 'Kapasiti emel berapa?', 'Mengikut polisi semasa UKM.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(36, 12, 'Boleh akses luar kampus?', 'Ya.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(37, 13, 'Siapa layak?', 'Semua pelajar berdaftar.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(38, 13, 'Bila akaun aktif?', 'Selepas pendaftaran pelajar disahkan.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(39, 13, 'Digunakan untuk apa?', 'Komunikasi rasmi akademik.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(40, 14, 'Untuk sistem apa?', 'Sistem rasmi dan penyelidikan UKM.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(41, 14, 'Siapa urus penyelenggaraan?', 'Unit ICT.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(42, 14, 'Ada backup?', 'Ya, backup berkala.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(43, 15, 'Data jenis apa boleh dipohon?', 'Data rasmi dan diluluskan UKM.', '2026-01-06 14:27:39', '2026-04-15 02:33:23', 0, 0),
(44, 15, 'Perlu kelulusan khas?', 'Ya, bergantung sensitiviti data.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(45, 15, 'Boleh kongsi dengan pihak luar?', 'Tidak tanpa kebenaran bertulis.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(46, 16, 'Siapa layak?', 'Fakulti, jabatan dan unit rasmi.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(47, 16, 'Template disediakan?', 'Ya, mengikut standard UKM.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(48, 16, 'Siapa kemas kini kandungan?', 'Pentadbir laman yang dilantik.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(49, 17, 'Untuk apa server digunakan?', 'Sistem dalaman dan aplikasi rasmi.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(50, 17, 'Siapa urus keselamatan?', 'Unit ICT.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(51, 17, 'Ada pemantauan?', 'Ya, 24/7 monitoring.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(52, 18, 'Untuk domain apa?', 'Domain berkaitan UKM.', '2026-01-06 14:27:39', '2026-04-24 08:18:14', 0, 0),
(53, 18, 'Perlu justifikasi?', 'Ya.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(54, 18, 'Berapa lama proses?', '1–3 hari bekerja.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(55, 19, 'Apa itu UAT?', 'Ujian penerimaan pengguna.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(56, 19, 'Bila UAT dibuat?', 'Sebelum sistem go-live.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(57, 19, 'Siapa terlibat?', 'Pemilik sistem dan pengguna akhir.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(58, 20, 'Wajib untuk semua perolehan?', 'Ya, bagi perolehan ICT.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(59, 20, 'Tujuan kelulusan?', 'Pastikan spesifikasi teknikal sesuai.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(60, 20, 'Siapa meluluskan?', 'Unit teknikal ICT UKM.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(61, 21, 'VPN digunakan untuk apa?', 'Akses sistem dalaman dari luar kampus.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(62, 21, 'Siapa layak?', 'Kakitangan dan pelajar terpilih.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0),
(63, 21, 'Perlu pasang perisian?', 'Ya, perisian VPN rasmi.', '2026-01-06 14:27:39', '2026-01-06 14:27:39', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-01-30-025158', 'App\\Database\\Migrations\\CreateServisTable', 'default', 'App', 1774403136, 1),
(2, '2026-02-04-063423', 'App\\Database\\Migrations\\CreateAict4u103dperincianmodul', 'default', 'App', 1774403136, 1),
(3, '2026-02-04-063533', 'App\\Database\\Migrations\\CreateAict4u106mdoc', 'default', 'App', 1774403136, 1),
(4, '2026-02-04-063744', 'App\\Database\\Migrations\\CreateAict4u106mApprovalDokumen', 'default', 'App', 1774403136, 1),
(5, '2026-02-04-063850', 'App\\Database\\Migrations\\CreateAict4u108mdes', 'default', 'App', 1774403136, 1),
(6, '2026-02-04-063936', 'App\\Database\\Migrations\\CreateFaqTable', 'default', 'App', 1774403136, 1),
(7, '2026-02-04-065113', 'App\\Database\\Migrations\\CreatePasswordResetsTable', 'default', 'App', 1774403136, 1),
(8, '2020-12-28-223112', 'CodeIgniter\\Shield\\Database\\Migrations\\CreateAuthTables', 'default', 'CodeIgniter\\Shield', 1774403268, 2),
(9, '2021-07-04-041948', 'CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable', 'default', 'CodeIgniter\\Settings', 1774403268, 2),
(10, '2021-11-14-143905', 'CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn', 'default', 'CodeIgniter\\Settings', 1774403268, 2),
(11, '2026-03-27-000001', 'App\\Database\\Migrations\\CreateAuditLogsTable', 'default', 'App', 1774596070, 3),
(12, '2026-03-27-000002', 'App\\Database\\Migrations\\RenameAuditLogUserNameColumn', 'default', 'App', 1774596292, 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(9) NOT NULL,
  `class` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(31) NOT NULL DEFAULT 'string',
  `context` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `profile_pic` varchar(255) DEFAULT '',
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `status`, `status_message`, `active`, `profile_pic`, `last_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Nur Umairah Binti Mohd Sabri', 'active', NULL, 1, '1777112111_5df2d158d1c42374775c.jpg', '2026-04-27 15:57:02', '2026-04-23 16:58:26', '2026-04-25 18:40:53', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aict4u103dperincianmodul`
--
ALTER TABLE `aict4u103dperincianmodul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_idservis` (`idservis`);

--
-- Indexes for table `aict4u103dservis`
--
ALTER TABLE `aict4u103dservis`
  ADD PRIMARY KEY (`idservis`);

--
-- Indexes for table `aict4u106mdoc`
--
ALTER TABLE `aict4u106mdoc`
  ADD PRIMARY KEY (`iddoc`);

--
-- Indexes for table `aict4u106m_approval_dokumen`
--
ALTER TABLE `aict4u106m_approval_dokumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iddoc` (`iddoc`);

--
-- Indexes for table `aict4u108mdes`
--
ALTER TABLE `aict4u108mdes`
  ADD PRIMARY KEY (`iddesc`),
  ADD KEY `108idservis` (`108idservis`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_secret` (`type`,`secret`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_permissions_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `auth_remember_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idservis` (`idservis`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`token`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aict4u103dperincianmodul`
--
ALTER TABLE `aict4u103dperincianmodul`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `aict4u103dservis`
--
ALTER TABLE `aict4u103dservis`
  MODIFY `idservis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `aict4u106mdoc`
--
ALTER TABLE `aict4u106mdoc`
  MODIFY `iddoc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aict4u106m_approval_dokumen`
--
ALTER TABLE `aict4u106m_approval_dokumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aict4u108mdes`
--
ALTER TABLE `aict4u108mdes`
  MODIFY `iddesc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `auth_identities`
--
ALTER TABLE `auth_identities`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aict4u106m_approval_dokumen`
--
ALTER TABLE `aict4u106m_approval_dokumen`
  ADD CONSTRAINT `aict4u106m_approval_dokumen_iddoc_foreign` FOREIGN KEY (`iddoc`) REFERENCES `aict4u106mdoc` (`iddoc`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `aict4u108mdes`
--
ALTER TABLE `aict4u108mdes`
  ADD CONSTRAINT `aict4u108mdes_108idservis_foreign` FOREIGN KEY (`108idservis`) REFERENCES `aict4u103dservis` (`idservis`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD CONSTRAINT `auth_identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD CONSTRAINT `auth_permissions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD CONSTRAINT `auth_remember_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `faq`
--
ALTER TABLE `faq`
  ADD CONSTRAINT `faq_ibfk_1` FOREIGN KEY (`idservis`) REFERENCES `aict4u103dservis` (`idservis`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
