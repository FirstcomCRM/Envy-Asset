-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2017 at 09:16 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `envy_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `announcement` text NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `title`, `announcement`, `date_created`, `date_modified`, `created_by`, `modified_by`) VALUES
(1, 'new titles', '"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"\r\n\r\n"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"', '2017-07-31 15:19:33', '2017-07-31 16:25:05', 'ad', 'admin'),
(2, 'te', 'te', NULL, NULL, '', ''),
(3, 'asdad', 'adadad', NULL, NULL, '', ''),
(4, 'ate', 'asdsad', '2017-07-31 08:26:46', NULL, 'admin', ''),
(5, 'tasda', 'asdadad', '2017-07-31 08:27:17', NULL, 'admin', ''),
(6, 'wwww', 'as', '2017-07-31 08:28:01', NULL, 'admin', ''),
(7, 'New title', '<strong>New title</strong>\r\n\r\nNew title\r\n\r\nNew title\r\n\r\nNew title', '2017-07-31 02:34:44', '2017-07-31 14:36:28', 'admin', 'admin'),
(8, 'Mouse changes', 'Update all mouses for next month', '2017-07-31 05:39:47', NULL, 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('Admin', '1', NULL),
('Admin', '5', 1501235679),
('Staff', '6', 1501576594);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('Admin', 1, 'Admin Group', NULL, NULL, NULL, NULL),
('Manager', 1, 'Manager group sectionas', NULL, NULL, NULL, NULL),
('Staff', 1, 'Staff group', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `country` varchar(50) NOT NULL,
  `capital` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `country_capital`
--

CREATE TABLE `country_capital` (
  `id` int(11) NOT NULL,
  `country_code` varchar(3) NOT NULL,
  `capital` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country_capital`
--

INSERT INTO `country_capital` (`id`, `country_code`, `capital`) VALUES
(1, 'AU', 'Melbourne'),
(2, 'PH', 'Manila');

-- --------------------------------------------------------

--
-- Table structure for table `country_code`
--

CREATE TABLE `country_code` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country_code`
--

INSERT INTO `country_code` (`id`, `code`, `country`) VALUES
(1, 'AU', 'Australia'),
(2, 'PH', 'Philippines');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `company_name` varchar(75) NOT NULL,
  `customer_group` varchar(75) NOT NULL,
  `contact_person` varchar(75) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` int(13) NOT NULL,
  `address` text NOT NULL,
  `remark` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `company_name`, `customer_group`, `contact_person`, `email`, `mobile`, `address`, `remark`) VALUES
(8, 'Nebula', 'Cust-B', 'nebula', 'nebula@nebukla.com', 123, '//use co\r\nmmon\\models\\DeposaitLine;', '//use common\r\n//use common\\models\\DepositLine;\r\n\r\n\\models\\DepositLine;'),
(9, 'Zarudo', 'Cust-C', 'Dio', 'Dio@dio.c', 123, 'za world', 'za worldza worldza world\r\nza worldza world');

-- --------------------------------------------------------

--
-- Table structure for table `customer_group`
--

CREATE TABLE `customer_group` (
  `id` int(11) NOT NULL,
  `customer_group` varchar(75) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_group`
--

INSERT INTO `customer_group` (`id`, `customer_group`, `description`) VALUES
(1, 'Cust-A', 'Cust-A'),
(2, 'Cust-B', 'Cust-B'),
(3, 'Cust-C', 'Cust-C'),
(4, 'redA', 'asd'),
(5, 'Cust-D', 'Cust-D'),
(6, 'cat-3', 'cat-3');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department`) VALUES
(1, 'Finance'),
(2, 'IT'),
(3, 'Sales'),
(4, 'Purchasing');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_head`
--

CREATE TABLE `deposit_head` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL COMMENT 'customer''s unique id based on the customer table',
  `customer` varchar(100) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deposit_head`
--

INSERT INTO `deposit_head` (`id`, `customer_id`, `customer`, `date_created`) VALUES
(6, 8, 'Nebula', '2017-08-01'),
(7, 9, 'Zarudo', '2017-08-01'),
(8, 10, 'new customer', '2017-08-02');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_line`
--

CREATE TABLE `deposit_line` (
  `id` int(11) NOT NULL,
  `header_id` int(11) NOT NULL,
  `deposit` decimal(11,2) NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deposit_line`
--

INSERT INTO `deposit_line` (`id`, `header_id`, `deposit`, `date_added`) VALUES
(10, 6, '1000.00', '2017-08-01'),
(11, 6, '2324.00', '2017-08-01'),
(12, 6, '2.00', '2017-08-01'),
(13, 7, '4444.00', '2017-08-01'),
(14, 7, '34.00', '2017-08-01'),
(15, 6, '34343.00', '2017-08-01'),
(16, 6, '1237.00', '2017-08-01'),
(17, 7, '9022.00', '2017-08-01');

-- --------------------------------------------------------

--
-- Table structure for table `invest_metal`
--

CREATE TABLE `invest_metal` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product` varchar(100) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invest_metal`
--

INSERT INTO `invest_metal` (`id`, `product_id`, `product`, `date_created`) VALUES
(2, 13, 'InvestStockMetal', '2017-09-04'),
(3, 14, 'InvestStock', '2017-08-04'),
(4, 15, 'InvestNew', '2017-08-04');

-- --------------------------------------------------------

--
-- Table structure for table `invest_metal_line`
--

CREATE TABLE `invest_metal_line` (
  `id` int(11) NOT NULL,
  `header_id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `investment` decimal(11,2) NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invest_metal_line`
--

INSERT INTO `invest_metal_line` (`id`, `header_id`, `type`, `investment`, `date_added`) VALUES
(2, 2, 'Metal', '1000.00', '2017-09-04'),
(3, 2, 'Metal', '2222.00', '2017-09-06'),
(4, 2, 'Metal', '2354.00', '2017-09-10'),
(5, 4, 'Metal', '23456.00', '2017-08-04'),
(6, 2, 'Metal', '3434.00', '2017-08-04'),
(7, 4, 'Metal', '10000.00', '2017-08-04'),
(8, 4, 'Metal', '10000.00', '2017-08-04'),
(9, 4, 'Metal', '2.20', '2017-08-04'),
(10, 3, 'Metal', '111.00', '2017-08-04'),
(11, 3, 'Metal', '2324.00', '2017-08-04'),
(12, 3, 'Metal', '4355.00', '2017-08-04'),
(13, 3, 'Metal', '126.00', '2017-08-04');

-- --------------------------------------------------------

--
-- Table structure for table `invest_metal_price`
--

CREATE TABLE `invest_metal_price` (
  `id` int(11) NOT NULL,
  `metal_price` decimal(11,2) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invest_stock`
--

CREATE TABLE `invest_stock` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product` varchar(100) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invest_stock`
--

INSERT INTO `invest_stock` (`id`, `product_id`, `product`, `date_created`) VALUES
(9, 13, 'InvestStockMetal', '2017-08-04'),
(10, 14, 'InvestStock', '2017-08-04'),
(11, 15, 'InvestNew', '2017-08-04');

-- --------------------------------------------------------

--
-- Table structure for table `invest_stock_line`
--

CREATE TABLE `invest_stock_line` (
  `id` int(11) NOT NULL,
  `header_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `investment` decimal(11,2) NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invest_stock_line`
--

INSERT INTO `invest_stock_line` (`id`, `header_id`, `type`, `investment`, `date_added`) VALUES
(14, 9, 'Stock', '2222.00', '2017-08-04'),
(15, 11, 'Stock', '34343.00', '2017-08-04');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1501039883),
('m130524_201442_init', 1501039888),
('m140506_102106_rbac_init', 1501232342),
('m150321_222228_audit_trail', 1501642586);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `category`, `description`) VALUES
(1, 'CAT-A', 'test'),
(2, 'CAT-B', 'asw'),
(3, 'CAT-C', 'CAT-Cw'),
(4, 'CAT-D', 'category class D');

-- --------------------------------------------------------

--
-- Table structure for table `product_management`
--

CREATE TABLE `product_management` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_price` decimal(10,0) NOT NULL,
  `product_cost` decimal(10,0) NOT NULL,
  `product_type` varchar(100) NOT NULL,
  `product_cat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_management`
--

INSERT INTO `product_management` (`id`, `product_name`, `description`, `product_code`, `product_price`, `product_cost`, `product_type`, `product_cat`) VALUES
(13, 'InvestStockMetal', 'InvestStockMetal', 'InvestStockMetal', '111', '222', 'Type-2', 'CAT-B'),
(14, 'InvestStock', 'InvestStock', 'InvestStock', '111222', '2', 'Type-2', 'CAT-C'),
(15, 'InvestNew', 'InvestNew', 'InvestNew', '1234', '444', 'Type-2', 'CAT-B');

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`id`, `type`, `description`) VALUES
(1, 'Type-1', 'test 1'),
(2, 'Type-2', 'adasd'),
(3, 'Type-3', 'adsasd'),
(4, 'Type-4', 'vdntnt\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit_trail`
--

CREATE TABLE `tbl_audit_trail` (
  `id` int(11) NOT NULL,
  `old_value` text,
  `new_value` text,
  `action` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `field` varchar(255) DEFAULT NULL,
  `stamp` datetime NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `model_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_audit_trail`
--

INSERT INTO `tbl_audit_trail` (`id`, `old_value`, `new_value`, `action`, `model`, `field`, `stamp`, `user_id`, `model_id`) VALUES
(1, NULL, NULL, 'CREATE', 'common\\models\\ProductManagement', NULL, '2017-08-04 11:18:26', '1', '10'),
(2, '', '10', 'SET', 'common\\models\\ProductManagement', 'id', '2017-08-04 11:18:26', '1', '10'),
(3, '', '123', 'SET', 'common\\models\\ProductManagement', 'product_name', '2017-08-04 11:18:26', '1', '10'),
(4, '', '123', 'SET', 'common\\models\\ProductManagement', 'description', '2017-08-04 11:18:26', '1', '10'),
(5, '', 'products', 'SET', 'common\\models\\ProductManagement', 'product_code', '2017-08-04 11:18:26', '1', '10'),
(6, '', '11', 'SET', 'common\\models\\ProductManagement', 'product_price', '2017-08-04 11:18:26', '1', '10'),
(7, '', '22', 'SET', 'common\\models\\ProductManagement', 'product_cost', '2017-08-04 11:18:26', '1', '10'),
(8, '', 'Type-2', 'SET', 'common\\models\\ProductManagement', 'product_type', '2017-08-04 11:18:26', '1', '10'),
(9, '', 'CAT-B', 'SET', 'common\\models\\ProductManagement', 'product_cat', '2017-08-04 11:18:26', '1', '10'),
(10, NULL, NULL, 'DELETE', 'common\\models\\ProductManagement', NULL, '2017-08-04 11:18:45', '1', '10'),
(11, NULL, NULL, 'CREATE', 'common\\models\\ProductManagement', NULL, '2017-08-04 11:18:54', '1', '11'),
(12, '', '11', 'SET', 'common\\models\\ProductManagement', 'id', '2017-08-04 11:18:54', '1', '11'),
(13, '', '11', 'SET', 'common\\models\\ProductManagement', 'product_name', '2017-08-04 11:18:54', '1', '11'),
(14, '', '2323', 'SET', 'common\\models\\ProductManagement', 'description', '2017-08-04 11:18:54', '1', '11'),
(15, '', 'awrsdsf', 'SET', 'common\\models\\ProductManagement', 'product_code', '2017-08-04 11:18:54', '1', '11'),
(16, '', '123', 'SET', 'common\\models\\ProductManagement', 'product_price', '2017-08-04 11:18:55', '1', '11'),
(17, '', '344', 'SET', 'common\\models\\ProductManagement', 'product_cost', '2017-08-04 11:18:55', '1', '11'),
(18, '', 'Type-2', 'SET', 'common\\models\\ProductManagement', 'product_type', '2017-08-04 11:18:55', '1', '11'),
(19, '', 'CAT-A', 'SET', 'common\\models\\ProductManagement', 'product_cat', '2017-08-04 11:18:55', '1', '11'),
(20, NULL, NULL, 'CREATE', 'common\\models\\ProductManagement', NULL, '2017-08-04 11:37:21', '1', '12'),
(21, '', '12', 'SET', 'common\\models\\ProductManagement', 'id', '2017-08-04 11:37:21', '1', '12'),
(22, '', 'stock1', 'SET', 'common\\models\\ProductManagement', 'product_name', '2017-08-04 11:37:21', '1', '12'),
(23, '', 'stock1', 'SET', 'common\\models\\ProductManagement', 'description', '2017-08-04 11:37:21', '1', '12'),
(24, '', 'stock1', 'SET', 'common\\models\\ProductManagement', 'product_code', '2017-08-04 11:37:21', '1', '12'),
(25, '', '111222', 'SET', 'common\\models\\ProductManagement', 'product_price', '2017-08-04 11:37:21', '1', '12'),
(26, '', '222', 'SET', 'common\\models\\ProductManagement', 'product_cost', '2017-08-04 11:37:22', '1', '12'),
(27, '', 'Type-1', 'SET', 'common\\models\\ProductManagement', 'product_type', '2017-08-04 11:37:22', '1', '12'),
(28, '', 'CAT-A', 'SET', 'common\\models\\ProductManagement', 'product_cat', '2017-08-04 11:37:22', '1', '12'),
(29, NULL, NULL, 'CREATE', 'common\\models\\ProductManagement', NULL, '2017-08-04 11:39:19', '1', '13'),
(30, '', '13', 'SET', 'common\\models\\ProductManagement', 'id', '2017-08-04 11:39:19', '1', '13'),
(31, '', 'InvestStockMetal', 'SET', 'common\\models\\ProductManagement', 'product_name', '2017-08-04 11:39:19', '1', '13'),
(32, '', 'InvestStockMetal', 'SET', 'common\\models\\ProductManagement', 'description', '2017-08-04 11:39:19', '1', '13'),
(33, '', 'InvestStockMetal', 'SET', 'common\\models\\ProductManagement', 'product_code', '2017-08-04 11:39:19', '1', '13'),
(34, '', '111', 'SET', 'common\\models\\ProductManagement', 'product_price', '2017-08-04 11:39:19', '1', '13'),
(35, '', '222', 'SET', 'common\\models\\ProductManagement', 'product_cost', '2017-08-04 11:39:19', '1', '13'),
(36, '', 'Type-2', 'SET', 'common\\models\\ProductManagement', 'product_type', '2017-08-04 11:39:19', '1', '13'),
(37, '', 'CAT-B', 'SET', 'common\\models\\ProductManagement', 'product_cat', '2017-08-04 11:39:19', '1', '13'),
(38, NULL, NULL, 'CREATE', 'common\\models\\ProductManagement', NULL, '2017-08-04 11:39:34', '1', '14'),
(39, '', '14', 'SET', 'common\\models\\ProductManagement', 'id', '2017-08-04 11:39:34', '1', '14'),
(40, '', 'InvestStock', 'SET', 'common\\models\\ProductManagement', 'product_name', '2017-08-04 11:39:34', '1', '14'),
(41, '', 'InvestStock', 'SET', 'common\\models\\ProductManagement', 'description', '2017-08-04 11:39:34', '1', '14'),
(42, '', 'InvestStock', 'SET', 'common\\models\\ProductManagement', 'product_code', '2017-08-04 11:39:34', '1', '14'),
(43, '', '111222', 'SET', 'common\\models\\ProductManagement', 'product_price', '2017-08-04 11:39:34', '1', '14'),
(44, '', '2', 'SET', 'common\\models\\ProductManagement', 'product_cost', '2017-08-04 11:39:34', '1', '14'),
(45, '', 'Type-2', 'SET', 'common\\models\\ProductManagement', 'product_type', '2017-08-04 11:39:34', '1', '14'),
(46, '', 'CAT-C', 'SET', 'common\\models\\ProductManagement', 'product_cat', '2017-08-04 11:39:34', '1', '14'),
(47, NULL, NULL, 'CREATE', 'common\\models\\ProductManagement', NULL, '2017-08-04 11:39:53', '1', '15'),
(48, '', '15', 'SET', 'common\\models\\ProductManagement', 'id', '2017-08-04 11:39:53', '1', '15'),
(49, '', 'InvestNew', 'SET', 'common\\models\\ProductManagement', 'product_name', '2017-08-04 11:39:53', '1', '15'),
(50, '', 'InvestNew', 'SET', 'common\\models\\ProductManagement', 'description', '2017-08-04 11:39:53', '1', '15'),
(51, '', 'InvestNew', 'SET', 'common\\models\\ProductManagement', 'product_code', '2017-08-04 11:39:53', '1', '15'),
(52, '', '1234', 'SET', 'common\\models\\ProductManagement', 'product_price', '2017-08-04 11:39:53', '1', '15'),
(53, '', '444', 'SET', 'common\\models\\ProductManagement', 'product_cost', '2017-08-04 11:39:53', '1', '15'),
(54, '', 'Type-2', 'SET', 'common\\models\\ProductManagement', 'product_type', '2017-08-04 11:39:53', '1', '15'),
(55, '', 'CAT-B', 'SET', 'common\\models\\ProductManagement', 'product_cat', '2017-08-04 11:39:53', '1', '15'),
(56, NULL, NULL, 'CREATE', 'common\\models\\WithdrawLine', NULL, '2017-08-04 14:36:34', '1', '12'),
(57, '', '12', 'SET', 'common\\models\\WithdrawLine', 'id', '2017-08-04 14:36:35', '1', '12'),
(58, '', '4', 'SET', 'common\\models\\WithdrawLine', 'header_id', '2017-08-04 14:36:35', '1', '12'),
(59, '', '111', 'SET', 'common\\models\\WithdrawLine', 'withdraw', '2017-08-04 14:36:35', '1', '12'),
(60, '', '2017-08-04', 'SET', 'common\\models\\WithdrawLine', 'date_added', '2017-08-04 14:36:35', '1', '12'),
(61, NULL, NULL, 'CREATE', 'common\\models\\WithdrawLine', NULL, '2017-08-04 14:37:37', '1', '13'),
(62, '', '13', 'SET', 'common\\models\\WithdrawLine', 'id', '2017-08-04 14:37:37', '1', '13'),
(63, '', '3', 'SET', 'common\\models\\WithdrawLine', 'header_id', '2017-08-04 14:37:37', '1', '13'),
(64, '', '-112', 'SET', 'common\\models\\WithdrawLine', 'withdraw', '2017-08-04 14:37:37', '1', '13'),
(65, '', '2017-08-04', 'SET', 'common\\models\\WithdrawLine', 'date_added', '2017-08-04 14:37:37', '1', '13');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `user_group_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `user_group_id`) VALUES
(1, 'admin', 'vkauDPlJsls4WFXgbTyREHmMbywJFuDL', '$2y$13$xCY8sL.kywvpq7vFNl5dsemsn70YfKPe67NRMgiViEKsaw/ad6Ugu', NULL, 'admin@admin.com', 10, 1501040056, 1501040056, 'Admin'),
(5, 'theta', 'bckFnYqpJeSwY_OHb6uONo1m3YPQ19Gg', '$2y$13$/L4F.VJLSkrpfkEGPfvRnud/k8TfbBogsfOpnFDHmAKMF8pi9x3jy', NULL, 'theta@th.c', 10, 1501234133, 1501235679, 'Admin'),
(6, 'staff01', 'HztrRFRB_i9OUbIaW51a_x1hlFbTlizF', '$2y$13$f4/jOHZ/CGftA17kdJNCl.9EIdeA0BRdaFJSQuzdzi1kAKYUbceVG', NULL, 'staff01@staff01.c', 10, 1501576594, 1501576594, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `usergroup` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`id`, `usergroup`, `description`) VALUES
(5, 'Admin', 'Admin Group'),
(6, 'Staff', 'Staff group'),
(7, 'Manager', 'Manager group sectionas');

-- --------------------------------------------------------

--
-- Table structure for table `user_management`
--

CREATE TABLE `user_management` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(75) NOT NULL,
  `user_group` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `email` varchar(75) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `mobile` int(13) NOT NULL,
  `remark` text NOT NULL,
  `login_id` varchar(25) NOT NULL,
  `login_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_management`
--

INSERT INTO `user_management` (`id`, `user_id`, `name`, `user_group`, `department`, `email`, `nationality`, `address`, `mobile`, `remark`, `login_id`, `login_password`) VALUES
(4, 5, 'theta', 'Admin', 'Finance', 'theta@th.c', 'caaa', '123', 123, '123', 'theta', '$2y$13$/L4F.VJLSkrpfkEGPfvRnud/k8TfbBogsfOpnFDHmAKMF8pi9x3jy'),
(5, 6, 'staff01', 'Staff', 'Sales', 'staff01@staff01.c', '123', '111', 222, 'w222', 'staff01', '$2y$13$f4/jOHZ/CGftA17kdJNCl.9EIdeA0BRdaFJSQuzdzi1kAKYUbceVG');

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `id` int(11) NOT NULL,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `user_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_permission`
--

INSERT INTO `user_permission` (`id`, `controller`, `action`, `user_group_id`) VALUES
(1, 'Customer', 'index', 5),
(2, 'Customer', 'view', 5),
(3, 'Customer', 'create', 5),
(4, 'Customer', 'update', 5),
(5, 'Customer', 'delete', 5),
(6, 'Customer', 'index', 6),
(7, 'Customer', 'view', 6),
(8, 'Customer', 'create', 6),
(9, 'Customer', 'update', 6),
(10, 'Customer', 'delete', 6),
(11, 'Customer', 'index', 7),
(12, 'Customer', 'view', 7),
(13, 'Customer', 'create', 7),
(14, 'Customer', 'update', 7),
(15, 'Customer', 'delete', 7),
(16, 'UserPermission', 'permission-setting', 5),
(17, 'CustomerGroup', 'index', 5),
(18, 'CustomerGroup', 'view', 5),
(19, 'CustomerGroup', 'create', 5),
(20, 'CustomerGroup', 'update', 5),
(21, 'CustomerGroup', 'delete', 5),
(22, 'Department', 'index', 5),
(23, 'Department', 'view', 5),
(24, 'Department', 'create', 5),
(25, 'Department', 'update', 5),
(26, 'Department', 'delete', 5),
(27, 'ProductCategory', 'index', 5),
(28, 'ProductCategory', 'view', 5),
(29, 'ProductCategory', 'create', 5),
(30, 'ProductCategory', 'update', 5),
(31, 'ProductCategory', 'delete', 5),
(32, 'ProductManagement', 'index', 5),
(33, 'ProductManagement', 'view', 5),
(34, 'ProductManagement', 'create', 5),
(35, 'ProductManagement', 'update', 5),
(36, 'ProductManagement', 'delete', 5),
(37, 'ProductType', 'index', 5),
(38, 'ProductType', 'view', 5),
(39, 'ProductType', 'create', 5),
(40, 'ProductType', 'update', 5),
(41, 'ProductType', 'delete', 5),
(42, 'UserGroup', 'index', 5),
(43, 'UserGroup', 'view', 5),
(44, 'UserGroup', 'create', 5),
(45, 'UserGroup', 'update', 5),
(46, 'UserGroup', 'delete', 5),
(47, 'UserManagement', 'index', 5),
(48, 'UserManagement', 'view', 5),
(49, 'UserManagement', 'create', 5),
(50, 'UserManagement', 'update', 5),
(51, 'UserManagement', 'delete', 5),
(52, 'Announcement', 'index', 6),
(53, 'Announcement', 'view', 6),
(54, 'Announcement', 'index', 5),
(55, 'Announcement', 'view', 5),
(56, 'Announcement', 'create', 5),
(57, 'Announcement', 'update', 5),
(58, 'Announcement', 'delete', 5),
(59, 'DepositHead', 'index', 5),
(60, 'DepositHead', 'view', 5),
(61, 'DepositHead', 'create', 5),
(62, 'DepositHead', 'update', 5),
(63, 'DepositHead', 'delete', 5),
(64, 'Withdraw', 'index', 5),
(65, 'Withdraw', 'view', 5),
(66, 'Withdraw', 'create', 5),
(67, 'Withdraw', 'update', 5),
(68, 'Withdraw', 'delete', 5),
(69, 'Withdraw', 'index', 6),
(70, 'Withdraw', 'view', 6);

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_head`
--

CREATE TABLE `withdraw_head` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL COMMENT 'customer''s unique id based on the customer table',
  `customer` varchar(100) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `withdraw_head`
--

INSERT INTO `withdraw_head` (`id`, `customer_id`, `customer`, `date_created`) VALUES
(2, 8, 'Nebula', '2017-08-01'),
(3, 9, 'Zarudo', '2017-08-01'),
(4, 10, 'new customer', '2017-08-02');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_line`
--

CREATE TABLE `withdraw_line` (
  `id` int(11) NOT NULL,
  `header_id` int(11) NOT NULL,
  `withdraw` decimal(11,2) NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `withdraw_line`
--

INSERT INTO `withdraw_line` (`id`, `header_id`, `withdraw`, `date_added`) VALUES
(4, 2, '1234.00', '2017-08-01'),
(5, 2, '122.00', '2017-08-01'),
(6, 3, '355.00', '2017-08-01'),
(7, 3, '222.00', '2017-08-01'),
(8, 3, '34343.00', '2017-08-01'),
(9, 2, '9999.00', '2017-08-01'),
(10, 3, '5000.00', '2017-08-01'),
(11, 2, '9000.00', '2017-08-01'),
(12, 4, '111.00', '2017-08-04'),
(13, 3, '-112.00', '2017-08-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country_capital`
--
ALTER TABLE `country_capital`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country_code`
--
ALTER TABLE `country_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_group`
--
ALTER TABLE `customer_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit_head`
--
ALTER TABLE `deposit_head`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer` (`customer`);

--
-- Indexes for table `deposit_line`
--
ALTER TABLE `deposit_line`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invest_metal`
--
ALTER TABLE `invest_metal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invest_metal_line`
--
ALTER TABLE `invest_metal_line`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invest_metal_price`
--
ALTER TABLE `invest_metal_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invest_stock`
--
ALTER TABLE `invest_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invest_stock_line`
--
ALTER TABLE `invest_stock_line`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_management`
--
ALTER TABLE `product_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_audit_trail`
--
ALTER TABLE `tbl_audit_trail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_trail_user_id` (`user_id`),
  ADD KEY `idx_audit_trail_model_id` (`model_id`),
  ADD KEY `idx_audit_trail_model` (`model`),
  ADD KEY `idx_audit_trail_field` (`field`),
  ADD KEY `idx_audit_trail_action` (`action`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_management`
--
ALTER TABLE `user_management`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login_id` (`login_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_head`
--
ALTER TABLE `withdraw_head`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer` (`customer`);

--
-- Indexes for table `withdraw_line`
--
ALTER TABLE `withdraw_line`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `country_capital`
--
ALTER TABLE `country_capital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `country_code`
--
ALTER TABLE `country_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `customer_group`
--
ALTER TABLE `customer_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `deposit_head`
--
ALTER TABLE `deposit_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `deposit_line`
--
ALTER TABLE `deposit_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `invest_metal`
--
ALTER TABLE `invest_metal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `invest_metal_line`
--
ALTER TABLE `invest_metal_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `invest_metal_price`
--
ALTER TABLE `invest_metal_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invest_stock`
--
ALTER TABLE `invest_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `invest_stock_line`
--
ALTER TABLE `invest_stock_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `product_management`
--
ALTER TABLE `product_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_audit_trail`
--
ALTER TABLE `tbl_audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_management`
--
ALTER TABLE `user_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT for table `withdraw_head`
--
ALTER TABLE `withdraw_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `withdraw_line`
--
ALTER TABLE `withdraw_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
