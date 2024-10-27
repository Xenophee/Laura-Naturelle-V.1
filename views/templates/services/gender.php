<?php if (!empty($female_services) && !empty($male_services)) { ?>
    <div class="row justify-content-center my-5 mx-0">
        <div class="col-12 col-lg-11 col-xl-9">
            <div class="d-flex flex-column flex-md-row justify-content-between gender-nav my-md-5">
                <h2 class="text-center gender-category d-flex justify-content-center align-items-center active">
                    Femmes</h2>
                <h2 class="text-center gender-category d-flex justify-content-center align-items-center">
                    Hommes</h2>
            </div>
        </div>
    </div>
<?php } else { ?>

    <div class="row justify-content-center mx-0">
        <div class="col-xl-11 col-xxl-10 d-flex justify-content-center align-items-center <?= !empty($female_services) ? 'female-badge-service' : 'male-badge-service' ?> mb-5">
            <div class="bagde-line-background-before me-5"></div>
            <img src="../public/assets/img/logos/<?= !empty($female_services) ? 'female' : 'male' ?>.webp" alt="Badge d'information : exclusivement <?= !empty($female_services) ? 'féminin' : 'masculin' ?>" class="img-fluid exclusively" title="Exclusivement <?= !empty($female_services) ? 'féminin' : 'masculin' ?>">
            <div class="bagde-line-background-after ms-5"></div>
        </div>
    </div>

<?php } ?>