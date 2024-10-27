<main>
    <div class="container-fluid px-0">
        <h1 class="text-center pt-5 mt-md-5">Prestations</h1>

        <section class="pb-5">
            <!-- TITRE CATEGORIE -->
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
            <div class="row mx-0 px-md-5 pb-4 pb-md-0 my-md-5">
                <div class="col">
                    <h2 class="category-title text-center py-4 my-5">Sublimez votre beauté avec des services
                        esthétiques sur mesure</h2>
                    <p class="service-text text-center pt-md-5 mt-md-5">Découvrez les prestations esthétiques
                        proposées par <strong>L’Aura Natur’elle</strong> ; conçues pour sublimer votre beauté
                        naturelle et vous offrir une expérience de bien-être inégalée. Le salon garantit la qualité exceptionnelle des soins en utilisant exclusivement des produits de renom.</p>
                    <div class="d-flex flex-wrap justify-content-around align-items-center logos-brand">
                        <img src="../public/assets/img/logos/passion.webp" alt="Marque Passion Marine" class="img-fluid">
                        <img src="../public/assets/img/logos/peggy.webp" alt="Marque Peggy Sage - Paris" class="img-fluid">
                        <img src="../public/assets/img/logos/sla.webp" alt="Marque SLA - Paris" class="img-fluid">
                        <img src="../public/assets/img/logos/leonia.webp" alt="Marque Léonia - Paris" class="img-fluid">
                    </div>
                </div>
            </div>
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

            <!-- EXPOSITION -->
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

            <div class="row justify-content-around mx-0 px-2">
                <!-- --------------------------------------------------------------------------------------------------- -->
                <?php foreach ($categories as $key => $category) { ?>
                    <div class="col-12 col-md-5 col-lg-3 col-xxl-2 d-flex justify-content-center my-3 my-md-5 mx-md-4 mx-xxl-5">
                        <a href="prestations/<?= $category->link ?>?id=<?= $category->id_category ?>" class="card-link" aria-label="Découvrir les services <?= $category->name ?>">
                            <div class="card">
                                <img src="../public/uploads/categories_min/<?= $category->id_category ?>.webp" class="card-img-top" alt="Illustration de la catégorie <?= $category->name ?>">
                                <div class="card-body">
                                    <h3 class="card-title text-center"><?= $category->name ?></h3>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
                <!-- --------------------------------------------------------------------------------------------------- -->
            </div>
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