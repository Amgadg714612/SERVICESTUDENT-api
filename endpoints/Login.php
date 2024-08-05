<?php


// login.php
require_once 'model/loginData.php';
require_once 'model/getIDuser.php';
require_once 'model/connectDatabase.php';

function generateToken($username) {
    // Generate a unique token (you can use any method you prefer)
    $token = bin2hex(random_bytes(32)); // Generate a random 64-character hexadecimal string
    // Store the token in the session or database (based on your application's requirements)
    $_SESSION['user_token'] = $token;
    $dbConnection =getDatabaseConnection() ;
    
    $stmt = $dbConnection->prepare('UPDATE users SET token = :token WHERE username = :username');
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':username', $username);
    $stmt->execute();


    // Return the token
    
    // Return the token
    return $token;
}



function handleLoginRequest($requestMethod) {
    // Check if the request method is POST
    if ($requestMethod === 'POST') {
        // Retrieve the username and password from the request body
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (!empty($username) && !empty($password)) {
          // Validate the username and password
        $userRole = validateUserCredentials($username, $password);
        if ($userRole) {
            // Authentication successful
            $token= generateToken($username);
            // Generate and return the token
            
            echo $userRole;
                // If the user is an admin, add the token to the admin table
                if ($userRole == 'admin') {
                    addToAdminTable($username, $token);
                }
                
                // Prepare the response
                $response = [
                    'success' => true,
                    'message' => 'Login successful for ' . $userRole,
                    'redirect' => 'create-assignment-' . $userRole . '.php',
                    'token' => $token,
                ];
                         
            echo json_encode($response);
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['userId']=get_IDuser($username);
            // echo $_SESSION['userId'];
             // Redirect to assignments after 60 seconds
           // header('Location: assignments ,Refresh:50 ');
           return $username;
            exit;
        } else {
            // Authentication failed
            $response = [
                'success' => false,
                'message' => 'Invalid username or password 1',
            ];
            echo json_encode($response);
            $_SESSION['error'] = 'Invalid username or password ';
            return null;
        }
    
    
    }
    else 
    {
        
        $response=  [
            'success'=>false,
             'message'  =>  'Invalid username or password' 
            ];
            echo json_encode($response);
                return null;
    
        }
    
    }

    else {
        // Invalid request method
        http_response_code(405);
        echo json_encode(['error' => 'Invalid request method']);
   
   return null;
    }}




    function addToAdminTable($username, $token) {
        // Get the database connection
        $pdo = getDatabaseConnection();
        // Prepare the SQL query to update the admin's token
        $updateQuery = "UPDATE admin SET TokenAdmin = :token WHERE username = :username";
        // Prepare the statement
        $updateStatement = $pdo->prepare($updateQuery);
        // Bind the parameters
        $updateStatement->bindParam(':username', $username);
        $updateStatement->bindParam(':token', $token);
        // Execute the query to update the token

        $updateStatement->execute();
        // Check if the update was successful
        if ($updateStatement->rowCount() > 0) {
            return true; // Token updated successfully
        } else {
            return false; // Update failed
        }
    }
    