-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2026 at 09:58 PM
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
-- Database: `logistix`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(10) UNSIGNED NOT NULL,
  `CustomerName` varchar(150) NOT NULL,
  `CustomerType` varchar(80) DEFAULT NULL,
  `Phone` varchar(40) DEFAULT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `Location` varchar(120) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Type` varchar(80) DEFAULT NULL,
  `CName` varchar(150) NOT NULL DEFAULT '',
  `BName` varchar(120) DEFAULT NULL,
  `ACNumber` varchar(80) DEFAULT NULL,
  `ContactPerson` varchar(150) DEFAULT NULL,
  `Address` varchar(180) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `PaymentTerms` varchar(50) DEFAULT NULL,
  `CreditLimit` decimal(12,2) NOT NULL DEFAULT 0.00,
  `Status` varchar(40) DEFAULT 'Active',
  `Notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `CustomerName`, `CustomerType`, `Phone`, `Email`, `Location`, `CreatedAt`, `UpdatedAt`, `Type`, `CName`, `BName`, `ACNumber`, `ContactPerson`, `Address`, `City`, `Country`, `PaymentTerms`, `CreditLimit`, `Status`, `Notes`) VALUES
(1, '', NULL, '+250788555111', 'procurement@primeconstruction.rw', NULL, '2026-06-29 18:16:14', '2026-06-29 18:16:14', 'Corporate', 'Prime Construction Ltd', 'Bank Of Kigali', 'BK-90909090', 'Eric Mugisha', 'KG 9 Avenue', 'Kigali', 'Rwanda', 'Net 30', 7000000.00, 'Active', 'Regular construction customer.'),
(2, '', NULL, '+250788555222', 'orders@horizon.rw', NULL, '2026-06-29 18:16:14', '2026-06-29 18:16:14', 'Contractor', 'Horizon Contractors', 'Equity Bank', 'EQ-12121212', 'Claudine Uwase', 'KK 18 Street', 'Kigali', 'Rwanda', 'Net 15', 3000000.00, 'Active', 'Buys site materials and safety equipment.'),
(3, '', NULL, '+250788555333', 'cashdesk@logistix.local', NULL, '2026-06-29 18:16:14', '2026-06-29 18:16:14', 'Retail', 'Walk-in Customer', 'MTN Mobile Money', 'MOMO-0001', 'Cash Desk', 'Main Branch', 'Kigali', 'Rwanda', 'Cash', 0.00, 'Active', 'Default retail customer.'),
(4, '', NULL, '0787836168', 'customer1@example.com', NULL, '2026-06-29 19:54:10', '2026-06-29 19:54:10', 'Retail', 'Customer 1', NULL, NULL, 'Person 1', 'Kigali', 'Kigali', 'Rwanda', 'Cash', 500000.00, 'Active', 'Demo customer'),
(5, '', NULL, '0787000002', 'customer2@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Wholesale', 'Customer 2', NULL, NULL, 'Person 2', 'Nyarugenge', 'Kigali', 'Rwanda', 'Net 30', 750000.00, 'Active', 'Demo customer'),
(6, '', NULL, '0787000003', 'customer3@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Retail', 'Customer 3', NULL, NULL, 'Person 3', 'Gasabo', 'Kigali', 'Rwanda', 'Cash', 500000.00, 'Active', 'Demo customer'),
(7, '', NULL, '0787000004', 'customer4@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Contractor', 'Customer 4', NULL, NULL, 'Person 4', 'Kicukiro', 'Kigali', 'Rwanda', 'Net 15', 1200000.00, 'Active', 'Demo customer'),
(8, '', NULL, '0787000005', 'customer5@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Corporate', 'Customer 5', NULL, NULL, 'Person 5', 'Musanze', 'Musanze', 'Rwanda', 'Net 30', 2000000.00, 'Active', 'Demo customer'),
(9, '', NULL, '0787000006', 'customer6@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Retail', 'Customer 6', NULL, NULL, 'Person 6', 'Rubavu', 'Rubavu', 'Rwanda', 'Cash', 600000.00, 'Active', 'Demo customer'),
(10, '', NULL, '0787000007', 'customer7@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Wholesale', 'Customer 7', NULL, NULL, 'Person 7', 'Huye', 'Huye', 'Rwanda', 'Net 30', 800000.00, 'Active', 'Demo customer'),
(11, '', NULL, '0787000008', 'customer8@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Retail', 'Customer 8', NULL, NULL, 'Person 8', 'Rusizi', 'Rusizi', 'Rwanda', 'Cash', 500000.00, 'Active', 'Demo customer'),
(12, '', NULL, '0787000009', 'customer9@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Government', 'Customer 9', NULL, NULL, 'Person 9', 'Muhanga', 'Muhanga', 'Rwanda', 'Net 60', 5000000.00, 'Active', 'Demo customer'),
(13, '', NULL, '0787000010', 'customer10@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'NGO', 'Customer 10', NULL, NULL, 'Person 10', 'Nyagatare', 'Nyagatare', 'Rwanda', 'Net 30', 2500000.00, 'Active', 'Demo customer'),
(14, '', NULL, '0787000011', 'customer11@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Retail', 'Customer 11', NULL, NULL, 'Person 11', 'Kigali', 'Kigali', 'Rwanda', 'Cash', 500000.00, 'Active', 'Demo customer'),
(15, '', NULL, '0787000012', 'customer12@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Corporate', 'Customer 12', NULL, NULL, 'Person 12', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 3000000.00, 'Active', 'Demo customer'),
(16, '', NULL, '0787000013', 'customer13@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Retail', 'Customer 13', NULL, NULL, 'Person 13', 'Musanze', 'Musanze', 'Rwanda', 'Cash', 450000.00, 'Active', 'Demo customer'),
(17, '', NULL, '0787000014', 'customer14@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Wholesale', 'Customer 14', NULL, NULL, 'Person 14', 'Rubavu', 'Rubavu', 'Rwanda', 'Net 15', 1000000.00, 'Active', 'Demo customer'),
(18, '', NULL, '0787000015', 'customer15@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Retail', 'Customer 15', NULL, NULL, 'Person 15', 'Huye', 'Huye', 'Rwanda', 'Cash', 500000.00, 'Active', 'Demo customer'),
(19, '', NULL, '0787000016', 'customer16@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Contractor', 'Customer 16', NULL, NULL, 'Person 16', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1500000.00, 'Active', 'Demo customer'),
(20, '', NULL, '0787000017', 'customer17@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Retail', 'Customer 17', NULL, NULL, 'Person 17', 'Rwamagana', 'Rwamagana', 'Rwanda', 'Cash', 600000.00, 'Active', 'Demo customer'),
(21, '', NULL, '0787000018', 'customer18@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Corporate', 'Customer 18', NULL, NULL, 'Person 18', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 2500000.00, 'Active', 'Demo customer'),
(22, '', NULL, '0787000019', 'customer19@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Retail', 'Customer 19', NULL, NULL, 'Person 19', 'Nyamata', 'Bugesera', 'Rwanda', 'Cash', 500000.00, 'Active', 'Demo customer'),
(23, '', NULL, '0787000020', 'customer20@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Wholesale', 'Customer 20', NULL, NULL, 'Person 20', 'Gicumbi', 'Gicumbi', 'Rwanda', 'Net 15', 900000.00, 'Active', 'Demo customer'),
(24, '', NULL, '0787000021', 'customer21@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Retail', 'Customer 21', NULL, NULL, 'Person 21', 'Kayonza', 'Kayonza', 'Rwanda', 'Cash', 550000.00, 'Active', 'Demo customer'),
(25, '', NULL, '0787000022', 'customer22@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Government', 'Customer 22', NULL, NULL, 'Person 22', 'Kigali', 'Kigali', 'Rwanda', 'Net 60', 4500000.00, 'Active', 'Demo customer'),
(26, '', NULL, '0787000023', 'customer23@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Retail', 'Customer 23', NULL, NULL, 'Person 23', 'Rubavu', 'Rubavu', 'Rwanda', 'Cash', 500000.00, 'Active', 'Demo customer'),
(27, '', NULL, '0787000024', 'customer24@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Corporate', 'Customer 24', NULL, NULL, 'Person 24', 'Huye', 'Huye', 'Rwanda', 'Net 30', 2800000.00, 'Active', 'Demo customer'),
(28, '', NULL, '0787000025', 'customer25@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Retail', 'Customer 25', NULL, NULL, 'Person 25', 'Muhanga', 'Muhanga', 'Rwanda', 'Cash', 500000.00, 'Active', 'Demo customer'),
(29, '', NULL, '0787000026', 'customer26@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Wholesale', 'Customer 26', NULL, NULL, 'Person 26', 'Musanze', 'Musanze', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo customer'),
(30, '', NULL, '0787000027', 'customer27@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Retail', 'Customer 27', NULL, NULL, 'Person 27', 'Kigali', 'Kigali', 'Rwanda', 'Cash', 600000.00, 'Active', 'Demo customer'),
(31, '', NULL, '0787000028', 'customer28@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Contractor', 'Customer 28', NULL, NULL, 'Person 28', 'Rusizi', 'Rusizi', 'Rwanda', 'Net 15', 1200000.00, 'Active', 'Demo customer'),
(32, '', NULL, '0787000029', 'customer29@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Retail', 'Customer 29', NULL, NULL, 'Person 29', 'Kigali', 'Kigali', 'Rwanda', 'Cash', 500000.00, 'Active', 'Demo customer'),
(33, '', NULL, '0787000030', 'customer30@example.com', NULL, '2026-06-29 19:55:14', '2026-06-29 19:55:14', 'Corporate', 'Customer 30', NULL, NULL, 'Person 30', 'Rubavu', 'Rubavu', 'Rwanda', 'Net 30', 3000000.00, 'Active', 'Demo customer');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `Code` int(10) UNSIGNED NOT NULL,
  `SKU` varchar(80) DEFAULT NULL,
  `Name` varchar(150) NOT NULL,
  `Brand` varchar(100) DEFAULT NULL,
  `Manufacturer` varchar(120) DEFAULT NULL,
  `Models` varchar(100) DEFAULT NULL,
  `Types` varchar(80) NOT NULL,
  `Categories` varchar(100) NOT NULL,
  `Measures` varchar(50) NOT NULL,
  `Barcode` varchar(100) DEFAULT NULL,
  `ReorderLevel` decimal(12,2) NOT NULL DEFAULT 0.00,
  `OpeningQuantity` decimal(12,2) NOT NULL DEFAULT 0.00,
  `Cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `Price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `Location` varchar(120) DEFAULT NULL,
  `Status` varchar(40) DEFAULT 'Active',
  `Description` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `QuantityOnHand` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`Code`, `SKU`, `Name`, `Brand`, `Manufacturer`, `Models`, `Types`, `Categories`, `Measures`, `Barcode`, `ReorderLevel`, `OpeningQuantity`, `Cost`, `Price`, `Location`, `Status`, `Description`, `CreatedAt`, `UpdatedAt`, `QuantityOnHand`) VALUES
(1, '', 'Wireless Keyboard', 'Miiec', 'HITACHI FM', 'ECM100', 'Stocked', 'Engineering', 'Pcs', '00012', 5.00, 0.00, 15200.00, 15200.00, 'RC-00-C', 'Active', '', '2026-06-29 18:05:21', '2026-06-29 18:05:21', 0.00),
(2, 'SKU-ENG-001', 'Cement 42.5N', 'Cimerwa', 'Cimerwa PLC', '42.5N', 'Stocked', 'Engineering', 'Bags', 'BC100001', 50.00, 300.00, 9500.00, 11500.00, 'Main Store', 'Active', 'General construction cement.', '2026-06-29 18:16:14', '2026-06-29 19:01:16', 300.00),
(3, 'SKU-MEC-002', 'Engine Oil 20W50', 'TotalEnergies', 'TotalEnergies', '20W50', 'Stocked', 'Oil and Fuel', 'Ltrs', 'BC100002', 20.00, 120.00, 3200.00, 4500.00, 'Garage', 'Active', 'Lubricant for diesel and petrol engines.', '2026-06-29 18:16:14', '2026-06-29 19:01:16', 120.00),
(4, 'SKU-ELE-003', 'Electrical Cable 2.5mm', 'Nexans', 'Nexans', '2.5mm', 'Stocked', 'Electricity', 'Rolls', 'BC100003', 10.00, 45.00, 42000.00, 52000.00, 'M15', 'Active', 'Copper electrical installation cable.', '2026-06-29 18:16:14', '2026-06-29 19:01:16', 45.00),
(5, 'SKU-SAF-004', 'Safety Helmet', '3M', '3M', 'H-701', 'Stocked', 'Safety Equipment', 'Pcs', 'BC100004', 15.00, 80.00, 6500.00, 9000.00, 'Building Sites', 'Active', 'Protective hard hat for site workers.', '2026-06-29 18:16:14', '2026-06-29 19:01:16', 80.00),
(6, 'SKU-OFF-005', 'A4 Printing Paper', 'Double A', 'Double A', 'A4 80gsm', 'Consumable', 'Office Supplies', 'Boxes', 'BC100005', 5.00, 25.00, 18000.00, 24000.00, 'Main Store', 'Active', 'Office printing paper.', '2026-06-29 18:16:14', '2026-06-29 19:01:16', 25.00),
(7, 'SKU001', 'Item 1', 'Brand2', 'Maker2', 'M1', 'Consumable', 'Engineering', 'Kgs', 'BC00001', 10.00, 100.00, 11.00, 16.50, 'Warehouse 2', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(8, 'SKU002', 'Item 2', 'Brand3', 'Maker3', 'M2', 'Service', 'Office Supplies', 'Pcs', 'BC00002', 10.00, 100.00, 12.00, 18.00, 'Warehouse 3', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(9, 'SKU003', 'Item 3', 'Brand4', 'Maker4', 'M3', 'Service', 'Mechanics', 'Pcs', 'BC00003', 10.00, 100.00, 13.00, 19.50, 'Warehouse 1', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(10, 'SKU004', 'Item 4', 'Brand5', 'Maker1', 'M4', 'Stocked', 'Office Supplies', 'Pcs', 'BC00004', 10.00, 100.00, 14.00, 21.00, 'Warehouse 2', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(11, 'SKU005', 'Item 5', 'Brand1', 'Maker2', 'M5', 'Stocked', 'Safety Equipment', 'Kgs', 'BC00005', 10.00, 100.00, 15.00, 22.50, 'Warehouse 3', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(12, 'SKU006', 'Item 6', 'Brand2', 'Maker3', 'M6', 'Consumable', 'Electricity', 'Boxes', 'BC00006', 10.00, 100.00, 16.00, 24.00, 'Warehouse 1', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(13, 'SKU007', 'Item 7', 'Brand3', 'Maker4', 'M7', 'Stocked', 'Safety Equipment', 'Pcs', 'BC00007', 10.00, 100.00, 17.00, 25.50, 'Warehouse 2', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(14, 'SKU008', 'Item 8', 'Brand4', 'Maker1', 'M8', 'Consumable', 'Mechanics', 'Boxes', 'BC00008', 10.00, 100.00, 18.00, 27.00, 'Warehouse 3', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(15, 'SKU009', 'Item 9', 'Brand5', 'Maker2', 'M9', 'Stocked', 'Mechanics', 'Pcs', 'BC00009', 10.00, 100.00, 19.00, 28.50, 'Warehouse 1', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(16, 'SKU010', 'Item 10', 'Brand1', 'Maker3', 'M10', 'Stocked', 'Office Supplies', 'Kgs', 'BC00010', 10.00, 100.00, 20.00, 30.00, 'Warehouse 2', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(17, 'SKU011', 'Item 11', 'Brand2', 'Maker4', 'M11', 'Service', 'Office Supplies', 'Kgs', 'BC00011', 10.00, 100.00, 21.00, 31.50, 'Warehouse 3', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(18, 'SKU012', 'Item 12', 'Brand3', 'Maker1', 'M12', 'Consumable', 'Office Supplies', 'Kgs', 'BC00012', 10.00, 100.00, 22.00, 33.00, 'Warehouse 1', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(19, 'SKU013', 'Item 13', 'Brand4', 'Maker2', 'M13', 'Service', 'Engineering', 'Boxes', 'BC00013', 10.00, 100.00, 23.00, 34.50, 'Warehouse 2', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(20, 'SKU014', 'Item 14', 'Brand5', 'Maker3', 'M14', 'Service', 'Mechanics', 'Boxes', 'BC00014', 10.00, 100.00, 24.00, 36.00, 'Warehouse 3', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(21, 'SKU015', 'Item 15', 'Brand1', 'Maker4', 'M15', 'Consumable', 'Engineering', 'Boxes', 'BC00015', 10.00, 100.00, 25.00, 37.50, 'Warehouse 1', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(22, 'SKU016', 'Item 16', 'Brand2', 'Maker1', 'M16', 'Stocked', 'Office Supplies', 'Kgs', 'BC00016', 10.00, 100.00, 26.00, 39.00, 'Warehouse 2', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(23, 'SKU017', 'Item 17', 'Brand3', 'Maker2', 'M17', 'Stocked', 'Safety Equipment', 'Boxes', 'BC00017', 10.00, 100.00, 27.00, 40.50, 'Warehouse 3', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(24, 'SKU018', 'Item 18', 'Brand4', 'Maker3', 'M18', 'Service', 'Safety Equipment', 'Pcs', 'BC00018', 10.00, 100.00, 28.00, 42.00, 'Warehouse 1', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(25, 'SKU019', 'Item 19', 'Brand5', 'Maker4', 'M19', 'Service', 'Electricity', 'Pcs', 'BC00019', 10.00, 100.00, 29.00, 43.50, 'Warehouse 2', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(26, 'SKU020', 'Item 20', 'Brand1', 'Maker1', 'M20', 'Service', 'Safety Equipment', 'Pcs', 'BC00020', 10.00, 100.00, 30.00, 45.00, 'Warehouse 3', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(27, 'SKU021', 'Item 21', 'Brand2', 'Maker2', 'M21', 'Stocked', 'Mechanics', 'Boxes', 'BC00021', 10.00, 100.00, 31.00, 46.50, 'Warehouse 1', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(28, 'SKU022', 'Item 22', 'Brand3', 'Maker3', 'M22', 'Stocked', 'Engineering', 'Boxes', 'BC00022', 10.00, 100.00, 32.00, 48.00, 'Warehouse 2', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(29, 'SKU023', 'Item 23', 'Brand4', 'Maker4', 'M23', 'Service', 'Electricity', 'Kgs', 'BC00023', 10.00, 100.00, 33.00, 49.50, 'Warehouse 3', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(30, 'SKU024', 'Item 24', 'Brand5', 'Maker1', 'M24', 'Service', 'Safety Equipment', 'Boxes', 'BC00024', 10.00, 100.00, 34.00, 51.00, 'Warehouse 1', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(31, 'SKU025', 'Item 25', 'Brand1', 'Maker2', 'M25', 'Consumable', 'Safety Equipment', 'Boxes', 'BC00025', 10.00, 100.00, 35.00, 52.50, 'Warehouse 2', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(32, 'SKU026', 'Item 26', 'Brand2', 'Maker3', 'M26', 'Stocked', 'Safety Equipment', 'Pcs', 'BC00026', 10.00, 100.00, 36.00, 54.00, 'Warehouse 3', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(33, 'SKU027', 'Item 27', 'Brand3', 'Maker4', 'M27', 'Service', 'Mechanics', 'Kgs', 'BC00027', 10.00, 100.00, 37.00, 55.50, 'Warehouse 1', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(34, 'SKU028', 'Item 28', 'Brand4', 'Maker1', 'M28', 'Stocked', 'Engineering', 'Pcs', 'BC00028', 10.00, 100.00, 38.00, 57.00, 'Warehouse 2', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(35, 'SKU029', 'Item 29', 'Brand5', 'Maker2', 'M29', 'Service', 'Safety Equipment', 'Ltrs', 'BC00029', 10.00, 100.00, 39.00, 58.50, 'Warehouse 3', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00),
(36, 'SKU030', 'Item 30', 'Brand1', 'Maker3', 'M30', 'Consumable', 'Electricity', 'Pcs', 'BC00030', 10.00, 100.00, 40.00, 60.00, 'Warehouse 1', 'Active', 'Demo item', '2026-06-29 19:47:20', '2026-06-29 19:47:20', 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `POID` int(10) UNSIGNED NOT NULL,
  `SupplierName` varchar(150) DEFAULT NULL,
  `SupplierTIN` varchar(50) DEFAULT NULL,
  `InvoiceNumber` varchar(80) DEFAULT NULL,
  `InvoiceDate` date DEFAULT NULL,
  `PaymentOption` varchar(50) DEFAULT NULL,
  `ItemCode` int(10) UNSIGNED DEFAULT NULL,
  `Quantity` decimal(12,2) NOT NULL DEFAULT 1.00,
  `UnitCost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `OrderDate` date NOT NULL,
  `Status` varchar(40) NOT NULL DEFAULT 'Draft',
  `Notes` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ItemName` varchar(150) NOT NULL DEFAULT '',
  `Cost` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`POID`, `SupplierName`, `SupplierTIN`, `InvoiceNumber`, `InvoiceDate`, `PaymentOption`, `ItemCode`, `Quantity`, `UnitCost`, `OrderDate`, `Status`, `Notes`, `CreatedAt`, `UpdatedAt`, `ItemName`, `Cost`) VALUES
(1, 'Kigali Building Supplies Ltd', 'TIN-SUP-001', 'INV-KBS-1001', '2026-06-01', 'Net 30', 1, 100.00, 0.00, '0000-00-00', 'Draft', NULL, '2026-06-29 18:16:14', '2026-06-29 18:16:14', 'Cement 42.5N', 9500.00),
(2, 'Rwanda Auto Parts', 'TIN-SUP-002', 'INV-RAP-2044', '2026-06-05', 'Net 15', 2, 40.00, 0.00, '0000-00-00', 'Draft', NULL, '2026-06-29 18:16:14', '2026-06-29 18:16:14', 'Engine Oil 20W50', 3200.00),
(3, 'East Africa Electricals', 'TIN-SUP-003', 'INV-EAE-7788', '2026-06-08', 'Net 60', 3, 12.00, 0.00, '0000-00-00', 'Draft', NULL, '2026-06-29 18:16:14', '2026-06-29 18:16:14', 'Electrical Cable 2.5mm', 42000.00),
(4, 'Kigali Building Supplies Ltd', 'TIN-SUP-001', 'INV-KBS-1002', '2026-06-12', 'Net 30', 4, 30.00, 0.00, '0000-00-00', 'Draft', NULL, '2026-06-29 18:16:14', '2026-06-29 18:16:14', 'Safety Helmet', 6500.00),
(5, 'East Africa Electricals', 'TIN-SUP-003', 'SDC002111547E', '2026-06-11', 'Net 15', 4, 5.00, 0.00, '0000-00-00', 'Draft', NULL, '2026-06-29 18:19:02', '2026-06-29 18:19:02', 'Electrical Cable 2.5mm', 42000.00),
(6, 'East Africa Electricals', 'TIN-SUP-003', 'SDC002111547E', '2026-06-11', 'Net 15', 5, 5.00, 0.00, '0000-00-00', 'Draft', NULL, '2026-06-29 18:19:02', '2026-06-29 18:19:02', 'Safety Helmet', 6500.00);

-- --------------------------------------------------------

--
-- Table structure for table `sales_orders`
--

CREATE TABLE `sales_orders` (
  `SOID` int(10) UNSIGNED NOT NULL,
  `CustomerID` int(10) UNSIGNED DEFAULT NULL,
  `ItemCode` int(10) UNSIGNED DEFAULT NULL,
  `Quantity` decimal(12,2) NOT NULL DEFAULT 1.00,
  `UnitPrice` decimal(12,2) NOT NULL DEFAULT 0.00,
  `OrderDate` date NOT NULL,
  `Status` varchar(40) NOT NULL DEFAULT 'Draft',
  `Notes` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `TINumber` varchar(50) NOT NULL,
  `Type` varchar(80) DEFAULT NULL,
  `SUName` varchar(150) NOT NULL,
  `ContactPerson` varchar(150) DEFAULT NULL,
  `BName` varchar(120) NOT NULL,
  `ACNumber` varchar(80) NOT NULL,
  `Phone` varchar(40) DEFAULT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `Address` varchar(180) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `PaymentTerms` varchar(50) DEFAULT NULL,
  `CreditLimit` decimal(12,2) NOT NULL DEFAULT 0.00,
  `Status` varchar(40) DEFAULT 'Active',
  `Notes` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`TINumber`, `Type`, `SUName`, `ContactPerson`, `BName`, `ACNumber`, `Phone`, `Email`, `Address`, `City`, `Country`, `PaymentTerms`, `CreditLimit`, `Status`, `Notes`, `CreatedAt`, `UpdatedAt`) VALUES
('125547', 'Local/LP', 'Karki Supply CO', 'NSENGUMUREMYI Theoneste', 'Bank Of Kigali', '002676711471018', '+250781030009', 'urugwiromail@gmail.com', 'Gasabo, Kigali', 'Kigali', 'Rwanda', 'Cash', 0.00, 'Active', 'For Plumbing Materials', '2026-06-29 18:10:59', '2026-06-29 18:10:59'),
('TIN-SUP-001', 'Local/LP', 'Kigali Building Supplies Ltd', 'Jean Ndayisaba', 'Bank Of Kigali', 'BK-100200300', '+250788111222', 'sales@kbs.rw', 'KN 3 Road', 'Kigali', 'Rwanda', 'Net 30', 5000000.00, 'Active', 'Main supplier for construction materials.', '2026-06-29 18:16:14', '2026-06-29 18:16:14'),
('TIN-SUP-002', 'SP/Service provider', 'Rwanda Auto Parts', 'Aline Mukamana', 'Equity Bank', 'EQ-77889900', '+250788333444', 'orders@autoparts.rw', 'KG 12 Avenue', 'Kigali', 'Rwanda', 'Net 15', 2500000.00, 'Active', 'Supplies garage parts and lubricants.', '2026-06-29 18:16:14', '2026-06-29 18:16:14'),
('TIN-SUP-003', 'Foreign', 'East Africa Electricals', 'Peter Kamau', 'Access Bank Rwanda', 'AC-44556677', '+254722555666', 'info@eae.co.ke', 'Industrial Area', 'Nairobi', 'Kenya', 'Net 60', 8000000.00, 'Active', 'Electrical cables and fittings.', '2026-06-29 18:16:14', '2026-06-29 18:16:14'),
('TIN0001', 'Local/LP', 'Supplier 1', 'Contact 1', 'Bank of Kigali', '10000001', '0764004948', 'supplier1@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0002', 'Local/LP', 'Supplier 2', 'Contact 2', 'Bank of Kigali', '10000002', '0730578243', 'supplier2@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0003', 'Local/LP', 'Supplier 3', 'Contact 3', 'Bank of Kigali', '10000003', '0725379599', 'supplier3@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0004', 'Local/LP', 'Supplier 4', 'Contact 4', 'Bank of Kigali', '10000004', '0781123728', 'supplier4@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0005', 'Local/LP', 'Supplier 5', 'Contact 5', 'Bank of Kigali', '10000005', '0793597327', 'supplier5@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0006', 'Local/LP', 'Supplier 6', 'Contact 6', 'Bank of Kigali', '10000006', '0739433892', 'supplier6@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0007', 'Local/LP', 'Supplier 7', 'Contact 7', 'Bank of Kigali', '10000007', '0774822073', 'supplier7@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0008', 'Local/LP', 'Supplier 8', 'Contact 8', 'Bank of Kigali', '10000008', '0784169218', 'supplier8@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0009', 'Local/LP', 'Supplier 9', 'Contact 9', 'Bank of Kigali', '10000009', '0778659538', 'supplier9@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0010', 'Local/LP', 'Supplier 10', 'Contact 10', 'Bank of Kigali', '10000010', '0730253672', 'supplier10@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0011', 'Local/LP', 'Supplier 11', 'Contact 11', 'Bank of Kigali', '10000011', '0745848751', 'supplier11@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0012', 'Local/LP', 'Supplier 12', 'Contact 12', 'Bank of Kigali', '10000012', '0765063935', 'supplier12@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0013', 'Local/LP', 'Supplier 13', 'Contact 13', 'Bank of Kigali', '10000013', '0781311377', 'supplier13@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0014', 'Local/LP', 'Supplier 14', 'Contact 14', 'Bank of Kigali', '10000014', '0759392762', 'supplier14@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0015', 'Local/LP', 'Supplier 15', 'Contact 15', 'Bank of Kigali', '10000015', '0750228030', 'supplier15@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0016', 'Local/LP', 'Supplier 16', 'Contact 16', 'Bank of Kigali', '10000016', '0721278249', 'supplier16@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0017', 'Local/LP', 'Supplier 17', 'Contact 17', 'Bank of Kigali', '10000017', '0740286003', 'supplier17@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0018', 'Local/LP', 'Supplier 18', 'Contact 18', 'Bank of Kigali', '10000018', '0745766969', 'supplier18@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0019', 'Local/LP', 'Supplier 19', 'Contact 19', 'Bank of Kigali', '10000019', '0769512596', 'supplier19@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0020', 'Local/LP', 'Supplier 20', 'Contact 20', 'Bank of Kigali', '10000020', '0786993342', 'supplier20@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0021', 'Local/LP', 'Supplier 21', 'Contact 21', 'Bank of Kigali', '10000021', '0738340675', 'supplier21@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0022', 'Local/LP', 'Supplier 22', 'Contact 22', 'Bank of Kigali', '10000022', '0754652636', 'supplier22@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0023', 'Local/LP', 'Supplier 23', 'Contact 23', 'Bank of Kigali', '10000023', '0753181654', 'supplier23@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0024', 'Local/LP', 'Supplier 24', 'Contact 24', 'Bank of Kigali', '10000024', '0799662697', 'supplier24@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0025', 'Local/LP', 'Supplier 25', 'Contact 25', 'Bank of Kigali', '10000025', '0761204102', 'supplier25@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0026', 'Local/LP', 'Supplier 26', 'Contact 26', 'Bank of Kigali', '10000026', '0720892443', 'supplier26@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0027', 'Local/LP', 'Supplier 27', 'Contact 27', 'Bank of Kigali', '10000027', '0771997997', 'supplier27@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0028', 'Local/LP', 'Supplier 28', 'Contact 28', 'Bank of Kigali', '10000028', '0769985445', 'supplier28@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0029', 'Local/LP', 'Supplier 29', 'Contact 29', 'Bank of Kigali', '10000029', '0754830375', 'supplier29@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20'),
('TIN0030', 'Local/LP', 'Supplier 30', 'Contact 30', 'Bank of Kigali', '10000030', '0739350881', 'supplier30@example.com', 'Kigali', 'Kigali', 'Rwanda', 'Net 30', 1000000.00, 'Active', 'Demo supplier', '2026-06-29 19:47:20', '2026-06-29 19:47:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`Code`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`POID`),
  ADD KEY `SupplierTIN` (`SupplierTIN`),
  ADD KEY `ItemCode` (`ItemCode`);

--
-- Indexes for table `sales_orders`
--
ALTER TABLE `sales_orders`
  ADD PRIMARY KEY (`SOID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `ItemCode` (`ItemCode`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`TINumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `Code` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `POID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales_orders`
--
ALTER TABLE `sales_orders`
  MODIFY `SOID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
