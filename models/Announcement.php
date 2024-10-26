<?php

class Announcement {

    private int $id;
    private string $content;
    private string $start_date;
    private string $end_date;
    private string $created_at;
    private string $updated_at;
    private string $deactivated_at;


    // GETTER & SETTER
    // ========================================================================
    // --------------------------------------------------
    // ID

    /**
     * Permet de définir l'id de l'annonce
     * @param int $value
     * 
     * @return void
     */
    public function set_id(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Permet de récupérer l'id de l'annonce
     * @return int
     */
    public function get_id(): int
    {
        return $this->id;
    }

    // --------------------------------------------------
    // CONTENU

    /**
     * Permet de définir le contenu de l'annonce
     * @param string $value
     * 
     * @return void
     */
    public function set_content(string $value): void
    {
        $this->content = $value;
    }

    /**
     * Permet de récupérer le contenu de l'annonce
     * @return string
     */
    public function get_content(): string
    {
        return $this->content;
    }

    // --------------------------------------------------
    // DATE DE DÉPART

    /**
     * Permet de définir la date de départ de l'annonce
     * @param string $value
     * 
     * @return void
     */
    public function set_start_date(string $value): void
    {
        $this->start_date = $value;
    }

    /**
     * Permet de récupérer la date de départ de l'annonce
     * @return string
     */
    public function get_start_date(): string
    {
        return $this->start_date;
    }

    // --------------------------------------------------
    // DATE DE FIN

    /**
     * Permet de définir la date de fin de l'annonce
     * @param string $value
     * 
     * @return void
     */
    public function set_end_date(string $value): void
    {
        $this->end_date = $value;
    }

    /**
     * Permet de récupérer la date de fin de l'annonce
     * @return string
     */
    public function get_end_date(): string
    {
        return $this->end_date;
    }

    // --------------------------------------------------
    // DATE DE CRÉATION DE L'ANNONCE

    /**
     * Permet de définir la date de création de l'annonce
     * @param string $value
     * 
     * @return void
     */
    public function set_created_at(string $value): void
    {
        $this->created_at = $value;
    }

    /**
     * Permet de récupérer la date de création de l'annonce
     * @return string
     */
    public function get_created_at(): string
    {
        return $this->created_at;
    }

    // --------------------------------------------------
    // DATE DE MODIFICATION DE L'ANNONCE

    /**
     * Permet de définir la date de modification de l'annonce
     * @param string $value
     * 
     * @return void
     */
    public function set_updated_at(string $value): void
    {
        $this->updated_at = $value;
    }

    /**
     * Permet de récupérer la date de modification de l'annonce
     * @return string
     */
    public function get_updated_at(): string
    {
        return $this->updated_at;
    }

    // --------------------------------------------------
    // DATE DE DÉSACTIVATION DE L'ANNONCE

    /**
     * Permet de définir la date de désactivation de l'annonce
     * @param string $value
     * 
     * @return void
     */
    public function set_deactivated_at(string $value): void
    {
        $this->deactivated_at = $value;
    }

    /**
     * Permet de récupérer la date de désactivation de l'annonce
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
     * Permet d'ajouter une annonce
     * @return bool
     */
    public function insert(): bool
    {
        $pdo = Database::getInstance();
        $sql = 'INSERT INTO `announcements` (`content`, `start_date`, `end_date`, `created_at`) 
                VALUES (:content, :start_date, :end_date, NOW());';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':content', $this->content);
        $sth->bindValue(':start_date', $this->start_date);
        $sth->bindValue(':end_date', $this->end_date);

        return $sth->execute();
    }

    // --------------------------------------------------
    // UPDATE

    /**
     * Mets à jour l'annonce en cours
     * @param int $id
     * 
     * @return bool
     */
    public function update(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `announcements` SET 
                        `content` = :content,
                        `start_date` = :start_date, 
                        `end_date` = :end_date,
                        `updated_at` = NOW()
                WHERE `id_announcement` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':content', $this->content);
        $sth->bindValue(':start_date', $this->start_date);
        $sth->bindValue(':end_date', $this->end_date);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return $sth->execute();
    }

    // --------------------------------------------------
    // DELETEALL

    /**
     * Permet de supprimer toutes les annonces
     * @param int $id
     * 
     * @return bool
     */
    public static function deleteAll(int|null $id): bool
    {
        $pdo = Database::getInstance();

        if ($id) {
            $sql = 'DELETE FROM `announcements` WHERE `id_announcement` <> :id;';
        } else {
            $sql = 'DELETE FROM `announcements`;';
        }
        
        
        $sth = $pdo->prepare($sql);

        if ($id) {
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
        }

        return $sth->execute();
    }

    // --------------------------------------------------
    // DELETE

    /**
     * Permet de supprimer une annonce
     * @param int $id
     * 
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'DELETE FROM `announcements`
                    WHERE `id_announcement` = :id;';

        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // DEACTIVATE

    /**
     * Désactive l'annonce en cours
     * @param int $id
     * 
     * @return bool
     */
    public static function deactivate(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `announcements` SET 
                        `deactivated_at` = NOW()
                WHERE `id_announcement` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // FETCH ALL

    /**
     * Permets de récupérer toutes les annonces
     * @return array
     */
    public static function fetchAll(): array
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT
            `id_announcement`, 
            `content`,
            `start_date`,
            `end_date`, 
            `deactivated_at`
        FROM `announcements`;';

        $sth = $pdo->prepare($sql);

        return ($sth->execute()) ? $sth->fetchAll() : [];
    }

    // --------------------------------------------------
    // FETCH

    /**
     * Permets de récupérer la dernière annonce postée
     * @param string $value
     * 
     * @return object
     */
    public static function fetch(): object|null
    {
        $pdo = Database::getInstance();
        $sql = 'SELECT
        `content`, 
        `start_date`,
        `end_date`
        FROM `announcements`
        WHERE `start_date` <= CURRENT_DATE
        AND `end_date` >= CURRENT_DATE
        AND `deactivated_at` IS NULL
        ORDER BY `id_announcement` DESC LIMIT 1';

        $sth = $pdo->prepare($sql);
        
        return ($sth->execute()) ? ($sth->fetch() ?: null) : null;
    }
}