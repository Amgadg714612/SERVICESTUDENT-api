<?php



// Function to register solved assignments in the database
function registerSolvedAssignment1($descSolve, $filePathSolve, $assignmentId) {
    // Connect to the database
    $pdo = getDatabaseConnection();

    // Prepare the query to insert the solved assignment data
    $query = 'INSERT INTO solved_assignments (Desc_Solve, File_path_solve, id_assignment) VALUES (:desc_solve, :file_path_solve, :id_assignment)';
    $stmt = $pdo->prepare($query);

    // Bind the parameters with the corresponding values
    $stmt->bindParam(':desc_solve', $descSolve);
    $stmt->bindParam(':file_path_solve', $filePathSolve);
    $stmt->bindParam(':id_assignment', $assignmentId);
    // Execute the query
    if ($stmt->execute()) {
        echo 'The solved assignment has been successfully registered.';
    } else {
        echo 'An error occurred while registering the solved assignment. Please try again.';
    }
}

// Function to register solved assignments in the database


// Function to register solved assignments in the database and return the result as JSON
function registerSolvedAssignment($descSolve, $filePathSolve, $assignmentId) {
    // Connect to the database
    $pdo = getDatabaseConnection();
    // Prepare the query to insert the solved assignment data
    $query = 'INSERT INTO solved_assignments (Desc_Solve, File_path_solve, id_assignment) VALUES (:desc_solve, :file_path_solve, :id_assignment)';
    $stmt = $pdo->prepare($query);
        // Bind the parameters with the corresponding values
    $stmt->bindParam(':desc_solve', $descSolve);
    $stmt->bindParam(':file_path_solve', $filePathSolve);
    $stmt->bindParam(':id_assignment', $assignmentId);
    // Execute the query and return the result as JSON
    if ($stmt->execute()) {
        // Create an array for the result
        $result = [
            'status' => 'success',
            'message' => 'The solved assignment has been successfully registered.',
            'data' => [
                'Desc_Solve' => $descSolve,
                'File_path_solve' => $filePathSolve,
                'id_assignment' => $assignmentId
            ]
        ];
    } else {
        // Create an array for the error
        $result = [
            'status' => 'error',
            'message' => 'An error occurred while registering the solved assignment. Please try again.'
        ];
    }

    // Return the result as JSON
    header('Content-Type: application/json');
    echo json_encode($result);
}






?>