<?php
session_start();
require_once '../database/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Get announcement ID from POST data
$announcement_id = isset($_POST['announcement_id']) ? (int)$_POST['announcement_id'] : 0;

if ($announcement_id <= 0) {
    echo json_encode(['error' => 'Invalid announcement ID']);
    exit;
}

try {
    // Check if the announcement has already been read by this user
    $check_stmt = $conn->prepare("SELECT id FROM announcement_reads WHERE announcement_id = ? AND username = ?");
    $check_stmt->bind_param("is", $announcement_id, $_SESSION["username"]);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows === 0) {
        // Insert new read record with current timestamp
        $insert_stmt = $conn->prepare("INSERT INTO announcement_reads (announcement_id, username, read_at) VALUES (?, ?, CURRENT_TIMESTAMP)");
        $insert_stmt->bind_param("is", $announcement_id, $_SESSION["username"]);
        
        if ($insert_stmt->execute()) {
            echo json_encode(['success' => true, 'read_at' => date('Y-m-d H:i:s')]);
        } else {
            throw new Exception('Failed to mark announcement as read');
        }
        $insert_stmt->close();
    } else {
        // Already read
        echo json_encode(['success' => true, 'already_read' => true]);
    }
    
    $check_stmt->close();
    
} catch (Exception $e) {
    error_log("Mark Announcement Read Error: " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?> 
?> 