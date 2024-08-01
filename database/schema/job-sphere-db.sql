-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Aug 01, 2024 at 08:38 PM
-- Server version: 8.2.0
-- PHP Version: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job-sphere-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Information Technology', 1, '2024-06-15 15:58:44', '2024-07-10 12:33:55'),
(2, 'Engineering', 1, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(3, 'Accountant', 1, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(4, 'Finance', 1, '2024-06-15 15:58:44', '2024-07-11 02:54:32'),
(6, 'Graphics & Design', 1, '2024-07-10 16:08:09', '2024-07-10 12:45:57'),
(7, 'Video & Animation', 1, '2024-07-10 18:48:53', '2024-07-10 12:50:48'),
(8, 'Sales AND Marketing', 1, '2024-07-10 18:51:41', '2024-07-27 22:47:01'),
(9, 'afsdfdffd', 0, '2024-07-10 18:52:05', '2024-08-01 11:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `email_verifications`
--

CREATE TABLE `email_verifications` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_verifications`
--

INSERT INTO `email_verifications` (`id`, `email`, `otp`, `created_at`) VALUES
(1, 'test@test.com', '402664', 1720462879);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `job_type_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `vacancy` int NOT NULL,
  `salary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `benefits` text COLLATE utf8mb4_unicode_ci,
  `responsibility` text COLLATE utf8mb4_unicode_ci,
  `qualifications` text COLLATE utf8mb4_unicode_ci,
  `keywords` text COLLATE utf8mb4_unicode_ci,
  `experience` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `isFeatured` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `category_id`, `job_type_id`, `user_id`, `vacancy`, `salary`, `location`, `description`, `benefits`, `responsibility`, `qualifications`, `keywords`, `experience`, `company_name`, `company_location`, `company_website`, `status`, `isFeatured`, `created_at`, `updated_at`) VALUES
(6, 'Laravel Developer', 1, 1, 1, 5, '100k', 'Gazipur Sadar', 'The main duties of a Laravel developer include writing code, fixing bugs, and adding new features to applications. He/she may also be required to work with databases and perform various tasks such as data migrations.', 'Ab nemo rerum blanditiis nam optio. Voluptatem quae aut quia non. Dolorum ipsam architecto ea ea. Soluta qui a dolores.', 'Quod at porro reiciendis pariatur ex qui impedit. Nobis eius qui accusamus eius. Tempora voluptatem quo molestiae iusto corporis.', 'Dolorem quia ab quae natus aut nobis. Sed officia recusandae occaecati. Omnis quis vero earum qui quia at error.', 'Et quasi tempore sunt.', '1', 'Leffler-Carroll', 'Aylinhaven', 'http://www.kovacek.com/quasi-omnis-aliquam-reiciendis-et', 1, 1, '2024-06-15 15:58:44', '2024-06-29 12:28:57'),
(7, 'Dolor in fuga culpa tenetur earum et error id.', 2, 2, 1, 8, '9560', 'Ullrichland', 'Consequatur cumque totam nemo distinctio omnis vitae. Sunt cumque eveniet dignissimos et. Enim et ullam sit et. Odio minima rem iste sapiente.', 'Praesentium ducimus omnis atque est quasi aut qui. Distinctio dolores natus neque minus et. Rerum quo rem quis quis ut dolorum non.', 'Vel ipsam voluptates rerum non omnis ab sit ut. Iusto quae dignissimos laudantium hic repellendus quia consequatur. Eum eligendi fugiat enim ab itaque tenetur quam. Sunt velit temporibus esse.', 'Omnis et libero velit accusantium rerum deserunt. Sed cumque beatae et in quibusdam. Voluptates aut accusantium laborum sit repellat.', 'Cupiditate non sapiente qui quia ipsum voluptatem quod est.', '6', 'Connelly, Eichmann and Stracke', 'Ginotown', 'http://reinger.com/quos-quia-sint-a-dolorum', 0, 0, '2024-06-15 15:58:44', '2024-07-08 13:28:49'),
(8, 'Ut earum nulla et ut dolores et aut.', 1, 4, 1, 9, '8526', 'East Anastasia', 'Et nisi et ab magnam illum autem et. Voluptatem et eveniet incidunt est. Voluptates aut repellendus inventore quis eligendi est.', 'Vel qui sint et quod. Aut ab pariatur minima illum voluptatem illum sed. Accusantium atque aut aut consectetur qui quis ea.', 'Placeat ullam minima quidem laborum alias. Est sunt qui ratione sed amet dolor. Repellat animi distinctio nobis. Nihil reiciendis aut quod unde enim.', 'Velit odit cumque sit nostrum beatae non consequuntur sed. Ad fugit ut perspiciatis dolorem voluptas. Aspernatur officia enim suscipit adipisci in reprehenderit. Maiores amet et in doloribus neque ducimus.', 'Autem ratione voluptatum cum ex sint cupiditate quasi sapiente.', '10', 'Aufderhar, Carroll and Reichel', 'Mollieside', 'http://www.harvey.com/', 0, 0, '2024-06-15 15:58:44', '2024-07-08 13:29:10'),
(17, 'Aut dolor vitae voluptatum impedit.', 3, 2, 1, 5, '6025', 'Wilkinsonfurt', 'Consequatur quod quia rerum quo optio rem ut quisquam. Eos possimus alias natus dolorem est quod. Ex velit sint non deleniti et id et.', 'Enim quis quaerat non. Vel pariatur accusamus cum est veniam quod eum. Eum ipsam sed eum deserunt quo sit enim.', 'Repellendus excepturi labore voluptatum dicta. Quia debitis ratione tempore assumenda voluptatum hic. Distinctio fugit fugiat laborum quam id eos.', 'Et eos reprehenderit mollitia vel in sunt ut. Enim quasi corrupti sed perferendis tempora. Ab id quasi ducimus tempora officia libero magnam quod. Hic et dolorem sit dignissimos rem.', 'Ipsam et nostrum officiis amet optio qui.', '3', 'Gislason, Bernhard and Heidenreich', 'East Ismaelport', 'http://www.renner.com/', 1, 0, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(19, 'Odio voluptatem est est et quod quis.', 3, 4, 1, 7, '3931', 'North Cristian', 'Porro repudiandae earum eum. Quam nam modi dolor et voluptatibus et impedit. Esse cupiditate eos inventore est est. Voluptas et reprehenderit eligendi fugit.', 'Sit sapiente sunt ullam nostrum expedita quidem sunt. Tenetur at sit velit id dolor quod eos. Laborum molestiae dignissimos aut rerum facere unde molestiae velit. Tempore odio dolorum eius quos.', 'Aut quidem est at ut est omnis id. Quaerat blanditiis accusantium in recusandae corporis mollitia similique. Expedita et quidem ea ipsam doloribus aut est. Dolore saepe esse et velit sed rerum.', 'Ea adipisci voluptate saepe odio voluptatibus dolor. Optio iste quis dolorem eum vel labore et id. Rerum omnis sapiente et delectus sit. Qui voluptatum doloribus sed quia qui.', 'Animi rem itaque commodi enim ab quia velit.', '3', 'Ratke Inc', 'North Pearlieview', 'http://www.jenkins.com/maxime-quos-sed-ducimus-praesentium-et-et', 1, 0, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(20, 'Sunt quis commodi occaecati vitae.', 2, 4, 1, 10, '7739', 'Lake Joesph', 'Id dolore in aperiam ea. Dolorum id atque voluptas et. Assumenda et iusto nesciunt exercitationem odio ratione ut vel. Voluptas unde totam animi et asperiores.', 'Rerum eos eius excepturi totam quae officiis et sed. Tempora soluta hic quam maiores. Architecto culpa commodi in voluptate. Reiciendis rerum iusto et et similique est quia.', 'Ut qui et expedita. Quis sint saepe sed inventore. Reiciendis voluptatem mollitia inventore temporibus repellendus.', 'Sed earum officia sed nulla impedit neque eos. Delectus qui ducimus incidunt dolor unde. Et reprehenderit quaerat cum dolore ex.', 'Quasi eum voluptas excepturi quia.', '10', 'Lubowitz LLC', 'Lake Faustino', 'http://www.friesen.com/maiores-laudantium-dolorem-excepturi-distinctio', 1, 0, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(21, 'Et non necessitatibus dolor sunt.', 4, 4, 1, 4, '8858', 'East Carlieside', 'Facere distinctio omnis doloremque autem enim reiciendis ipsa. Dolor hic non nisi unde cupiditate. Illo est reprehenderit fugiat minima asperiores vel.', 'Incidunt cum minima rerum. Accusantium non tempore sunt autem soluta. Beatae nesciunt eos enim facilis. Et tenetur non ad ut sunt ut saepe.', 'Consequuntur explicabo aut ut in et suscipit iusto. Enim provident temporibus dolor aperiam eos. Explicabo velit officia vero ad accusamus labore asperiores. Expedita dignissimos soluta quis est.', 'Consequatur illum consequatur voluptatem inventore. Rerum pariatur itaque doloremque aut. Soluta voluptatem facere omnis itaque autem incidunt eaque. Aut excepturi blanditiis suscipit amet vel tempora.', 'Sunt laudantium qui autem ullam aut.', '5', 'Balistreri Group', 'North Emmanuelleshire', 'http://www.maggio.com/', 1, 1, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(22, 'Reiciendis earum officiis autem ut.', 3, 2, 1, 9, '1199', 'Opalland', 'Natus necessitatibus quos sint ut quia. Ab libero officiis enim maxime. Officiis voluptas ab consequatur aperiam. Veritatis consequuntur reprehenderit quo quo aut adipisci ratione.', 'Alias similique officia natus sit. Dolor reprehenderit quasi perspiciatis omnis. Quo numquam illum porro similique soluta quam. Hic doloribus quas aut nesciunt in eligendi occaecati.', 'Odit fugit quia voluptate excepturi saepe sint. Voluptatibus sint suscipit ipsam nihil id. Dicta nesciunt nam blanditiis quisquam.', 'Odit aut laboriosam soluta ratione nihil. Quas sunt consequuntur architecto enim repellendus. Corrupti ducimus omnis aut voluptates quibusdam nulla dolores. Omnis dolor repellat aut harum voluptatem.', 'Aut sint exercitationem esse amet voluptas.', '8', 'Altenwerth Ltd', 'Lake Mariam', 'http://armstrong.com/qui-ea-labore-voluptatem-aspernatur-omnis-consequatur-nostrum', 1, 0, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(23, 'Veniam iure sit nihil temporibus explicabo.', 4, 4, 1, 7, '3911', 'Breitenbergmouth', 'Beatae corrupti sed incidunt perferendis sapiente. Blanditiis atque et dignissimos at laudantium et. Nisi a velit ipsa voluptate culpa qui.', 'Iure at natus quisquam in ipsam commodi. Voluptatibus enim quia ea rerum est. Praesentium aut sint quos rem id eligendi.', 'Aut perspiciatis excepturi id provident. Rerum odio id ut saepe omnis praesentium ullam eum. Aut aut quia nam non alias. Non commodi nisi blanditiis autem ad.', 'Ut aut quia rem aut tempore. Pariatur non hic ipsum. Modi sed iusto fuga aliquid voluptatibus molestias voluptatibus.', 'Quisquam consequatur magnam doloribus id aut voluptatum.', '4', 'Willms and Sons', 'Franeckifurt', 'http://www.little.com/voluptas-quaerat-magnam-quae-hic-adipisci-aut', 1, 1, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(24, 'Cumque ut laudantium quidem voluptatem amet facilis voluptatem.', 4, 3, 1, 2, '3952', 'Lake Griffinmouth', 'Sit unde dicta vel sit et nihil minima. Sed accusantium qui est explicabo qui maiores. Quae perspiciatis dignissimos minus atque accusamus.', 'Nobis consequatur non maxime ratione vel. Aperiam et tempora cumque quo inventore explicabo natus qui. Voluptatem ullam consectetur earum vel.', 'Tenetur officiis quis nam error possimus possimus. Labore dignissimos pariatur molestiae. Maxime doloremque dolores magnam voluptate ea sit nam.', 'Incidunt saepe ipsa qui dolor recusandae molestiae animi. Sit molestiae dolores a et repellat ut. Labore quibusdam hic nihil et perspiciatis. Aliquid rem aliquid laboriosam dicta. Accusantium qui aspernatur et eveniet similique et.', 'Est officiis dolore expedita sit doloremque illum.', '9', 'Rice-McLaughlin', 'Toyborough', 'http://www.littel.net/', 1, 0, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(25, 'Porro culpa aspernatur eos voluptate.', 2, 1, 1, 10, '3637', 'Jonesburgh', 'Sed vero ab temporibus est et minus. Odio rerum aut et dolore et reprehenderit aliquid.', 'Consequatur quis est quod consequatur. Voluptatem atque id fuga at dolores. Accusamus voluptates quas officia fuga molestiae tenetur consequatur dolor.', 'Facere modi voluptatem voluptatem voluptatum non nemo eveniet ut. Doloremque ipsam vero nemo molestiae similique molestiae ipsa iusto. Aut numquam quas consequatur quo quis. Alias voluptas quo quos dignissimos at recusandae.', 'Occaecati et deleniti a. Id placeat at molestiae voluptas nam ratione et.', 'Quam optio non corporis ut.', '9', 'Will-Beer', 'Larsonfurt', 'http://www.jakubowski.biz/dignissimos-ipsam-veniam-voluptas-adipisci', 1, 0, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(26, 'Quo hic rerum non in odit sint.', 1, 2, 1, 5, '4953', 'Maudebury', 'Distinctio eum quia dolores sunt labore quae. Qui nihil ad ratione vel laborum amet ut. Consectetur eum non enim aut itaque.', 'Explicabo nulla est magni iusto quidem velit. Dolore temporibus est debitis vitae sunt nihil aspernatur. Quod qui id excepturi.', 'Nemo id beatae omnis est aspernatur totam nihil. Quam autem ipsam atque voluptatem sed. Doloremque quod quas quis natus voluptatem fugit aliquid laboriosam.', 'Tempore et quis non ut itaque aut tempora. Id rerum inventore laudantium maiores.', 'Quia quibusdam in non error sequi modi molestiae.', '1', 'Goodwin and Sons', 'West Richmond', 'http://www.watsica.info/dolorum-aperiam-officia-nam-voluptate-hic', 1, 0, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(27, 'Front-End Engineer: React', 1, 3, 1, 1, '30k-45k', 'Banani', 'Voluptas rerum quisquam sed aut et quos veritatis. Eum beatae et quaerat vel. Consequatur officiis repellat illo voluptatibus nam rem quia.', 'Alias id consequatur ab voluptatem nisi consequatur. Aut necessitatibus eius doloribus accusantium in dicta. Nam sed quo deleniti ab nisi inventore nostrum velit. Cum iusto voluptatem ea voluptatem cumque aut.', 'Sed accusantium velit provident. Hic blanditiis odit quasi vitae sint laboriosam esse. Eveniet dolorem consequatur et. Autem et nostrum rerum consequuntur odio.', 'Unde maiores id nemo voluptas nemo. Laudantium amet omnis corrupti itaque. Deleniti corporis et ut exercitationem esse.', 'Vel libero qui cupiditate doloremque temporibus enim sequi.', '5', 'Toy-Borer', 'Lake Marcelle', 'http://www.krajcik.org/voluptatum-possimus-in-delectus-voluptatibus-enim-consequuntur-aut', 1, 0, '2024-06-16 07:24:28', '2024-06-23 00:48:10'),
(28, 'Database Admin: MySQL', 1, 1, 1, 3, '33k', 'On-Site', 'Voluptas rerum quisquam sed aut et quos veritatis. Eum beatae et quaerat vel. Consequatur officiis repellat illo voluptatibus nam rem quia.', 'Alias id consequatur ab voluptatem nisi consequatur. Aut necessitatibus eius doloribus accusantium in dicta. Nam sed quo deleniti ab nisi inventore nostrum velit. Cum iusto voluptatem ea voluptatem cumque aut.', 'Sed accusantium velit provident. Hic blanditiis odit quasi vitae sint laboriosam esse. Eveniet dolorem consequatur et. Autem et nostrum rerum consequuntur odio.', 'Unde maiores id nemo voluptas nemo. Laudantium amet omnis corrupti itaque. Deleniti corporis et ut exercitationem esse.', 'Vel libero qui cupiditate doloremque temporibus enim sequi.', '2', 'Toy-Borer', 'Lake Marcelle', 'http://www.krajcik.org/voluptatum-possimus-in-delectus-voluptatibus-enim-consequuntur-aut', 1, 0, '2024-06-16 07:24:55', '2024-06-23 00:58:35'),
(29, 'Senior Vue.js Developer', 1, 1, 1, 10, 'Negotiable', 'On-Site', '<p><strong>Voluptas </strong>rerum quisquam sed aut et quos veritatis. Eum beatae et quaerat vel. Consequatur officiis repellat illo voluptatibus nam rem quia.</p>', '<p>Alias id consequatur ab voluptatem nisi consequatur. Aut necessitatibus eius doloribus accusantium in dicta. Nam sed quo deleniti ab nisi inventore nostrum velit.\r\n\r\nCum iusto voluptatem ea voluptatem cumque aut.</p><p></p><hr><span style=\"font-size: 16px;\">Alias id consequatur ab voluptatem nisi consequatur. Aut necessitatibus eius doloribus accusantium in dicta. Nam sed quo deleniti ab nisi inventore nostrum velit. Cum iusto voluptatem ea voluptatem cumque aut.</span><p></p>', 'Sed accusantium velit provident. Hic blanditiis odit quasi vitae sint laboriosam esse. Eveniet dolorem consequatur et. Autem et nostrum rerum consequuntur odio.', 'Unde maiores id nemo voluptas nemo. Laudantium amet omnis corrupti itaque. Deleniti corporis et ut exercitationem esse.', 'Vel libero qui cupiditate doloremque temporibus enim sequi.', '2', 'Toy-Borer', 'Lake Marcelle', 'http://www.krajcik.org/voluptatum-possimus-in-delectus-voluptatibus-enim-consequuntur-aut', 1, 0, '2024-06-16 07:27:49', '2024-07-08 13:28:58'),
(30, '.NET Develper (Intern)', 1, 1, 1, 1, 'Tk. 15000 (Monthly)', 'Dhaka', '<p>some DESCRIPTION</p>', 'Satisfactory performance as an intern will result in permanent position.', '<ul><li><span style=\"font-size: 16px;\">Responsible for the development of front-end and back-end services</span></li><li><span style=\"font-size: 16px;\">Collaborate with internal teams to produce software design and architecture</span></li><li><span style=\"font-size: 16px;\">Develop &amp; implement different 3rd party APIs like Payment Gateway, Google API, Ajax Libraries, SMS Integration, JSON APIs.</span></li><li><span style=\"font-size: 16px;\">Test and deploy applications and systems.</span><br></li></ul>', '<p><span style=\"text-align: var(--bs-body-text-align);\"><strong>Education</strong></span></p><p></p><ul><li>Bachelor of Science (BSc) in Computer Science &amp; Engineering</li></ul><p></p><p><strong>Additional Requirement</strong></p><p></p><ul><li>Age 22 to 30 years</li></ul><p></p>', 'asp.net, .net framework', '1', 'PRAN-RFL Group', 'Corporate Headquarters: PRAN-RFL Center, 105 Middle Badda, Dhaka - 1212, Bangladesh.', 'https://rflbd.com/', 1, 1, '2024-06-23 06:22:31', '2024-06-29 12:29:22'),
(31, 'Vel voluptatem harum', 2, 3, 6, 9, '1234', 'Quia non dolor aut i', 'Iusto deserunt in ul', 'Voluptates labore qu', '<p>lorem ipsumHtml By Mehedi Islam Ripon on Feb 25 2021 ThankComments(4)Suggest EditShare<br></p><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,</p><p>molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum</p><p>numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium</p><p>optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis</p><p>obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam</p><p>nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,</p><p>tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,</p><p>quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos&nbsp;</p>', '<p><br></p><p>lorem ipsumHtml By Mehedi Islam Ripon on Feb 25 2021 ThankComments(4)Suggest EditShare</p><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,</p><p>molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum</p><p>numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium</p><p>optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis</p><p>obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam</p><p>nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,</p><p>tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,</p><p>quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos&nbsp;</p>', 'Consequuntur non cil', '1', 'Norris Spence Trading', 'Allison Mccray Inc', 'Burch and Dickerson Inc', 1, 0, '2024-06-29 12:47:04', '2024-06-29 12:47:04'),
(33, 'Odio voluptatem pers', 1, 4, 1, 37, 'Quas omnis qui quod', 'Dolor id sunt est', 'Laboriosam rerum mi', 'Hic non lorem et et', 'Aliquid vero eu haru', 'Labore autem et expe', 'Voluptatem quibusda', '10_plus', 'Payne and Rodgers Trading', 'Cobb Knox Associates', 'Kirkland Wooten Inc', 1, 0, '2024-07-09 03:49:39', '2024-07-09 03:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `job_id` bigint UNSIGNED NOT NULL,
  `employer_id` bigint UNSIGNED NOT NULL,
  `applied_date` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `user_id`, `job_id`, `employer_id`, `applied_date`, `created_at`, `updated_at`) VALUES
(2, 2, 29, 1, '2024-06-21 08:54:15', '2024-06-21 08:54:15', '2024-06-21 08:54:15'),
(5, 1, 30, 2, '2024-06-23 06:25:59', '2024-06-23 06:25:59', '2024-06-23 06:25:59'),
(8, 2, 28, 1, '2024-06-30 00:23:42', '2024-06-30 00:23:42', '2024-06-30 00:23:42'),
(15, 2, 31, 6, '2024-06-30 04:00:23', '2024-06-30 04:00:23', '2024-06-30 04:00:23'),
(16, 2, 6, 1, '2024-06-30 04:00:37', '2024-06-30 04:00:37', '2024-06-30 04:00:37'),
(17, 2, 30, 1, '2024-06-30 04:01:50', '2024-06-30 04:01:50', '2024-06-30 04:01:50');

-- --------------------------------------------------------

--
-- Table structure for table `job_types`
--

CREATE TABLE `job_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_types`
--

INSERT INTO `job_types` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Full-Time', 1, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(2, 'Part-Time', 1, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(3, 'Remote', 1, '2024-06-15 15:58:44', '2024-06-15 15:58:44'),
(4, 'Freelance', 1, '2024-06-15 15:58:44', '2024-06-15 15:58:44');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_14_053521_create_categories_table', 1),
(6, '2024_06_14_053616_create_job_types_table', 1),
(7, '2024_06_14_053629_create_jobs_table', 1),
(8, '2024_06_15_094010_add_status_and_isFeatured_column_to_jobs_table', 1),
(9, '2024_06_15_204759_add_user_id_column_to_jobs_table', 1),
(10, '2024_06_19_121614_create_job_applications_table', 2),
(11, '2024_06_22_195139_create_saved_jobs_applications_table', 3),
(12, '2024_06_22_195139_create_saved_jobs_table', 4),
(13, '2024_06_24_180347_add_role_column_to_users_table', 5),
(14, '2024_07_08_064935_add_is_verified_column_to_users_table', 6),
(15, '2024_07_08_064947_email_verifications_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('reyna05@example.com', 'gqUWD4cikvc6zCJjMj3uvqE5VHMFYa3cLWvIheltvGAQfV8e35', '2024-07-01 08:30:46'),
('test@test.com', '1RP45hGSyLsPqH0WD2I2YeOwf86na7cdwKw9k1P2i0kbKAyNpd', '2024-07-01 08:17:04');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved_jobs`
--

CREATE TABLE `saved_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `job_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saved_jobs`
--

INSERT INTO `saved_jobs` (`id`, `job_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 27, 1, '2024-06-22 14:46:44', '2024-06-22 14:46:44'),
(2, 6, 1, '2024-06-23 00:49:36', '2024-06-23 00:49:36'),
(3, 7, 1, '2024-06-23 00:49:46', '2024-06-23 00:49:46'),
(5, 29, 1, '2024-06-23 00:52:42', '2024-06-23 00:52:42'),
(6, 28, 1, '2024-06-23 00:58:48', '2024-06-23 00:58:48'),
(7, 21, 1, '2024-06-23 00:58:56', '2024-06-23 00:58:56'),
(8, 22, 1, '2024-06-23 00:59:00', '2024-06-23 00:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_verified` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `image`, `designation`, `mobile`, `role`, `remember_token`, `created_at`, `updated_at`, `is_verified`) VALUES
(1, 'Samiul Islam', 'test@test.com', NULL, '$2y$10$HRaMGsIw6WJfwPEvEe9YluwjC7j/aL4PRI1qNZuHidkNUNc3MY5Za', '1-1720210214.png', 'Laravel Developer | VILT Stack', '01716571811', 'admin', NULL, '2024-06-15 15:55:26', '2024-07-08 12:22:14', 1),
(2, 'Mr. Abul Kashem Bhuiyan', 'reyna05@example.com', '2024-06-15 15:58:44', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'Chakri Khuji, Chakri Dei', '01800001325', 'user', 'RvvIHjTv7z89GPkhperGiitMKtJAhnpcOVZX3hp5bZnNAv1DSL5ph9ux8d5O', '2024-06-15 15:58:44', '2024-06-27 05:48:42', 0),
(6, 'Miss Dasia Kutch', 'ritchie.dora@example.com', '2024-06-15 15:58:44', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, NULL, 'user', 'erv9QFIGL3q35bbtfoGfVxGZG7Y6xzg7ZNcUQgxeRrWNaixEdqxwVGtrDfYe', '2024-06-15 15:58:44', '2024-06-15 15:58:44', 0),
(7, 'Dr. Madelynn King', 'hammes.chaim@example.org', '2024-06-15 15:58:44', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, NULL, 'user', 'QH4hSVT6mH', '2024-06-15 15:58:44', '2024-06-15 15:58:44', 0),
(8, 'Prof. Shyanne Rau III', 'regan.carter@example.net', '2024-06-15 15:58:44', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, NULL, 'user', 'giRXjyYUAj', '2024-06-15 15:58:44', '2024-06-15 15:58:44', 0),
(9, 'Dr. Darrell Gleichner', 'tyree.bosco@example.net', '2024-06-15 15:58:44', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, NULL, 'user', 'ssr0sQTj70', '2024-06-15 15:58:44', '2024-06-15 15:58:44', 0),
(10, 'Landen Funk', 'pfeffer.jana@example.org', '2024-06-15 15:58:44', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, NULL, 'user', '52xrATKO3D', '2024-06-15 15:58:44', '2024-06-15 15:58:44', 0),
(11, 'Trisha Lubowitz Sr.', 'afunk@example.org', '2024-06-15 15:58:44', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, NULL, 'user', 'axwxRlnurp', '2024-06-15 15:58:44', '2024-06-15 15:58:44', 0),
(12, 'Macy Maynard', 'dotiwaryju@mailinator.com', NULL, '$2y$10$DR6tso8KU/ZrmBJHEoc0guxhDdqs4aAsRJCArsuJKTepMkHbCj94i', NULL, NULL, NULL, 'user', NULL, '2024-06-27 13:18:26', '2024-06-27 13:18:26', 0),
(13, 'Md. Sirajul Islam', 'sirajul.1459@gmail.com', NULL, '$2y$10$jw/Y.bldAPpI2.d1qzW7JuBQqap1.3cdMU.TXujwoLqxaZ8bZHPIO', NULL, 'Sub-Assitant Engineer', '01716549418', 'user', NULL, '2024-06-27 13:23:22', '2024-06-27 13:23:58', 0),
(14, 'Wade Larson', 'digucad@mailinator.com', NULL, '$2y$10$fA4x.aVF3VKn8qgNpwuUmu/3kbthbO8KwjvdQ622fXb/lfkOKh0ou', NULL, NULL, NULL, 'user', NULL, '2024-07-05 14:08:26', '2024-07-05 14:08:26', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_verifications_email_index` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_category_id_foreign` (`category_id`),
  ADD KEY `jobs_job_type_id_foreign` (`job_type_id`),
  ADD KEY `jobs_user_id_foreign` (`user_id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_applications_user_id_foreign` (`user_id`),
  ADD KEY `job_applications_job_id_foreign` (`job_id`),
  ADD KEY `job_applications_employer_id_foreign` (`employer_id`);

--
-- Indexes for table `job_types`
--
ALTER TABLE `job_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saved_jobs_job_id_foreign` (`job_id`),
  ADD KEY `saved_jobs_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `job_types`
--
ALTER TABLE `job_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jobs_job_type_id_foreign` FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD CONSTRAINT `saved_jobs_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
