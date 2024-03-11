<?php
ini_set('memory_limit','-1');
$servername = "localhost";
$username = "root";
$password = null;
$dbname = "storage";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === FALSE) {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($dbname);

// Create stores table
$sql = "CREATE TABLE IF NOT EXISTS stores (
    id INT(11) PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    address VARCHAR(50)
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Create rows table
$sql = "CREATE TABLE IF NOT EXISTS rowss (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30)
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Create columns table
$sql = "CREATE TABLE IF NOT EXISTS columns (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30)
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Create shelves table
$sql = "CREATE TABLE IF NOT EXISTS shelves (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30)
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Create products table
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_store INT(11),
    id_row INT(11),
    id_column INT(11),
    id_shelf INT(11),
    name VARCHAR(30) NOT NULL,
    price FLOAT(6) NOT NULL,
    quantity INT(11) NOT NULL,
    min_quantity INT(11) NOT NULL,
    FOREIGN KEY (id_shelf) REFERENCES shelves(id),
    FOREIGN KEY (id_store) REFERENCES stores(id),
    FOREIGN KEY (id_row) REFERENCES rowss(id),
    FOREIGN KEY (id_column) REFERENCES columns(id)
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

$conn->close();
?>