<?php
include 'db_connect.php';

// Get the horse ID from the URL
if (isset($_GET['id'])) {
    $paard_id = $_GET['id'];

    // First delete the related lessons
    $query_lessen = "DELETE FROM lessen WHERE paard_id = ?";
    $stmt_lessen = $conn->prepare($query_lessen);
    $stmt_lessen->bind_param("i", $paard_id);
    $stmt_lessen->execute();

    // Then delete the horse
    $query_paard = "DELETE FROM paarden WHERE paard_id = ?";
    $stmt_paard = $conn->prepare($query_paard);
    $stmt_paard->bind_param("i", $paard_id);

    // Execute the delete operation for the horse
    if ($stmt_paard->execute()) {
        // Redirect back to the horse management page after deletion
        header("Location: paarden_overzicht.php");
        exit;
    } else {
        echo "Error tijdens het verwijderen.";
    }
} else {
    echo "Invalid request.";
}
?>
