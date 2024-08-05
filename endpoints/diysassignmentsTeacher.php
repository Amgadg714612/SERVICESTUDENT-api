<?php
// assignments.php
// Display available assignments to the teacher based on their specialty
include_once "model/connectDatabase.php";
include_once "token_ver.php";



function displayAssignmentsForTeacher($teacherSpecialty) {
    // Connect to the database
    $pdo = getDatabaseConnection();
    // Prepare the SQL query to select assignments based on the teacher's specialty
    $query = 'SELECT * FROM assignments WHERE specialty = :specialty';
    $statement = $pdo->prepare($query);
    // Bind the specialty parameter
    $statement->bindParam(':specialty', $teacherSpecialty);
    // Execute the query
    $statement->execute();
    // Fetch all the assignments
    $assignments = $statement->fetchAll(PDO::FETCH_ASSOC);
    // Check if assignments are found
    if ($assignments) {
        // Return the assignments as a JSON object
        echo json_encode($assignments);
    } else {
        // No assignments found for the specialty
        echo json_encode(['message' => 'No assignments available for this specialty.']);
    }
}




?>