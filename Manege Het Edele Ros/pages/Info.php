<!DOCTYPE html>
<html lang="nl">
    <?php include 'head.php'; ?>
<body>
    <!-- Navbar -->
    <?php include 'navbar.html'; ?>

    <!-- Header with Background Image -->
    <header class="bg-dark text-white text-center py-5" style="background-image: url('https://source.unsplash.com/1600x400/?horses'); background-size: cover; background-position: center;">
        <div class="container">
            <h1 class="display-4">Welkom bij Het Edele Ros</h1>
            <p class="lead">Jouw reis naar het beheersen van paardrijden begint hier.</p>
            <a href="#services" class="btn btn-primary-custom mt-3">Ontdek onze diensten</a>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container my-5">

        <!-- About Us Section -->
        <section id="about" class="mb-5">
            <div class="row mt-4">
                <div class="col-md-6">
                    <h3>Onze Doelstelling</h3>
                    <p>Het Edele Ros is een manege die zich richt op het bieden van inclusieve en toegankelijke paardrijlessen voor studenten van alle niveaus, met speciale aandacht voor jongeren met een fysieke beperking. We hebben 13 paarden, waaronder hengsten, ruinen en merries, en een gepassioneerd team van 4 instructeurs.</p>
                </div>
                <div class="col-md-6">
                    <h3>Ons Team</h3>
                    <p>Ons team bestaat uit toegewijde instructeurs die ervoor zorgen dat elke student persoonlijke begeleiding krijgt. De manege wordt geleid door één eigenaar die toezicht houdt op de operaties en een hoge standaard van service waarborgt voor alle studenten.</p>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section id="team" class="mb-5">
    <h3 class="text-center mb-4">Introductie</h3>
    <div class="container">
        <div class="row justify-content-center">
            <!-- Team Member 1: Daniel -->
            <div class="col-12 col-md-2 text-center mb-4">
                <a href="#" data-bs-toggle="modal" data-bs-target="#teamMemberModal" data-name="Daniel" data-role="Instructeur" data-intro="Maak kennis met Daniel, onze innovatieve hoofd-instructeur met een passie voor het creëren van boeiende leerervaringen. Met zijn talent voor het vereenvoudigen van complexe concepten zorgt Daniel ervoor dat elke student met een diep begrip en enthousiasme voor het onderwerp de les verlaat.">
                    <img src="../images/instructeurs/Daniel.png" class="img-fluid rounded-circle team-img" alt="Daniel">
                </a>
                <div class="mt-2">
                    <h5>Daniel</h5>
                    <p>Instructeur</p>
                </div>
            </div>
            <!-- Team Member 2: Maria -->
            <div class="col-12 col-md-2 text-center mb-4">
                <a href="#" data-bs-toggle="modal" data-bs-target="#teamMemberModal" data-name="Maria" data-role="Instructeur" data-intro="Maria brengt een schat aan kennis en een vriendelijke glimlach naar ons team. Haar expertise in praktijkgericht onderwijs en haar toewijding aan het succes van studenten maken haar een onmisbaar onderdeel van onze onderwijsmethodes.">
                    <img src="../images/instructeurs/Maria.png" class="img-fluid rounded-circle team-img" alt="Maria">
                </a>
                <div class="mt-2">
                    <h5>Maria</h5>
                    <p>Instructeur</p>
                </div>
            </div>
            <!-- Team Member 3: Florian -->
            <div class="col-12 col-md-2 text-center mb-4">
                <a href="#" data-bs-toggle="modal" data-bs-target="#teamMemberModal" data-name="Florian" data-role="Eigennaar" data-intro="Florian is de eigenaar van ons instituut en de drijvende kracht achter onze visie. Met zijn strategisch inzicht en passie voor onderwijs zorgt hij ervoor dat alles op rolletjes loopt en dat we voortdurend streven naar uitmuntendheid in ons onderwijs.">
                    <img src="../images/instructeurs/Florian.png" class="img-fluid rounded-circle team-img" alt="Florian">
                </a>
                <div class="mt-2">
                    <h5>Florian</h5>
                    <p>Eigennaar</p>
                </div>
            </div>
            <!-- Team Member 4: Reafon -->
            <div class="col-12 col-md-2 text-center mb-4">
                <a href="#" data-bs-toggle="modal" data-bs-target="#teamMemberModal" data-name="Reafon" data-role="Instructeur" data-intro="Reafon combineert praktische ervaring met een inspirerende lesstijl. Bekend om zijn probleemoplossende vaardigheden en ondersteunende aard, begeleidt hij studenten door uitdagingen met geduld en aanmoediging.">
                    <img src="../images/instructeurs/Reafon.png" class="img-fluid rounded-circle team-img" alt="Reafon">
                </a>
                <div class="mt-2">
                    <h5>Reafon</h5>
                    <p>Instructeur</p>
                </div>
            </div>
            <!-- Team Member 5: Vika -->
            <div class="col-12 col-md-2 text-center mb-4">
                <a href="#" data-bs-toggle="modal" data-bs-target="#teamMemberModal" data-name="Vika" data-role="Instructeur" data-intro="Vika’s creatieve aanpak en dynamische lesmethoden maken leren zowel plezierig als effectief. Haar vermogen om een goede band met studenten op te bouwen en een samenwerkende omgeving te bevorderen, ligt aan de basis van het succes van ons team.">
                    <img src="../images/instructeurs/Vika.png" class="img-fluid rounded-circle team-img" alt="Vika">
                </a>
                <div class="mt-2">
                    <h5>Vika</h5>
                    <p>Instructeur</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for image preview -->
    <div class="modal fade" id="teamMemberModal" tabindex="-1" aria-labelledby="teamMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teamMemberModalLabel">Team Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex">
                    <img src="" id="modalImage" class="img-fluid rounded-circle me-3" alt="Team Member">
                    <div>
                        <h5 id="modalName">Name</h5>
                        <p id="modalRole">Role</p>
                        <p id="modalIntro">Introduction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        <!-- Services Section -->
        <section id="services" class="my-5">
            <h2 class="text-center text-dark-custom">Onze Diensten</h2>
            <div class="row text-center mt-4">
                <div class="col-md-4">
                    <a href="calendar.php" class="icon-link">
                        <i class="bi bi-calendar-week display-1 text-primary-custom"></i>
                    </a>
                    <h4>Lesroosters</h4>
                    <p>Bekijk het actuele rooster van onze paardrijlessen. We bieden lessen op verschillende tijdstippen en dagen om aan jouw behoeften te voldoen.</p>
                </div>
                <div class="col-md-4">
                    <a href="#lessen" class="icon-link">
                        <i class="bi bi-cart-plus display-1 text-primary-custom"></i>
                    </a>
                    <h4>Lessenkopen</h4>
                    <p>Koop eenvoudig lessen via onze website. Kies het pakket dat bij je past en boek je lessen direct online.</p>
                </div>
                <div class="col-md-4">
                    <a href="paarden.php" class="icon-link">
                        <i class="bi bi-hand-index-thumb display-1 text-primary-custom"></i>
                    </a>
                    <h4>Onze Paarden</h4>
                    <p>Maak kennis met onze prachtige paarden. Klik hier om meer te leren over de dieren waarmee je tijdens je lessen werkt.</p>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section id="cta" class="text-center">
            <div class="container-fluid">
                <h2>Word Vandaag Lid</h2>
                <p>Klaar om te beginnen met je paardrijreis of wil je meer informatie? Schrijf je nu in of vraag meer informatie aan.</p>
                <a href="inschrijf_formulier.php" class="btn btn-primary-custom btn-lg">Schrijf je nu in</a>
            </div>
        </section>  


    </div>

    <!-- Custom JavaScript for modal image source -->
    <script>
    var teamMemberModal = document.getElementById('teamMemberModal');
    teamMemberModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var imageUrl = button.querySelector('img').src;
        var name = button.getAttribute('data-name');
        var role = button.getAttribute('data-role');
        var intro = button.getAttribute('data-intro');
        
        var modalImage = document.getElementById('modalImage');
        var modalName = document.getElementById('modalName');
        var modalRole = document.getElementById('modalRole');
        var modalIntro = document.getElementById('modalIntro');
        
        modalImage.src = imageUrl;
        modalName.textContent = name;
        modalRole.textContent = role;
        modalIntro.textContent = intro;
    });
</script>

    <!-- Footer -->
    <?php include 'footer.html'; ?>
</body>

</html>