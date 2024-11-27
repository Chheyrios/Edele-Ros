<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lessonId = $_POST['lesson_id'];
    $reason = $_POST['reason'];

    // Update the lesson status to canceled and set the cancellation reason
    $sql = "UPDATE lessen SET status = 'geannuleerd', annuleringsreden = ? WHERE les_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $reason, $lessonId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to cancel the lesson.']);
    }

    $stmt->close();
    $conn->close();
}
