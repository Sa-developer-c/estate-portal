-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 04:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estateportal_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `agent_list`
--

CREATE TABLE `agent_list` (
  `id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `gender` text NOT NULL,
  `contact` text NOT NULL,
  `address` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agent_list`
--

INSERT INTO `agent_list` (`id`, `firstname`, `middlename`, `lastname`, `gender`, `contact`, `address`, `email`, `password`, `avatar`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'user', 'D', 'محمود', 'Male', '09123456789', 'qalqilia', 'user@gmail.com', '202cb962ac59075b964b07152d234b70', 'uploads/agents/1.jpg?v=1645241414', 1, 0, '2022-02-19 11:30:14', NULL),
(2, 'manar', 'm', 'ma', 'Female', '05999559', 'Ramallah', 'manar@gmail.com', '202cb962ac59075b964b07152d234b70', 'uploads/agents/2.jpg?v=1745412738', 1, 0, '2025-04-23 15:52:18', NULL),
(3, 'sama', 's', 'sama', 'Female', '5555', 'nablus', 'sama@gmail.com', '202cb962ac59075b964b07152d234b70', 'uploads/agents/3.jpg?v=1745413422', 1, 0, '2025-04-23 16:03:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `amenity_list`
--

CREATE TABLE `amenity_list` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `type` tinyint(1) DEFAULT 1 COMMENT '1 = indoor, 2 = outdoor',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `amenity_list`
--

INSERT INTO `amenity_list` (`id`, `name`, `type`, `status`, `delete_flag`, `date_created`) VALUES
(1, 'غرفة نوم رئيسية', 1, 1, 0, '2022-02-19 09:45:33'),
(2, 'غرفة ضيوف', 1, 1, 0, '2022-02-19 09:45:42'),
(3, 'غرفة معيشة', 1, 1, 0, '2022-02-19 09:45:48'),
(5, 'مطبخ', 1, 1, 0, '2022-02-19 09:46:17'),
(6, 'موقف سيارات', 2, 1, 0, '2022-02-19 09:47:08'),
(7, 'برندة', 2, 1, 0, '2022-02-19 09:47:15'),
(9, 'ساحة', 2, 1, 0, '2022-02-19 09:47:43'),
(10, 'انترنت', 1, 1, 0, '2022-02-19 09:52:07'),
(11, 'غسالة', 1, 1, 0, '2022-02-19 09:52:15'),
(12, 'منطقة لعب للاطفال', 1, 1, 0, '2022-02-19 09:52:39');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `property_id` int(10) UNSIGNED NOT NULL,
  `sender_id` int(10) UNSIGNED NOT NULL,
  `receiver_id` int(10) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `property_id`, `sender_id`, `receiver_id`, `message`, `created_at`) VALUES
(25, 5, 1, 2, 'السلام عليكم', '2025-04-27 18:22:32'),
(26, 5, 2, 1, 'وعليكم السلام', '2025-04-27 18:22:46'),
(27, 5, 2, 3, 'مرحبا', '2025-04-27 18:25:05'),
(28, 5, 3, 2, 'هلا', '2025-04-27 18:25:12');

-- --------------------------------------------------------

--
-- Table structure for table `real_estate_amenities`
--

CREATE TABLE `real_estate_amenities` (
  `real_estate_id` int(30) NOT NULL,
  `amenity_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `real_estate_amenities`
--

INSERT INTO `real_estate_amenities` (`real_estate_id`, `amenity_id`) VALUES
(2, 10),
(2, 7),
(2, 9),
(2, 2),
(2, 3),
(2, 1),
(2, 11),
(2, 5),
(2, 12),
(2, 6),
(3, 10),
(3, 7),
(3, 9),
(3, 2),
(3, 3),
(3, 1),
(3, 11),
(3, 5),
(3, 12),
(3, 6),
(4, 7),
(4, 2),
(4, 1),
(5, 10),
(5, 7),
(5, 9),
(5, 2),
(5, 3),
(5, 1),
(5, 11),
(5, 5),
(5, 12),
(5, 6),
(6, 10),
(6, 7),
(6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `real_estate_list`
--

CREATE TABLE `real_estate_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `type_id` int(30) NOT NULL,
  `agent_id` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Available, 2 = not Available',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `sold_date` datetime DEFAULT NULL,
  `feedback` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `real_estate_list`
--

INSERT INTO `real_estate_list` (`id`, `code`, `name`, `type_id`, `agent_id`, `status`, `date_created`, `date_updated`, `sold_date`, `feedback`) VALUES
(2, '20250400002', 'مكتب للايجار السنوي', 2, 3, 1, '2022-02-19 14:12:49', '2025-05-03 04:08:37', NULL, 0),
(3, '20250400003', 'بيت مستقل للبيع', 3, 3, 1, '2022-02-19 16:00:19', '2025-04-23 16:41:31', NULL, 0),
(4, '20250400001', 'شقة للبيع', 1, 1, 0, '2025-04-26 23:22:08', '2025-04-27 01:47:45', '2025-04-27 00:12:24', 3),
(5, '20250500002', 'بيت للبيع', 3, 2, 1, '2025-04-27 17:46:05', '2025-05-03 16:40:07', NULL, NULL),
(6, '20250500003', 'Sample 102', 2, 2, 1, '2025-05-03 03:49:49', '2025-05-03 16:40:42', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `real_estate_meta`
--

CREATE TABLE `real_estate_meta` (
  `real_estate_id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `real_estate_meta`
--

INSERT INTO `real_estate_meta` (`real_estate_id`, `meta_field`, `meta_value`) VALUES
(2, 'type', 'مكتب'),
(2, 'purpose', 'للايجار'),
(2, 'area', '150 متر مرقع'),
(2, 'location', 'قلقيلية , هنا الشارع، هنا المدينة,..'),
(2, 'sale_price', '10000'),
(2, 'coordinates', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13505.219515583316!2d34.981513!3d32.1960145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151d3b9048e7320d%3A0x8ed08c13e5d9dc07!2sQalqilya!5e0!3m2!1sen!2s!4v1745413164768!5m2!1sen!2s'),
(2, 'description', '&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;&quot;&gt;هنا وصف لتفاصيل اخرى تخص العقار .. .&amp;nbsp;&lt;span style=&quot;font-size: 0.875rem;&quot;&gt;هنا وصف لتفاصيل اخرى تخص العقار .. .&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;font-size: 0.875rem;&quot;&gt;هنا وصف لتفاصيل اخرى تخص العقار .. .&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;font-size: 0.875rem;&quot;&gt;هنا وصف لتفاصيل اخرى تخص العقار .. .&amp;nbsp;&lt;/span&gt;&lt;/p&gt;'),
(2, 'thumbnail_path', 'uploads/thumbnails/2.jpg?v=1645251171'),
(3, 'type', 'بيت لعائلة'),
(3, 'purpose', 'للبيع'),
(3, 'area', '350'),
(3, 'location', 'رام الله'),
(3, 'sale_price', '300000'),
(3, 'coordinates', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13505.219515583316!2d34.981513!3d32.1960145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151d3b9048e7320d%3A0x8ed08c13e5d9dc07!2sQalqilya!5e0!3m2!1sen!2s!4v1745413164768!5m2!1sen!2s'),
(3, 'description', '&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;&quot;&gt;هنا وصف لتفاصيل اخرى تخص العقار .. .&amp;nbsp;&lt;span style=&quot;font-size: 0.875rem;&quot;&gt;هنا وصف لتفاصيل اخرى تخص العقار .. .&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;font-size: 0.875rem;&quot;&gt;هنا وصف لتفاصيل اخرى تخص العقار .. .&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;font-size: 0.875rem;&quot;&gt;هنا وصف لتفاصيل اخرى تخص العقار .. .&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;font-size: 0.875rem;&quot;&gt;هنا وصف لتفاصيل اخرى تخص العقار .. .&amp;nbsp;&lt;/span&gt;&lt;/p&gt;'),
(3, 'thumbnail_path', 'uploads/thumbnails/3.jpg?v=1645258133'),
(4, 'type', 'سكني'),
(4, 'purpose', 'بيع'),
(4, 'area', '150'),
(4, 'location', 'رام الله'),
(4, 'sale_price', '55555'),
(4, 'coordinates', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d27095.778143476775!2d35.20588205!3d31.90735085!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1502d54cda2d58d1%3A0xbf6d4d17cc8b2c76!2z2LHYp9mFINin2YTZhNmH!5e0!3m2!1sar!2s!4v1745698800944!5m2!1sar!2s>'),
(4, 'description', '&lt;p&gt;شقة جميلة للبيع بسعر جيد&lt;/p&gt;'),
(4, 'thumbnail_path', 'uploads/thumbnails/4.jpeg?v=1745698928'),
(5, 'type', 'سكني'),
(5, 'purpose', 'بيع'),
(5, 'area', '150'),
(5, 'location', 'رام الله'),
(5, 'sale_price', '55555'),
(5, 'coordinates', 'https://maps.app.goo.gl/ov8m8YVXCUYqGuCM7'),
(5, 'description', '....'),
(5, 'thumbnail_path', 'uploads/thumbnails/5.jpg?v=1745765165'),
(6, 'type', 'تجاري'),
(6, 'purpose', 'ايجار'),
(6, 'area', '350'),
(6, 'location', 'الخليل - راس الجورة'),
(6, 'sale_price', '10000'),
(6, 'coordinates', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13505.219515583316!2d34.981513!3d32.1960145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151d3b9048e7320d%3A0x8ed08c13e5d9dc07!2sQalqilya!5e0!3m2!1sen!2s!4v1745413164768!5m2!1sen!2s'),
(6, 'description', '&lt;p&gt;مكتب تجاري ممتااز&lt;/p&gt;'),
(6, 'thumbnail_path', 'uploads/thumbnails/6.jpeg?v=1746233389');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'البوابة العقارية'),
(6, 'short_name', 'البوابة العقارية'),
(11, 'logo', 'uploads/cover-1741516818.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1645233884.jpg?v=1645233884');

-- --------------------------------------------------------

--
-- Table structure for table `type_list`
--

CREATE TABLE `type_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type_list`
--

INSERT INTO `type_list` (`id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'شقة', 'شقة', 1, 0, '2022-02-19 10:02:11', '2025-04-23 15:47:00'),
(2, 'مكتب', 'مكتب', 1, 0, '2022-02-19 10:02:33', '2025-04-23 15:47:23'),
(3, 'بيت', 'بيت', 1, 0, '2022-02-19 10:02:48', '2025-04-23 15:47:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '202cb962ac59075b964b07152d234b70', 'uploads/avatars/1.png?v=1645064505', NULL, 1, '2021-01-20 14:02:37', '2025-04-23 15:53:22'),
(2, 'aya', 'admin', 'aya', '202cb962ac59075b964b07152d234b70', 'uploads/avatars/1.png?v=1645064505', NULL, 1, '2025-05-04 15:05:17', NULL),
(3, 'raghd', 'admin', 'raghd', '202cb962ac59075b964b07152d234b70', 'uploads/avatars/1.png?v=1645064505', NULL, 1, '2025-05-04 15:05:17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agent_list`
--
ALTER TABLE `agent_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amenity_list`
--
ALTER TABLE `amenity_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `real_estate_amenities`
--
ALTER TABLE `real_estate_amenities`
  ADD KEY `real_estate_id` (`real_estate_id`),
  ADD KEY `amenity_id` (`amenity_id`);

--
-- Indexes for table `real_estate_list`
--
ALTER TABLE `real_estate_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `agent_id` (`agent_id`);

--
-- Indexes for table `real_estate_meta`
--
ALTER TABLE `real_estate_meta`
  ADD KEY `real_estate_id` (`real_estate_id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_list`
--
ALTER TABLE `type_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agent_list`
--
ALTER TABLE `agent_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `amenity_list`
--
ALTER TABLE `amenity_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `real_estate_list`
--
ALTER TABLE `real_estate_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `type_list`
--
ALTER TABLE `type_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `real_estate_amenities`
--
ALTER TABLE `real_estate_amenities`
  ADD CONSTRAINT `real_estate_amenities_ibfk_1` FOREIGN KEY (`real_estate_id`) REFERENCES `real_estate_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `real_estate_amenities_ibfk_2` FOREIGN KEY (`amenity_id`) REFERENCES `amenity_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `real_estate_list`
--
ALTER TABLE `real_estate_list`
  ADD CONSTRAINT `real_estate_list_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `real_estate_list_ibfk_2` FOREIGN KEY (`agent_id`) REFERENCES `agent_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `real_estate_meta`
--
ALTER TABLE `real_estate_meta`
  ADD CONSTRAINT `real_estate_meta_ibfk_1` FOREIGN KEY (`real_estate_id`) REFERENCES `real_estate_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
