<main>
    <div class="container-fluid px-0">

        <div class="row justify-content-around mx-0">

            <?php
            include(__DIR__ . './../../views/templates/dashboard_nav.php');
            ?>

            <div class="col-12 col-xl-9 col-xxl-10">
                <section class="d-flex flex-column justify-content-center align-items-center">
                    <h1 class="category-title text-center py-4 my-5 px-3 px-md-5">Mes horaires</h1>

                    <!-- ========================================================================================================================================================================== -->
                    <!-- FORMULAIRE -->
                    <!-- ========================================================================================================================================================================== -->

                    <form method="POST" class="schedules-form d-flex flex-column align-items-center mt-md-5" id="schedules-form">

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

                        <div class="text-danger text-center fst-italic fw-bold fs-4" id="errorMessage"><?= $error ?? '' ?></div>

                        <!-- --------------------------------------------------------------- -->
                        <!-- JOUR -->
                        <?php foreach ($schedules_bdd as $schedule) { ?>
                            <fieldset class="schedules d-flex flex-column justify-content-center align-items-center py-4">
                                <legend class="text-center mb-4"><?= $schedule->week_day ?></legend>

                                <!-- --------------------------------------------------------------- -->
                                <!-- DÉTERMINE L'OUVERTURE -->
                                <div class="btn-group d-flex flex-wrap pb-4 pb-md-5 schedule-btn-group" role="group" aria-label="Choisir si l'entreprise est ouverte ou non">
                                    <input type="radio" class="btn-check scheduleBtn" name="open_day<?= $schedule->id_schedules ?>" value="0" id="close_day<?= $schedule->id_schedules ?>" autocomplete="off" required <?= (($all_open_day[$schedule->id_schedules] ?? $schedule->open_day) == 0) ? 'checked' : '' ?>>
                                    <label class="btn btn-radio" for="close_day<?= $schedule->id_schedules ?>">Fermé</label>

                                    <input type="radio" class="btn-check scheduleBtn" name="open_day<?= $schedule->id_schedules ?>" value="1" id="open-uninterrupted_day<?= $schedule->id_schedules ?>" autocomplete="off" <?= (($all_open_day[$schedule->id_schedules] ?? $schedule->open_day) == 1) ? 'checked' : '' ?>>
                                    <label class="btn btn-radio" for="open-uninterrupted_day<?= $schedule->id_schedules ?>">Ouvert sans interruption</label>

                                    <input type="radio" class="btn-check scheduleBtn" name="open_day<?= $schedule->id_schedules ?>" value="2" id="open-interrupted_day<?= $schedule->id_schedules ?>" autocomplete="off" <?= (($all_open_day[$schedule->id_schedules] ?? $schedule->open_day) == 2) ? 'checked' : '' ?>>
                                    <label class="btn btn-radio" for="open-interrupted_day<?= $schedule->id_schedules ?>">Ouvert avec interruption</label>
                                </div>
                                <!-- --------------------------------------------------------------- -->

                                <!-- --------------------------------------------------------------- -->
                                <!-- PREMIER BLOC D'HORAIRES -->
                                <div class="schedules-first-bloc d-flex flex-column flex-md-row justify-content-center align-items-center mb-4">
                                    <span>De</span>
                                    <div class="d-flex justify-content-center align-items-center ms-md-3 my-3 my-md-0">
                                        <input type="number" class="form-control text-end me-md-3 <?= (isset($all_valid_hours) && $all_valid_hours[$schedule->id_schedules][0] == false) ? 'error-form' : '' ?>" aria-label="Heure d'ouverture sans préciser les minutes" id="day<?= $schedule->id_schedules ?>_hour_open_hour" name="day<?= $schedule->id_schedules ?>_hour_open_hour" value="<?= $all_hour_open_hour[$schedule->id_schedules] ?? $schedule->hour_open_hour ?>"><span class="fw-bold mx-3 mx-md-0">H</span>

                                        <input type="number" class="form-control mx-md-3 <?= (isset($all_valid_minutes) && $all_valid_minutes[$schedule->id_schedules][0] == false) ? 'error-form' : '' ?>" aria-label="Minutes d'ouverture associées à l'heure du champs précédent" aria-required="false" id="day<?= $schedule->id_schedules ?>_minute_open_hour" name="day<?= $schedule->id_schedules ?>_minute_open_hour" value="<?= $all_minute_open_hour[$schedule->id_schedules] ?? $schedule->minute_open_hour ?>">
                                    </div>
                                    <span>à</span>
                                    <div class="d-flex justify-content-center align-items-center close-mid-hour ms-md-3 my-3 my-md-0">
                                        <input type="number" class="form-control text-end me-md-3 <?= (isset($all_valid_hours) && $all_valid_hours[$schedule->id_schedules][1] == false) ? 'error-form' : '' ?>" aria-label="Heure de fermeture sans préciser les minutes" id="day<?= $schedule->id_schedules ?>_hour_close_mid_hour" name="day<?= $schedule->id_schedules ?>_hour_close_mid_hour" value="<?= $all_hour_close_mid_hour[$schedule->id_schedules] ?? $schedule->hour_close_mid_hour ?>"><span class="fw-bold mx-3 mx-md-0">H</span>

                                        <input type="number" class="form-control mx-md-3 <?= (isset($all_valid_minutes) && $all_valid_minutes[$schedule->id_schedules][1] == false) ? 'error-form' : '' ?>" aria-label="Minutes de fermeture associées à l'heure du champs précédent" aria-required="false" id="day<?= $schedule->id_schedules ?>_minute_close_mid_hour" name="day<?= $schedule->id_schedules ?>_minute_close_mid_hour" value="<?= $all_minute_close_mid_hour[$schedule->id_schedules] ?? $schedule->minute_close_mid_hour ?>">
                                    </div>
                                </div>
                                <!-- --------------------------------------------------------------- -->

                                <!-- --------------------------------------------------------------- -->
                                <!-- SECOND BLOC D'HORAIRES -->
                                <div class="schedules-second-bloc d-flex flex-column flex-md-row justify-content-center align-items-center mb-4">
                                    <span>De</span>
                                    <div class="d-flex justify-content-center align-items-center ms-md-3 my-3 my-md-0">
                                        <input type="number" class="form-control text-end me-md-3 <?= (isset($all_valid_hours) && $all_valid_hours[$schedule->id_schedules][2] == false) ? 'error-form' : '' ?>" aria-label="Heure d'ouverture sans préciser les minutes" id="day<?= $schedule->id_schedules ?>_hour_open_mid_hour" name="day<?= $schedule->id_schedules ?>_hour_open_mid_hour" value="<?= $all_hour_open_mid_hour[$schedule->id_schedules] ??  $schedule->hour_open_mid_hour ?>"><span class="fw-bold mx-3 mx-md-0">H</span>

                                        <input type="number" class="form-control mx-md-3 <?= (isset($all_valid_minutes) && $all_valid_minutes[$schedule->id_schedules][2] == false) ? 'error-form' : '' ?>" aria-label="Minutes d'ouverture associées à l'heure du champs précédent" aria-required="false" id="day<?= $schedule->id_schedules ?>_minute_open_mid_hour" name="day<?= $schedule->id_schedules ?>_minute_open_mid_hour" value="<?= $all_minute_open_mid_hour[$schedule->id_schedules] ??  $schedule->minute_open_mid_hour ?>">
                                    </div>
                                    <span>à</span>
                                    <div class="d-flex justify-content-center align-items-center close-hour ms-md-3 my-3 my-md-0">
                                        <input type="number" class="form-control text-end me-md-3 <?= (isset($all_valid_hours) && $all_valid_hours[$schedule->id_schedules][3] == false) ? 'error-form' : '' ?>" aria-label="Heure de fermeture sans préciser les minutes" id="day<?= $schedule->id_schedules ?>_hour_close_hour" name="day<?= $schedule->id_schedules ?>_hour_close_hour" value="<?= $all_hour_close_hour[$schedule->id_schedules] ?? $schedule->hour_close_hour ?>"><span class="fw-bold mx-3 mx-md-0">H</span>

                                        <input type="number" class="form-control mx-md-3 <?= (isset($all_valid_minutes) && $all_valid_minutes[$schedule->id_schedules][3] == false) ? 'error-form' : '' ?>" aria-label="Minutes de fermeture associées à l'heure du champs précédent" aria-required="false" id="day<?= $schedule->id_schedules ?>_minute_close_hour" name="day<?= $schedule->id_schedules ?>_minute_close_hour" value="<?= $all_minute_close_hour[$schedule->id_schedules] ??  $schedule->minute_close_hour ?>">
                                    </div>
                                </div>
                                <!-- --------------------------------------------------------------- -->
                            </fieldset> <?php } ?>
                        <!-- --------------------------------------------------------------- -->

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