<main>
    <div class="container-fluid px-0">
        <div class="background-title">
            <img src="./public/assets/img/logos/logo-xl.webp" class="img-fluid" aria-hidden="true">
            <h1 class="main-title d-flex flex-column justify-content-center"><span class="text-center offset-lg-3 offset-xxl-4 my-5">Salon de beauté</span><span class="text-center mb-4">L'AURA NATUR'ELLE</span></h1>
        </div>

        <!-- ========================================================================================================================================================================== -->
        <!-- BANDEROLE D'ANNONCE -->

        <?php if (!is_null($announcement)) { ?>
            <section class="announcement">
                <div class="row mx-0 announcement-content">
                    <div class="col d-flex justify-content-center">
                        <div class="d-flex flex-wrap justify-content-center align-items-center py-2 pe-3">
                            <i class="bi bi-megaphone-fill announcement-icon"></i>
                            <p class="d-flex flex-wrap justify-content-center align-items-center text-center pt-2 pt-md-0 ps-md-5 my-0">
                                <?= $announcement->content ?>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>


        <!-- ========================================================================================================================================================================== -->
        <!-- PARTIE PRESENTATION -->

        <section class="py-3 py-md-5" id="presentation">
            <!-- <div class="d-flex flex-column justify-content-center align-items-center">
                    <h2 class="category-title text-center py-4 px-4 mt-2 mb-5">Votre salon de beauté bio & vegan !</h2>
                </div> -->
            <div class="row justify-content-evenly pt-md-5 mx-0">
                <div class="col-12 col-md-11 col-xl-6 d-flex flex-column justify-content-around align-items-center pb-md-5 pb-lg-0">
                    <div class="presentation-text d-flex flex-column align-items-center">
                        <p class="align-self-md-start py-5">Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Quisquam,
                            nisi! Quidem quas
                            omnis quia minus libero reiciendis tempora sed, alias rem, nisi, optio porro
                            molestiae earum ipsa est? Ipsa, mollitia?</p>
                        <p class="align-self-md-end text-end py-5">Lorem ipsum dolor sit amet consectetur
                            adipisicing
                            elit. Quisquam,
                            nisi! Quidem quas
                            omnis quia minus libero reiciendis tempora sed, alias rem, nisi, optio porro
                            molestiae earum ipsa est? Ipsa, mollitia?</p>
                        <picture>
                            <source srcset="../public/assets/img/backgrounds/index-xl.webp" type="image/webp" media="(min-width: 1200px)">
                            <source srcset="../public/assets/img/backgrounds/index-md.webp" type="image/webp" media="(min-width: 768px)">
                            <img src="../public/assets/img/backgrounds/index.webp" class="img-fluid" aria-hidden="true">
                        </picture>
                    </div>
                </div>

                <div class="col-11 col-sm-10 col-lg-9 col-xl-5 col-xxl-4 pb-5 py-md-5">

                    <div class="d-flex justify-content-center px-4">
                        <div id="galleryImg" class="carousel carousel-dark slide">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#galleryImg" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#galleryImg" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#galleryImg" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="../public/assets/img/photos/manucure.webp" class="d-block w-100" alt="Photo de la partie manucure du salon L'Aura Natur'elle">
                                </div>
                                <div class="carousel-item">
                                    <img src="../public/assets/img/photos/salon.webp" class="d-block w-100" alt="Photo de la partie massage du salon L'Aura Natur'elle">
                                </div>
                                <div class="carousel-item">
                                    <img src="../public/assets/img/photos/maison.webp" class="d-block w-100" alt="Photo de la façade du salon L'Aura Natur'elle">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#galleryImg" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#galleryImg" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================================================================================================================================================== -->

        <div class="split-index mt-3 mt-md-5"></div>

        <!-- ========================================================================================================================================================================== -->
        <!-- PARTIE PRESTATIONS -->

        <section class="py-3 py-md-5">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <h2 class="category-title text-center py-4 px-4 my-2">Les prestations chez L'Aura Natur'elle</h2>
            </div>

            <div class="row justify-content-around mx-0 mt-5">
                <div class="col prestations-index px-0 py-5">
                    <picture id="diapo">
                        <source srcset="../public/assets/img/backgrounds/prestations-xl.webp" type="image/webp" media="(min-width: 768px)">
                        <img src="../public/assets/img/backgrounds/prestations.webp" class="img-fluid services-index-img" aria-hidden="true">
                    </picture>
                    <div class="prestations-div-text">
                        <div class="prestations-text-index lightmode py-3 py-md-5 px-3 px-md-5">
                            <p>Offrez à votre peau l'attention qu'elle mérite avec des soins du visage. Arborez des ongles impeccables grâce aux manucures professionnelles.
                                Dites adieu aux soucis des poils indésirables par le biais d'épilations expertes.
                                Et pour une évasion totale, détendez-vous et échappez au stress quotidien grâce à nos modelages apaisants…</p>
                            <ul class="d-flex justify-content-evenly align-items-center logos-product mt-4">
                                <li><img src="../public/assets/img/logos/france.webp" alt="Produits made in France" title="Produits made in France" class="img-fluid min-logos"></li>
                                <li><img src="../public/assets/img/logos/bio.webp" alt="Produits bio" title="Produits bio" class="img-fluid min-logos"></li>
                                <li><img src="../public/assets/img/logos/vegan.webp" alt="Produits vegan" title="Produits vegan" class="img-fluid min-logos"></li>
                                <li><img src="../public/assets/img/logos/naturels.webp" alt="Produits naturels" title="Produits naturels" class="img-fluid min-logos"></li>
                            </ul>
                        </div>
                        <a href="./main/services_categories.html" class="btn btn-outline btn-services-index lightmode py-3">Voir les prestations</a>
                    </div>
                </div>
            </div>
        </section>

        <div class="split-index mt-4"></div>


        <!-- ========================================================================================================================================================================== -->
        <!-- PARTIE FIDELITE -->

        <section class="section-index py-3 py-md-5">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <h2 class="category-title text-center py-4 px-3 my-2">Votre fidélité récompensée !</h2>
            </div>

            <div class="row justify-content-center justify-content-xl-evenly mx-0 mt-5 py-xl-5">
                <div class="col-12 col-md-9 col-xl-5 col-xxl-4 py-md-5 d-flex justify-content-center align-items-center">
                    <picture class="d-flex justify-content-center fidelity-img">
                        <source srcset="../public/assets/img/illustrations/others/carte-xl-verso.webp" type="image/webp" media="(min-width: 768px)">
                        <img src="../public/assets/img/illustrations/others/carte-verso.webp" alt="Visuel de la carte de fidélité" class="img-fluid">
                    </picture>

                </div>

                <div class="col-12 col-md-9 col-xl-5 col-xxl-4 d-flex flex-column justify-content-evenly fidelity-text px-4 px-md-0 pt-5 pt-xl-0">
                    <p><strong class="c-pink">L’Aura Natur’elle</strong> est ravie de vous présenter son <strong class="c-pink">programme fidélité</strong>, vous permettant de bénéficier
                        d’une réduction de <span>15%</span> sur une prestation de votre choix d’un montant minimum de 10 €,
                        une fois la carte complète.</p>
                </div>
            </div>
        </section>

        <div class="split-index"></div>

        <!-- ========================================================================================================================================================================== -->
        <!-- PARTIE EMPLACEMENT -->

        <section class="pt-3 pt-md-5 pb-xl-5" id="place">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <h2 class="category-title text-center py-4 px-3 my-2">Emplacement & Horaires</h2>
            </div>


            <div class="row justify-content-evenly align-items-stretch py-xl-5 mx-0">

                <div class="col-12 col-xl-7 col-xxl-7 d-flex flex-column justify-content-center align-items-center">
                    <div class="mt-3 mt-md-5" id="map">
                    </div>

                    <p class="text-center mt-4">Parking gratuit à 250m, 4 min à pied (supermarché, pharmacie).</p>
                </div>

                <!-- --------------------------------------------------------------------------------------------- -->
                <!-- PLAQUE HORAIRES -->
                <div class="col-12 col-xl-4 col-xxl-3 d-flex justify-content-center align-items-center mt-5 mt-xl-0">
                    <div class="scheduleBoard d-flex flex-column justify-content-center align-items-center py-5 px-xl-5 mb-5 mb-xl-0">
                        <h3 class="text-center mb-4">Horaires</h3>
                        <ul>
                            <?php foreach ($schedules_sign as $schedule) { ?>
                                <li class="py-1"><span><?= $schedule->week_day ?> :</span> <?= $schedule->display ?></li><?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row justify-content-around informations mx-0">
                <div class="col-12 col-md-6 col-xl-4 d-flex flex-column align-items-center">
                    <h3 class="text-center py-2 px-5 mb-3">Adresse</h3>
                    <p class="text-center"><i class="bi bi-geo-alt me-2"></i><?= $artisan->address ?> <br> <?= $artisan->zipcode . ' ' . $artisan->city ?></p>
                </div>
                <div class="col-12 col-md-6 col-xl-4 d-flex flex-column align-items-center">
                    <h3 class="text-center py-2 px-5 mb-3">Téléphone</h3>
                    <p class="text-center"><i class="bi bi-telephone me-2"></i><?= $artisan->phone ?></p>
                </div>
                <div class="col-12 col-md-6 col-xl-4 d-flex flex-column align-items-center mt-md-4 mt-xl-0 mb-5 mb-xl-0">
                    <h3 class="text-center py-2 px-5 mb-3">Mail</h3>
                    <a href="mailto: <?= $artisan->email ?>"><i class="bi bi-envelope-at me-2"></i><?= $artisan->email ?></a>
                </div>
            </div>
        </section>
    </div>
</main>