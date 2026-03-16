-- Nagashree English School
-- MySQL schema for cPanel/phpMyAdmin import
-- Charset/engine aligned with the PHP application

SET NAMES utf8mb4;
SET time_zone = '+00:00';

CREATE TABLE IF NOT EXISTS admin_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS gallery_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  src LONGTEXT NOT NULL,
  alt_text VARCHAR(255) NOT NULL,
  category VARCHAR(50) NOT NULL,
  title VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS faculties (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  role VARCHAR(150) NOT NULL,
  subject VARCHAR(150) NOT NULL,
  experience VARCHAR(100) NOT NULL,
  image LONGTEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(30) NULL,
  subject VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  seen TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS admissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_name VARCHAR(150) NOT NULL,
  parent_name VARCHAR(150) NOT NULL,
  dob VARCHAR(30) NOT NULL,
  gender VARCHAR(30) NOT NULL,
  class_applying VARCHAR(50) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  email VARCHAR(255) NULL,
  address TEXT NOT NULL,
  previous_school VARCHAR(255) NULL,
  previous_grade VARCHAR(100) NULL,
  aadhaar VARCHAR(30) NULL,
  seen TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Notes:
-- 1) Do not insert a plain-text admin password here.
-- 2) On first app load, bootstrap logic in functions/helpers.php automatically creates:
--    username: admin
--    password: admin123
--    if admin_users is empty.
-- 3) It also auto-seeds default gallery/faculty data if those tables are empty.
