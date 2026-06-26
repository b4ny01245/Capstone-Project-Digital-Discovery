<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get comment index
    $index = isset($_POST['index']) ? intval($_POST['index']) : -1;
    
    // Validate index
    if ($index < 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid comment index']);
        exit;
    }
    
    // Read comments from JSON file
    $commentsFile = 'comment.json';
    $comments = [];
    
    if (file_exists($commentsFile)) {
        $jsonContent = file_get_contents($commentsFile);
        $comments = json_decode($jsonContent, true);
    }
    
    // Check if index exists
    if (!isset($comments[$index])) {
        echo json_encode(['success' => false, 'message' => 'Comment not found']);
        exit;
    }
    
    // Remove comment
    unset($comments[$index]);
    
    // Re-index array to avoid gaps
    $comments = array_values($comments);
    
    // Save back to JSON file
    file_put_contents($commentsFile, json_encode($comments, JSON_PRETTY_PRINT));
    
    // Return success response
    echo json_encode([
        'success' => true, 
        'count' => count($comments)
    ]);
} else {
    // Not a POST request
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>