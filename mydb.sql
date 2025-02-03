-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2025 at 04:27 AM
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
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` int(15) NOT NULL DEFAULT 0,
  `gender` varchar(8) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`, `phone`, `gender`, `address`) VALUES
(1, 'Mohammad Shahriar Zaman', 'rifti@gmail.com', 'rifti@1234', 1789456126, 'Male', 'Mohakhali'),
(2, 'Rafiul Hasan Shafin', 'shafin@gmail.com', 'shafin@1234', 1789756926, 'Male', 'Basundhara R/A'),
(3, 'Abrar Shakil', 'abrar@gmail.com', 'abrar@1234', 1896456126, 'Male', 'Basundhara R/A'),
(4, 'Julfiqure Islam Antor', 'antor@gmail.com', 'antor@1234', 1745713126, 'Male', 'Kuril');

-- --------------------------------------------------------

--
-- Table structure for table `approve_tour_package`
--

CREATE TABLE `approve_tour_package` (
  `approve_tour_package_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `status` varchar(15) NOT NULL,
  `price` int(5) NOT NULL,
  `employee_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `approve_travel_accessory`
--

CREATE TABLE `approve_travel_accessory` (
  `approve_travel_accessory_id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL,
  `description` varchar(50) NOT NULL,
  `price` int(8) NOT NULL,
  `stock` int(8) NOT NULL,
  `seller_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approve_travel_accessory`
--

INSERT INTO `approve_travel_accessory` (`approve_travel_accessory_id`, `name`, `description`, `price`, `stock`, `seller_id`) VALUES
(7, 'sadcSA', 'ascsa', 500, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(8) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_payment_status` tinyint(1) NOT NULL,
  `booking_total_amount` int(8) NOT NULL,
  `customer_id` int(8) NOT NULL,
  `tour_package_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(8) NOT NULL,
  `customer_id` int(8) NOT NULL,
  `travel_accessory_id` int(8) NOT NULL,
  `quantity` int(8) NOT NULL,
  `price` int(20) NOT NULL,
  `total_price` int(20) NOT NULL,
  `added_date` date NOT NULL,
  `product_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(8) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` int(15) NOT NULL DEFAULT 0,
  `c_image` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `discount_id` int(8) NOT NULL,
  `discount_name` varchar(20) NOT NULL,
  `discount_amount` int(8) NOT NULL,
  `discount_period_start` date NOT NULL,
  `discount_period_end` date NOT NULL,
  `employee_id` int(8) NOT NULL,
  `tour_package_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(8) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` int(15) NOT NULL DEFAULT 0,
  `gender` varchar(8) NOT NULL,
  `address` varchar(50) NOT NULL DEFAULT '0',
  `position` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `name`, `email`, `password`, `phone`, `gender`, `address`, `position`) VALUES
(10, 'Provat', 'provat@gmail.com', 'provat@1234', 1949575896, 'Male', 'Kuril', 'Manager'),
(11, 'Mutasim', 'billah@gmail.com', 'billah@1234', 1934575896, 'Male', 'Kuril', 'Assistant Manag'),
(12, 'Shakil', 'shakil@gmail.com', 'shakil@1234', 1945875896, 'Male', 'Kuril', 'HR'),
(13, 'Rabbi', 'rabbi@gmail.com', 'rabbi@1234', 1934265896, 'Male', 'Basundhara R/A', 'Dept. Head');

-- --------------------------------------------------------

--
-- Table structure for table `guide`
--

CREATE TABLE `guide` (
  `guide_id` int(8) NOT NULL,
  `guide_name` varchar(15) NOT NULL,
  `guide_email` varchar(20) NOT NULL,
  `guide_address` varchar(20) NOT NULL,
  `guide_phone` int(15) NOT NULL DEFAULT 0,
  `tour_package_id` int(8) NOT NULL,
  `employee_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `helpus`
--

CREATE TABLE `helpus` (
  `helpus_id` int(8) NOT NULL,
  `helpus_messege` varchar(200) NOT NULL,
  `helpus_status` tinyint(1) NOT NULL,
  `helpus_created_date` date NOT NULL,
  `helpus_solved_date` date NOT NULL,
  `customer_id` int(8) NOT NULL,
  `employee_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(8) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_amount` int(8) NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `payment_status` tinyint(1) NOT NULL,
  `customer_id` int(8) NOT NULL,
  `booking_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(8) NOT NULL,
  `review_date` date NOT NULL,
  `review_comments` varchar(200) NOT NULL,
  `review_rating` int(6) NOT NULL,
  `tour_package_id` int(8) NOT NULL,
  `customer_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `seller_id` int(8) NOT NULL,
  `name` varchar(50) NOT NULL,
  `shop_email` varchar(50) NOT NULL,
  `shop_name` varchar(50) NOT NULL,
  `trade_license_number` int(25) NOT NULL,
  `shop_address` varchar(50) NOT NULL,
  `password` varchar(15) NOT NULL,
  `shop_phone` int(15) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`seller_id`, `name`, `shop_email`, `shop_name`, `trade_license_number`, `shop_address`, `password`, `shop_phone`) VALUES
(7, 'John Doe', 'johndoe@example.com', 'Doe Electronics', 0, '123 Main St, NY', 'securePass123', 123),
(8, 'Alice Smith', 'alice.smith@example.com', 'Smith Fashion', 0, '456 Elm St, CA', 'passAlice789', 987),
(9, 'Michael Johnson', 'michaelj@example.com', 'Johnson Furniture', 0, '789 Oak St, TX', 'mikeSecure456', 456),
(10, 'Emma Brown', 'emma.b@example.com', 'Brown Books', 0, '101 Pine St, FL', 'emmaPass999', 321);

-- --------------------------------------------------------

--
-- Table structure for table `sold_items`
--

CREATE TABLE `sold_items` (
  `sold_id` int(8) NOT NULL,
  `p_name` varchar(100) NOT NULL,
  `p_id` int(8) NOT NULL,
  `c_id` int(8) NOT NULL,
  `p_price` int(20) NOT NULL,
  `p_quantity` int(8) NOT NULL,
  `total_price` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_admin`
--

CREATE TABLE `temp_admin` (
  `temp_admin_id` int(8) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_employee`
--

CREATE TABLE `temp_employee` (
  `temp_employee_id` int(8) NOT NULL,
  `email` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_pkg`
--

CREATE TABLE `temp_pkg` (
  `temp_pkg_id` int(8) NOT NULL,
  `customer_id` int(8) NOT NULL,
  `pkg_id` int(8) NOT NULL,
  `total_person` int(8) NOT NULL,
  `pkg_price` int(8) NOT NULL,
  `totalpkg_price` int(20) NOT NULL,
  `booking_date` date NOT NULL,
  `pkg_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_package`
--

CREATE TABLE `tour_package` (
  `tour_package_id` int(8) NOT NULL,
  `tour_package_name` varchar(20) NOT NULL,
  `tour_package_description` varchar(200) NOT NULL,
  `tour_package_status` varchar(15) NOT NULL,
  `tour_package_price` int(5) NOT NULL,
  `employee_id` int(8) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour_package`
--

INSERT INTO `tour_package` (`tour_package_id`, `tour_package_name`, `tour_package_description`, `tour_package_status`, `tour_package_price`, `employee_id`, `image`) VALUES
(19, 'Cox\'s Bazar', 'A beautiful beach destination with the longest sea beach in the world.', 'Available', 15000, 10, 'coxs1.jpeg'),
(20, 'Rangamati', 'Experience the beauty of Kaptai Lake and tribal culture.', 'Available', 12000, 10, 'rangamati3.jpg'),
(21, 'Mirinja Valley', 'Enjoy breathtaking mountain views and serene landscapes.', 'Available', 14000, 11, 'mirinja2.jpg'),
(22, 'Sajek', 'A mesmerizing hill station with stunning cloud views.', 'Available', 16000, 11, 'sajek1.jpg'),
(23, 'Bandarban', 'Explore the hills, waterfalls, and tribal culture.', 'Available', 13000, 12, 'bandarban.jpg'),
(24, 'Jaflong', 'Famous for its stone collection sites and beautiful river views.', 'Available', 11000, 12, 'jaflong1.jpg'),
(25, 'Sunamganj', 'A land of wetlands and haors with scenic beauty.', 'Available', 10000, 13, 'tanguarhaor1.jpg'),
(26, 'Sylhet', 'Explore tea gardens, waterfalls, and historical sites.', 'Available', 12500, 13, 'ratargul3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `travel_accessory`
--

CREATE TABLE `travel_accessory` (
  `travel_accessory_id` int(8) NOT NULL,
  `name` varchar(15) NOT NULL,
  `description` varchar(200) NOT NULL,
  `price` int(8) NOT NULL,
  `stock` int(8) NOT NULL,
  `travel_accessory_image` varchar(50) NOT NULL,
  `seller_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `travel_accessory`
--

INSERT INTO `travel_accessory` (`travel_accessory_id`, `name`, `description`, `price`, `stock`, `travel_accessory_image`, `seller_id`) VALUES
(6, 'Travel Backpack', 'Spacious and durable backpack for travelers.', 2500, 50, 'bag.jpg', 7),
(7, 'Neck Pillow', 'Comfortable memory foam neck pillow for long journeys.', 1200, 30, 'neck_pillow.jpg', 8),
(8, 'Power Bank', '10,000mAh portable power bank for charging on the go.', 1800, 40, 'power_bank.jpg', 9),
(9, 'Travel Adapter', 'Universal travel adapter compatible with multiple plug types.', 1500, 60, 'travel_adapter.jpg', 10),
(10, 'Luggage Locks', 'Set of 2 TSA-approved luggage locks for secure travel.', 800, 70, 'luggage_locks.jpg', 7),
(11, 'Waterproof Pouc', 'Keep your phone and essentials dry while traveling.', 900, 50, 'waterproof_pouch.jpg', 8),
(12, 'Packing Cubes', 'Set of 5 packing cubes for organized packing.', 2000, 45, 'packing_cubes.jpg', 9),
(13, 'Portable Fan', 'USB rechargeable mini fan for travel convenience.', 1300, 35, 'portable_fan.jpg', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `approve_tour_package`
--
ALTER TABLE `approve_tour_package`
  ADD PRIMARY KEY (`approve_tour_package_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `approve_travel_accessory`
--
ALTER TABLE `approve_travel_accessory`
  ADD PRIMARY KEY (`approve_travel_accessory_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `tour_package_id` (`tour_package_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `travel_accessory_id` (`travel_accessory_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`discount_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `tour_package_id` (`tour_package_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `guide`
--
ALTER TABLE `guide`
  ADD PRIMARY KEY (`guide_id`),
  ADD KEY `tour_package_id` (`tour_package_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `helpus`
--
ALTER TABLE `helpus`
  ADD PRIMARY KEY (`helpus_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `tour_package_id` (`tour_package_id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`seller_id`);

--
-- Indexes for table `sold_items`
--
ALTER TABLE `sold_items`
  ADD PRIMARY KEY (`sold_id`);

--
-- Indexes for table `temp_admin`
--
ALTER TABLE `temp_admin`
  ADD PRIMARY KEY (`temp_admin_id`);

--
-- Indexes for table `temp_employee`
--
ALTER TABLE `temp_employee`
  ADD PRIMARY KEY (`temp_employee_id`);

--
-- Indexes for table `temp_pkg`
--
ALTER TABLE `temp_pkg`
  ADD PRIMARY KEY (`temp_pkg_id`);

--
-- Indexes for table `tour_package`
--
ALTER TABLE `tour_package`
  ADD PRIMARY KEY (`tour_package_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `travel_accessory`
--
ALTER TABLE `travel_accessory`
  ADD PRIMARY KEY (`travel_accessory_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `approve_tour_package`
--
ALTER TABLE `approve_tour_package`
  MODIFY `approve_tour_package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `approve_travel_accessory`
--
ALTER TABLE `approve_travel_accessory`
  MODIFY `approve_travel_accessory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `discount_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `guide`
--
ALTER TABLE `guide`
  MODIFY `guide_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `helpus`
--
ALTER TABLE `helpus`
  MODIFY `helpus_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `seller_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sold_items`
--
ALTER TABLE `sold_items`
  MODIFY `sold_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `temp_admin`
--
ALTER TABLE `temp_admin`
  MODIFY `temp_admin_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `temp_employee`
--
ALTER TABLE `temp_employee`
  MODIFY `temp_employee_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `temp_pkg`
--
ALTER TABLE `temp_pkg`
  MODIFY `temp_pkg_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tour_package`
--
ALTER TABLE `tour_package`
  MODIFY `tour_package_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `travel_accessory`
--
ALTER TABLE `travel_accessory`
  MODIFY `travel_accessory_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approve_tour_package`
--
ALTER TABLE `approve_tour_package`
  ADD CONSTRAINT `approve_tour_package_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`);

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`tour_package_id`) REFERENCES `tour_package` (`tour_package_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
