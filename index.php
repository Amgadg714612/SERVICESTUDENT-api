<?php

require_once 'config.php';
require_once 'endpoints/login.php';
require_once 'endpoints/assignments.php';
require_once 'endpoints/solutions.php';
require_once 'endpoints/unsolved-questions.php';
require_once 'endpoints/solve-question.php';
require_once 'endpoints/search.php';
require_once 'endpoints/addquestion.php';

require_once 'endpoints/upload-pdf.php';
require_once 'endpoints/SignUp.php';
require_once 'endpoints/addassignments.php';
include_once 'endpoints/model/getIDuser.php';
include_once 'endpoints/addTeacher.php';
include_once 'endpoints/displayassignments.php';
// Handle the incoming request
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestEndpoint = $_SERVER['REQUEST_URI'];
// Remove any query parameters from the endpoint
$requestEndpoint = strtok($requestEndpoint, '?');

// Dispatch the request to the appropriate endpoint
$userId = null;
session_start();
$username = null;

switch ($requestEndpoint) {

    case '/SERVICESTUDENT-api/login':
        $username = handleLoginRequest($requestMethod);
        // $_SESSION['username'] = $username;
        // echo  $_SESSION['username'];
        break;
    case '/SERVICESTUDENT-api/SignUp':
        handleSignUpRequest($requestMethod);
        break;
    case '/SERVICESTUDENT-api/addassignments':
        Addassignment($requestMethod);
        break;
    case '/SERVICESTUDENT-api/addQuestion':
        handleaddQuestion($requestMethod);
        break;
    case '/SERVICESTUDENT-api/assignments':
        handleAssignmentsRequest($requestMethod);
        break;
    case '/SERVICESTUDENT-api/Add_New_Teacher':
        addTeacherFromPostRequest();
        break;
        
    case '/SERVICESTUDENT-api/displayassiggnments':
        displayassiggnments();
        break;
        case '/SERVICESTUDENT-api/displayQuestion':
            displayassiggnments();
            break;

    case '/solutions':
        handleSolutionsRequest($requestMethod);
        break;
    case '/unsolved-questions':
        handleUnsolvedQuestionsRequest($requestMethod);
        break;
    case '/solve-question':
        handleSolveQuestionRequest($requestMethod);
        break;
    case '/search':
        handleSearchRequest($requestMethod);
        break;
    case '/upload-pdf':
        handleUploadPDFRequest($requestMethod);
        break;
    default:
        // Handle invalid or unsupported endpoint
        http_response_code(404);
        echo json_encode(['error 400' => 'Endpoint not found']);
        break;
}
