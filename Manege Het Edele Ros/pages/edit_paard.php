<?php
session_start();
ob_start();  // Start output buffering
include 'db_connect.php'; 

// Check if the user is logged in and has the 'eigenaar' role
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit();
}

$gebruiker_id = $_SESSION['gebruiker_id'];

// Fetch the user's role from the database based on gebruiker_id
$query = "SELECT gebruikersrol FROM gebruikers WHERE gebruiker_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $gebruiker_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null || $user['gebruikersrol'] !== 'eigenaar') {
    header("Location: home.php");
    exit();
}

// Check if horse ID is provided in URL
if (!isset($_GET['id'])) {
    header("Location: paarden_overzicht.php");
    exit();
}

$paard_id = $_GET['id'];

// Fetch horse data from the database
$query = "SELECT * FROM paarden WHERE paard_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $paard_id);
$stmt->execute();
$result = $stmt->get_result();
$horse = $result->fetch_assoc();

if ($horse === null) {
    echo "<p class='text-danger'>Paard niet gevonden.</p>";
    exit();
}

// Handle form submission (when the user submits the form to update horse details)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form inputs
    $naam = mysqli_real_escape_string($conn, $_POST['naam']);
    $geslacht = mysqli_real_escape_string($conn, $_POST['geslacht']);
    $tamheid = mysqli_real_escape_string($conn, $_POST['tamheid']);
    $afbeelding = mysqli_real_escape_string($conn, $_POST['afbeelding']);  // Sanitize image URL

    // Update the horse record in the database
    $query = "UPDATE paarden SET naam = ?, geslacht = ?, tamheid = ?, afbeelding = ? WHERE paard_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $naam, $geslacht, $tamheid, $afbeelding, $paard_id);

    if ($stmt->execute()) {
        // Redirect back to paarden_overzicht.php or display success message
        header("Location: paarden_overzicht.php");
        exit();
    } else {
        echo "<p class='text-danger'>Er is iets misgegaan bij het bijwerken van de gegevens.</p>";
    }
}

include 'head.php'; 
include 'navbar.html'; 
?>

<div class="container my-5">
    <div class="card bg-dark border-dark text-light">
        <div class="card-header">
            <h2 class="my-2">Bewerk Paard: <?php echo htmlspecialchars($horse['naam']); ?></h2>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group mb-3"> <!-- Added margin bottom -->
                    <label for="naam">Naam:</label>
                    <input type="text" class="form-control" id="naam" name="naam" value="<?php echo htmlspecialchars($horse['naam']); ?>" required>
                </div>

                <div class="form-group mb-3"> <!-- Added margin bottom -->
                    <label for="geslacht">Geslacht:</label>
                    <select class="form-control" id="geslacht" name="geslacht" required>
                        <option value="hengst" <?php echo ($horse['geslacht'] === 'hengst') ? 'selected' : ''; ?>>Hengst</option>
                        <option value="ruin" <?php echo ($horse['geslacht'] === 'ruin') ? 'selected' : ''; ?>>Ruin</option>
                        <option value="merrie" <?php echo ($horse['geslacht'] === 'merrie') ? 'selected' : ''; ?>>Merrie</option>
                    </select>
                </div>

                <div class="form-group mb-3"> <!-- Added margin bottom -->
                    <label for="tamheid">Tamheid:</label>
                    <select class="form-control" id="tamheid" name="tamheid" required>
                        <option value="wild" <?php echo ($horse['tamheid'] === 'wild') ? 'selected' : ''; ?>>Wild</option>
                        <option value="gemiddeld" <?php echo ($horse['tamheid'] === 'gemiddeld') ? 'selected' : ''; ?>>Gemiddeld</option>
                        <option value="tam" <?php echo ($horse['tamheid'] === 'tam') ? 'selected' : ''; ?>>Tam</option>
                    </select>
                </div>

                <div class="form-group mb-3"> <!-- Added margin bottom -->
                    <label for="afbeelding">Afbeelding URL:</label>
                    <input type="text" class="form-control" id="afbeelding" name="afbeelding" value="<?php echo htmlspecialchars($horse['afbeelding']); ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Opslaan</button>
                <a href="paarden_overzicht.php" class="btn btn-secondary">Annuleren</a>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.html'; ?>
