<?php

class Discount
{

    private int $id;
    private string $start_date;
    private string $end_date;
    private int $advantage;
    private bool $euro;
    private string $created_at;
    private string $updated_at;
    private string $deactivated_at;




    // GETTER & SETTER
    // ========================================================================
    // --------------------------------------------------
    // ID

    /**
     * Permet de définir l'id de la promotion
     * @param int $value
     * 
     * @return void
     */
    public function set_id(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Permet de récupérer l'id de la promotion
     * @return int
     */
    public function get_id(): int
    {
        return $this->id;
    }

    // --------------------------------------------------
    // DATE DE DÉPART D'UNE PROMOTION

    /**
     * Permet de définir la date de départ d'une promotion
     * @param string $value
     * 
     * @return void
     */
    public function set_start_date(string $value): void
    {
        $this->start_date = $value;
    }

    /**
     * Permet de récupérer la date de départ d'une promotion
     * @return string
     */
    public function get_start_date(): string
    {
        return $this->start_date;
    }

    // --------------------------------------------------
    // DATE DE FIN D'UNE PROMOTION

    /**
     * Permet de définir la date de fin d'une promotion
     * @param string $value
     * 
     * @return void
     */
    public function set_end_date(string $value): void
    {
        $this->end_date = $value;
    }

    /**
     * Permet de récupérer la date de fin d'une promotion
     * @return string
     */
    public function get_end_date(): string
    {
        return $this->end_date;
    }

    // --------------------------------------------------
    // MONTANT DE LA REMISE

    /**
     * Permet de définir le montant de la remise
     * @param int $value
     * 
     * @return void
     */
    public function set_advantage(int $value): void
    {
        $this->advantage = $value;
    }

    /**
     * Permet de récupérer le montant de la remise
     * @return int
     */
    public function get_advantage(): int
    {
        return $this->advantage;
    }

    // --------------------------------------------------
    // EURO

    /**
     * Permet de définir si la remise est en euro ou en pourcentage
     * @param bool $value
     * 
     * @return void
     */
    public function set_euro(bool $value): void
    {
        $this->euro = $value;
    }

    /**
     * Permet de récupérer si la remise est en euro ou en pourcentage
     * @return bool
     */
    public function get_euro(): bool
    {
        return $this->euro;
    }

    // --------------------------------------------------
    // DATE DE CRÉATION DE LA PROMOTION

    /**
     * Permet de définir la date de création de la promotion
     * @param string $value
     * 
     * @return void
     */
    public function set_created_at(string $value): void
    {
        $this->created_at = $value;
    }

    /**
     * Permet de récupérer la date de création de la promotion
     * @return string
     */
    public function get_created_at(): string
    {
        return $this->created_at;
    }

    // --------------------------------------------------
    // DATE DE MODIFICATION DE LA PROMOTION

    /**
     * Permet de définir la date de modification de la promotion
     * @param string $value
     * 
     * @return void
     */
    public function set_updated_at(string $value): void
    {
        $this->updated_at = $value;
    }

    /**
     * Permet de récupérer la date de modification de la promotion
     * @return string
     */
    public function get_updated_at(): string
    {
        return $this->updated_at;
    }

    // --------------------------------------------------
    // DATE DE DESACTIVATION DE LA PROMOTION

    /**
     * Permet de définir la date de modification de la promotion
     * @param string $value
     * 
     * @return void
     */
    public function set_deactivated_at(string $value): void
    {
        $this->deactivated_at = $value;
    }

    /**
     * Permet de récupérer la date de modification de la promotion
     * @return string
     */
    public function get_deactivated_at(): string
    {
        return $this->deactivated_at;
    }


    // BDD
    // ========================================================================
    // --------------------------------------------------
    // INSERT

    /**
     * Permet d'ajouter une promotion
     * @return bool
     */
    public function insert(): bool
    {
        $pdo = Database::getInstance();
        $sql = 'INSERT INTO `discounts` (`start_date`, `end_date`, `advantage`, `euro`, `created_at`) 
                VALUES (:start_date, :end_date, :advantage, :euro, NOW());';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':start_date', $this->start_date);
        $sth->bindValue(':end_date', $this->end_date);
        $sth->bindValue(':advantage', $this->advantage, PDO::PARAM_INT);
        $sth->bindValue(':euro', $this->euro, PDO::PARAM_BOOL);

        return $sth->execute();
    }

    // --------------------------------------------------
    // UPDATE

    /**
     * Mets à jour une promotion
     * @param int $id
     * 
     * @return bool
     */
    public function update(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `discounts` SET 
                        `start_date` = :start_date,
                        `end_date` = :end_date, 
                        `advantage` = :advantage,
                        `euro` = :euro,
                        `updated_at` = NOW()
                WHERE `id_discount` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':start_date', $this->start_date);
        $sth->bindValue(':end_date', $this->end_date);
        $sth->bindValue(':advantage', $this->advantage, PDO::PARAM_INT);
        $sth->bindValue(':euro', $this->euro, PDO::PARAM_BOOL);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return $sth->execute();
    }

    // --------------------------------------------------
    // FETCH ALL

    /**
     * Permets de récupérer toutes les promotions
     * @return array
     */
    public static function fetchAll(): array
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT
            `discounts`.`id_discount` AS `id_discount`,
            `discounts`.`start_date` AS `start_date`,
            `discounts`.`end_date` AS `end_date`,
            `discounts`.`advantage` AS `advantage`,
            `discounts`.`euro` AS `euro`,
            `discounts`.`deactivated_at` AS `deactivated_at`,
            GROUP_CONCAT(DISTINCT `services`.`id_service` SEPARATOR \', \') AS `id_services`,
            GROUP_CONCAT(DISTINCT `categories`.`name` ORDER BY `categories`.`name` SEPARATOR \', \') AS `categories`
            FROM `discounts`
        JOIN `services` ON `services`.`id_discount` = `discounts`.`id_discount`
        JOIN `categories` ON `services`.`id_category` = `categories`.`id_category`
        GROUP BY `discounts`.`id_discount`;';

        $sth = $pdo->prepare($sql);

        return ($sth->execute()) ? $sth->fetchAll() : [];
    }

    // --------------------------------------------------
    // FETCH

    /**
     * Permet de récupérer une promotion spécifique
     * 
     * @param int $id_category
     * 
     * @return object
     */
    public static function fetch(int $id_discount): object|null
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT `start_date`, `end_date`, `advantage`, `euro`, 
        GROUP_CONCAT(`id_service` SEPARATOR \', \') AS `id_services`
        FROM `discounts`
        JOIN `services` ON `services`.`id_discount` = `discounts`.`id_discount`
        WHERE `discounts`.`id_discount` = :id_discount';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id_discount', $id_discount, PDO::PARAM_INT);

        return ($sth->execute()) ? ($sth->fetch() ?: null) : null;
    }

    // --------------------------------------------------
    // DEACTIVATE

    /**
     * Désactive une promotion
     * @param int $id
     * 
     * @return bool
     */
    public static function deactivate(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `discounts` SET 
                        `deactivated_at` = NOW()
                WHERE `id_discount` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // ACTIVATE

    /**
     * Active une promotion
     * @param int $id
     * 
     * @return bool
     */
    public static function activate(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `discounts` SET 
                        `deactivated_at` = null
                WHERE `id_discount` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // DELETE

    /**
     * Permet de supprimer une ou toutes les promotions
     * @param int $id
     * 
     * @return bool
     */
    public static function delete(int $id, $all = false): bool
    {
        $pdo = Database::getInstance();

        if ($all) {
            $sql = 'DELETE FROM `discounts`;';
        } else {
            $sql = 'DELETE FROM `discounts`
                    WHERE `id_discount` = :id;';
        }

        $sth = $pdo->prepare($sql);

        if (!$all) {
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
        }

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }



    // AUTRES
    // ========================================================================
    // --------------------------------------------------
    // DISCOUNT_CALC


    public static function discount_calc($euro, $price, $discount)
    {

        if ($euro) {
            $result = $price - $discount;
        } else {
            $result = $price * ($discount / 100);
            $result = $price - $result;
        }

        $result = format_float($result);

        return $result;
    }
}
