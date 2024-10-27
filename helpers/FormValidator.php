<?php


require_once(__DIR__ . './../helpers/Regex.php');

$regex = Regex::get_instance();


class FormValidator extends Regex
{

    // ============================================================================================================================================================
    // MESSAGE D'ERREUR
    // ============================================================================================================================================================

    /**
     * Génère trois messages d'erreur possible selon le paramètre d'entrée $error.
     * 
     * @param int $error Type d'erreur rencontrée (1 - Donnée vide ou pour personnaliser, 2 - Donnée trop longue, 3 - Donnée non conforme, 4 - Choix à faire, 5 - Choix invalide)
     * @param string $string Morceau de texte pour compléter les phrases d'erreurs qui commencent toutes par "Veuillez saisir"
     * @param ?int $limit Le nombre de caractères maximum autorisé pour la personnalisation du message en cas d'erreur sur la longueur
     * 
     * @return string Retourne le message d'erreur personnalisé
     */
    public static function error_message(int $error, string $string, ?int $limit = null): string
    {
        switch ($error) {
            case 1:
                $message = 'Veuillez saisir ' . $string . '.';
                break;
            case 2:
                $message = 'Veuillez saisir ' . $string . ' sans dépasser la limite de caractères autorisée (' . $limit . ' max).';
                break;
            case 3:
                $message = 'Veuillez saisir ' . $string . ' au bon format.';
                break;
            case 4:
                $message = 'Veuillez effectuer un choix ' . $string . '.';
                break;
            case 5:
                $message = 'Veuillez effectuer un choix ' . $string . ' recevable.';
                break;
        }
        return $message;
    }
    // ============================================================================================================================================================



    // ============================================================================================================================================================
    // EMAIL
    // ============================================================================================================================================================

    /**
     * Permets de vérifier une adresse mail et de renvoyer la donnée ainsi que le message d'erreur s'il y en a un.
     * Vérifie l'obligation grâce au paramètre d'entrée, l'existence de la donnée, sa longueur et sa conformité.
     * 
     * @param bool $required Champ obligatoire
     * 
     * @return array Renvoie un tableau de deux clefs (data et message)
     */
    public static function validate_email(bool $required = true): array
    {
        $email = trim((string)filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $is_empty = empty($email);

        $result = [
            'data' => $email,
            'message' => ''
        ];

        if ($required && $is_empty) {
            $result['message'] = self::error_message(1, 'une adresse mail');
            return $result;
        }

        if (strlen($email) > 150) {
            $result['message'] = self::error_message(2, 'une adresse mail', 150);
            return $result;
        }

        $is_valid_email = ($is_empty) ? true : filter_var($email, FILTER_VALIDATE_EMAIL);

        if (!$is_valid_email) {
            $result['message'] = self::error_message(3, 'une adresse mail');
        }

        return $result;
    }
    // ============================================================================================================================================================



    // ============================================================================================================================================================
    // NUMÉRO DE TÉLÉPHONE
    // ============================================================================================================================================================

    /**
     * Permets de vérifier un numéro de téléphone et de renvoyer la donnée ainsi que le message d'erreur s'il y en a un.
     * Vérifie l'obligation grâce au paramètre d'entrée, l'existence de la donnée et sa conformité.
     * 
     * @param bool $required Champ obligatoire
     * 
     * @return array Renvoie un tableau de deux clefs (data et message)
     */
    public static function validate_phone(bool $required = true): array
    {
        $phone = trim((string)filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT));
        $is_empty = empty($phone);

        if ($required && $is_empty) {
            return [
                'data' => $phone,
                'message' => self::error_message(1, 'un numéro de téléphone')
            ];
        }

        $is_valid_phone = ($is_empty) ? true : filter_var($phone, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/' . Regex::$phone . '/']]);

        return [
            'data' => $phone,
            'message' => $is_valid_phone ? '' : self::error_message(3, 'un numéro de téléphone')
        ];
    }
    // ============================================================================================================================================================



    // ============================================================================================================================================================
    // ADRESSE
    // ============================================================================================================================================================

    /**
     * Permets de vérifier une adresse et de renvoyer la donnée ainsi que le message d'erreur s'il y en a un.
     * Vérifie l'obligation et la longueur grâce aux paramètres d'entrée, l'existence de la donnée et sa conformité.
     * 
     * @param int $limit Le nombre de caractères maximum autorisé
     * @param bool $required Champ obligatoire
     * 
     * @return array Renvoie un tableau de deux clefs (data et message)
     */
    public static function validate_address(int $limit, bool $required = true): array
    {
        $address = trim((string)filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS));
        $is_empty = empty($address);

        // Permet de récupérer les apostrophes et de faire fonctionner la regex correctement
        $address = html_entity_decode($address, ENT_QUOTES, 'UTF-8');

        $result = [
            'data' => $address,
            'message' => ''
        ];

        if ($required && $is_empty) {
            $result['message'] = self::error_message(1, 'une adresse');
            return $result;
        }

        if (strlen($address) > $limit) {
            $result['message'] = self::error_message(2, 'une adresse', $limit);
            return $result;
        }

        $is_valid_address = ($is_empty) ? true : filter_var($address, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/' . Regex::$address . '/']]);

        if (!$is_valid_address) {
            $result['message'] = self::error_message(3, 'une adresse');
        }

        return $result;
    }
    // ============================================================================================================================================================



    // ============================================================================================================================================================
    // CODE POSTAL
    // ============================================================================================================================================================

    /**
     * Permets de vérifier un code postal et de renvoyer la donnée ainsi que le message d'erreur s'il y en a un.
     * Vérifie l'obligation grâce au paramètre d'entrée, l'existence de la donnée et sa conformité.
     * 
     * @param bool $required Champ obligatoire
     * 
     * @return array Renvoie un tableau de deux clefs (data et message)
     */
    public static function validate_zipcode(bool $required = true): array
    {
        $zipcode = trim((string)filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_NUMBER_INT));
        $is_empty = empty($zipcode);

        if ($required && $is_empty) {
            return [
                'data' => $zipcode,
                'message' => self::error_message(1, 'un code postal')
            ];
        }

        $is_valid_zipcode = ($is_empty) ? true : filter_var($zipcode, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/' . Regex::$zipcode . '/']]);

        return [
            'data' => $zipcode,
            'message' => $is_valid_zipcode ? '' : self::error_message(3, 'un code postal')
        ];
    }
    // ============================================================================================================================================================



    // ============================================================================================================================================================
    // TEXTE
    // ============================================================================================================================================================

    /**
     * Permets de vérifier un champ texte et de renvoyer la donnée ainsi que le message d'erreur s'il y en a un.
     * Vérifie l'obligation et la longueur grâce aux paramètres d'entrée, l'existence de la donnée et sa conformité.
     * 
     * @param string $name Le nom du champ de formulaire
     * @param string $message Personnalisation du message d'erreur
     * @param int $limit Le nombre de caractères maximum autorisé
     * @param bool $required Champ obligatoire
     * 
     * @return array Renvoie un tableau de deux clefs (data et message)
     */
    public static function validate_text(string $name, string $message, int $limit, bool $required = true): array
    {
        $text = trim((string)filter_input(INPUT_POST, $name, FILTER_SANITIZE_SPECIAL_CHARS));
        $is_empty = empty($text);

        // Permet de récupérer les apostrophes et de faire fonctionner la regex correctement
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

        $result = [
            'data' => $text,
            'message' => ''
        ];

        if ($required && $is_empty) {
            $result['message'] = self::error_message(1, $message);
            return $result;
        }

        if (strlen($text) > $limit) {
            $result['message'] = self::error_message(2, $message, $limit);
            return $result;
        }

        // var_dump(Regex::$text);
        $is_valid_text = ($is_empty) ? true : filter_var($text, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/' . Regex::$text . '/']]);

        if (!$is_valid_text) {
            $result['message'] = self::error_message(3, $message);
        }

        return $result;
    }
    // ============================================================================================================================================================



    // ============================================================================================================================================================
    // TEXTAREA
    // ============================================================================================================================================================

    /**
     * Permets de vérifier un textarea et de renvoyer la donnée ainsi que le message d'erreur s'il y en a un.
     * Vérifie l'obligation et la longueur grâce aux paramètres d'entrée et l'existence de la donnée.
     * 
     * @param string $textarea Le nom du textarea dans le formulaire
     * @param int $limit Le nombre de caractères maximum autorisé
     * @param bool $required Champ obligatoire
     * 
     * @return array Renvoie un tableau de deux clefs (data et message)
     */
    public static function validate_textarea(string $textarea, string $message, int $limit, bool $required = true): array
    {
        $textarea = trim((string)filter_input(INPUT_POST, $textarea, FILTER_SANITIZE_SPECIAL_CHARS));
        // $textarea  = html_entity_decode($textarea);
        $is_empty = empty($textarea);

        if ($required && $is_empty) {
            return [
                'data' => $textarea,
                'message' => self::error_message(1, $message)
            ];
        }

        if (!$is_empty) {
            $textarea = nl2br(html_entity_decode($textarea));
        }

        $is_valid_textarea = ($is_empty) ? true : strlen($textarea) <= $limit;

        return [
            'data' => $textarea,
            'message' => $is_valid_textarea ? '' : self::error_message(2, $message)
        ];
    }
    // ============================================================================================================================================================



    // ============================================================================================================================================================
    // ENTIER
    // ============================================================================================================================================================

    /**
     * Permets de vérifier un champ number et de renvoyer la donnée ainsi que le message d'erreur s'il y en a un.
     * Vérifie l'obligation et la limitation grâce aux paramètres d'entrée, l'existence de la donnée et sa conformité.
     * 
     * @param string $name Le nom du champ de formulaire
     * @param string $message Personnalisation du message d'erreur
     * @param bool $choice Boutons radio ou checkbox
     * @param array $limit Comprends les limites min et max. Exemple : $limit['min' => 0, 'max' => 10].
     * @param bool $required Champ obligatoire
     * 
     * @return array Renvoie un tableau de deux clefs (data et message)
     */
    public static function validate_int(string $name, string $message, bool $choice = false, array $limit = [], bool $required = true): array
    {
        $int = filter_input(INPUT_POST, $name, FILTER_SANITIZE_NUMBER_INT);
        $is_empty = empty($int) && $int != 0;

        $min = $limit['min'] ?? null;
        $max = $limit['max'] ?? null;

        $result = [
            'data' => ($is_empty) ? null : $int,
            'message' => ''
        ];

        if ($required && $is_empty) {
            $result['message'] = ($choice) ? self::error_message(4, $message) : self::error_message(1, $message);
            return $result;
        }

        if (is_null($min) || is_null($max)) {
            $is_valid_int = ($is_empty) ? true : filter_var($int, FILTER_VALIDATE_INT);

            if (!$is_valid_int) {
                $result['message'] = ($choice) ? self::error_message(4, $message) : self::error_message(1, $message);
            }
            return $result;
        }

        $is_valid_int = ($is_empty) ? true : filter_var($int, FILTER_VALIDATE_INT, ['options' => ['min_range' => $min, 'max_range' => $max]]);

        if (!$is_valid_int) {
            $messageModified = $message . ' dans la plage autorisée (' . $min . ' minimum et ' . $max . ' maximum)';
            $result['message'] = ($choice) ? self::error_message(5, $message) : self::error_message(1, $messageModified);
        }

        return $result;
    }
    // ============================================================================================================================================================


    // ============================================================================================================================================================
    // FLOAT
    // ============================================================================================================================================================

    /**
     * Permets de vérifier un champ number et de renvoyer la donnée ainsi que le message d'erreur s'il y en a un.
     * Vérifie l'obligation et la limitation grâce aux paramètres d'entrée, l'existence de la donnée et sa conformité.
     * 
     * @param string $name Le nom du champ de formulaire
     * @param string $message Personnalisation du message d'erreur
     * @param bool $choice Boutons radio ou checkbox
     * @param array $limit Comprends les limites min et max. Exemple : $limit['min' => 0, 'max' => 10].
     * @param bool $required Champ obligatoire
     * 
     * @return array Renvoie un tableau de deux clefs (data et message)
     */
    public static function validate_float(string $name, string $message, bool $choice = false, array $limit = [], bool $required = true): array
    {
        $float = filter_input(INPUT_POST, $name, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $is_empty = empty($float) && $float != 0;

        $min = $limit['min'] ?? null;
        $max = $limit['max'] ?? null;
        $precision = $limit['precision'] ?? null;

        $result = [
            'data' => ($is_empty) ? null : $float,
            'message' => ''
        ];

        if ($required && $is_empty) {
            $result['message'] = ($choice) ? self::error_message(4, $message) : self::error_message(1, $message);
            return $result;
        }

        if (is_null($min) || is_null($max)) {
            $is_valid_float = ($is_empty) ? true : filter_var($float, FILTER_VALIDATE_FLOAT);

            if (!$is_valid_float) {
                $result['message'] = ($choice) ? self::error_message(4, $message) : self::error_message(1, $message);
            }
            return $result;
        }

        $is_valid_float = ($is_empty) ? true : filter_var($float, FILTER_VALIDATE_FLOAT, ['options' => ['min_range' => $min, 'max_range' => $max, 'precision' => $precision]]);

        if (!$is_valid_float) {
            $messageModified = $message . ' dans la plage autorisée (' . $min . ' minimum et ' . $max . ' maximum avec ' . $precision . 'chiffre(s) maximum après la virgule)';
            $result['message'] = ($choice) ? self::error_message(5, $message) : self::error_message(1, $messageModified);
        }

        return $result;
    }
    // ============================================================================================================================================================



    // ============================================================================================================================================================
    // BOOLÉEN
    // ============================================================================================================================================================

    /**
     * Permets de vérifier un booléen et de renvoyer la donnée ainsi que le message d'erreur s'il y en a un.
     * Vérifie l'obligation grâce aux paramètre d'entrée, l'existence de la donnée et sa conformité.
     * 
     * @param string $name Nom du champ de formulaire
     * @param string $message Personnalisation du message d'erreur
     * @param bool $required Champ obligatoire
     * 
     * @return array Renvoie un tableau de deux clefs (data et message)
     */
    public static function validate_bool(string $name, string $message, bool $required = true): array
    {
        $value = filter_input(INPUT_POST, $name, FILTER_SANITIZE_NUMBER_INT);

        $is_empty = is_null($value);

        $result = [
            'data' => $value,
            'message' => ''
        ];

        if ($required && $is_empty) {
            $result['message'] = self::error_message(4, $message);
            return $result;
        }

        $is_valid_value = ($is_empty) ? true : filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if (is_null($is_valid_value)) {
            $result = [
                'data' => $is_valid_value,
                'message' => self::error_message(5, $message)
            ];
        }

        $result['data'] = intval($value);

        return $result;
    }
    // ============================================================================================================================================================



    // ============================================================================================================================================================
    // DATES
    // ============================================================================================================================================================

    /**
     * Permets de vérifier deux dates et de renvoyer les données ainsi que les messages d'erreur s'il y en a.
     * 
     * 
     * @param string $first_date Nom du premier input date
     * @param string $last_date Nom du second input date
     * @param bool $required Champ obligatoire
     * 
     * @return array Renvoie un tableau de deux clefs (first_date, last_date) contenant chacune deux clefs (data et message)
     */
    public static function validate_dates(string $first_date, string $last_date, bool $required = true): array
    {
        $first_date = trim((string)filter_input(INPUT_POST, $first_date, FILTER_SANITIZE_NUMBER_INT));
        $last_date = trim((string)filter_input(INPUT_POST, $last_date, FILTER_SANITIZE_NUMBER_INT));

        $results = [
            'first_date' => ['data' => $first_date, 'message' => ''],
            'last_date' => ['data' => $last_date, 'message' => '']
        ];

        // -------------------------------------------------------------------------------------------------
        // Étape 1: Vérifier si les dates sont vides et obligatoires
        if ($required) {
            if (empty($first_date)) {
                $results['first_date']['message'] = self::error_message(1, 'une date');
            }
            if (empty($last_date)) {
                $results['last_date']['message'] = self::error_message(1, 'une date');
            }
        }
        // -------------------------------------------------------------------------------------------------

        // -------------------------------------------------------------------------------------------------
        // Étape 2: Valider les dates en utilisant la regex $date
        if (!empty($first_date) && !filter_var($first_date, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/' . Regex::$date . '/']])) {
            $results['first_date']['message'] = self::error_message(3, 'une date');
        }
        if (!empty($last_date) && !filter_var($last_date, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/' . Regex::$date . '/']])) {
            $results['last_date']['message'] = self::error_message(3, 'une date');
        }
        // -------------------------------------------------------------------------------------------------

        // -------------------------------------------------------------------------------------------------
        // Étape 3: Vérifier si la première date est inférieure à la deuxième date
        if (!empty($first_date) && !empty($last_date)) {

            $currentDate = date('Y-m-d');

            if (strtotime($first_date) > strtotime($last_date)) {
                $results['first_date']['message'] = self::error_message(1, 'des dates cohérentes');
                $results['last_date']['message'] = self::error_message(1, 'des dates cohérentes');
            }

            if (strtotime($first_date) < strtotime($currentDate)) {
                $results['first_date']['message'] = 'La date ne peut pas être inférieure à la date actuelle.';
            }
        }
        // -------------------------------------------------------------------------------------------------

        return $results;
    }
    // ============================================================================================================================================================



    // ============================================================================================================================================================
    // MOTS DE PASSE
    // ============================================================================================================================================================

    /**
     * Permets de vérifier un changement de mot de passe avec trois inputs (le mot de passe actuel, le nouveau et la confimation du nouveau).
     * 
     * @param string $actualPassword Mot de passe actuel de l'utilisateur
     * 
     * @return array Renvoie un tableau de trois clefs (password, newPassword, confirmPassword) contenant chacune deux clefs (data et message)
     */
    public static function validate_password(string $actualPassword): array
    {
        $password = filter_input(INPUT_POST, 'password');
        $newPassword = filter_input(INPUT_POST, 'newPassword');
        $confirmPassword = filter_input(INPUT_POST, 'confirmPassword');

        $result = [
            'password' => ['data' => $password, 'message' => ''],
            'newPassword' => ['data' => $newPassword, 'message' => ''],
            'confirmPassword' => ['data' => $confirmPassword, 'message' => '']
        ];

        $is_password_empty = empty($password);
        $is_newPassword_empty = empty($newPassword);
        $is_confirmPassword_empty = empty($confirmPassword);

        // Si le nouveau mot de passe est vide, aucune vérification
        if ($is_newPassword_empty) {
            return $result;
        }

        // ---------------------------------------------------------------------------------------
        // Valider le nouveau mot de passe
        $is_valid_newPassword = filter_var($newPassword, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/' . Regex::$password . '/']]);
        if (!$is_valid_newPassword) {
            $result['newPassword']['message'] = self::error_message(3, 'un mot de passe');
        } else {
            // Hacher le nouveau mot de passe
            $result['passwordHash'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }
        // ---------------------------------------------------------------------------------------

        // ---------------------------------------------------------------------------------------
        // Valider la confirmation du mot de passe
        if ($is_confirmPassword_empty) {
            $result['confirmPassword']['message'] = self::error_message(1, 'votre nouveau mot de passe une seconde fois');
        } elseif ($newPassword != $confirmPassword) {
            $result['confirmPassword']['message'] = 'Les mots de passe ne sont pas identiques';
        }
        // ---------------------------------------------------------------------------------------

        // ---------------------------------------------------------------------------------------
        // Valider le mot de passe actuel
        if ($is_password_empty) {
            $result['password']['message'] = self::error_message(1, 'votre mot de passe actuel');
        } else {
            $is_valid_password = password_verify($password, $actualPassword);
            if (!$is_valid_password) {
                $result['password']['message'] = 'Votre identifiant et mot de passe ne correspondent pas.';
            }
        }
        // ---------------------------------------------------------------------------------------

        return $result;
    }
    // ============================================================================================================================================================



    // ============================================================================================================================================================
    // VALIDATION DE CONNEXION
    // ============================================================================================================================================================

    /**
     * Permets de valider une connexion en vérifiant l'email et le mot de passe
     * Créer une session utilisateur en cas de succès => $_SESSION['user']
     * 
     * @return array Renvoie un tableau de deux clefs (email, password) contenant chacune deux clefs (data et message)
     */
    public static function validate_connexion(): array
    {
        $email = self::validate_email();
        $password = filter_input(INPUT_POST, 'password');

        $result = [
            'email' => ['data' => $email['data'], 'message' => $email['message']],
            'password' => ['data' => $password, 'message' => '']
        ];

        $is_password_empty = empty($password);

        // Si le mot de passe est vide, génération du message d'erreur
        if ($is_password_empty) {
            $result['password']['message'] = self::error_message(1, 'votre mot de passe');
        }

        // ---------------------------------------------------------------------------------------
        // Si l'email ne comporte pas d'erreur, vérification de l'existance du compte
        if (empty($email['message'])) {

            $user = User::fetch('email', $result['email']['data']);

            if (!$user) {
                $result['email']['message'] = 'Ce compte n\'existe pas.';
            }
        } else {
            return $result;
        }
        // ---------------------------------------------------------------------------------------

        // ---------------------------------------------------------------------------------------
        // Si aucune erreur présente, vérification de la concordance compte/mdp et création de la session
        if (empty($result['email']['message']) && empty($result['password']['message'])) {

            $is_valid_password = password_verify($password, $user->password);

            if (!$is_valid_password) {
                $result['email']['message'] = $result['password']['message'] = 'Votre identifiant et mot de passe ne correspondent pas.';
            } else {
                $_SESSION['user'] = $user;
            }
        }
        // ---------------------------------------------------------------------------------------

        return $result;
    }
    // ============================================================================================================================================================
}
