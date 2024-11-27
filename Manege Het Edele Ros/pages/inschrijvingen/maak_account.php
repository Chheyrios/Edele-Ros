<?php
session_start();

// Controleer of de gebruiker is ingelogd en een eigenaar is
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'eigenaar') {
    header("Location: ../home.php"); // Redirect als de gebruiker geen eigenaar is
    exit();
}

// Verbind met de database
include '../db_connect.php';

$message = '';

// Verwerk het formulier wanneer het wordt ingediend
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Haal gegevens op uit het formulier
    $inschrijving_id = $_POST['inschrijving_id'];
    $naam = $conn->real_escape_string($_POST['naam']);
    $email = $conn->real_escape_string($_POST['email']);
    $telefoon = $conn->real_escape_string($_POST['telefoon']);
    $geboortedatum = $conn->real_escape_string($_POST['geboortedatum']);
    $adres = $conn->real_escape_string($_POST['adres']);
    $wachtwoord = md5('standaardwachtwoord'); // Gebruik een standaard wachtwoord of genereer een nieuw wachtwoord

    // Controleer of de gebruiker al bestaat
    $checkUser = "SELECT * FROM gebruikers WHERE email = '$email'";
    $result = $conn->query($checkUser);

    if ($result->num_rows > 0) {
        $message = "Een account met dit e-mailadres bestaat al.";
    } else {
        // Maak een nieuwe gebruiker aan in de database
        $sql = "INSERT INTO gebruikers (naam, email, wachtwoord, adres, telefoonnummer, geboortedatum, gebruikersrol)
                VALUES ('$naam', '$email', '$wachtwoord', '$adres', '$telefoon', '$geboortedatum', 'leerling')";

        if ($conn->query($sql) === TRUE) {
            // Verwijder de inschrijving nadat het account is aangemaakt
            $deleteInschrijving = "DELETE FROM inschrijvingen WHERE inschrijving_id = $inschrijving_id";
            if ($conn->query($deleteInschrijving) === TRUE) {
                $_SESSION['success_message'] = "Account succesvol aangemaakt en inschrijving verwijderd!";
                header("Location: ../inschrijvingen.php"); // Redirect naar een overzichtspagina of een andere pagina
                exit(); // Stop verdere uitvoer
            } else {
                $message = "Fout bij het verwijderen van de inschrijving: " . $conn->error;
            }
        } else {
            $message = "Fout bij het aanmaken van het account: " . $conn->error;
        }
    }
}

// Sluit de databaseverbinding
$conn->close();
?>
