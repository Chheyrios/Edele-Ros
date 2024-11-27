<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_role']) || !isset($_SESSION['gebruiker_id'])) {
    echo '<p>Please log in to view this page.</p>';
    exit; // Stop further script execution if not logged in
}

// Get user ID and role from session
$userId = $_SESSION['gebruiker_id'];
$userRole = $_SESSION['user_role'];

?>

<!DOCTYPE html>
<html lang="en">
    <?php include 'head.php'; ?>
<body>

    <?php include 'navbar.html'; ?>

    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col text-center">
                <?php
                    // Calculate the start and end dates for the current week
                    $currentDate = isset($_GET['week']) ? $_GET['week'] : date('Y-m-d');
                    $startOfWeek = date('Y-m-d', strtotime('monday this week', strtotime($currentDate)));
                    $endOfWeek = date('Y-m-d', strtotime('sunday this week', strtotime($currentDate)));

                    // Calculate the next and previous weeks
                    $previousWeek = date('Y-m-d', strtotime('-1 week', strtotime($startOfWeek)));
                    $nextWeek = date('Y-m-d', strtotime('+1 week', strtotime($startOfWeek)));
                ?>

                <!-- Previous Week Arrow -->
                <a href="?week=<?php echo $previousWeek; ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                </a>

                <!-- Display the Week Range -->
                <span class="mx-4"><strong>Week: <?php echo date('d M', strtotime($startOfWeek)); ?> - <?php echo date('d M', strtotime($endOfWeek)); ?></strong></span>

                <!-- Next Week Arrow -->
                <a href="?week=<?php echo $nextWeek; ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="row">
            <?php
                // Initialize the SQL statement variable
                $stmt = null;

                // Create SQL query based on user role
                if ($userRole === 'eigenaar') {
                    // Owner sees all lessons
                    $sql = "SELECT l.les_id, l.datum, l.tijd, l.lesdoel, l.opmerking, l.status, l.annuleringsreden, 
                                   g.naam as leerling_naam, i.naam as instructeur_naam, p.naam as paard_naam
                            FROM lessen l
                            JOIN gebruikers g ON l.leerling_id = g.gebruiker_id
                            JOIN gebruikers i ON l.instructeur_id = i.gebruiker_id
                            JOIN paarden p ON l.paard_id = p.paard_id
                            WHERE l.datum BETWEEN ? AND ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ss', $startOfWeek, $endOfWeek);
                } else if ($userRole === 'instructeur') {
                    // Instructor sees only their own lessons
                    $sql = "SELECT l.les_id, l.datum, l.tijd, l.lesdoel, l.opmerking, l.status, l.annuleringsreden, 
                                   g.naam as leerling_naam, i.naam as instructeur_naam, p.naam as paard_naam
                            FROM lessen l
                            JOIN gebruikers g ON l.leerling_id = g.gebruiker_id
                            JOIN gebruikers i ON l.instructeur_id = i.gebruiker_id
                            JOIN paarden p ON l.paard_id = p.paard_id
                            WHERE l.instructeur_id = ? AND l.datum BETWEEN ? AND ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('iss', $userId, $startOfWeek, $endOfWeek);
                } else if ($userRole === 'leerling') {
                    // Student sees only their own lessons
                    $sql = "SELECT l.les_id, l.datum, l.tijd, l.lesdoel, l.opmerking, l.status, l.annuleringsreden, 
                                   g.naam as leerling_naam, i.naam as instructeur_naam, p.naam as paard_naam
                            FROM lessen l
                            JOIN gebruikers g ON l.leerling_id = g.gebruiker_id
                            JOIN gebruikers i ON l.instructeur_id = i.gebruiker_id
                            JOIN paarden p ON l.paard_id = p.paard_id
                            WHERE l.leerling_id = ? AND l.datum BETWEEN ? AND ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('iss', $userId, $startOfWeek, $endOfWeek);
                }

                // Check if $stmt was successfully prepared
                if ($stmt === false) {
                    die('Prepare failed: ' . htmlspecialchars($conn->error)); // Handle prepare error
                }

                // Execute the query
                $stmt->execute();
                $result = $stmt->get_result();

                // Get current date and time for comparison
                $currentDateTime = date('Y-m-d H:i:s');

                // Check if there are lessons and display them in cards
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Check if the lesson has already passed and is not canceled
                        if ($row['status'] !== 'geannuleerd' && $row['datum'] < date('Y-m-d') || 
                            ($row['datum'] === date('Y-m-d') && $row['tijd'] < date('H:i:s'))) {
                            // Update the status to "gevolgd"
                            $row['status'] = 'gevolgd';
                        }

                        echo '<div class="col-md-4 d-flex mb-4">';
                        echo '  <div class="card w-100 shadow-sm" style="min-height: 250px;">';
                        echo '      <div class="card-header text-center p-2">';
                        echo '          <strong>' . htmlspecialchars($row['lesdoel']) . '</strong>';
                        echo '      </div>';
                        echo '      <div class="card-body text-center p-2">';
                        echo '          <p class="mb-1"><strong>Datum:</strong> ' . htmlspecialchars($row['datum']) . '</p>';
                        echo '          <p class="mb-1"><strong>Tijd:</strong> ' . htmlspecialchars($row['tijd']) . '</p>';
                        echo '          <p class="mb-1"><strong>Leerling:</strong> ' . htmlspecialchars($row['leerling_naam']) . '</p>';
                        echo '          <p class="mb-1"><strong>Instructeur:</strong> ' . htmlspecialchars($row['instructeur_naam']) . '</p>';
                        echo '          <p class="mb-1"><strong>Paard:</strong> ' . htmlspecialchars($row['paard_naam']) . '</p>';
                        echo '          <p class="mb-1"><strong>Status:</strong> ' . htmlspecialchars($row['status']) . '</p>';

                        // If the lesson is canceled, show the cancellation reason
                        if ($row['status'] === 'geannuleerd' && !empty($row['annuleringsreden'])) {
                            echo '          <p class="mb-1 text-danger"><strong>Annuleringsreden:</strong> ' . htmlspecialchars($row['annuleringsreden']) . '</p>';
                        }

                        echo '          <p class="mb-1"><strong>Opmerking:</strong> ' . htmlspecialchars($row['opmerking']) . '</p>';

                        echo '      </div>';

                        // Show Afmelden button only if the lesson is not canceled
                        if ($row['status'] !== 'geannuleerd') {
                            echo '      <div class="card-footer text-center p-2">';
                            echo '          <button class="btn btn-danger btn-sm afmelden-btn" data-lesson-id="' . $row['les_id'] . '" data-bs-toggle="modal" data-bs-target="#cancelLessonModal">Afmelden</button>';
                            echo '      </div>';
                        }

                        echo '  </div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col text-center">';
                    echo '<p class="text-center">Geen lessen gevonden voor deze week.</p>';
                    echo '</div>';
                }

                // Close the statement
                $stmt->close();
                $conn->close();
            ?>
        </div>
    </div>

    <!-- Modal for Canceling Lessons -->
    <div class="modal fade" id="cancelLessonModal" tabindex="-1" aria-labelledby="cancelLessonModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-white" id="cancelLessonModalLabel">Afmelden Reden</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Geef een reden voor het afmelden van de les:</p>
            <textarea id="cancelReason" class="form-control" rows="3" placeholder="Typ hier je reden..."></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
            <button type="button" class="btn btn-danger" id="confirmCancelBtn">Bevestigen</button>
          </div>
        </div>
      </div>
    </div>

    <script>
        let lessonIdToCancel;

        // Handle Afmelden button click
        $('.afmelden-btn').click(function() {
            lessonIdToCancel = $(this).data('lesson-id');
            $('#cancelLessonModal').modal('show');
        });

        // Handle confirm button in the modal
        $('#confirmCancelBtn').click(function() {
            var cancelReason = $('#cancelReason').val(); // Get the reason from the textarea

            // Send the AJAX request to afmelden.php to cancel the lesson with a reason
            $.ajax({
                url: 'afmelden.php',
                type: 'POST',
                data: { lesson_id: lessonIdToCancel, reason: cancelReason },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        location.reload(); // Refresh the page to show updated status
                    } else {
                        console.error('Afmelding mislukt: ' + data.message);
                    }
                },
                error: function() {
                    console.error('Er is een fout opgetreden bij het afmelden van de les.');
                }
            });

            // Hide the modal
            $('#cancelLessonModal').modal('hide');
        });
    </script>

    <?php include 'footer.html'; ?>

</body>
</html>
