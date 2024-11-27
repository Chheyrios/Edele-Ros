<?php
session_start();
include 'db_connect.php';

// Initialize toggle state for showing read messages
if (!isset($_SESSION['show_read'])) {
    $_SESSION['show_read'] = false; // Default to show unread messages
}

// Handle toggle request
if (isset($_POST['toggle_read'])) {
    $_SESSION['show_read'] = !$_SESSION['show_read']; // Toggle the state
}

// Fetch the user ID from the session
$gebruiker_id = $_SESSION['gebruiker_id'];

// Fetch the user's role
$sql = "SELECT gebruikersrol FROM gebruikers WHERE gebruiker_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $gebruiker_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if the user's role is 'eigenaar'
if ($user['gebruikersrol'] !== 'eigenaar') {
    header("Location: home.php");
    exit();
}

// Handle delete request
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $deleteSql = "DELETE FROM contact_submissions WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);  // Refresh page after delete
    exit();
}

// Handle mark as read request
if (isset($_POST['read_id'])) {
    $read_id = $_POST['read_id'];
    $readSql = "UPDATE contact_submissions SET is_read = 1 WHERE id = ?";
    $stmt = $conn->prepare($readSql);
    $stmt->bind_param("i", $read_id);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);  // Refresh page after marking as read
    exit();
}

// Adjust SQL query based on toggle state
if ($_SESSION['show_read']) {
    // Show only read messages
    $submissionsSql = "SELECT * FROM contact_submissions WHERE is_read = 1 ORDER BY submitted_at DESC";
} else {
    // Show unread messages
    $submissionsSql = "SELECT * FROM contact_submissions WHERE is_read = 0 ORDER BY submitted_at DESC";
}

// Execute the query and check for errors
$result = $conn->query($submissionsSql);

// Check if the query was successful
if ($result === false) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="nl">
    <?php include 'head.php'; ?>
<body>
<?php include 'navbar.html'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4 text-dark text-center">Alle contact opnames</h2>

            <!-- Toggle Button -->
            <form method="post" class="mb-3 text-center">
                <button type="submit" name="toggle_read" class="btn btn-primary-custom">
                    <?php echo $_SESSION['show_read'] ? 'Toon Ongelezen Berichten' : 'Toon Gelezen Berichten'; ?>
                </button>
            </form>

            <div class="submission-container">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($submission = $result->fetch_assoc()): ?>
                        <div class="card card-custom bg-light text-dark">
                            <div class="card-body">
                                <strong><?php echo htmlspecialchars($submission['name']); ?></strong><br>
                                E-mail: <a href="mailto:<?php echo htmlspecialchars($submission['email']); ?>" class="text-dark"><?php echo htmlspecialchars($submission['email']); ?></a><br>
                                Telefoon: <a href="tel:<?php echo htmlspecialchars($submission['phone']); ?>" class="text-dark"><?php echo htmlspecialchars($submission['phone']); ?></a>

                                <div class="submission-message mt-2">
                                    <p><?php echo nl2br(htmlspecialchars($submission['message'])); ?></p>
                                </div>
                                <div class="submission-date">
                                    <small>Ingediend op: <?php echo $submission['submitted_at']; ?></small>
                                </div>
                                <div class="mt-2 text-right">
                                    <form method="post">
                                        <button type="submit" name="delete_id" value="<?php echo $submission['id']; ?>" class="btn btn-danger btn-sm">Verwijderen</button>
                                        <?php if ($submission['is_read'] == 0): // Check if the message is unread ?>
                                            <button type="submit" name="read_id" value="<?php echo $submission['id']; ?>" class="btn btn-warning btn-sm">Markeer als gelezen</button>
                                        <?php endif; ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class='fs-5 text-light text-center'>Er zijn momenteel geen openstaande berichten.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.html'; ?>
