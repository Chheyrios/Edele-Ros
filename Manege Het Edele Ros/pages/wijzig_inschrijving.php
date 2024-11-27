<?php
session_start();

// Controleer of de gebruiker is ingelogd en een eigenaar is
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'eigenaar') {
    header("Location: home.php");
    exit();
}

// Verbind met de database
include 'db_connect.php';

// Haal de inschrijving_id op uit de POST-data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inschrijving_id'])) {
    $inschrijving_id = $_POST['inschrijving_id'];
} else {
    // Als er geen POST-gegevens zijn, redirect naar de inschrijvingenpagina
    header("Location: inschrijvingen.php");
    exit();
}

// Haal de gegevens van de inschrijving uit de database
$sql = "SELECT * FROM inschrijvingen WHERE inschrijving_id = $inschrijving_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Vul de variabelen met de huidige gegevens van de inschrijving
    $row = $result->fetch_assoc();
    $naam = $row['naam'];
    $email = $row['email'];
    $telefoon = $row['telefoon'];
    $geboortedatum = $row['geboortedatum'];
    $postcode = $row['postcode'];
    $straat = $row['straat'];
    $stad = $row['stad'];
    $opmerkingen = $row['opmerkingen'];
} else {
    echo "Geen inschrijving gevonden.";
    exit();
}

// Verwerk het formulier wanneer het wordt verzonden om de inschrijving te wijzigen
if (isset($_POST['update'])) {
    // Haal de nieuwe waarden op uit het formulier
    $nieuw_naam = $conn->real_escape_string($_POST['naam']);
    $nieuw_email = $conn->real_escape_string($_POST['email']);
    $nieuw_telefoon = $conn->real_escape_string($_POST['telefoon']);
    $nieuw_geboortedatum = $conn->real_escape_string($_POST['geboortedatum']);
    $nieuw_postcode = $conn->real_escape_string($_POST['postcode']);
    $nieuw_straat = $conn->real_escape_string($_POST['straat']);
    $nieuw_stad = $conn->real_escape_string($_POST['stad']);
    $nieuw_opmerkingen = $conn->real_escape_string($_POST['opmerkingen']);

    // Update de inschrijving in de database
    $sql = "UPDATE inschrijvingen SET 
                naam='$nieuw_naam', 
                email='$nieuw_email', 
                telefoon='$nieuw_telefoon', 
                geboortedatum='$nieuw_geboortedatum', 
                postcode='$nieuw_postcode', 
                straat='$nieuw_straat', 
                stad='$nieuw_stad', 
                opmerkingen='$nieuw_opmerkingen' 
            WHERE inschrijving_id=$inschrijving_id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Inschrijving succesvol bijgewerkt!";
        header("Location: inschrijvingen.php");
        exit();
    } else {
        echo "Fout bij het bijwerken van de inschrijving: " . $conn->error;
    }
}

// Sluit de databaseverbinding
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <title>Wijzig Inschrijving</title>
</head>
<body>
    <?php include 'navbar.html'; ?>

    <div class="container mt-5">
        <h2 class="mb-5">Wijzig Inschrijving</h2>
        <form action="wijzig_inschrijving.php" method="post">
            <input type="hidden" name="inschrijving_id" value="<?php echo $inschrijving_id; ?>">
            <div class="form-group mb-3">
                <label for="naam">Naam:</label>
                <input type="text" id="naam" name="naam" class="form-control" value="<?php echo isset($naam) ? $naam : ''; ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($email) ? $email : ''; ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="telefoon">Telefoon:</label>
                <input type="tel" id="telefoon" name="telefoon" class="form-control" value="<?php echo isset($telefoon) ? $telefoon : ''; ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="geboortedatum">Geboortedatum:</label>
                <input type="date" id="geboortedatum" name="geboortedatum" class="form-control" value="<?php echo isset($geboortedatum) ? $geboortedatum : ''; ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="postcode">Postcode:</label>
                <input type="text" id="postcode" name="postcode" class="form-control" value="<?php echo isset($postcode) ? $postcode : ''; ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="straat">Straat:</label>
                <input type="text" id="straat" name="straat" class="form-control" value="<?php echo isset($straat) ? $straat : ''; ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="stad">Stad:</label>
                <input type="text" id="stad" name="stad" class="form-control" value="<?php echo isset($stad) ? $stad : ''; ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="opmerkingen">Opmerkingen:</label>
                <textarea id="opmerkingen" name="opmerkingen" class="form-control"><?php echo isset($opmerkingen) ? $opmerkingen : ''; ?></textarea>
            </div>

            <button type="submit" name="update" class="btn btn-success mb-5">Wijzig Inschrijving</button>
        </form>
    </div>

    <?php include 'footer.html'; ?>
</body>
</html>
