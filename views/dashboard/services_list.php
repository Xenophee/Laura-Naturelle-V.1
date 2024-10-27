<main>
    <div class="container-fluid px-0">

        <div class="row justify-content-around mx-0">

            <?php
            include(__DIR__ . './../../views/templates/dashboard_nav.php');
            ?>

            <div class="col-12 col-xl-9 col-xxl-10">
                <section class="d-flex flex-column justify-content-center align-items-center">
                    <h1 class="category-title text-center py-4 my-5 px-3 px-md-5">Liste des prestations</h1>

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
                    <!-- TABLEAUX -->
                    <!-- ========================================================================================================================================================================== -->

                    <?php foreach ($categories_services as $key => $item) { ?>
                        <div class="table-responsive pt-md-5 my-4 my-md-5">
                            <table class="table align-middle table-hover-green">
                                <thead>
                                    <tr>
                                        <th scope="col" class="<?= $item['category']->class_row ?>"></th>
                                        <th scope="col" class="<?= $item['category']->class_row ?>">
                                            <h2><?= $item['category']->name ?></h2>
                                        </th>
                                        <th scope="col" class="table-description <?= $item['category']->class_row ?>"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col">
                                            <div class="d-flex justify-content-end">
                                                <a href="/prestations/<?= $category->link ?>?id=<?= $item['category']->id_category ?>" class="btn view py-2 me-3" title="Voir sur le site"><i class="bi bi-globe2"></i></a>
                                                <!-- Bouton de validation -->
                                                <?php if (!$item['category']->published_at) { ?>
                                                    <button type="button" class="btn validate validateAll py-2 me-3" title="Publier la catégorie" data-id="<?= $item['category']->id_category ?>" data-param="1" data-bs-toggle="modal" data-bs-target="#displayModal">
                                                        <i class="bi bi-check2" data-id="<?= $item['category']->id_category ?>" data-param="1"></i>
                                                    </button>
                                                <?php } ?>

                                                <!-- Bouton éditer -->
                                                <a href="/gestion/modifier-une-categorie?id=<?= $item['category']->id_category ?>" class="btn edit py-2 me-3" title="Modifier la catégorie"><i class="bi bi-pen"></i></a>

                                                <!-- Bouton de désactivation -->
                                                <?php if ($item['category']->published_at) {

                                                    if ($item['category']->deactivated_at) { ?>
                                                        <button type="button" class="btn activate activateAll py-2 me-3" title="Activer la catégorie" data-id="<?= $item['category']->id_category ?>" data-param="1" data-bs-toggle="modal" data-bs-target="#displayModal">
                                                            <i class="bi bi-eye-slash" data-id="<?= $item['category']->id_category ?>" data-param="1"></i>
                                                        </button>

                                                    <?php } else { ?>
                                                        <button type="button" class="btn deactivate deactivateAll py-2 me-3" title="Désactiver la catégorie" data-id="<?= $item['category']->id_category ?>" data-param="1" data-bs-toggle="modal" data-bs-target="#displayModal">
                                                            <i class="bi bi-eye" data-id="<?= $item['category']->id_category ?>" data-param="1"></i>
                                                        </button>
                                                <?php }
                                                } ?>

                                                <!-- Bouton supprimer -->
                                                <button type="button" class="btn delete deleteAll py-2" title="Supprimer  la catégorie" data-id="<?= $item['category']->id_category ?>" data-param="1" data-bs-toggle="modal" data-bs-target="#displayModal">
                                                    <i class="bi bi-trash3" data-id="<?= $item['category']->id_category ?>" data-param="1"></i>
                                                </button>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="table-group-divider">
                                    <?php
                                    foreach ($item['services'] as $key => $service) { ?>
                                        <tr>
                                            <th class="<?= $service->class_row ?>" scope="row"><?= $key + 1 ?></th>
                                            <td>
                                                <?= ($service->icon_new) ? '<i class="bi bi-stars text-gold me-3" title="Nouveauté"></i>' : '' ?>
                                                <?= ($service->gender == 1) ? '<i class="bi bi-gender-male text-green me-3" title="Homme"></i>' : '<i class="bi bi-gender-female text-pink me-3" title="Femme"></i>'; ?>
                                                <?= ($service->package) ? '<i class="bi bi-box text-brown me-3" title="Forfait"></i>' : '' ?>
                                                <?= ($service->start_exclusive_date) ? '<i class="bi bi-calendar-range text-pink me-3" title="Exclusivité du ' . $service->start_exclusive_date . ' au ' . $service->end_exclusive_date . '"></i>' : '' ?>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center"><?= $service->service_name ?></div>
                                            </td>

                                            <td>
                                                <?php foreach ($service->durations as $key => $duration) { ?>
                                                    <div class="table-badge-beige d-flex justify-content-center align-items-center fw-bold py-1 px-2 my-2"><?= $duration ?> min</div>
                                                <?php } ?>
                                            </td>

                                            <td>
                                                <?php foreach ($service->prices as $key => $price) { ?>
                                                    <div class="table-badge-green d-flex justify-content-center align-items-center py-1 px-2 my-2" <?= ($service->discount_display) ? 'title="Promotion du ' . $service->discount_start_date . ' au ' . $service->discount_end_date . '"' : '' ?>><?= ($service->discount_display) ? '<span class="text-decoration-line-through me-3"> ' . $price . ' €</span>' . $service->reduced_prices[$key] : $price ?> €</div>
                                                <?php } ?>
                                            </td>

                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <!-- Bouton de publication -->
                                                    <?php if (!$service->service_published_at && !$service->start_exclusive_date) { ?>
                                                        <button type="button" class="btn validate py-2 me-3" title="Publier la prestation" data-id="<?= $service->id_service ?>" data-param="2" data-bs-toggle="modal" data-bs-target="#displayModal">
                                                            <i class="bi bi-check2" data-id="<?= $service->id_service ?>" data-param="2"></i>
                                                        </button>
                                                    <?php } ?>

                                                    <!-- Bouton d'édition -->
                                                    <a href="/gestion/modifier-une-prestation?id=<?= $service->id_service ?>" class="btn edit py-2 me-3" title="Modifier la prestation"><i class="bi bi-pen"></i></a>

                                                    <!-- Bouton de désactivation -->
                                                    <?php if ($service->service_published_at || $service->start_exclusive_date) {

                                                        if ($service->service_deactivated_at) { ?>
                                                            <button type="button" class="btn activate py-2 me-3" title="Activer la prestation" data-id="<?= $service->id_service ?>" data-param="2" data-bs-toggle="modal" data-bs-target="#displayModal">
                                                                <i class="bi bi-eye-slash" data-id="<?= $service->id_service ?>" data-param="2"></i>
                                                            </button>

                                                        <?php } else { ?>
                                                            <button type="button" class="btn deactivate py-2 me-3" title="Désactiver la prestation" data-id="<?= $service->id_service ?>" data-param="2" data-bs-toggle="modal" data-bs-target="#displayModal">
                                                                <i class="bi bi-eye" data-id="<?= $service->id_service ?>" data-param="2"></i>
                                                            </button>
                                                    <?php }
                                                    } ?>

                                                    <!-- Bouton de suppression -->
                                                    <button type="button" class="btn delete py-2" title="Supprimer la prestation" data-id="<?= $service->id_service ?>" data-param="2" data-bs-toggle="modal" data-bs-target="#displayModal">
                                                        <i class="bi bi-trash3" data-id="<?= $service->id_service ?>" data-param="2"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </section>
            </div>

        </div>

    </div>
</main>



<?php
include(__DIR__ . './../../views/templates/modal.php');
?>