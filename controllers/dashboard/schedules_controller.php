<?php

require_once(__DIR__ . './../../config/init.php');
require_once(__DIR__ . './../../helpers/Flash.php');


// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------

try {

    // ------------------------------------------------
    // Vérification des droits de l'utilisateur
    // ------------------------------------------------
    if (empty($_SESSION['user'])) {
        header('location: /404');
        die;
    }
    // ------------------------------------------------


    // ------------------------------------------------
    // SEO
    // ------------------------------------------------
    $document_title = TITLES['schedules'];
    // ------------------------------------------------


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        foreach ($schedules as $schedule) {

            // ===================================================================================================================================
            // RÉCUPÉRATION DES DONNÉES SAISIES ET NETTOYAGES
            // ===================================================================================================================================
            $open_day = intval(filter_input(INPUT_POST, 'open_day' . $schedule->id_schedules, FILTER_SANITIZE_NUMBER_INT));
            $is_valid_open_day = filter_var($open_day, FILTER_VALIDATE_INT, ["options" => ["min_range" => 0, "max_range" => 2]]);
            $is_valid_open_day = ($is_valid_open_day === false) ?  0 : $is_valid_open_day;
            $open_day = $is_valid_open_day;

            if ($open_day == 1 || $open_day == 2) {

                $hour_open_hour = intval(filter_input(INPUT_POST, 'day' . $schedule->id_schedules . '_hour_open_hour', FILTER_SANITIZE_NUMBER_INT));
                $minute_open_hour = intval(filter_input(INPUT_POST, 'day' . $schedule->id_schedules . '_minute_open_hour', FILTER_SANITIZE_NUMBER_INT));

                if ($open_day == 2) {

                    $hour_close_mid_hour = intval(filter_input(INPUT_POST, 'day' . $schedule->id_schedules . '_hour_close_mid_hour', FILTER_SANITIZE_NUMBER_INT));
                    $minute_close_mid_hour = intval(filter_input(INPUT_POST, 'day' . $schedule->id_schedules . '_minute_close_mid_hour', FILTER_SANITIZE_NUMBER_INT));

                    $hour_open_mid_hour = intval(filter_input(INPUT_POST, 'day' . $schedule->id_schedules . '_hour_open_mid_hour', FILTER_SANITIZE_NUMBER_INT));
                    $minute_open_mid_hour = intval(filter_input(INPUT_POST, 'day' . $schedule->id_schedules . '_minute_open_mid_hour', FILTER_SANITIZE_NUMBER_INT));
                }

                $hour_close_hour = intval(filter_input(INPUT_POST, 'day' . $schedule->id_schedules . '_hour_close_hour', FILTER_SANITIZE_NUMBER_INT));
                $minute_close_hour = intval(filter_input(INPUT_POST, 'day' . $schedule->id_schedules . '_minute_close_hour', FILTER_SANITIZE_NUMBER_INT));
            }
            // ===================================================================================================================================



            // ===================================================================================================================================
            // MISE EN PLACE DES HEURES ET DES MINUTES DANS DEUX TABLEAUX ET VÉRIFICATION DE LEUR VALIDITÉ
            // ===================================================================================================================================
            if ($open_day == 0 || $open_day == 1) {
                list($hour_close_mid_hour, $minute_close_mid_hour) = explode(':', $schedule->close_mid_hour);
                list($hour_open_mid_hour, $minute_open_mid_hour) = explode(':', $schedule->open_mid_hour);

                if ($open_day == 0) {
                    list($hour_open_hour, $minute_open_hour) = explode(':', $schedule->open_hour);
                    list($hour_close_hour, $minute_close_hour) = explode(':', $schedule->close_hour);
                }
            }

            $is_valid_hours = [$hour_open_hour, $hour_close_mid_hour, $hour_open_mid_hour, $hour_close_hour];
            $is_valid_minutes = [$minute_open_hour, $minute_close_mid_hour, $minute_open_mid_hour, $minute_close_hour];

            list($is_valid_hours, $is_valid_minutes) = Schedule::verifSchedules($is_valid_hours, $is_valid_minutes);

            $all_valid_hours[$schedule->id_schedules] = $is_valid_hours;
            $all_valid_minutes[$schedule->id_schedules] = $is_valid_minutes;

            // ===================================================================================================================================



            // ===================================================================================================================================
            // FORMATAGE DES HORAIRES POUR RESPECTER L'UNIFORMISATION
            // ===================================================================================================================================
            if ($open_day == 1 || $open_day == 2) {

                $hour_open_hour = (sprintf('%02d', $hour_open_hour));
                $minute_open_hour = (sprintf('%02d', $minute_open_hour));

                $hour_close_mid_hour = (sprintf('%02d', $hour_close_mid_hour));
                $minute_close_mid_hour = (sprintf('%02d', $minute_close_mid_hour));

                $hour_open_mid_hour = (sprintf('%02d', $hour_open_mid_hour));
                $minute_open_mid_hour = (sprintf('%02d', $minute_open_mid_hour));

                $hour_close_hour = (sprintf('%02d', $hour_close_hour));
                $minute_close_hour = (sprintf('%02d', $minute_close_hour));
            }
            // ===================================================================================================================================



            // ===================================================================================================================================
            // CONSERVATION DES VALEURS DANS DES TABLEAUX À PART POUR LE RÉAFFICHAGE DES DONNÉES SAISIES ET L'ENREGISTREMENT EN BASE
            // ===================================================================================================================================
            $all_open_day[$schedule->id_schedules] = $open_day;

            $all_hour_open_hour[$schedule->id_schedules] = $hour_open_hour;
            $all_minute_open_hour[$schedule->id_schedules] = $minute_open_hour;

            $all_hour_close_mid_hour[$schedule->id_schedules] = $hour_close_mid_hour;
            $all_minute_close_mid_hour[$schedule->id_schedules] = $minute_close_mid_hour;

            $all_hour_open_mid_hour[$schedule->id_schedules] = $hour_open_mid_hour;
            $all_minute_open_mid_hour[$schedule->id_schedules] = $minute_open_mid_hour;

            $all_hour_close_hour[$schedule->id_schedules] = $hour_close_hour;
            $all_minute_close_hour[$schedule->id_schedules] = $minute_close_hour;
            // ===================================================================================================================================



            // ===================================================================================================================================
            // VÉRIFICATION SUR LES TABLEAUX CONTENANT LES VÉRIFICATIONS DES HORAIRES. EN CAS DE FALSE --> AJOUT DE FALSE DANS LE TABLEAU DES JOURS
            // ===================================================================================================================================
            if ($open_day == 1 || $open_day == 2) {
                if (in_array(false, $is_valid_hours) || in_array(false, $is_valid_minutes)) {

                    $is_valid_days[$schedule->id_schedules] = false;
                    $error_days[] = $schedule->week_day;
                } else {
    
                    $is_valid_days[$schedule->id_schedules] = true;
                }
            }
            // ===================================================================================================================================
        }

        // ===================================================================================================================================
        // VÉRIFICATION SUR LE TABLEAU DES JOURS VALIDES. EN CAS DE FALSE --> ERREUR, SINON ENREGISTREMENT EN BASE
        // ===================================================================================================================================
        if (in_array(false, $is_valid_days)) {

            $error = 'Un ou plusieurs horaires que vous avez saisis ne sont pas valides ! ';
            $error = $error .= '(' . implode(', ', $error_days) . ')';

        } else {

            foreach ($schedules as $schedule) {

                $schedules_updates = new Schedule;
                $schedules_updates->set_id($schedule->id_schedules);
                $schedules_updates->set_week_day($schedule->week_day);
                $schedules_updates->set_open_day($all_open_day[$schedule->id_schedules]);

                $schedules_updates->set_open_hour($all_hour_open_hour[$schedule->id_schedules] . ':' .  $all_minute_open_hour[$schedule->id_schedules] . ':00');
                $schedules_updates->set_close_mid_hour($all_hour_close_mid_hour[$schedule->id_schedules] . ':' .  $all_minute_close_mid_hour[$schedule->id_schedules] . ':00');
                $schedules_updates->set_open_mid_hour($all_hour_open_mid_hour[$schedule->id_schedules] . ':' .  $all_minute_open_mid_hour[$schedule->id_schedules] . ':00');
                $schedules_updates->set_close_hour($all_hour_close_hour[$schedule->id_schedules] . ':' .  $all_minute_close_hour[$schedule->id_schedules] . ':00');

                $isSchedulesUpdate[$schedule->id_schedules] = $schedules_updates->update($schedule->id_schedules);
            }
        }
        // ===================================================================================================================================


        // ===================================================================================================================================
        // AFFICHAGE D'UN MESSAGE À L'UTILISATEUR APRÈS L'ENREGISTREMENT EN BASE DE DONNÉES
        // ===================================================================================================================================
        if (empty($error)) {
            if (in_array(false, $isSchedulesUpdate)) {
                Flash::setMessage('Une erreur est survenue : les horaires n\'ont pas été mis à jour.', false);
            } else {
                Flash::setMessage('Les horaires ont été mis à jour.');
            }
        }
        // ===================================================================================================================================
    }

    
    // ------------------------------------------------
    // Rappel de la fonction de récupération pour voir la mise à jour après modification (premier appel dans le fichier init)
    // ------------------------------------------------
    $schedules_bdd = Schedule::fetchAll();
    // ------------------------------------------------


    foreach ($schedules_bdd as $schedule) {

        // Dissection des horaires pour les afficher dans le formulaire en créant deux variables par horaires (heure & minutes)
        $open_hour = $schedule->open_hour;
        list($hour_open_hour_bdd, $minute_open_hour_bdd) = explode(':', $open_hour);

        $close_mid_hour = $schedule->close_mid_hour;
        list($hour_close_mid_hour_bdd, $minute_close_mid_hour_bdd) = explode(':', $close_mid_hour);

        $open_mid_hour = $schedule->open_mid_hour;
        list($hour_open_mid_hour_bdd, $minute_open_mid_hour_bdd) = explode(':', $open_mid_hour);

        $close_hour = $schedule->close_hour;
        list($hour_close_hour_bdd, $minute_close_hour_bdd) = explode(':', $close_hour);

        // Ajout des horaires disséqués dans de nouvelles propriétés de l'objet initial
        $schedule->hour_open_hour = $hour_open_hour_bdd;
        $schedule->minute_open_hour = $minute_open_hour_bdd;
        $schedule->hour_close_mid_hour = $hour_close_mid_hour_bdd;
        $schedule->minute_close_mid_hour = $minute_close_mid_hour_bdd;
        $schedule->hour_open_mid_hour = $hour_open_mid_hour_bdd;
        $schedule->minute_open_mid_hour = $minute_open_mid_hour_bdd;
        $schedule->hour_close_hour = $hour_close_hour_bdd;
        $schedule->minute_close_hour = $minute_close_hour_bdd;
    }


    // ------------------------------------------------
    // Nom des fichiers js nécessaire au fonctionnement
    // ------------------------------------------------
    $js = ['schedules'];
    // ------------------------------------------------


} catch (\Throwable $th) {
    include_once(__DIR__ . './../../views/templates/header.php');
    include_once(__DIR__ . './../../views/error.php');
    include_once(__DIR__ . './../../views/templates/footer.php');
    die;
}



// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------
// AFFICHAGE DES VUES

include_once(__DIR__ . './../../views/templates/header.php');

include(__DIR__ . './../../views/dashboard/schedules.php');

include_once(__DIR__ . './../../views/templates/footer.php');
