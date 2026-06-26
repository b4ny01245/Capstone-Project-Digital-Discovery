<?php
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    
    // Validate required fields
    if (empty($name) || empty($comment)) {
        echo json_encode(['success' => false, 'message' => 'Name and comment are required.']);
        exit;
    }
    
    // Create new comment array
    $newComment = [
        'name' => $name,
        'email' => $email,
        'comment' => $comment,
        'date' => date('Y-m-d H:i:s')
    ];
    
    // Read existing comments
    $commentsFile = 'comment.json';
    $comments = [];
    
    if (file_exists($commentsFile)) {
        $jsonContent = file_get_contents($commentsFile);
        $comments = json_decode($jsonContent, true);
    }
    
    // Add new comment at the beginning
    array_unshift($comments, $newComment);
    
    // Save back to JSON file
    file_put_contents($commentsFile, json_encode($comments, JSON_PRETTY_PRINT));
    
    // Return success response
    echo json_encode(['success' => true]);
} else {
    // Not a POST request
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>