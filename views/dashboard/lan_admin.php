<main>
    <div class="container-fluid px-0">
        <section class="pb-5">
            <h1 class="category-title text-center py-4 my-5 px-3 px-md-5">Connexion</h1>

            <div class="row justify-content-around mx-0 py-md-5 mt-5">

                <!-- ========================================================================================================================================================================== -->
                <!-- FORMULAIRE -->
                <!-- ========================================================================================================================================================================== -->

                <div class="col-12 col-sm-11 col-md-7 col-lg-7 col-xl-6 col-xxl-5">
                    <form method="POST">
                        <fieldset>
                            <legend class="text-center py-2 mb-5">Se connecter</legend>

                            <!-- ---------------------------------------------------- -->
                            <!-- ADRESSE MAIL -->
                            <div class="mb-4 mb-xl-5 pt-xl-5">
                                <label for="email" class="form-label">Adresse mail * :</label>
                                <input type="email" class="form-control <?= (empty($account['email']['message'])) ? '' : 'error-form' ?>" id="email" name="email" autocomplete="email" value="<?= $account['email']['data'] ?? '' ?>" pattern="<?= $regex->get_email() ?>" required>
                                <small class="<?= (empty($account['email']['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="email" id="emailError"><?= $account['email']['message'] ?? '' ?></small>
                            </div>
                            <!-- ---------------------------------------------------- -->

                            <!-- ---------------------------------------------------- -->
                            <!-- MOT DE PASSE -->
                            <div class="mb-4 mb-xl-5">
                                <label for="password" class="form-label">Mot de passe * :</label>
                                <input type="password" class="form-control <?= (empty($account['password']['message'])) ? '' : 'error-form' ?>" id="password" name="password" value="<?= $account['password']['data'] ?? '' ?>" required>
                                <small class="<?= (empty($account['password']['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="password" id="passwordError"><?= $account['password']['message'] ?? '' ?></small>
                            </div>
                            <!-- ---------------------------------------------------- -->

                            <!-- ---------------------------------------------------- -->
                            <!-- BOUTON DE VALIDATION -->
                            <div class="d-flex justify-content-center pt-xl-5 mt-5">
                                <button type="submit" class="btn btn-classic d-flex justify-content-center align-items-center py-2"><i class="bi bi-key me-3" aria-hidden="true"></i>Se connecter</button>
                            </div>
                            <!-- ---------------------------------------------------- -->

                        </fieldset>
                    </form>
                    <!-- ========================================================================================================================================================================== -->
                </div>
            </div>
        </section>

    </div>
</main>