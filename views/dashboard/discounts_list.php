<main>
    <div class="container-fluid px-0">

        <div class="row justify-content-around mx-0">

            <?php
            include(__DIR__ . './../../views/templates/dashboard_nav.php');
            ?>

            <div class="col-12 col-xl-9 col-xxl-10">

                <section class="d-flex flex-column justify-content-center align-items-center pb-5">
                    <h1 class="category-title text-center py-4 my-5 px-3 px-md-5">Promotions</h1>


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

                    <?php if (!empty($discounts)) { ?>
                        <div class="table-responsive pt-lg-5 my-4 my-md-5">
                            <table class="table align-middle table-hover-green">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col">
                                            <h2>Promotions enregistrées</h2>
                                        </th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col">
                                            <div class="d-flex justify-content-end">
                                                <!-- Bouton supprimer -->
                                                <button type="button" class="btn delete deleteAll py-2" title="Supprimer toutes les promotions" data-id="" data-param="3" data-method="1" data-bs-toggle="modal" data-bs-target="#displayModal">
                                                    <i class="bi bi-trash3" data-id="" data-param="3" data-method="1"></i>
                                                </button>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="table-group-divider">
                                    <?php foreach ($discounts as $key => $discount) { ?>
                                        <tr>
                                            <th class="<?= $discount->class_row ?>" scope="row"><?= $key + 1 ?></th>
                                            <td>
                                                <?= ($discount->icon == 2) ? '<i class="bi bi-globe2 text-green" title="Actuellement en ligne"></i>' : '' ?>
                                                <?= ($discount->icon == 1) ? '<i class="bi bi-hourglass-split text-gold" title="En attente"></i>' : '' ?>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center fw-bold"><?= $discount->categories ?></div>
                                            </td>
                                            <td>
                                                <div class="table-badge-green d-flex justify-content-center align-items-center px-2 py-2"><?= $discount->discount ?></div>
                                            </td>
                                            <td>
                                                <div class="table-badge-beige d-flex justify-content-center align-items-center text-center fw-bold text-nowrap w-100 px-3 py-2">Du <?= $discount->start_date ?> au <?= $discount->end_date ?></div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <!-- Bouton éditer -->
                                                    <a href="/gestion/modifier-une-promotion?id=<?= $discount->id_discount ?>" class="btn edit py-2 me-3" title="Modifier la promotion"><i class="bi bi-pen"></i></a>

                                                    <!-- Bouton de désactivation -->
                                                    <?php if ($discount->deactivated_at) { ?>
                                                        <button type="button" class="btn activate py-2 me-3" title="Activer la catégorie" data-id="<?= $discount->id_discount ?>" data-param="3" data-bs-toggle="modal" data-bs-target="#displayModal">
                                                            <i class="bi bi-eye-slash" data-id="<?= $discount->id_discount ?>" data-param="3"></i>
                                                        </button>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn deactivate py-2 me-3" title="Désactiver la promotion" data-id="<?= $discount->id_discount ?>" data-param="3" data-bs-toggle="modal" data-bs-target="#displayModal">
                                                            <i class="bi bi-eye" data-id="<?= $discount->id_discount ?>" data-param="3"></i>
                                                        </button>
                                                    <?php } ?>

                                                    <!-- Bouton supprimer -->
                                                    <button type="button" class="btn delete py-2" title="Supprimer la promotion" data-id="<?= $discount->id_discount ?>" data-param="3" data-method="2" data-bs-toggle="modal" data-bs-target="#displayModal">
                                                        <i class="bi bi-trash3" data-id="<?= $discount->id_discount ?>" data-param="3" data-method="2"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                    <?php } ?>


                    <a href="/gestion/ajouter-une-promotion" class="btn btn-classic mt-4">Ajouter une promotion</a>
                </section>

            </div>

        </div>

    </div>
</main>


<?php
include(__DIR__ . './../../views/templates/modal.php');
?>