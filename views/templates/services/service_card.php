<div class="col-12 col-md-4 col-xl-6 col-xxl-4 mt-3 mt-md-5">
    <article class="service d-flex flex-column justify-content-between py-4 px-4">
        <div class="d-flex flex-column flex-xl-row flex-wrap justify-content-between mb-3">
            <h4 class="underline-title"><?= $service->name ?></h4>
            <?php if (is_null($service->published_at)) { ?>
                <small class="not-published d-inline text-center px-3 mt-2 mt-xl-0">Non publiée</small>
            <?php } else if (!is_null($service->deactivated_at)) { ?>
                <small class="deactivated d-inline text-center px-3 mt-2 mt-xl-0">Désactivée</small>
            <?php } else if ($service->end_exclusive_date) { ?>
                <small class="special-service d-inline text-center px-3 mt-2 mt-xl-0">Jusqu'au <?= $service->end_exclusive_date ?></small>
            <?php } else if (Service::new_display($service->published_at)) { ?>
                <small class="new-service d-inline text-center px-3 mt-2 mt-xl-0">Nouveauté</small>
            <?php } ?>
        </div>
        <?php if (!empty($service->description)) { ?><p><?= $service->description ?></p><?php } ?>

        <?php
        include(__DIR__ . './pricings_grid.php');
        ?>
    </article>
</div>