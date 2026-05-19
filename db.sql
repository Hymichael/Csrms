-- SQL schema for CSRMS
CREATE DATABASE IF NOT EXISTS csrms;
USE csrms;

-- users table (admins & staff)
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','staff') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- customers table
CREATE TABLE IF NOT EXISTS customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  license_number VARCHAR(80),
  contact VARCHAR(80),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- cars table
CREATE TABLE IF NOT EXISTS cars (
  id INT AUTO_INCREMENT PRIMARY KEY,
  vin VARCHAR(100) UNIQUE,
  model VARCHAR(150),
  year SMALLINT,
  mileage INT,
  daily_rate DECIMAL(10,2),
  status ENUM('available','rented','maintenance','sold') DEFAULT 'available',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- rentals table
CREATE TABLE IF NOT EXISTS rentals (
  id INT AUTO_INCREMENT PRIMARY KEY,
  car_id INT NOT NULL,
  customer_id INT NOT NULL,
  staff_id INT NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  total_cost DECIMAL(12,2),
  status ENUM('pending','active','completed','cancelled') DEFAULT 'pending',
  damage_notes TEXT,
  late_fee DECIMAL(10,2) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE,
  FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
  FOREIGN KEY (staff_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Insert default users (passwords hashed)
-- Passwords: Admin@123 and Staff@123
INSERT INTO users (name, email, password, role) VALUES
('Administrator','admin@example.com','','admin'),
('Staff Member','staff@example.com','','staff');

-- Sample cars
INSERT INTO cars (vin, model, year, mileage, daily_rate, status) VALUES
('1HGBH41JXMN109186','Toyota Corolla',2020,35000,100.00,'available'),
('3C6JR6DT0GG100001','Hyundai Accent',2018,52000,80.00,'available');

-- Sample customer
INSERT INTO customers (name, license_number, contact) VALUES
('John Doe','DL-123456','0911000111');
