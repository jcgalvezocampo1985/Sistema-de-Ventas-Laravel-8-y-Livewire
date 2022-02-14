/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : ventaslite

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 13/02/2022 23:19:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'CURSOS', 'https://dummyimage.com/200x150/707070/fff.jpg', '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `categories` VALUES (2, 'TENIS', 'https://dummyimage.com/200x150/707070/fff.jpg', '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `categories` VALUES (3, 'CELULARES', 'https://dummyimage.com/200x150/707070/fff.jpg', '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `categories` VALUES (4, 'COMPUTADORAS', 'https://dummyimage.com/200x150/707070/fff.jpg', '2022-02-13 01:30:32', '2022-02-13 01:30:32');

-- ----------------------------
-- Table structure for companies
-- ----------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `taxpayes_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of companies
-- ----------------------------

-- ----------------------------
-- Table structure for denominations
-- ----------------------------
DROP TABLE IF EXISTS `denominations`;
CREATE TABLE `denominations`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('BILLETE','MONEDA','OTRO') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BILLETE',
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of denominations
-- ----------------------------
INSERT INTO `denominations` VALUES (1, 'BILLETE', '1000', NULL, '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `denominations` VALUES (2, 'BILLETE', '500', NULL, '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `denominations` VALUES (3, 'BILLETE', '200', NULL, '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `denominations` VALUES (4, 'BILLETE', '100', NULL, '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `denominations` VALUES (5, 'BILLETE', '50', NULL, '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `denominations` VALUES (6, 'BILLETE', '20', NULL, '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `denominations` VALUES (7, 'MONEDA', '20', NULL, '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `denominations` VALUES (8, 'MONEDA', '10', NULL, '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `denominations` VALUES (9, 'MONEDA', '5', NULL, '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `denominations` VALUES (10, 'MONEDA', '2', NULL, '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `denominations` VALUES (11, 'MONEDA', '1', NULL, '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `denominations` VALUES (12, 'MONEDA', '0.5', NULL, '2022-02-13 01:30:31', '2022-02-13 01:30:31');
INSERT INTO `denominations` VALUES (13, 'OTRO', '0', NULL, '2022-02-13 01:30:31', '2022-02-13 01:30:31');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2022_02_12_042037_create_companies_table', 1);
INSERT INTO `migrations` VALUES (6, '2022_02_12_042638_create_denominations_table', 1);
INSERT INTO `migrations` VALUES (7, '2022_02_12_043040_create_categories_table', 1);
INSERT INTO `migrations` VALUES (8, '2022_02_12_043254_create_products_table', 1);
INSERT INTO `migrations` VALUES (9, '2022_02_12_044510_create_sales_table', 1);
INSERT INTO `migrations` VALUES (10, '2022_02_12_225255_create_sale_details_table', 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cost` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `price` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL,
  `alerts` int(11) NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `products_category_id_foreign`(`category_id`) USING BTREE,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 'Curso laravel', '75010065987', 200.00, 350.00, 1000, 10, 'curso.jpg', 1, '2022-02-13 01:30:32', '2022-02-13 01:30:32');
INSERT INTO `products` VALUES (2, 'Curso laravel', '75010065987', 200.00, 350.00, 1000, 10, 'curso.jpg', 2, '2022-02-13 01:30:32', '2022-02-13 01:30:32');
INSERT INTO `products` VALUES (3, 'Curso laravel', '75010065987', 200.00, 350.00, 1000, 10, 'curso.jpg', 3, '2022-02-13 01:30:32', '2022-02-13 01:30:32');
INSERT INTO `products` VALUES (4, 'Curso laravel', '75010065987', 200.00, 350.00, 1000, 10, 'curso.jpg', 4, '2022-02-13 01:30:32', '2022-02-13 01:30:32');

-- ----------------------------
-- Table structure for sale_details
-- ----------------------------
DROP TABLE IF EXISTS `sale_details`;
CREATE TABLE `sale_details`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `price` decimal(10, 2) NOT NULL,
  `quantity` decimal(10, 2) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sale_details_product_id_foreign`(`product_id`) USING BTREE,
  INDEX `sale_details_sale_id_foreign`(`sale_id`) USING BTREE,
  CONSTRAINT `sale_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sale_details_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sale_details
-- ----------------------------

-- ----------------------------
-- Table structure for sales
-- ----------------------------
DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `total` decimal(10, 2) NOT NULL,
  `items` int(11) NOT NULL,
  `cash` decimal(10, 2) NOT NULL,
  `change` decimal(10, 2) NOT NULL,
  `status` enum('PAID','PENDING','CANCELLED') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PAID',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sales_user_id_foreign`(`user_id`) USING BTREE,
  CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sales
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` enum('ADMIN','EMPLOYEE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ADMIN',
  `status` enum('ACTIVE','LOCKED') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Juan', '9361199500', 'juan@gmail.com', 'ADMIN', 'ACTIVE', NULL, '$2y$10$qK4iQLq9TUiu8eCCd446Q.Fp8xui3kGY0Tr9suqLgOUFq360EgOra', NULL, NULL, '2022-02-13 01:30:32', '2022-02-13 01:30:32');
INSERT INTO `users` VALUES (2, 'Carlos', '9363896099', 'carlos@gmail.com', 'EMPLOYEE', 'ACTIVE', NULL, '$2y$10$zR4mOp04Qq6wz518Lvd6YeTRMXJQr7ixRaP5zqAFkEhFieLHXffe2', NULL, NULL, '2022-02-13 01:30:32', '2022-02-13 01:30:32');

SET FOREIGN_KEY_CHECKS = 1;
