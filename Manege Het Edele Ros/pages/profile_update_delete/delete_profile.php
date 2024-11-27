<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

// Include the database connection
include '../db_connect.php';

// Check if the request is a delete profile request
$input = json_decode(file_get_contents('php://input'), true);
if (isset($input['action']) && $input['action'] === 'delete_profile') {
    $gebruiker_id = $_SESSION['gebruiker_id'];

    // Delete the user from the database
    $sql = "DELETE FROM gebruikers WHERE gebruiker_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $gebruiker_id);

    if ($stmt->execute()) {
        // If the deletion is successful, log the user out and return a success response
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session

        echo json_encode(['success' => true]);
    } else {
        // If the deletion fails, return an error response
        echo json_encode(['success' => false, 'message' => 'Could not delete profile']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
