-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2025 at 07:52 AM
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
-- Database: `e_commerce_artist`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(3) NOT NULL,
  `admin_name` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `email`, `password`) VALUES
(1, 'Dhixers', 'dhian@gmail.com', '4be50395d33814a1d29bce9ec1328e53'),
(2, 'Jennikles', 'jennifer@gmail.com', '8b6457fcd2e073efd88a4717eb5945d2'),
(3, 'Junets', 'junets@gmail.com', '4e1747b7457f08442e650894107f6157');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `artist_id` int(10) UNSIGNED NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `display_image` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `bio` text DEFAULT NULL,
  `joined_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`artist_id`, `display_name`, `display_image`, `email`, `bio`, `joined_at`) VALUES
(1, 'Jennikles', 'Jamie.png', 'jentoastmilque@gmail.com', 'Hi!! Let\'s get along! Come take a look at my things!', '2025-04-24 14:19:40'),
(2, 'Junets', 'Venturine.png', 'junets@gmail.com', 'Love writing, take a look if you\'re interest in fantasy!!', '2025-04-29 14:20:38'),
(3, 'Juniper', 'wirly.png', 'juniper@gmail.com', 'Passionate in making cute jewelry, please check them out if you\'re curious!', '2025-05-05 15:12:01'),
(7, 'Jennifer', 'aya.jpg', 'jenniferbbb@gmail.com', 'Hello, this is Jennifer! Let\'s get along!!', '2025-06-30 06:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(2) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `email`, `message`) VALUES
(1, 'dhian@gmail.com', 'Keren banget deh produknya hehe'),
(2, 'jimmy@gmail.com', 'Mau nanya soal produk ini, ada berapa ya sisa inventory nya?'),
(3, 'jennifer@gmail.com', 'Maaf, aku lupa password aku, tolonggg'),
(4, 'steven@gmail.com', 'Boleh tambahin produk nya dong kapan2 ye'),
(5, 'veranica@gmail.com', 'really cool ^^ keep it up <3'),
(6, 'veranica@gmail.com', 'halo mo nanya stok nya masi ada kan ya?'),
(7, 'dhian@gmail.com', 'Produk ini kapan restock ya?'),
(8, 'eric@gmail.com', 'Hello, I think this is a good website'),
(13, 'jenniferbbb@gmail.com', 'Hello, this is nice thanks!');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `postcode` int(10) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `full_name`, `email`, `phone`, `created_at`, `address`, `postcode`, `password`) VALUES
(1, 'Putri', 'putri@gmail.com', '087882934023', '2025-05-21 14:23:49', 'Jl. Tanjung Duren Raya No.4, RT.12/RW.2, Tj. Duren Utara, Kec. Grogol petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta', 11470, '4be50395d33814a1d29bce9ec1328e53'),
(2, 'Febri', 'febri@gmail.com', '87664934023', '2025-04-30 14:24:10', 'Jl. Tanjung Duren Raya No.4, RT.12/RW.2, Tj. Duren Utara, Kec. Grogol petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta', 11470, 'fb9ab3c02b10f878e9f494a86b076d90'),
(3, 'Wilfred', 'wilfred@gmail.com', '87882934023', '2025-06-17 14:24:18', 'Jl. Tanjung Duren Raya No.4, RT.12/RW.2, Tj. Duren Utara, Kec. Grogol petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta', 11470, 'a51611e015d71e4017d6c3d33e7ae3bd'),
(4, 'Eric', 'eric@gmail.com', '08978394192', '2025-05-04 10:08:33', 'Jl. Tanjung Duren Raya No.4, RT.12/RW.2, Tj. Duren Utara, Kec. Grogol petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta', 11470, '16f71e705653b0e381a0ba4a31582bc6'),
(5, 'Jennifer', 'jennifer@gmail.com', NULL, '2025-05-31 22:15:36', NULL, NULL, 'c6f7c372641dd25e0fddf0215375561f'),
(6, 'Steven', 'steven@gmail.com', '08970459981993', '2025-05-31 22:18:27', 'Jl. Tanjung Duren Raya No.4, RT.12/RW.2, Tj. Duren Utara, Kec. Grogol petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta', 11470, 'b0c8def6a47a858fe5f1d170d4a321b7'),
(8, 'Jimmy', 'jimmy@gmail.com', '08788294311', '2025-05-31 22:26:07', 'Tanjung Duren', 11470, '0f8f94a2fd915c12ca295b4921d69ce7'),
(9, 'Jennifer', 'jen@gmail.com', NULL, '2025-06-01 16:47:01', NULL, NULL, '499dbb300fbf229d0c9275216a0535ae'),
(11, 'Jentini', 'jentini@gmail.com', NULL, '2025-06-08 08:53:15', NULL, NULL, 'e64227086ef585b501f4f4d304daed49'),
(12, 'June', 'june@gmail.com', '087882944311', '2025-06-29 22:14:52', 'Jakarta', 11000, 'a3504ce3a21476e10c02b725dfba6381'),
(13, 'Banei', 'banei@gmail.com', '087882944311', '2025-06-29 22:31:32', 'Jakarta', 11000, 'a3504ce3a21476e10c02b725dfba6381'),
(15, 'Jean', 'jean@gmail.com', '087882944311', '2025-06-30 11:13:50', 'Jakarta', 11000, 'a3504ce3a21476e10c02b725dfba6381'),
(16, 'Jule', 'jule@gmail.com', '087882944311', '2025-06-30 11:47:53', 'Jakarta', 11000, 'a3504ce3a21476e10c02b725dfba6381');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id_news` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `admin_id` int(10) NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id_news`, `title`, `image`, `content`, `admin_id`, `date_updated`) VALUES
(1, 'Timun Mas Adventures', 'timunnn.png', 'Timun Mas Adventures\n\nThis game is based on a classic Indonesian fairy tale, Timun Mas. This fairy tale from Central Java tells the story of a brave girl named Timun Mas who must escape from being chased by a giant who wants to eat her. \n\nIn this game, players will play as Timun Mas and go on an adventure to protect herself from the threat of the giant. This game is designed to introduce classic Indonesian fairy tales to the younger generation in an interactive and fun way, while also carrying local wisdom values ​​such as courage, ingenuity, and fighting spirit. \n\nIn the midst of this modern era, the interest of the younger generation in local fairy tales has begun to decline due to the influence of foreign popular culture which is more dominant. Therefore, this game aims to utilize technology as a medium for cultural preservation, by introducing local culture and providing insight to the younger generation about the richness of Indonesian fairy tales, especially the story of Timun Mas. \n\nIn addition, this game also functions as an interactive educational media by including game mechanics such as computing, as well as training logical thinking skills and numeracy skills. Through this game, it is hoped that the younger generation will not only get entertainment, but also useful learning.\n\nThus, they can get to know, love, and appreciate the richness of Indonesian culture!\n\nUse the link below to become a beta-tester for the newest release of Timun Mas Adventures and leave a comment on PC!\nhttps://www.greenfoot.org/scenarios/34235', 2, '2025-06-03 16:59:59'),
(2, 'Don\'t Look Down', 'Magister.jpg', '\"Kahili had always loved the cliffs for as long as she could remember, raptly staring at the sharp cutoff of the edge with fascination and how there always seemed to be streaks of color along the cliff walls.\r\n\r\nNow she just felt contemplative, tracing the way those colors painted the cliffs with streaks of color. It no longer gave her the peace of mind, only the cold truth that nothing will ever be the same again..\"\r\n\r\nThat is an excerpt from my latest novel named \'Don\'t Look Down\', please look forward to the release next month!\r\n\r\nUse this link to enter the pre-order for this novel!\r\nhttps://forms.gle/EBNTpFB2G3NeC8TX9', 2, '2025-06-03 18:14:53'),
(3, 'Subscribe to Our Weekly Newsletter', 'timunmas.png', 'Weekly Newsletters is a way to stay up-to-date with our artists! \r\n\r\nGet the benefits here:\r\n- Get to know our process\r\n- Be the first to know of new product launches\r\n- Any coupons for purchase\r\n\r\nJoin our newsletter using this link!\r\nhttps://forms.gle/U8gA5Nr24cpoVfYy6', 1, '2025-06-04 22:46:06'),
(4, 'Melody - Coming Your Way!', 'melody.jpg', 'Say hello to Melody, the newest music player app designed to bring your favorite tunes to life! With a sleek interface, smart playlists, and seamless streaming, Melody makes listening effortless and enjoyable. Whether you\'re chilling, working out, or on the go — Melody sets the perfect soundtrack for every moment.\r\n\r\nStay tuned for the release this coming summer!!', 1, '2025-06-08 21:10:44');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `status` enum('Pending','Paid','Shipped','Completed','Cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `status`) VALUES
(1, 1, 'Completed'),
(2, 2, 'Paid'),
(3, 3, 'Pending'),
(4, 6, 'Shipped'),
(5, 9, 'Pending'),
(6, 4, 'Pending'),
(7, 8, 'Pending'),
(8, 1, 'Paid'),
(9, 8, 'Paid'),
(10, 1, 'Pending'),
(11, 2, 'Pending'),
(12, 3, 'Completed'),
(13, 1, 'Pending'),
(14, 12, 'Cancelled'),
(15, 13, 'Pending'),
(16, 13, 'Cancelled'),
(17, 15, 'Cancelled'),
(18, 15, 'Paid'),
(19, 1, 'Pending'),
(20, 12, 'Cancelled'),
(21, 15, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `data_order` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `subtotal`, `data_order`) VALUES
(3, 3, 1, 1, 30.00, '2025-04-25'),
(6, 5, 1, 1, 0.00, '2025-06-01'),
(7, 5, 8, 1, 0.00, '2025-06-01'),
(8, 6, 7, 1, 0.00, '2025-06-01'),
(9, 6, 6, 1, 0.00, '2025-06-01'),
(10, 7, 6, 1, 0.00, '2025-06-01'),
(11, 7, 7, 1, 0.00, '2025-06-01'),
(12, 4, 1, 2, 0.00, '2025-06-01'),
(13, 4, 9, 1, 0.00, '2025-06-01'),
(16, 9, 1, 1, 0.00, '2025-06-07'),
(17, 9, 2, 1, 0.00, '2025-06-07'),
(18, 8, 1, 1, 0.00, '2025-06-07'),
(19, 8, 2, 1, 0.00, '2025-06-07'),
(21, 1, 2, 2, 0.00, '2025-04-23'),
(24, 10, 1, 3, 0.00, '2025-06-08'),
(25, 10, 2, 1, 0.00, '2025-06-08'),
(26, 11, 6, 1, 0.00, '2025-06-08'),
(27, 11, 9, 1, 0.00, '2025-06-08'),
(28, 2, 3, 1, 0.00, '2025-04-24'),
(29, 12, 2, 2, 0.00, '2025-06-09'),
(30, 12, 9, 1, 0.00, '2025-06-09'),
(51, 16, 3, 1, 0.00, '2025-06-30'),
(52, 16, 5, 1, 0.00, '2025-06-30'),
(53, 16, 6, 1, 0.00, '2025-06-30'),
(58, 17, 1, 2, 0.00, '2025-06-30'),
(59, 17, 2, 1, 0.00, '2025-06-30'),
(60, 17, 3, 1, 0.00, '2025-06-30'),
(61, 17, 7, 2, 0.00, '2025-06-30'),
(62, 18, 10, 1, 0.00, '2025-06-30'),
(63, 18, 8, 1, 0.00, '2025-06-30'),
(64, 19, 1, 1, 0.00, '2025-06-30'),
(65, 19, 2, 1, 0.00, '2025-06-30'),
(70, 20, 1, 1, 0.00, '2025-06-30'),
(71, 20, 2, 2, 0.00, '2025-06-30'),
(72, 20, 3, 1, 0.00, '2025-06-30'),
(73, 20, 5, 1, 0.00, '2025-06-30'),
(74, 21, 6, 2, 0.00, '2025-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `artist_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `category` enum('Art Print','Novel','Photocard','Keychain','Jewelry') NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_desc` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_qty` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `artist_id`, `title`, `category`, `product_image`, `product_desc`, `price`, `stock_qty`, `created_at`) VALUES
(1, 1, 'Firefly Keychain', 'Keychain', 'firefly.png', 'An acrylic keychain of Firefly from Honkai Star Rail', 30.00, 16, '2025-04-25 14:35:55'),
(2, 1, 'Cheesecake Dog Keychain', 'Keychain', 'doggo.png', 'An acrylic keychain of a cheesecake themed Pomeranian', 25.00, 8, '2025-04-25 14:36:06'),
(3, 2, 'Don\'t Look Down', 'Novel', 'Magister.jpg', 'A thrilling Fantasy story about a girl finding herself', 50.00, 44, '2025-04-25 14:36:13'),
(4, 1, 'Jade Keychain', 'Keychain', 'jade.png', 'An acrylic keychain of Jade from Honkai Star Rail', 30.00, 19, '0000-00-00 00:00:00'),
(5, 1, 'Dan Heng Photocard', 'Photocard', 'danheng.png', 'Full Color 2.5 x 3.5 inches 300 gsm Watercolor Paper', 8.00, 27, '0000-00-00 00:00:00'),
(6, 2, 'Thawing a Frozen Heart', 'Novel', 'vibrant.png', 'A thrilling Fantasy story about two brothers reconciling', 50.00, 16, '0000-00-00 00:00:00'),
(7, 3, 'Aventurine Candy', 'Jewelry', 'gelang1.jpg', 'An elastic string bracelet made out of real Aventurine stone and colorful beads', 25.00, 13, '0000-00-00 00:00:00'),
(8, 3, 'Cherry Candy', 'Jewelry', 'kalung1.jpg', 'A braided thread necklace made out of real seashell, gold plated accessory, and colorful beads', 20.00, 4, '0000-00-00 00:00:00'),
(9, 3, 'Cotton Candy', 'Jewelry', 'gelang 2.jpg', 'An elastic string bracelet made out of cotton candy colored beads', 8.00, 3, '0000-00-00 00:00:00'),
(10, 1, 'Kiyotaka Art Print', 'Art Print', 'aya.jpg', 'Full Color A4 inches 300 gsm Watercolor Paper', 20.00, 38, '2025-06-09 04:53:35'),
(11, 2, 'When I Fall in Love', 'Novel', 'kyoshi.jpg', 'A special day for a special someone..', 55.00, 50, '2025-06-09 06:13:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`artist_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id_news`),
  ADD KEY `fk_admin_id` (`admin_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_orders_customer` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `fk_items_order` (`order_id`),
  ADD KEY `fk_items_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_products_artist` (`artist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `artist_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id_news` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_admin_id` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_artist` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
