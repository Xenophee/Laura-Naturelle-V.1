<?php

class User
{

    private int $id;
    private string $email;
    private string $phone;
    private string $address;
    private string $zipcode;
    private string $city;
    private bool $artisan;
    private bool $admin;
    private string $password;
    private string $updated_at;


    // GETTER & SETTER
    // ========================================================================
    // --------------------------------------------------
    // ID

    /**
     * Permet de définir l'id de l'utilisateur
     * @param int $value
     * 
     * @return void
     */
    public function set_id(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Permet de récupérer l'id de l'utilisateur
     * @return int
     */
    public function get_id(): int
    {
        return $this->id;
    }

    // --------------------------------------------------
    // MAIL

    /**
     * Permet de définir l'email de l'utilisateur
     * @param string $value
     * 
     * @return void
     */
    public function set_email(string $value): void
    {
        $this->email = $value;
    }

    /**
     * Permet de récupérer l'email de l'utilisateur
     * @return string
     */
    public function get_email(): string
    {
        return $this->email;
    }

    // --------------------------------------------------
    // TÉLÉPHONE

    /**
     * Permet de définir le numéro de téléphone de l'utilisateur
     * @param string $value
     * 
     * @return void
     */
    public function set_phone(string $value): void
    {
        $this->phone = $value;
    }

    /**
     * Permet de récupérer le numéro de téléphone de l'utilisateur
     * @return string
     */
    public function get_phone(): string
    {
        return $this->phone;
    }

    // --------------------------------------------------
    // ADRESSE

    /**
     * Permet de définir l'adresse de l'utilisateur
     * @param string $value
     * 
     * @return void
     */
    public function set_address(string $value): void
    {
        $this->address = $value;
    }

    /**
     * Permet de récupérer l'adresse de l'utilisateur
     * @return string
     */
    public function get_address(): string
    {
        return $this->address;
    }

    // --------------------------------------------------
    // CODE POSTAL

    /**
     * Permet de définir le code postal de l'utilisateur
     * @param string $value
     * 
     * @return void
     */
    public function set_zipcode(string $value): void
    {
        $this->zipcode = $value;
    }

    /**
     * Permet de récupérer le code postal de l'utilisateur
     * @return string
     */
    public function get_zipcode(): string
    {
        return $this->zipcode;
    }

    // --------------------------------------------------
    // VILLE

    /**
     * Permet de définir la ville de l'utilisateur
     * @param string $value
     * 
     * @return void
     */
    public function set_city(string $value): void
    {
        $this->city = $value;
    }

    /**
     * Permet de récupérer la ville de l'utilisateur
     * @return string
     */
    public function get_city(): string
    {
        return $this->city;
    }


    // --------------------------------------------------
    // ARTISAN

    /**
     * Permet de définir si l'utilisateur est artisan
     * @param bool $value
     * 
     * @return void
     */
    public function set_artisan(bool $value): void
    {
        $this->artisan = $value;
    }

    /**
     * Permet de récupérer si l'utilisateur est artisan
     * @return bool
     */
    public function get_artisan(): bool
    {
        return $this->artisan;
    }


    // --------------------------------------------------
    // ADMIN

    /**
     * Permet de définir si l'utilisateur est administrateur
     * @param bool $value
     * 
     * @return void
     */
    public function set_admin(bool $value): void
    {
        $this->admin = $value;
    }

    /**
     * Permet de récupérer si l'utilisateur est administrateur
     * @return bool
     */
    public function get_admin(): bool
    {
        return $this->admin;
    }

    // --------------------------------------------------
    // MOT DE PASSE

    /**
     * Permet de définir le mot de passe de l'utilisateur
     * @param string $value
     * 
     * @return void
     */
    public function set_password(string $value): void
    {
        $this->password = $value;
    }

    /**
     * Permet de récupérer le mot de passe de l'utilisateur
     * @return string
     */
    public function get_password(): string
    {
        return $this->password;
    }

    // --------------------------------------------------
    // UPDATED_AT

    /**
     * Permet de définir la date de la dernière mise à jour du compte de l'utilisateur
     * @param string $value
     * 
     * @return void
     */
    public function set_updated_at(string $value): void
    {
        $this->updated_at = $value;
    }

    /**
     * Permet de récupérer la date de la dernière mise à jour du compte de l'utilisateur
     * @return string
     */
    public function get_updated_at(): string
    {
        return $this->updated_at;
    }
    // --------------------------------------------------
    // ========================================================================

    // BDD
    // ========================================================================
    // --------------------------------------------------
    // UPDATE DES INFORMATIONS UTILISATEUR

    /**
     * Mets à jour les informations de l'utilisateur
     * @param int $id
     * 
     * @return bool
     */
    public function update(int $id, bool $updatePassword = false): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `users` SET 
                        `email` = :email,
                        `phone` = :phone, 
                        `address` = :address,
                        `zipcode` = :zipcode,
                        `city` = :city,';

        if ($updatePassword) {
            $sql .= ' `password` = :password,';
        }

        $sql .= ' `updated_at` = NOW()
                WHERE `id_user` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':email', $this->email);
        $sth->bindValue(':phone', $this->phone);
        $sth->bindValue(':address', $this->address);
        $sth->bindValue(':zipcode', $this->zipcode);
        $sth->bindValue(':city', $this->city);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        if ($updatePassword) {
            $sth->bindValue(':password', $this->password);
        }

        return $sth->execute();
    }

    // --------------------------------------------------
    // FETCH ARTISAN

    /**
     * Permet de récupérer les informations de l'artisan
     * @param int $id
     * 
     * @return object
     */
    public static function fetch_artisan(): object|null
    {
        $pdo = Database::getInstance();
        $sql = 'SELECT `email`, `phone`, `address`, `zipcode`, `city` FROM `users`
                    WHERE `artisan` = 1';

        $sth = $pdo->prepare($sql);

        return ($sth->execute()) ? ($sth->fetch() ?: null) : null;
    }

    // --------------------------------------------------
    // FETCH

    /**
     * Permets de récupérer un utilisateur selon un nom de colonne passé en paramètre ainsi que la valeur recherchée
     * @param string $value
     * 
     * @return object
     */
    public static function fetch(string $column, string $value): object|null
    {
        $pdo = Database::getInstance();
        $sql = 'SELECT * FROM `users` WHERE ' . $column . ' = :value;';

        $sth = $pdo->prepare($sql);
        $sth->bindValue(':value', $value);

        return ($sth->execute()) ? ($sth->fetch() ?: null) : null;
    }
}
