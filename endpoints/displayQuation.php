<?php
//Cloud Messaging to find your server key.
//772484998385 
//BOgj7DetaGHzWq_smrsgCkbYfHUWoWfurxLBEpu8xHpfcnZvPlpA0xoWtzcybD-EnuTMVQ1KwaGPldExYI6m3OQ

// Include your database connection details
require_once 'db_config.php';
require_once 'model/connectDatabase.php';

// require_once '../vendor/autoload.php';

// use Kreait\Firebase\Factory;
// use Kreait\Firebase\Messaging\CloudMessage;
// use Kreait\Firebase\Messaging\Notification;

// Function to get all unsolved questions for a teacher's specialization
function getUnsolvedQuestions($teacherId) {
          $db = getDatabaseConnection();
          $stmt = $db->prepare("SELECT q.* FROM questions q
                                JOIN teacher t ON q.dept_specialization = t.dept_specialization
                                WHERE q.is_solved = 0 AND t.Idteacher = ?");
          $stmt->execute([$teacherId]);

          return $stmt->fetchAll(PDO::FETCH_ASSOC);

      }

// Function to reserve a question for solving

// Function to reserve a question for solving
function reserveQuestion($teacherId, $questionId) {
    $db = getDatabaseConnection();
    $db->beginTransaction();
    try {
        $stmt = $db->prepare("UPDATE questions SET Idteacher = ?, is_solved = 2 WHERE id = ? AND is_solved = 0");
        $stmt->execute([$teacherId, $questionId]);
        if ($stmt->rowCount() === 0) {
            throw new Exception('Question could not be reserved.');
        }
        $db->commit();
        return ['success' => true, 'message' => 'Question reserved.', 'solveTimeLimit' => 60];
    } catch (Exception $e) {
        $db->rollBack();
        return ['success' => false, 'message' => $e->getMessage()];
    }
}
// Function to mark a question as solved and notify the student
function solveQuestion($teacherId, $questionId) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("UPDATE questions SET is_solved = 1 WHERE id = ? AND Idteacher = ?");
    $stmt->execute([$questionId, $teacherId]);
    if ($stmt->rowCount() === 0) {
        return ['success' => false, 'message' => 'Question could not be marked as solved.'];
    }    
    // Assuming notification sending logic is implemented elsewhere
    // sendNotificationToStudent($questionId);
    
    return ['success' => true, 'message' => 'Question solved and student notified.'];
}

// Function to send a notification to the student (placeholder)

// Function to send a notification to the student
// function sendNotificationToStudent($studentToken, $messageText) {
//           $firebase = (new Factory)
//               ->withServiceAccount('path/to/your/firebase-service-account.json')
//               ->createMessaging();
      
//           $message = CloudMessage::withTarget('token', $studentToken)
//               ->withNotification(Notification::create('New Solution', $messageText))
//               ->withData(['key' => 'value']); // Optional additional data
      
//           try {
//               $firebase->send($message);
//               return ['success' => true, 'message' => 'Notification sent successfully.'];
//           } catch (Exception $e) {
//               return ['success' => false, 'message' => 'Failed to send notification: ' . $e->getMessage()];
//           }
//       }


// Example usage
// Assuming you have proper authentication and teacherId is obtained from the session or token
// $teacherId = 1; // Example teacher ID
// $questionId = 10; // Example question ID

// Get all unsolved questions for the teacher
// $unsolvedQuestions = getUnsolvedQuestions($teacherId);

// Reserve a question
// $reserveResult = reserveQuestion($teacherId, $questionId);

// Solve a question and notify the student
// $solveResult = solveQuestion($teacherId, $questionId);

// Output the results (for API response)
// header('Content-Type: application/json');
// echo json_encode([
//     'unsolvedQuestions' => $unsolvedQuestions,
//     'reserveResult' => $reserveResult,
//     'solveResult' => $solveResult
// ]);
?>
