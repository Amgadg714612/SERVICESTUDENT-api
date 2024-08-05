<?php
// assignments.php

// Include the necessary files and configurations
require_once '../config.php';
require_once '../endpoints/model/connectDatabase.php';
// Start the session to ensure the user is logged in as a student
// Addassignment($_SERVER['REQUEST_METHOD']);

// function Addassignment($requestMethod){
//     session_start();
// // Check if the user is logged in and has the role of a student
// //if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === '0') {
//     // Handle assignments request
    
//         // Check the request method
//         if ($requestMethod === 'POST') {
//             // Check if a file has been uploaded
//             if (isset($_FILES['assignment_file']) &&  isset($_POST['assignmentName']) &&  isset($_POST['deadlinedate'])) {
//                 // Retrieve file details
//                 $assignmentName =$_POST['assignmentName'];
//                 $deadlinedate =$_POST['deadlinedate'];
//                 $fileTmpPath = $_FILES['assignment_file']['tmp_name'];
//                 $fileName = $_FILES['assignment_file']['name'];
//                 $fileSize = $_FILES['assignment_file']['size'];
//                 $fileType = $_FILES['assignment_file']['type'];
//                 $fileNameCmps = explode(".", $fileName);
//                 $fileExtension = strtolower(end($fileNameCmps));
//                 // Define allowed file types
//                 $allowedfileExtensions = ['txt', 'doc', 'docx', 'pdf', 'zip','jpg'];
//                 // Check if the file extension is allowed
//                 if (in_array($fileExtension, $allowedfileExtensions)) {
//                     // Directory where uploaded files will be saved
//                     $uploadFileDir = './uploaded_files/';
//                     // Create the upload directory if it doesn't exist
//                     if (!is_dir($uploadFileDir)) {
//                         mkdir($uploadFileDir, 0755, true);
//                     }
//                     // Path where the file will be saved
//                     $dest_path = $uploadFileDir . $fileName;
//                     // Move the file from the temporary directory to the destination path
//                     if (move_uploaded_file($fileTmpPath, $dest_path)) {
//                         // File upload was successful
//                         // Connect to the database
//                        // $student_id= $_SESSION['user_id'];
//                        $student_id= '1';
//                         $pdo = getDatabaseConnection();
//                         // Prepare the SQL query to insert the assignment data into the database
//                         $insertQuery = 'INSERT INTO assignments (student_id,assignment_name,deadlinedate,file_path) VALUES (:student_id,:assignment_name, :deadlinedate, :file_path)';
//                         $insertStatement = $pdo->prepare($insertQuery);
//                         // Bind the parameters
//                        // $insertStatement->bindParam(':student_id', $_SESSION['user_id']);
//                           $insertStatement->bindParam(':student_id',$student_id);
//                          // Assuming the student's ID is stored in the session
//                          $insertStatement->bindParam(':assignment_name', $assignmentName); 
//                          $insertStatement->bindParam(':deadlinedate', $deadlinedate); 
//                          // Bind the deadline date
//                         $insertStatement->bindParam(':file_path', $dest_path);
//                         // Execute the query to insert the assignment data
//                         $insertStatement->execute();
                        
//                         echo json_encode(['message' => 'Assignment uploaded and saved successfully']);
//                     } else {
//                         // Handle error during file upload
//                         echo json_encode(['error' => 'There was an error uploading your assignment. Please try again.']);
//                     }
//                 } else {
//                     // Handle invalid file type
//                     echo json_encode(['error' => 'Upload failed. Allowed file types: ' . implode(', ', $allowedfileExtensions)]);
//                 }
//             } else {
//                 // Handle no file uploaded
//                 echo json_encode(['error' => 'No file uploaded. Please upload an assignment.']);
//             }
//         } else {
//             // Invalid request method
//             echo json_encode(['error' => 'Invalid request method. Only POST is allowed']);
//         }
    
// // } else {
// //     // User is not logged in as a student
// //     echo json_encode(['error' => 'Unauthorized access. You must be logged in as a student.']);
// // }


// }

?>


