<?php
session_start();

// Controleer of de gebruiker is ingelogd en een eigenaar is
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'eigenaar') {
    header("Location: home.php"); // Redirect als de gebruiker geen eigenaar is
    exit();
}

// Verbind met de database
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Haal het inschrijving_id op uit het formulier
    $inschrijving_id = $_POST['inschrijving_id'];

    // Verwijder de inschrijving uit de database
    $sql = "DELETE FROM inschrijvingen WHERE inschrijving_id = $inschrijving_id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Inschrijving succesvol verwijderd!";
    } else {
        $_SESSION['success_message'] = "Fout bij het verwijderen van de inschrijving: " . $conn->error;
    }

    // Sluit de databaseverbinding
    $conn->close();

    // Redirect terug naar de inschrijvingenpagina
    header("Location: ../inschrijvingen.php");
    exit();
}
?>
