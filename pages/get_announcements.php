<?php
session_start();
require_once '../database/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    echo json_encode(['error' => 'Please log in to view announcements']);
    exit;
}

// Get subject from query parameter and standardize it
$subject = isset($_GET['subject']) ? trim($_GET['subject']) : '';

// Convert subject name to proper case for database matching
if ($subject === 'math') {
    $subject = 'Mathematics';
} else {
    $subject = ucfirst(strtolower($subject));
}

if (empty($subject)) {
    echo json_encode(['error' => 'Subject is required']);
    exit;
}

try {
    // Get announcements for the subject with read status and timestamp
    $query = "SELECT 
                a.*, 
                s.name as subject_name,
                ar.read_at,
                CASE WHEN ar.id IS NOT NULL THEN 1 ELSE 0 END as is_read
              FROM announcements a 
              LEFT JOIN subjects s ON a.subject = s.name 
              LEFT JOIN announcement_reads ar ON a.id = ar.announcement_id 
                AND ar.username = ?
              WHERE (a.subject = ? OR a.subject = 'General')
              ORDER BY a.created_at DESC";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Database error: " . $conn->error);
    }

    $stmt->bind_param("ss", $_SESSION["username"], $subject);
    if (!$stmt->execute()) {
        throw new Exception("Database error: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $announcements = [];

    while ($row = $result->fetch_assoc()) {
        $announcements[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'content' => $row['content'],
            'subject' => $row['subject_name'],
            'created_at' => $row['created_at'],
            'is_read' => (bool)$row['is_read'],
            'read_at' => $row['read_at']
        ];
    }

    $stmt->close();
    $conn->close();

    echo json_encode($announcements);

} catch (Exception $e) {
    // Log the error
    error_log("Get Announcements Error: " . $e->getMessage());
    
    // Return error response
    echo json_encode([
        'error' => 'Error loading announcements: ' . $e->getMessage()
    ]);
    
    // Close connections if they exist
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?> 