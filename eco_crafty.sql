-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2025 at 03:22 PM
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
-- Database: `eco_crafty`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(13, NULL, 7, 1, '2025-06-20 14:16:15'),
(14, NULL, 4, 1, '2025-06-20 14:16:36'),
(48, 5, 27, 1, '2025-06-22 07:59:35');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'Jewellery'),
(2, 'Bags'),
(3, 'Decor'),
(4, 'Baskets'),
(5, 'Stationery'),
(6, 'Paintings'),
(7, 'Crochets');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('pending','confirmed','shipped','delivered') DEFAULT 'pending',
  `ordered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `address`, `status`, `ordered_at`) VALUES
(14, 1, 29, 2, 'Palakollu,West godavari', 'pending', '2025-08-03 07:53:01'),
(15, 1, 14, 1, 'Palakollu,West godavari', 'pending', '2025-08-03 07:53:01'),
(16, 1, 10, 1, 'Palakollu,West godavari', 'pending', '2025-08-03 07:53:01'),
(17, 6, 11, 2, 'Palakollu,West godavari', 'pending', '2025-08-03 07:59:28'),
(18, 6, 19, 1, 'Palakollu,West godavari', 'pending', '2025-08-03 07:59:28'),
(19, 6, 20, 1, 'Palakollu,West godavari', 'pending', '2025-08-03 07:59:28'),
(21, 7, 20, 2, 'Palakollu,West godavari', 'pending', '2025-08-03 08:14:29');

-- --------------------------------------------------------

--
-- Table structure for table `pending_products`
--

CREATE TABLE `pending_products` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_name`, `price`, `description`, `image`, `seller_id`, `created_at`, `quantity`) VALUES
(1, 'Handmade Necklace', 'Jewellery', 299.00, 'Eco-friendly and Handmade necklace with colourful stones', 'images/jewellery.jpg', 1, '2025-06-18 06:33:44', 10),
(2, 'Thread Chain with Earings', 'Jewellery', 199.00, ' Handmade Thread chain along with beautiful earings', 'images/j1jpg.jpg', 1, '2025-06-18 06:38:29', 14),
(3, 'Wooden Elephant', 'Decor', 349.00, ' Handmade and eco friendly wooden elephant toy ', 'images/d1.jpg', 1, '2025-06-18 07:04:19', 20),
(4, 'Wooden Dol', 'Decor', 149.00, ' Handmade wooden  toy  for decor', 'images/d2.jpg', 1, '2025-06-18 07:22:30', 40),
(5, 'Anklet Set', 'Jewellery', 159.00, 'Anklet set with beads', 'images/anklet.jpg', 1, '2025-06-19 09:07:24', 50),
(6, 'Book Mark', 'Crochet', 249.00, 'Crochet book mark', 'images/crochet-bookmark.jpg', 1, '2025-06-19 09:07:24', 13),
(7, 'Desk Organizer', 'Decor', 359.00, 'Wooden desk organizer for pens ', 'images/desk-organizer.jpg', 1, '2025-06-19 09:15:32', 25),
(8, 'Jute Basket', 'Baskets', 249.00, 'Basket for cloths ', 'images/jute-basket.jpg', 1, '2025-06-19 09:15:32', 45),
(9, 'Bamboo Wind Chime', 'Decor', 299.00, 'Bamboo wind chime', 'images/wind-chime.jpg', 1, '2025-06-20 10:44:58', 12),
(10, 'Wollen Wall Hanging', 'Decor', 159.00, 'Wollen wall hanfing craft ', 'images/wall-hanging.jpg', 1, '2025-06-20 10:44:58', 35),
(11, 'Decorative Wooden Lantern', 'Decor', 299.00, 'Decorative wooden lantern', 'images/lantern.jpg', 1, '2025-06-20 10:44:58', 12),
(12, 'Wooden Candle Holder', 'Decor', 129.00, 'wooden candle holder', 'images/candle-holder.jpg', 1, '2025-06-20 10:44:58', 45),
(13, 'Painting', 'Paintings', 129.00, 'beatiful wall painting', 'images/abstract.jpg', 2, '2025-06-20 17:31:00', 98),
(14, 'Mini Elephant', 'Crochet', 399.00, 'Mini elephant crochet toy', 'images/amigurumi.jpg', 2, '2025-06-20 17:31:00', 15),
(15, 'Mini Handbags ', 'Bags', 149.00, 'Cloth and eco friendly mini hand bags', 'images/bags.jpg', 2, '2025-06-20 17:31:00', 50),
(16, 'Wooden ruler', 'Stationary', 69.00, 'bamboo scale for kids', 'images/bamboo-ruler.jpg', 2, '2025-06-20 17:31:00', 30),
(17, 'Basket', 'Basket', 119.00, 'mini basket ', 'images/baskets.jpg', 2, '2025-06-20 17:31:00', 20),
(18, 'Flowers Painting', 'Paintings', 299.00, 'colourful flowers painting for wall', 'images/botanical.jpg', 2, '2025-06-20 17:31:00', 10),
(19, 'Beads Bracelet ', 'Jewellery', 49.00, 'blue colour beads bracelet', 'images/bracelet.jpg', 2, '2025-06-20 17:31:00', 29),
(20, 'Brooch', 'Crochet', 99.00, 'Brooch crochet art', 'images/brooch.jpg', 2, '2025-06-20 17:31:00', 39),
(21, 'Crochet hand bag', 'Crochet', 299.00, 'Crochet art mini hand bag for ladies', 'images/c1.jpg', 2, '2025-06-20 17:31:00', 25),
(22, 'Blue Crochet bag', 'Crochet', 499.00, 'crochet handbag', 'images/crochet-bag.jpg', 2, '2025-06-20 17:31:00', 15),
(23, 'Cloth bag ', 'Bags', 129.00, 'Cloth and eco friendly mini hand bags', 'images/canvas-tote.jpg', 2, '2025-06-20 17:31:00', 89),
(24, 'Doll', 'Crochet', 189.00, 'crochet doll for kids', 'images/crochet-doll.jpg', 2, '2025-06-20 17:31:00', 25),
(25, 'Crochet Flower vase', 'Crochet', 499.00, 'Sunflower theme crochet flower vase', 'images/crochet-flowers.jpg', 1, '2025-06-20 17:40:28', 12),
(26, 'Dog Key Chain', 'Crochet', 119.00, 'Dog mini key chain', 'images/crochet-keychain.jpg', 1, '2025-06-20 17:40:28', 14),
(27, 'Wooden Bullocart', 'Decor', 899.00, 'Wooden bullocart', 'images/decor.jpg', 1, '2025-06-20 17:40:28', 10),
(28, 'Denim tote ', 'Bags', 189.00, 'Denim tote handbags', 'images/denim-tote.jpg', 1, '2025-06-20 17:40:28', 15),
(29, 'Thread Earrings', 'Jewellery', 199.00, ' handmade Thread Earings ', 'images/earrings.jpg', 1, '2025-06-20 17:40:28', 12),
(47, 'camel', 'Decor', 299.00, 'wooden camel ', 'images/1754209033_camel.jpg', 1, '2025-08-03 08:17:38', 20),
(48, 'camel', 'Decor', 123.00, 'wooden camel', 'images/1754209302_camel.jpg', 7, '2025-08-03 08:22:00', 12);

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `aadhar_number` varchar(20) DEFAULT NULL,
  `shop_name` varchar(100) DEFAULT NULL,
  `proof` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `name`, `email`, `phone`, `aadhar_number`, `shop_name`, `proof`, `password`, `status`, `created_at`) VALUES
(1, 'sri', 'srivalli@gmail.com', '1234567890', '234345451232', 'crafty', '../uploads/seller_proofs/687525232d45f.jpg', '$2y$10$vN/zXDv7TpsckePAT971kORqFDIopWXocSR5IHbf4..zEtyGiF5Xy', 'approved', '2025-07-14 15:41:23'),
(3, 'valli', 'valli@gmail.com', '1234567890', '232312214554', 'arts&crafts', '../uploads/seller_proofs/68766ac85097f.jpg', '$2y$10$7MtVrthEfhYVaTOgyzInKuiOkK.eohBNn0KO6TKimriSg.VYgYzbC', 'rejected', '2025-07-15 14:50:48'),
(5, 'xyz', 'xyz@gmail.com', '1236547890', '78965412301236', 'asdfg', '../uploads/seller_proofs/688a47cd8ec49.jpg', '$2y$10$FkzDb5.brXzf1RVLxVw9h.cB8otm/5OypzXDi6./57eH0qILVZcnS', 'pending', '2025-07-30 16:26:53'),
(6, 'suresh', 'suresh@gmail.com', '1236547890', '234345451232', 'sscrafts&arts', '../uploads/seller_proofs/688f1735a8c3b.jpeg', '$2y$10$Q6QMO4VF1ilQzgm/MNNsEeIE1.G4ixTFwCiJpQ/B.i71Z2OJfyLX6', 'approved', '2025-08-03 08:00:53'),
(7, 'venkata suresh', 'venkatasuresh@gmail.com', '1236547890', '1236541236987', 'ssarts & crafts', '../uploads/seller_proofs/688f1b9e50d3a.jpeg', '$2y$10$J6R21ah3BbUdrsUyBilfQe09VkGyo/6xnQr0cNGrghGXxHMYcpRFG', 'approved', '2025-08-03 08:19:42');

-- --------------------------------------------------------

--
-- Table structure for table `shipped_orders`
--

CREATE TABLE `shipped_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `ordered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipped_orders`
--

INSERT INTO `shipped_orders` (`id`, `user_id`, `product_id`, `quantity`, `address`, `status`, `ordered_at`) VALUES
(1, 1, 3, 1, 'West godavari', 'shipped', '2025-08-03 10:57:28'),
(2, 7, 3, 1, 'Palakollu,West godavari', 'shipped', '2025-08-03 13:44:29'),
(3, 7, 48, 1, 'bhimavaram,West godavari', 'shipped', '2025-08-03 13:53:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` enum('user','seller','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `type`, `created_at`) VALUES
(1, 'srivalli', 'srivalli@gmail.com', '$2y$10$ZWzFzHOm4Tld0sNf2ALql.5X11wHdyq0G9PcWOLjYoJMNPuzQ0ir.', 'user', '2025-06-17 19:02:56'),
(2, 'vaishu', 'vaishu@gmail.com', '$2y$10$uNkpzFtJ3ES.vi.QEXmyh./X65bGmKjl8OjrtpG78aOHkpFJvgdNm', 'user', '2025-06-17 19:21:20'),
(3, 'srivalli', 'srivall@gmail.com', '$2y$10$ZgiYWDNaUKH26pd2vo69deRKl0w1Oz92gwsnzI1tYJ9xMe5K95Zve', 'user', '2025-06-17 19:23:22'),
(4, 'vaishu', 'valli@gmail.com', '$2y$10$AiT3aukIIhBHwys38xQV9uJr36NLlOtm7W4tcdukRxk6nenXmE4P6', 'user', '2025-06-18 13:24:03'),
(5, 'suresh', 'suresh@gmail.com', '$2y$10$RDaeg7RKGWw9jFkDNXxm5eEMJ5GOi2/ezj1uzF1sFI1ACssbJpHze', 'user', '2025-06-22 07:54:36'),
(6, 'tulasi', 'tulasi@gmail.com', '$2y$10$TAo7usTJ8AErAQQJEqPKZ.mPky1PYixdf7t6GH28HEYK1WlnR9Z7G', 'user', '2025-08-03 07:57:18'),
(7, 'lakshmi', 'lashmi@gmail.com', '$2y$10$vF4LFajMcapOHUy0i8mJpeV8atrDRR.3rz8MeBuXbVkXzdDiNxCi6', 'user', '2025-08-03 08:11:59');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `added_at`) VALUES
(33, 5, 7, '2025-06-22 07:56:04'),
(35, 5, 24, '2025-06-22 07:58:26'),
(36, 5, 25, '2025-06-22 07:58:27'),
(37, 5, 2, '2025-06-22 08:00:25'),
(38, 5, 3, '2025-06-22 08:00:26'),
(40, 2, 10, '2025-06-23 19:24:26'),
(41, 2, 11, '2025-06-23 19:24:41'),
(42, 2, 29, '2025-06-23 19:24:54'),
(43, 2, 14, '2025-06-23 19:25:21'),
(44, 2, 26, '2025-06-23 19:25:24'),
(45, 2, 1, '2025-06-23 19:29:41'),
(46, 2, 9, '2025-06-24 09:18:17'),
(47, 2, 16, '2025-06-24 09:27:32'),
(48, 2, 13, '2025-07-21 15:31:48'),
(49, 2, 18, '2025-07-21 15:31:50'),
(50, 1, 2, '2025-08-03 07:51:47'),
(51, 1, 16, '2025-08-03 07:52:02'),
(53, 1, 9, '2025-08-03 07:52:23'),
(54, 6, 3, '2025-08-03 07:58:09'),
(55, 6, 10, '2025-08-03 07:58:12'),
(56, 6, 29, '2025-08-03 07:58:32'),
(57, 6, 23, '2025-08-03 07:58:40'),
(58, 6, 14, '2025-08-03 07:58:51'),
(59, 6, 22, '2025-08-03 07:58:53'),
(60, 7, 2, '2025-08-03 08:13:00'),
(61, 7, 19, '2025-08-03 08:13:02'),
(62, 7, 12, '2025-08-03 08:13:18'),
(63, 7, 9, '2025-08-03 08:13:20'),
(64, 7, 22, '2025-08-03 08:13:29'),
(65, 7, 14, '2025-08-03 08:13:33'),
(66, 7, 24, '2025-08-03 08:13:35'),
(67, 7, 8, '2025-08-03 08:13:40'),
(68, 7, 23, '2025-08-03 08:13:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `pending_products`
--
ALTER TABLE `pending_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `shipped_orders`
--
ALTER TABLE `shipped_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pending_products`
--
ALTER TABLE `pending_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `shipped_orders`
--
ALTER TABLE `shipped_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `pending_products`
--
ALTER TABLE `pending_products`
  ADD CONSTRAINT `pending_products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
