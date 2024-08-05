<?php


function getTeacherIdByToken($token) {
    // Get the database connection
    $pdo = getDatabaseConnection();
    // First, get the user ID associated with the token from the 'users' table
    $stmtUser = $pdo->prepare("SELECT id FROM users WHERE token = :token");
    $stmtUser->bindParam(':token', $token);
    $stmtUser->execute();
    $userResult = $stmtUser->fetch(PDO::FETCH_ASSOC);
    // If a user ID is found, proceed to get the teacher ID from the 'teachers' table
    if ($userResult) {
        $id_user = $userResult['id'];
        $stmtTeacher = $pdo->prepare("SELECT id  FROM teachers WHERE id_user = :id_user");
        $stmtTeacher->bindParam(':id_user', $id_user);
        $stmtTeacher->execute();
        $teacherResult = $stmtTeacher->fetch(PDO::FETCH_ASSOC);
        // Return the teacher ID if found, otherwise return null
        return $teacherResult ? $teacherResult['id'] : null;
    } else {
        // No user found with the given token
        return null;
    }
}
