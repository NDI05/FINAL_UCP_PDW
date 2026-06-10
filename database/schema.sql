-- Active: 1779261121855@@127.0.0.1@3306
CREATE DATABASE IF NOT EXISTS ndi_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ndi_cms;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'editor',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    visits INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT,
    page VARCHAR(255) NOT NULL,
    visited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_visited_at (visited_at),
    INDEX idx_page (page)
) ENGINE=InnoDB;

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    author_id INT DEFAULT NULL,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@nusadataindonesia.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

CREATE TABLE IF NOT EXISTS site_settings (
    `key` VARCHAR(100) PRIMARY KEY,
    `value` TEXT NULL,
    `label` VARCHAR(255) NOT NULL DEFAULT '',
    `group` VARCHAR(50) NOT NULL DEFAULT 'general',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT IGNORE INTO site_settings (`key`, `value`, `label`, `group`) VALUES
('landing_hero_eyebrow', 'WE ARE NDI', 'Hero Eyebrow Text', 'landing'),
('landing_hero_title', 'DATA IS THE NEW TERRITORY', 'Hero Main Title', 'landing'),
('landing_hero_subtitle', 'Nusa Data Indonesia transforms raw data into strategic advantage for organizations across the archipelago.', 'Hero Subtitle', 'landing'),
('landing_statement', 'In a world driven by information, those who understand data lead the conversation. We exist to make that leadership accessible.', 'Statement Section Text', 'landing'),
('about_tagline', 'We are not consultants. We are navigators.', 'About Tagline', 'about'),
('about_intro', 'Founded in the archipelago, Nusa Data Indonesia exists at the intersection of data science, strategic consulting, and local intelligence.', 'About Intro Text', 'about'),
('services_intro', 'Four core capabilities. One integrated approach to data intelligence.', 'Services Intro Text', 'services'),
('contact_address', 'Jl. Sudirman No. 123, Jakarta Selatan, DKI Jakarta 12190', 'Office Address', 'contact'),
('contact_email', 'hello@nusadataindonesia.com', 'Contact Email', 'contact'),
('contact_phone', '+62 21 1234 5678', 'Contact Phone', 'contact'),
('site_name', 'Nusa Data Indonesia', 'Site Name', 'general'),
('site_tagline', 'Data Intelligence for the Archipelago', 'Site Tagline', 'general');
