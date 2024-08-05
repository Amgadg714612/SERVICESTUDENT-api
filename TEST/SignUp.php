<?php
// signup.php

// Include the necessary files and configurations
require_once '../endpoints/model/connectDatabase.php';


function  handleSignUpRequest($requestMethod)
{
// Handle the incoming request
if ($requestMethod === 'POST') {
//     // Access the request body to get the signup data

$username=$_POST['username'];
$password=$_POST['password'];
$email =$_POST['email'];
$dept=$_POST['dept'];
$typeaccount = '0';
$mobile=$_POST['mobile'];



// Perform validation on the signup data
    // You can add your own validation logic here
    if (empty($username) || empty($password) || empty($email) || empty($dept) || empty($mobile)){
        // Return an error response if any field is missing\

        http_response_code(400);
        echo json_encode(['error' => 'All fields are required 1']);
        
        exit;
    }
    // Check if the user already exists in the database
    // You can implement your own logic here to check for existing users
    // For example, you can query the database to see if a user with the same username or email already exists
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
    // Check if the count is greater than 0, indicating the user already exists
    if ($count > 0) {
        // Return an error response
        http_response_code(409);
        echo json_encode(['error' => 'User already exists']);
        exit;
    }
    

    // Assuming the user does not exist, you can proceed with creating the user account
    // Add your own logic here to store the user data in the database or perform any other necessary actions
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
// Prepare the SQL query to insert the user data into the database
$insertQuery = 'INSERT INTO users (username, password, email, typeaccount, dept, mobile) VALUES (:username, :password, :email, :typeaccount, :dept, :mobile)';
// Prepare the statementذ
$insertStatement = $pdo->prepare($insertQuery);
// Bind the parameters
 // Prepare the statement
 $insertStatement = $pdo->prepare($insertQuery);
 // Bind the parameters
 $insertStatement->bindParam(':username', $username);
 $insertStatement->bindParam(':password', $hashedPassword); // Hash the password before storing it
 $insertStatement->bindParam(':email', $email);
 $insertStatement->bindParam(':typeaccount', $typeaccount);
 $insertStatement->bindParam(':dept', $dept);
 $insertStatement->bindParam(':mobile', $mobile);
 // Execute the query to insert the user data
 $insertStatement->execute();
    // Return a success response
    http_response_code(200);
    echo json_encode(['message' => 'SignUp successful']);
} else {
    // Invalid method for the signup endpoint
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}

}
handleSignUpRequest('POST');