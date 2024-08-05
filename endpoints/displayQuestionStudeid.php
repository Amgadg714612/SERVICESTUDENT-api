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

 function getSolutionWithTeacherDetails($question_id) {
          // Assume you have an active database connection
          global $pdo;
      
          // Prepare the query to retrieve solution details and teacher information
          $sql = "SELECT sq.solution_text, sq.solution_time, t.dept_specialization, t.Phone_Number, u.username 
                  FROM solve_questions sq
                  JOIN teachers t ON sq.id_teacher = t.id
                  JOIN users u ON t.id_user = u.id
                  WHERE sq.question_id = :question_id";
      
          // Prepare the statement
          $stmt = $pdo->prepare($sql);
          
          // Execute the query with parameter binding
          $stmt->execute(['question_id' => $question_id]);
          
          // Fetch the results
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
          // Check if there are any results
          if ($results) {
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($results as $row) {
                 
                  // Print solution details and teacher information
                  echo "Solution Text: " . $row['solution_text'] . "\n";
                  echo "Solution Time: " . $row['solution_time'] . "\n";
                  echo "Department Specialization: " . $row['dept_specialization'] . "\n";
                  echo "Phone Number: " . $row['Phone_Number'] . "\n";
                  echo "Teacher's Username: " . $row['username'] . "\n";
              }
          } else {
              echo "No solution found for this question.";
          }
      }
      



 function displayQustion(){
// Check user type (student or teacher)
// Student or teacher ID
$userType = $_POST['userType'];

if (!empty($_POST['token']) && !empty($_POST['userType']))
{
if ($userType == 'student') {
        $providedToken = $_POST['token'];
        if (!empty($providedToken)){
       $id=gettokenwithid($providedToken);
       // $id= getStudentIdByToken($providedToken);
       // Display assignments for the student
       // Database connection
       $pdo = getDatabaseConnection() ;
        $stmt = $pdo->prepare("SELECT * FROM questions WHERE student_id = :userId");
        $stmt->execute(['userId' => $id]);
        $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Send data as JSON
        if ($assignments) {
          $data_all=$assignments;
          $i = 0; 

          foreach ($assignments as $row) {
      
          if( $row['is_solved'] ) {
                  
                  $data=  getSolutionWithTeacherDetails($row['id ']);   
         
                  $data_all[$i]['is_solved'] = $data;

          }
          $i++;
    }
    echo json_encode(['message' => $data_all]);
 }
 else {
          echo json_encode(['message' => ' not Quation  ']);

 }
}
        else
        {
            echo json_encode(['message'=>'Please ensure all required data is entered  _token.'] );
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
     $stmt = $pdo->prepare("SELECT q.*, t.dept_specialization AS teacher_specialization, u.dept AS student_specialization
     FROM questions q
     JOIN students s ON q.id_student = s.id
     JOIN users u ON s.user_id = u.id
     JOIN teachers t ON q.Idteacher = t.id
     WHERE t.dept_specialization =:specialization ;
     ");
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


