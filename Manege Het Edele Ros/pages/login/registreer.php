<?php
session_start();
include '../db_connect.php';

// Controleer of de gebruiker eigenaar is
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'eigenaar') {
    header("Location: home.php");
    exit();
}

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $conn->real_escape_string($_POST['naam']);
    $email = $conn->real_escape_string($_POST['email']);
    $wachtwoord = $conn->real_escape_string($_POST['wachtwoord']);
    $hashedPassword = md5($wachtwoord);  // Gebruik bcrypt voor betere beveiliging in productie
    $gebruikersrol = $conn->real_escape_string($_POST['gebruikersrol']);

    // Controleer of de e-mail al bestaat
    $emailCheckSql = "SELECT * FROM gebruikers WHERE email = ?";
    $emailStmt = $conn->prepare($emailCheckSql);
    $emailStmt->bind_param("s", $email);
    $emailStmt->execute();
    $emailResult = $emailStmt->get_result();

    if ($emailResult->num_rows > 0) {
        $response['message'] = 'Er bestaat al een account met dit e-mailadres.';
    } else {
        // Voeg de nieuwe gebruiker toe
        $insertSql = "INSERT INTO gebruikers (naam, email, wachtwoord, gebruikersrol) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("ssss", $naam, $email, $hashedPassword, $gebruikersrol);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Nieuwe gebruiker succesvol geregistreerd!';
        } else {
            $response['message'] = 'Er is een fout opgetreden bij het registreren van de gebruiker.';
        }

        $stmt->close();
    }

    $emailStmt->close();
    $conn->close();
}

// Stuur de JSON response terug
header('Content-Type: application/json');
echo json_encode($response);
?>
