-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2019 at 02:49 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hd_repair`
--

-- --------------------------------------------------------

--
-- Table structure for table `appusers`
--

CREATE TABLE `appusers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firebase_token` text COLLATE utf8mb4_unicode_ci,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appusers`
--

INSERT INTO `appusers` (`id`, `name`, `email_id`, `phone_number`, `firebase_token`, `gender`, `state`, `city`, `dob`, `image`, `delete_status`, `created_at`, `updated_at`) VALUES
(1, 'khan', 'khan@gmail.com', '867867867', '786tcyu7hbhk76rj765cfn6', 'male', 'Up', 'Gzb', '14/1/1995', 'public/user_images/_user1553334524.png', '1', '2019-03-23 00:00:00', '2019-03-23 00:00:00'),
(2, 'aamir', ' ', '98989898', '786tj876ym,976cfn6', ' ', ' ', ' ', ' ', ' ', '1', '2019-03-23 00:00:00', NULL),
(12, 'Pratham Vision', 'Vikash@prathamvision.com', '9873396412', 'e9j0watkyLY:APA91bE1_mro6LvGFyQp_3-SOzhNIAjOPv9pRLMo7rjG9IikXQ5QzUlR7B8iVxDB5BlMdiF6BaaBm-jRc-sfw7gT3J-4tw_b2touDhMiibdNFvsmR272J35asVZYvfTo8jOiDZskcJ-l', 'Female', 'Uttar Pradesh', 'Ghaziabad', '25/3/2019', 'public/user_images/_user1553599344.png', '1', '2019-03-25 00:00:00', '2019-03-26 00:00:00'),
(13, 'Vikash Prashar', 'vekain19@gmail.com', '+918700853187', 'eZZdxmZ8Bk0:APA91bGhHzbZIuT8QwSuTddhfySd0JnyMHKoX-K27bJyWvzo59bFYLYBryV5suPQDTCAX81iq2h-4yLBQyIwFo2nsFV8OLKrGjKUBFxAjzwjgEWmdnHNMz_tS1lQugS5DeXGlwkO-lNA', 'Male', 'Uttar Pradesh', 'Noida', '25/3/2019', 'public/user_images/_user1553673598.png', '1', '2019-03-25 00:00:00', '2019-03-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `app_banners`
--

CREATE TABLE `app_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0=yes,1=no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_type_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categories` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alternate_name` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` varchar(151) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `categories`, `alternate_name`, `images`, `delete_status`, `created_at`, `updated_at`) VALUES
(1, 'Auto Parts Repairc', 'Auto Parts Repair', NULL, '1', '2019-04-30 07:00:00', '2019-04-30 07:00:00'),
(2, 'Electronics', NULL, NULL, '1', '2019-04-30 07:00:00', '2019-04-30 07:00:00'),
(3, 'Water', NULL, NULL, '1', '2019-04-30 07:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `state_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_04_29_120909_create_sub_categories_table', 2),
(5, '2019_04_29_122511_create_app_banners_table', 3),
(6, '2019_04_30_063635_create_service_features_table', 4),
(7, '2019_04_30_083532_create_service_feature_types_table', 5),
(8, '2019_04_30_091717_cart', 6),
(9, '2019_05_02_104643_create_cities_table', 7),
(10, '2019_05_02_111202_create_states_table', 7),
(11, '2019_05_03_110712_create_service_providers_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referal_codes`
--

CREATE TABLE `referal_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redmeed_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0=yes, 1=no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_features`
--

CREATE TABLE `service_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` varchar(151) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcat_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0=yes,1=no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_features`
--

INSERT INTO `service_features` (`id`, `cat_id`, `subcat_id`, `service_type`, `delete_status`, `created_at`, `updated_at`) VALUES
(1, '3', '1', 'AC Service', '0', '2019-05-01 07:00:00', NULL),
(2, '3', '1', 'Ac Repair', '1', '2019-05-01 07:00:00', NULL),
(3, '3', '1', 'Installation/Uninstallation', '1', '2019-05-01 07:00:00', '2019-05-01 07:00:00'),
(4, '1', '1', 'Installation', '1', '2019-05-01 07:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_feature_types`
--

CREATE TABLE `service_feature_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_features_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0=yes,1=no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_feature_types`
--

INSERT INTO `service_feature_types` (`id`, `service_features_id`, `type`, `price`, `image`, `delete_status`, `created_at`, `updated_at`) VALUES
(1, '1', 'Window AC Service', '499', NULL, '0', '2019-05-01 07:00:00', NULL),
(2, '1', 'Split AC Service', '499', NULL, '1', '2019-05-01 07:00:00', NULL),
(3, '2', 'Window AC Repiar', '600', NULL, '1', '2019-05-01 07:00:00', NULL),
(4, '2', 'Split AC Repair', '65', NULL, '1', '2019-05-01 07:00:00', '2019-05-01 07:00:00'),
(5, '1', 'Window AC Installation/Uninstallation', '900', NULL, '0', '2019-05-01 07:00:00', '2019-05-01 07:00:00'),
(6, '3', 'Split AC Installation/Uninstallation', '890', NULL, '0', '0000-00-00 00:00:00', NULL),
(13, '3', 'Table', '3444', NULL, '0', '2019-05-01 07:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_providers`
--

CREATE TABLE `service_providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_cat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pin_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0=yes,1=no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_providers`
--

INSERT INTO `service_providers` (`id`, `cat`, `sub_cat`, `name`, `phone`, `address`, `district`, `state`, `pin_code`, `delete_status`, `created_at`, `updated_at`) VALUES
(1, 'House Fold', 'Ac', 'Daikin & Voltas AC Dealer in Noida Sector 10', '097111 18808', ' D-112, C Block, Sector 10', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(2, 'House Fold', 'Ac', 'Star Air Conditioning (AC Dealer in Noida Sec-18)', ' 097111 18808', ' BR-79, Sector-45, Noida', 'Noida', 'Uttar Pradesh', '201303', '1', '2019-05-04 07:00:00', NULL),
(3, 'House Fold', 'Ac', 'AC Service in Noida AC Repair in Noida', ' 092132 33558', 'shop no 15, Gali Number 1, near post office, Mamura, Sector 51', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(4, 'House Fold', 'Ac', 'LG Service Center Noida Washing Machine Microwave Refrigerator Ac Repair Noida', '087458 39081', 'Shop No. 3, Main Road Hoshiyar Pur, Sector - 51', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(5, 'House Fold', 'Ac', 'Malik AC on rent in Noida, Split window AC on Rent', '091931 27255', 'PF 17, TOT mall, Sector 62', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(6, 'House Fold', 'Ac', 'AC WORLD', '097110 09555', ' A2, A Block, Sector 58', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(7, 'House Fold', 'Ac', 'Kay Dee Electronics P5 Sector 18, Noida. AC, LED TV, ELECTRONICS SHOWROOM', ' 0120 431 1116', 'P5, Ocean Plaza, Opposite GIP Mall, Sector 18', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(8, 'House Fold', 'Ac', 'KP Car A/C', '098100 27011', 'Shop No. 2, Baisoya Complex, Nayabans, Sector 16', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(9, 'House Fold', 'Ac', 'Samsung & Lg Service Center In Noida, AC Washing Machine Repair, Microwave', ' 096436 61370', ' near, shop no 6 noida block a market sec 50, Sector 41', 'Noida', 'Uttar Pradesh', '201307', '1', '2019-05-04 07:00:00', NULL),
(10, 'House Fold', 'Ac', 'AC service in Noida, AC installation, AC repair in Noida', ' 099997 15777', ' ESI Road, Hospital Marg, Chaura Raghunathpur, Sector 22', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(11, 'House Hold', 'Ac', 'AC service in Noida, AC installation, AC repair in Noida', ' 070118 22858', ' Bishanpura Rd, Deepak Vihar, Shital Vihar, Khora Colony, Sector 53', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(12, 'House Hold', 'Ac', 'M.D Khan A/C Car', ' 098915 38325', 'Shop No. B-111, Captain Vijyant Thapar Marg, Naya Bans Noida, Sector-16 ', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(13, 'House Hold', 'Ac', 'VOLTAS AC SERVICE CENTRE IN NOIDA', '081469 39319', ' C-37, Industrial Area, Block C, Sector 57', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(14, 'House Hold', 'Ac', 'Ac Repair Shop Noida', ' 097179 80764', 'Ambey Air Conditioner', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(15, 'House Hold', 'Ac', 'Noida AC Service AC Repair AC Installation in Noida', '070114 31245', 'Hospital Marg, Chaura Raghunathpur, Raghunathpur, Sector 22', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(16, 'House Hold', 'Ac', 'kiran Air Conditioner- AC Repair noida, washing machine repiar ,geyser repiar ', ' 081308 39596', 'shop no. 259 near sai mandir, F Block, Sector 40', 'Noida', 'Uttar Pradesh', '201303', '1', '2019-05-04 07:00:00', NULL),
(17, 'House Hold', 'Ac', 'LG, SAMSUNG, VIDEOCON, ONIDA,IFB,ELECTROLUX ,REPAIR,SERVICE CENTRE', '070652 06743', 'Shop No-08, Ground Floor, Amrapali Shopping Arcade,, Noida Sector-45', 'Noida', 'Uttar Pradesh', ' 201303', '1', '2019-05-04 07:00:00', NULL),
(18, 'House Hold', 'Ac', 'Daiken AC Service Center Noida', ' 070652 06796', ' Shop No.6 Plot No.1205, Gali Number 7, Mamura, Sector 66', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(19, 'House Hold', 'Ac', 'Alif AC', ' 070421 21052', '21-A, Rajput Colony, Hindon Vihar, Baraula, Sector 49', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(20, 'House Hold', 'Ac', 'Panasonic Service Center - Home Appliances Repair Service - Ac Repair & Service ', ' 084271 75664', 'Hospital, A-9, 10 & 11, First Floor, Dharampali Place, Bhoja Market ', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(21, 'House Hold', 'Ac', 'AC Repairing In Noida', ' 098184 73764', ' Windsor Greens, F-28, F Block, Sector 50', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(22, 'House Hold', 'Ac', 'Ifb Ac Repair Service Center', '087458 39092', 'Shop No - 51, Sadrapur Chhlera, Sector - 44, Opp. Sector - 37', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(23, 'House Hold', 'Ac', 'AC service in Noida, AC repairing, AC installation in Noida', '084334 59569', ' Chhijarsi, Sector 63', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(24, 'House Hold', 'Ac', 'Voltas AC Service Center Noida', '098219 91093', ' Shop No. 1050/5 Near Bartan Market, Harola, Sector 5', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(25, 'House Hold', 'Ac', 'AC repair service in Noida', ' 084334 59569', ' Near red light, Hoshiyarpur, Hoshiarpur Village, Sector 51', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(26, 'House Hold', 'Ac', 'Gujraj Aircon Limited', '0120 422 8388', ' D-161,I-Area, Lohia Rd, A Block, Sector 63', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(27, 'House Hold', 'Ac', 'Ogeneral Service Center Noida', ' 070657 19210', 'Shop No.95/1 Near HDFC Bank ATM Hajipur, Sector 104', 'Noida', 'Uttar Pradesh', ' 201304', '1', '2019-05-04 07:00:00', NULL),
(28, 'House Hold', 'Ac', 'Ambey Electricals Repair Shop', '095604 78285', 'Shop 10, Village Gejha, Noida Sector 93', 'Noida', 'Uttar Pradesh', ' 201304', '1', '2019-05-04 07:00:00', NULL),
(29, 'House Hold', 'Ac', 'Care & Repair India', '0120 491 2466', ' B-9A Green Boulevard Sector -62', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(30, 'House Hold', 'Ac', 'AC repair service Gaur city Noida extension', ' 091931 27255', 'Eteda near Gaur city, Noida Extension', 'Noida', 'Uttar Pradesh', '201305', '1', '2019-05-04 07:00:00', NULL),
(31, 'House Hold', 'Ac', 'Classic Air Conditioner', ' 098114 09935', 'Shop No. 5, Near E. S. I Hospital, Hospital Marg, Block C, Sector 22, ', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(32, 'House Hold', 'Ac', 'Voltas Ac Service Center In Noida', ' 086501 79294', ' M-96, Street Number 3, Gautam Budh Nagar, Shramik Kunj, Sector 66', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(33, 'House Hold', 'Ac', 'Rahul Air Conditioning Service', '099713 75442', 'Shop No-6, Near E-221, Indira Market, Sector 27', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(34, 'House Hold', 'Ac', 'Malik AC on rent in Noida, Split window AC on Rent', ' 091931 27255', 'PF 17, TOT mall, Sector 62', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(35, 'House Hold', 'Ac', 'True Cool Engineers', ' 0120 413 7135', ' floor a, G-30 First, 9, Bishanpura Rd, Sector 58', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(36, 'House Hold', 'Ac', 'Air Command Engineers', ' 098913 71009', 'D-84, D Block, Sector 10', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(37, 'House Hold', 'Ac', 'Hitachi Air Conditioner- Home Split & Window Ac Service , Ac Repair In Noida', ' 084271 76898', 'Near Canara Bank, Water Tank 43 Road, Sector-45', 'Noida', 'Uttar Pradesh', '201303', '1', '2019-05-04 07:00:00', NULL),
(38, 'House Hold', 'Ac', 'Guru Kripa (Best AC Repair Service In Noida/AC Installation shop in Noida/Water Cooler repair)', ' 099116 03663', 'Village Chhalera & Sadarpur, Sadarpur, Sector-45', 'Noida', 'Uttar Pradesh', '201303', '1', '2019-05-04 07:00:00', NULL),
(39, 'House Hold', 'Ac', 'Hitech Service', '099711 81001', 'Bharat Petroleum Petrol Pump, Golf Marg, Morna, Sector 35', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(40, 'House Hold', 'Ac', 'Voltas Ac Service Center In Noida', ' 086501 79294', 'M-96, Street Number 3, Gautam Budh Nagar, Shramik Kunj, Sector 66', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(41, 'House Hold', 'Ac', 'Rahul Air Conditioning Service', '099713 75442', ' Shop No-6, Near E-221, Indira Market, Sector 27', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(42, 'House Hold', 'Ac', 'Malik AC on rent in Noida, Split window AC on Rent', ' 091931 27255', 'PF 17, TOT mall, Sector 62, Noida', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(43, 'House Hold', 'Ac', 'True Cool Engineers', ' 0120 413 7135', 'floor a, G-30 First, 9, Bishanpura Rd, Sector 58', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(44, 'House Hold', 'Ac', 'Purvanchal Air Conditioner- AC Repair noida, washing machine repiar ,geyser repiar ,microware repiar', ' 081308 39596', 'shop no- 259, Near Sai Mandir, F Block, Sector 40', 'Noida', 'Uttar Pradesh', '201303', '1', '2019-05-04 07:00:00', NULL),
(45, 'House Hold', 'Ac', 'Lg Voltas Whirlpool Hitachi AC Service And Installation', ' 097173 50308', 'Sarfabad Village, Sarfabad, Sector 73', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(46, 'House Hold', 'Ac', 'AC Repair in Noida', ' 099106 85343', 'Shop No 1, Near Glued & Theo\'s, Aghapur', 'Noida', 'Uttar Pradesh', '201303', '1', '2019-05-04 07:00:00', NULL),
(47, 'House Hold', 'Ac', 'AC Service Centre lg , Samsung, Voltas, Daikin, Hitachi, Panasonic, Sharp', '097110 14444', 'PS Market, Block F, Sector 51', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(48, 'House Hold', 'Ac', 'Bablu & Co | Best AC Repair/Service center in Noida/sector 62/Greater Noida', ' 075628 62008', 'Sector 9, C 61', 'Noida', 'Uttar Pradesh', '201301', '1', '2019-05-04 07:00:00', NULL),
(49, 'House Hold', 'Ac', 'Baba Air Conditioner Work Shop', '098915 69786', ' Luv Kush Market, Gali Number 9, Hoshiyarpur, Sector 51', 'Noida', 'Uttar Pradesh', '201304', '1', '2019-05-04 07:00:00', NULL),
(50, 'House Hold', 'Ac', 'Godrej Service Center Noida', ' 089298 55019', 'Kiosk No.9 Plot No.8 Gardenia Golf City, Sector 75', 'Noida', 'Uttar Pradesh', '201305', '1', '2019-05-04 07:00:00', NULL),
(51, 'Auto Parts Repairc', 'CAR', 'archit attre', '956808326', 'kjh', 'hapur', NULL, '245304', '0', '2019-05-04 07:00:00', '2019-05-04 07:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` varchar(151) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0=yes,1=no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `cat_id`, `sub_category`, `images`, `delete_status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'CAR', NULL, '1', '2019-05-01 07:00:00', NULL),
(2, '3', 'Bus', NULL, '0', '2019-05-01 07:00:00', '2019-05-01 07:00:00'),
(3, '1', NULL, NULL, '1', '2019-05-01 07:00:00', NULL),
(4, '1', NULL, NULL, '1', '2019-05-01 07:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=admin,2=user,3=super_admin',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'HD REPAIR', 'hdrepair@gmail.com', '1', NULL, '$2y$10$6Ejvbv58eE9t0mqfohOIuu8b.imx4PxobuG1bfxHjd4NZEDtK1VXC', NULL, '2019-04-29 17:23:09', '2019-04-29 17:23:09'),
(2, 'HD REPAIR SUPER', 'architattrey@gmail.com', '1', NULL, '$2y$10$ersXa2TVRXT5VPNy4UiW.e.aggUGxJdHe4EU/CNzC1PQ5eHjY3J5q', NULL, '2019-05-02 17:17:34', '2019-05-02 17:17:34');

-- --------------------------------------------------------

--
-- Table structure for table `users_delivery_addresses`
--

CREATE TABLE `users_delivery_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dlvry_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(151) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(151) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_feedbacks`
--

CREATE TABLE `users_feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `feedbacks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_feedbacks`
--

INSERT INTO `users_feedbacks` (`id`, `user_id`, `transaction_id`, `feedbacks`, `created_at`, `updated_at`) VALUES
(1, '13', '1', 'Sometimes a situation arises where we want to exit from a loop immediately without waiting to get back to the conditional statement.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_transactions`
--

CREATE TABLE `user_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_provider_id` varchar(151) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_type_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dlvry_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(151) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(151) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dlvry_status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0=placed,1=success, 2=cancelled ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_transactions`
--

INSERT INTO `user_transactions` (`id`, `order_id`, `user_id`, `service_provider_id`, `service_type_id`, `invoice_id`, `amount`, `phone_number`, `dlvry_address`, `lat`, `lng`, `dlvry_status`, `created_at`, `updated_at`) VALUES
(1, '1233434', '13', '1', '[\"1\",\"2\",\"3\"]', NULL, '5670', '', '', '', '', '0', '2019-04-01 07:00:00', NULL),
(2, '1233434', '13', '1', '[\"1\",\"2\",\"3\"]', NULL, '5670', '', '', '', '', '0', '2019-04-01 07:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redmeed_id` varchar(151) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_type` enum('credit','debit') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'credit, debit',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appusers`
--
ALTER TABLE `appusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_banners`
--
ALTER TABLE `app_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `referal_codes`
--
ALTER TABLE `referal_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_features`
--
ALTER TABLE `service_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_feature_types`
--
ALTER TABLE `service_feature_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_providers`
--
ALTER TABLE `service_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_delivery_addresses`
--
ALTER TABLE `users_delivery_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_feedbacks`
--
ALTER TABLE `users_feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_transactions`
--
ALTER TABLE `user_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appusers`
--
ALTER TABLE `appusers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `app_banners`
--
ALTER TABLE `app_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `referal_codes`
--
ALTER TABLE `referal_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_features`
--
ALTER TABLE `service_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service_feature_types`
--
ALTER TABLE `service_feature_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `service_providers`
--
ALTER TABLE `service_providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_delivery_addresses`
--
ALTER TABLE `users_delivery_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_feedbacks`
--
ALTER TABLE `users_feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_transactions`
--
ALTER TABLE `user_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
