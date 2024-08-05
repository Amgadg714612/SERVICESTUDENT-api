<?php


// Include your database connection script
require_once 'model/connectDatabase.php';



// Function to add a user to the database
function addUser($username, $password, $email, $created_at, $typeaccount, $mobile, $dept) {
    // Get the database connection
    $pdo = getDatabaseConnection();
    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, created_at, typeaccount, mobile, dept) VALUES (:username, :password, :email, :created_at, :typeaccount, :mobile, :dept)");
    // Bind the parameters
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':created_at', $created_at);
    $stmt->bindParam(':typeaccount', $typeaccount);
    $stmt->bindParam(':mobile', $mobile);
    $stmt->bindParam(':dept', $dept);
    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Return the last inserted ID
        return $pdo->lastInsertId();
    } else {
        return false;
    }
}


// Function to add a teacher to the database
function addTeacher($id_user, $dept_specialization, $Phone_Number) {
    // Get the database connection
    $pdo = getDatabaseConnection();
    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO teachers (id_user, dept_specialization, Phone_Number) VALUES (:id_user, :dept_specialization, :Phone_Number)");
    // Bind the parameters
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':dept_specialization', $dept_specialization);
    $stmt->bindParam(':Phone_Number', $Phone_Number);
    // Execute the statement and check for success
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}



// // Check if the request is a POST request
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Retrieve data from POST request
//     $username = $_POST['username'];
//     $password = $_POST['password'];
//     $email = $_POST['email'];
//     $created_at = $_POST['created_at'];
//     $typeaccount = $_POST['typeaccount'];
//     $mobile = $_POST['mobile'];
//     $dept = $_POST['dept'];
//     $dept_specialization = $_POST['dept_specialization'];
//     $Phone_Number = $_POST['Phone_Number'];

//     // Initialize an array to store the response
//     $response = [];

//     // First, add the user
//     $id_user = addUser($username, $password, $email, $created_at, $typeaccount, $mobile, $dept);

//     if ($id_user) {
//         // If the user is a teacher, add to teachers table
//         if ($typeaccount == 1) {
//             $result = addTeacher($id_user, $dept_specialization, $Phone_Number);
//             if ($result) {
//                 $response['message'] = 'Teacher added successfully.';
//                 $response['id_user'] = $id_user;
//             } else {
//                 $response['message'] = 'Error adding teacher.';
//             }
//         }
//     } else {
//         $response['message'] = 'Error adding user.';
//     }

//     // Return the response in JSON format
//     echo json_encode($response);
// } else {
//     // If not a POST request, return an error in JSON format
//     echo json_encode(['message' => 'Invalid request method.']);
// }


// Function to add a teacher to the database with admin verification
function addTeacherFromPostRequest() {
    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve data from POST request
        $id_user = $_POST['id_user'];
        $dept_specialization = $_POST['dept_specialization'];
        $Phone_Number = $_POST['Phone_Number'];
        $token = $_POST['token']; // Admin ID
        // Example: Check $idadmin against the 'admins' table in the database

        // If verification is successful, proceed to add the teacher
        if (isAdmin($token)) {
            $idadmin = getAdminIdByToken($token);
            $success = addTeacher($id_user, $dept_specialization, $Phone_Number, $idadmin);
            // Prepare the response based on the success of addTeacher
            if ($success) {
                $response = [
                    'success' => true,
                    'message' => 'Teacher added successfully by admin.',
                    'idadmin' => $idadmin // Include the admin ID in the response
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Failed to add teacher.'
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Unauthorized: Only admins can add teachers.'
            ];
        }
        echo json_encode($response);
    } else {
        // If not a POST request, return an error
        $response = [
            'success' => false,
            'message' => 'Invalid request method.'
        ];
        echo json_encode($response);
    }
}

// Example function to check if the user is an admin
function isAdmin($token) {
    // Example: Query the 'admins' table in the database
$providedToken = $token; // Retrieve the provided token from the POST request
$tokenExists = verifyTokenInAdmin($providedToken);

if ($tokenExists) {
    // Token exists in the admin table
    return true;

} else {
    // Token does not exist in the admin table
    return false;
    
}



    // Return true if $idadmin is an admin, otherwise false
   // Placeholder return value
}

function verifyTokenInAdmin($token) {
    // Get the database connection
    $pdo = getDatabaseConnection();
    // Prepare the SQL SELECT statement
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE TokenAdmin = :token");
    // Bind the token parameter
    $stmt->bindParam(':token', $token);
    
    // Execute the query
    $stmt->execute();
    
    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Return true if a record is found, otherwise false
    return $result ? true : false;
}


function getAdminIdByToken($token) {
    // Get the database connection
    $pdo = getDatabaseConnection();
    // Prepare the SQL SELECT statement
    $stmt = $pdo->prepare("SELECT idadmin FROM admin WHERE TokenAdmin = :token");
    // Bind the token parameter
    $stmt->bindParam(':token', $token);
    // Execute the query
    $stmt->execute();
    
    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Return the admin ID if found, otherwise return null
    return $result ? $result['idadmin'] : null;
}



?>





