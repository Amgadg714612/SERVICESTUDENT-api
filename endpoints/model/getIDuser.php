<?php
include_once 'connectDatabase.php';
function get_IDuser($username){
$query = "SELECT id,username FROM users WHERE username = :username";
try {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $user_id = $result['id'];
        $user_name = $result['username'];
        $response = [
            'user_id' => $user_id,
            'username' => $user_name,
        ];

        return $user_id;
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

}

?>
