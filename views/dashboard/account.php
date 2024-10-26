<main>
    <div class="container-fluid px-0">

        <div class="row justify-content-around mx-0">

            <?php
            include(__DIR__ . './../../views/templates/dashboard_nav.php');
            ?>

            <div class="col-12 col-xl-9 col-xxl-10">
                <section class="d-flex flex-column justify-content-center align-items-center">
                    <h1 class="category-title text-center py-4 my-5 px-3 px-md-5">Mon Compte</h1>

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

                    <form method="post" class="dashboard-form mt-5" id="account-form" novalidate>

                        <!-- ============================================================================================================= -->
                        <!-- INFORMATIONS GÉNÉRALES -->
                        <!-- ============================================================================================================= -->
                        <fieldset class="mb-md-5">
                            <legend class="text-center py-2 mb-5">Informations générales</legend>
                            <!-- -------------------------------------------------------------- -->
                            <!-- ADRESSE MAIL -->
                            <div class="mb-4">
                                <label for="email" class="form-label me-3">Adresse mail * :</label>
                                <input type="email" class="form-control <?= (empty($email['message'])) ? '' : 'error-form' ?>" id="email" name="email" autocomplete="email" value="<?= $email['data'] ?? $user->email ?>" pattern="<?= $regex->get_email() ?>" maxlength="<?= TEXT_LIMIT['medium'] ?>" required>
                                <small class="<?= (empty($email['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="email" id="emailError"><?= $email['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- NUMÉRO DE TÉLÉPHONE -->
                            <div class="mb-4">
                                <label for="phone" class="form-label me-3">Numéro de téléphone * :</label>
                                <input type="text" class="form-control <?= (empty($phone['message'])) ? '' : 'error-form' ?>" id="phone" name="phone" autocomplete="tel" value="<?= $phone['data'] ?? $user->phone ?>" pattern="<?= $regex->get_phone() ?>" required>
                                <small class="<?= (empty($phone['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="phone" id="phoneError"><?= $phone['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- ADRESSE -->
                            <div class="mb-4">
                                <label for="address" class="form-label me-3">Adresse * :</label>
                                <input type="text" class="form-control <?= (empty($address['message'])) ? '' : 'error-form' ?>" id="address" name="address" autocomplete="address-line1" value="<?= $address['data'] ?? $user->address ?>" pattern="<?= $regex->get_address() ?>" maxlength="<?= TEXT_LIMIT['medium'] ?>" required>
                                <small class="<?= (empty($address['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="address" id="addressError"><?= $address['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- CODE POSTAL -->
                            <div class="mb-4">
                                <label for="zipcode" class="form-label me-3">Code postal * :</label>
                                <input type="text" class="form-control <?= (empty($zipcode['message'])) ? '' : 'error-form' ?>" id="zipcode" name="zipcode" autocomplete="postal-code" value="<?= $zipcode['data'] ?? $user->zipcode ?>" pattern="<?= $regex->get_zipcode() ?>" required>
                                <small class="<?= (empty($zipcode['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="zipcode" id="zipcodeError"><?= $zipcode['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- VILLE -->
                            <div class="mb-4">
                                <label for="city" class="form-label me-3">Ville * :</label>
                                <input type="text" class="form-control <?= (empty($city['message'])) ? '' : 'error-form' ?>" id="city" name="city" autocomplete="address-level2" value="<?= $city['data'] ?? $user->city ?>" pattern="<?= $regex->get_text() ?>" maxlength="<?= TEXT_LIMIT['medium'] ?>" required>
                                <small class="<?= (empty($city['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="city" id="cityError"><?= $city['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->
                        </fieldset>
                        <!-- ============================================================================================================= -->

                        <!-- ============================================================================================================= -->
                        <!-- CHANGEMENT DE MOT DE PASSE -->
                        <!-- ============================================================================================================= -->
                        <fieldset class="pt-5">
                            <legend class="text-center py-2 mb-5">Changer de mot de passe</legend>
                            <!-- -------------------------------------------------------------- -->
                            <!-- MOT DE PASSE ACTUEL -->
                            <div class="mb-4">
                                <label for="password" class="form-label mb-2">Mot de passe actuel :</label>
                                <input type="password" class="form-control <?= (empty($passwords['password']['message'])) ? '' : 'error-form' ?>" id="password" name="password" value="<?= isset($is_updated) ? '' : $passwords['password']['data'] ?? '' ?>">
                                <small class="<?= (empty($passwords['password']['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="password" id="passwordError"><?= $passwords['password']['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- NOUVEAU MOT DE PASSE-->
                            <div class="mb-4">
                                <label for="newPassword" class="form-label mb-2">Nouveau mot de passe <abbr title="au moins une majuscule, une minuscule, un chiffre et un caractère spécial (@#$%§^&+=!)">(?)</abbr> :</label>
                                <input type="password" class="form-control <?= (empty($passwords['newPassword']['message'])) ? '' : 'error-form' ?>" id="newPassword" name="newPassword" pattern="<?= $regex->get_password() ?>" value="<?= isset($is_updated) ? '' : $passwords['newPassword']['data'] ?? '' ?>">
                                <small class="<?= (empty($passwords['newPassword']['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="newPassword" id="newPasswordError"><?= $passwords['newPassword']['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- CONFIRMATION DU MOT DE PASSE -->
                            <div class="mb-4">
                                <label for="confirmPassword" class="form-label mb-2">Confirmer le mot de passe :</label>
                                <input type="password" class="form-control <?= (empty($passwords['confirmPassword']['message'])) ? '' : 'error-form' ?>" id="confirmPassword" name="confirmPassword" value="<?= isset($is_updated) ? '' : $passwords['confirmPassword']['data'] ?? '' ?>">
                                <small class="<?= (empty($passwords['confirmPassword']['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="confirmPassword" id="confirmPasswordError"><?= $passwords['confirmPassword']['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->
                        </fieldset>
                        <!-- ============================================================================================================= -->

                        <!-- -------------------------------------------------------------- -->
                        <!-- BOUTON DE VALIDATION -->
                        <div class="d-flex justify-content-center pb-md-5 my-5">
                            <button type="submit" class="btn btn-classic btn-large py-2"><i class="bi bi-pencil-fill me-3" aria-hidden="true"></i>Soumettre les modifications</button>
                        </div>
                        <!-- -------------------------------------------------------------- -->

                    </form>
                </section>
            </div>

        </div>

    </div>
</main>