<?php


class Service
{
    private int $id;
    private string $name;
    private int $gender;
    private string $description;
    private string $start_exclusive_date;
    private string $end_exclusive_date;
    private bool $package;
    private string $created_at;
    private string $published_at;
    private string $updated_at;
    private string $deactivated_at;
    private int $id_category;


    // GETTER & SETTER
    // ========================================================================
    // --------------------------------------------------
    // ID

    /**
     * Permet de définir l'id de la prestation
     * @param int $value
     * 
     * @return void
     */
    public function set_id(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Permet de récupérer l'id de la prestation
     * @return int
     */
    public function get_id(): int
    {
        return $this->id;
    }

    // --------------------------------------------------
    // NOM

    /**
     * Permet de définir le nom de la prestation
     * @param string $value
     * 
     * @return void
     */
    public function set_name(string $value): void
    {
        $this->name = $value;
    }

    /**
     * Permet de récupérer le nom de la prestation
     * @return string
     */
    public function get_name(): string
    {
        return $this->name;
    }

    // --------------------------------------------------
    // GENRE

    /**
     * Permet de définir à quel genre est destiné la prestation
     * @param int $value
     * 
     * @return void
     */
    public function set_gender(int $value): void
    {
        $this->gender = $value;
    }

    /**
     * Permet de récupérer à quel genre est destiné la prestation
     * @return int
     */
    public function get_gender(): int
    {
        return $this->gender;
    }

    // --------------------------------------------------
    // DESCRIPTION

    /**
     * Permet de définir la description de la prestation
     * @param string $value
     * 
     * @return void
     */
    public function set_description(string $value): void
    {
        $this->description = $value;
    }

    /**
     * Permet de récupérer la description de la prestation
     * @return string
     */
    public function get_description(): string
    {
        return $this->description;
    }

    // --------------------------------------------------
    // DATE DE DÉPART D'UNE PRESTATION EXCLUSIVE

    /**
     * Permet de définir la date de départ d'une prestation exclusive
     * @param string $value
     * 
     * @return void
     */
    public function set_start_exclusive_date(string $value): void
    {
        $this->start_exclusive_date = $value;
    }

    /**
     * Permet de récupérer la date de départ d'une prestation exclusive
     * @return string
     */
    public function get_start_exclusive_date(): string
    {
        return $this->start_exclusive_date;
    }

    // --------------------------------------------------
    // DATE DE FIN D'UNE PRESTATION EXCLUSIVE

    /**
     * Permet de définir la date de fin d'une prestation exclusive
     * @param string $value
     * 
     * @return void
     */
    public function set_end_exclusive_date(string $value): void
    {
        $this->end_exclusive_date = $value;
    }

    /**
     * Permet de récupérer la date de fin d'une prestation exclusive
     * @return string
     */
    public function get_end_exclusive_date(): string
    {
        return $this->end_exclusive_date;
    }

    // --------------------------------------------------
    // FORFAIT

    /**
     * Permet de définir si la prestation est un forfait
     * @param bool $value
     * 
     * @return void
     */
    public function set_package(bool $value): void
    {
        $this->package = $value;
    }

    /**
     * Permet de récupérer si la prestation est un forfait
     * @return bool
     */
    public function get_package(): bool
    {
        return $this->package;
    }

    // --------------------------------------------------
    // DATE DE CRÉATION DE LA PRESTATION

    /**
     * Permet de définir la date de création de la prestation
     * @param string $value
     * 
     * @return void
     */
    public function set_created_at(string $value): void
    {
        $this->created_at = $value;
    }

    /**
     * Permet de récupérer la date de création de la prestation
     * @return string
     */
    public function get_created_at(): string
    {
        return $this->created_at;
    }

    // --------------------------------------------------
    // DATE DE MODIFICATION DE LA PRESTATION

    /**
     * Permet de définir la date de modification de la prestation
     * @param string $value
     * 
     * @return void
     */
    public function set_updated_at(string $value): void
    {
        $this->updated_at = $value;
    }

    /**
     * Permet de récupérer la date de modification de la prestation
     * @return string
     */
    public function get_updated_at(): string
    {
        return $this->updated_at;
    }

    // --------------------------------------------------
    // DATE DE PUBLICATION DE LA PRESTATION

    /**
     * Permet de définir la date de modification de la prestation
     * @param string $value
     * 
     * @return void
     */
    public function set_published_at(string $value): void
    {
        $this->published_at = $value;
    }

    /**
     * Permet de récupérer la date de modification de la prestation
     * @return string
     */
    public function get_published_at(): string
    {
        return $this->published_at;
    }

    // --------------------------------------------------
    // DATE DE DESACTIVATION DE LA PRESTATION

    /**
     * Permet de définir la date de modification de la prestation
     * @param string $value
     * 
     * @return void
     */
    public function set_deactivated_at(string $value): void
    {
        $this->deactivated_at = $value;
    }

    /**
     * Permet de récupérer la date de modification de la prestation
     * @return string
     */
    public function get_deactivated_at(): string
    {
        return $this->deactivated_at;
    }

    // --------------------------------------------------
    // ID CATEGORIE

    /**
     * Permet de définir l'id de la catégorie pour cette prestation
     * @param int $value
     * 
     * @return void
     */
    public function set_id_category(int $value): void
    {
        $this->id_category = $value;
    }

    /**
     * Permet de récupérer l'id de la catégorie pour cette prestation
     * @return int
     */
    public function get_id_category(): int
    {
        return $this->id_category;
    }


    // BDD
    // ========================================================================
    // --------------------------------------------------
    // INSERT

    /**
     * Permet d'ajouter une prestation
     * @return bool
     */
    public function insert(bool $exclusive): bool
    {
        $pdo = Database::getInstance();
        $sql = 'INSERT INTO `services` (`name`, `gender`, `description`, `package`, `id_category`, `created_at`) 
                VALUES (:name, :gender, :description, :package, :id_category, NOW());';

        if ($exclusive) {
            $sql = 'INSERT INTO `services` (`name`, `gender`, `description`, `package`, `start_exclusive_date`, `end_exclusive_date`, `id_category`, `created_at`, `published_at`) 
                VALUES (:name, :gender, :description, :package, :start_exclusive_date, :end_exclusive_date, :id_category, NOW(), NOW());';
        }

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':name', $this->name);
        $sth->bindValue(':gender', $this->gender, PDO::PARAM_INT);
        $sth->bindValue(':description', $this->description);
        $sth->bindValue(':package', $this->package, PDO::PARAM_BOOL);
        $sth->bindValue(':id_category', $this->id_category, PDO::PARAM_INT);

        if ($exclusive) {
            $sth->bindValue(':start_exclusive_date', $this->start_exclusive_date);
            $sth->bindValue(':end_exclusive_date', $this->end_exclusive_date);
        }

        return $sth->execute();
    }

    // --------------------------------------------------
    // UPDATE

    /**
     * Mets à jour une prestation
     * @param int $id
     * 
     * @return bool
     */
    public function update(int $id, bool $exclusive): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `services` SET 
                        `name` = :name,
                        `gender` = :gender,
                        `description` = :description,
                        `package` = :package,';

        if ($exclusive) {
            $sql .= ' `start_exclusive_date` = :start_exclusive_date, `end_exclusive_date` = :end_exclusive_date,';
        }

        $sql .= ' `updated_at` = NOW()
                WHERE `id_service` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':name', $this->name);
        $sth->bindValue(':gender', $this->gender, PDO::PARAM_INT);
        $sth->bindValue(':description', $this->description);
        $sth->bindValue(':package', $this->package, PDO::PARAM_BOOL);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        if ($exclusive) {
            $sth->bindValue(':start_exclusive_date', $this->start_exclusive_date);
            $sth->bindValue(':start_exclusive_date', $this->end_exclusive_date);
        }

        return $sth->execute();
    }

    // --------------------------------------------------
    // FETCH ALL

    /**
     * Permets de récupérer toutes les prestations avec leurs tarifs et leur promotion
     * 
     * @return array
     */
    public static function fetchAll($id = null, $admin = false): array
    {
        $pdo = Database::getInstance();

        if (is_null($id)) {
            $sql = 'SELECT 
                `services`.`id_category` AS `id_category`,
                `services`.`id_service` AS `id_service`,
                `services`.`name` AS `service_name`,
                `services`.`gender` AS `gender`,
                `services`.`package` AS `package`,
                `services`.`start_exclusive_date` AS `start_exclusive_date`,
                `services`.`end_exclusive_date` AS `end_exclusive_date`,
                `services`.`published_at` AS `service_published_at`,
                `services`.`deactivated_at` `service_deactivated_at`,
                GROUP_CONCAT(DISTINCT `pricings`.`duration` SEPARATOR \', \') AS `durations`,
                GROUP_CONCAT(DISTINCT `pricings`.`price` SEPARATOR \', \') AS `prices`,
                MAX(`discounts`.`advantage`) AS `advantage`,
                MAX(`discounts`.`euro`) AS `euro`,
                MAX(`discounts`.`start_date`) AS `discount_start_date`,
                MAX(`discounts`.`end_date`) AS `discount_end_date`,
                MAX(`discounts`.`deactivated_at`) AS `discount_deactivated_at`
                FROM `services`
                LEFT JOIN `pricings` ON `pricings`.`id_service` = `services`.`id_service`
                LEFT JOIN `discounts` ON `discounts`.`id_discount` = `services`.`id_discount`
                GROUP BY `services`.`id_service`
                ORDER BY 
                    CASE 
                        WHEN `start_exclusive_date` IS NOT NULL THEN 1
                        WHEN `package` = 0 THEN 2
                        ELSE 3
                    END,
                    `service_name` ASC;';
        } else {
            $sql = 'SELECT
                `services`.`name` AS `name`,
                `services`.`description` AS `description`,
                `services`.`gender` AS `gender`,
                `services`.`package` AS `package`,
                `services`.`start_exclusive_date` AS `start_exclusive_date`,
                `services`.`end_exclusive_date` AS `end_exclusive_date`,
                `services`.`published_at` AS `published_at`,
                `services`.`deactivated_at` `deactivated_at`,
                GROUP_CONCAT(DISTINCT `pricings`.`duration` SEPARATOR \', \') AS `durations`,
                GROUP_CONCAT(DISTINCT `pricings`.`price` SEPARATOR \', \') AS `prices`,
                MAX(`discounts`.`advantage`) AS `advantage`,
                MAX(`discounts`.`euro`) AS `euro`,
                MAX(`discounts`.`start_date`) AS `discount_start_date`,
                MAX(`discounts`.`end_date`) AS `discount_end_date`,
                MAX(`discounts`.`deactivated_at`) AS `discount_deactivated_at`
                FROM `services`
                LEFT JOIN `pricings` ON `pricings`.`id_service` = `services`.`id_service`
                LEFT JOIN `discounts` ON `discounts`.`id_discount` = `services`.`id_discount`
                WHERE `id_category` = :id ';

            if (!$admin) {
                $sql .= 'AND `services`.`published_at` IS NOT NULL
                AND `services`.`deactivated_at` IS NULL
                AND (
                    (`services`.`start_exclusive_date` IS NULL AND `services`.`end_exclusive_date` IS NULL)
                    OR (
                        `services`.`start_exclusive_date` <= CURRENT_DATE
                        AND `services`.`end_exclusive_date` >= CURRENT_DATE
                    )
                ) ';
            }

            $sql .= 'GROUP BY `services`.`id_service`
                ORDER BY 
                    CASE 
                        WHEN `start_exclusive_date` IS NOT NULL THEN 1
                        WHEN `package` = 0 THEN 2
                        ELSE 3
                    END,
                    `name` ASC;';
        }


        $sth = $pdo->prepare($sql);

        if (!is_null($id)) {
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
        }

        return ($sth->execute()) ? $sth->fetchAll() : [];
    }

    // --------------------------------------------------
    // FETCH

    // ! Reprendre le principe du return (ne concerne pas les fetchAll)

    /**
     * Permet de récupérer toutes les informations relatives à une prestation spécifique
     * 
     * @param int $id_service
     * 
     * @return object
     */
    public static function fetch(int $id_service): object|null
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT `name`, `gender`, `description`, `start_exclusive_date`, `end_exclusive_date`, `package`, `id_category`, 
        GROUP_CONCAT(`pricings`.`duration` ORDER BY `pricings`.`price` SEPARATOR \', \') AS `duration`, 
        GROUP_CONCAT(`pricings`.`price` ORDER BY `pricings`.`price` SEPARATOR \', \') AS `price`, 
        GROUP_CONCAT(`pricings`.`id_pricing` ORDER BY `pricings`.`price` SEPARATOR \', \') AS `id_pricing`
        FROM `services`
        JOIN `pricings` ON `pricings`.`id_service` = `services`.`id_service`
        WHERE `services`.`id_service` = :id_service
        GROUP BY `services`.`id_service`;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id_service', $id_service, PDO::PARAM_INT);

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
        $sql = 'UPDATE `services` SET 
                        `published_at` = NOW()
                WHERE `id_service` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // DELETE

    /**
     * Permet de supprimer une prestation
     * @param int $id
     * 
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'DELETE FROM `services`
                    WHERE `id_service` = :id;';

        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // DEACTIVATE

    /**
     * Désactive une prestation
     * @param int $id
     * 
     * @return bool
     */
    public static function deactivate(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `services` SET 
                        `deactivated_at` = NOW()
                WHERE `id_service` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // ACTIVATE

    /**
     * Active une prestation
     * @param int $id
     * 
     * @return bool
     */
    public static function activate(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `services` SET 
                        `deactivated_at` = null
                WHERE `id_service` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // ADD DISCOUNT

    /**
     * Ajoute une promotion à une ou plusieurs prestations
     * 
     * @param int $id_discount
     * @param int|null $id_service
     * 
     * @return bool
     */
    public static function add_discount(int $id_discount, int|null $id_service = null): bool
    {
        $pdo = Database::getInstance();

        if (is_null($id_service)) {
            $sql = 'UPDATE `services` SET 
                        `id_discount` = :id_discount
                        WHERE `package` = 0
                        AND `start_exclusive_date` IS NULL
                        AND `published_at` IS NOT NULL
                        AND `deactivated_at` IS NULL';
        } else {
            $sql = 'UPDATE `services` SET 
                        `id_discount` = :id_discount
                WHERE `id_service` = :id_service;';
        }

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id_discount', $id_discount, PDO::PARAM_INT);

        if ($id_service) {
            $sth->bindValue(':id_service', $id_service, PDO::PARAM_INT);
        }

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // RESET DISCOUNT

    /**
     * Retire la promotion d'une prestation concernée
     * 
     * @param int|null $id_service
     * 
     * @return bool
     */
    public static function reset_discount(int $id_discount): bool
    {
        $pdo = Database::getInstance();

        $sql = 'UPDATE `services` SET 
                `id_discount` = null
                WHERE `id_discount` = :id_discount';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id_discount', $id_discount, PDO::PARAM_INT);

        return ($sth->execute() && $sth->rowCount() > 0) ? true : false;
    }

    // --------------------------------------------------
    // IS_DISCOUNT_EXIST

    /**
     * Permet de récupérer les promotions déjà en cours sur les prestations
     * 
     * @param int $id_discount
     * 
     * @return array
     */
    public static function is_discounts_exist(int $id_discount): array
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT `id_service`
        FROM `services`
        WHERE `id_discount` IS NOT NULL ';

        if ($id_discount != 0) {
            $sql .= 'AND `id_discount` <> :id_discount ';
        }

        $sql .= 'GROUP BY `id_service`;';

        $sth = $pdo->prepare($sql);

        if ($id_discount != 0) {
            $sth->bindValue(':id_discount', $id_discount, PDO::PARAM_INT);
        }

        return ($sth->execute()) ? $sth->fetchAll(PDO::FETCH_COLUMN) : [];
    }

    // --------------------------------------------------
    // COUNT

    /**
     * Permet de récupérer le nombre total de prestations classiques
     *
     * @return int
     */
    public static function count(): int|bool
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT COUNT(`id_service`)
        FROM `services`
        WHERE `package` = 0 
        AND `start_exclusive_date` IS NULL
        AND `published_at` IS NOT NULL
        AND `deactivated_at` IS NULL;';

        $sth = $pdo->query($sql);

        return ($sth) ? $sth->fetchColumn() : false;
    }


    // AUTRES
    // ========================================================================
    // --------------------------------------------------
    // NEW_DISPLAY


    /**
     * Permet de définir une nouveauté
     * 
     * @param string $date
     * 
     * @return bool
     */
    public static function new_display(string $date): bool
    {

        // Convertir la date de publication en objet DateTime.
        $publication_date = new DateTime($date);

        // Date actuelle.
        $current_date = new DateTime();

        // Calcule la différence en jours entre la date actuelle et la date de publication.
        $interval = $current_date->diff($publication_date)->days;

        // Si la date de publication n'excède pas 30 jours par rapport à la date actuelle, renvoi true.
        return ($interval < 30) ? true : false;
    }
}
