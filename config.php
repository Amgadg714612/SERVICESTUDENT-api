<?php
// config.php
// Database configuration
$databaseHost = 'localhost';
$databaseName = 'question_solver';
$databaseUser = 'root';
$databasePassword = '';
// Other configuration settings
$apiBaseUrl = 'http://your-api-base-url.com';
$uploadDirectory = '/path/to/upload/directory';
$allowedFileTypes = ['pdf', 'doc', 'docx'];

// Maximum file size in bytes (e.g., 5MB)
$maxFileSize = 5 * 1024 * 1024;

// Database connection
try {

    $db = new PDO("mysql:host={$databaseHost};dbname={$databaseName}", $databaseUser, $databasePassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

?>