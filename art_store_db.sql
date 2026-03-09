-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2025 at 08:11 AM
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
-- Database: `art_store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustEmail` varchar(100) NOT NULL,
  `CustFName` varchar(50) DEFAULT NULL,
  `CustLName` varchar(50) DEFAULT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL,
  `PostCode` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustEmail`, `CustFName`, `CustLName`, `Phone`, `Address`, `State`, `PostCode`) VALUES
('123123123123123@gmail.com', 'User', 'Account', NULL, NULL, NULL, NULL),
('123123123@gmail.com', 'User', 'Account', NULL, NULL, NULL, NULL),
('123123@gmail.com', 'User', 'Account', NULL, NULL, NULL, NULL),
('123123@hotmail.com', 'Vinh Kien', 'Tran', '0459055790', '18 Clarence St Lea', 'New South Wales', '0812'),
('123@gmail.com', 'User', 'Account', NULL, NULL, NULL, NULL),
('admin123@gmail.com', 'Admin', 'Account', NULL, NULL, NULL, NULL),
('asad@gmail.com', 'Vinh Kien', 'Tran', '0459055790', '18 Clarence St Lea', 'Northern Territory', '0812'),
('asd@asda.com', 'Vinh Kien', 'Tran', '0459055790', '18 Clarence St Lea', 'Northern Territory', '0812'),
('asda@gmail.com', 'asdsa', 'asdasd', '0459055790', '18 Clarence St Lea', 'Northern Territory', '0812'),
('asdads@gmail.com', 'Vinh Kien', 'Tran', '0459055790', '18 Clarence St Lea', 'Australian Capital Territory', '0812'),
('asdas1@gmail.com', 'Vinh Kien', 'Tran', '0459055790', '18 Clarence Street', 'South Australia', '0812'),
('asdas@ads.com', 'asda', 'asdasd', '0459055790', 'asd', 'Tasmania', '0810'),
('asdas@asdsa.com', 'Vinh Kien', 'Tran', '0459055790', '43 McLachlan St\r\nUnit 9', 'Northern Territory', '0800'),
('asdasd@asdadsasdasdasd.com', 'asda', 'asdasd', '0459055790', 'asd', 'Tasmania', '0810'),
('asdasda2123@hotmail.com', 'asdas', 'asdas', '0459055790', '18 Clarence Street', 'South Australia', '0812'),
('kecmllop61@gmail.com', 'Vinh', 'Tran', '0459055790', 'Parcel Locker 10270 34645 Shop 1 4 Rowling Street', NULL, '0810'),
('kecmllop61@rqweqwa.com', 'Vinh', 'Tran', '0459055790', 'Parcel Locker 10270 34645 Shop 1 4 Rowling Street', 'Northern Territory', '0810'),
('ken123@gmail.com', 'User', 'Account', NULL, NULL, NULL, NULL),
('kencmllop61@gmai.com', 'User', 'Account', NULL, NULL, NULL, NULL),
('kencmllop61@gmail.com', 'Vinh Kien', 'Tran', '0459055790', '18 Clarence St Lea', NULL, '0812'),
('kencmllop61@hotmai.com', 'Vinh Kien', 'Tran', '0459055790', '18 Clarence Street', 'South Australia', '0812'),
('s367251@asda.com', 'Vinh Kien', 'Tran', '0459055790', '43 McLachlan St\r\nUnit 9', 'Northern Territory', '0800'),
('s367251@asdasd.com', 'Vinh Kien', 'Tran', '0459055790', '43 McLachlan St\r\nUnit 9', 'Northern Territory', '0800'),
('s367251@students.cdu.edu.au', 'Vinh Kien', 'Tran', '0459055790', '43 McLachlan St\r\nUnit 9', NULL, '0800'),
('sadin11223@gmail.com', 'Vinh Kien', 'Tran', '123123', '18 Clarence St Lea', 'Western Australia', '0812');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `NewsID` int(11) NOT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `Message` text DEFAULT NULL,
  `DatePosted` date DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`NewsID`, `Title`, `Message`, `DatePosted`, `IsActive`) VALUES
(4, 'News 1', 'asd', '2025-06-02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `Description` text DEFAULT NULL,
  `Artist` varchar(100) DEFAULT NULL,
  `Price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `Description`, `Artist`, `Price`) VALUES
(1, 'Sunset Landscape', 'Sarah Mitchell', 75),
(2, 'Abstract Shapes', 'James Chen', 46),
(3, 'Ocean Painting', 'Emma Thompson', 65),
(4, 'Kakadu Dreaming', 'Michael Aboriginal Art', 89),
(5, 'Darwin Harbour Sunset', 'Sarah Mitchell', 120),
(6, 'Mindil Beach Markets', 'Lisa Rodriguez', 95),
(7, 'Crocodile Spirit', 'Michael Aboriginal Art', 150),
(8, 'Tropical Paradise', 'James Chen', 78),
(9, 'Litchfield Waterfalls', 'Tom Anderson', 110),
(10, 'Aboriginal Dot Painting', 'Mary Namatjira', 200),
(11, 'Mangrove Reflections', 'Lisa Rodriguez', 85),
(12, 'Desert Bloom', 'Mary Namatjira', 175);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `PurchaseNo` int(11) NOT NULL,
  `DateOrdered` date DEFAULT NULL,
  `CustEmail` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`PurchaseNo`, `DateOrdered`, `CustEmail`) VALUES
(1, '2025-05-20', 'kencmllop61@gmail.com'),
(2, '2025-05-20', 'kencmllop61@gmail.com'),
(3, '2025-05-20', 'kecmllop61@gmail.com'),
(4, '2025-05-20', 's367251@students.cdu.edu.au'),
(5, '2025-05-20', 'kencmllop61@gmail.com'),
(6, '2025-05-20', 'kencmllop61@gmail.com'),
(7, '2025-05-20', 'kecmllop61@gmail.com'),
(8, '2025-05-20', 's367251@students.cdu.edu.au'),
(9, '2025-05-23', 'kencmllop61@gmail.com'),
(10, '2025-05-23', 'kencmllop61@gmail.com'),
(11, '2025-05-23', 'kecmllop61@gmail.com'),
(12, '2025-05-23', 'kencmllop61@gmail.com'),
(13, '2025-05-23', 'kencmllop61@gmail.com'),
(14, '2025-05-24', '123@gmail.com'),
(15, '2025-05-24', '123123@gmail.com'),
(16, '2025-05-25', 'kencmllop61@gmail.com'),
(17, '2025-05-25', 'admin123@gmail.com'),
(18, '2025-05-27', 'kencmllop61@gmail.com'),
(19, '2025-05-27', 'kencmllop61@gmail.com'),
(20, '2025-05-27', 'kencmllop61@gmail.com'),
(21, '2025-05-27', 'asda@gmail.com'),
(22, '2025-05-27', 'kencmllop61@gmail.com'),
(23, '2025-05-27', 'kencmllop61@gmail.com'),
(24, '2025-05-27', '123123@hotmail.com'),
(25, '2025-05-27', 'kencmllop61@gmail.com'),
(26, '2025-05-27', 's367251@students.cdu.edu.au'),
(27, '2025-05-27', 'kencmllop61@gmail.com'),
(28, '2025-05-28', 'kecmllop61@gmail.com'),
(29, '2025-05-28', 'kencmllop61@gmail.com'),
(30, '2025-05-28', 'admin123@gmail.com'),
(31, '2025-05-28', 'kencmllop61@gmail.com'),
(32, '2025-05-28', 'kencmllop61@gmail.com'),
(33, '2025-05-28', 'kencmllop61@gmail.com'),
(34, '2025-05-28', 'kencmllop61@gmail.com'),
(35, '2025-05-28', 's367251@students.cdu.edu.au'),
(36, '2025-05-28', 'kencmllop61@gmail.com'),
(37, '2025-05-28', 'kencmllop61@gmail.com'),
(38, '2025-05-28', 'asdas1@gmail.com'),
(39, '2025-05-28', 'asdads@gmail.com'),
(40, '2025-05-28', 'kencmllop61@gmail.com'),
(41, '2025-05-28', 'asdas@asdsa.com'),
(42, '2025-05-28', 'kencmllop61@hotmai.com'),
(43, '2025-05-28', 'asdasda2123@hotmail.com'),
(44, '2025-05-28', 'kecmllop61@gmail.com'),
(45, '2025-05-28', 'asdasd@asdadsasdasdasd.com'),
(46, '2025-05-30', 'kencmllop61@gmail.com'),
(47, '2025-05-30', 'sadin11223@gmail.com'),
(48, '2025-05-30', 'asad@gmail.com'),
(49, '2025-05-30', 'asd@asda.com'),
(50, '2025-05-30', 's367251@students.cdu.edu.au'),
(51, '2025-05-30', 'kecmllop61@gmail.com'),
(52, '2025-05-30', 's367251@asda.com'),
(53, '2025-05-30', 's367251@asdasd.com'),
(54, '2025-05-30', 'kecmllop61@gmail.com'),
(55, '2025-05-30', 'kencmllop61@gmail.com'),
(56, '2025-05-30', 'kencmllop61@gmail.com'),
(57, '2025-05-30', 'kencmllop61@gmail.com'),
(58, '2025-05-30', 's367251@students.cdu.edu.au'),
(59, '2025-05-30', 'asdas@ads.com'),
(60, '2025-05-30', 'kencmllop61@gmail.com'),
(61, '2025-06-02', 'kecmllop61@rqweqwa.com'),
(62, '2025-06-02', 'kencmllop61@gmail.com'),
(63, '2025-06-02', 'kencmllop61@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseitem`
--

CREATE TABLE `purchaseitem` (
  `ItemNo` int(11) NOT NULL,
  `PurchaseNo` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchaseitem`
--

INSERT INTO `purchaseitem` (`ItemNo`, `PurchaseNo`, `ProductID`, `Quantity`) VALUES
(2, 12, 2, 1),
(3, 13, 2, 1),
(4, 14, 1, 1),
(5, 15, 2, 1),
(6, 15, 1, 1),
(7, 16, 4, 1),
(8, 16, 2, 3),
(9, 16, 1, 3),
(10, 16, 3, 2),
(11, 17, 5, 1),
(12, 17, 2, 2),
(13, 18, 2, 3),
(14, 19, 2, 1),
(15, 20, 2, 3),
(16, 20, 3, 1),
(17, 21, 2, 1),
(18, 22, 2, 1),
(19, 23, 2, 1),
(20, 24, 2, 1),
(21, 25, 2, 1),
(22, 26, 2, 1),
(23, 27, 2, 1),
(24, 28, 2, 1),
(25, 29, 3, 1),
(26, 30, 2, 1),
(27, 31, 2, 1),
(28, 32, 2, 1),
(29, 33, 2, 1),
(30, 34, 3, 1),
(31, 34, 1, 1),
(32, 35, 2, 1),
(33, 36, 1, 1),
(34, 36, 2, 1),
(35, 36, 3, 1),
(36, 37, 3, 1),
(37, 37, 2, 1),
(38, 37, 5, 1),
(39, 38, 2, 1),
(40, 39, 3, 1),
(41, 40, 2, 1),
(42, 41, 2, 1),
(43, 42, 3, 1),
(44, 43, 2, 1),
(45, 44, 2, 1),
(46, 45, 2, 1),
(47, 46, 2, 1),
(48, 47, 3, 1),
(49, 48, 1, 1),
(50, 49, 1, 1),
(51, 50, 2, 1),
(52, 51, 2, 1),
(53, 52, 2, 1),
(54, 53, 2, 2),
(55, 53, 1, 1),
(56, 54, 2, 1),
(57, 55, 2, 1),
(58, 56, 2, 1),
(59, 57, 1, 1),
(60, 57, 3, 1),
(61, 57, 5, 1),
(62, 57, 4, 1),
(63, 58, 3, 1),
(64, 59, 4, 1),
(65, 59, 3, 1),
(66, 60, 2, 1),
(67, 60, 3, 1),
(68, 60, 4, 1),
(69, 61, 3, 1),
(70, 61, 2, 1),
(71, 62, 2, 1),
(72, 63, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `TestimonialID` int(11) NOT NULL,
  `CustEmail` varchar(100) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `DatePosted` datetime NOT NULL DEFAULT current_timestamp(),
  `Status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonial`
--

INSERT INTO `testimonial` (`TestimonialID`, `CustEmail`, `Content`, `DatePosted`, `Status`) VALUES
(36, 's367251@students.cdu.edu.au', 'asdas', '2025-06-02 01:32:06', 0),
(37, 'kencmllop61@gmail.com', 'asdas', '2025-06-02 15:07:17', 0),
(38, 'asdasd@asdadsasdasdasd.com', 'asdsad', '2025-06-02 15:14:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `is_admin`, `created_at`) VALUES
(1, 'kencmllop61@gmail.com', '$2y$10$8RxaTwOhc4605nAl.ofwO.v9vYmrW5qxedwJV7rMiMf/fje7TcJNW', 0, '2025-05-23 17:05:23'),
(3, '123@gmail.com', '$2y$10$YmyKGQGKYOcwtjARfQv/TeDZJth7CUk3a4nfPiseHqRIvHJFfXJZS', 0, '2025-05-23 17:06:29'),
(4, 's367251@students.cdu.edu.au', '$2y$10$eJKAc2DjQ.zrUMljZoTVCOUdleQeUkQJbdf3tkoMXpy2DkFLHr1lO', 0, '2025-05-23 17:10:34'),
(5, '123123@gmail.com', '$2y$10$GNS094T8eruA40yKdVxFFOr5x41BAck9VTmLuYwcKxBfU3Vf6zzYq', 0, '2025-05-23 17:16:43'),
(6, 'admin123@gmail.com', '$2y$10$7UI.i6.D/BEStn3z6duQ9uJUmUkbMlTUmeg9RT9s7N8kImKIxO/M6', 1, '2025-05-23 17:49:17'),
(7, '123123123@gmail.com', '$2y$10$SD9DR2DhQdl52VYfVUeu5.mc8wg6LJTEm/DxP86LU7vKauE644V/2', 0, '2025-05-24 13:31:10'),
(8, 'kencmllop61@gmai.com', '$2y$10$5i5STtgqkkHR1Oppkn9WZ.hapW2.6tHSNN0dByV6njD.ufTKdZsm.', 0, '2025-05-25 12:33:42'),
(9, '123123123123123@gmail.com', '$2y$10$rZCUPsPUlV/OeYgcmXzbG.W5jz/JI9o7IHPN5t0kdJ0Ys/PHDeVbK', 0, '2025-05-25 15:05:58'),
(10, 'ken123@gmail.com', '$2y$10$5E.h.J/oXQH0rN67kxLnNe84FKYsGCuHjeMgIQ1s.dXEZ5DT1ik4i', 0, '2025-05-26 12:07:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustEmail`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`NewsID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`PurchaseNo`),
  ADD KEY `CustEmail` (`CustEmail`);

--
-- Indexes for table `purchaseitem`
--
ALTER TABLE `purchaseitem`
  ADD PRIMARY KEY (`ItemNo`),
  ADD KEY `PurchaseNo` (`PurchaseNo`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`TestimonialID`),
  ADD KEY `CustEmail` (`CustEmail`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_is_admin` (`is_admin`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_is_admin` (`is_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `NewsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `PurchaseNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `purchaseitem`
--
ALTER TABLE `purchaseitem`
  MODIFY `ItemNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `TestimonialID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`CustEmail`) REFERENCES `customer` (`CustEmail`);

--
-- Constraints for table `purchaseitem`
--
ALTER TABLE `purchaseitem`
  ADD CONSTRAINT `purchaseitem_ibfk_1` FOREIGN KEY (`PurchaseNo`) REFERENCES `purchase` (`PurchaseNo`),
  ADD CONSTRAINT `purchaseitem_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- Constraints for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD CONSTRAINT `testimonial_ibfk_1` FOREIGN KEY (`CustEmail`) REFERENCES `customer` (`CustEmail`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
