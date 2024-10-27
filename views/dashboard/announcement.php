<main>
    <div class="container-fluid px-0">

        <div class="row justify-content-around mx-0">

            <?php
            include(__DIR__ . './../../views/templates/dashboard_nav.php');
            ?>

            <div class="col-12 col-xl-9 col-xxl-10">
                <section class="d-flex flex-column justify-content-center align-items-center">
                    <h1 class="category-title text-center py-4 my-5 px-3 px-md-5">Mes annonces</h1>

                    <!-- ========================================================================================================================================================================== -->
                    <!-- TABLEAU DES ANNONCES PASSÉES -->
                    <!-- ========================================================================================================================================================================== -->

                    <?php if (!empty($announcements)) { ?>
                        <div class="table-responsive pt-md-5 my-4 my-md-5">
                            <table class="table align-middle table-hover-brown table-news">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">
                                            <h2>Anciennes annonces</h2>
                                        </th>
                                        <th scope="col"></th>
                                        <th scope="col">
                                            <div class="d-flex justify-content-end">
                                                <!-- Bouton supprimer -->
                                                <a href="" class="btn delete deleteAll py-2" title="Supprimer toutes les annonces" data-id="" data-param="4" data-method="1" data-bs-toggle="modal" data-bs-target="#displayModal" id="deleteAll">
                                                    <i class="bi bi-trash3" data-id="" data-param="4" data-method="1"></i>
                                                </a>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="table-group-divider">
                                    <?php foreach ($announcements as $announcement) { ?>
                                        <tr>
                                            <th scope="row"><?= $count++ ?></th>
                                            <td>
                                                <?= html_entity_decode($announcement->content) ?>
                                            </td>
                                            <td>
                                                <div class="table-badge-beige d-flex justify-content-center align-items-center text-center fw-bold text-nowrap w-100 px-3 py-2">Du <?= $announcement->start_date ?> au <?= $announcement->end_date ?></div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <!-- Bouton supprimer -->
                                                    <button type="button" class="btn delete delete-one py-2" title="Supprimer l'annonce" data-id="<?= $announcement->id_announcement ?>" data-param="4" data-method="2" data-bs-toggle="modal" data-bs-target="#displayModal">
                                                        <i class="bi bi-trash3" data-id="<?= $announcement->id_announcement ?>" data-param="4" data-method="2"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr> <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

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

                    <form method="POST" action="/gestion/mes-annonces?id=<?= isset($actual_announcement) ? $actual_announcement->id_announcement : 0 ?>" class="d-flex flex-column align-items-center w-100" id="announcement-form" novalidate>

                        <!-- -------------------------------------------------------------- -->
                        <!-- MODIFICATION OU DÉSACTIVATION DE L'ANNONCE -->
                        <?php if (isset($actual_announcement)) { ?>
                            <div class="dashboard-form d-flex flex-column align-items-center">
                                <label class="fw-bold mt-4 mt-md-5 mb-4 mb-md-0">Une annonce est actuellement en cours :</label>

                                <div class="btn-group d-flex flex-column flex-md-row w-100 mb-4 mb-lg-5 py-md-5" role="group" aria-label="Activer / Désactiver l'annonce">
                                    <input type="radio" class="btn-check status-choice" name="active" value="1" id="modify" autocomplete="off" required checked>
                                    <label class="btn btn-radio" for="modify">Modifier</label>

                                    <input type="radio" class="btn-check status-choice" name="active" value="0" id="deactivation" autocomplete="off" data-bs-toggle="modal" data-bs-target="#displayModal" data-id="<?= $actual_announcement->id_announcement ?>" data-param="4">
                                    <label class="btn btn-radio" for="deactivation">Désactiver</label>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- -------------------------------------------------------------- -->

                        <!-- ========================================================================================================================================================================= -->

                        <!-- -------------------------------------------------------------- -->
                            <!-- APERÇU DE L'ANNONCE -->
                        <div class="announcement mt-5">
                            <div class="row mx-0 announcement-content">
                                <div class="col d-flex justify-content-center">
                                    <div class="d-flex flex-wrap justify-content-center align-items-center py-2 pe-3">
                                        <i class="bi bi-megaphone-fill announcement-icon"></i>
                                        <p class="d-flex flex-wrap justify-content-center align-items-center text-center pt-2 pt-md-0 ps-md-5 my-0" id="preview">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- -------------------------------------------------------------- -->

                        <!-- ========================================================================================================================================================================= -->

                        <div class="dashboard-form d-flex flex-column align-items-center">

                            <!-- -------------------------------------------------------------- -->
                            <!-- CONTENU DE L'ANNONCE -->
                            <div class="mb-4 mb-md-5 pt-4 pt-md-5 w-100">
                                <p class="text-center text-green fst-italic mb-5">Afin de limiter les erreurs d'orthographe, vous pouvez faire vérifier votre texte sur le site de <a href="https://bonpatron.com/fr/" class="text-pink underline" target="_blank" rel="noopener noreferrer">Bonpatron</a>.</p>
                                <div class="d-flex flex-column flex-md-row justify-content-between">
                                    <label for="content" class="form-label me-3">Contenu * :</label>
                                    <small>Nb de caractères restants : <span id="counterChar"><?= TEXT_LIMIT['large'] ?></span></small>
                                </div>
                                <textarea class="form-control <?= (empty($content['message'])) ? '' : 'error-form' ?> textarea" name="content" maxlength="<?= TEXT_LIMIT['large'] ?>" id="content" required><?= $content['data'] ?? $actual_announcement->content ?? '' ?></textarea>

                                <small class="<?= (empty($content['message'])) ? 'd-none' : '' ?> d-block text-danger fst-italic mt-2" role="alert" aria-errormessage="content" id="contentError"><?= $content['message'] ?? '' ?></small>
                                <small class="d-none d-block text-danger fst-italic mt-2" role="alert" aria-errormessage="content" id="contentLenght"></small>
                                <button type="button" class="formatting mt-3 mx-2">Mettre en valeur</button>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- DATES DE L'ANNONCE -->
                            <label class="text-center fw-bold mb-4">Quand l'annonce doit-elle paraître sur le site ?</label>

                            <div class="d-flex flex-column flex-md-row justify-content-around w-100 mb-4 mb-md-5">
                                <div class="form-div me-md-5 mb-3 mb-md-0">
                                    <label for="startDate" class="form-label me-3">Date de début * :</label>
                                    <input type="date" class="form-control <?= (empty($dates['first_date']['message'])) ? '' : 'error-form' ?>" id="startDate" name="startDate" min="<?= date('Y-m-d') ?>" value="<?= $dates['first_date']['data'] ?? $actual_announcement->start_date ?? '' ?>" pattern="<?= $regex->get_date() ?>" required>
                                    <small class="<?= (empty($dates['first_date']['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="startDate" id="startDateError"><?= $dates['first_date']['message'] ?? '' ?></small>
                                </div>

                                <span class="align-self-center fw-bold">au</span>

                                <div class="form-div ms-md-5 mt-3 mt-md-0">
                                    <label for="endDate" class="form-label me-3">Date de fin * :</label>
                                    <input type="date" class="form-control <?= (empty($dates['last_date']['message'])) ? '' : 'error-form' ?>" id="endDate" name="endDate" min="<?= date('Y-m-d') ?>" value="<?= $dates['last_date']['data'] ?? $actual_announcement->end_date ?? '' ?>" pattern="<?= $regex->get_date() ?>" required>
                                    <small class="<?= (empty($dates['last_date']['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="endDate" id="endDateError"><?= $dates['last_date']['message'] ?? '' ?></small>
                                </div>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- BOUTON DE VALIDATION -->
                            <div class="d-flex justify-content-center pb-md-5 mt-4 mt-md-5 mb-5 w-100">
                                <button type="submit" class="btn btn-classic py-2"><i class="bi bi-pencil-fill me-3" aria-hidden="true"></i><?= (isset($actual_announcement)) ? 'Modifier' : 'Ajouter' ?> l'annonce</button>
                            </div>
                            <!-- -------------------------------------------------------------- -->
                        </div>
                    </form>
                    <!-- ========================================================================================================================================================================= -->

                </section>
            </div>

        </div>

    </div>
</main>


<?php
include(__DIR__ . './../../views/templates/modal.php');
?>