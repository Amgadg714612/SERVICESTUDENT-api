<?php
function getStudentId($id_user) {
    // افترض أن لديك اتصالًا بقاعدة البيانات
    $pdo = getDatabaseConnection(); // استدعاء الدالة للحصول على اتصال بقاعدة البيانات
    // استعلم عن id_student باستخدام id_user
    $query = 'SELECT id FROM students WHERE user_id = :id_user';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    // استرجاع id_student
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        return $result['id'];
    } else {
        return null; // إذا لم يتم العثور على سجل مطابق
    }
}

?>
