<?php


// Function to display all solved questions along with information about the teacher who solved each question
function displaySolvedQuestions() {
    // Connect to the database
    $pdo = getDatabaseConnection();

    // Prepare the SQL query to retrieve solved questions and teacher information
    $query = 'SELECT q.question_text, q.descrpation, t.dept_specialization, t.id_user 
              FROM questions q
              JOIN teachers t  ON q.Idteacher = t.id_user
              WHERE q.is_solved = 1';
    $statement = $pdo->prepare($query);

    // Execute the query
    $statement->execute();

    // Fetch the results
    $solvedQuestions = $statement->fetchAll(PDO::FETCH_ASSOC);
    // Display the results
    if ($solvedQuestions) {
        echo json_encode($solvedQuestions);
    } else {
        echo json_encode(['message' => 'No solved questions found.']);
    }
}




?>