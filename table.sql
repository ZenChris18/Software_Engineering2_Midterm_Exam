CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    address VARCHAR(255),
    age INT,
    email VARCHAR(100) UNIQUE,
    password_hash VARCHAR(255), -- hash passworsd
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- edit table from previous activity
ALTER TABLE Customers 
ADD COLUMN added_by INT,
ADD COLUMN last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE SaaS_Products 
ADD COLUMN added_by INT,
ADD COLUMN last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- add last updated by column
ALTER TABLE Customers 
ADD COLUMN last_updated_by INT AFTER subscription_end_date;


