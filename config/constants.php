<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Initialiser Dotenv et charger le fichier .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();


// INFOS DE CONNEXION A LA BASE
define('DATABASE_NAME', $_ENV['DATABASE_NAME']);
define('DATABASE_USER', $_ENV['DATABASE_USER']);
define('DATABASE_PASSWORD', $_ENV['DATABASE_PASSWORD']);



// Constantes pour les vérifications de formulaire
define('TEXT_LIMIT', ['short' => 50, 'medium' => 150, 'medium_plus' => 250, 'large' => 500]);

define('PRICINGS_NUMBER_ALLOWED', 3);

define('AUTHORIZED_IMAGE_FORMAT', ['image/jpeg', 'image/webp']);

define('MAX_FILE_SIZE', 5 * 1024 * 1024);

define('MIN_FILE_SIZE', [
    'width' => 2000, 
    'height' => 800]);

define('SIZES_WIDTH', [
    'landscape' => 2000,
    'portrait' => 650,
    'min' => 400
]);

define('SIZES_HEIGHT', [
    'landscape' => 1000,
    'portrait' => 650,
    'min' => 300
]);

define('LOCATION_CATEGORIES', [
    'original' => $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/categories_original/',
    'categories' => $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/categories/',
    'min' => $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/categories_min/'
]);




// Constantes pour le fonctionnement de Stripe
define('GIFT_CARD_PRICES', [15, 30, 45, 60, 75]);
define('KEY_STRIPE', $_ENV['KEY_STRIPE']);


// Constantes pour l'object dans le formulaire de contact
define('OBJECTS_MAIL', [
    'Question / demande sur une prestation',
    'Question / demande sur les cartes cadeaux',
    'Problème technique sur le site',
    'Autre'
]);


// Constantes pour le fonctionnement du captcha
define('HOST_NAME', $_ENV['HOST_NAME']);
define('CLIENT_KEY_CAPTCHA', $_ENV['CLIENT_KEY_CAPTCHA']);
define('SECRET_KEY_CAPTCHA', $_ENV['SECRET_KEY_CAPTCHA']);



// Tableau de caractères pour la réecriture d'url
define('ACCENT_CHARACT', ['À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'Ý'=>'Y', 'ý'=>'y', 'ÿ'=>'y', 'Ç'=>'C', 'ç'=>'c', 'Ñ'=>'N', 'ñ'=>'n']);