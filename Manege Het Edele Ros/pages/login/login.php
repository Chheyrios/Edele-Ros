<?php
session_start();
include '../db_connect.php';

$response = array('success' => false, 'message' => '', 'emailError' => '', 'passwordError' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $hashedPassword = md5($password);  // Use bcrypt in production for better security

    // Check if email exists
    $emailCheckSql = "SELECT * FROM gebruikers WHERE email = ?";
    $emailStmt = $conn->prepare($emailCheckSql);
    $emailStmt->bind_param("s", $email);
    $emailStmt->execute();
    $emailResult = $emailStmt->get_result();

    if ($emailResult->num_rows > 0) {
        // Email exists, now check the password
        $user = $emailResult->fetch_assoc();
        if ($user['wachtwoord'] == $hashedPassword) {
            // Password is correct, log the user in
            $_SESSION['gebruiker_id'] = $user['gebruiker_id'];
            $_SESSION['user_name'] = $user['naam'];
            $_SESSION['user_role'] = $user['gebruikersrol'];
        
            // Check if the user is an owner
            if ($user['gebruikersrol'] == 'eigenaar') {
                $_SESSION['is_eigenaar'] = true;  // Set a session variable for owners
                $response['redirect'] = 'dashboard.php';  // Redirect to the dashboard for owners
            } else {
                $response['redirect'] = 'profile.php';  // Redirect to profile for non-owners
            }
        
            // Return success
            $response['success'] = true;
        }
         else {
            // Password is incorrect
            $response['passwordError'] = 'Onjuist wachtwoord.';
        }
    } else {
        // Email does not exist
        $response['emailError'] = 'Geen account gevonden met deze email.';
    }

    // Close the statement and connection
    $emailStmt->close();
    $conn->close();
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
