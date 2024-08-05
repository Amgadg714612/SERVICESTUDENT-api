<?php
// search.php

// Handle search request
function handleSearchRequest($requestMethod)
{
    // Check the request method
    if ($requestMethod === 'GET') {
        // Process the GET request for search

        // Retrieve and process search query
        $searchQuery = $_GET['query'];

        // Perform the search logic
        // Here, you can implement your own search algorithm or utilize a search library

        // Assuming search results are found
        $searchResults = [
            [
                'id' => 1,
                'title' => 'Document 1',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
            [
                'id' => 2,
                'title' => 'Document 2',
                'content' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
            ],
            // Add more search results as needed
        ];

        // Return the search results as a JSON response
        echo json_encode($searchResults);
    } else {
        // Invalid request method
        http_response_code(405);
        echo json_encode(['error' => 'Invalid request method']);
    }
}

// Function to handle a search request
function handleSearchRequest1($requestMethod)
{
    // Check the request method
    if ($requestMethod === 'GET') {
        // Process the GET request for search

        // Retrieve and sanitize the search query to prevent SQL injection
        $searchQuery = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING);

        // Sample documents array
        $documents = [
            [
                'id' => 1,
                'title' => 'Document 1',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
            [
                'id' => 2,
                'title' => 'Document 2',
                'content' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
            ],
            // Add more documents as needed
        ];

        // Perform the search logic using array_filter
        $searchResults = array_filter($documents, function ($doc) use ($searchQuery) {
            return stripos($doc['title'], $searchQuery) !== false || stripos($doc['content'], $searchQuery) !== false;
        });

        // Return the search results as a JSON response
        echo json_encode(array_values($searchResults));
    } else {
        // Invalid request method
        http_response_code(405);
        echo json_encode(['error' => 'Invalid request method']);
    }
}
?>

?>
