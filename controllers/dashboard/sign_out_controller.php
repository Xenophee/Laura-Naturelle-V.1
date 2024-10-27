<?php

require_once(__DIR__ . './../../config/init.php');


// ===================================================================================================================
// -------------------------------------------------------------------------------------------------------------------

try {

    unset($_SESSION['user']);

    session_destroy();
    
    header('location: /accueil');

    die;

} catch (\Throwable $th) {
    include_once(__DIR__ . '/../views/templates/header.php');
    include_once(__DIR__ . '/../views/error.php');
    include_once(__DIR__ . '/../views/templates/footer.php');
    die;
}