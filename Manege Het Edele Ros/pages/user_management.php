<?php
session_start();

// Controleer of de gebruiker is ingelogd en of hij/zij eigenaar is
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'eigenaar') {
    header("Location: home.php");
    exit();
}

// Verbind met de database
include 'db_connect.php';
include 'head.php';

// Haal alle gebruikers op uit de database
$sql = "SELECT * FROM gebruikers";
$result = $conn->query($sql);
?>

<body>
<?php include 'navbar.html'; ?>

<div class="container mt-5">
    <h1 class="mb-4">Gebruikers Beheren</h1>

    <!-- Success or Error Messages -->
    <?php
    if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']); // Clear message after displaying it
    }
    if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']); // Clear message after displaying it
    }
    ?>

    <?php if ($result->num_rows > 0): ?>
        <!-- Sla alle resultaten op in een array -->
        <?php $gebruikers = []; ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php $gebruikers[] = $row; ?>
        <?php endwhile; ?>

        <!-- Tabel voor grotere schermen -->
        <div class="d-none d-md-block table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Email</th>
                        <th>Adres</th>
                        <th>Telefoonnummer</th>
                        <th>Geboortedatum</th>
                        <th>Gebruikersrol</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gebruikers as $row): ?>
                        <tr>
                            <td><?php echo $row['gebruiker_id']; ?></td>
                            <td><?php echo $row['naam']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['adres']; ?></td>
                            <td><?php echo $row['telefoonnummer']; ?></td>
                            <td><?php echo $row['geboortedatum']; ?></td>
                            <td><?php echo ucfirst($row['gebruikersrol']); ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $row['gebruiker_id']; ?>" class="btn btn-warning btn-sm mb-1">Bewerk</a>
                                <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?php echo $row['gebruiker_id']; ?>" data-naam="<?php echo $row['naam']; ?>">
                                    Verwijder
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Cards voor mobiele schermen -->
        <div class="d-block d-md-none">
            <?php foreach ($gebruikers as $row): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['naam']; ?></h5>
                        <p class="card-text">
                            <strong>Email:</strong> <?php echo $row['email']; ?><br>
                            <strong>Adres:</strong> <?php echo $row['adres']; ?><br>
                            <strong>Telefoonnummer:</strong> <?php echo $row['telefoonnummer']; ?><br>
                            <strong>Geboortedatum:</strong> <?php echo $row['geboortedatum']; ?><br>
                            <strong>Gebruikersrol:</strong> <?php echo ucfirst($row['gebruikersrol']); ?>
                        </p>
                        <a href="edit_user.php?id=<?php echo $row['gebruiker_id']; ?>" class="btn btn-warning btn-sm mb-1">Bewerk</a>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?php echo $row['gebruiker_id']; ?>" data-naam="<?php echo $row['naam']; ?>">
                            Verwijder
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Geen gebruikers gevonden.</div>
    <?php endif; ?>
</div>




<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="deleteModalLabel">Verwijder Gebruiker</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Weet je zeker dat je deze gebruiker wilt verwijderen?
                <strong id="userName"></strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleer</button>
                <a href="#" id="confirmDeleteButton" class="btn btn-danger">Verwijder</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.html'; ?>

<script>
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var userId = button.getAttribute('data-id'); // Extract info from data-* attributes
        var userName = button.getAttribute('data-naam'); // Extract user name

        // Update the modal's content
        var modalTitle = deleteModal.querySelector('.modal-title');
        var modalBodyUserName = deleteModal.querySelector('#userName');
        var confirmDeleteButton = deleteModal.querySelector('#confirmDeleteButton');

        modalBodyUserName.textContent = userName; // Show user name in modal
        confirmDeleteButton.setAttribute('href', 'delete_user.php?id=' + userId); // Set the delete link
    });
</script>

</body>
</html>

<?php
// Sluit de databaseverbinding
$conn->close();
?>
