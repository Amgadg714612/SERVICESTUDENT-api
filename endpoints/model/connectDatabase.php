<?php
// connectDatabase.php

// Replace these values with your actual database credentials
            //$host = 'your_database_host';
            //$dbname = 'your_database_name';
            //$username = 'your_database_username';
            //$password = 'your_database_password';

    $host = 'localhost';
    $dbname = 'question_solver';
    $username = 'root';
    $password = '';     

// Function to establish a database connection
function getDatabaseConnection() {
    global $host, $dbname, $username, $password;
    
    $host = 'localhost';
    $dbname = 'question_solver';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo " TYR";
        return $pdo;
    } catch (PDOException $e) {
        // Handle database connection errors
        // Log or display an error message
         // Handle database connection errors
        $errorResponse = [
            'success' => false,
            'message' => 'Database connection failed 1: ' . $e->getMessage(),
        ];
        echo json_encode($errorResponse);
        exit; // Terminate the script
        die('Database connection failed 1 : ' . $e->getMessage());
    }
}
?>