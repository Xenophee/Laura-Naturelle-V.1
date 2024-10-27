<main>
    <div class="container-fluid px-0">
    <h1 class="text-center pt-5 mt-md-5">Contact</h1>

        <section class="pb-5">
            <!-- TITRE CATEGORIE -->
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
            <div class="row mx-0 px-md-5 pb-3 pb-md-5 my-md-5">
                <div class="col">
                    <h2 class="category-title text-center py-4 my-5">Des questions ? N’hésitez pas à contacter L’Aura Natur’elle !</h2>
                    <p class="service-text text-center pt-md-5 mt-md-5">Vous recevrez une réponse dans les 24h qui suivent.</p>
                </div>
            </div>
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->


            <!-- ========================================================================================================================================================================== -->
            <!-- MESSAGE FLASH -->
            <!-- ========================================================================================================================================================================== -->

            <?php if (Flash::isExist()) {
                $flash = Flash::getMessage(); ?>
                <div class="d-flex justify-content-center ">
                    <div class="alert alert-dismissible <?= $flash['class'] ?? '' ?> fade show w-50" data-bs-theme="dark" role="alert">
                        <div><i class="bi <?= $flash['icon'] ?? '' ?> me-3"></i><?= $flash['message'] ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php } ?>



            <!-- ========================================================================================================================================================================== -->
            <!-- FORMULAIRE -->
            <!-- ========================================================================================================================================================================== -->
            <div class="row justify-content-around mx-0 py-md-5 mt-5">

                <!-- ------------------------------------------------------------------------------------------------------ -->
                <!-- GRANDE IMAGE DE GAUCHE -->
                <div class="col-12 col-md-1 col-xl-2 bg-form d-none d-md-block px-0">
                    <img src="../public/assets/img/illustrations/contact/left.webp" alt="Illustration d'huile de bien être" class="img-fluid">
                </div>
                <!-- ------------------------------------------------------------------------------------------------------ -->

                <!-- ------------------------------------------------------------------------------------------------------ -->
                <!-- FORMULAIRE -->
                <div class="col-12 col-sm-11 col-md-7 col-lg-7 col-xl-6 col-xxl-5">
                    <form method="POST" novalidate>
                        <fieldset>
                            <legend class="text-center py-2 mb-5">Envoyer un message</legend>

                            <!-- ---------------------------------------------------- -->
                            <!-- CIVILITE -->
                            <label>Civilité * :</label>
                            <div class="mt-2 mb-4 d-flex flex-wrap justify-content-around justify-content-sm-start">
                                <div class="d-inline d-flex align-items-center me-3">
                                    <input type="radio" name="civility" value="1" id="mr" class="form-check-input me-2" required <?= (isset($civility) && $civility['data'] == 1) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mr">M</label>
                                </div>
                                <div class="ps-3 d-inline d-flex align-items-center">
                                    <input type="radio" name="civility" value="2" id="mrs" class="form-check-input me-2" <?= (isset($civility) && $civility['data'] == 2) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="mrs">Mme</label>
                                </div>
                                <small class="<?= (empty($civility['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-3 mt-md-0 ms-md-5" role="alert" aria-errormessage="civility" id="civilityError"><?= $civility['message'] ?? '' ?></small>
                            </div>

                            <!-- ---------------------------------------------------- -->
                            <!-- NOM -->
                            <div class="mb-4">
                                <label for="lastname" class="form-label">Nom * :</label>
                                <input type="text" class="form-control <?= (empty($lastname['message'])) ? '' : 'error-form' ?>" id="lastname" name="lastname" autocomplete="family-name" pattern="<?= $regex->get_text() ?>" value="<?= $lastname['data'] ?? '' ?>" required>
                                <small class="<?= (empty($lastname['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="lastname" id="lastnameError"><?= $lastname['message'] ?? '' ?></small>
                            </div>

                            <!-- ---------------------------------------------------- -->
                            <!-- PRENOM -->
                            <div class="mb-4">
                                <label for="firstname" class="form-label">Prénom * :</label>
                                <input type="text" class="form-control <?= (empty($firstname['message'])) ? '' : 'error-form' ?>" id="firstname" name="firstname" autocomplete="given-name" pattern="<?= $regex->get_text() ?>" value="<?= $firstname['data'] ?? '' ?>" required>
                                <small class="<?= (empty($firstname['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="firstname" id="firstnameError"><?= $firstname['message'] ?? '' ?></small>
                            </div>

                            <!-- ---------------------------------------------------- -->
                            <!-- ADRESSE MAIL -->
                            <div class="mb-4">
                                <label for="email" class="form-label">Adresse mail * :</label>
                                <input type="email" class="form-control <?= (empty($email['message'])) ? '' : 'error-form' ?>" id="email" name="email" autocomplete="email" pattern="<?= $regex->get_email() ?>" value="<?= $email['data'] ?? '' ?>" required>
                                <small class="<?= (empty($email['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="email" id="emailError"><?= $email['message'] ?? '' ?></small>
                            </div>

                            <!-- ---------------------------------------------------- -->
                            <!-- OBJET -->
                            <div class="mb-4">
                                <label for="object" class="form-label mb-2">Objet * :</label>
                                <select class="form-select <?= (empty($object['message'])) ? '' : 'error-form' ?>" id="object" name="object" required>
                                    <option value="0">-</option>
                                    <?php foreach (OBJECTS_MAIL as $key => $object_mail) { ?>
                                        <option value="<?= $key + 1 ?>" <?= (isset($object) && $object['data'] == $key + 1) ? 'selected' : '' ?>><?= $object_mail ?></option>
                                    <?php } ?>

                                </select>
                                <small class="<?= (empty($object['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="object" id="objectError"><?= $object['message'] ?? '' ?></small>
                            </div>

                            <!-- ---------------------------------------------------- -->
                            <!-- MESSAGE -->
                            <div class="mt-4 mb-5">
                                <label for="request" class="form-label">Votre message * :</label>
                                <textarea class="form-control textarea <?= (empty($request['message'])) ? '' : 'error-form' ?>" id="request" name="request" required><?= $request['data'] ?? '' ?></textarea>
                                <small class="<?= (empty($request['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="request" id="requestError"><?= $request['message'] ?? '' ?></small>
                            </div>

                            <!-- ---------------------------------------------------- -->
                            <!-- BOUTON -->
                            <div class="d-flex flex-column justify-content-center align-items-center">
                            <small class="<?= (empty($captcha['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="captcha" id="captchaError"><?= $captcha['message'] ?? '' ?></small>
                            <div class="g-recaptcha" data-sitekey="<?= CLIENT_KEY_CAPTCHA ?>" id="captcha"></div>
                                <button type="submit" class="btn btn-classic d-flex justify-content-center align-items-center py-2 mt-4"><i class="bi bi-envelope me-3" aria-hidden="true"></i>Envoyer</button>
                            </div>

                        </fieldset>
                    </form>
                </div>
                <!-- ------------------------------------------------------------------------------------------------------ -->

                <!-- ------------------------------------------------------------------------------------------------------ -->
                <!-- GRANDE IMAGE DE DROITE -->
                <div class="col-12 col-md-1 col-xl-2 bg-form d-none d-md-block px-0">
                    <img src="../public/assets/img/illustrations/contact/right.webp" alt="Illustration de maquillages" class="img-fluid">
                </div>
                <!-- ------------------------------------------------------------------------------------------------------ -->
            </div>
        </section>

    </div>
</main>