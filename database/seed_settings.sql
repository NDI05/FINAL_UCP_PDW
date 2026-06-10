-- Site Settings table for NDI CMS
-- Run this file to add site_settings support

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
