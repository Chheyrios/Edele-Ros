<?php
session_start();

// Controleer of de gebruiker is ingelogd en of hij/zij eigenaar is
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'eigenaar') {
    header("Location: home.php");
    exit();
}

// Verbind met de database
include 'db_connect.php';

// Controleer of er een gebruiker_id is opgegeven
if (isset($_GET['id'])) {
    $gebruiker_id = $_GET['id'];

    // Begin een transactie
    $conn->begin_transaction();

    try {
        // Verwijder eerst alle lessen waar de gebruiker leerling of instructeur is
        $sql_delete_lessons = "DELETE FROM lessen WHERE instructeur_id = ? OR leerling_id = ?";
        $stmt_delete_lessons = $conn->prepare($sql_delete_lessons);
        $stmt_delete_lessons->bind_param("ii", $gebruiker_id, $gebruiker_id);
        $stmt_delete_lessons->execute();

        // Verwijder vervolgens de gebruiker uit de database
        $sql = "DELETE FROM gebruikers WHERE gebruiker_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $gebruiker_id);

        if ($stmt->execute()) {
            // Commit de transactie als beide verwijderingen slagen
            $conn->commit();
            $_SESSION['success_message'] = "Gebruiker succesvol verwijderd!";
        } else {
            throw new Exception("Fout bij het verwijderen van de gebruiker: " . $conn->error);
        }

    } catch (Exception $e) {
        // Rol de transactie terug bij een fout
        $conn->rollback();
        $_SESSION['error_message'] = $e->getMessage();
    }
} else {
    $_SESSION['error_message'] = "Geen gebruiker opgegeven voor verwijdering.";
}

// Redirect naar de juiste pagina na verwijdering
header("Location: user_management.php");
exit();
?>
