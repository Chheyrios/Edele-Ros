<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_connect.php';

$mededeling_id = $_GET['id'];
$gebruiker_id = $_SESSION['gebruiker_id'];

// Haal de huidige mededeling op om te bewerken
$sql = "SELECT * FROM mededelingen WHERE mededeling_id = $mededeling_id AND gebruiker_id = $gebruiker_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Geen toegang om deze mededeling te bewerken.";
    exit();
}

$mededeling = $result->fetch_assoc();

// Verwerk het update-formulier
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titel = $conn->real_escape_string($_POST['titel']);
    $inhoud = $conn->real_escape_string($_POST['inhoud']);
    $doelgroep = $_POST['doelgroep'];

    // Update query
    $sql = "UPDATE mededelingen SET titel = '$titel', inhoud = '$inhoud', doelgroep = '$doelgroep' WHERE mededeling_id = $mededeling_id AND gebruiker_id = $gebruiker_id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Mededeling succesvol bijgewerkt!";
        header("Location: mededelingen.php");
        exit();
    } else {
        echo "Fout bij het bijwerken van de mededeling: " . $conn->error;
    }
}
?>


<?php include 'head.php'; ?>

<?php include 'navbar.html'; ?>

<div class="container mt-5">
    <h1>Bewerk Mededeling</h1>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="titel" class="form-label">Titel:</label>
            <input type="text" id="titel" name="titel" class="form-control" value="<?php echo $mededeling['titel']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="inhoud" class="form-label">Inhoud:</label>
            <textarea id="inhoud" name="inhoud" class="form-control" rows="4" required><?php echo $mededeling['inhoud']; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="doelgroep" class="form-label">Doelgroep:</label>
            <select id="doelgroep" name="doelgroep" class="form-select" required>
                <option value="klant" <?php if ($mededeling['doelgroep'] == 'klant') echo 'selected'; ?>>Klanten</option>
                <option value="instructeur" <?php if ($mededeling['doelgroep'] == 'instructeur') echo 'selected'; ?>>Instructeurs</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Bijwerken</button>
    </form>
</div>

<?php include 'footer.html'; ?>

</body>
</html>

<?php
// Sluit de databaseverbinding
$conn->close();
?>
