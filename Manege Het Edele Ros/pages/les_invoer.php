<?php
session_start();
include 'db_connect.php'; 

// Assuming gebruiker_id is stored in the session
if (!isset($_SESSION['gebruiker_id'])) {
    // If no gebruiker_id is in the session, redirect to login page
    header("Location: home.php");
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

if ($user === null || ($user['gebruikersrol'] !== 'eigenaar' && $user['gebruikersrol'] !== 'instructeur')) {
    // If the user doesn't exist or isn't an 'eigenaar' or 'instructeur', redirect them
    header("Location: home.php");
    exit();
}

// Handle form submission
$message = ""; // Initialize a variable to store the message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $instructeur_id = $_POST['instructeur_id'];
    $paard_id = $_POST['paard_id'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $lesdoel = $_POST['lesdoel'];
    $opmerking = $_POST['opmerking'];
    $status = 'pending'; 

    // Collect learner IDs, ensuring at least 1 learner is selected
    $leerling_id_1 = !empty($_POST['leerling_id_1']) ? $_POST['leerling_id_1'] : null;
    $leerling_id_2 = !empty($_POST['leerling_id_2']) ? $_POST['leerling_id_2'] : null;
    $leerling_id_3 = !empty($_POST['leerling_id_3']) ? $_POST['leerling_id_3'] : null;

    if ($leerling_id_1) {
        // Insert for the required learner
        $sql = "INSERT INTO lessen (leerling_id, instructeur_id, paard_id, datum, tijd, lesdoel, opmerking, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiisssss", $leerling_id_1, $instructeur_id, $paard_id, $datum, $tijd, $lesdoel, $opmerking, $status);

        if ($stmt->execute()) {
            // Redirect to calendar.php after successful insertion
            header("Location: calendar.php");
            exit(); // Stop further execution after redirection
        } else {
            $message = "<div class='alert alert-danger'>Fout: " . $stmt->error . "</div>";
        }

        // Optionally insert for the second learner if provided
        if ($leerling_id_2) {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiisssss", $leerling_id_2, $instructeur_id, $paard_id, $datum, $tijd, $lesdoel, $opmerking, $status);
            if ($stmt->execute()) {
                // Redirect to calendar.php after successful insertion
                header("Location: calendar.php");
                exit(); // Stop further execution after redirection
            } else {
                $message .= "<div class='alert alert-danger'>Fout bij Leerling 2: " . $stmt->error . "</div>";
            }
        }

        // Optionally insert for the third learner if provided
        if ($leerling_id_3) {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiisssss", $leerling_id_3, $instructeur_id, $paard_id, $datum, $tijd, $lesdoel, $opmerking, $status);
            if ($stmt->execute()) {
                // Redirect to calendar.php after successful insertion
                header("Location: calendar.php");
                exit(); // Stop further execution after redirection
            } else {
                $message .= "<div class='alert alert-danger'>Fout bij Leerling 3: " . $stmt->error . "</div>";
            }
        }
        $stmt->close(); // Close the statement
    } else {
        $message = "<div class='alert alert-danger'>Selecteer minimaal één leerling.</div>";
    }
}

// Fetch instructeurs and paarden for dropdowns 
$instructeurs = $conn->query("SELECT * FROM gebruikers WHERE gebruikersrol = 'instructeur'");
$paarden = $conn->query("SELECT * FROM paarden");

// Fetch leerlingen for multi-select dropdown 
$leerlingen = $conn->query("SELECT * FROM gebruikers WHERE gebruikersrol = 'leerling'");
?>

<!DOCTYPE html>
<html lang="en">
    <?php include 'head.php'; ?>
<body>
    <?php include 'navbar.html'; ?>

    <div class="container mt-5">
        <form method="post" action="" class="bg-dark text-white p-4 rounded">
        <h1 class="mb-4">Nieuwe Les</h1>
            <div class="form-group mb-3">
                <label for="instructeur_id">Instructeur:</label>
                <select class="form-control" name="instructeur_id" required>
                    <option value="">Selecteer instructeur</option>
                    <?php while ($row = $instructeurs->fetch_assoc()): ?>
                        <option value="<?php echo $row['gebruiker_id']; ?>"><?php echo $row['naam']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="paard_id">Paard:</label>
                <select class="form-control" name="paard_id" required>
                    <option value="">Selecteer paard</option>
                    <?php while ($row = $paarden->fetch_assoc()): ?>
                        <option value="<?php echo $row['paard_id']; ?>"><?php echo $row['naam']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- First Learner (Required) -->
            <div class="form-group mb-3">
                <label for="leerling_id_1">Leerling:</label>
                <select class="form-control" name="leerling_id_1" required>
                    <option value="">Selecteer leerling</option>
                    <?php while ($row = $leerlingen->fetch_assoc()): ?>
                        <option value="<?php echo $row['gebruiker_id']; ?>"><?php echo $row['naam']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="datum">Datum:</label>
                <input type="date" class="form-control" name="datum" required>
            </div>

            <div class="form-group mb-3">
                <label for="tijd">Tijd:</label>
                <select class="form-control" name="tijd" required>
                    <?php
                    // Generate time slots every 3 hours starting from 06:00 to 18:00
                    $start_time = strtotime('06:00');
                    $end_time = strtotime('18:00');

                    for ($time = $start_time; $time <= $end_time; $time += 3 * 3600) {
                        echo '<option value="' . date('H:i', $time) . '">' . date('H:i', $time) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="lesdoel">Lesdoel:</label>
                <input type="text" class="form-control" name="lesdoel" required>
            </div>

            <div class="form-group mb-3">
                <label for="opmerking">Opmerking:</label>
                <textarea class="form-control" name="opmerking"></textarea>
            </div>

            <button type="submit" class="btn" style="background-color: #52528C; color: white;">Toevoegen</button>
        </form>
        </br>
    </div>

    <?php include 'footer.html'; ?>

</body>
</html>
