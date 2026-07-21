CREATE DATABASE student_management;

USE student_management;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roll_no VARCHAR(20) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    gender VARCHAR(10),
    department VARCHAR(50),
    year INT,
    profile_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

ALTER TABLE students
ADD password VARCHAR(255) NOT NULL;

ALTER TABLE admins
ADD COLUMN email VARCHAR(100),
ADD COLUMN photo VARCHAR(255);

ALTER TABLE students
ADD address VARCHAR(255);