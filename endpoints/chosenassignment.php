


<?php





// Receiving data related to the assignment chosen by the teacher for monetized solving
function solveAssignmentForTeacher($assignmentId, $teacherId, $price) {
    // Connect to the database
    $pdo = getDatabaseConnection();
    // Prepare the SQL query to update the assignment status and record the teacher and price
    $query = 'UPDATE assignments SET solved_by_teacher = :teacher_id, price = :price WHERE assignment_id = :assignment_id';
    $statement = $pdo->prepare($query);
    // Bind the teacher ID, price, and assignment ID
    $statement->bindParam(':teacher_id', $teacherId);
    $statement->bindParam(':price', $price);
    $statement->bindParam(':assignment_id', $assignmentId);

    // Execute the query
    if ($statement->execute()) {
        echo json_encode(['message' => 'Assignment solved successfully by the teacher.']);
    } else {
        echo json_encode(['error' => 'Error solving the assignment. Please try again.']);
    }
}

// Function to register assignments chosen by the teacher for monetized solving
function registerSolvedAssignment($teacherId, $assignmentId, $description, $price) {
    // Connect to the database
    $pdo = getDatabaseConnection();
    // Prepare the SQL query to insert data into the pricesolveassignment table
    $query = 'INSERT INTO pricesolveassignment (id_teacher, id_assignmint, descrip_text, price) VALUES (:teacher_id, :assignment_id, :description, :price)';
    $statement = $pdo->prepare($query);

    // Bind the parameters
    $statement->bindParam(':teacher_id', $teacherId);
    $statement->bindParam(':assignment_id', $assignmentId);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':price', $price);

    // Execute the query
    if ($statement->execute()) {
        // Query executed successfully
        echo json_encode(['message' => 'The assignment has been successfully registered for solving.']);
    } else {
        // Error occurred during query execution
        echo json_encode(['error' => 'There was an error registering the assignment for solving. Please try again.']);
    }
}





?>