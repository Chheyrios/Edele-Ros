<?php
// Verbind met de database
include '../db_connect.php';
session_start(); // Start de sessie

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Haal de formuliergegevens op
    $naam = $conn->real_escape_string($_POST['naam']);
    $email = $conn->real_escape_string($_POST['email']);
    $telefoon = $conn->real_escape_string($_POST['telefoon']);
    $geboortedatum = $conn->real_escape_string($_POST['geboortedatum']);
    $postcode = $conn->real_escape_string($_POST['postcode']);
    $straat = $conn->real_escape_string($_POST['straat']);
    $stad = $conn->real_escape_string($_POST['stad']);
    $opmerkingen = $conn->real_escape_string($_POST['opmerkingen']);

    // SQL om de inschrijving in de database op te slaan
    $sql = "INSERT INTO inschrijvingen (naam, email, telefoon, geboortedatum, postcode, straat, stad, opmerkingen)
            VALUES ('$naam', '$email', '$telefoon', '$geboortedatum', '$postcode', '$straat', '$stad', '$opmerkingen')";

    if ($conn->query($sql) === TRUE) {
        // Succesbericht opslaan in sessie
        $_SESSION['success_message'] = "Inschrijving succesvol verzonden!";
        header('Location: ../inschrijf_formulier.php'); // Redirect naar de inschrijfpagina
        exit();
    } else {
        echo "Fout: " . $sql . "<br>" . $conn->error;
    }

    // Sluit de databaseverbinding
    $conn->close();
}
?>
