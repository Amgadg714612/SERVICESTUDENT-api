<?php 

require_once 'connectDatabase.php'; 
// Function to validate user credentials
function validateUserCredentials($username, $password) {
    try {
        // Create a database connection
        $pdo = getDatabaseConnection();
      // Prepare and execute a query to check user credentials
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username' );
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && password_verify($password, $result['password'])) {
            // Authentication successful
            $typeaccount= authenticateUser($result['typeaccount']);
            return $typeaccount; // Return the user's role (e.g., 'student', 'teacher', 'admin')
        } else {
            
            // Authentication failed
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        // Log or display an error message
        return false;
    }
}

function authenticateUser($typeaccount) {
    // Replace these with actual checks against user credentials in your database
    if ($typeaccount== 0) {
        // Authentication successful for student
        $_SESSION['user_role'] = '0';
        return 'student';
    } elseif ($typeaccount== 1) {
        // Authentication successful for teacher
        $_SESSION['user_role'] = '1';
        return 'teacher';
    } elseif ($typeaccount== 2) {
        // Authentication successful for administrator
        $_SESSION['user_role'] = '2';
        return 'admin';
    } else {
        // Authentication failed
        return false;
    }
}
?>