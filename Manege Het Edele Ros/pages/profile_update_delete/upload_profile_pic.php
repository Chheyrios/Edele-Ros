<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Check if file was uploaded
    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == 0) {
        echo '<pre>';
        print_r($_FILES['profilePic']);
        echo '</pre>';

        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];
        $fileSize = $_FILES['profilePic']['size'];
        $fileName = $_FILES['profilePic']['name'];
        $fileTmpName = $_FILES['profilePic']['tmp_name'];
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $maxFileSize = 2 * 1024 * 1024; // 2MB limit

        // Validate file type and size
        if (in_array($extension, $allowedExtensions) && $fileSize <= $maxFileSize) {
            $gebruiker_id = $_SESSION['gebruiker_id'];
            $newFileName = 'profile_' . $gebruiker_id . '.' . $extension;

            // Upload directory
            $uploadDir = '../uploads/profile_pics/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $uploadPath = $uploadDir . $newFileName;

            // Move the file to the upload directory
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                // Update the user's profile picture path in the database
                $sql = "UPDATE gebruikers SET profielfoto = ? WHERE gebruiker_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $newFileName, $gebruiker_id);

                if ($stmt->execute()) {
                    header("Location: ../profile.php?upload=success");
                    exit();
                } else {
                    $error = "Error updating profile picture in the database.";
                }
            } else {
                $error = "Error moving the uploaded file.";
            }
        } else {
            $error = "Invalid file type or size. Please upload a JPEG, PNG, or GIF file smaller than 2MB.";
        }
    } else {
        $error = "No file uploaded or there was an upload error.";
    }

    // Redirect to profile with error message
    if (isset($error)) {
        header("Location: ../profile.php?upload=error&message=" . urlencode($error));
        exit();
    }
}
?>
