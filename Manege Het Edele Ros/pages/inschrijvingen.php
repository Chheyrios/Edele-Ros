<?php
session_start();

// Controleer of de gebruiker is ingelogd en een eigenaar is
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'eigenaar') {
    header("Location: home.php"); // Redirect als de gebruiker geen eigenaar is
    exit();
}

// Verbind met de database
include 'head.php';
include 'db_connect.php';

// Haal alle inschrijvingen op uit de database
$sql = "SELECT * FROM inschrijvingen";
$result = $conn->query($sql);
?>

<body>

    <?php include 'navbar.html'; ?>

    <div class="container mt-5">
        <h2 class="mb-5">Inschrijvingen voor Paardrijlessen</h2>
        
        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']); // Zorg ervoor dat het bericht maar één keer wordt weergegeven
        }
        ?>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['naam']; ?></h5>
                                <p class="card-text"><strong>Email:</strong> <?php echo $row['email']; ?></p>
                                <p class="card-text"><strong>Telefoon:</strong> <?php echo $row['telefoon']; ?></p>
                                <p class="card-text"><strong>Geboortedatum:</strong> <?php echo $row['geboortedatum']; ?></p>
                                <p class="card-text"><strong>Adres:</strong> <?php echo $row['postcode'] . ', ' . $row['straat'] . ', ' . $row['stad']; ?></p>
                                <p class="card-text"><strong>Opmerkingen:</strong> <?php echo $row['opmerkingen']; ?></p>
                            </div>
                            <div class="card-footer text-center">
                                <div class="d-flex justify-content-center">
                                    <!-- Maak Account knop -->
                                    <form action="inschrijvingen/maak_account.php" method="post" class="me-2">
                                        <input type="hidden" name="inschrijving_id" value="<?php echo $row['inschrijving_id']; ?>">
                                        <input type="hidden" name="naam" value="<?php echo $row['naam']; ?>">
                                        <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                                        <input type="hidden" name="telefoon" value="<?php echo $row['telefoon']; ?>">
                                        <input type="hidden" name="geboortedatum" value="<?php echo $row['geboortedatum']; ?>">
                                        <input type="hidden" name="adres" value="<?php echo $row['postcode'] . ', ' . $row['straat'] . ', ' . $row['stad']; ?>">
                                        <button type="submit" class="btn btn-primary">Maak Account</button>
                                    </form>

                                    <!-- Wijzig Inschrijving knop -->
                                    <form action="wijzig_inschrijving.php" method="post" class="me-2">
                                        <input type="hidden" name="inschrijving_id" value="<?php echo $row['inschrijving_id']; ?>">
                                        <input type="hidden" name="naam" value="<?php echo $row['naam']; ?>">
                                        <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                                        <input type="hidden" name="telefoon" value="<?php echo $row['telefoon']; ?>">
                                        <input type="hidden" name="geboortedatum" value="<?php echo $row['geboortedatum']; ?>">
                                        <input type="hidden" name="adres" value="<?php echo $row['postcode'] . ', ' . $row['straat'] . ', ' . $row['stad']; ?>">
                                        <button type="submit" class="btn btn-warning">Wijzig</button>
                                    </form>

                                    <!-- Verwijder Inschrijving knop -->
                                    <form action="inschrijvingen/verwijder_inschrijving.php" method="post" class="me-2">
                                        <input type="hidden" name="inschrijving_id" value="<?php echo $row['inschrijving_id']; ?>">
                                        <button type="submit" class="btn btn-danger">Verwijder</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Geen inschrijvingen gevonden
                    </div>
                </div>
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
