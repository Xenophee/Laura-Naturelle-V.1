<main>
    <div class="container-fluid px-0">

        <div class="row justify-content-around mx-0">

            <?php
            include(__DIR__ . './../../views/templates/dashboard_nav.php');
            ?>

            <div class="col-12 col-xl-9 col-xxl-10">
                <section class="d-flex flex-column justify-content-center align-items-center">
                    <h1 class="category-title text-center py-4 my-5 px-3 px-md-5">Ajouter une prestation</h1>

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


                    <form method="post" class="dashboard-form mt-5" action="../../controllers/dashboard/service_manager_controller.php?id=<?= $id ?>" id="service-form">

                        <!-- =============================================================================================================== -->
                        <!-- INFORMATION GÉNÉRALE -->
                        <!-- =============================================================================================================== -->

                        <fieldset>
                            <legend class="text-center py-2 mb-4 mb-md-5">Informations générales</legend>
                            <!-- -------------------------------------------------------------- -->
                            <!-- CATÉGORIE DE LA PRESTATION -->
                            <div class="mb-4">
                                <label for="object" class="form-label mb-2">Catégorie de la prestation * :</label>
                                <select class="form-select <?= (empty($id_category['message'])) ? '' : 'error-form' ?>" id="category" name="category" required>
                                    <option value="0">-</option>
                                    <?php foreach ($categories as $category) {
                                        $is_selected = ($selected_category == $category->id_category) ? 'selected' : '';
                                        echo "<option value=\"$category->id_category\" $is_selected>$category->name</option>";
                                    } ?>
                                </select>
                                <small class="<?= (empty($id_category['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="category" id="categoryError"><?= $id_category['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- NOM DE LA PRESTATION -->
                            <div class="mb-4">
                                <label for="title" class="form-label me-3">Nom * :</label>
                                <input type="text" class="form-control <?= (empty($name['message'])) ? '' : 'error-form' ?>" id="title" name="title" value="<?= $name['data'] ?? $service->name ?? '' ?>" pattern="<?= $regex->get_text() ?>" maxlength="<?= TEXT_LIMIT['short'] ?>" required>
                                <small class="<?= (empty($name['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="title" id="titleError"><?= $name['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- DESCRIPTION DE LA PRESTATION -->
                            <div class="mb-4 pt-md-5">
                                <p class="text-center text-green fst-italic mb-5">Afin de limiter les erreurs d'orthographe, vous pouvez faire vérifier votre texte sur le site de <a href="https://bonpatron.com/fr/" class="text-pink underline" target="_blank" rel="noopener noreferrer">Bonpatron</a>.</p>
                                <div class="d-flex flex-column flex-md-row justify-content-between">
                                    <label for="description" class="form-label me-3">Description :</label>
                                    <small>Nb de caractères restants : <span id="counterChar"><?= TEXT_LIMIT['medium_plus'] ?></span></small>
                                </div>
                                <textarea class="form-control <?= (empty($description['message'])) ? '' : 'error-form' ?> textarea" name="description" id="description" maxlength="<?= TEXT_LIMIT['medium_plus'] ?>"><?= $description['data'] ?? $service->description ?? '' ?></textarea>
                                <small class="<?= (empty($description['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="description" id="descriptionLenght"><?= $description['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->
                        </fieldset>

                        <!-- ================================================================================================================ -->
                        <!-- TARIFICATION -->
                        <!-- ================================================================================================================ -->

                        <fieldset>
                            <legend class="text-center py-2 mt-4 mb-4 mb-lg-5">Tarification</legend>

                            <!-- -------------------------------------------------------------- -->
                            <!-- DURÉE ET TARIF -->
                            <div id="pricings">
                                <?php for ($i = 1; $i <= $pricings_number; $i++) { ?>
                                    <div class="d-flex flex-column flex-md-row justify-content-between pricing py-3" id="pricing<?= $i ?>">
                                        <div class="mb-4">
                                            <label for="duration<?= $i ?>" class="form-label me-3">Durée (en minutes) * :</label>
                                            <input type="number" class="form-control <?= (empty($durations[$i]['message'])) ? '' : 'error-form' ?>" id="duration<?= $i ?>" name="duration<?= $i ?>" value="<?= $durations[$i]['data'] ?? $service->duration[$i -1] ?? '' ?>" min="0" required>
                                            <small class="<?= (empty($durations[$i]['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="duration<?= $i ?>" id="durationError<?= $i ?>"><?= $durations[$i]['message'] ?? '' ?></small>
                                        </div>

                                        <div class="mb-md-4">
                                            <label for="price<?= $i ?>" class="form-label me-3">Tarif * :</label>
                                            <input type="number" class="form-control <?= (empty($prices[$i]['message'])) ? '' : 'error-form' ?>" id="price<?= $i ?>" name="price<?= $i ?>" value="<?= $prices[$i]['data'] ?? $service->price[$i -1] ?? '' ?>" min="0" required>
                                            <small class="<?= (empty($prices[$i]['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="price<?= $i ?>" id="priceError<?= $i ?>"><?= $prices[$i]['message'] ?? '' ?></small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- BOUTON D'AJOUT D'UNE TARIFICATION SUPPLÉMENTAIRE ET DE SUPPRESSION -->
                            <div class="d-flex flex-column align-items-center mb-5 mt-4">
                                <small class="d-none text-danger text-center fst-italic mb-2" role="alert" id="addError">Vous ne pouvez pas ajouter de tarification supplémentaire.</small>
                                <div>
                                    <button type="button" class="btn btn-classic" id="addPricing" aria-errormessage="addError" title="Ajouter une tarification"><i class="bi bi-plus-circle me-3" aria-hidden="true"></i>Ajouter</button>
                                    <button type="button" class="d-none btn btn-classic mt-4 mt-md-0 ms-lg-4" id="deletePricing" title="Supprimer une tarification"><i class="bi bi-trash3 me-3" aria-hidden="true"></i>Supprimer</button>
                                </div>
                            </div>
                            <!-- -------------------------------------------------------------- -->
                        </fieldset>

                        <!-- ================================================================================================================= -->
                        <!-- TYPE DE PRESTATION -->
                        <!-- ================================================================================================================= -->

                        <fieldset>
                            <legend class="text-center py-2 mb-4 mb-md-5">Type de la prestation</legend>

                            <div>
                                <!-- -------------------------------------------------------------- -->
                                <!-- PRESTATION CLASSIQUE OU FORFAIT -->
                                <small class="<?= (empty($gender['message'])) ? 'd-none' : '' ?> d-block text-danger text-center fst-italic mt-2" role="alert" id="genderError"><?= $gender['message'] ?? '' ?></small>
                                <div class="btn-group d-flex mt-3 mb-5" role="group" aria-label="Choisir le type de prestation">

                                    <input type="radio" class="btn-check" name="gender" value="1" id="male" aria-errormessage="genderError" autocomplete="off" <?= (isset($gender) && $gender['data'] == 1) || (isset($service) && $service->gender == 1) ? 'checked' : '' ?> required>
                                    <label class="btn btn-radio" for="male">Prestation Homme</label>

                                    <input type="radio" class="btn-check" name="gender" value="2" id="female" aria-errormessage="genderError" autocomplete="off" <?= (isset($gender) && $gender['data'] == 2) || (isset($service) && $service->gender == 2) ? 'checked' : '' ?>>
                                    <label class="btn btn-radio" for="female">Prestation Femme</label>
                                </div>
                                <!-- -------------------------------------------------------------- -->

                                <!-- -------------------------------------------------------------- -->
                                <!-- PRESTATION CLASSIQUE OU FORFAIT -->
                                <small class="<?= (empty($package['message'])) ? 'd-none' : '' ?> d-block text-danger text-center fst-italic mt-2" role="alert" id="packageError"><?= $package['message'] ?? '' ?></small>
                                <div class="btn-group d-flex mt-3 mb-5" role="group" aria-label="Choisir le type de prestation">

                                    <input type="radio" class="btn-check" name="package" value="0" id="classic" aria-errormessage="packageError" autocomplete="off" <?= (isset($package) && $package['data'] === 0) || (isset($service) && $service->package === 0) ? 'checked' : '' ?> required>
                                    <label class="btn btn-radio" for="classic">Prestation classique</label>

                                    <input type="radio" class="btn-check" name="package" value="1" id="package" aria-errormessage="packageError" autocomplete="off" <?= (isset($package) && $package['data'] === 1) || (isset($service) && $service->package === 1) ? 'checked' : '' ?>>
                                    <label class="btn btn-radio" for="package">Prestation en forfait</label>
                                </div>
                                <!-- -------------------------------------------------------------- -->

                                <!-- -------------------------------------------------------------- -->
                                <!-- PRESTATION EXCLUSIVE OU PERMANENTE -->
                                <small class="<?= (empty($exclusive['message'])) ? 'd-none' : '' ?> d-block text-danger text-center fst-italic mt-2" role="alert" id="exclusiveError"><?= $exclusive['message'] ?? '' ?></small>
                                <div class="btn-group d-flex mt-3 mb-5" role="group" aria-label="Choisir le type de prestation">
                                    <input type="radio" class="btn-check type-choice" name="exclusive" value="0" id="permanent" aria-errormessage="exclusiveError" autocomplete="off" <?= (isset($exclusive) && $exclusive['data'] === 0) || (isset($service) && is_null($service->start_exclusive_date)) ? 'checked' : '' ?> required>
                                    <label class="btn btn-radio" for="permanent">Prestation permanente</label>

                                    <input type="radio" class="btn-check type-choice" name="exclusive" value="1" id="exclusive" aria-errormessage="exclusiveError" autocomplete="off" <?= (isset($exclusive) && $exclusive['data'] === 1) || (isset($service) && !is_null($service->start_exclusive_date)) ? 'checked' : '' ?>>
                                    <label class="btn btn-radio" for="exclusive">Prestation exclusive</label>
                                </div>
                                <!-- -------------------------------------------------------------- -->
                            </div>

                            <!-- -------------------------------------------------------------- -->
                            <!-- DATES EN CAS DE PRESTATIONS EXCLUSIVES -->
                            <div class="exclusive-dates d-none">
                                <div class="mb-4">
                                    <label for="startExclusiveDate" class="form-label me-3">Date de début * :</label>
                                    <input type="date" class="form-control <?= (empty($dates['first_date']['message'])) ? '' : 'error-form' ?>" id="startExclusiveDate" name="startExclusiveDate" value="<?= $dates['first_date']['data'] ?? $service->start_exclusive_date ?? '' ?>">
                                    <small class="<?= (empty($dates['first_date']['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="startExclusiveDate" id="startExclusiveDateError"><?= $dates['first_date']['message'] ?? '' ?></small>
                                </div>

                                <div class="mb-md-4">
                                    <label for="endExclusiveDate" class="form-label me-3">Date de fin * :</label>
                                    <input type="date" class="form-control <?= (empty($dates['last_date']['message'])) ? '' : 'error-form' ?>" id="endExclusiveDate" name="endExclusiveDate" value="<?= $dates['last_date']['data'] ?? $service->end_exclusive_date ?? '' ?>">
                                    <small class="<?= (empty($dates['last_date']['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="endExclusiveDate" id="endExclusiveDateError"><?= $dates['last_date']['message'] ?? '' ?></small>
                                </div>
                            </div>
                            <!-- -------------------------------------------------------------- -->
                        </fieldset>

                        <!-- -------------------------------------------------------------- -->
                        <!-- BOUTON DE VALIDATION -->
                        <div class="d-flex justify-content-center pb-md-5 my-5">
                            <button type="submit" class="btn btn-classic py-2"><i class="bi bi-pencil-fill me-3" aria-hidden="true"></i><?= (empty($id)) ? 'Ajouter' : 'Modifier' ?> la prestation</button>
                        </div>
                        <!-- -------------------------------------------------------------- -->

                    </form>
                </section>
            </div>

        </div>

    </div>
</main>