<?php if (is_array($service->prices)) { ?>
    <!-- -------------------------------------------------------------------- -->
    <!-- ACCORDEON -->

    <div class="accordion accordion-flush accordion-price-time <?= $service->accordion_class ?> accordion-min mt-4" id="accordionFlush<?= $key ?? $i ?>">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed px-4" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $key ?? $i ?>" aria-expanded="false" aria-controls="flush-collapse<?= $key ?? $i ?>"> Durée &
                    Tarifs
                </button>
            </h2>
            <div id="flush-collapse<?= $key ?? $i ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlush<?= $key ?? $i ?>">
                <div class="accordion-body">
                    <?php foreach ($service->prices as $key => $price) { ?>
                        <hr class="hr-services">
                        <div class="d-flex flex-column flex-xl-row justify-content-evenly div-badges">
                            <div class="time time-badge-grid d-flex justify-content-center align-items-center px-4 py-1">
                                <i class="bi bi-clock me-2"></i><?= $service->durations[$key] ?> min
                            </div>
                            <div class="price price-badge-grid <?= ($service->discount_display) ? 'discount' : '' ?> d-flex justify-content-center align-items-center px-4 mt-3 mt-xl-0">
                                <?= ($service->discount_display) ? '<span class="text-decoration-line-through me-3"> ' . $price . ' €</span>' . $service->reduced_prices[$key] : $price ?> €
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- -------------------------------------------------------------------- -->
<?php } else { ?>
    <div class="d-flex flex-column flex-xl-row justify-content-md-center justify-content-xl-between align-items-xl-center badges-div">

        <!-- TEMPS -->
        <div class="time time-badge-line d-flex justify-content-center align-items-center px-xl-4 py-1 mb-md-4 mb-xl-0">
            <i class="bi bi-clock me-2"></i><?= $service->durations ?> min
        </div>

        <!-- PRIX -->
        <div class="price price-badge-line <?= ($service->discount_display) ? 'discount' : '' ?> d-flex justify-content-center align-items-center px-xl-4 mt-3 mt-md-0">
            <?= ($service->discount_display) ? '<span class="text-decoration-line-through me-3"> ' . $service->prices . ' €</span>' . $service->reduced_prices : $service->prices ?> €
        </div>
    </div>
<?php } ?>