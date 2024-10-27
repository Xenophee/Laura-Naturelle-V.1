<main>
    <div class="container-fluid px-0">
        <h1 class="text-center pt-5 mt-md-5">Prestations</h1>

        <section class="pb-5">
            <!-- TITRE CATEGORIE -->
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
            <div class="row mx-0 px-md-5 pb-md-5 mt-lg-5">
                <div class="col">
                    <h2 class="category-title text-center py-4 my-5"><?= $category->name ?></h2>
                    <?php if (!empty($category->description)) { ?><p class="service-text text-center pt-md-5 mt-md-5"><?= $category->description ?></p><?php } ?>
                </div>
            </div>
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

            <!-- AFFICHAGE DU GENRE -->
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
            <?php
            include(__DIR__ . './templates/services/gender.php');
            ?>
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->


            <?php if (!empty($female_services)) { ?>
                <section id="female">
                    <!-- SECTION EXCLUSIVE -->
                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                    <?php if (!empty($female_exclusives)) { ?>
                        <section>
                            <h3 class="subtitle text-center my-5">Les exclusives</h3>
                            <div class="row justify-content-around mx-0 px-md-4 px-xl-5 pb-5 service-row special-section">
                                <!-- ========================================================================================================================== -->
                                <?php foreach ($female_exclusives as $key => $service) {
                                    include(__DIR__ . './../views/templates/services/service_card.php');
                                } ?>
                                <!-- ========================================================================================================================== -->
                            </div>
                        </section>
                    <?php } ?>
                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

                    <!-- SECTION PRESTATIONS CLASSIQUES -->
                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                    <?php if (!empty($female_classics)) { ?>
                        <section>
                            <h3 class="subtitle text-center my-5 pt-xl-5">Les classiques</h3>
                            <!-- PREMIERE PARTIE AVEC IMAGES ET DEUX PRESTATIONS -->
                            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                            <div class="row justify-content-between mx-0 mt-xl-5 px-md-4 px-xxl-5 pt-5 service-row classic-section">
                                <!-- PRESTATIONS -->
                                <div class="col-12 col-md-8 col-xl-6 col-xxl-4 d-flex flex-column justify-content-between mt-4 mt-md-0 order-2">
                                    <!-- ========================================================================================================================== -->
                                    <?php for ($i = 0; $i < count($female_classics) && $i < 2; $i++) {
                                        $service = $female_classics[$i]; ?>
                                        <article class="service main-service py-4 px-4 <?= ($i == 1) ? 'mt-3 mt-md-5' : '' ?>">
                                            <div class="d-flex flex-column flex-md-row flex-wrap justify-content-between mb-3">
                                                <h4 class="underline-title"><?= $service->name ?></h4>
                                                <?php if (is_null($service->published_at)) { ?>
                                                    <small class="not-published d-inline text-center px-3 mt-2 mt-md-0 mt-md-0">Non publiée</small>
                                                <?php } else if (!is_null($service->deactivated_at)) { ?>
                                                    <small class="deactivated d-inline text-center px-3 mt-2 mt-md-0 mt-md-0">Désactivée</small>
                                                <?php } else if (Service::new_display($service->published_at)) { ?>
                                                    <small class="new-service d-inline text-center px-3 mt-2 mt-md-0 mt-md-0">Nouveauté</small>
                                                <?php } ?>
                                            </div>
                                            <?php if (!empty($service->description)) { ?><p><?= $service->description ?></p><?php } ?>
                                            <?php include(__DIR__ . './../views/templates/services/pricings_grid.php'); ?>
                                        </article>
                                    <?php } ?>
                                    <!-- ========================================================================================================================== -->
                                </div>

                                <!-- GRANDE IMAGE -->
                                <div class="col-12 col-md-4 col-xl-6 col-xxl-8 order-1">
                                    <picture>
                                        <source srcset="../public/uploads/categories/<?= $id ?>-xl.webp" type="image/webp" media="(min-width: 1400px)">
                                        <img src="../public/uploads/categories/<?= $id ?>.webp" alt="Illustration de la catégorie <?= $category->name ?>" class="img-fluid service-img">
                                    </picture>
                                </div>

                            </div>
                            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

                            <!-- DEUXIEME PARTIE AVEC LES AUTRES PRESTATIONS -->
                            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                            <div class="row justify-content-around mx-0 px-md-4 px-xxl-5 pb-5 service-row classic-section">
                                <!-- ========================================================================================================================== -->
                                <?php foreach ($female_classics as $key => $service) {
                                    if ($key > 1) {
                                        include(__DIR__ . './../views/templates/services/service_card.php');
                                    }
                                } ?>
                                <!-- ========================================================================================================================== -->
                            </div>
                            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                        </section>
                    <?php } ?>
                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

                    <!-- SECTION FORFAITS -->
                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                    <?php if (!empty($female_packages)) { ?>
                        <section>
                            <h3 class="subtitle text-center my-5 pt-xl-4 pt-xxl-5">Les forfaits</h3>
                            <div class="row justify-content-around mx-0 px-md-4 px-xl-5 pb-5 service-row package-section">
                                <!-- ========================================================================================================================== -->
                                <?php foreach ($female_packages as $key => $service) {
                                    include(__DIR__ . './../views/templates/services/service_card.php');
                                } ?>
                                <!-- ========================================================================================================================== -->
                            </div>
                        </section>
                    <?php } ?>
                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                </section>
            <?php } ?>




            <?php if (!empty($male_services)) { ?>
                <section <?= (!empty($female_services) && !empty($male_services)) ? 'class="d-none"' : '' ?> id="male">
                    <!-- SECTION EXCLUSIVE -->
                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                    <?php if (!empty($male_exclusives)) { ?>
                        <section>
                            <h3 class="subtitle text-center my-5">Les exclusives</h3>
                            <div class="row justify-content-around mx-0 px-md-4 px-xl-5 pb-5 service-row special-section">
                                <!-- ========================================================================================================================== -->
                                <?php foreach ($male_exclusives as $key => $service) {
                                    include(__DIR__ . './../views/templates/services/service_card.php');
                                } ?>
                                <!-- ========================================================================================================================== -->
                            </div>
                        </section>
                    <?php } ?>
                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

                    <!-- SECTION PRESTATIONS CLASSIQUES -->
                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                    <?php if (!empty($male_classics)) { ?>
                        <section>
                            <h3 class="subtitle text-center my-5 pt-xl-5">Les classiques</h3>
                            <!-- PREMIERE PARTIE AVEC IMAGES ET DEUX PRESTATIONS -->
                            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                            <div class="row justify-content-between mx-0 mt-xl-5 px-md-4 px-xxl-5 pt-5 service-row classic-section">
                                <!-- PRESTATIONS -->
                                <div class="col-12 col-md-8 col-xl-6 col-xxl-4 d-flex flex-column justify-content-between mt-4 mt-md-0 order-2">
                                    <!-- ========================================================================================================================== -->
                                    <?php for ($i = 0; $i < count($male_classics) && $i < 2; $i++) {
                                        $service = $male_classics[$i]; ?>
                                        <article class="service main-service py-4 px-4 <?= ($i == 1) ? 'mt-3 mt-md-5' : '' ?>">
                                            <div class="d-flex flex-column flex-md-row flex-wrap justify-content-between mb-3">
                                                <h4 class="underline-title"><?= $service->name ?></h4>
                                                <?php if (is_null($service->published_at)) { ?>
                                                    <small class="not-published d-inline text-center px-3 mt-2 mt-md-0 mt-md-0">Non publiée</small>
                                                <?php } else if (!is_null($service->deactivated_at)) { ?>
                                                    <small class="deactivated d-inline text-center px-3 mt-2 mt-md-0 mt-md-0">Désactivée</small>
                                                <?php } else if (Service::new_display($service->published_at)) { ?>
                                                    <small class="new-service d-inline text-center px-3 mt-2 mt-md-0 mt-md-0">Nouveauté</small>
                                                <?php } ?>
                                            </div>
                                            <?php if (!empty($service->description)) { ?><p><?= $service->description ?></p><?php } ?>
                                            <?php include(__DIR__ . './../views/templates/services/pricings_grid.php'); ?>
                                        </article>
                                    <?php } ?>
                                    <!-- ========================================================================================================================== -->
                                </div>

                                <!-- GRANDE IMAGE -->
                                <div class="col-12 col-md-4 col-xl-6 col-xxl-8 order-1">
                                    <picture>
                                        <source srcset="../public/uploads/categories/<?= $id ?>-xl.webp" type="image/webp" media="(min-width: 1400px)">
                                        <img src="../public/uploads/categories/<?= $id ?>.webp" alt="Illustration de la catégorie <?= $category->name ?>" class="img-fluid service-img">
                                    </picture>
                                </div>

                            </div>
                            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

                            <!-- DEUXIEME PARTIE AVEC LES AUTRES PRESTATIONS -->
                            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                            <div class="row justify-content-around mx-0 px-md-4 px-xxl-5 pb-5 service-row classic-section">
                                <!-- ========================================================================================================================== -->
                                <?php foreach ($male_classics as $key => $service) {
                                    if ($key > 1) {
                                        include(__DIR__ . './../views/templates/services/service_card.php');
                                    }
                                } ?>
                                <!-- ========================================================================================================================== -->
                            </div>
                            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                        </section>
                    <?php } ?>
                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

                    <!-- SECTION FORFAITS -->
                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                    <?php if (!empty($male_packages)) { ?>
                        <section>
                            <h3 class="subtitle text-center my-5 pt-xl-4 pt-xxl-5">Les forfaits</h3>
                            <div class="row justify-content-around mx-0 px-md-4 px-xl-5 pb-5 service-row package-section">
                                <!-- ========================================================================================================================== -->
                                <?php foreach ($male_packages as $key => $service) {
                                    include(__DIR__ . './../views/templates/services/service_card.php');
                                } ?>
                                <!-- ========================================================================================================================== -->
                            </div>
                        </section>
                    <?php } ?>
                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                </section>
            <?php } ?>


            <!-- BOUTON DE RDV -->
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
            <?php
            include(__DIR__ . './templates/services/btn_appointment.php');
            ?>
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

            <!-- PRODUITS -->
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
            <?php
            include(__DIR__ . './templates/services/products.php');
            ?>
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

        </section>

    </div>
</main>