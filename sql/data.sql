CREATE TABLE customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    purpose TEXT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    added_by VARCHAR(50),
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by VARCHAR(50)
);

CREATE TABLE virtual_pc (
    pc_id INT AUTO_INCREMENT PRIMARY KEY,
    pc_name VARCHAR(50),
    pc_specs TEXT,
    customer_id INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_passwords (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255),
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    dob DATE,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
