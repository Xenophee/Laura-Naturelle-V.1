<?php

class Category
{
    private int $id;
    private string $name;
    private string $description;
    private int $view;
    private bool $darkmode;
    private string $created_at;
    private string $published_at;
    private string $updated_at;
    private string $deactivated_at;


    // GETTER & SETTER
    // ========================================================================
    // --------------------------------------------------
    // ID

    /**
     * Permet de définir l'id de la catégorie
     * @param int $value
     * 
     * @return void
     */
    public function set_id(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Permet de récupérer l'id de la catégorie
     * @return int
     */
    public function get_id(): int
    {
        return $this->id;
    }

    // --------------------------------------------------
    // NOM

    /**
     * Permet de définir le nom de la catégorie
     * @param string $value
     * 
     * @return void
     */
    public function set_name(string $value): void
    {
        $this->name = $value;
    }

    /**
     * Permet de récupérer le nom de la catégorie
     * @return string
     */
    public function get_name(): string
    {
        return $this->name;
    }

    // --------------------------------------------------
    // DESCRIPTION

    /**
     * Permet de définir la description de la catégorie
     * @param string $value
     * 
     * @return void
     */
    public function set_description(string $value): void
    {
        $this->description = $value;
    }

    /**
     * Permet de récupérer la description de la catégorie
     * @return string
     */
    public function get_description(): string
    {
        return $this->description;
    }

    // --------------------------------------------------
    // VUE

    /**
     * Permet de définir la vue utilisée pour la catégorie
     * @param int $value
     * 
     * @return void
     */
    public function set_view(int $value): void
    {
        $this->view = $value;
    }

    /**
     * Permet de récupérer la vue utilisée pour la catégorie
     * @return int
     */
    public function get_view(): int
    {
        return $this->view;
    }

    // --------------------------------------------------
    // DARKMODE

    /**
     * Permet de définir l'utilisation du darkmode pour la catégorie
     * @param bool $value
     * 
     * @return void
     */
    public function set_darkmode(bool $value): void
    {
        $this->darkmode = $value;
    }

    /**
     * Permet de récupérer l'utilisation du darkmode pour la catégorie
     * @return bool
     */
    public function get_darkmode(): bool
    {
        return $this->darkmode;
    }

    // --------------------------------------------------
    // DATE DE CRÉATION DE LA CATÉGORIE

    /**
     * Permet de définir la date de création de la catégorie
     * @param string $value
     * 
     * @return void
     */
    public function set_created_at(string $value): void
    {
        $this->created_at = $value;
    }

    /**
     * Permet de récupérer la date de création de la catégorie
     * @return string
     */
    public function get_created_at(): string
    {
        return $this->created_at;
    }

    // --------------------------------------------------
    // DATE DE PUBLICATION DE LA CATÉGORIE

    /**
     * Permet de définir la date de modification de la catégorie
     * @param string $value
     * 
     * @return void
     */
    public function set_published_at(string $value): void
    {
        $this->published_at = $value;
    }

    /**
     * Permet de récupérer la date de modification de la catégorie
     * @return string
     */
    public function get_published_at(): string
    {
        return $this->published_at;
    }

    // --------------------------------------------------
    // DATE DE MODIFICATION DE LA CATÉGORIE

    /**
     * Permet de définir la date de modification de la catégorie
     * @param string $value
     * 
     * @return void
     */
    public function set_updated_at(string $value): void
    {
        $this->updated_at = $value;
    }

    /**
     * Permet de récupérer la date de modification de la catégorie
     * @return string
     */
    public function get_updated_at(): string
    {
        return $this->updated_at;
    }

    // --------------------------------------------------
    // DATE DE DESACTIVATION DE LA CATÉGORIE

    /**
     * Permet de définir la date de modification de la catégorie
     * @param string $value
     * 
     * @return void
     */
    public function set_deactivated_at(string $value): void
    {
        $this->deactivated_at = $value;
    }

    /**
     * Permet de récupérer la date de modification de la catégorie
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
     * Permet d'ajouter une catégorie
     * @return bool
     */
    public function insert(): bool
    {
        $pdo = Database::getInstance();
        $sql = 'INSERT INTO `categories` (`name`, `description`, `view`, `darkmode`, `created_at`) 
                VALUES (:name, :description, :view, :darkmode, NOW());';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':name', $this->name);
        $sth->bindValue(':description', $this->description);
        $sth->bindValue(':view', $this->view, PDO::PARAM_INT);
        $sth->bindValue(':darkmode', $this->darkmode, PDO::PARAM_BOOL);

        return $sth->execute();
    }

    // --------------------------------------------------
    // UPDATE

    /**
     * Mets à jour une catégorie
     * @param int $id
     * 
     * @return bool
     */
    public function update(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `categories` SET 
                        `name` = :name,
                        `description` = :description, 
                        `view` = :view,
                        `darkmode` = :darkmode,
                        `updated_at` = NOW()
                WHERE `id_category` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':name', $this->name);
        $sth->bindValue(':description', $this->description);
        $sth->bindValue(':view', $this->view, PDO::PARAM_INT);
        $sth->bindValue(':darkmode', $this->darkmode, PDO::PARAM_BOOL);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return $sth->execute();
    }

    // --------------------------------------------------
    // FETCH ALL

    /**
     * Permets de récupérer toutes les catégories
     * @param bool $join Permet d'effectuer la requête complète ou non
     * 
     * @return array
     */
    public static function fetchAll(bool $join = false): array
    {
        $pdo = Database::getInstance();

        if ($join) {
            // Requête utilisée pour ajouter une promotion
            $sql = 'SELECT `categories`.`id_category` AS `id_category`,
            `categories`.`name` AS `category_name`,
            GROUP_CONCAT(DISTINCT `services`.`id_service` ORDER BY `services`.`name` SEPARATOR \', \') AS `id_services`,
            GROUP_CONCAT(`services`.`name` ORDER BY `services`.`name` SEPARATOR \', \') AS `service_names`,
            GROUP_CONCAT(`services`.`gender` ORDER BY `services`.`name` SEPARATOR \', \') AS `genders`,
            MAX(`services`.`id_discount`) AS `id_discount`
            FROM `categories`
            JOIN `services` ON `services`.`id_category` = `categories`.`id_category`
            WHERE `services`.`package` = 0
            AND `services`.`start_exclusive_date` IS NULL
            AND `services`.`published_at` IS NOT NULL
            AND `services`.`deactivated_at` IS NULL
            AND `categories`.`published_at` IS NOT NULL
            AND `categories`.`deactivated_at` IS NULL
            GROUP BY `categories`.`id_category`
            ORDER BY `categories`.`name` ASC;';
        } else {
            $sql = 'SELECT 
            `id_category`,
            `name`,
            `description`,
            `view`,
            `darkmode`,
            `published_at`, 
            `deactivated_at`
            FROM `categories`;';
        }

        $sth = $pdo->prepare($sql);

        return ($sth->execute()) ? $sth->fetchAll() : [];
    }

    // --------------------------------------------------
    // FETCH INDEX

    /**
     * Permets de récupérer les catégories actives (nom et id)
     * 
     * @param bool $add_name Permet de renvoyer le nom de la catégorie en plus
     * 
     * @return array
     */
    public static function fetch_index(bool $add_name = false, bool $admin = false): array
    {
        $pdo = Database::getInstance();

        if ($add_name) {

            $sql = 'SELECT
                    `id_category`,
                    `name`
                    FROM `categories` ';

            if (!$admin) {
                $sql .= 'WHERE `deactivated_at` IS NULL AND `published_at` IS NOT NULL ';
            }

            $sql .= 'ORDER BY `categories`.`name` ASC;';

        } else {
            $sql = 'SELECT
            `id_category`, `darkmode`
            FROM `categories` ';
            
            if (!$admin) {
                $sql .= 'WHERE `deactivated_at` IS NULL AND `published_at` IS NOT NULL';
            }

            $sql .= ';';
        }

        $sth = $pdo->prepare($sql);

        return ($sth->execute()) ? $sth->fetchAll() : [];
    }

    // --------------------------------------------------
    // FETCH

    /**
     * Permet de récupérer toutes les informations relatives à une catégorie spécifique
     * 
     * @param int $id_category
     * 
     * @return object
     */
    public static function fetch(int $id_category): object|null
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT `name`, `description`, `view`, `darkmode`
        FROM `categories`
        WHERE `id_category` = :id_category';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id_category', $id_category, PDO::PARAM_INT);

        return ($sth->execute()) ? ($sth->fetch() ?: null) : null;
    }

    // --------------------------------------------------
    // PUBLISH

    /**
     * Publie une prestation
     * @param int $id
     * 
     * @return bool
     */
    public static function publish(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `categories` SET 
                        `published_at` = NOW()
                WHERE `id_category` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // DELETE

    /**
     * Permet de supprimer une catégorie
     * @param int $id
     * 
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'DELETE FROM `categories`
                    WHERE `id_category` = :id;';

        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // DEACTIVATE

    /**
     * Désactive une catégorie
     * @param int $id
     * 
     * @return bool
     */
    public static function deactivate(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `categories` SET 
                        `deactivated_at` = NOW()
                WHERE `id_category` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // ACTIVATE

    /**
     * Active une catégorie
     * @param int $id
     * 
     * @return bool
     */
    public static function activate(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `categories` SET 
                        `deactivated_at` = null
                WHERE `id_category` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // COUNT

    /**
     * Permet de récupérer le nombre total de catégories
     *
     * @return int
     */
    public static function count(): int|bool
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT COUNT(`id_category`)
        FROM `categories`
        WHERE `published_at` IS NOT NULL;';

        $sth = $pdo->query($sql);

        return ($sth) ? $sth->fetchColumn() : false;
    }
}
