<?php

$host = 'localhost';
$username = 'root';
$password = '1402';  // Provide your MySQL password if any
$dbname = 'major_testing';

try {
    // DSN (Data Source Name) for the PDO connection
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

    // Create a PDO instance (this connects to the database)
    $pdo = new PDO($dsn, $username, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // If connection is successful, you can proceed
    // echo "Connected successfully!";
} catch (PDOException $e) {
    // If the connection fails, it will display an error message
    die("Connection failed:" . $e->getMessage());
}


