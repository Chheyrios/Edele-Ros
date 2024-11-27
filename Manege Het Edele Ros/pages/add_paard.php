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

// Handle form submission for adding a new horse
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form inputs
    $naam = mysqli_real_escape_string($conn, $_POST['naam']);
    $geslacht = mysqli_real_escape_string($conn, $_POST['geslacht']);
    $tamheid = mysqli_real_escape_string($conn, $_POST['tamheid']);

    // Handle the uploaded image file
    if (isset($_FILES['afbeelding']) && $_FILES['afbeelding']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../images/paarden/"; // Directory to save uploaded images
        $target_file = $target_dir . basename($_FILES["afbeelding"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES["afbeelding"]["tmp_name"]);
        if ($check === false) {
            echo "<p class='text-danger'>Het bestand is geen afbeelding.</p>";
        } else {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["afbeelding"]["tmp_name"], $target_file)) {
                // Insert horse details into the database
                $query = "INSERT INTO paarden (naam, geslacht, tamheid, afbeelding) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('ssss', $naam, $geslacht, $tamheid, $target_file);

                if ($stmt->execute()) {
                    $_SESSION['success_message'] = "Paard succesvol toegevoegd!";
                    
                    header("Location: paarden_overzicht.php");
                    exit();
                }
                 else {
                    echo "<p class='text-danger'>Er is iets misgegaan bij het toevoegen van het paard.</p>";
                }
            } else {
                echo "<p class='text-danger'>Er was een fout bij het uploaden van de afbeelding.</p>";
            }
        }
    } else {
        echo "<p class='text-danger'>Geen afbeelding geselecteerd of er was een fout bij het uploaden.</p>";
    }
}

include 'head.php'; 
include 'navbar.html'; 
?>

<div class="container my-5">
    <div class="card bg-dark border-dark text-light">
        <div class="card-header">
            <h2 class="my-2">Nieuw paard toevoegen</h2>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group mb-3"> <!-- Added margin bottom -->
                    <label for="naam">Naam:</label>
                    <input type="text" class="form-control" name="naam" required>
                </div>

                <div class="form-group mb-3"> <!-- Added margin bottom -->
                    <label for="geslacht">Geslacht:</label>
                    <select class="form-control" name="geslacht" required>
                        <option value="hengst">Hengst</option>
                        <option value="ruin">Ruin</option>
                        <option value="merrie">Merrie</option>
                    </select>
                </div>

                <div class="form-group mb-3"> <!-- Added margin bottom -->
                    <label for="tamheid">Tamheid:</label>
                    <select class="form-control" name="tamheid" required>
                        <option value="wild">Wild</option>
                        <option value="gemiddeld">Gemiddeld</option>
                        <option value="tam">Tam</option>
                    </select>
                </div>

                <div class="form-group mb-3"> <!-- Added margin bottom -->
                    <label for="afbeelding">Afbeelding:</label>
                    <input type="file" class="form-control-file" name="afbeelding" required>
                </div>

                <button type="submit" class="btn btn-success">Toevoegen</button>
                <a href="paarden_overzicht.php" class="btn btn-secondary">Annuleren</a>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.html'; ?>
