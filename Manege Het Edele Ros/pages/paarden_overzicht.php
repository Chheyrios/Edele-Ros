<?php
session_start();
include 'db_connect.php'; 

// Check if the user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit();
}

$gebruiker_id = $_SESSION['gebruiker_id'];

// Fetch the user's role
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

include 'head.php'; 
include 'navbar.html'; 

// Query to fetch horse data from the database
$query = "SELECT paard_id, naam, geslacht, tamheid, afbeelding FROM paarden";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
?>

<div class="container">

    <div class="row">
        <div class="col-md-12 my-3">
            <h2 class="text-dark mt-4 mb-4 text-center">Paarden Overzicht</h2>
        </div>

        <?php 
        if (isset($_SESSION['success_message'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
            // Unset the session variable after displaying the message
            unset($_SESSION['success_message']);
        }
    
    ?>
    </div>

    <div class="row">
        <?php 
        // Loop through each horse record
        while($row = mysqli_fetch_assoc($result)) { 
        ?>
        <div class="col-md-4">
            <div class="card bg-dark border-dark text-light mb-4">
                <img src="<?php echo $row['afbeelding']; ?>" class="card-img-top" alt="<?php echo $row['naam']; ?>">
                <div class="card-body">
                    <h5 class="card-title text-light"><?php echo $row['naam']; ?></h5>
                    <p class="card-text"><strong>Geslacht:</strong> <?php echo $row['geslacht']; ?></p>
                    <p class="card-text"><strong>Tamheid:</strong> <?php echo $row['tamheid']; ?></p>

                    <!-- Edit and Delete buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="edit_paard.php?id=<?php echo $row['paard_id']; ?>" class="btn" style="background-color: #52528C; color: white;">Aanpassen</a>
                        <a href="delete_paard.php?id=<?php echo $row['paard_id']; ?>" class="btn" style="background-color: #372554; color: white;" onclick="return confirm('Weet je zeker dat je dit paard wil verwijderen?');">Verwijderen</a>
                    </div>
                </div>
            </div>
        </div>
        <?php 
        } // End of while loop 
        ?>
    </div>

    <!-- Button to add a new horse -->
    <div class="row">
        <div class="col-12 text-right my-3">
            <a href="add_paard.php" class="btn" style="background-color: #52528C; color: white;">Voeg een nieuw paard toe</a>
        </div>
    </div>
</div>

<?php 
} else {
    echo "<p class='text-light'>Geen paarden gevonden in de database.</p>";
}
?>

<?php include 'footer.html'; ?>
