<?php
// Include your database connection script
require_once 'model/connectDatabase.php';
require_once 'model/getStudentidByToken.php';
// Function to add a question to the database
function addQuestion($student_id, $question_text,$descrpation) {
    // Get the database connection
    $pdo = getDatabaseConnection();
    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO questions (id_student, question_text  ,descrpation) VALUES (:student_id, :question_text,:descrpation)");
    // Bind the parameters
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':question_text', $question_text);
    $stmt->bindParam(':descrpation', $descrpation);
    // Execute the statement and check for success
    if ($stmt->execute()) {
        return "Question added successfully.";
    } else {
        return "Error adding question.";
    }
}

function handleaddQuestion($REQUEST_METHOD) {
    // Check if the request is a POST request
    if ($REQUEST_METHOD=== 'POST') {
        // Validate the token
        if(isset($_POST['token']) && isset($_POST['question_text'])&& isset($_POST['descrpation'])){
            $token=$_POST['token'];
            $student_id=getStudentIdByToken($token);
            $question_text=$_POST['question_text'];
            $descrpation= $_POST['descrpation'];
            // Retrieve data from POST request
            $results = addQuestion($student_id, $question_text,$descrpation);
            // Return the results in JSON format
            echo json_encode(['Massage' =>$results]);
        }
       else{
        echo json_encode(['error' => 'Invalid request all viled.']);

       }
    } else {
        // If not a POST request, return an error
        echo json_encode(['error' => 'Invalid request method.']);
    }
}





?>
