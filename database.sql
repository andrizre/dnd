-- Create database
CREATE DATABASE dungeon_rpg;
USE dungeon_rpg;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Characters table
CREATE TABLE characters (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    name VARCHAR(50) NOT NULL,
    level INT DEFAULT 1,
    experience INT DEFAULT 0,
    health INT DEFAULT 100,
    max_health INT DEFAULT 100,
    strength INT DEFAULT 10,
    defense INT DEFAULT 10,
    gold INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Quests table
CREATE TABLE quests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    min_level INT DEFAULT 1,
    experience_reward INT NOT NULL,
    gold_reward INT NOT NULL
);

-- User_quests table
CREATE TABLE user_quests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    quest_id INT,
    status ENUM('active', 'completed') DEFAULT 'active',
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (quest_id) REFERENCES quests(id)
);