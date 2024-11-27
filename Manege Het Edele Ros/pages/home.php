<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
    <?php include 'head.php'; ?>
<body>

    <?php include 'navbar.html'; ?>

    <div class="container-fluid header-img mb-5">
        <div class="container"> 
            <div class="row" style="font-size: 50px;">
                <div class="col-12 mt-5 ">
                <h1 class="fw-bold">Manege </h1>
                <h1 class="fw-bold">het Edele Ros </h1>
                </div>
            </div>
        </div>
    </div>


    <section id="over ons">
        <div class="header">
            <div class="container p-5 text-lg-start text-center">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md">
                        <img src="../Images/paard.png" class="img-fluid rounded col-md-12" alt="">
                    </div>

                    <div class="col-md text-dark mt-5 p-5">
                        <h1 class="fw-bold">Over ons</h1>
                        <p class="mt-4">
                        Bij "Het Edele Ros" combineren we passie voor paardrijden met inclusiviteit. Onze manege biedt toegankelijke lessen voor iedereen, inclusief jongeren met een fysieke beperking. Op onze gebruiksvriendelijke website vind je snel alle informatie over lessen, instructeurs en onze diensten, met een speciale focus op eenvoudige navigatie en toegankelijkheid.
                        </p>
                        <a href="inschrijf_formulier.php" class="fw-bold btn-primary-custom text-white mob btn mt-5 px-5 py-3">
                        Schrijf je in!
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="p-5 mt-5 violet">
    <div class="container text-lg-start text-center">
        <div class="row justify-content-center justify-content-md-around"> <!-- Center and space evenly -->
            <div class="col-md-3 mb-4 mt-3">
                <div class="card border-0 text-dark">
                    <div class="card-body rounded text-dark">
                        <img class="mb-4" src="img/Icon3.png" alt="">
                        <h4 class="card-title text-center mb-2">1 lessen</h4>
                        <p class="card-text mb-2 text-center mt-4">Prijs: € 90,00-</p>
                        <p class="card-text mb-2 text-center mt-4">3 uur per les</p>
                        <p class="card-text mb-2 text-center mt-4">
                            <a href="#" class="btn text-white btn-primary-custom text-center"> Bestel nu</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4 mt-3">
                <div class="card border-0 text-dark">
                    <div class="card-body rounded text-dark">
                        <img class="mb-4" src="img/Icon3.png" alt="">
                        <h4 class="card-title text-center mb-2">5 lessen</h4>
                        <p class="card-text mb-2 text-center mt-4">Prijs: € 405,00 <span class="text-danger">-10%</span></p>
                        <p class="card-text mb-2 text-center mt-4">3 uur per les</p>
                        <p class="card-text mb-2 text-center mt-4">
                            <a href="#" class="btn text-white btn-primary-custom text-center"> Bestel nu</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4 mt-3">
                <div class="card border-0 text-dark">
                    <div class="card-body rounded text-dark">
                        <img class="mb-4" src="img/Icon3.png" alt="">
                        <h4 class="card-title text-center mb-2">10 lessen</h4>
                        <p class="card-text mb-2 text-center mt-4">Prijs: € 765,00 <span class="text-danger">-15%</span></p>
                        <p class="card-text mb-2 text-center mt-4">3 uur per les</p>
                        <p class="card-text mb-2 text-center mt-4">
                            <a href="#" class="btn text-white btn-primary-custom text-center"> Bestel nu</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <div class="container p-5 text-lg-start text-center">
        <div class="row align-items-center justify-content-between">
            <div class="col-md text-dark p-5">
                <div class="rounded" id="map" style="height: 400px; width: 100%;"></div>
            </div>
        </div>
    </div>

    <?php include 'footer.html'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-LsL1IqxlqDXT3G2foV2iI494OgTYNS8&callback=initMap" async defer></script>
    <script src="../Javascript/google_maps.js"></script>



</body>
</html>
