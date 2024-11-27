<?php
session_start();

// Controleer of de gebruiker is ingelogd en of hij/zij eigenaar is
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'eigenaar') {
    header("Location: home.php");
    exit();
}

include 'db_connect.php';
include 'head.php';

// Haal de gebruiker op basis van de ID
if (isset($_GET['id'])) {
    $gebruiker_id = $_GET['id'];
    $sql = "SELECT * FROM gebruikers WHERE gebruiker_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $gebruiker_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $gebruiker = $result->fetch_assoc();
    
    if (!$gebruiker) {
        echo "Gebruiker niet gevonden.";
        exit();
    }
}

// Verwerk het formulier voor het bijwerken van de gebruiker
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $conn->real_escape_string($_POST['naam']);
    $email = $conn->real_escape_string($_POST['email']);
    $adres = $conn->real_escape_string($_POST['adres']);
    $telefoonnummer = $conn->real_escape_string($_POST['telefoonnummer']);
    $geboortedatum = $_POST['geboortedatum'];  // Birthdate field added
    $gebruikersrol = $_POST['gebruikersrol'];

    $sql = "UPDATE gebruikers SET naam=?, email=?, adres=?, telefoonnummer=?, geboortedatum=?, gebruikersrol=? WHERE gebruiker_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $naam, $email, $adres, $telefoonnummer, $geboortedatum, $gebruikersrol, $gebruiker_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Gebruiker succesvol bijgewerkt!";
        header("Location: user_management.php");
        exit();
    } else {
        echo "Fout bij het bijwerken: " . $conn->error;
    }
}

?>

<body>
<?php include 'navbar.html'; ?>

<div class="container mt-5">
    <h1 class="mb-4">Bewerk Gebruiker</h1>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="naam" class="form-label">Naam</label>
            <input type="text" class="form-control" id="naam" name="naam" value="<?php echo $gebruiker['naam']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $gebruiker['email']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="adres" class="form-label">Adres</label>
            <input type="text" class="form-control" id="adres" name="adres" value="<?php echo $gebruiker['adres']; ?>">
        </div>

        <div class="mb-3">
            <label for="telefoonnummer" class="form-label">Telefoonnummer</label>
            <input type="text" class="form-control" id="telefoonnummer" name="telefoonnummer" value="<?php echo $gebruiker['telefoonnummer']; ?>">
        </div>

        <div class="mb-3">
            <label for="geboortedatum" class="form-label">Geboortedatum</label>
            <input type="date" class="form-control" id="geboortedatum" name="geboortedatum" value="<?php echo $gebruiker['geboortedatum']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="gebruikersrol" class="form-label">Gebruikersrol</label>
            <select class="form-select" id="gebruikersrol" name="gebruikersrol" required>
                <option value="leerling" <?php echo ($gebruiker['gebruikersrol'] == 'leerling') ? 'selected' : ''; ?>>Leerling</option>
                <option value="instructeur" <?php echo ($gebruiker['gebruikersrol'] == 'instructeur') ? 'selected' : ''; ?>>Instructeur</option>
                <option value="eigenaar" <?php echo ($gebruiker['gebruikersrol'] == 'eigenaar') ? 'selected' : ''; ?>>Eigenaar</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>

<?php include 'footer.html'; ?>

</body>
</html>

<?php
$conn->close();
?>
