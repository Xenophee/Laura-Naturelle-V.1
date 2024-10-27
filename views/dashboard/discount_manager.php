<main>
    <div class="container-fluid px-0">

        <div class="row justify-content-around mx-0">

            <?php
            include(__DIR__ . './../../views/templates/dashboard_nav.php');
            ?>

            <div class="col-12 col-xl-9 col-xxl-10">

                <section class="d-flex flex-column justify-content-center align-items-center pt-lg-5">

                    <!-- ========================================================================================================================================================================== -->
                    <!-- MESSAGE FLASH -->
                    <!-- ========================================================================================================================================================================== -->

                    <?php if (Flash::isExist()) {
                        $flash = Flash::getMessage(); ?>
                        <div class="alert alert-dismissible <?= $flash['class'] ?? '' ?> fade show w-50 mt-5" data-bs-theme="dark" role="alert">
                            <div><i class="bi <?= $flash['icon'] ?? '' ?> me-3"></i><?= $flash['message'] ?></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>


                    <!-- ========================================================================================================================================================================== -->
                    <!-- FORMULAIRE -->
                    <!-- ========================================================================================================================================================================== -->

                    <form action="../../controllers/dashboard/discount_manager_controller.php?id=<?= $id ?>" method="post" enctype="multipart/form-data" class="dashboard-form mt-5" id="discount-form">
                        <legend class="text-center py-2 mb-5"><?= (empty($id)) ? 'Ajouter' : 'Modifier' ?> une promotion</legend>

                        <!-- -------------------------------------------------------------- -->
                        <!-- DURÉE DE LA REDUCTION -->
                        <label class="d-block text-center fw-bold mb-4 mt-md-4">Quand la promotion doit-elle être appliquée ?</label>

                        <div class="d-flex flex-column flex-md-row justify-content-around align-items-center w-100 mb-4 mb-md-5">
                            <div class="form-div me-md-5 mb-3 mb-md-0">
                                <label for="startDate" class="form-label me-3">Date de début * :</label>
                                <input type="date" class="form-control <?= (empty($dates['first_date']['message'])) ? '' : 'error-form' ?>" id="startDate" name="startDate" min="<?= date('Y-m-d') ?>" value="<?= $dates['first_date']['data'] ?? $discount->start_date ?? '' ?>" required>
                                <small class="<?= (empty($dates['first_date']['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="startDate" id="startDateError"><?= $dates['first_date']['message'] ?? '' ?></small>
                            </div>

                            <span class="fw-bold">au</span>

                            <div class="form-div ms-md-5 mt-3 mt-md-0">
                                <label for="endDate" class="form-label me-3">Date de fin * :</label>
                                <input type="date" class="form-control <?= (empty($dates['last_date']['message'])) ? '' : 'error-form' ?>" id="endDate" name="endDate" min="<?= date('Y-m-d') ?>" value="<?= $dates['last_date']['data'] ?? $discount->end_date ?? '' ?>" required>
                                <small class="<?= (empty($dates['last_date']['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="endDate" id="endDateError"><?= $dates['last_date']['message'] ?? '' ?></small>
                            </div>
                        </div>
                        <!-- -------------------------------------------------------------- -->
                        <!-- TYPE DE REDUCTION -->
                        <label class="d-block text-center fw-bold">Type de réduction :</label>
                        <small class="<?= (empty($euro['message'])) ? 'd-none' : '' ?> d-block text-danger text-center fst-italic mt-2" role="alert" id="discountTypeError"><?= $euro['message'] ?? '' ?></small>
                        <div class="btn-group d-flex mt-3 mb-5" role="group" aria-label="Choisir le type de réduction">
                            <input type="radio" class="btn-check" name="discountType" value="0" id="percentage" aria-errormessage="discountTypeError" autocomplete="off" required <?= (isset($euro) && $euro['data'] === 0) || (isset($discount) && $discount->euro === 0) ? 'checked' : '' ?>>
                            <label class="btn btn-radio" for="percentage">%</label>

                            <input type="radio" class="btn-check" name="discountType" value="1" id="euro" aria-errormessage="discountTypeError" autocomplete="off" required <?= (isset($euro) && $euro['data'] === 1) || (isset($discount) && $discount->euro === 1) ? 'checked' : '' ?>>
                            <label class="btn btn-radio" for="euro">€</label>
                        </div>
                        <!-- -------------------------------------------------------------- -->
                        <!-- MONTANT DE LA REDUCTION -->
                        <div class="mb-4">
                            <label for="advantage" class="form-label me-3">Montant de la réduction * :</label>
                            <input type="number" class="form-control <?= (empty($advantage['message'])) ? '' : 'error-form' ?>" id="advantage" name="advantage" value="<?= $advantage['data'] ?? $discount->advantage ?? '' ?>" required>
                            <small class="<?= (empty($advantage['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="advantage" id="advantageError"><?= $advantage['message'] ?? '' ?></small>
                        </div>
                        <!-- -------------------------------------------------------------- -->
                        <!-- CHOIX DES PRESTATIONS CONCERNEES PAR LA REDUCTION -->
                        <label class="d-block text-center fw-bold pt-4">Prestations concernées :</label>
                        <small class="<?= (empty($which_services['message'])) ? 'd-none' : '' ?> d-block text-danger text-center fst-italic mt-2" role="alert" id="whichServicesError"><?= $which_services['message'] ?? '' ?></small>
                        <div class="btn-group d-flex mt-3 mb-5" role="group" aria-label="Choisir les prestations ciblées">
                            <input type="radio" class="btn-check" name="whichServices" value="1" id="all" aria-errormessage="whichServicesError" autocomplete="off" required <?= (isset($which_services) && $which_services['data'] == 1) || (isset($discount) && $discount->services == 1) ? 'checked' : '' ?>>
                            <label class="btn btn-radio" for="all">Toutes les prestations</label>

                            <input type="radio" class="btn-check" name="whichServices" value="2" id="specific" aria-errormessage="whichServicesError" autocomplete="off" required <?= (isset($which_services) && $which_services['data'] == 2) || (isset($discount) && $discount->services == 2) ? 'checked' : '' ?>>
                            <label class="btn btn-radio" for="specific">Prestations ciblées</label>
                        </div>
                        <!-- -------------------------------------------------------------- -->

                        <!-- -------------------------------------------------------------- -->
                        <!-- ACCORDEON DES PRESTATIONS -->
                        <div class="accordion d-none" id="servicesAccordion">
                            <?php foreach ($categories as $key => $category) { ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?= $key ?>" aria-expanded="true" aria-controls="panelsStayOpen-collapse<?= $key ?>">
                                            <?= $category->category_name ?>
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapse<?= $key ?>" class="accordion-collapse collapse <?= (in_array('checked', $category->status)) ? 'show' : '' ?>">
                                        <div class="accordion-body">

                                            <?php if (in_array(2, $category->genders)) { ?>
                                                <fieldset class="mb-1">
                                                    <label class="bg-filter-pink fw-bold w-100 px-4 mb-2">Femmes</label>
                                                    <div class="d-flex flex-wrap">
                                                        <?php foreach ($category->id_services as $key => $id_service) {
                                                            if ($category->genders[$key] == 2) { ?>
                                                                <div class="form-check accordion-block mt-2">
                                                                    <input class="form-check-input" type="checkbox" name="services[]" value="<?= $id_service ?>" id="service<?= $id_service ?>" <?= $category->status[$key] ?> <?= (in_array($id_service, $is_discounts_exist)) ? 'disabled' : '' ?>>
                                                                    <label class="form-check-label ps-2" for="service<?= $id_service ?>">
                                                                    <?= (in_array($id_service, $is_discounts_exist)) ? '<i class="bi bi-exclamation-diamond text-danger" title="Promotion déjà en cours"></i>' : '' ?>
                                                                        <?= $category->service_names[$key] ?>
                                                                    </label>
                                                                </div>
                                                        <?php }
                                                        } ?>
                                                    </div>
                                                </fieldset>
                                            <?php } ?>

                                            <?php if (in_array(1, $category->genders)) { ?>
                                                <fieldset class="mb-1">
                                                    <label class="bg-filter-green fw-bold w-100 px-4 mt-3 mb-2">Hommes</label>
                                                    <div class="d-flex flex-wrap">
                                                        <?php foreach ($category->id_services as $key => $id_service) {
                                                            if ($category->genders[$key] == 1) { ?>
                                                                <div class="form-check accordion-block mt-2">
                                                                    <input class="form-check-input" type="checkbox" name="services[]" value="<?= $id_service ?>" id="service<?= $id_service ?>" <?= $category->status[$key] ?> <?= (in_array($id_service, $is_discounts_exist)) ? 'disabled' : '' ?>>
                                                                    <label class="form-check-label ps-2" for="service<?= $id_service ?>">
                                                                    <?= (in_array($id_service, $is_discounts_exist)) ? '<i class="bi bi-exclamation-diamond text-danger" title="Promotion déjà en cours"></i>' : '' ?>
                                                                        <?= $category->service_names[$key] ?>
                                                                    </label>
                                                                </div>
                                                        <?php }
                                                        } ?>
                                                    </div>
                                                </fieldset>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- -------------------------------------------------------------- -->

                        <div class="d-flex justify-content-center pb-md-5 pt-md-5 my-5">
                            <button type="submit" class="btn btn-classic btn-large py-2"><i class="bi <?= (empty($id)) ? 'bi-tag' : 'bi-pencil-fill' ?> me-3" aria-hidden="true"></i><?= (empty($id)) ? 'Ajouter' : 'Modifier' ?> la promotion</button>
                        </div>

                    </form>
                </section>
            </div>

        </div>

    </div>
</main>