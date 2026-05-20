-- ============================================
-- Sales Analytics Dashboard - Database Schema
-- ============================================

CREATE DATABASE IF NOT EXISTS sales_dashboard CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sales_dashboard;

-- -----------------------------------------------
-- Customers Table
-- -----------------------------------------------
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    phone VARCHAR(20),
    city VARCHAR(100),
    country VARCHAR(100) DEFAULT 'Tanzania',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------
-- Products Table
-- -----------------------------------------------
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    category VARCHAR(100),
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------
-- Sales Table
-- -----------------------------------------------
CREATE TABLE IF NOT EXISTS sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    unit_price DECIMAL(10,2) NOT NULL,
    total_amount DECIMAL(10,2) GENERATED ALWAYS AS (quantity * unit_price) STORED,
    status ENUM('pending','completed','cancelled','refunded') DEFAULT 'completed',
    sale_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- -----------------------------------------------
-- Sample Data - Customers
-- -----------------------------------------------
INSERT INTO customers (name, email, phone, city) VALUES
('Amina Hassan',     'amina@email.com',    '+255712345678', 'Dar es Salaam'),
('John Mkwawa',      'john@email.com',     '+255723456789', 'Arusha'),
('Fatuma Juma',      'fatuma@email.com',   '+255734567890', 'Mwanza'),
('Peter Ngowi',      'peter@email.com',    '+255745678901', 'Dodoma'),
('Grace Mwangi',     'grace@email.com',    '+255756789012', 'Zanzibar'),
('Ali Hamisi',       'ali@email.com',      '+255767890123', 'Tanga'),
('Sarah Kimani',     'sarah@email.com',    '+255778901234', 'Morogoro'),
('David Osei',       'david@email.com',    '+255789012345', 'Dar es Salaam'),
('Zaina Rashid',     'zaina@email.com',    '+255790123456', 'Mbeya'),
('Emmanuel Temba',   'emmanuel@email.com', '+255701234567', 'Iringa');

-- -----------------------------------------------
-- Sample Data - Products
-- -----------------------------------------------
INSERT INTO products (name, category, price, stock) VALUES
('Laptop Pro 15"',          'Electronics',   1500000, 45),
('Wireless Headphones',     'Electronics',    85000,  120),
('Office Chair Ergonomic',  'Furniture',     250000,  30),
('Standing Desk',           'Furniture',     450000,  15),
('USB-C Hub 7-in-1',        'Electronics',    45000,  200),
('Monitor 27" 4K',          'Electronics',   750000,  25),
('Mechanical Keyboard',     'Electronics',   120000,  80),
('Webcam HD 1080p',         'Electronics',    65000,  90),
('Desk Lamp LED',           'Furniture',      35000,  150),
('External SSD 1TB',        'Electronics',   180000,  60);

-- -----------------------------------------------
-- Sample Data - Sales (last 12 months)
-- -----------------------------------------------
INSERT INTO sales (customer_id, product_id, quantity, unit_price, status, sale_date) VALUES
(1,  1, 1, 1500000, 'completed', DATE_SUB(CURDATE(), INTERVAL 340 DAY)),
(2,  2, 2,   85000, 'completed', DATE_SUB(CURDATE(), INTERVAL 330 DAY)),
(3,  3, 1,  250000, 'completed', DATE_SUB(CURDATE(), INTERVAL 320 DAY)),
(4,  4, 1,  450000, 'completed', DATE_SUB(CURDATE(), INTERVAL 310 DAY)),
(5,  5, 3,   45000, 'completed', DATE_SUB(CURDATE(), INTERVAL 300 DAY)),
(6,  6, 1,  750000, 'completed', DATE_SUB(CURDATE(), INTERVAL 290 DAY)),
(7,  7, 2,  120000, 'completed', DATE_SUB(CURDATE(), INTERVAL 280 DAY)),
(8,  8, 1,   65000, 'completed', DATE_SUB(CURDATE(), INTERVAL 270 DAY)),
(9,  9, 4,   35000, 'completed', DATE_SUB(CURDATE(), INTERVAL 260 DAY)),
(10,10, 2,  180000, 'completed', DATE_SUB(CURDATE(), INTERVAL 250 DAY)),
(1,  2, 1,   85000, 'completed', DATE_SUB(CURDATE(), INTERVAL 240 DAY)),
(2,  6, 1,  750000, 'completed', DATE_SUB(CURDATE(), INTERVAL 230 DAY)),
(3,  1, 2, 1500000, 'completed', DATE_SUB(CURDATE(), INTERVAL 220 DAY)),
(4,  7, 1,  120000, 'completed', DATE_SUB(CURDATE(), INTERVAL 210 DAY)),
(5,  3, 2,  250000, 'completed', DATE_SUB(CURDATE(), INTERVAL 200 DAY)),
(6,  5, 5,   45000, 'completed', DATE_SUB(CURDATE(), INTERVAL 190 DAY)),
(7,  8, 2,   65000, 'completed', DATE_SUB(CURDATE(), INTERVAL 180 DAY)),
(8,  4, 1,  450000, 'cancelled', DATE_SUB(CURDATE(), INTERVAL 170 DAY)),
(9,  2, 3,   85000, 'completed', DATE_SUB(CURDATE(), INTERVAL 160 DAY)),
(10, 9, 6,   35000, 'completed', DATE_SUB(CURDATE(), INTERVAL 150 DAY)),
(1,  6, 1,  750000, 'completed', DATE_SUB(CURDATE(), INTERVAL 140 DAY)),
(2,  1, 1, 1500000, 'completed', DATE_SUB(CURDATE(), INTERVAL 130 DAY)),
(3,  5, 4,   45000, 'completed', DATE_SUB(CURDATE(), INTERVAL 120 DAY)),
(4,  8, 1,   65000, 'completed', DATE_SUB(CURDATE(), INTERVAL 110 DAY)),
(5, 10, 1,  180000, 'completed', DATE_SUB(CURDATE(), INTERVAL 100 DAY)),
(6,  7, 2,  120000, 'completed', DATE_SUB(CURDATE(), INTERVAL 90  DAY)),
(7,  3, 1,  250000, 'completed', DATE_SUB(CURDATE(), INTERVAL 80  DAY)),
(8,  9, 5,   35000, 'completed', DATE_SUB(CURDATE(), INTERVAL 70  DAY)),
(9,  1, 1, 1500000, 'completed', DATE_SUB(CURDATE(), INTERVAL 60  DAY)),
(10, 4, 1,  450000, 'completed', DATE_SUB(CURDATE(), INTERVAL 50  DAY)),
(1,  7, 3,  120000, 'completed', DATE_SUB(CURDATE(), INTERVAL 40  DAY)),
(2,  5, 2,   45000, 'completed', DATE_SUB(CURDATE(), INTERVAL 30  DAY)),
(3,  2, 4,   85000, 'completed', DATE_SUB(CURDATE(), INTERVAL 25  DAY)),
(4,  6, 1,  750000, 'completed', DATE_SUB(CURDATE(), INTERVAL 20  DAY)),
(5,  8, 2,   65000, 'refunded',  DATE_SUB(CURDATE(), INTERVAL 15  DAY)),
(6,  1, 1, 1500000, 'completed', DATE_SUB(CURDATE(), INTERVAL 10  DAY)),
(7, 10, 2,  180000, 'completed', DATE_SUB(CURDATE(), INTERVAL 7   DAY)),
(8,  3, 1,  250000, 'completed', DATE_SUB(CURDATE(), INTERVAL 5   DAY)),
(9,  9, 3,   35000, 'completed', DATE_SUB(CURDATE(), INTERVAL 3   DAY)),
(10, 7, 1,  120000, 'pending',   DATE_SUB(CURDATE(), INTERVAL 1   DAY));
