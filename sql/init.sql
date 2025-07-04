CREATE DATABASE meylan_tv;
USE meylan_tv;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE disponibilites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  date DATE,
  disponible BOOLEAN,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Exemple : création d’un compte admin
INSERT INTO users (username, password_hash, is_admin)
VALUES ('admin', SHA2('adminpass', 256), TRUE);
