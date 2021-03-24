-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Mar 2021 pada 07.08
-- Versi server: 10.4.13-MariaDB
-- Versi PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `splashpos_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_category`
--

CREATE TABLE `t_category` (
  `category_id` char(3) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_category`
--

INSERT INTO `t_category` (`category_id`, `category_name`, `created_at`) VALUES
('BRT', 'Makanan Pokok', '2021-03-15 18:27:26'),
('MKN', 'Snack\'s', '2021-03-15 18:27:34'),
('MNM', 'Minuman', '2021-03-15 18:27:38'),
('SNS', 'Alat Tulis Kantor', '2021-03-15 18:27:42'),
('TST', 'Test', '2021-03-19 13:33:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_customer`
--

CREATE TABLE `t_customer` (
  `customer_id` varchar(255) NOT NULL,
  `division_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_phone` char(13) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_customer`
--

INSERT INTO `t_customer` (`customer_id`, `division_id`, `customer_name`, `customer_address`, `customer_phone`, `is_active`, `created_at`) VALUES
('CST21032400001', 1, 'Wibi Wijaksono', '-', '0', 1, '2021-03-24 13:41:52'),
('CST21032400006', 1, 'Budi Saptaji', '-', '0', 1, '2021-03-24 13:42:49'),
('CST_20210316_00002', 1, 'Ridho Chairul Anam', 'Sindangbarang Bendungan RT.002', '0862781681123', 1, NULL),
('CST_20210319_00003', 2, 'Haris Nurul Fasyih', 'Tanggerang', '081725376517', 1, NULL),
('CST_20210322_00004', 1, 'Ahmad Satibi', '-', '0', 1, '2021-03-22 11:22:35'),
('CST_20210322_00005', 1, 'Ahmad Mulyana', '-', '0', 1, '2021-03-22 11:48:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_division`
--

CREATE TABLE `t_division` (
  `division_id` int(11) NOT NULL,
  `division_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_division`
--

INSERT INTO `t_division` (`division_id`, `division_name`, `created_at`) VALUES
(1, 'Umum', '2021-03-16 18:15:47'),
(2, 'Spesial', '2021-03-16 18:15:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_inventory`
--

CREATE TABLE `t_inventory` (
  `inventory_id` varchar(255) NOT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `inventory_stock` int(11) NOT NULL,
  `inventory_units` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_inventory`
--

INSERT INTO `t_inventory` (`inventory_id`, `product_id`, `inventory_stock`, `inventory_units`, `created_at`) VALUES
('INV_20210316_00001', 'PRD_20210315_00001', 0, 'Bungkus', '2021-03-16 11:09:55'),
('INV_20210318_00002', 'PRD_20210317_00007', 14, 'Unit', '2021-03-18 22:30:34'),
('INV_20210318_00003', 'PRD_20210317_00004', 0, 'Unit', '2021-03-18 22:31:00'),
('INV_20210318_00004', 'PRD_20210317_00005', 0, 'Unit', '2021-03-18 22:31:12'),
('INV_20210318_00005', 'PRD_20210317_00006', 4, 'Unit', '2021-03-18 22:32:55'),
('INV_20210319_00006', 'PRD_20210319_00010', 27, 'Unit', '2021-03-19 14:15:29'),
('INV_20210322_00007', 'PRD_20210317_00008', 23, 'Unit', '2021-03-22 14:51:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_payment`
--

CREATE TABLE `t_payment` (
  `payment_id` char(3) NOT NULL,
  `payment_name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_payment`
--

INSERT INTO `t_payment` (`payment_id`, `payment_name`, `is_active`) VALUES
('CSH', 'Cash', NULL),
('DBT', 'Debit Card', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_price`
--

CREATE TABLE `t_price` (
  `price_id` int(11) NOT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `division_id` int(11) NOT NULL,
  `price_name` varchar(255) DEFAULT NULL,
  `price_value` int(11) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_expired` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_price`
--

INSERT INTO `t_price` (`price_id`, `product_id`, `division_id`, `price_name`, `price_value`, `date_start`, `date_expired`, `created_at`) VALUES
(1, 'PRD_20210315_00001', 1, 'Harga Umum', 20000, '2021-03-16', '2021-03-31', '2021-03-16 16:49:03'),
(2, 'PRD_20210317_00006', 1, 'Harga Umum', 10000, '2021-03-18', '2021-03-31', '2021-03-16 16:49:32'),
(3, 'PRD_20210317_00004', 1, 'Harga Umum', 15000, '2021-03-18', '2021-03-31', '2021-03-18 17:49:52'),
(4, 'PRD_20210317_00007', 1, 'Harga Umum', 2000, '2021-03-18', '2021-03-31', '2021-03-18 17:50:09'),
(5, 'PRD_20210317_00005', 1, 'Harga Umum', 15000, '2021-03-18', '2021-03-31', '2021-03-18 22:31:52'),
(6, 'PRD_20210317_00006', 2, 'Harga Spesial', 7000, '2021-03-19', '2021-03-31', '2021-03-19 11:20:15'),
(7, 'PRD_20210319_00010', 1, 'Harga Umum', 10000, '2021-03-19', '2021-03-31', '2021-03-19 14:12:16'),
(8, 'PRD_20210317_00008', 1, 'Harga Umum', 17000, '2021-03-22', '2021-03-31', '2021-03-22 14:46:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_product`
--

CREATE TABLE `t_product` (
  `product_id` varchar(255) NOT NULL,
  `category_id` char(3) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_product`
--

INSERT INTO `t_product` (`product_id`, `category_id`, `product_name`, `product_image`, `is_active`, `created_at`) VALUES
('PRD_20210315_00001', 'BRT', 'Makanan Berat', 'makanan.jpg', 1, '2021-03-15 21:03:32'),
('PRD_20210315_00002', 'MNM', 'Minuman Enak', 'makanan1.jpg', 0, '2021-03-15 21:22:17'),
('PRD_20210317_00003', 'BRT', 'Nasi Goreng', '20190604-nasi-goreng-fried-rice-vicky-wasik-7-750x563.jpg', 1, '2021-03-17 12:07:31'),
('PRD_20210317_00004', 'BRT', 'Nasi Goreng Spesial ', 'vegetarian-nasi-goreng-taste-152060-2.jpg', 1, '2021-03-17 12:08:40'),
('PRD_20210317_00005', 'BRT', 'Mie Goreng', 'vegetarian-nasi-goreng-taste-152060-21.jpg', 1, '2021-03-17 12:08:57'),
('PRD_20210317_00006', 'MNM', 'Boba Berkhasiat Tinggi', 'content_minuman-_kekinian__1_.jpg', 1, '2021-03-17 12:09:50'),
('PRD_20210317_00007', 'SNS', 'Pensil', 'Pensil_Ujian___Pensil_2B_Staedtler_Mars_Lumograph_100_isi_12.jpg', 1, '2021-03-17 12:10:04'),
('PRD_20210317_00008', 'MKN', 'Chitato', 'efkpgnOl_400x400.jpg', 1, '2021-03-17 12:10:18'),
('PRD_20210317_00009', 'MKN', 'Chitato Putih', 'batch-upload_16f2bfcc-8acb-4efa-95b6-ef0dd73bad96.jpg', 1, '2021-03-17 12:10:59'),
('PRD_20210319_00010', 'BRT', 'Aci Haris', '4-46990_colours-splash-png-color-splash-transparent-background-png.png', 0, '2021-03-19 13:57:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_role`
--

CREATE TABLE `t_role` (
  `role_id` char(3) NOT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_role`
--

INSERT INTO `t_role` (`role_id`, `role_name`, `is_active`) VALUES
('ADM', 'Administrator', 1),
('SYS', 'System Administrator', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_store`
--

CREATE TABLE `t_store` (
  `store_id` char(3) NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_store`
--

INSERT INTO `t_store` (`store_id`, `store_name`, `created_at`) VALUES
('MGA', 'Makmur Gemilang Abadi', '2021-03-19 20:06:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_transaction`
--

CREATE TABLE `t_transaction` (
  `transaction_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `payment_id` char(3) DEFAULT NULL,
  `transaction_pay` int(11) DEFAULT NULL,
  `transaction_value` double DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_transaction`
--

INSERT INTO `t_transaction` (`transaction_id`, `customer_id`, `payment_id`, `transaction_pay`, `transaction_value`, `created_at`) VALUES
('INVMGA21032200001', 'CST_20210316_00002', 'CSH', 10000, 6000, '2021-03-22 10:59:27'),
('INVMGA21032200002', 'CST_20210322_00004', 'CSH', 50000, 40000, '2021-03-22 11:22:35'),
('INVMGA21032200003', 'CST_20210316_00002', 'CSH', 4000, 2000, '2021-03-22 11:33:05'),
('INVMGA21032200004', 'CST_20210322_00005', 'CSH', 3000, 2000, '2021-03-22 11:48:12'),
('INVMGA21032200005', 'CST_20210322_00005', 'CSH', 50000, 40000, '2021-03-22 15:01:23'),
('INVMGA21032200006', 'CST_20210322_00004', 'CSH', 35000, 35000, '2021-03-22 15:01:35'),
('INVMGA21032200007', 'CST_20210316_00002', 'CSH', 35000, 32000, '2021-03-22 15:49:06'),
('INVMGA21032200008', 'CST_20210319_00003', 'CSH', 10000, 7000, '2021-03-22 17:23:05'),
('INVMGA21032300001', 'CST_20210322_00005', 'CSH', 20000, 10000, '2021-03-23 11:26:08'),
('INVMGA21032300002', 'CST_20210322_00005', 'CSH', 98000, 98000, '2021-03-23 20:40:53'),
('INVMGA21032400001', 'CST_20210322_00005', 'CSH', 25000, 20000, '2021-03-24 12:16:02'),
('INVMGA21032400002', 'CST_20210322_00004', 'CSH', 25000, 22000, '2021-03-24 12:16:17'),
('INVMGA21032400003', 'CST_20210322_00005', 'CSH', 7000, 6000, '2021-03-24 13:54:25'),
('INVMGA21032400004', 'CST_20210316_00002', 'CSH', 50000, 35000, '2021-03-24 13:59:15'),
('INVMGA21032400005', 'CST_20210322_00004', 'CSH', 20000, 20000, '2021-03-24 14:01:44'),
('INVMGA21032400006', 'CST_20210322_00005', 'CSH', 20000, 20000, '2021-03-24 14:02:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_transaction_detail`
--

CREATE TABLE `t_transaction_detail` (
  `transaction_id` varchar(255) NOT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `transaction_qty` int(11) DEFAULT NULL,
  `transaction_price` int(11) DEFAULT NULL,
  `transaction_note` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_transaction_detail`
--

INSERT INTO `t_transaction_detail` (`transaction_id`, `product_id`, `transaction_qty`, `transaction_price`, `transaction_note`, `created_at`) VALUES
('INVMGA21032200001', 'PRD_20210317_00007', 3, 6000, '', '2021-03-22 10:59:47'),
('INVMGA21032200002', 'PRD_20210315_00001', 2, 40000, '', '2021-03-22 11:23:03'),
('INVMGA21032200003', 'PRD_20210317_00007', 1, 2000, '', '2021-03-22 11:39:01'),
('INVMGA21032200004', 'PRD_20210317_00007', 1, 2000, '', '2021-03-22 11:48:17'),
('INVMGA21032200005', 'PRD_20210315_00001', 2, 40000, '', '2021-03-22 15:01:27'),
('INVMGA21032200006', 'PRD_20210317_00004', 1, 15000, '', '2021-03-22 15:01:40'),
('INVMGA21032200007', 'PRD_20210317_00004', 1, 15000, '', '2021-03-22 15:49:12'),
('INVMGA21032200007', 'PRD_20210317_00007', 1, 2000, '', '2021-03-22 15:49:36'),
('INVMGA21032200008', 'PRD_20210317_00006', 1, 7000, '', '2021-03-22 17:25:38'),
('INVMGA21032200007', 'PRD_20210317_00004', 1, 15000, '', '2021-03-22 20:51:29'),
('INVMGA21032200006', 'PRD_20210317_00006', 2, 20000, 'mantaps', '2021-03-22 21:04:12'),
('INVMGA21032300001', 'PRD_20210317_00006', 1, 10000, '', '2021-03-23 11:26:15'),
('INVMGA21032300002', 'PRD_20210315_00001', 1, 20000, '', '2021-03-23 20:40:58'),
('INVMGA21032300002', 'PRD_20210317_00008', 2, 34000, '', '2021-03-23 20:41:09'),
('INVMGA21032300002', 'PRD_20210317_00006', 4, 40000, '', '2021-03-23 20:41:18'),
('INVMGA21032300002', 'PRD_20210317_00007', 2, 4000, 'Pensil yang bagus', '2021-03-23 20:57:57'),
('INVMGA21032400001', 'PRD_20210315_00001', 1, 20000, '', '2021-03-24 12:16:08'),
('INVMGA21032400002', 'PRD_20210317_00006', 2, 20000, 'ga pedes', '2021-03-24 12:16:29'),
('INVMGA21032400002', 'PRD_20210317_00007', 1, 2000, '', '2021-03-24 12:16:40'),
('INVMGA21032400003', 'PRD_20210317_00007', 3, 6000, '', '2021-03-24 13:54:32'),
('INVMGA21032400004', 'PRD_20210315_00001', 1, 20000, '', '2021-03-24 13:59:21'),
('INVMGA21032400004', 'PRD_20210317_00004', 1, 15000, '', '2021-03-24 13:59:37'),
('INVMGA21032400005', 'PRD_20210315_00001', 1, 20000, '', '2021-03-24 14:01:51'),
('INVMGA21032400006', 'PRD_20210315_00001', 1, 20000, '', '2021-03-24 14:02:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user`
--

CREATE TABLE `t_user` (
  `user_id` varchar(255) NOT NULL,
  `role_id` char(3) DEFAULT NULL,
  `store_id` char(3) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_regist` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_user`
--

INSERT INTO `t_user` (`user_id`, `role_id`, `store_id`, `user_name`, `user_email`, `user_password`, `user_regist`, `is_active`) VALUES
('USR_20210315_00001', 'SYS', '', 'Daud Nuryasin Nikah Catur Putra', 'nuryasin.daudpoetra@gmail.com', 'b5e3984c5ed3ca3d3dd1f690e4d84cfd', '2021-03-15', 1),
('USR_20210316_00002', 'ADM', 'MGA', 'Muhammad Naufal', 'naufaltrix@gmail.com', 'e6821e71321c72a73d5fceeb44b145da', '2021-03-16', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user_access_menu`
--

CREATE TABLE `t_user_access_menu` (
  `access_id` int(11) NOT NULL,
  `role_id` char(3) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_user_access_menu`
--

INSERT INTO `t_user_access_menu` (`access_id`, `role_id`, `menu_id`) VALUES
(1, 'SYS', 1),
(2, 'SYS', 2),
(3, 'SYS', 3),
(5, 'SYS', 5),
(6, 'SYS', 6),
(7, 'ADM', 1),
(8, 'ADM', 2),
(9, 'ADM', 3),
(10, 'ADM', 4),
(11, 'SYS', 7),
(13, 'ADM', 7),
(14, 'SYS', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user_menu`
--

CREATE TABLE `t_user_menu` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_user_menu`
--

INSERT INTO `t_user_menu` (`menu_id`, `menu_name`, `menu_sort`) VALUES
(1, 'Menu Utama', 1),
(2, 'Data Master', 2),
(3, 'Transaksi', 3),
(4, 'Laporan', 4),
(5, 'Manajemen Pengguna', 5),
(6, 'Manajemen Menu', 6),
(7, 'Profile', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user_submenu`
--

CREATE TABLE `t_user_submenu` (
  `submenu_id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `submenu_title` varchar(255) DEFAULT NULL,
  `submenu_url` varchar(255) DEFAULT NULL,
  `submenu_icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_user_submenu`
--

INSERT INTO `t_user_submenu` (`submenu_id`, `menu_id`, `submenu_title`, `submenu_url`, `submenu_icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'dashboard', 'fas fa-fw fa-home', 1),
(2, 2, 'Product', 'product', 'fas fa-fw fa-cubes', 1),
(3, 2, 'Category', 'category', 'far fa-fw fa-list-alt', 1),
(4, 2, 'Inventory', 'inventory', 'fas fa-warehouse', 1),
(5, 2, 'Customer', 'customer', 'fas fa-users', 1),
(6, 2, 'Payment', 'payment', 'fas fa-money-check-alt', 1),
(7, 2, 'Price', 'price', 'fas fa-money-bill-alt', 1),
(8, 3, 'New Transaction', 'transaction', 'fas fa-cash-register', 1),
(9, 4, 'Last Stock Product', 'laststock', 'fas fa-list-ol', 1),
(10, 2, 'Division', 'division', 'fab fa-black-tie', 1),
(11, 6, 'Menu', 'menu', 'far fa-folder-open', 1),
(12, 6, 'Submenu', 'submenu', 'far fa-folder-open', 1),
(13, 5, 'User', 'user', 'fas fa-user', 1),
(14, 5, 'Role', 'role', 'fas fa-user-tie', 1),
(16, 7, 'Profile', 'profile', 'fas fa-id-badge', 0),
(17, 7, 'Change Password', 'password', 'fas fa-key', 0),
(18, 5, 'Store', 'store', 'fas fa-store', 1),
(19, 3, 'Transaction Pending', 'pending', 'fas fa-ticket-alt', 1),
(20, 4, 'Laporan', 'report', 'fas fa-book', 0),
(21, 4, 'Report Transaction', 'report-transaction', 'far fa-file-alt', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_category`
--
ALTER TABLE `t_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indeks untuk tabel `t_customer`
--
ALTER TABLE `t_customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `division_id` (`division_id`);

--
-- Indeks untuk tabel `t_division`
--
ALTER TABLE `t_division`
  ADD PRIMARY KEY (`division_id`);

--
-- Indeks untuk tabel `t_inventory`
--
ALTER TABLE `t_inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `t_payment`
--
ALTER TABLE `t_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indeks untuk tabel `t_price`
--
ALTER TABLE `t_price`
  ADD PRIMARY KEY (`price_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `division_id` (`division_id`);

--
-- Indeks untuk tabel `t_product`
--
ALTER TABLE `t_product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeks untuk tabel `t_role`
--
ALTER TABLE `t_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indeks untuk tabel `t_store`
--
ALTER TABLE `t_store`
  ADD PRIMARY KEY (`store_id`);

--
-- Indeks untuk tabel `t_transaction`
--
ALTER TABLE `t_transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indeks untuk tabel `t_transaction_detail`
--
ALTER TABLE `t_transaction_detail`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indeks untuk tabel `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `store_id_2` (`store_id`);

--
-- Indeks untuk tabel `t_user_access_menu`
--
ALTER TABLE `t_user_access_menu`
  ADD PRIMARY KEY (`access_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indeks untuk tabel `t_user_menu`
--
ALTER TABLE `t_user_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indeks untuk tabel `t_user_submenu`
--
ALTER TABLE `t_user_submenu`
  ADD PRIMARY KEY (`submenu_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_division`
--
ALTER TABLE `t_division`
  MODIFY `division_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `t_price`
--
ALTER TABLE `t_price`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `t_user_access_menu`
--
ALTER TABLE `t_user_access_menu`
  MODIFY `access_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `t_user_menu`
--
ALTER TABLE `t_user_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `t_user_submenu`
--
ALTER TABLE `t_user_submenu`
  MODIFY `submenu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_customer`
--
ALTER TABLE `t_customer`
  ADD CONSTRAINT `t_customer_ibfk_1` FOREIGN KEY (`division_id`) REFERENCES `t_division` (`division_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_inventory`
--
ALTER TABLE `t_inventory`
  ADD CONSTRAINT `t_inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `t_product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_price`
--
ALTER TABLE `t_price`
  ADD CONSTRAINT `t_price_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `t_product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_price_ibfk_2` FOREIGN KEY (`division_id`) REFERENCES `t_division` (`division_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_product`
--
ALTER TABLE `t_product`
  ADD CONSTRAINT `t_product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `t_category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_transaction`
--
ALTER TABLE `t_transaction`
  ADD CONSTRAINT `t_transaction_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `t_payment` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_transaction_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `t_customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_transaction_detail`
--
ALTER TABLE `t_transaction_detail`
  ADD CONSTRAINT `t_transaction_detail_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `t_product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_transaction_detail_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `t_transaction` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_user`
--
ALTER TABLE `t_user`
  ADD CONSTRAINT `t_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `t_role` (`role_id`);

--
-- Ketidakleluasaan untuk tabel `t_user_access_menu`
--
ALTER TABLE `t_user_access_menu`
  ADD CONSTRAINT `t_user_access_menu_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `t_role` (`role_id`),
  ADD CONSTRAINT `t_user_access_menu_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `t_user_menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_user_submenu`
--
ALTER TABLE `t_user_submenu`
  ADD CONSTRAINT `t_user_submenu_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `t_user_menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
