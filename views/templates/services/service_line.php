<article>
    <div class="row justify-content-center mx-0 <?= $key > 0 ? 'mt-4' : '' ?>">
        <div class="col-11 col-md-10 col-xl-10 col-xxl-9 d-flex flex-column flex-md-row justify-content-between align-items-center service-line pb-4 px-0">

            <!-- CONTENU TEXTE -->
            <div class="lines-service-div mb-3 mb-md-0">
                <div class="d-flex flex-column flex-md-row align-items-start">
                    <h4 class="sideline-title mb-3"><?= $service->name ?></h4>
                    <?php if (is_null($service->published_at)) { ?>
                        <small class="not-published d-inline text-center px-3 ms-md-5 mb-2">Non publiée</small>
                    <?php } else if (!is_null($service->deactivated_at)) { ?>
                        <small class="deactivated d-inline text-center px-3 ms-md-5 mb-2">Désactivée</small>
                    <?php } else if ($service->end_exclusive_date) { ?>
                        <small class="special-service d-inline text-center px-3 ms-md-5 mb-2">Jusqu'au <?= $service->end_exclusive_date ?></small>
                    <?php } else if (Service::new_display($service->published_at)) { ?>
                        <small class="new-service d-inline text-center px-3 ms-md-5 mb-2">Nouveauté</small>
                    <?php } ?>
                </div>
                <?php if (!empty($service->description)) { ?><p><?= $service->description ?></p><?php } ?>
            </div>

            <?php
            include(__DIR__ . './pricings_line.php');
            ?>

        </div>
    </div>
</article>