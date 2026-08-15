CREATE TABLE IF NOT EXISTS pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pet_name VARCHAR(100) NOT NULL,
    pet_type_id INT,
    pet_type VARCHAR(50) NOT NULL,
    breed VARCHAR(100),
    age INT,
    gender VARCHAR(20),
    owner_name VARCHAR(100),
    contact_number VARCHAR(50),
    status VARCHAR(50) DEFAULT 'Active'
);
