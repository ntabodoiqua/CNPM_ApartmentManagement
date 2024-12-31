-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 31, 2024 lúc 03:05 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `apartment_control`
--
CREATE DATABASE IF NOT EXISTS `apartment_control` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `apartment_control`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_username` varchar(100) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_name`, `admin_email`, `admin_username`, `admin_password`) VALUES
(1, 'Nguyễn Thế Anh', 'ntabodoiqua1@gmail.com', 'ntabodoiqua', '$2y$10$XQ1pHtfANnZRB8bUbi5C2ekbNunUGXZOZdBt7JVtLNPS.ABgI6dsq');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `apartments`
--

CREATE TABLE `apartments` (
  `apartment_id` int(11) NOT NULL,
  `apartment_name` varchar(50) NOT NULL,
  `apartment_num` int(11) NOT NULL,
  `apartment_area` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `curr_living` int(11) NOT NULL,
  `is_left` tinyint(1) NOT NULL,
  `apartment_type` varchar(50) NOT NULL,
  `apartment_ngaylap` date DEFAULT NULL,
  `apartment_ngayroi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `apartments`
--

INSERT INTO `apartments` (`apartment_id`, `apartment_name`, `apartment_num`, `apartment_area`, `owner_id`, `curr_living`, `is_left`, `apartment_type`, `apartment_ngaylap`, `apartment_ngayroi`) VALUES
(1, 'Phòng 101 - Nguyễn Thế Anh', 101, 20, 1, 4, 0, 'Nhà thường', '2024-12-25', NULL),
(2, 'Phòng 201 - Vũ Đức Hiếu', 201, 25, 2, 3, 0, 'Penhouse', '2024-12-25', NULL),
(3, 'Phòng 301 - Trần Hữu Đạt', 301, 27, 3, 2, 0, 'Nhà thường', '2024-12-25', NULL),
(4, 'Phòng 401 - Trần Dần', 401, 31, 0, 0, 1, 'Nhà thường', '2024-12-26', '2024-12-30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `apartment_fees`
--

CREATE TABLE `apartment_fees` (
  `apartment_fee_id` int(11) NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `fee_id` int(11) NOT NULL,
  `money` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `apartment_fees`
--

INSERT INTO `apartment_fees` (`apartment_fee_id`, `apartment_id`, `fee_id`, `money`) VALUES
(6, 1, 5, 70000),
(7, 2, 5, 70000),
(8, 3, 5, 70000),
(9, 1, 6, 1200000),
(10, 2, 6, 2400000),
(11, 3, 6, 2400000),
(12, 1, 7, 320000),
(13, 2, 7, 400000),
(14, 3, 7, 432000),
(15, 1, 8, 100000),
(16, 1, 9, 320000),
(17, 2, 9, 400000),
(18, 3, 9, 432000),
(19, 1, 10, 320000),
(20, 2, 10, 400000),
(21, 3, 10, 432000),
(22, 2, 11, 2400002),
(23, 3, 11, 2400002),
(24, 1, 12, 140000),
(25, 2, 12, 175000),
(26, 3, 12, 189000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `fees`
--

CREATE TABLE `fees` (
  `fee_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `fee_additional_amount` int(11) NOT NULL,
  `fee_name` varchar(255) NOT NULL,
  `fee_image` varchar(255) NOT NULL,
  `fee_start_date` date NOT NULL,
  `fee_due_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `fees`
--

INSERT INTO `fees` (`fee_id`, `type_id`, `fee_additional_amount`, `fee_name`, `fee_image`, `fee_start_date`, `fee_due_date`) VALUES
(5, 5, 0, 'Phí gửi xe máy tháng 12/2024', 'Phi_xe_may.png', '2024-12-01', '2024-12-31'),
(6, 6, 0, 'Phí gửi xe Oto tháng 12/2024', 'Phi_oto.png', '2024-12-01', '2024-12-31'),
(7, 1, 0, 'Phí dịch vụ chung cư Tháng 12/2024', 'Phi_dich_vu_chung_cu.png', '2024-12-01', '2024-12-31'),
(8, 4, 100000, 'Tiền điện tháng 12/2024', 'Phi_tien_ich.png', '2024-12-01', '2024-12-31'),
(9, 1, 0, 'Phí dịch vụ chung cư Tháng 2/2025', 'Phi_dich_vu_chung_cu.png', '2025-02-01', '2025-02-28'),
(10, 1, 0, 'Phí dịch vụ chung cư tháng 11/2024', 'Phi_dich_vu_chung_cu.png', '2024-11-01', '2024-11-30'),
(11, 6, 0, 'Phí gửi xe Oto tháng 12/2023', 'Phi_oto.png', '2023-12-01', '2023-12-31'),
(12, 2, 0, 'Phí quản lý chung cư tháng 1/2025', 'Phi_quan_ly_chung_cu.png', '2025-01-01', '2025-01-31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `fee_id` int(11) NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `amount_due` double NOT NULL,
  `amount_paid` double NOT NULL,
  `payment_date` datetime DEFAULT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`payment_id`, `fee_id`, `apartment_id`, `amount_due`, `amount_paid`, `payment_date`, `status`) VALUES
(6, 5, 1, 70000, 70000, '2024-12-26 10:02:36', 'Đã thanh toán'),
(7, 5, 2, 70000, 70000, '2024-12-28 19:36:31', 'Đã thanh toán'),
(9, 6, 1, 1200000, 1200000, '2024-12-28 19:36:41', 'Đã thanh toán'),
(11, 6, 3, 2400000, 2400000, '2024-12-28 19:37:10', 'Đã thanh toán'),
(15, 8, 1, 100000, 100000, '2024-12-28 19:37:00', 'Đã thanh toán'),
(17, 9, 2, 400000, 400000, '2024-12-28 19:36:49', 'Đã thanh toán'),
(32, 10, 1, 320000, 320000, '2024-11-27 10:26:11', 'Đã thanh toán'),
(33, 10, 2, 400000, 400000, '2024-11-28 10:26:56', 'Đã thanh toán'),
(34, 10, 3, 432000, 432000, '2024-11-13 10:27:19', 'Đã thanh toán'),
(35, 11, 2, 2400002, 2400002, '2023-12-27 10:29:09', 'Đã thanh toán'),
(36, 11, 3, 2400002, 2400002, '2023-12-28 10:29:39', 'Đã thanh toán'),
(37, 12, 1, 140000, 140000, '2024-12-30 10:48:07', 'Đã thanh toán'),
(38, 12, 2, 175000, 0, NULL, 'Chưa thanh toán'),
(39, 12, 3, 189000, 0, NULL, 'Chưa thanh toán');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `residents`
--

CREATE TABLE `residents` (
  `resident_id` int(11) NOT NULL,
  `resident_name` varchar(50) NOT NULL,
  `resident_phone` varchar(20) NOT NULL,
  `resident_email` varchar(100) NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `resident_image` varchar(255) NOT NULL,
  `resident_status` varchar(50) NOT NULL,
  `resident_ngayden` date DEFAULT NULL,
  `resident_ngaydi` date DEFAULT NULL,
  `resident_dob` date NOT NULL,
  `resident_relation_owner` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `residents`
--

INSERT INTO `residents` (`resident_id`, `resident_name`, `resident_phone`, `resident_email`, `apartment_id`, `resident_image`, `resident_status`, `resident_ngayden`, `resident_ngaydi`, `resident_dob`, `resident_relation_owner`) VALUES
(1, 'Nguyễn Thế Anh', '20224921', 'anhnta2004@gmail.com', 1, 'theanh.png', 'Đang sống', '2024-12-25', NULL, '2004-07-30', 'Chủ hộ'),
(2, 'Vũ Đức Hiếu', '20210314', 'duchieu@gmail.com', 2, 'vuhieu.png', 'Đang sống', '2024-12-25', NULL, '2003-01-01', 'Chủ hộ'),
(3, 'Trần Hữu Đa', '20225120', 'huudat@gmail.com', 3, 'nguoidan_7.jpg', 'Đang sống', '2024-12-25', NULL, '2004-01-01', 'Chủ hộ'),
(4, 'Lionel Messi', '20220000', 'messi@gmail.com', 1, 'nguoidan_9.jpg', 'Tạm vắng', '2024-12-26', NULL, '1987-06-24', 'Con ruột'),
(5, 'Trần Hà Linh', '20220001', 'halinh@gmail.com', 2, 'nguoidan_1.jpg', 'Đang sống', '2024-12-25', NULL, '1999-01-01', 'Vợ'),
(6, 'Nguyễn Thị An Nhiên', '20220002', 'annhien@gmail.com', 3, 'nguoidan_2.jpg', 'Đã chuyển đi', '2024-12-25', '2024-12-26', '1998-01-01', 'Vợ'),
(7, 'Phạm Gia Linh', '20220003', 'gialinh@gmail.com', 1, 'nguoidan_3.jpg', 'Đang sống', '2024-12-25', NULL, '1995-12-30', 'Con ruột'),
(8, 'Hoàng Hạ Vy', '20220004', 'havi@gmail.com', 2, 'nguoidan_4.jpg', 'Đang sống', '2024-12-25', NULL, '1994-01-01', 'Con ruột'),
(9, 'Đặng Thị Hoàng Anh', '20220005', 'hoanganh@gmail.com', 3, 'nguoidan_5.jpg', 'Đang sống', '2024-12-25', NULL, '1994-01-01', 'Con ruột'),
(10, 'Vũ Khánh Linh', '20220006', 'khanhlinh@gmail.com', 1, 'nguoidan_6.jpg', 'Đang sống', '2024-12-25', NULL, '1990-01-01', 'Vợ'),
(11, 'Trần Dần', '20220007', 'trandan@gmail.com', 4, 'nguoidan_12.jpg', 'Đã chuyển đi', '2024-12-26', '2024-12-26', '1980-01-01', 'Chủ hộ'),
(12, 'Trần Đức Bo', '20229999', 'ducbo@gmail.com', 1, 'nguoidan_14.jpg', 'Tạm trú', NULL, NULL, '1955-01-01', 'Không có');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tamtru`
--

CREATE TABLE `tamtru` (
  `tamtru_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `lydo` varchar(255) NOT NULL,
  `tamtru_thuongtru` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tamtru`
--

INSERT INTO `tamtru` (`tamtru_id`, `resident_id`, `lydo`, `tamtru_thuongtru`, `start_date`, `end_date`) VALUES
(1, 12, 'Đi học Đại học', 'Thụy Chính', '2025-01-01', '2029-01-01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tamvang`
--

CREATE TABLE `tamvang` (
  `tamvang_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `cccd` varchar(20) NOT NULL,
  `lydo` varchar(255) NOT NULL,
  `tamvang_address` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tamvang`
--

INSERT INTO `tamvang` (`tamvang_id`, `resident_id`, `cccd`, `lydo`, `tamvang_address`, `start_date`, `end_date`) VALUES
(1, 4, '20220000', 'Đi công tác', 'Singapore', '2025-01-01', '2029-01-01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `type_fee`
--

CREATE TABLE `type_fee` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `type_rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `type_fee`
--

INSERT INTO `type_fee` (`type_id`, `type_name`, `type_rate`) VALUES
(1, 'Phí dịch vụ chung cư', 16000),
(2, 'Phí quản lý chung cư', 7000),
(3, 'Phí không bắt buộc', 0),
(4, 'Phí tiện ích', 0),
(5, 'Phí gửi xe máy', 70000),
(6, 'Phí gửi xe oto', 1200001);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_table`
--

CREATE TABLE `user_table` (
  `resident_id` int(11) NOT NULL,
  `user_username` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_table`
--

INSERT INTO `user_table` (`resident_id`, `user_username`, `user_password`) VALUES
(1, 'theanh', '$2y$10$BecmLUCeA0kL3aDe8HxhnujimXwEfhuWMISGi.h7/nsz6WnXWaEX.'),
(3, 'huuda', '$2y$10$t3m0LlJZBjc6msk/JM1bouLzTjzgD4uvSocGklI1F1S5E3Cq4a6U6');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `vehicle_name` varchar(100) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `vehicle_plate` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `resident_id`, `vehicle_name`, `vehicle_type`, `vehicle_plate`) VALUES
(4, 1, 'Honda Wave đen', 'Xe máy', '17B6-72685'),
(6, 2, 'Exciter', 'Xe máy', '30B6-12345'),
(7, 5, 'Audi Trắng', 'Oto', '30B-12345'),
(8, 8, 'Lexus Trắng', 'Oto', '30B1-12345'),
(9, 3, 'Camry Đỏ', 'Oto', '15A-12345'),
(10, 9, 'Huyndai Tím', 'Oto', '15B-12345'),
(11, 6, 'Yamaha Elegant Hồng', 'Xe máy', '30B5-12345'),
(12, 5, 'Air Blade', 'Xe máy', '99A-9999');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`apartment_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Chỉ mục cho bảng `apartment_fees`
--
ALTER TABLE `apartment_fees`
  ADD PRIMARY KEY (`apartment_fee_id`);

--
-- Chỉ mục cho bảng `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`fee_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `apartment_id` (`apartment_id`),
  ADD KEY `fee_id` (`fee_id`);

--
-- Chỉ mục cho bảng `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`resident_id`),
  ADD KEY `apartment_id` (`apartment_id`);

--
-- Chỉ mục cho bảng `tamtru`
--
ALTER TABLE `tamtru`
  ADD PRIMARY KEY (`tamtru_id`);

--
-- Chỉ mục cho bảng `tamvang`
--
ALTER TABLE `tamvang`
  ADD PRIMARY KEY (`tamvang_id`);

--
-- Chỉ mục cho bảng `type_fee`
--
ALTER TABLE `type_fee`
  ADD PRIMARY KEY (`type_id`);

--
-- Chỉ mục cho bảng `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`resident_id`);

--
-- Chỉ mục cho bảng `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD KEY `vehicles_ibfk_1` (`resident_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `apartments`
--
ALTER TABLE `apartments`
  MODIFY `apartment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `apartment_fees`
--
ALTER TABLE `apartment_fees`
  MODIFY `apartment_fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `fees`
--
ALTER TABLE `fees`
  MODIFY `fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `residents`
--
ALTER TABLE `residents`
  MODIFY `resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `tamtru`
--
ALTER TABLE `tamtru`
  MODIFY `tamtru_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tamvang`
--
ALTER TABLE `tamvang`
  MODIFY `tamvang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `type_fee`
--
ALTER TABLE `type_fee`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
