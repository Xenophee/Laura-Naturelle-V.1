<?php


/**
 * Fonction de réecriture des urls
 * 
 * @param string $string
 * 
 * @return string
 */
function slug(string $string):string {

    $string = strtr($string, ACCENT_CHARACT);
    $string = strtolower($string);
    $string = preg_replace(
        array('/[^a-zA-Z0-9 \'-]/', '/[ -\']+/','/^-|-$/'),
        array('', '-', ''), $string);
    
    return $string;
}


/**
 * Permet de formater une date en français numérique et retourne le résultat
 * @param string $date
 * 
 * @return string
 */
function format_date(string $date, $all = true): string
{
    $date = new DateTime($date);

    if ($all) {
        $date = $date->format('d/m/Y');
    } else {
        $date = $date->format('d/m');
    }

    return $date;
}


/**
 * Permet de formater un nombre décimal avec deux chiffres après la virgule
 * 
 * @param float $number
 * 
 * @return float
 */
function format_float(float $number): int|string
{

    $number = number_format($number, 2, ',');

    if (substr($number, -2) === '00') {
        $number = intval($number);
    }

    return $number;
}



function resize_img($image, int $width, int $height, string $path)
{
    // Récupération des dimensions originales de l'image
    $width_original = imagesx($image);
    $height_original = imagesy($image);

    // Calcul du ratio de redimensionnement
    $ratio = max($width / $width_original, $height / $height_original);

    // Calcul des nouvelles dimensions pour maintenir les proportions
    $new_width = round($width_original * $ratio);
    $new_height = round($height_original * $ratio);

    // Création d'une nouvelle image avec les nouvelles dimensions
    $gd_scaled = imagecreatetruecolor($new_width, $new_height);
    imagealphablending($gd_scaled, false);
    imagesavealpha($gd_scaled, true);
    $transparent = imagecolorallocatealpha($gd_scaled, 255, 255, 255, 127);
    imagefilledrectangle($gd_scaled, 0, 0, $new_width, $new_height, $transparent);
    imagecopyresampled($gd_scaled, $image, 0, 0, 0, 0, $new_width, $new_height, $width_original, $height_original);

    // Calcul des coordonnées pour le rognage
    $x_cropped = max(0, ($new_width - $width) / 2);
    $y_cropped = max(0, ($new_height - $height) / 2);

    // Création d'une nouvelle image avec les dimensions de découpe
    $gd_cropped = imagecrop($gd_scaled, ['x' => $x_cropped, 'y' => $y_cropped, 'width' => $width, 'height' => $height]);

    // Sauvegarde de la nouvelle image
    imagewebp($gd_cropped, $path, 90);

    // Libération de la mémoire
    imagedestroy($gd_scaled);
    imagedestroy($gd_cropped);
}

