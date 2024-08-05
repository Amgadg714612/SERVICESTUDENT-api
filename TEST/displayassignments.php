<!-- 
<?php

// require_once 'model/connectDatabase.php';


// // Database connection
// $pdo = getDatabaseConnection() ;

// // Check user type (student or teacher)

// $userType = $_GET['userType']; // student or teacher
// $userId = $_GET['userId']; // Student or teacher ID
// if ($userType == '0') {
//     // Display assignments for the student
//     $stmt = $pdo->prepare("SELECT * FROM assignments WHERE student_id = :userId");
//     $stmt->execute(['userId' => $userId]);
//     $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     // Send data as JSON
//     echo json_encode($assignments);
// } elseif ($userType == '1') {
//     // Display assignments for the teacher
//     $specialization = $_GET['specialization']; // Teacher's specialization
//     $stmt = $pdo->prepare("SELECT * FROM assignments WHERE specialization = :specialization");
//     $stmt->execute(['specialization' => $specialization]);
//     $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     // Send data as JSON
//     echo json_encode($assignments);
// } else {
//     echo 'Invalid user type';
// }
?> -->
