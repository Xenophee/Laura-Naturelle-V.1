<?php


class Regex
{
    protected static ?self $instance = null;
    protected static string $email;
    protected static string $phone;
    protected static string $address;
    protected static string $zipcode;
    protected static string $text;
    protected static string $date;
    protected static string $password;


    private function __construct()
    {
        self::$email = '^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$';
        self::$phone = '^(0[1-9])(\d{8})$';
        self::$address = '^\d+\s[\'’A-Za-zÀ-ÿ\s-]+$';
        self::$zipcode = '^\d{5}$';
        self::$text = '^[\'’A-Za-zÀ-ÿ\s-]+$';
        self::$date = '^\d{4}-\d{2}-\d{2}$';
        self::$password = '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%§^&+=!])(?=.*[a-zA-Z\d@#$%§^&+=!]).{8,}$';
    }

    
    /**
     * Permets de créer une instance regex si elle n'a pas déjà été faite
     * @return self
     */
    public static function get_instance(): self {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    // GETTER
    // ========================================================================
    // --------------------------------------------------
    // EMAIL

    /**
     * Permet de récupérer la regex de l'email
     * @return string
     */
    public function get_email(): string {
        return self::$email;
    }

    // --------------------------------------------------
    // NUMERO DE TELEPHONE

    /**
     * Permet de récupérer la regex du numéro de téléphone
     * @return string
     */
    public function get_phone(): string {
        return self::$phone;
    }

    // --------------------------------------------------
    // ADRESSE

    /**
     * Permet de récupérer la regex de l'adresse
     * @return string
     */
    public function get_address(): string {
        return self::$address;
    }

    // --------------------------------------------------
    // CODE POSTAL

    /**
     * Permet de récupérer la regex du code postal
     * @return string
     */
    public function get_zipcode(): string {
        return self::$zipcode;
    }

    // --------------------------------------------------
    // VILLE

    /**
     * Permet de récupérer la regex de la ville
     * @return string
     */
    public function get_text(): string {
        return self::$text;
    }

    // --------------------------------------------------
    // DATE

    /**
     * Permet de récupérer la regex de la date
     * @return string
     */
    public function get_date(): string {
        return self::$date;
    }

    // --------------------------------------------------
    // MOT DE PASSE

    /**
     * Permet de récupérer la regex du mot de passe
     * @return string
     */
    public function get_password(): string {
        return self::$password;
    }
    // --------------------------------------------------
    // ========================================================================
}
