<?php

require_once 'model/connectDatabase.php';
require_once 'token_ver.php';
// require_once 'getTokenID.php';

 function gettokenwithid($tokenst){
      // Connect to the database
      $pdo = getDatabaseConnection();
      // Prepare the SQL query to retrieve the student ID
      $query = 'SELECT students.id FROM students INNER JOIN users ON students.user_id = users.id WHERE users.token = :token';
      $statement = $pdo->prepare($query);
      // Bind the token parameter
      $statement->bindParam(':token', $tokenst);
      // Execute the query
      $statement->execute();
      // Fetch the student ID
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      // Check if a row was found
      if ($result) {
        
          // Return the student ID
          return $result['id'];
      } else {
          // Return null if no row was found
          echo json_encode(['error' => 'Token not found. Please try again.']);
          return null;
      }
 }



 function displayassiggnments(){
// Check user type (student or teacher)
// Student or teacher ID
$userType = $_POST['userType'];

if (!empty($userType))
{
if ($userType == 'student') {
        $providedToken = $_POST['token'];
        if (!empty($providedToken)){
       $id=gettokenwithid($providedToken);
       // $id= getStudentIdByToken($providedToken);
       // Display assignments for the student
       // Database connection
       $pdo = getDatabaseConnection() ;
        $stmt = $pdo->prepare("SELECT * FROM assignments WHERE student_id = :userId");
        $stmt->execute(['userId' => $id]);
        $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Send data as JSON

        echo json_encode($assignments);
        }
        else
        {
            echo json_encode( "Please ensure all required data is entered  _token." );
        }
       
    } elseif ($userType == 'teacher') {
    
        $providedToken = $_POST['token'];
        if (isset($providedToken) && !empty($providedToken)){ 
        $id_teacter=getTeacherIdByToken($providedToken);
        if($id_teacter)
    // Display assignments for the teacher
          $specialization = getTeacherSpecialization($id_teacter); 
      $pdo = getDatabaseConnection() ;
      // Teacher's specialization
     $stmt = $pdo->prepare("SELECT * FROM assignments WHERE specialization = :specialization and completed == 0");
     $stmt->execute(['specialization' => $specialization]);
     $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
     // Send data as JSON
     echo json_encode($assignments);
      
    }
      
    } 
    else {

        echo json_encode('Invalid user type ');
    }

    
} 
else {
    echo json_encode('type not fiend');


}



 }
 function isAssignmentSolved($assignmentId) {
    // Get the database connection
    $pdo = getDatabaseConnection();

    // Prepare the SQL SELECT statement
    $stmt = $pdo->prepare("SELECT completed FROM assignments WHERE id = :assignmentId");
    // Bind the assignment ID parameter
    $stmt->bindParam(':assignmentId', $assignmentId);
    // Execute the query
    $stmt->execute();
    
    // Fetch the result
    $result = $stmt->fetchColumn();
    if($result['id']!=0){
        return true;

    }
    else{
                return false;

    }
    // Return true if solutions exist (assignment is solved), otherwise false
}


function getTeacherSpecialization($id_teacher) {
    // Get the database connection
    $pdo = getDatabaseConnection();

    // Prepare the SQL SELECT statement
    $stmt = $pdo->prepare("SELECT dept_specialization FROM teachers WHERE id_teacher = :id_teacher");
    
    // Bind the teacher ID parameter
    $stmt->bindParam(':id_teacher', $id_teacher);
    
    // Execute the query
    $stmt->execute();
    
    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Return the specialization if found, otherwise return null
    return $result ? $result['dept_specialization'] : null;
}


?>


