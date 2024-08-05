<?php

// solve-question.php

// Handle solve question request
// function handleSolveQuestionRequest($requestMethod)
// {
//     // Check the request method
//     if ($requestMethod === 'POST') {
//         // Process the POST request to solve a question

//         // Retrieve and process request data
//         $questionId = $_POST['question_id'];
//         $solution = $_POST['solution'];

//         // Perform the solving logic and store the solution

//         // Assuming the solution is successfully stored
//         $response = [
//             'success' => true,
//             'message' => 'Question solved successfully',
//         ];
//         echo json_encode($response);
//     } else {
//         // Invalid request method
//         http_response_code(405);
//         echo json_encode(['error' => 'Invalid request method']);
//     }
// }



require_once 'model/connectDatabase.php';

function handleSolveQuestionRequest($requestMethod)
{
    // Check the request method
    if ($requestMethod === 'POST') {
        // Process the POST request to solve a question
        // Retrieve and process request data
        $questionId = $_POST['question_id'];
        $solutionText = $_POST['solution_text'];
        $teacherId = $_POST['id_teacher'];
        $providedToken = $_POST['token'];
        // Call the function to save the solution
        $teacherId = getTeacherIdByToken($providedToken);
        if ($teacherId !== null) {
            // Teacher ID found
             // Get the database connection
        $pdo = getDatabaseConnection();
        // Perform the solving logic and store the solution
        $stmt = $pdo->prepare("INSERT INTO solve_questions (question_id, solution_text, solution_time, id_teacher) VALUES (:questionId, :solutionText, NOW(), :teacherId)");
        $stmt->bindParam(':questionId', $questionId);
        $stmt->bindParam(':solutionText', $solutionText);
        $stmt->bindParam(':teacherId', $teacherId);
        // Execute the statement and check for success
        if ($stmt->execute()) {
            // Retrieve the question and solution to display
            $stmt = $pdo->prepare("SELECT q.question, s.solution_text FROM questions q JOIN solution s ON q.id = s.question_id WHERE q.id = :questionId");
            $stmt->bindParam(':questionId', $questionId);
            $stmt->execute();
            $questionSolutionData = $stmt->fetch(PDO::FETCH_ASSOC);

            // Assuming the solution is successfully stored and retrieved
            $response = [
                'success' => true,
                'message' => 'Question solved successfully',
                'question' => $questionSolutionData['question'],
                'solution' => $questionSolutionData['solution_text']
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Error adding solution.'
            ];
        }
        echo json_encode($response);
        } else {
            // Token does not exist or teacher ID not found
            echo json_encode(['error' => 'Invalid token or teacher ID not found.']);
            exit; 

        }
       
    } else {
        // Invalid request method
        http_response_code(405);
        echo json_encode(['error' => 'Invalid request method']);
    }
}


?>
