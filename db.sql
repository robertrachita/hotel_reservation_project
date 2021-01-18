CREATE DATABASE IF NOT EXISTS `hotel_system`  DEFAULT CHARACTER SET utf8mb4;
USE `hotel_system`;

CREATE TABLE IF NOT EXISTS `apartments` (
    `apartment_id`      INT UNIQUE NOT NULL AUTO_INCREMENT,
    `name`              VARCHAR(50) NOT NULL,
    `description`       VARCHAR(500),
    `capacity`          TINYINT NOT NULL,
    `price_night_regular`       DECIMAL(8,2) NOT NULL,
    `price_week_regular`        DECIMAL(8,2) NOT NULL,
    `price_weekend_regular`     DECIMAL(8,2) NOT NULL,
    `price_night_season`        DECIMAL(8,2) NOT NULL,
    `price_week_season`         DECIMAL(8,2) NOT NULL,
    `price_weekend_season`      DECIMAL(8,2) NOT NULL,
    `price_night_vacation`      DECIMAL(8,2) NOT NULL,
    `price_week_vacation`       DECIMAL(8,2) NOT NULL,
    `price_weekend_vacation`    DECIMAL(8,2) NOT NULL,

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
    `date_created`      DATE NOT NULL,
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
INSERT INTO `apartments`(`name`, `description`, `capacity`, `price_night_regular`, `price_week_regular`, `price_weekend_regular`, `price_night_season`, `price_week_season`, `price_weekend_season`,`price_night_vacation`, `price_week_vacation`, `price_weekend_vacation`) values 
('Iemke', 'this', 2, 50, 350, 100, 55, 375, 125, 70, 450, 150),
('Jaakje', 'is', 2, 50, 350, 100, 55, 375, 125, 70, 450, 150),
('Sil', 'a', 3, 60, 395, 112.5, 62, 425, 125, 72, 495, 150),
('Jelle','valid', 4, 65, 450, 137.5, 70, 475, 162.5, 80, 550, 175),
('Wietse','description', 4, 65, 450, 137.5, 70, 475, 162.5, 80, 550, 175),
('Lobke', 'for', 5, 70, 475, 162.5, 75, 500, 187.5, 85, 585, 200),
('Maam', 'these', 6, 70, 475, 162.5, 75, 525, 187.5, 85, 585, 200),
('Test', 'apartments', 2, 10, 90, 15, 10, 90, 15, 10, 90, 15);
/* (default) bcrypt hash, password is admin, for developing purposes only*/
INSERT INTO `users`(`last_name`, `first_name`, `country`, `city`, `email`, `password`, `authorisation`) values
    ('Peters', 'Victor', 'Netherlands', 'Groningen', 'admin@admin.com', '$2y$12$DznTtqjtDvfT6RvFfQdL7OmU1l4fsycMhVD38yG7eCO16v3jLzPKy', '1');

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `images` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO `article` (`id`, `title`, `images`) VALUES
(1, 'Vaccine for Covid 19', 'covid.jpg'),
(2, 'Covid-19 Cases in Netherlands', 'covid-19.jpg'),
(3, 'Explore Netherlands', 'travel.jpg'),
(4, "It's Getting Colder in Netherlands", 'winter.jpg'),
(5, 'Nightlife in Netherlands', 'party.jpg'),
(6, 'Cost of Life in Netherlands', 'money.jpg'),
(7, 'Why Study Career Coaching is Important for Your Life', 'scc.jpg'),
(8, 'Too Much Coding Can Harm Your Brain', 'barin.png'),
(9, 'Cybernetic Arms for Humans', 'cyber.jpg');
