<?php
// solutions.php
include_once "model/connectDatabase.php";
include_once "token_ver.php";


// Function to save solution data to the database
function saveSolution($quation_id, $teacher_id, $solution_text, $solution_date) {
    // Get the database connection
    $pdo = getDatabaseConnection();
    // Prepare the SQL INSERT statement
    $stmt = $pdo->prepare("INSERT INTO solutions (quation_id, teacher_id, solution_text, solution_date) VALUES (:quation_id, :teacher_id, :solution_text, :solution_date)");    
    // Bind the parameters
    $stmt->bindParam(':quation_id', $quation_id);
    $stmt->bindParam(':teacher_id', $teacher_id);
    $stmt->bindParam(':solution_text', $solution_text);
    $stmt->bindParam(':solution_date', $solution_date);
    // Execute the statement and check for success
    if ($stmt->execute()) {
        return "Solution saved successfully.";
    } else {
        return "Error saving solution.";
    }
}








// Handle solutions request
function handleSolutionsRequest($requestMethod)
{
    // Check the request method
    if ($requestMethod === 'POST') {
        // Process the POST request to save a new solution
        $quation_id = $_POST['quation_id'];
        $solution_text = $_POST['solution_text'];
        $solution_date = $_POST['solution_date'];
        $providedToken = $_POST['token'];
        // Call the function to save the solution
        $teacherId = getTeacherIdByToken($providedToken);
        if ($teacherId !== null) {
            // Teacher ID found
            $result = saveSolution($quation_id, $teacherId, $solution_text, $solution_date);
            echo json_encode($result);

        } else {
            // Token does not exist or teacher ID not found
            echo json_encode(['error' => 'Invalid token or teacher ID not found.']);
            exit; 

        }
    } elseif ($requestMethod === 'GET') {
        // Process the GET request for solutions
        // Retrieve and process solutions data
        echo json_encode(['error' => 'Invalid request method']);
 
        exit;
        // ... Existing GET request code ...
    } else {
        // Invalid request method
        http_response_code(405);
        echo json_encode(['error' => 'Invalid request method']);
    }
}


?>