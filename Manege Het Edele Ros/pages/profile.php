<?php
// Start session at the very beginning, before any output
session_start();

// Check if the user is logged in by verifying the session variable
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit();
}

// Include the head and database connection
include 'head.php';
include 'db_connect.php';
?>

<body>
<?php include 'navbar.html'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Picture Section -->
            <div class="text-center">
                <?php
                $gebruiker_id = $_SESSION['gebruiker_id'];
                $sql = "SELECT profielfoto FROM gebruikers WHERE gebruiker_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $gebruiker_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                $profilePic = $user['profielfoto'] ? 'uploads/profile_pics/' . $user['profielfoto'] : 'path_to_default_profile_pic.jpg';
                ?>
                <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" class="img-thumbnail" style="width: 200px; height: 200px;">
                <form action="profile_update_delete/upload_profile_pic.php" method="POST" enctype="multipart/form-data">
                    <div class="mt-3">
                        <label for="profilePic" class="form-label">Upload Profile Picture</label>
                        <input class="form-control" type="file" id="profilePic" name="profilePic" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Upload</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <h2>Your Profile</h2>

            <?php
            // Fetch the user's profile data
            $sql = "SELECT naam, email, adres, telefoonnummer, geboortedatum, gebruikersrol FROM gebruikers WHERE gebruiker_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $gebruiker_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
            ?>

            <form action="profile_update_delete/update_profile.php" method="POST">
                <div class="mb-3 mt-4">
                    <label for="naam" class="form-label">Name</label>
                    <input type="text" class="form-control" id="naam" name="naam" value="<?php echo htmlspecialchars($user['naam']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="adres" class="form-label">Address</label>
                    <input type="text" class="form-control" id="adres" name="adres" value="<?php echo htmlspecialchars($user['adres']); ?>">
                </div>
                <div class="mb-3">
                    <label for="telefoonnummer" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="telefoonnummer" name="telefoonnummer" value="<?php echo htmlspecialchars($user['telefoonnummer']); ?>">
                </div>
                <div class="mb-3">
                    <label for="geboortedatum" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="geboortedatum" name="geboortedatum" value="<?php echo htmlspecialchars($user['geboortedatum']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="gebruikersrol" class="form-label">Role</label>
                    <input type="text" class="form-control" id="gebruikersrol" name="gebruikersrol" value="<?php echo htmlspecialchars($user['gebruikersrol']); ?>" disabled>
                </div>

                <?php
                // Display upload success/error messages
                if (isset($_GET['upload'])) {
                    if ($_GET['upload'] === 'success') {
                        echo '<div class="alert alert-success" role="alert">Profile picture updated successfully!</div>';
                    } elseif ($_GET['upload'] === 'error') {
                        echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['message']) . '</div>';
                    }
                }
                ?>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Update Profile</button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProfileModal">Delete Profile</button>
                </div>
            </form>

            <?php
            } else {
                echo "<p>No user found.</p>";
            }
            ?>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteProfileModal" tabindex="-1" aria-labelledby="deleteProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteProfileModalLabel">Delete Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete your profile? This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete Profile</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.html'; ?>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const confirmDeleteButton = document.getElementById('confirmDelete');

    confirmDeleteButton.addEventListener('click', function () {
        // Send AJAX request to delete_profile.php
        fetch('profile_update_delete/delete_profile.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'delete_profile'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'home.php';
            } else {
                alert('Error deleting profile. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });
});
</script>
</body>
</html>
