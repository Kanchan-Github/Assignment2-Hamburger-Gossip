--Drop the existing Database if exists
DROP DATABASE IF EXISTS HAMBURGER;
CREATE DATABASE HAMBURGER CHARACTER SET utf8_general_ci;

GRANT SELECT, INSERT, UPDATE, DELETE
ON HAMBURGER.*
TO 'root'@'localhost'
IDENTIFIED BY ''; -- PASSWORD

--create table
CREATE TABLE hamburger (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    text VARCHAR(100) NOT NULL,
    post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    likes INT(3) NOT NULL,
    reply_to VARCHAR(100)
    
);

-- DML to create data
INSERT INTO hamburger
(name, text,)
VALUES
('user30344274', 'i like to eat hamburger'),
('david', 'hamburgers are the best burger'),
('wayne', 'i hate hamburger'),
('anonymous', 'when i am hungry i like to eat hamburger'),
('bruce', 'some say it is the worst burger'),
('taylor','hamburger is a junk food'),
('jsnfg', 'hamburger is ehrej'),
('harley', 'hamburger is good burger');