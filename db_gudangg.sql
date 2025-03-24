-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: db_gudangg
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alamat_cabangs`
--

DROP TABLE IF EXISTS `alamat_cabangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alamat_cabangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_cabang_id` bigint unsigned NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pos` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alamat_cabangs_nama_cabang_id_foreign` (`nama_cabang_id`),
  CONSTRAINT `alamat_cabangs_nama_cabang_id_foreign` FOREIGN KEY (`nama_cabang_id`) REFERENCES `nama_cabangs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alamat_cabangs`
--

LOCK TABLES `alamat_cabangs` WRITE;
/*!40000 ALTER TABLE `alamat_cabangs` DISABLE KEYS */;
INSERT INTO `alamat_cabangs` VALUES (1,2,'Jl. Gajah Mada No.5, Rw. III, Seduri, Kec. Mojosari','Mojokerto','Jawa Timur','61385','2025-03-15 21:31:29','2025-03-15 21:31:29');
/*!40000 ALTER TABLE `alamat_cabangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_keluars`
--

DROP TABLE IF EXISTS `barang_keluars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang_keluars` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pengiriman` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_cabang_id` bigint unsigned NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `nama_barang_id` bigint unsigned NOT NULL,
  `jumlah` int NOT NULL,
  `no_batch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_expired` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `barang_keluars_id_pengiriman_unique` (`id_pengiriman`),
  KEY `barang_keluars_nama_cabang_id_foreign` (`nama_cabang_id`),
  KEY `barang_keluars_nama_barang_id_foreign` (`nama_barang_id`),
  CONSTRAINT `barang_keluars_nama_barang_id_foreign` FOREIGN KEY (`nama_barang_id`) REFERENCES `nama_barangs` (`id`),
  CONSTRAINT `barang_keluars_nama_cabang_id_foreign` FOREIGN KEY (`nama_cabang_id`) REFERENCES `nama_cabangs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_keluars`
--

LOCK TABLES `barang_keluars` WRITE;
/*!40000 ALTER TABLE `barang_keluars` DISABLE KEYS */;
INSERT INTO `barang_keluars` VALUES (1,'JBG001',1,'2025-03-18',1,4,'qw23','2027-12-12','2025-03-17 19:33:31','2025-03-17 19:33:31');
/*!40000 ALTER TABLE `barang_keluars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_masuks`
--

DROP TABLE IF EXISTS `barang_masuks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang_masuks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tanggal_masuk` datetime NOT NULL,
  `nama_barang_id` bigint unsigned NOT NULL,
  `jumlah` int NOT NULL,
  `no_batch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_expired` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `barang_masuks_nama_barang_id_foreign` (`nama_barang_id`),
  CONSTRAINT `barang_masuks_nama_barang_id_foreign` FOREIGN KEY (`nama_barang_id`) REFERENCES `nama_barangs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_masuks`
--

LOCK TABLES `barang_masuks` WRITE;
/*!40000 ALTER TABLE `barang_masuks` DISABLE KEYS */;
INSERT INTO `barang_masuks` VALUES (5,'2025-03-16 02:31:07',5,30,'xzz1','2090-12-12','2025-03-15 19:31:07','2025-03-15 19:31:07'),(6,'2025-03-16 02:32:05',5,2,'zxx2','2034-12-12','2025-03-15 19:32:05','2025-03-15 19:32:05'),(7,'2025-03-16 06:52:22',3,10,'cvb12','2030-06-16','2025-03-15 23:52:22','2025-03-15 23:52:22'),(8,'2025-03-16 06:53:13',4,13,'aadc1','2030-12-12','2025-03-15 23:53:13','2025-03-15 23:53:13'),(9,'2025-03-16 07:11:01',1,17,'qw23','2027-12-12','2025-03-16 00:11:01','2025-03-16 00:11:01'),(10,'2025-03-16 08:13:45',1,12,'qw23','2029-02-22','2025-03-16 01:13:45','2025-03-16 01:13:45'),(11,'2025-03-16 08:14:37',3,23,'12bn','2029-09-12','2025-03-16 01:14:37','2025-03-16 01:14:37');
/*!40000 ALTER TABLE `barang_masuks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_barangs`
--

DROP TABLE IF EXISTS `jenis_barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_barangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_barangs`
--

LOCK TABLES `jenis_barangs` WRITE;
/*!40000 ALTER TABLE `jenis_barangs` DISABLE KEYS */;
INSERT INTO `jenis_barangs` VALUES (1,'skincare','2025-03-14 20:31:32','2025-03-14 20:31:32'),(2,'pelembab kulit','2025-03-14 21:31:39','2025-03-14 21:31:46'),(3,'alat kesehatan','2025-03-15 00:17:01','2025-03-15 00:17:01'),(4,'alat kehamilan','2025-03-15 19:26:14','2025-03-15 19:26:14');
/*!40000 ALTER TABLE `jenis_barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'0001_01_01_000002_create_jobs_table',1),(3,'2025_03_11_090646_create_users_table',1),(4,'2025_03_12_074433_create_nama_barangs_table',1),(5,'2025_03_12_074441_create_jenis_barangs_table',1),(6,'2025_03_12_074451_create_satuan_barangs_table',1),(7,'2025_03_15_031653_create_sessions_table',2),(9,'2025_03_15_080149_create_barang_masuks_table',3),(11,'2025_03_15_102823_modify_stock_column_in_nama_barangs_table',4),(12,'2025_03_16_000000_create_cabangs_table',4),(13,'2025_03_16_034951_create_cabangs_table',5),(14,'2025_03_16_042407_create_alamat_cabangs_table',6),(15,'2025_03_16_043512_create_penanggung_jawab_cabangs_table',7),(16,'2025_03_16_061047_create_barang_keluars_table',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nama_barangs`
--

DROP TABLE IF EXISTS `nama_barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nama_barangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nama_barangs_kode_barang_unique` (`kode_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nama_barangs`
--

LOCK TABLES `nama_barangs` WRITE;
/*!40000 ALTER TABLE `nama_barangs` DISABLE KEYS */;
INSERT INTO `nama_barangs` VALUES (1,'001','Masker wajah','skincare','pcs',25,'2025-03-14 21:09:28','2025-03-17 19:33:31'),(3,'003','tissue','alat kesehatan','box',33,'2025-03-15 00:17:32','2025-03-16 01:14:37'),(4,'002','sunscreen','pelembab kulit','liter',13,'2025-03-15 00:18:09','2025-03-15 23:53:13'),(5,'004','Facewash','skincare','Botol',32,'2025-03-15 19:25:38','2025-03-15 19:32:05');
/*!40000 ALTER TABLE `nama_barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nama_cabangs`
--

DROP TABLE IF EXISTS `nama_cabangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nama_cabangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_cabang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_cabang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nama_cabangs_kode_cabang_unique` (`kode_cabang`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nama_cabangs`
--

LOCK TABLES `nama_cabangs` WRITE;
/*!40000 ALTER TABLE `nama_cabangs` DISABLE KEYS */;
INSERT INTO `nama_cabangs` VALUES (1,'JBG','Jombang 1','2025-03-15 21:03:16','2025-03-15 21:03:16'),(2,'MJS','Mojosari','2025-03-15 21:04:20','2025-03-15 21:04:30');
/*!40000 ALTER TABLE `nama_cabangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penanggung_jawab_cabangs`
--

DROP TABLE IF EXISTS `penanggung_jawab_cabangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penanggung_jawab_cabangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_cabang_id` bigint unsigned NOT NULL,
  `nama_penanggung_jawab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon_cs` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon_pj` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penanggung_jawab_cabangs_nama_cabang_id_foreign` (`nama_cabang_id`),
  CONSTRAINT `penanggung_jawab_cabangs_nama_cabang_id_foreign` FOREIGN KEY (`nama_cabang_id`) REFERENCES `nama_cabangs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penanggung_jawab_cabangs`
--

LOCK TABLES `penanggung_jawab_cabangs` WRITE;
/*!40000 ALTER TABLE `penanggung_jawab_cabangs` DISABLE KEYS */;
INSERT INTO `penanggung_jawab_cabangs` VALUES (1,2,'Siti Maemunah','012345678910','098765432112','2025-03-15 21:59:54','2025-03-15 22:00:09');
/*!40000 ALTER TABLE `penanggung_jawab_cabangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `satuan_barangs`
--

DROP TABLE IF EXISTS `satuan_barangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `satuan_barangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `satuan_barangs`
--

LOCK TABLES `satuan_barangs` WRITE;
/*!40000 ALTER TABLE `satuan_barangs` DISABLE KEYS */;
INSERT INTO `satuan_barangs` VALUES (1,'pcs','2025-03-14 20:39:25','2025-03-14 20:39:25'),(2,'liter','2025-03-14 21:39:25','2025-03-14 21:39:25'),(3,'Botol','2025-03-14 21:39:47','2025-03-14 21:40:08'),(4,'box','2025-03-15 00:17:15','2025-03-15 00:17:15'),(5,'Sachet','2025-03-15 19:26:40','2025-03-15 19:26:40');
/*!40000 ALTER TABLE `satuan_barangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('nHvSgn6xqjJRNTxNQ8s3iV7aY9dowGlofAalNlZn',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','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',1742282846);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$12$8h07Bb/FdWGyyhV83Aa4Ded849Z5Z5E7kSRsgaBmT2alQqKPGlliq','2025-03-14 20:31:02','2025-03-14 20:31:02');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-18 15:09:04
