CREATE DATABASE IF NOT EXISTS `donations`;

CREATE TABLE IF NOT EXISTS `donations`.`submissions` (
    `id` INT AUTO_INCREMENT,
    `last_name` VARCHAR(256) NOT NULL,
    `first_name` VARCHAR(256) NOT NULL,
    `street_address` VARCHAR(512) NOT NULL,
    `city` VARCHAR(128) NOT NULL,
    `region` VARCHAR(128),
    `country` VARCHAR(64) NOT NULL,
    `postal_code` VARCHAR(16),
    `phone_number` VARCHAR(32) NOT NULL,
    `email_address` VARCHAR(256) NOT NULL, -- RFC 5321
    `contact_method` ENUM('phone', 'email') NOT NULL,
    `currency` ENUM('USD', 'EUR', 'BTC') NOT NULL,
    `frequency` ENUM('monthly', 'yearly', 'once') NOT NULL,
    `donation_amount` INT NOT NULL, -- in cents/pence/satoshi
    `comments` VARCHAR(2048),
    PRIMARY KEY (`id`)
) COLLATE utf8mb4_bin; -- ENGINE = InnoDB