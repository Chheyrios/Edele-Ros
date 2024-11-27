<?php
include 'db_connect.php'; 
include 'head.php'; 
include 'navbar.html'; 

// Query to fetch horse data from the database
$query = "SELECT paard_id, naam, geslacht, tamheid, afbeelding FROM paarden";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
?>

<div class="container">
        <div class="alert alert-info mt-4" role="alert">
            Dit is een lijst van onze paarden. Voor meer informatie over welke beschikbaar zijn voor lessen, neem contact met ons op.
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
                </div>
            </div>
        </div>
        <?php 
        }  
        ?>
    </div>
</div>

<?php 
} else {
    echo "<p class='text-light'>Geen paarden gevonden in de database.</p>";
}
?>

<?php include 'footer.html'; ?>
