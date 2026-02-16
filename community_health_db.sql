CREATE DATABASE IF NOT EXISTS community_health
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Create a dedicated database user (do NOT use root in your program)
CREATE USER IF NOT EXISTS 'chc_user'@'localhost' IDENTIFIED BY 'chc_pass';
CREATE USER IF NOT EXISTS 'chc_user'@'127.0.0.1' IDENTIFIED BY 'chc_pass';

GRANT SELECT, INSERT, UPDATE, DELETE ON community_health.* TO 'chc_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON community_health.* TO 'chc_user'@'127.0.0.1';

FLUSH PRIVILEGES;

USE community_health;

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL
);

INSERT INTO categories (category_name) VALUES
('Mental Health'),
('Food Insecurity'),
('Housing & Shelter'),
('Women\'s Health'),
('General Health Clinic'),
('Support Group');

CREATE TABLE IF NOT EXISTS resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    zip_code VARCHAR(20) NOT NULL,
    phone VARCHAR(30),
    website VARCHAR(255),
    category_id INT NOT NULL,
    description TEXT,
    hours VARCHAR(255),
    latitude DECIMAL(10, 7) DEFAULT NULL,
    longitude DECIMAL(10, 7) DEFAULT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admins (username, password)
VALUES ('admin', 'admin123');
