<?php
// signup.php

// Include the necessary files and configurations
require_once 'config.php';
require_once 'model/connectDatabase.php';
// require_once 'vendor/autoload.php'; 
// signup.php
// Include the necessary files and configurations


// Function to check if the user already exists in the database
function checkUserExists($username, $email) {
    $pdo = getDatabaseConnection();
    // Prepare the SQL query to check for existing user
    $query = 'SELECT COUNT(*) FROM users WHERE username = :username OR email = :email';
    // Prepare the statement
    $statement = $pdo->prepare($query);
    // Bind the parameters
    $statement->bindParam(':username', $username);
    $statement->bindParam(':email', $email);
    // Execute the query
    $statement->execute();
    // Fetch the count of matching rows
    $count = $statement->fetchColumn();
    return $count > 0;
}

// Function to handle the sign-up request

function handleSignUpRequest($requestMethod) {
    if ($requestMethod === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $dept = $_POST['dept'];
        $typeaccount = '0';
        $mobile = $_POST['mobile'];
        // Perform validation on the signup data
        if (empty($username) || empty($password) || empty($email) || empty($dept) || empty($mobile)) {
            http_response_code(400);
            echo json_encode(['error' => 'All fields are required']);
            exit;
        }

        // Check if the user already exists
        if (checkUserExists($username, $email)) {
            http_response_code(409);
            echo json_encode(['error' => 'User already exists']);
            exit;
        }

        // Proceed with creating the user account
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Prepare the SQL query to insert the user data into the database
        $insertQuery = 'INSERT INTO users (username, password, email, typeaccount, dept, mobile) VALUES (:username, :password, :email, :typeaccount, :dept, :mobile)';
        // Prepare the statement
         // Prepare the statement
        $pdo = getDatabaseConnection();
        $insertStatement = $pdo->prepare($insertQuery);
        // Bind the parameters
        $insertStatement->bindParam(':username', $username);
        $insertStatement->bindParam(':password', $hashedPassword);
       $insertStatement->bindParam(':email', $email);
        $insertStatement->bindParam(':typeaccount', $typeaccount);
        $insertStatement->bindParam(':dept', $dept);
        $insertStatement->bindParam(':mobile', $mobile);
        // Execute the query to insert the user data
        $insertStatement->execute();
        // Get the newly inserted user's ID
       $userId = $pdo->lastInsertId();

        // Check if the account type is a student
        if ($typeaccount === '0') {
                // Prepare an SQL query to insert student data into the 'students' table
                $insertStudentQuery = 'INSERT INTO students (user_id) VALUES (:user_id)';
                // Prepare the statement
                $insertStudentStatement = $pdo->prepare($insertStudentQuery);
                // Bind the parameters
                $insertStudentStatement->bindParam(':user_id', $userId);
                // Execute the query to insert student data
                try {
                    // Your existing code to insert data
                    $insertStudentStatement->execute();
                    // Rest of your code
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        // Handle the specific duplicate entry error
                        echo json_encode(['error' => 'Duplicate entry for primary key']);
                    } else {
                        // Handle other PDO exceptions
                        echo json_encode(['error' => $e->getMessage()]);
                    }
                    exit;
                }
        }

// Return a success response
http_response_code(200);
echo json_encode(['message' => 'SignUp successful']);
        // Return a success response
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Invalid request method']);
    }
}





?>


