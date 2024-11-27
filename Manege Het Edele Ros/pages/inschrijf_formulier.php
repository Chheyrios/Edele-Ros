<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
    <?php include 'head.php'; ?>
<body>

    <?php include 'navbar.html'; ?>


    <div class="container d-flex justify-content-center align-items-center">
        <div class="col-md-6">
            <h2 class="text-center mb-5 mt-5">Inschrijfformulier voor Paardrijlessen</h2>
            <form action="inschrijvingen/verwerk_inschrijving.php" method="post">
                <div class="form-group mb-3">
                    <label for="naam">Volledige naam:</label>
                    <input type="text" id="naam" name="naam" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">E-mailadres:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="telefoon">Telefoonnummer:</label>
                    <input type="tel" id="telefoon" name="telefoon" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="geboortedatum">Geboortedatum:</label>
                    <input type="date" id="geboortedatum" name="geboortedatum" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="adres">Postcode</label>
                    <input type="text" id="postcode" name="postcode" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="adres">Straat</label>
                    <input type="text" id="straat" name="straat" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="adres">Stad</label>
                    <input type="text" id="stad" name="stad" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="opmerkingen">Opmerkingen of speciale verzoeken:</label>
                    <textarea id="opmerkingen" name="opmerkingen" class="form-control" rows="4"></textarea>
                </div>

                <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['success_message']; ?>
                </div>
                <?php unset($_SESSION['success_message']); // Verwijder het bericht na weergave ?>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary-custom btn-block mb-5">Verstuur Inschrijving</button>
            </form>
        </div>
    </div>
    <?php include 'footer.html'; ?>
</body>
</html>
