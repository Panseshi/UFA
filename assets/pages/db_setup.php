<?php
include 'db_connect.php';

// SQL to create roles table
$sql_roles = "CREATE TABLE IF NOT EXISTS roles (
    role_id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(50) UNIQUE
)";

$conn->query($sql_roles);

// SQL to create users table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    user_first_name VARCHAR(50),
    user_last_name VARCHAR(50),
    user_email VARCHAR(100) UNIQUE,
    user_phone VARCHAR(20),
    user_date_of_birth DATE,
    user_registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_login VARCHAR(64),
    user_password VARCHAR(128),
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
)";

$conn->query($sql_users);

// SQL to create tours table
$sql_tours = "CREATE TABLE IF NOT EXISTS tours (
    tour_id INT PRIMARY KEY AUTO_INCREMENT,
    tour_name VARCHAR(100),
    tour_description TEXT,
    price DECIMAL(10, 2),
    duration INT,
    start_date DATE,
    end_date DATE
)";

$conn->query($sql_tours);

// SQL to create souvenirs table
$sql_souvenirs = "CREATE TABLE IF NOT EXISTS souvenirs (
    souvenir_id INT PRIMARY KEY AUTO_INCREMENT,
    sounvenir_name VARCHAR(100),
    souvenir_description TEXT,
    souvenir_price DECIMAL(10, 2),
    stock_quantity INT
)";

$conn->query($sql_souvenirs);

// SQL to create bookings table
$sql_bookings = "CREATE TABLE IF NOT EXISTS bookings (
    booking_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    tour_id INT,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    number_of_people INT,
    booking_price DECIMAL(10, 2),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (tour_id) REFERENCES tours(tour_id)
)";

$conn->query($sql_bookings);

// SQL to create purchases table
$sql_purchases = "CREATE TABLE IF NOT EXISTS purchases (
    purchase_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    souvenir_id INT,
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    purchase_quantity INT,
    purchase_price DECIMAL(10, 2),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (souvenir_id) REFERENCES souvenirs(souvenir_id)
)";

$conn->query($sql_purchases);

// SQL to create hotels table
$sql_hotels = "CREATE TABLE IF NOT EXISTS hotels (
    hotel_id INT PRIMARY KEY AUTO_INCREMENT,
    hotel_name VARCHAR(100),
    hotel_location VARCHAR(100),
    hotel_description TEXT,
    hotel_profile TEXT,
    hotel_price DECIMAL(10, 2),
    hotel_rooms INT,
    hotel_amenities TEXT,
    hotel_contact_info VARCHAR(100),
    hotel_rank INT,
    hotel_image TEXT,
    hotel_distance INT //* distance from airport */
)";

$conn->query($sql_hotels);

// SQL to create holiday_types table
$sql_holiday_types = "CREATE TABLE IF NOT EXISTS holiday_types (
    type_id INT PRIMARY KEY AUTO_INCREMENT,
    holiday_type VARCHAR(255) UNIQUE
)";

// SQL to create hotel_holiday_types table
$sql_hotel_holiday_types = "CREATE TABLE IF NOT EXISTS hotel_holiday_types (
    hotel_id INT,
    type_id INT,
    PRIMARY KEY (hotel_id, type_id),
    FOREIGN KEY (hotel_id) REFERENCES hotels(hotel_id),
    FOREIGN KEY (type_id) REFERENCES holiday_types(type_id)
)";

/* 
CREATE TABLE reservations (
    reservation_id INT PRIMARY KEY AUTO_INCREMENT,
    hotel_id INT,
    check_in_date DATE,
    check_out_date DATE,
    -- other fields as needed
    FOREIGN KEY (hotel_id) REFERENCES hotels(hotel_id)
);

CREATE TABLE `rooms` (
    `room_id` int(11) NOT NULL,
    `hotel_id` int(11) DEFAULT NULL,
    `room_type` varchar(255) DEFAULT NULL,
    `price` decimal(10,2) DEFAULT NULL,
    `availability` tinyint(1) DEFAULT 1
  );


*/

?>
