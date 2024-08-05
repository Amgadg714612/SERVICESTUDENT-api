<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Assignments API</title>
    <script>
        // Function to fetch and display assignments
        function fetchAssignments(userType, userId, specialization = '') {
            // Build the API URL with query parameters
            var apiUrl = 'displayassignments.php ?userType=' + userType + '&userId=' + userId;
            if (specialization) {
                apiUrl += '&specialization=' + specialization;
            }

            // Make the API request
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    // Display the assignments
                    var assignmentsList = document.getElementById('assignmentsList');
                    assignmentsList.innerHTML = ''; // Clear current list
                    data.forEach(function(assignment) {
                        var listItem = document.createElement('li');
                        listItem.textContent = assignment.assignment_name + ' - ' + assignment.deadline_date;
                        assignmentsList.appendChild(listItem);
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>
    <h1>Assignments API Tester</h1>
    <button onclick="fetchAssignments('0', 'student_id_here')">Fetch Student Assignments</button>
    <button onclick="fetchAssignments('1', 'teacher_id_here', 'specialization_here')">Fetch Teacher Assignments</button>
    <ul id="assignmentsList"></ul>
</body>
</html> -->
