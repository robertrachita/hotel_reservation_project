CREATE DATABASE IF NOT EXISTS `hotel_system`  DEFAULT CHARACTER SET utf8mb4;
USE `hotel_system`;

CREATE TABLE IF NOT EXISTS `apartments` (
    `apartment_id`      INT UNIQUE NOT NULL AUTO_INCREMENT,
    `name`              VARCHAR(50) NOT NULL,
    `description`       VARCHAR(500),
    `capacity`          TINYINT NOT NULL,
    `price_night`       DECIMAL(8,2) NOT NULL,
    `price_week`        DECIMAL(8,2) NOT NULL,
    `price_weekend`     DECIMAL(8,2) NOT NULL,
    `discount`          TINYINT NOT NULL,

    CONSTRAINT PK_apartment_id PRIMARY KEY (apartment_id)

)ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `users`(
    `user_id`           INT UNIQUE NOT NULL AUTO_INCREMENT,
    `last_name`         VARCHAR(50) NOT NULL,
    `first_name`        VARCHAR(50) NOT NULL,
    `date_of_birth`     DATE NOT NULL,
    `country`           VARCHAR(50) NOT NULL,
    `city`              VARCHAR(50),
    `street`            VARCHAR(50),
    `postal_code`       VARCHAR(15) NOT NULL,
    `house_number`      INT,
    `telephone_number`  VARCHAR(15) NOT NULL,
    `email`             VARCHAR(255) UNIQUE NOT NULL,
    `password`          VARCHAR(255) NOT NULL,
    `authorisation`     BOOLEAN NOT NULL DEFAULT '0',       

    INDEX (`email`, `password`,`authorisation`),
    CONSTRAINT PK_user_id PRIMARY KEY (user_id)

)ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `orders`(
    `order_id`          INT UNIQUE NOT NULL AUTO_INCREMENT,
    `date_start`        DATE NOT NULL,
    `date_end`          DATE NOT NULL,
    `status`            ENUM('PENDING', 'ACCEPTED', 'DECLINED') NOT NULL DEFAULT 'PENDING',
    `total_price`       DECIMAL(8,2) NOT NULL,
    `apartment_id`      INT,
    `user_id`           INT,
 
    CONSTRAINT PK_order_id PRIMARY KEY (order_id),
    CONSTRAINT FK_apartment_orders FOREIGN KEY (apartment_id)
                                REFERENCES apartments (apartment_id)
                                ON UPDATE CASCADE
                                ON DELETE NO ACTION,
    CONSTRAINT FK_user_orders FOREIGN KEY (user_id)
                              REFERENCES users (user_id)
                              ON UPDATE CASCADE
                              ON DELETE NO ACTION                         

)ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `contact` (
    `contact_id`        INT UNIQUE NOT NULL AUTO_INCREMENT,
    `message`           VARCHAR(255) NOT NULL,
    `response`          VARCHAR(255),
    `date`              DATE NOT NULL,
    `user_id_contact`   INT,

    CONSTRAINT PK_contact_id PRIMARY KEY (contact_id),
    CONSTRAINT FK_user_contact FOREIGN KEY (user_id_contact)
                                REFERENCES users (user_id)
                                ON UPDATE CASCADE
                                ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/* Appartment information*/
INSERT INTO `apartments`(`name`,`capacity`) values 
('Iemke', 2),
('Jaakje', 2),
('Sil', 3),
('Jelle', 4),
('Wietse', 4),
('Lobke', 5),
('Maam', 6);
/* default bcrypt hash, password is admin, for developing purposes only*/
INSERT INTO `users`(`last_name`, `first_name`, `country`, `city`, `email`, `password`, `authorisation`) values
    ('Peters', 'Victor', 'Netherlands', 'Groningen', 'admin@admin.com', '$2y$12$DznTtqjtDvfT6RvFfQdL7OmU1l4fsycMhVD38yG7eCO16v3jLzPKy', '1');