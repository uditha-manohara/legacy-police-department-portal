CREATE DATABASE IF NOT EXISTS db_name;
USE db_name;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  ingame_name VARCHAR(100),
  rank VARCHAR(100),
  callsign VARCHAR(50),
  is_admin TINYINT(1) DEFAULT 0
);

CREATE TABLE rule_breaks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  warning TEXT,
  added_by INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE notices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  content TEXT,
  from_user_id INT,
  to_ranks TEXT,
  start_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  end_date DATETIME,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE warnings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  content TEXT,
  from_user_id INT,
  to_user_id INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    username VARCHAR(255),
    action TEXT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Section 1.0
    full_name_ooc VARCHAR(100),
    gender ENUM('Male', 'Female'),
    birthday DATE,
    whatsapp VARCHAR(20),
    email VARCHAR(100),
    discord VARCHAR(50),
    mta_serial VARCHAR(100),
    character_slot ENUM('1st', '2nd'),
    gang_member ENUM('Yes', 'No'),
    mic ENUM('Yes', 'No'),

    -- Section 2.0
    full_name_ic VARCHAR(100),
    age INT,
    backstory TEXT,
    reason_to_join TEXT,
    duty_hours VARCHAR(50),
    workshift SET('Morning', 'Afternoon', 'Evening', 'Night'),

    -- Section 3.0
    username VARCHAR(50),
    password VARCHAR(256),

    status ENUM('Pending', 'Accepted', 'Denied') DEFAULT 'Pending',
    reviewer_id INT DEFAULT NULL,
    reviewed_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



INSERT INTO users (username, password, rank, is_admin) VALUES ('admin', SHA2('123', 256), 'Chief', 1);
