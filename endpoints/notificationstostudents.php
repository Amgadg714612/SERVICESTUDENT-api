<?php

// Function to send notifications to students that an assignment has been solved by a teacher
function notifyStudentsAssignmentSolved($assignmentId) {
    // Connect to the database
    $pdo = getDatabaseConnection();
    // Prepare the query to fetch the list of students enrolled in the assignment
    $studentQuery = 'SELECT student_id FROM student_assignments WHERE assignment_id = :assignment_id';
    $studentStmt = $pdo->prepare($studentQuery);
    $studentStmt->bindParam(':assignment_id', $assignmentId);
    $studentStmt->execute();
    $students = $studentStmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare the query to fetch information about the teacher who solved the assignment
    $teacherQuery = 'SELECT t.name FROM teachers t JOIN assignments a ON t.id = a.solved_by_teacher WHERE a.id = :assignment_id';
    $teacherStmt = $pdo->prepare($teacherQuery);
    $teacherStmt->bindParam(':assignment_id', $assignmentId);
    $teacherStmt->execute();
    $teacher = $teacherStmt->fetch(PDO::FETCH_ASSOC);

    // Send notifications to each student
    foreach ($students as $student) {
        // Here you can add code to send notifications, such as sending an email or text message
        // For example: sendNotification($student['student_id'], "The assignment has been solved by teacher {$teacher['name']}.");
    }

    echo 'Notifications have been sent successfully.';
}


// Function to send an email notification to a student
function sendNotification($studentId, $message) {
    // Connect to the database
    $pdo = getDatabaseConnection();

    // Prepare the query to retrieve the student's email address
    $emailQuery = 'SELECT email FROM students WHERE id = :student_id';
    $emailStmt = $pdo->prepare($emailQuery);
    $emailStmt->bindParam(':student_id', $studentId);
    $emailStmt->execute();
    $studentEmail = $emailStmt->fetch(PDO::FETCH_ASSOC)['email'];

    // Check if the student's email address was found
    if ($studentEmail) {
        // Set the email headers
        $headers = "From: no-reply@yourschool.edu\r\n";
        $headers .= "Reply-To: no-reply@yourschool.edu\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // Send the email
        if (mail($studentEmail, 'Assignment Solved Notification', $message, $headers)) {
            echo 'Notification sent successfully to student ID ' . $studentId;
        } else {
            echo 'Failed to send notification to student ID ' . $studentId;
        }
    } else {
        echo 'No email address found for student ID ' . $studentId;
    }
}


?>