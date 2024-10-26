<?php

require_once(__DIR__ . './../../config/init.php');
require_once(__DIR__ . './../../helpers/Flash.php');

require_once(__DIR__ . './../../models/Category.php');
require_once(__DIR__ . './../../helpers/FormValidator.php');



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
    // Récupération de l'id pour savoir si on se trouve en présence d'un ajout ou d'une modification
    // ------------------------------------------------
    $id = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
    // ------------------------------------------------


    // ------------------------------------------------
    // SEO
    // ------------------------------------------------
    if (empty($id)) {
        $document_title = TITLES['category_add'];
    } else {
        $document_title = TITLES['category_update'];
    }
    // ------------------------------------------------



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // ===================================================================================================================================
        // CHOIX DE L'IMAGE D'ILLUSTRATION
        // ===================================================================================================================================

        if (isset($_FILES['cover'])) {
            $cover['data'] = $_FILES['cover'];

            if (empty($id) || $cover['data']['error'] != 4) {
                if ($cover['data']['error'] == 4) {
                    $cover['message'] = 'L\'image est obligatoire.';
                } else if ($cover['data']['error'] > 0) {
                    $cover['message'] = 'Une erreur de transfert s\'est produite.';
                } else if (!in_array($cover['data']['type'], AUTHORIZED_IMAGE_FORMAT)) {
                    $cover['message'] = 'Le format de l\'image n\'est pas bon.';
                } else if ($cover['data']['size'] > MAX_FILE_SIZE) {
                    $cover['message'] = 'Le poids de l\'image est trop élévé.';
                } else {

                    $sizes = getimagesize($cover['data']['tmp_name']);

                    if ($sizes[0] < MIN_FILE_SIZE['width'] || $sizes[1] < MIN_FILE_SIZE['height']) {
                        $cover['message'] = 'Les dimensions de l\'image sont trop petites (min ' . MIN_FILE_SIZE['width'] . ' x ' . MIN_FILE_SIZE['height'] . ').';
                    }
                }

                $errors[] = (empty($cover['message'])) ? false : true;
            }
        }


        // ===================================================================================================================================
        // CHOIX DU RENDU TEXTUEL SUR L'IMAGE
        // ===================================================================================================================================

        $darkmode = FormValidator::validate_bool('darkmode', 'de thème');
        $errors[] = ($darkmode['message']) ? true : false;


        // ===================================================================================================================================
        // TITRE DE LA CATÉGORIE
        // ===================================================================================================================================

        $name = FormValidator::validate_text('title', 'un nom de catégorie', TEXT_LIMIT['short']);
        $errors[] = ($name['message']) ? true : false;


        // ===================================================================================================================================
        // DESCRIPTION DE LA CATÉGORIE
        // ===================================================================================================================================

        $description = FormValidator::validate_textarea('description', 'une description de la catégorie', TEXT_LIMIT['large'], false);
        $errors[] = ($description['message']) ? true : false;


        // ===================================================================================================================================
        // CHOIX DE LA VUE POUR LES PRESTATIONS DE LA CATÉGORIE
        // ===================================================================================================================================

        $view = FormValidator::validate_int('view', 'd\'affichage', true, [1, 2]);
        $errors[] = ($view['message']) ? true : false;


        // ===================================================================================================================================
        // ENREGISTREMENT DE LA MISE À JOUR EN BASE S'IL N'Y A PAS D'ERREURS
        // ===================================================================================================================================

        if (!in_array(true, $errors)) {

            $pdo = Database::getInstance();
            $pdo->beginTransaction();

            $category_object = new Category;
            $category_object->set_darkmode($darkmode['data']);
            $category_object->set_name($name['data']);
            $category_object->set_description($description['data']);
            $category_object->set_view($view['data']);

            if ($id === 0) {
                $is_valid_request = $category_object->insert();

                $id_category = $pdo->lastInsertId();
            } else {
                $is_valid_request = $category_object->update($id);

                $id_category = $id;
            }

            // ===================================================================================================================================
            // ENREGISTREMENT ET DÉCOUPAGE DE L'IMAGE DE COUVERTURE
            // ===================================================================================================================================
            $is_file_valid = true;

            if (empty($id) || $cover['data']['error'] != 4) {
                $extension = pathinfo($cover['data']['name'], PATHINFO_EXTENSION);
                $from = $cover['data']['tmp_name'];
                $file_name = $id_category . '.' . $extension;
                $to = LOCATION_CATEGORIES['original'] . $file_name;
                $is_file_valid = move_uploaded_file($from, $to);


                $gd_original = imagecreatefromjpeg($to);

                $path_landscape = LOCATION_CATEGORIES['categories'] . $id_category . '-xl.webp';
                $path_portrait = LOCATION_CATEGORIES['categories'] . $id_category . '.webp';
                $path_min = LOCATION_CATEGORIES['min'] . $id_category . '.webp';

                resize_img($gd_original, SIZES_WIDTH['landscape'], SIZES_HEIGHT['landscape'], $path_landscape);
                resize_img($gd_original, SIZES_WIDTH['portrait'], SIZES_HEIGHT['portrait'], $path_portrait);
                resize_img($gd_original, SIZES_WIDTH['min'], SIZES_HEIGHT['min'], $path_min);

                imagedestroy($gd_original);
            }

            // ===================================================================================================================================
            // AFFICHAGE D'UN MESSAGE À L'UTILISATEUR APRÈS L'ENREGISTREMENT EN BASE DE DONNÉES
            // ===================================================================================================================================
            if ($is_valid_request && $is_file_valid) {
                $pdo->commit();
                unset($cover, $darkmode, $name, $description, $view);
                ($id === 0) ? Flash::setMessage('La catégorie a été ajoutée.') : Flash::setMessage('La catégorie a été mise à jour.');
            } else {
                $pdo->rollBack();
                ($id === 0) ? Flash::setMessage('Une erreur est survenue : la catégorie n\'a pas été ajoutée.', false) : Flash::setMessage('Une erreur est survenue : la catégorie n\'a pas été mise à jour.', false);
            }
        }
    }

    // ------------------------------------------------
    // Récupération de la prestation concernée
    // ------------------------------------------------
    if (!empty($id)) {
        $category = Category::fetch($id);
    }
    // ------------------------------------------------

    // ------------------------------------------------
    // Nom des fichiers js nécessaire au fonctionnement
    // ------------------------------------------------
    $js = ['form', 'category'];
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

include(__DIR__ . './../../views/dashboard/category_manager.php');

include_once(__DIR__ . './../../views/templates/footer.php');
