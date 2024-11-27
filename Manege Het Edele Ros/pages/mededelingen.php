<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit();
}

// Verbind met de database
include 'db_connect.php';
include 'head.php';

// Haal de rol en ID van de ingelogde gebruiker op
$user_role = $_SESSION['user_role'];
$gebruiker_id = $_SESSION['gebruiker_id'];

// Verwerk het formulier wanneer een nieuwe mededeling wordt geplaatst
if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($user_role == 'eigenaar' || $user_role == 'instructeur')) {
    $titel = $conn->real_escape_string($_POST['titel']);
    $inhoud = $conn->real_escape_string($_POST['inhoud']);
    $doelgroep = $_POST['doelgroep']; // klant of instructeur

    // SQL om de mededeling op te slaan
    $sql = "INSERT INTO mededelingen (titel, inhoud, gebruiker_id, doelgroep) VALUES ('$titel', '$inhoud', $gebruiker_id, '$doelgroep')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Mededeling succesvol geplaatst!";
    } else {
        echo "Fout bij het plaatsen van de mededeling: " . $conn->error;
    }
}

// Haal de mededelingen op voor de juiste doelgroep
if ($user_role == 'leerling') {
    // Klanten mogen alleen mededelingen voor klanten zien
    $sql = "SELECT m.*, g.naam, g.gebruikersrol FROM mededelingen m
            JOIN gebruikers g ON m.gebruiker_id = g.gebruiker_id
            WHERE m.doelgroep = 'klant'
            ORDER BY m.datum DESC";
} elseif ($user_role == 'instructeur') {
    // Instructeurs mogen mededelingen voor zowel klanten als instructeurs zien
    $sql = "SELECT m.*, g.naam, g.gebruikersrol FROM mededelingen m
            JOIN gebruikers g ON m.gebruiker_id = g.gebruiker_id
            WHERE m.doelgroep = 'instructeur' OR m.doelgroep = 'klant'
            ORDER BY m.datum DESC";
} else {
    // Eigenaren mogen alle mededelingen zien
    $sql = "SELECT m.*, g.naam, g.gebruikersrol FROM mededelingen m
            JOIN gebruikers g ON m.gebruiker_id = g.gebruiker_id
            ORDER BY m.datum DESC";
}

$result = $conn->query($sql);

?>

<body>

<?php include 'navbar.html'; ?>

<div class="container mt-5">
    <h1 class="mb-4">Mededelingen</h1>

    <!-- Formulier om mededelingen te plaatsen, alleen voor eigenaren en instructeurs -->
    <?php if ($user_role == 'eigenaar' || $user_role == 'instructeur'): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h2>Nieuwe Mededeling Plaatsen</h2>
            </div>
            <div class="card-body">
                <form action="mededelingen.php" method="POST">
                    <div class="mb-3">
                        <label for="titel" class="form-label">Titel:</label>
                        <input type="text" id="titel" name="titel" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="inhoud" class="form-label">Inhoud:</label>
                        <textarea id="inhoud" name="inhoud" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="doelgroep" class="form-label">Doelgroep:</label>
                        <select id="doelgroep" name="doelgroep" class="form-select" required>
                            <option value="klant">Klanten</option>
                            <option value="instructeur">Instructeurs</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Plaats Mededeling</button>
                </form>
            </div>
        </div>

        <!-- Succesbericht voor het plaatsen van een mededeling -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Weergave van de mededelingen -->
    <h2 class="mb-4">Laatste Mededelingen</h2>
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['titel']; ?></h5>
                            <p class="card-text"><?php echo $row['inhoud']; ?></p>
                            <p class="card-text"><small>Geplaatst door: <?php echo $row['naam']; ?> (<?php echo $row['gebruikersrol']; ?>)</small></p>
                            <p class="card-text"><small>Op: <?php echo $row['datum']; ?></small></p>

                            <!-- Show the "Edit" button if the logged-in user is the author of the mededeling -->
                            <?php if ($row['gebruiker_id'] == $gebruiker_id): ?>
                                <a href="edit_mededeling.php?id=<?php echo $row['mededeling_id']; ?>" class="btn btn-warning">Bewerk</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info">Er zijn momenteel geen mededelingen.</div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.html'; ?>

</body>
</html>

<?php
// Sluit de databaseverbinding
$conn->close();
?>

