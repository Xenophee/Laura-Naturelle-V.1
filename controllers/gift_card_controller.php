<?php

require_once(__DIR__ . '/../config/init.php');

require_once(__DIR__ . '/../helpers/FormValidator.php');
require_once(__DIR__ . '/../helpers/StripePayment.php');

require '../vendor/autoload.php';

// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------

try {
    
    // ------------------------------------------------
    // SEO
    // ------------------------------------------------
    $document_title = TITLES['gift_card'];
    $meta_description = META_DESCRIPTION['gift_card'];
    // ------------------------------------------------


    if (!empty($_GET['status'])) {
        $payment_status = intval(filter_input(INPUT_GET, 'status', FILTER_VALIDATE_BOOL));
    }
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // ===================================================================================================================================
        // CHOIX DU PRIX DE LA CARTE
        // ===================================================================================================================================

        $price = FormValidator::validate_int('price', 'de prix', true);

        if (empty($price['message'])) {
            $is_valid_price = in_array($price['data'], GIFT_CARD_PRICES);

            $price['message'] = ($is_valid_price) ? '' : 'Veuillez saisir un montant valide.';

            if ($is_valid_price) {

                $payment = new StripePayment(KEY_STRIPE);
                $payment->startPayment($price['data']);

            }
        }
    }


} catch (\Throwable $th) {
    include_once(__DIR__ . '/../views/templates/header.php');
    include_once(__DIR__ . '/../views/error.php');
    include_once(__DIR__ . '/../views/templates/footer.php');
    die;
}



// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------
// AFFICHAGE DES VUES

include_once(__DIR__ . '/../views/templates/header.php');

include(__DIR__ . '/../views/gift_card.php');

include_once(__DIR__ . '/../views/templates/footer.php');


// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------
// MODAL ALERT SITE NON OFFICIEL
include_once(__DIR__ . '/../views/templates/alert_modal.php');