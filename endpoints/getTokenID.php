<?php
include_once "model/connectDatabase.php";



function getStudentIdByToken($tokenst) {
    try {
        // Connect to the database
        $pdo = getDatabaseConnection();
        // Prepare the SQL query to retrieve the student ID
        $query = 'SELECT students.id FROM students INNER JOIN users ON students.user_id = users.id WHERE users.token = :token';
        $statement = $pdo->prepare($query);
        // Bind the token parameter
        $statement->bindParam(':token', $tokenst);
        // Execute the query
        $statement->execute();
        // Fetch the student ID
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        // Check if a row was found
        if ($result) {
            // Return the student ID
            return $result['id'];
        } else {
            // Return null if no row was found
            echo json_encode(['error' => 'Token not found. Please try again.']);
            exit(1);
            return null;
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit(1);
    }


}

