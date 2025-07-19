-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 27, 2025 at 12:24 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `photo`, `password`, `token`, `role`, `status`) VALUES
(1, 'John Doe', 'admin@example.com', '1696430317.jpg', '$2y$10$ZWxErZpXCc8M34cN57tA.OD0b/n/w5CjCZITFXtoObQ3xMkkiiPL6', '', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charge` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `name`, `charge`) VALUES
(1, 'Free Shipping (10+ days)', 0),
(2, 'Inside City', 20),
(3, 'Outside City', 50);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish_date` date NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `name`, `email`, `content`, `publish_date`, `status`) VALUES
(1, 5, 'Peter', 'peter@example.com', 'This is a very nice website.', '2025-05-26', 'Approved'),
(2, 5, 'Brendon', 'brendon@example.com', 'Awesome post. This is a very nice practical post. I will follow this.', '2025-05-26', 'Approved'),
(3, 5, 'Matt', 'support@gravatar.com', 'This article was very informative. Thanks for sharing!', '2025-05-26', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` int NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `maximum_use` int NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount`, `type`, `start_date`, `end_date`, `maximum_use`, `status`) VALUES
(1, 'HOLIDAY', 20, 'Percentage', '2025-05-20', '2025-05-24', 2, 'Active'),
(2, 'COMMON', 10, 'Fixed', '2025-05-20', '2025-05-25', 1, 'Active'),
(3, 'TEST1', 5, 'Fixed', '2025-05-25', '2025-05-28', 3, 'Active'),
(4, 'TEST2', 5, 'Fixed', '2025-05-19', '2025-05-24', 4, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `password`, `token`, `status`) VALUES
(1, 'Mister John', 'john@example.com', '+1 (777) 777-7777', '33, Test Street, Test City, USA', '$2y$10$QKcd.02K9u/2OrVnQ.0rUORzJJOzgshQFpGvGNm7vu2aiw/7fpgsu', '', 'Active'),
(2, 'Smith Cooper', 'smith@example.com', '+1 (666) 666-6666', '44, Test Street, Test City, USA', '$2y$10$a7/5ojhXCu2v0cDyk/U2qunVG6aRIsulE7zqa.4t6mLZdxBWXOvS.', '', 'Active'),
(3, 'Knox Downs', 'knox@example.com', '+1 (555) 555-5555', '22, Test Street, Test City, USA', '$2y$10$WKf4TIRI1IT9e4a0zksk2u1QEx.eEPMb4M1bkWCdJAWDKcaI4HtzC', '', 'Inactive'),
(4, 'Carl Hex', 'carl@example.com', '+1 (444) 444-4444', '11, Test Street, Test City, USA', '$2y$10$hGttE9RvIXlr02eVo42RD.duy1iFz9PwVPkFD.Ta6db5bB61qjZrW', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`) VALUES
(1, 'Lorem ipsum dolor sit amet, sit posse?', 'Lorem ipsum dolor sit amet, sit posse vocent splendide at, eripuit nostrum deterruisset te quo. Est at reque impedit, eam nusquam suscipit an. Sed at suas tota sententiae, ex sit prima facete noluisse. Est possit noluisse id. No quas melius mediocrem his, et verear definitiones vel, duo no tale eirmod.'),
(2, 'Cum in veritus corrumpit gubergren mucius?', 'Cum in veritus corrumpit gubergren. Mucius vituperatoribus ea sit, te patrioque elaboraret vel, has denique senserit at. Eos probo nemore eripuit eu. Persius civibus pro ei, ex commune quaestio delicata qui. Has cu liber aperiri blandit, mea ei dicat vitae concludaturque. Omnis paulo ei duo, ei autem viderer lucilius vim.'),
(3, 'In sit prompta aliquam viris audire eu ius?', 'In sit prompta aliquam. Viris audire eu ius, homero quidam dissentias mei ne. Tibique contentiones ex eos, integre deterruisset delicatissimi sit et. Pro cu posse deleniti. Purto civibus dissentias no mea, mel id ludus molestiae, solet indoctum vituperatoribus nam id. Et alii verear has.'),
(4, 'Porro omnesque deseruisse usu at ut vim?', 'Porro omnesque deseruisse usu at, ut vim omnes laoreet singulis. Nec eius eleifend laboramus ex, has eu soluta vidisse iracundia. Erant salutandi definiebas vim id. Ex aeque nonumes recusabo sed, alii iudico ne mel. Duo quod principes consequat in. Harum aliquando pertinacia ne nam, has nominati posidonium ut.'),
(5, 'Oportere corrumpit laboramus vel ut?', 'Oportere corrumpit laboramus vel ut. Tale volutpat suscipiantur sit ne. Ex vis probo tincidunt rationibus, id per omittam deserunt explicari, vim et inani euripidis. Nihil nullam eos ex, eam et posse ornatus recteque. Detracto lobortis comprehensam et mea.'),
(6, 'Ex errem consul labore cum, legendos hendrerit?', 'Ex errem consul labore cum, legendos hendrerit ut cum. Ne est justo dolorum consequuntur, ei est graecis senserit. Sea suas instructior ei, veritus hendrerit cum an. Vix at omittam percipitur omittantur, usu ut dicta deleniti philosophia, no falli nullam tractatos eum. Corpora vulputate ei vel, eu omnium mentitum facilisi vis.'),
(7, 'At vix sint veniam definiebas vix eu cetero?', 'At vix sint veniam definiebas. Vix eu cetero adolescens sententiae, vide accusata ad qui. Qui te eleifend corrumpit dignissim, sed possim vocibus epicurei cu, id tempor senserit assentior duo. Id vix tale senserit, aperiri habemus mnesarchum vix id. Vim dicant inimicus et, in minim debet essent nam, essent copiosae recusabo ut vim.'),
(8, 'Qui ea debet elitr efficiantur, putant accusata?', 'Qui ea debet elitr efficiantur, putant accusata conceptam nam ei. Cu per timeam volumus reprehendunt, mea ferri exerci et. Duo ne soleat ubique sententiae, vitae nominavi percipit cum et. Vis debitis fastidii in, an mel error zril oratio, eos deleniti deserunt cu. Dicat causae alienum no sed, at mel illum tollit euismod. Illum numquam splendide has et, sed at quem partiendo gloriatur.'),
(9, 'Et omnium expetendis has, id purto semper?', 'Et omnium expetendis has, id purto semper repudiare pri, sit erat fierent id. Habeo molestie in est, qui ei quot conceptam vituperata. In idque legere sea. Ei brute nihil hendrerit eam. At pro accusamus accommodare theophrastus.'),
(10, 'Vero accusam abhorreant ut quo?', 'Vero accusam abhorreant ut quo. Alia iudicabit omittantur mei ut, evertitur dissentiet ad quo, est equidem similique ei. Sonet oratio salutatus id pri, aliquam scripserit te vim. Suas mediocrem consequuntur nec an. Duo et idque elitr accusata, similique abhorreant nec id.'),
(11, 'Apeirian imperdiet vix te, no est decore?', 'Apeirian imperdiet vix te, no est decore detraxit accusamus. Aeterno laoreet volutpat est cu, id ius elitr antiopam electram. Est quodsi concludaturque et, facilisis democritum constituto vel in. Ea nam tacimates neglegentur, oporteat erroribus in qui. Qui purto platonem dignissim no, et aeque consul per.'),
(12, 'Mollis tibique maiestatis eu ius?', 'Mollis tibique maiestatis eu ius. Vis no dicit exerci quaerendum, no sit sonet facilis. Accumsan copiosae officiis ad vel, pro nominavi phaedrum gloriatur ut. Autem graeco prompta in sea. Duo perfecto senserit an.');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `order_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_date` date NOT NULL,
  `subtotal` float NOT NULL,
  `shipping_cost` float NOT NULL,
  `coupon_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` float NOT NULL,
  `total` float NOT NULL,
  `status` enum('Pending','Paid','Processing','Shipped','Delivered','Cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_no`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `payment_method`, `order_date`, `subtotal`, `shipping_cost`, `coupon_code`, `discount`, `total`, `status`) VALUES
(2, 'ORD-1747895978-953', 'Smith', 'smith@example.com', '01912000000', '333, Sample Street, City, Country, 22222', 'PayPal', '2025-05-22', 98, 20, 'HOLIDAY', 19.6, 98.4, 'Shipped'),
(3, 'ORD-1747896397431', 'Rebecca Robertson', 'rebecca@example.com', '+1 (111) 222-3333', '34, Velit modi laborum e', 'PayPal', '2025-05-22', 74, 20, NULL, 0, 94, 'Paid'),
(4, 'ORD-1747901310295', 'Mister John', 'john@example.com', '222-333-4444', '34, Test Street, Test City, USA', 'Stripe', '2025-05-22', 187, 20, NULL, 0, 207, 'Paid'),
(5, 'ORD-1747903071591', 'Dell Park', 'dell@example.com', '+1 (444) 444-4444', '77, Aut tempore perspic', 'Cash on Delivery', '2025-05-22', 99, 50, NULL, 0, 149, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `order_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` float NOT NULL,
  `product_quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `order_no`, `product_id`, `product_name`, `product_price`, `product_quantity`) VALUES
(3, 2, 'ORD-1747895978-953', 1, 'Rhona Oliver', 29, 2),
(4, 2, 'ORD-1747895978-953', 2, 'Jordan Wallace', 20, 2),
(5, 3, 'ORD-1747896397431', 5, 'Hedley Moran', 15, 3),
(6, 3, 'ORD-1747896397431', 1, 'Rhona Oliver', 29, 1),
(7, 4, 'ORD-1747901310295', 1, 'Rhona Oliver', 29, 1),
(8, 4, 'ORD-1747901310295', 4, 'Malik Hart', 79, 2),
(9, 5, 'ORD-1747903071591', 5, 'Hedley Moran', 15, 2),
(10, 5, 'ORD-1747903071591', 6, 'James Moody', 69, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `terms_content` longtext COLLATE utf8mb4_unicode_ci,
  `privacy_content` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `terms_content`, `privacy_content`) VALUES
(1, '<p>Lorem ipsum dolor sit amet, vidit senserit pri ut, dolor eripuit detraxit et qui, mei duis graeco inermis in. Eligendi verterem voluptatibus ut vel. Vim periculis abhorreant constituto eu, aliquid laboramus ne per. An scripta erroribus cum, ne zril veritus pro, ne vis saepe quaeque ceteros.</p>\r\n<p>Ex cum impetus vidisse labitur, omnis noluisse ut pro. Indoctum patrioque assentior qui eu. An veri postulant honestatis pro, cu nihil saepe dicant sea, usu paulo dicunt inimicus ei. Exerci aeterno intellegam eu vix, eius admodum ne sed. Antiopam laboramus constituam est eu, vim affert oratio voluptaria in. Ex duo copiosae inimicus, ut est sonet quaeque.</p>\r\n<p>Id eam vitae soluta explicari, quo delectus reprimique complectitur ad. Quot debet quodsi ea vis, adolescens definiebas disputando nec et. Eam graecis accusam assentior in. Nam amet iriure eleifend at, cum soleat nominati an, nam mentitum percipit ut. Dicta iuvaret id sed, an mei graeci dissentias. Facer minim inciderint sit at, ad qui possim patrioque sententiae.</p>\r\n<p>Pri ad novum moderatius, ne mea graece doming, et sed dico putent timeam. Assum volutpat has cu, vocent omittam qui an, doming vituperatoribus in pri. Ei nibh quidam mea, no inani apeirian scribentur mea. Sadipscing necessitatibus est et. Per ne nobis malorum explicari.</p>', '<p>Lorem ipsum dolor sit amet, vidit senserit pri ut, dolor eripuit detraxit et qui, mei duis graeco inermis in. Eligendi verterem voluptatibus ut vel. Vim periculis abhorreant constituto eu, aliquid laboramus ne per. An scripta erroribus cum, ne zril veritus pro, ne vis saepe quaeque ceteros.</p>\r\n<p>Ex cum impetus vidisse labitur, omnis noluisse ut pro. Indoctum patrioque assentior qui eu. An veri postulant honestatis pro, cu nihil saepe dicant sea, usu paulo dicunt inimicus ei. Exerci aeterno intellegam eu vix, eius admodum ne sed. Antiopam laboramus constituam est eu, vim affert oratio voluptaria in. Ex duo copiosae inimicus, ut est sonet quaeque.</p>\r\n<p>Id eam vitae soluta explicari, quo delectus reprimique complectitur ad. Quot debet quodsi ea vis, adolescens definiebas disputando nec et. Eam graecis accusam assentior in. Nam amet iriure eleifend at, cum soleat nominati an, nam mentitum percipit ut. Dicta iuvaret id sed, an mei graeci dissentias. Facer minim inciderint sit at, ad qui possim patrioque sententiae.</p>\r\n<p>Pri ad novum moderatius, ne mea graece doming, et sed dico putent timeam. Assum volutpat has cu, vocent omittam qui an, doming vituperatoribus in pri. Ei nibh quidam mea, no inani apeirian scribentur mea. Sadipscing necessitatibus est et. Per ne nobis malorum explicari.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `post_category_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `post_category_id`, `title`, `slug`, `content`, `photo`, `tags`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ius vitae appellantur deterruisset', 'ius-vitae-appellantur', '<p>Lorem ipsum dolor sit amet, ius vitae appellantur deterruisset ad, zril adolescens mea in, ut eum solet alienum sensibus. Ius amet definiebas an. Vix iusto tantas ei. Vix in tota possit delicatissimi, his at tempor admodum. Eu pro probatus neglegentur, veniam expetenda te has.<br /><br />Eum ei labores omittantur. Pro probo reque vulputate no, vero natum percipit eum ea. Reque blandit sed ad, eos delectus delicata necessitatibus ei. Ea dico recusabo quo, vis ad everti doctus qualisque. Per fastidii eloquentiam ad, epicuri aliquando ut sed.<br /><br />Vel ne dictas luptatum. Sea errem detraxit postulant ea. Ei wisi quidam scaevola sed, ut sit affert nonumes deterruisset, praesent qualisque expetendis pri in. Ne pro melius labitur fierent, te vix consul fastidii. Est no antiopam intellegebat signiferumque.</p>', 'post_1748147524.jpg', 'food,fashion,travel,bag', '2025-05-25', '2025-05-25'),
(2, 5, 'Vel ne dictas luptatum sea', 'vel-ne-dictas-luptatum', '<p>Vel ne dictas luptatum. Sea errem detraxit postulant ea. Ei wisi quidam scaevola sed, ut sit affert nonumes deterruisset, praesent qualisque expetendis pri in. Ne pro melius labitur fierent, te vix consul fastidii. Est no antiopam intellegebat signiferumque.<br /><br />Cu elit dissentiet vis. Per homero appetere ad, ne eum partem discere. Ferri partiendo ea mel. Sea ad populo detracto democritum, ex nam option delenit.<br /><br />Movet scripserit ne vis. Cu lorem detracto periculis est. Singulis pertinax moderatius pro at, blandit noluisse in mei. Pri ferri mediocritatem ea. Est case omnium sententiae eu, mei detracto conceptam an.</p>', 'post_1748147595.jpg', 'fashion,blue,color', '2025-05-25', '2025-05-25'),
(3, 4, 'Cu elit dissentiet vis per', 'cu-elit-dissentiet-vis', '<p>Cu elit dissentiet vis. Per homero appetere ad, ne eum partem discere. Ferri partiendo ea mel. Sea ad populo detracto democritum, ex nam option delenit.<br /><br />Movet scripserit ne vis. Cu lorem detracto periculis est. Singulis pertinax moderatius pro at, blandit noluisse in mei. Pri ferri mediocritatem ea. Est case omnium sententiae eu, mei detracto conceptam an.<br /><br />Ex delenit aliquando sit. Eum ei paulo nemore petentium. Novum senserit definitiones sed in. Eum ad lorem gubergren laboramus. Justo principes efficiendi ne pro, eos duis omnesque ei, ullum iudico in sed. Quodsi deseruisse mel eu, pri euismod recteque theophrastus ad.</p>', 'post_1748147640.jpg', 'nice,beautiful,bag,fashion', '2025-05-25', '2025-05-25'),
(4, 5, ' Movet scripserit ne vis', 'movet-scripserit-ne-vis', '<p><br />Movet scripserit ne vis. Cu lorem detracto periculis est. Singulis pertinax moderatius pro at, blandit noluisse in mei. Pri ferri mediocritatem ea. Est case omnium sententiae eu, mei detracto conceptam an.<br /><br />Ex delenit aliquando sit. Eum ei paulo nemore petentium. Novum senserit definitiones sed in. Eum ad lorem gubergren laboramus. Justo principes efficiendi ne pro, eos duis omnesque ei, ullum iudico in sed. Quodsi deseruisse mel eu, pri euismod recteque theophrastus ad.<br /><br />Ei porro sonet reprehendunt quo, cum in dictas lucilius efficiantur. Ex ius partem voluptaria, mei et eros impedit, id per natum appareat incorrupte. Corpora consequat assentior ea eum, per possim theophrastus ad. Ex pri paulo dicam verterem, id nec homero laboramus prodesset.</p>', 'post_1748147704.jpg', 'furniture,fashion,business', '2025-05-25', '2025-05-25'),
(5, 6, 'Ex delenit aliquando sit', 'ex-delenit-aliquando-sit', '<p>Ex delenit aliquando sit. Eum ei paulo nemore petentium. Novum senserit definitiones sed in. Eum ad lorem gubergren laboramus. Justo principes efficiendi ne pro, eos duis omnesque ei, ullum iudico in sed. Quodsi deseruisse mel eu, pri euismod recteque theophrastus ad.<br /><br />Ei porro sonet reprehendunt quo, cum in dictas lucilius efficiantur. Ex ius partem voluptaria, mei et eros impedit, id per natum appareat incorrupte. Corpora consequat assentior ea eum, per possim theophrastus ad. Ex pri paulo dicam verterem, id nec homero laboramus prodesset.<br /><br />Usu doming intellegam vituperatoribus an, cum ei tantas legendos similique, viris propriae expetenda cum an. Choro menandri assentior nam ne, indoctum ocurreret cu his. Sit ludus menandri te, vel iuvaret maiorum splendide te, porro nihil splendide pri ut. Duo ne scripta splendide. Eum at quem scriptorem.</p>', 'post_1748147734.jpg', 'furniture,food', '2025-05-25', '2025-05-25'),
(6, 2, ' Nam ullum paulo nete', 'nam-ullum-paulo-nete', '<p><br />Nam ullum paulo ne, te nostrud meliore singulis mea. Qui eirmod salutandi incorrupte et. Maluisset dignissim ei sed, his quem omnes eu. Ei causae omnesque mel, at his decore ponderum sententiae. Tantas putent admodum te est, justo inermis an sit. His in debet vocibus ocurreret.<br /><br />Zril insolens vel et, omnium invidunt in his. Cu eum case homero viderer. Rebum harum postulant eu nam. Pri harum noluisse persecuti ut.<br /><br />Ut nam alii dignissim delicatissimi, legere tacimates ea est. Sed alia solum cu. An choro abhorreant cum, sit sapientem maluisset no. Id pri everti fastidii definiebas, nec labore lobortis postulant in, te qui wisi timeam. An cetero splendide sea, est dicta volutpat conclusionemque te, pro saepe nemore aliquip ex.</p>', 'post_1748147765.jpg', 'dining,food', '2025-05-25', '2025-05-25'),
(7, 5, 'Ad per commodo rationibus', 'ad-per-commodo-rationibus', '<p>Ad per commodo rationibus omittantur, ne appareat ponderum cum, eu modus lucilius deserunt duo. Est enim postulant cu, has ex diam aeterno. Et fabellas expetenda scripserit vix, ei mea ornatus persequeris. An his sint graeco officiis, duo commodo salutatus ei. Ei mel atqui laoreet deseruisse, ut ridens tibique sadipscing vix, ne liber cotidieque ius.<br /><br />Mazim aperiam iudicabit mel ex, mel ex accusamus omittantur, dicam recteque cum ut. Ei habeo ipsum fuisset eos. Ea eos dicit praesent, ei graeco reformidans ius. Mei tation rationibus theophrastus at. Agam omnis id mel, ei mel forensibus adolescens, elitr prompta accumsan qui ei.</p>', 'post_1748147816.jpg', 'travel,food,business,home,hotel', '2025-05-25', '2025-05-25');

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_categories`
--

INSERT INTO `post_categories` (`id`, `name`, `slug`) VALUES
(1, 'Post Category 1', 'post-category-1'),
(2, 'Post Category 2', 'post-category-2'),
(3, 'Post Category 3', 'post-category-3'),
(4, 'Post Category 4', 'post-category-4'),
(5, 'Post Category 5', 'post-category-5'),
(6, 'Post Category 6', 'post-category-6');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `product_category_id` int NOT NULL,
  `featured_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `regular_price` float DEFAULT NULL,
  `sale_price` float DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pocket` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `water_resistant` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warranty` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_sale` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_category_id`, `featured_photo`, `name`, `slug`, `quantity`, `regular_price`, `sale_price`, `short_description`, `description`, `sku`, `size`, `color`, `capacity`, `weight`, `pocket`, `water_resistant`, `warranty`, `total_sale`) VALUES
(1, 1, 'product_1747666510.jpg', 'Rhona Oliver', 'rhona-oliver', 6, 34, 29, 'Per ea docendi assueverit, inani tempor molestiae mei cu. Justo nonumes atomorum ex pri. Vel erant saperet facilisis at. His ad cetero euripidis ullamcorper. Inermis ocurreret eos et, oportere patrioque cum et. ', '<p>Lorem ipsum dolor sit amet, per atqui omittantur et, reque dolor quando usu at, eu falli placerat salutandi nam. Duo ea enim sanctus, ne sumo munere consulatu eos. Prompta suavitate cum et, tritani invidunt usu ne. An iusto indoctum persecuti mel, qui no diceret apeirian singulis. Solet prodesset ut sea, mel cu verear voluptua. At nam sale semper persius, eum decore splendide in.<br /><br />Per ea docendi assueverit, inani tempor molestiae mei cu. Justo nonumes atomorum ex pri. Vel erant saperet facilisis at. His ad cetero euripidis ullamcorper. Inermis ocurreret eos et, oportere patrioque cum et. Nam mundi euismod saperet eu, sed amet verear moderatius ei. Per doctus tacimates at, an illud semper per, et nec labores luptatum. Ne pro ceteros recusabo salutatus. Pri ut essent pertinacia.<br /><br />Eam fabulas omittam pertinacia ei, per soluta maiorum an. Mei no elitr efficiendi delicatissimi, option ponderum intellegebat vel an. Vel dolorum accumsan convenire ei, pro ei quot moderatius. Magna iusto omnium quo ad. Id vim libris scriptorem, tamquam laoreet eos ne.</p>', 'AA1', '12', 'Red', '1 Litre', '230 gm', '4', 'Yes', '2 years', 4),
(2, 2, 'product_1747713047.jpg', 'Jordan Wallace', 'jordan-wallace', 0, 20, 20, 'Per ea docendi assueverit, inani tempor molestiae mei cu. Justo nonumes atomorum ex pri. Vel erant saperet facilisis at. His ad cetero euripidis ullamcorper. Inermis ocurreret eos et, oportere patrioque cum et. ', '<p>Lorem ipsum dolor sit amet, per atqui omittantur et, reque dolor quando usu at, eu falli placerat salutandi nam. Duo ea enim sanctus, ne sumo munere consulatu eos. Prompta suavitate cum et, tritani invidunt usu ne. An iusto indoctum persecuti mel, qui no diceret apeirian singulis. Solet prodesset ut sea, mel cu verear voluptua. At nam sale semper persius, eum decore splendide in.<br /><br />Per ea docendi assueverit, inani tempor molestiae mei cu. Justo nonumes atomorum ex pri. Vel erant saperet facilisis at. His ad cetero euripidis ullamcorper. Inermis ocurreret eos et, oportere patrioque cum et. Nam mundi euismod saperet eu, sed amet verear moderatius ei. Per doctus tacimates at, an illud semper per, et nec labores luptatum. Ne pro ceteros recusabo salutatus. Pri ut essent pertinacia.<br /><br />Eam fabulas omittam pertinacia ei, per soluta maiorum an. Mei no elitr efficiendi delicatissimi, option ponderum intellegebat vel an. Vel dolorum accumsan convenire ei, pro ei quot moderatius. Magna iusto omnium quo ad. Id vim libris scriptorem, tamquam laoreet eos ne.</p>\r\n<p>&nbsp;</p>', 'HHH1111', '20x15x10', 'Green, Blue, Purple', '2 Ltr', '400 gm', '6', 'No', '', 2),
(3, 3, 'product_1747713400.jpg', 'Edan Aguirre', 'edan-aguirre', 0, 49, 29, 'Per ea docendi assueverit, inani tempor molestiae mei cu. Justo nonumes atomorum ex pri. Vel erant saperet facilisis at. His ad cetero euripidis ullamcorper. Inermis ocurreret eos et, oportere patrioque cum et. ', '<p>Lorem ipsum dolor sit amet, per atqui omittantur et, reque dolor quando usu at, eu falli placerat salutandi nam. Duo ea enim sanctus, ne sumo munere consulatu eos. Prompta suavitate cum et, tritani invidunt usu ne. An iusto indoctum persecuti mel, qui no diceret apeirian singulis. Solet prodesset ut sea, mel cu verear voluptua. At nam sale semper persius, eum decore splendide in.<br /><br />Per ea docendi assueverit, inani tempor molestiae mei cu. Justo nonumes atomorum ex pri. Vel erant saperet facilisis at. His ad cetero euripidis ullamcorper. Inermis ocurreret eos et, oportere patrioque cum et. Nam mundi euismod saperet eu, sed amet verear moderatius ei. Per doctus tacimates at, an illud semper per, et nec labores luptatum. Ne pro ceteros recusabo salutatus. Pri ut essent pertinacia.<br /><br />Eam fabulas omittam pertinacia ei, per soluta maiorum an. Mei no elitr efficiendi delicatissimi, option ponderum intellegebat vel an. Vel dolorum accumsan convenire ei, pro ei quot moderatius. Magna iusto omnium quo ad. Id vim libris scriptorem, tamquam laoreet eos ne.</p>', 'AA111', '25x20', 'Red, Green', '2 ltr', '230 gm', '2', 'Yes', '3 years', 0),
(4, 1, 'product_1747713479.jpg', 'Malik Hart', 'malik-hart', 1, 127, 79, 'Per ea docendi assueverit, inani tempor molestiae mei cu. Justo nonumes atomorum ex pri. Vel erant saperet facilisis at. His ad cetero euripidis ullamcorper. Inermis ocurreret eos et, oportere patrioque cum et. ', '<p>Lorem ipsum dolor sit amet, per atqui omittantur et, reque dolor quando usu at, eu falli placerat salutandi nam. Duo ea enim sanctus, ne sumo munere consulatu eos. Prompta suavitate cum et, tritani invidunt usu ne. An iusto indoctum persecuti mel, qui no diceret apeirian singulis. Solet prodesset ut sea, mel cu verear voluptua. At nam sale semper persius, eum decore splendide in.<br /><br />Per ea docendi assueverit, inani tempor molestiae mei cu. Justo nonumes atomorum ex pri. Vel erant saperet facilisis at. His ad cetero euripidis ullamcorper. Inermis ocurreret eos et, oportere patrioque cum et. Nam mundi euismod saperet eu, sed amet verear moderatius ei. Per doctus tacimates at, an illud semper per, et nec labores luptatum. Ne pro ceteros recusabo salutatus. Pri ut essent pertinacia.<br /><br />Eam fabulas omittam pertinacia ei, per soluta maiorum an. Mei no elitr efficiendi delicatissimi, option ponderum intellegebat vel an. Vel dolorum accumsan convenire ei, pro ei quot moderatius. Magna iusto omnium quo ad. Id vim libris scriptorem, tamquam laoreet eos ne.</p>\r\n<p>&nbsp;</p>', 'B111', '28x21', 'Blue, Black', '2 ltr', '350 gm', '2', 'No', '2 years', 2),
(5, 7, 'product_1747713564.jpg', 'Hedley Moran', 'hedley-moran', 7, 23, 15, 'Per ea docendi assueverit, inani tempor molestiae mei cu. Justo nonumes atomorum ex pri. Vel erant saperet facilisis at. His ad cetero euripidis ullamcorper. Inermis ocurreret eos et, oportere patrioque cum et. ', '<p>Lorem ipsum dolor sit amet, per atqui omittantur et, reque dolor quando usu at, eu falli placerat salutandi nam. Duo ea enim sanctus, ne sumo munere consulatu eos. Prompta suavitate cum et, tritani invidunt usu ne. An iusto indoctum persecuti mel, qui no diceret apeirian singulis. Solet prodesset ut sea, mel cu verear voluptua. At nam sale semper persius, eum decore splendide in.<br /><br />Per ea docendi assueverit, inani tempor molestiae mei cu. Justo nonumes atomorum ex pri. Vel erant saperet facilisis at. His ad cetero euripidis ullamcorper. Inermis ocurreret eos et, oportere patrioque cum et. Nam mundi euismod saperet eu, sed amet verear moderatius ei. Per doctus tacimates at, an illud semper per, et nec labores luptatum. Ne pro ceteros recusabo salutatus. Pri ut essent pertinacia.<br /><br />Eam fabulas omittam pertinacia ei, per soluta maiorum an. Mei no elitr efficiendi delicatissimi, option ponderum intellegebat vel an. Vel dolorum accumsan convenire ei, pro ei quot moderatius. Magna iusto omnium quo ad. Id vim libris scriptorem, tamquam laoreet eos ne.</p>', 'C001', '23x21', 'Green', '2 ltr', '230 gm', '4', 'Yes', '1 year', 5),
(6, 1, 'product_1747713641.jpg', 'James Moody', 'james-moody', 4, 110, 69, 'Per ea docendi assueverit, inani tempor molestiae mei cu. Justo nonumes atomorum ex pri. Vel erant saperet facilisis at. His ad cetero euripidis ullamcorper. Inermis ocurreret eos et, oportere patrioque cum et. ', '<p>Lorem ipsum dolor sit amet, per atqui omittantur et, reque dolor quando usu at, eu falli placerat salutandi nam. Duo ea enim sanctus, ne sumo munere consulatu eos. Prompta suavitate cum et, tritani invidunt usu ne. An iusto indoctum persecuti mel, qui no diceret apeirian singulis. Solet prodesset ut sea, mel cu verear voluptua. At nam sale semper persius, eum decore splendide in.<br /><br />Per ea docendi assueverit, inani tempor molestiae mei cu. Justo nonumes atomorum ex pri. Vel erant saperet facilisis at. His ad cetero euripidis ullamcorper. Inermis ocurreret eos et, oportere patrioque cum et. Nam mundi euismod saperet eu, sed amet verear moderatius ei. Per doctus tacimates at, an illud semper per, et nec labores luptatum. Ne pro ceteros recusabo salutatus. Pri ut essent pertinacia.<br /><br />Eam fabulas omittam pertinacia ei, per soluta maiorum an. Mei no elitr efficiendi delicatissimi, option ponderum intellegebat vel an. Vel dolorum accumsan convenire ei, pro ei quot moderatius. Magna iusto omnium quo ad. Id vim libris scriptorem, tamquam laoreet eos ne.</p>', 'V0001', '40x32', 'Red, Black, Brown', '3 ltr', '700 gm', '5', 'Yes', 'No Warranty', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `photo`) VALUES
(1, 'Product Category 1', 'product_category_1747626695.jpg'),
(2, 'Product Category 2', 'product_category_1747626718.jpg'),
(3, 'Product Category 3', 'product_category_1747626705.jpg'),
(4, 'Product Category 4', 'product_category_1747626712.jpg'),
(7, 'Product Category 5', 'product_category_1747626751.jpg'),
(8, 'Product Category 6', 'product_category_1747626763.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_photos`
--

CREATE TABLE `product_photos` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_photos`
--

INSERT INTO `product_photos` (`id`, `product_id`, `photo`) VALUES
(1, 5, 'product_photo_1747723254.jpg'),
(2, 5, 'product_photo_1747723265.jpg'),
(3, 3, 'product_photo_1747723293.jpg'),
(4, 3, 'product_photo_1747723296.jpg'),
(5, 3, 'product_photo_1747723300.jpg'),
(6, 5, 'product_photo_1747723307.jpg'),
(7, 6, 'product_photo_1747723314.jpg'),
(8, 6, 'product_photo_1747723318.jpg'),
(9, 4, 'product_photo_1747723324.jpg'),
(10, 4, 'product_photo_1747723327.jpg'),
(11, 1, 'product_photo_1747723333.jpg'),
(12, 1, 'product_photo_1747723335.jpg'),
(13, 2, 'product_photo_1747723344.jpg'),
(14, 2, 'product_photo_1747723351.jpg'),
(15, 2, 'product_photo_1747723354.jpg'),
(16, 1, 'product_photo_1747723360.jpg'),
(17, 6, 'product_photo_1747723373.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `comment_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish_date` date NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `post_id`, `comment_id`, `name`, `email`, `content`, `publish_date`, `status`) VALUES
(1, 5, 2, 'Test User 1', 'testuser1@example.com', 'I am agreed to you. This post is super helpful!', '2025-05-26', 'Approved'),
(2, 5, 3, 'Patrick', 'patrick@example.com', 'Yes, Agreed!', '2025-05-26', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `top_bar_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `copyright_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme_color` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logo`, `favicon`, `top_bar_phone`, `copyright_text`, `theme_color`) VALUES
(1, 'logo_1748242828.png', 'favicon_1748242836.png', '01700000000', 'Copyright © John Doe. All Rights Reserved.', 'F76B6A');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int NOT NULL,
  `photo1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subheading` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `heading` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_position` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `photo1`, `photo2`, `subheading`, `heading`, `button_text`, `button_url`, `text_position`) VALUES
(2, 'slider_photo1_1748234810.jpg', 'slider_photo2_1748234810.jpg', 'Top Branded 1', 'Best Bags 2025', 'Shop Now', '#', 'Right'),
(3, 'slider_photo1_1748237109.jpg', 'slider_photo2_1748237109.jpg', 'Top Branded 2', 'Best Bags 2025', 'Shop Now', '#', 'Left'),
(4, 'slider_photo1_1748237152.jpg', 'slider_photo2_1748237152.jpg', 'Top Branded 3', 'Best Bags 2025', 'Shop Now', '#', 'Right');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `token`, `status`) VALUES
(1, 'test_email_1@example.com', '', 'Active'),
(2, 'test_email_2@example.com', '', 'Active'),
(4, 'test_email_3@example.com', 'a67861055a7c198239a3', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `customer_id`, `product_id`) VALUES
(3, 2, 3),
(4, 2, 6),
(5, 2, 4),
(6, 2, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_photos`
--
ALTER TABLE `product_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_photos`
--
ALTER TABLE `product_photos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
