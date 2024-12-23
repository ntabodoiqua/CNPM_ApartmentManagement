-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 22, 2024 lúc 05:57 PM
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
(1, 'Nguyễn Thế Anh', 'ntabodoiqua1@gmail.com', 'ntabodoiqua', '$2y$10$F4FeQyrcZQ7/XXfPG6HmUOMY71UiXAFFT8jDoaW4uPwwsAID789Q2');

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
  `apartment_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `apartments`
--

INSERT INTO `apartments` (`apartment_id`, `apartment_name`, `apartment_num`, `apartment_area`, `owner_id`, `curr_living`, `apartment_type`) VALUES
(2, 'Nguyễn Thế Anh', 101, 120, 3, 2, 'Nhà thường'),
(3, 'Phạm Văn Cường', 201, 150, 9, 1, 'Nhà thường'),
(4, 'Phạm Văn Thanh', 202, 111, 10, 2, 'Nhà thường');

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
(1, 2, 2, 1920000),
(2, 3, 2, 2400000),
(3, 4, 2, 1776000),
(4, 2, 3, 1920000),
(5, 3, 3, 2400000),
(6, 4, 3, 1776000),
(7, 2, 4, 840000),
(8, 3, 4, 1050000),
(9, 4, 4, 777000),
(18, 2, 11, 140000),
(19, 3, 11, 70000),
(20, 4, 11, 140000),
(21, 2, 12, 1920000),
(22, 3, 12, 2400000),
(23, 4, 12, 1776000),
(24, 2, 13, 100000),
(25, 3, 13, 100000),
(26, 4, 13, 100000),
(27, 2, 14, 120000),
(28, 3, 14, 120000),
(29, 4, 14, 120000),
(30, 2, 16, 115000),
(31, 3, 16, 115000),
(32, 4, 16, 115000),
(34, 3, 17, 70000),
(35, 4, 17, 140000),
(36, 2, 18, 140000),
(37, 3, 18, 70000),
(38, 4, 18, 140000),
(39, 2, 19, 140000),
(40, 3, 19, 70000),
(41, 4, 19, 140000),
(42, 2, 20, 140000),
(43, 3, 20, 70000),
(44, 4, 20, 140000),
(45, 2, 21, 1980000),
(46, 3, 21, 2475000),
(47, 4, 21, 1831500);

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
(1, 1, 0, 'Phí dịch vụ chung cư Tháng 12/2024', 'elon.jpg', '2024-12-01', '2024-12-31'),
(2, 1, 0, 'Phí dịch vụ chung cư Tháng 12/2024', 'elon.jpg', '2024-12-01', '2024-12-31'),
(3, 1, 0, 'Phí dịch vụ chung cư Tháng 1/2025', 'dell.png', '2025-01-01', '2025-01-31'),
(4, 2, 0, 'Phí quản lý chung cư tháng 12/2024', 'lenovo_logo.png', '2024-12-01', '2024-12-30'),
(11, 5, 0, 'Phí gửi xe máy tháng 12/2024', '747.png', '2024-12-01', '2024-12-31'),
(12, 1, 0, 'Phí dịch vụ chung cư Tháng 2/2025', 'customer1.jpg', '2025-02-01', '2025-02-28'),
(13, 3, 100000, 'Phí biển đảo tháng 12/2024', 'dohoa.png', '2024-12-01', '2024-12-31'),
(14, 4, 120000, 'Phí vì người nghèo tháng 12/2024', 'hp_logo.png', '2024-12-01', '2024-12-31'),
(15, 6, 0, 'Phí gửi Oto tháng 1/2025', 'lenovo_logo.png', '2025-01-01', '2025-01-31'),
(16, 3, 115000, 'Đóng góp vì người nghèo tháng 1/2025', 'msi_logo.png', '2025-01-01', '2025-01-31'),
(18, 5, 0, 'Phí gửi xe máy tháng 12/2024', 'lenovo_logo.png', '2024-12-01', '2024-12-31'),
(19, 5, 0, 'Phí gửi xe máy tháng 1/2025', 'slide7.jpg', '2025-01-01', '2025-01-31'),
(20, 5, 0, 'Phí gửi xe máy tháng 12/2023', 'QR_code.jpg', '2023-12-01', '2023-12-31'),
(21, 1, 0, 'Phí dịch vụ chung cư Tháng 3/2025', 'poster.jpg', '2025-03-01', '2025-03-31');

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
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`payment_id`, `fee_id`, `apartment_id`, `amount_due`, `amount_paid`, `payment_date`, `status`) VALUES
(1, 12, 2, 1920000, 1920000, '2024-12-21 16:01:48', 'Thanh toán 1 phần'),
(2, 12, 3, 2400000, 2400000, '2024-12-21 16:05:49', 'Đã thanh toán'),
(3, 12, 4, 1776000, 1776000, '2024-12-21 16:07:42', 'Đã thanh toán'),
(4, 16, 2, 115000, 0, '2024-12-21 16:27:44', 'Chưa thanh toán'),
(5, 16, 3, 115000, 115000, '2024-12-21 16:28:01', 'Đã thanh toán'),
(6, 16, 4, 115000, 0, '2024-12-21 16:27:44', 'Chưa thanh toán'),
(10, 18, 2, 140000, 100000, '2024-12-21 17:37:45', 'Thanh toán 1 phần'),
(11, 18, 3, 70000, 0, '2024-12-21 17:19:26', 'Chưa thanh toán'),
(12, 18, 4, 140000, 0, '2024-12-21 17:19:26', 'Chưa thanh toán'),
(13, 19, 2, 140000, 0, '2024-12-21 17:24:24', 'Chưa thanh toán'),
(14, 19, 3, 70000, 0, '2024-12-21 17:24:24', 'Chưa thanh toán'),
(15, 19, 4, 140000, 0, '2024-12-21 17:24:24', 'Chưa thanh toán'),
(16, 20, 2, 140000, 0, '2024-12-21 17:25:17', 'Chưa thanh toán'),
(17, 20, 3, 70000, 0, '2024-12-21 17:25:17', 'Chưa thanh toán'),
(18, 20, 4, 140000, 0, '2024-12-21 17:25:17', 'Chưa thanh toán'),
(19, 21, 2, 1980000, 0, '2024-12-22 08:35:52', 'Chưa thanh toán'),
(20, 21, 3, 2475000, 0, '2024-12-22 08:35:52', 'Chưa thanh toán'),
(21, 21, 4, 1831500, 0, '2024-12-22 08:35:52', 'Chưa thanh toán');

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
  `resident_dob` date NOT NULL,
  `resident_relation_owner` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `residents`
--

INSERT INTO `residents` (`resident_id`, `resident_name`, `resident_phone`, `resident_email`, `apartment_id`, `resident_image`, `resident_status`, `resident_dob`, `resident_relation_owner`) VALUES
(1, 'Vũ Hồng An', '0966277109', 'honganh@gmail.com', 2, 'customer3.jpg', 'Tạm vắng', '0000-00-00', 'Vợ'),
(2, 'Anh Đức', '123456789', 'honganh@gmail.com', 2, 'customer2.jpg', 'Đã chuyển đi', '0000-00-00', 'Vợ'),
(3, 'Vũ Thị Gái', '123', 'dsad', 2, 'ceonvdia.jpg', 'Đang sống', '2021-01-28', 'Chủ hộ'),
(9, 'Phạm Văn Cường', '111', 'dsaddsda', 3, 'elon.jpg', 'Đang sống', '2024-12-05', 'Chủ hộ'),
(10, 'Phạm Văn Thanh', '1023', '424', 4, 'QR_code.jpg', 'Đang sống', '2024-08-01', 'Chủ hộ'),
(11, 'Đức Quý', '452', '45254', 4, 'sontung.jpg', 'Đang sống', '2024-08-30', 'Em trai ruột'),
(15, 'Nguyễn Văn Quốc Việt', '034204004454', 'thuthucallme@gmail.com', 2, 'camung_icon.png', 'Tạm trú', '2024-04-30', 'Không có');

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
(1, 15, 'Ở trọ', 'Hạ Đình', '2024-07-30', '2029-07-30');

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
(1, 1, '0966277109', 'Đi học Đại học', 'Hà Nội', '2025-07-30', '2029-07-30');

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
(1, 'Phí dịch vụ chung cư', 16500),
(2, 'Phí quản lý chung cư', 7000),
(3, 'Phí không bắt buộc', 0),
(4, 'Phí tiện ích', 0),
(5, 'Phí gửi xe máy', 70000),
(6, 'Phí gửi xe oto', 1200000);

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
(9, 'phamvancuong', '$2y$10$5qIyi7UIU.Fs8JMcHS8fSeI3ZozzJfhLCwgAqVO3gxMl4/evar.9q');

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
(1, 1, 'Honda Wave trằng', 'Xe máy', '17B6-72685'),
(2, 2, 'Honda Wave đen', 'Xe máy', '122345'),
(3, 3, 'XYZ', 'Xe máy', 'XXXXXXXX'),
(4, 9, 'VLXX', 'Xe máy', 'VLXX'),
(5, 10, 'ĐCM', 'Xe máy', 'CCMNH'),
(6, 15, '12225544', 'Xe máy', '5434653686'),
(7, 11, 'CMMM', 'Xe máy', 'CMSNNSH');

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
  MODIFY `apartment_fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT cho bảng `fees`
--
ALTER TABLE `fees`
  MODIFY `fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `residents`
--
ALTER TABLE `residents`
  MODIFY `resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `tamtru`
--
ALTER TABLE `tamtru`
  MODIFY `tamtru_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tamvang`
--
ALTER TABLE `tamvang`
  MODIFY `tamvang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `type_fee`
--
ALTER TABLE `type_fee`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`apartment_id`);

--
-- Các ràng buộc cho bảng `residents`
--
ALTER TABLE `residents`
  ADD CONSTRAINT `residents_ibfk_1` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`apartment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
