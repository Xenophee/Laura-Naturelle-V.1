<?php

class Pricing
{

    private int $id;
    private int $duration;
    private float $price;
    private int $id_service;


    // GETTER & SETTER
    // ========================================================================
    // --------------------------------------------------
    // ID

    /**
     * Permet de définir l'id de la tarification
     * @param int $value
     * 
     * @return void
     */
    public function set_id(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Permet de récupérer l'id de la tarification
     * @return int
     */
    public function get_id(): int
    {
        return $this->id;
    }

    // --------------------------------------------------
    // DUREE

    /**
     * Permet de définir la durée d'une prestation
     * @param int $value
     * 
     * @return void
     */
    public function set_duration(int $value): void
    {
        $this->duration = $value;
    }

    /**
     * Permet de récupérer la durée d'une prestation
     * @return int
     */
    public function get_duration(): int
    {
        return $this->duration;
    }

    // --------------------------------------------------
    // TARIF

    /**
     * Permet de définir le tarif d'une prestation
     * @param float $value
     * 
     * @return void
     */
    public function set_price(float $value): void
    {
        $this->price = $value;
    }

    /**
     * Permet de récupérer le tarif d'une prestation
     * @return float
     */
    public function get_price(): float
    {
        return $this->price;
    }

    // --------------------------------------------------
    // ID PRESTATION

    /**
     * Permet de définir l'id de la prestation pour cette tarification
     * @param int $value
     * 
     * @return void
     */
    public function set_id_service(int $value): void
    {
        $this->id_service = $value;
    }

    /**
     * Permet de récupérer l'id de la prestation pour cette tarification
     * @return int
     */
    public function get_id_service(): int
    {
        return $this->id_service;
    }


    // BDD
    // ========================================================================
    // --------------------------------------------------
    // INSERT

    /**
     * Permet d'ajouter une tarification
     * @return bool
     */
    public function insert(): bool
    {
        $pdo = Database::getInstance();
        $sql = 'INSERT INTO `pricings` (`duration`, `price`, `id_service`) 
                VALUES (:duration, :price, :id_service);';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':duration', $this->duration, PDO::PARAM_INT);
        $sth->bindValue(':price', $this->price);
        $sth->bindValue(':id_service', $this->id_service, PDO::PARAM_INT);

        return $sth->execute();
    }

    // --------------------------------------------------
    // UPDATE

    /**
     * Mets à jour une tarification de prestation
     * 
     * @param int $id_service
     * @param int $id_pricing
     * 
     * @return bool
     */
    public function update(int $id_service, int $id_pricing): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `pricings` SET 
                        `duration` = :duration,
                        `price` = :price
                WHERE `id_service` = :id_service AND `id_pricing` = :id_pricing;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':duration', $this->duration, PDO::PARAM_INT);
        $sth->bindValue(':price', $this->price);
        $sth->bindValue(':id_service', $id_service, PDO::PARAM_INT);
        $sth->bindValue(':id_pricing', $id_pricing, PDO::PARAM_INT);

        return $sth->execute();
    }

    // --------------------------------------------------
    // DELETE

    /**
     * Permet de supprimer une tarification
     * 
     * @param int $id_service
     * @param int $id_pricing
     * 
     * @return bool
     */
    public static function delete(int $id_service, int $id_pricing): bool
    {
        $pdo = Database::getInstance();
        $sql = 'DELETE FROM `pricings`
                    WHERE `id_service` = :id_service AND `id_pricing` = :id_pricing;';

        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id_service', $id_service, PDO::PARAM_INT);
        $sth->bindValue(':id_pricing', $id_pricing, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }
}
