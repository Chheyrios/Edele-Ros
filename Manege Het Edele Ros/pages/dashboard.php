<?php
// Start de sessie
session_start();

// Controleer of de gebruiker is ingelogd en of hij/zij eigenaar is
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'eigenaar') {
    // Als de gebruiker geen eigenaar is, redirect naar de homepagina of een andere pagina
    header("Location: home.php");
    exit();
}

// Verbind met de database
include 'db_connect.php';
include 'head.php';
?>

<body>

<?php include 'navbar.html'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Welkom op het Dashboard van de Eigenaar!</h1>
            <p class="text-center">Hier kun je alle belangrijke informatie beheren en inzien.</p>
        </div>
    </div>

    <!-- Voorbeeld van dashboard secties -->
    <div class="row mt-4">
        <!-- Inschrijvingen beheren -->
        <div class="col-md-4 d-flex mb-5">
            <div class="card h-100 w-100">
                <div class="card-header">
                    Inschrijvingen Beheren
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="flex-grow-1">Bekijk en beheer alle inschrijvingen voor de manege.</p>
                    <a href="inschrijvingen.php" class="btn btn-primary mt-auto">Bekijk Inschrijvingen</a>
                </div>
            </div>
        </div>

        <!-- Mededelingen plaatsen -->
        <div class="col-md-4 d-flex mb-5">
            <div class="card h-100 w-100">
                <div class="card-header">
                    Mededelingen Plaatsen
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="flex-grow-1">Plaats nieuwe mededelingen voor klanten en instructeurs.</p>
                    <a href="mededelingen.php" class="btn btn-primary mt-auto">Mededelingen Plaatsen</a>
                </div>
            </div>
        </div>

         <!-- Paarden overzicht -->
         <div class="col-md-4 d-flex mb-5">
            <div class="card h-100 w-100">
                <div class="card-header">
                    Overzicht van Paarden
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="flex-grow-1">Bekijk een volledig overzicht van alle paarden in de manege.</p>
                    <a href="paarden_overzicht.php" class="btn btn-info mt-auto">Bekijk Paarden</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Nieuwe Gebruiker Registreren Kaart -->
    <div class="row mt-4">
        <div class="col-md-4 d-flex mb-5">
            <div class="card h-100 w-100">
                <div class="card-header">
                    Nieuwe Gebruiker Registreren
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="flex-grow-1">Registreer een nieuwe gebruiker als leerling of instructeur.</p>
                    <!-- Knop om de modal te openen -->
                    <button type="button" class="btn btn-primary mt-auto" data-bs-toggle="modal" data-bs-target="#registerUserModal">
                        Registreer Gebruiker
                    </button>
                </div>
            </div>
        </div>

            <!-- New Card: Lesrooster Bekijken -->
        <div class="col-md-4 d-flex mb-5">
            <div class="card h-100 w-100">
                <div class="card-header">
                    Lesrooster Bekijken
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="flex-grow-1">Bekijk de lesroosters in de kalender.</p>
                    <a href="calendar.php" class="btn btn-primary mt-auto">Bekijk Kalender</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 d-flex mb-5">
            <div class="card h-100 w-100">
                <div class="card-header">
                    Les toevoegen
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="flex-grow-1">Bekijk de lesroosters in de kalender.</p>
                    <a href="les_invoer.php" class="btn btn-primary mt-auto">Voeg lessen toe</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 d-flex mb-5">
            <div class="card h-100 w-100">
                <div class="card-header">
                    Contact inzendingen bekijken
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="flex-grow-1">Bekijk ingezonden contact formulieren</p>
                    <a href="admissions.php" class="btn btn-primary mt-auto">Bekijk inzendingen</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 d-flex mb-5">
            <div class="card h-100 w-100">
                <div class="card-header">
                    Gebruikers Beheren
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="flex-grow-1">Bekijk en beheer alle gebruikers in het systeem.</p>
                    <a href="user_management.php" class="btn btn-primary mt-auto">Bekijk Gebruikers</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal voor Gebruiker Registreren -->
<div class="modal fade" id="registerUserModal" tabindex="-1" aria-labelledby="registerUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="registerUserModalLabel">Nieuwe Gebruiker Registreren</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerUserForm" method="POST" action="register_user.php">
                    <div class="mb-3">
                        <label for="naam" class="form-label">Naam</label>
                        <input type="text" class="form-control" id="naam" name="naam" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="wachtwoord" class="form-label">Wachtwoord</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
                            <span class="input-group-text">
                                <i class="bi bi-eye-slash" id="toggleRegisterPassword"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="gebruikersrol" class="form-label">Gebruikersrol</label>
                        <select class="form-select" id="gebruikersrol" name="gebruikersrol" required>
                            <option value="leerling">Leerling</option>
                            <option value="instructeur">Instructeur</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
                        <button type="submit" class="btn btn-primary">Registreer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.html'; ?>

<!-- Script for handling password visibility toggle -->
<script src="../Javascript/togglepassword.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleRegisterPassword = document.querySelector("#toggleRegisterPassword");
    const registerPasswordField = document.querySelector("#wachtwoord");

    toggleRegisterPassword.addEventListener("click", function () {
        const type = registerPasswordField.getAttribute("type") === "password" ? "text" : "password";
        registerPasswordField.setAttribute("type", type);
        this.classList.toggle("bi-eye");
    });
    
    // Handle form submission via AJAX
    document.getElementById('registerUserForm').addEventListener('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        fetch('login/registreer.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                var registerModal = new bootstrap.Modal(document.getElementById('registerUserModal'));
                registerModal.hide();
                location.reload();  // Refresh page to reflect changes
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>

</body>
</html>
