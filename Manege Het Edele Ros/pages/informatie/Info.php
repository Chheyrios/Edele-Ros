<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manege Edele Ros</title>
    <?php include 'head.php'; ?>
    <style>
        .card-custom {
            margin-bottom: 20px;
            border: 1px solid #212529; /* Adding a border with the specified color */
            border-radius: 0.25rem; /* Optional: Adds rounded corners */
            transition: box-shadow 0.2s ease; /* Optional: Add a transition effect */
        }

        .card-custom:hover {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2); /* Optional: Add shadow on hover */
        }

        .submission-details {
            width: 50%; 
        }

        .submission-message {
            width: 50%; 
        }

        .submission-date {
            text-align: center;
            margin-top: 10px;
            font-size: 0.9em;
            color: #b0b0b0;
        }

        .btn {
            margin: 5px; /* Adding a small margin around buttons */
        }

        .submission-container {
            display: flex; /* Display submissions in a row */
            flex-direction: column; /* Column layout */
        }

        @media (min-width: 768px) {
            .submission-container {
                flex-direction: row; /* Switch to row layout on larger screens */
                flex-wrap: wrap; /* Allow wrapping of cards */
            }

            .submission-details, .submission-message {
                flex: 1; /* Allow details and message to take equal space */
                padding: 10px; /* Padding inside each section */
            }
        }
    </style>
</head>

<?php include 'navbar.html'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4 text-light text-center">Alle contact opnames</h2>

            <!-- Toggle Button -->
            <form method="post" class="mb-3 text-center">
                <button type="submit" name="toggle_read" class="btn btn-primary-custom">
                    <?php echo $_SESSION['show_read'] ? 'Toon Ongelezen Berichten' : 'Toon Gelezen Berichten'; ?>
                </button>
            </form>

            <div class="submission-container">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($submission = $result->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="card card-custom bg-light text-dark">
                                <div class="card-body d-flex">
                                    <div class="submission-details">
                                        <strong><?php echo htmlspecialchars($submission['name']); ?></strong><br>
                                        E-mail: <a href="mailto:<?php echo htmlspecialchars($submission['email']); ?>" class="text-dark"><?php echo htmlspecialchars($submission['email']); ?></a><br>
                                        Telefoon: <a href="tel:<?php echo htmlspecialchars($submission['phone']); ?>" class="text-dark"><?php echo htmlspecialchars($submission['phone']); ?></a>
                                    </div>
                                    <div class="submission-message">
                                        <p><?php echo nl2br(htmlspecialchars($submission['message'])); ?></p>
                                    </div>
                                </div>
                                <div class="submission-date">
                                    <small>Ingediend op: <?php echo $submission['submitted_at']; ?></small>
                                </div>
                                <div class="mt-2 text-right">
                                    <form method="post">
                                        <button type="submit" name="delete_id" value="<?php echo $submission['id']; ?>" class="btn btn-danger btn-sm">Verwijderen</button>
                                        <button type="submit" name="read_id" value="<?php echo $submission['id']; ?>" class="btn btn-warning btn-sm">Markeer als gelezen</button>
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
</body>
</html>
