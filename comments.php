<?php
// comments.php
header('Content-Type: application/json');

// Include your database connection file
require_once 'db.php'; // Adjust path if db.php is in a different directory

// Function to sanitize input (important for security)
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Prevent XSS, use UTF-8
    return $data;
}

// Handle POST request to add a new comment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
    $comment = isset($_POST['comment']) ? sanitize_input($_POST['comment']) : '';

    if (!empty($name) && !empty($comment)) {
        try {
            // Use a prepared statement to insert the new comment
            $stmt = $pdo->prepare("INSERT INTO comments (name, comment) VALUES (:name, :comment)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':comment', $comment);
            $stmt->execute();

            echo json_encode(['success' => true, 'message' => 'Comment added successfully!']);
        } catch (PDOException $e) {
            // Log the error for debugging, don't show internal error to user
            error_log("Error adding comment: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Failed to save comment due to a database error.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Name and comment cannot be empty.']);
    }
    exit;
}

// Handle GET request to fetch all comments
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Fetch comments, ordered by creation time (newest first)
        $stmt = $pdo->query("SELECT name, comment, time FROM comments ORDER BY time DESC LIMIT 20");
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as associative arrays

        echo json_encode(['success' => true, 'comments' => $comments]);
    } catch (PDOException $e) {
        error_log("Error fetching comments: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Failed to fetch comments due to a database error.']);
    }
    exit;
}

// If neither GET nor POST, send an error
echo json_encode(['success' => false, 'message' => 'Invalid request method.']);

?>