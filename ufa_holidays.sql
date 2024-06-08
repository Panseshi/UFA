-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 10:00 PM
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
-- Database: `ufa_holidays`
--

-- --------------------------------------------------------

--
-- Table structure for table `action_logs`
--

CREATE TABLE `action_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action_type` enum('purchase','reservation') DEFAULT NULL,
  `action_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `action_logs`
--

INSERT INTO `action_logs` (`log_id`, `user_id`, `action_type`, `action_id`, `action`, `action_date`) VALUES
(1, 0, 'purchase', 11, 'Deleted purchase ID: 11', '2024-06-06 17:04:10'),
(2, 2, '', NULL, 'Deleted reservation with ID 37', '2024-06-06 18:16:33'),
(3, 0, 'purchase', 14, 'Deleted purchase ID: 14', '2024-06-06 20:21:52'),
(4, 0, 'purchase', 15, 'Deleted purchase ID: 15', '2024-06-06 20:21:56'),
(5, 0, 'purchase', 13, 'Deleted purchase ID: 13', '2024-06-06 20:21:59'),
(6, 0, 'purchase', 16, 'Deleted purchase ID: 16', '2024-06-06 20:22:02'),
(7, 0, 'purchase', 12, 'Deleted purchase ID: 12', '2024-06-06 20:22:06'),
(8, 2, '', NULL, 'Deleted reservation with ID 38', '2024-06-06 20:35:10'),
(9, 0, 'purchase', 17, 'Deleted purchase ID: 17', '2024-06-06 20:35:42'),
(10, 0, 'purchase', 18, 'Deleted purchase ID: 18', '2024-06-06 20:48:30'),
(11, 0, 'purchase', 20, 'Deleted purchase ID: 20', '2024-06-06 20:48:33'),
(12, 0, 'purchase', 21, 'Deleted purchase ID: 21', '2024-06-06 20:48:36'),
(13, 0, 'purchase', 22, 'Deleted purchase ID: 22', '2024-06-06 20:48:39'),
(14, 0, 'purchase', 23, 'Deleted purchase ID: 23', '2024-06-06 20:48:42'),
(15, 0, 'purchase', 24, 'Deleted purchase ID: 24', '2024-06-06 20:48:45'),
(16, 0, 'purchase', 25, 'Deleted purchase ID: 25', '2024-06-06 20:48:48'),
(17, 0, 'purchase', 26, 'Deleted purchase ID: 26', '2024-06-06 20:48:52'),
(18, 0, 'purchase', 19, 'Deleted purchase ID: 19', '2024-06-07 09:53:12');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tour_id` int(11) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `number_of_people` int(11) DEFAULT NULL,
  `booking_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `confirmations`
--

CREATE TABLE `confirmations` (
  `confirmation_id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_types`
--

CREATE TABLE `holiday_types` (
  `type_id` int(11) NOT NULL,
  `holiday_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `holiday_types`
--

INSERT INTO `holiday_types` (`type_id`, `holiday_type`) VALUES
(12, 'Adults Only'),
(9, 'All Inclusive'),
(13, 'Big Resorts'),
(6, 'Budget'),
(2, 'Diving'),
(5, 'Family'),
(1, 'Honeymoon'),
(11, 'Laid Back'),
(10, 'Lifestyle'),
(3, 'Luxury'),
(7, 'Safari'),
(14, 'Small Resorts'),
(4, 'Spa'),
(8, 'Surfing');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `hotel_id` int(11) NOT NULL,
  `hotel_name` varchar(100) DEFAULT NULL,
  `hotel_location` varchar(100) DEFAULT NULL,
  `hotel_description` text DEFAULT NULL,
  `hotel_profile` text DEFAULT NULL,
  `hotel_rooms` int(11) DEFAULT NULL,
  `hotel_amenities` text DEFAULT NULL,
  `hotel_contact_info` varchar(100) DEFAULT NULL,
  `hotel_rank` int(11) DEFAULT NULL,
  `hotel_image` text DEFAULT NULL,
  `hotel_distance` int(11) NOT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`hotel_id`, `hotel_name`, `hotel_location`, `hotel_description`, `hotel_profile`, `hotel_rooms`, `hotel_amenities`, `hotel_contact_info`, `hotel_rank`, `hotel_image`, `hotel_distance`, `deleted`) VALUES
(1, 'Villa Nautica Maldives', 'K.Lankanfinolhu', 'Located in North Malé Atoll, just 20 minutes from Velana International Airport by speedboat. Villa Nautica celebrates the glitz and glamour of yacht-life and is always ‘en vogue’. Surrounded by sparkling lagoons and idyllic beaches, it is an island like no other: a hive of activity, a place to be seen. Complemented by exceptional scuba diving and other water sports, the resort embraces the seafarer lifestyle with a glamorous twist.', 'Best All Inclusive Resort', 284, 'Free internet\r\nPool\r\nFitness Center with Gym / Workout Room\r\nFree breakfast\r\nBeach\r\nBicycle rental\r\nBabysitting\r\nIndoor play area for children', '3316161', 1, 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/28/b5/b0/a1/main-pool.jpg?w=1000&h=-1&s=1', 13, 0),
(2, 'OBLU SELECT Lobigili', 'K. Lobigili', 'OBLU SELECT Lobigili is as enchanting as its sister property – OBLU SELECT Sangeli. Located just a few minutes from Malé International Airport, Lobigili is a contemporary resort, exclusively for adults! In the Maldivian language of Dhivehi, ‘Loabi’ means love and ‘Gili’ means island. Lobigili is, in essence, the island of love. Romance permeates the air here! Idyllic tropical vistas complemented by nature-inspired designs create a secluded, castaway feel. A perfect getaway for two.', 'Best for Honeymoon Couples & Luxury Travelers', 68, 'Free High Speed Internet (WiFi)\r\nPool\r\nFitness Center with Gym / Workout Room\r\nFree breakfast\r\nBeach\r\nDiving\r\nFree airport transportation\r\nBusiness Center with Internet Access', '4000066', 2, 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2b/c3/39/22/caption.jpg?w=1000&h=-1&s=1', 14, 0),
(3, 'Sun Siyam Iru Fushi', 'N.Medhafushi', 'Welcome to your 5 star home in the heart of the Maldives, where days are long and sun-filled in a setting you’ll never forget. With 15 bars and restaurants and a whole host of experiences on offer, at Sun Siyam Iru Fushi, no two days are ever the same.', 'Eco Friendly Hotel for Charming Holidays', 224, 'Free High Speed Internet (WiFi)\r\nPool\r\nFitness Center with Gym / Workout Room\r\nBar / lounge\r\nBeach\r\nBadminton\r\nBabysitting\r\nIndoor play area for children', '6560591', 3, 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1b/f4/56/f1/aerial-view.jpg?w=1000&h=-1&s=1', 201, 0),
(4, 'Sun Siyam Iru Veli', 'Dh.Aluvifushi', 'Sleek and spacious accommodations make Sun Siyam Iru Veli the ultimate tropical retreat. With front row lagoon views and a freshwater pool for every five star suite, all you have to do is check in, chill out and let our neighbouring dolphins provide your entertainment as they swim past each day.', NULL, 327, 'Free High Speed Internet (WiFi)\r\nPool\r\nFitness Center with Gym / Workout Room\r\nFree breakfast\r\nBeach\r\nBadminton\r\nBabysitting\r\nChildren Activities (Kid / Family Friendly)', '6760100', 4, 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/29/7c/95/78/overwater-villas.jpg?w=300&h=300&s=1', 180, 0),
(5, 'Emerald Maldives Resort & Spa', 'R.Fasmendhoo', 'Welcome to the Emerald Maldives, a new 5-star deluxe all-inclusive Resort and a proud member of The Leading Hotels of the World. Built to blend in perfect harmony with the surrounding environment.', NULL, 143, 'Free High Speed Internet (WiFi)\r\nPool\r\nFitness Center with Gym / Workout Room\r\nFree breakfast\r\nBeach\r\nBicycles available\r\nBabysitting\r\nChildren\'s playground', '6582100', 5, 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2c/28/5b/8d/aerial-view.jpg?w=300&h=300&s=1', 207, 0),
(6, 'Siyam World Maldives', 'N. Dhigurah', 'Siyam World Maldives is a striking new vision of the Maldives’ rich natural wonders, a carefree playground with an exciting, diverse, and endless array of ‘never-seen-before’ experiences to bask in - a WOW! Premium All-inclusive island getaway that crosses cultures and borders.', 'Best All Inclusive Resort', 530, 'Free High Speed Internet (WiFi)\r\nPool\r\nFitness Center with Gym / Workout Room\r\nFree breakfast\r\nBeach\r\nBadminton\r\nKids stay free\r\nBabysitting', '6567777', 6, 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1d/85/70/d6/lagoon-villa-with-pool.jpg?w=1200&h=-1&s=1', 174, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_holiday_types`
--

CREATE TABLE `hotel_holiday_types` (
  `hotel_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel_holiday_types`
--

INSERT INTO `hotel_holiday_types` (`hotel_id`, `type_id`) VALUES
(1, 5),
(1, 6),
(1, 9),
(1, 11),
(1, 13),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 9),
(2, 10),
(2, 12),
(2, 14),
(3, 1),
(3, 2),
(3, 5),
(3, 9),
(3, 10),
(3, 11),
(3, 14),
(4, 1),
(4, 3),
(4, 4),
(4, 5),
(4, 9),
(4, 14),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(5, 9),
(5, 10),
(5, 11),
(5, 14),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 9),
(6, 10),
(6, 11),
(6, 13);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_rooms`
--

CREATE TABLE `hotel_rooms` (
  `room_id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `room_type_id` int(11) DEFAULT NULL,
  `room_number` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'available',
  `room_price` decimal(10,2) NOT NULL,
  `room_capacity` int(11) DEFAULT NULL,
  `room_image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel_rooms`
--

INSERT INTO `hotel_rooms` (`room_id`, `hotel_id`, `room_type_id`, `room_number`, `status`, `room_price`, `room_capacity`, `room_image`) VALUES
(1, 1, 1, '325', 'reserved', 145.00, 2, 'https://ideogram.ai/assets/image/balanced/response/6RSGBAHkTTGqpehemsYZ6A'),
(2, 2, 1, '101', 'reserved', 745.00, 2, 'https://ideogram.ai/assets/image/balanced/response/Xht1FI8lRRCGg0dHfk1DHA'),
(3, 3, 3, '280', 'available', 293.00, 2, 'https://ideogram.ai/assets/image/lossless/response/YqhNmHRoR7yIfeMJ2ZW16Q'),
(4, 4, 4, '201', 'available', 399.00, 2, 'https://ideogram.ai/assets/image/balanced/response/olvAyBMmRJ2VCePdB01hOw'),
(5, 5, 6, '189', 'available', 601.00, 2, 'https://ideogram.ai/assets/image/balanced/response/XWKozdptS_qRjpic3bimnQ');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `reservation_id`, `user_id`, `payment_date`, `payment_amount`, `payment_method`) VALUES
(1, 4, 2, '2024-05-31 17:45:34', 4350.00, 'Credit Card'),
(18, 39, 2, '2024-06-07 06:53:51', 745.00, 'Credit Card (Dummy)');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `souvenir_id` int(11) DEFAULT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `purchase_quantity` int(11) DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`purchase_id`, `user_id`, `souvenir_id`, `purchase_date`, `purchase_quantity`, `purchase_price`, `is_deleted`) VALUES
(11, 2, 2, '2024-06-06 14:04:03', 1, 10.00, 1),
(12, 2, 2, '2024-06-06 17:19:52', 1, 10.00, 1),
(13, 2, 2, '2024-06-06 17:20:07', 1, 10.00, 1),
(14, 2, 2, '2024-06-06 17:20:29', 1, 10.00, 1),
(15, 2, 2, '2024-06-06 17:21:10', 1, 10.00, 1),
(16, 2, 2, '2024-06-06 17:21:36', 1, 10.00, 1),
(17, 2, 3, '2024-06-06 17:35:22', 1, 10.00, 1),
(18, 2, 3, '2024-06-06 17:38:10', 1, 10.00, 1),
(19, 2, 2, '2024-06-06 17:38:32', 1, 10.00, 1),
(20, 2, 2, '2024-06-06 17:43:40', 1, 10.00, 1),
(21, 2, 2, '2024-06-06 17:44:10', 1, 10.00, 1),
(22, 2, 2, '2024-06-06 17:44:52', 1, 10.00, 1),
(23, 2, 2, '2024-06-06 17:46:16', 1, 10.00, 1),
(24, 2, 2, '2024-06-06 17:46:29', 1, 10.00, 1),
(25, 2, 2, '2024-06-06 17:47:11', 1, 10.00, 1),
(26, 2, 2, '2024-06-06 17:48:06', 1, 10.00, 1),
(27, 2, 2, '2024-06-07 06:52:55', 1, 10.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `room_price` decimal(10,2) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `is_confirmed` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `days_of_stay` int(11) GENERATED ALWAYS AS (to_days(`check_out`) - to_days(`check_in`)) VIRTUAL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `room_id`, `room_price`, `user_id`, `check_in`, `check_out`, `total_price`, `is_confirmed`, `created_at`, `updated_at`, `is_deleted`) VALUES
(4, 1, 145.00, 2, '2024-05-01', '2024-05-30', 4205.00, 1, '2024-05-31 17:40:44', '2024-05-31 17:45:50', 0),
(39, 2, 745.00, 2, '0000-00-00', '2024-06-19', 4470.00, 0, '2024-06-07 09:53:50', '2024-06-07 09:53:50', 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(3, 'Guest'),
(2, 'Guide');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `room_type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`room_type_id`, `type_name`, `description`) VALUES
(1, 'Beach Villa', 'Villa on the Beach'),
(2, 'Overwater Villa', 'Villa over water'),
(3, 'Deluxe Beach Villa', 'Luxurious Beach Villa'),
(4, 'Beach Villa with Pool', 'Beach Villa with Pool'),
(5, 'Marina Garden Villa', 'Marina Garden Villa'),
(6, 'Marina Garden Villa with Pool', 'Marina Garden Villa');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `description`, `image`) VALUES
(1, 'Hotel Booking', 'Find the perfect accommodation for your trip', 'https://ideogram.ai/assets/image/lossless/response/DqbDRABoR8y6XCIYP7fRaQ'),
(2, 'Tour Packages', 'Explore personalized tour packages', 'https://ideogram.ai/assets/image/balanced/response/vvAjzm8dQzeaXcHrHRk5mQ'),
(3, 'Souvenir Shopping', 'Order souvenirs to be delivered to the airport', 'https://ideogram.ai/assets/image/balanced/response/7b1bP3OpTbeKqlISqs6TIg');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `chat_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `souvenirs`
--

CREATE TABLE `souvenirs` (
  `souvenir_id` int(11) NOT NULL,
  `sounvenir_name` varchar(100) DEFAULT NULL,
  `souvenir_description` text DEFAULT NULL,
  `souvenir_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL,
  `sounvenir_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `souvenirs`
--

INSERT INTO `souvenirs` (`souvenir_id`, `sounvenir_name`, `souvenir_description`, `souvenir_price`, `stock_quantity`, `sounvenir_image`) VALUES
(1, 'Turtle', 'handcrafted turtle magnetic', 2.00, 100, 'https://ideogram.ai/assets/image/balanced/response/ddMlrQFkRMC5s8n4BRVAsg'),
(2, 'Fish', 'handcrafted fish magnetic', 2.00, 100, 'https://ideogram.ai/assets/image/balanced/response/RTbd20jGTjCnV50Xehj9dg'),
(3, 'Pearl Necklace', 'jewelry pearl necklace', 100.00, 100, 'https://ideogram.ai/assets/image/lossless/response/lj5vb5g7Q_yBS4qVP6JHsw'),
(4, 'Glass Bottle', 'handcrafted glass bottle', 3.00, 100, 'https://ideogram.ai/assets/image/lossless/response/Z_FVLNwpSxSG9iQOxL6IGw'),
(5, 'Coral Piece', 'real coral piece pink', 200.00, 100, 'https://images.playground.com/02859c3456dd487c9badcc0130129b98.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `tour_id` int(11) NOT NULL,
  `tour_name` varchar(100) DEFAULT NULL,
  `tour_description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_first_name` varchar(50) DEFAULT NULL,
  `user_last_name` varchar(50) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_phone` varchar(20) DEFAULT NULL,
  `user_date_of_birth` date DEFAULT NULL,
  `user_registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_login` varchar(64) DEFAULT NULL,
  `user_password` varchar(128) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_first_name`, `user_last_name`, `user_email`, `user_phone`, `user_date_of_birth`, `user_registration_date`, `user_login`, `user_password`, `role_id`) VALUES
(1, 'admin', 'admin', 'admin@ufa.com', '7654321', '2000-01-01', '2024-05-30 12:26:27', 'admin', '$2y$10$IViRhDHoYq5RhP4PPH.FH.rZXICbDcGEAseLnh47kHmFTbn/bMM/y', 1),
(2, 'Zoe', 'Jones', 'zoejones@gmail.com', '+32 55 99 32 81 89', '1996-06-07', '2024-05-31 11:40:44', 'maybes', '$2y$10$nRq8RwU/STrkrdhwanJhg.NBDpHMj2F.xMK6V8nUwO763yNx24PbW', 3),
(3, 'Casper', 'Jolie', 'casperjolie@gmail.com', '+44 00809 705101', '1983-01-23', '2024-05-31 12:58:55', 'morbus', '$2y$10$tqPebNgVtv.7b9whhLfNp.DzaleWf28tuDnAuLIZm8GRGkIxWh8ma', 3),
(4, 'Kathy', 'Olsson', 'kathyolsson@gmail.com', '+1 (887) 559-1059', '2005-01-05', '2024-05-31 13:15:04', 'dennis', '$2y$10$IAax4V2XqQtPMt1ECEc0LuK.NQrxUTaK.S8JThiAiEj0DbySi9OXW', 3),
(5, 'Pete', 'Barker', 'petebarker@gmail.com', '+49 3988 55682149', '1999-01-07', '2024-05-31 13:18:07', 'modius', '$2y$10$IQtLAzuPM8WgmRA.X7Fr7.3hlD3XXfI5CrP6pqv5DmIINEhicbvjy', 3),
(6, 'Tommy', 'Blacksmith', 'tommyblacksmith@gmail.com', '+64 44 0192 0219', '2000-01-07', '2024-05-31 13:19:30', 'umbels', '$2y$10$Bi.95l2Gpdvlxv3257rbIufza..22JNkCKYAbnM/KzIs1Nn/n4NJC', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action_logs`
--
ALTER TABLE `action_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Indexes for table `confirmations`
--
ALTER TABLE `confirmations`
  ADD PRIMARY KEY (`confirmation_id`),
  ADD UNIQUE KEY `reservation_id` (`reservation_id`),
  ADD UNIQUE KEY `payment_id` (`payment_id`);

--
-- Indexes for table `holiday_types`
--
ALTER TABLE `holiday_types`
  ADD PRIMARY KEY (`type_id`),
  ADD UNIQUE KEY `holiday_type` (`holiday_type`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`hotel_id`);

--
-- Indexes for table `hotel_holiday_types`
--
ALTER TABLE `hotel_holiday_types`
  ADD PRIMARY KEY (`hotel_id`,`type_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `hotel_id` (`hotel_id`),
  ADD KEY `room_type_id` (`room_type_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `souvenir_id` (`souvenir_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`room_type_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `souvenirs`
--
ALTER TABLE `souvenirs`
  ADD PRIMARY KEY (`souvenir_id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`tour_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action_logs`
--
ALTER TABLE `action_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `confirmations`
--
ALTER TABLE `confirmations`
  MODIFY `confirmation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holiday_types`
--
ALTER TABLE `holiday_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `hotel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `room_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `souvenirs`
--
ALTER TABLE `souvenirs`
  MODIFY `souvenir_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`tour_id`);

--
-- Constraints for table `confirmations`
--
ALTER TABLE `confirmations`
  ADD CONSTRAINT `confirmations_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`reservation_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `confirmations_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hotel_holiday_types`
--
ALTER TABLE `hotel_holiday_types`
  ADD CONSTRAINT `hotel_holiday_types_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`),
  ADD CONSTRAINT `hotel_holiday_types_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `holiday_types` (`type_id`);

--
-- Constraints for table `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  ADD CONSTRAINT `hotel_rooms_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`),
  ADD CONSTRAINT `hotel_rooms_ibfk_2` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`room_type_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`reservation_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`souvenir_id`) REFERENCES `souvenirs` (`souvenir_id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `hotel_rooms` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
