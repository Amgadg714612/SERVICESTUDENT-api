
<?php
include_once 'model/getStudentidByToken.php';



function handleAssignmentsRequest($requestMethod  )
{   
    // Check the request method
    if ($requestMethod === 'POST') {
      if(isset($_POST['token']))  {
            $token=$_POST['token'];
    $userId=getStudentIdByToken($token);

    $assignments=handleAssignmentsRequestuser($requestMethod , $userId );

        echo json_encode($assignments);
    
    }
        // Return the assignments as a JSON response
    } else {
        // Invalid request method
        http_response_code(405);
        echo json_encode(['error' => 'Invalid request method']);
    }


}


function handleAssignmentsRequestuser($requestMethod , $userId )
{   //AssignmentsUser endpoint
    // Check the request method
    if ($requestMethod === 'POST') {
        // Process the GET request for assignments
        // Retrieve and process assignments data
        $pdo = getDatabaseConnection(); // استدعاء الدالة للحصول على اتصال بقاعدة البيانات
        $query = "SELECT * FROM assignments WHERE student_id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $completedAssignments = [];
        $incompleteAssignments = [];
        foreach ($assignments as $assignment) {
            if ($assignment['completed']) {
                $completedAssignments[] = $assignment;
            } else {

                $incompleteAssignments[] = $assignment;
            }
        }
        // Return the assignments as a JSON response
        echo json_encode([
            'completedAssignments' => $completedAssignments,
            'incompleteAssignments' => $incompleteAssignments
        ]);
        // Return the assignments as a JSON response
        echo json_encode($assignments);
    } else {
        // Invalid request method
        http_response_code(405);
        echo json_encode(['error' => 'Invalid request method']);
    }


}
