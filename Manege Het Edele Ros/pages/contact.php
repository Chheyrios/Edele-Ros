<?php 
session_start(); 
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    $insertSql = "INSERT INTO contact_submissions (name, email, phone, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ssss", $name, $email, $phone, $message);
    $stmt->execute();
    $stmt->close();

    header("Location: home.php"); 
    exit();
}

include 'head.php'; 
include 'navbar.html'; 
?>

<div class="container content mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6 text-center">
      <div class="card border-0 shadow-sm p-4 mob">
        <h2 class="mb-4 text-light">Contact</h2>
        <p class="fs-5 text-light mb-1">Telefoon nummer: <a href="tel:0612345678" class="text-light">06 12345678</a></p>
        <p class="fs-5 text-light">Email adress: <a href="mailto:HetEdeleRos@gmail.com" class="text-light">HetEdeleRos@gmail.com</a></p>
      </div>

      <!-- Google Maps Display in a Card -->
      <div class="card border-0 shadow-sm p-4 mob mt-4">
        <h3 class="text-light">Onze locatie</h3>
        <div id="map" class="map-responsive" style="height: 450px;"></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card border-0 shadow-sm p-4 mob">
        <h2 class="mb-4 text-light text-center">Contact formulier</h2>
        <form action="contact.php" method="post">
          <div class="mb-3">
            <label for="name" class="form-label text-light">Naam</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label text-light">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label text-light">Telefoon</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label text-light">Bericht</label>
            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Verstuur</button>
        </form>
      </div>
    </div>
  </div>
  
  <div class="mt-5"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-LsL1IqxlqDXT3G2foV2iI494OgTYNS8&callback=initMap" async defer></script>
<script src="../Javascript/google_maps.js"></script>

<?php include 'footer.html'; ?>
