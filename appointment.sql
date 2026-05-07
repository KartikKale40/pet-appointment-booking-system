CREATE DATABASE appointment;
USE appointment;

-- =========================
-- USERS TABLE
-- =========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    address VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- APPOINTMENTS TABLE
-- =========================
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,

    pet_name VARCHAR(100) NOT NULL,
    pet_type VARCHAR(50) NOT NULL,
    breed VARCHAR(100),
    color VARCHAR(50),

    age INT,
    weight DECIMAL(5,2),

    gender VARCHAR(20),

    health_problem TEXT,

    vaccinated VARCHAR(10),

    vaccination_date DATE NULL,

    vaccination_file VARCHAR(255),

    behaviour VARCHAR(255),

    service VARCHAR(100) NOT NULL,

    appointment_date DATE NOT NULL,

    time_slot VARCHAR(50) NOT NULL,

    status VARCHAR(50) DEFAULT 'Pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
);

-- =========================
-- SCHEDULED APPOINTMENTS TABLE
-- =========================
CREATE TABLE scheduled_appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,

    appointment_id INT NOT NULL,

    pet_name VARCHAR(100),
    pet_type VARCHAR(50),

    age INT,

    vaccinated VARCHAR(10),

    behaviour VARCHAR(255),

    service VARCHAR(100),

    appointment_date DATE,

    time_slot VARCHAR(50),

    scheduled_time TIME,

    charges DECIMAL(10,2),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (appointment_id) REFERENCES appointments(id)
    ON DELETE CASCADE
);

-- =========================
-- OPTIONAL ADMIN TABLE
-- =========================
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Default Admin
INSERT INTO admin(username, password)
VALUES ('admin', 'admin123');