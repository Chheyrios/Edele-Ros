<?php
session_start();

// Include database connection
include '../db_connect.php';  // Ensure the correct path to db_connect.php

// Check if the user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../login.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID from the session
    $gebruiker_id = $_SESSION['gebruiker_id'];

    // Get the form input values and sanitize them
    $naam = $conn->real_escape_string($_POST['naam']);
    $email = $conn->real_escape_string($_POST['email']);
    $adres = $conn->real_escape_string($_POST['adres']);
    $telefoonnummer = $conn->real_escape_string($_POST['telefoonnummer']);
    $geboortedatum = $conn->real_escape_string($_POST['geboortedatum']);

    // Fetch the original user data from the database for comparison
    $sql = "SELECT naam, email, adres, telefoonnummer, geboortedatum FROM gebruikers WHERE gebruiker_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $gebruiker_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $original_user_data = $result->fetch_assoc();

        // Check if any changes were made by comparing original data with the submitted data
        if ($original_user_data['naam'] === $naam &&
            $original_user_data['email'] === $email &&
            $original_user_data['adres'] === $adres &&
            $original_user_data['telefoonnummer'] === $telefoonnummer &&
            $original_user_data['geboortedatum'] === $geboortedatum) {
            
            // No changes made, redirect with a message
            header("Location: ../profile.php?update=no_changes");
            exit();
        }
    }

    // Validate email (optional but recommended)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../profile.php?update=invalid_email");
        exit();
    }

    // Update the user's data in the database
    $sql = "UPDATE gebruikers SET naam = ?, email = ?, adres = ?, telefoonnummer = ?, geboortedatum = ? WHERE gebruiker_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $naam, $email, $adres, $telefoonnummer, $geboortedatum, $gebruiker_id);

    if ($stmt->execute()) {
        // Success: Redirect to profile page with a success message
        header("Location: ../profile.php?update=success");
        exit();
    } else {
        // Error: Redirect to profile page with an error message
        header("Location: ../profile.php?update=error");
        exit();
    }
}
?>
