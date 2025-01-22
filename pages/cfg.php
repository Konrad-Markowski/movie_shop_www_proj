<?php
// Database Configuration File: cfg.php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'shop';

// Create connection
$mysqli = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

