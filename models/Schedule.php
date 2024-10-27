<?php


class Schedule
{

    private int $id;
    private string $week_day;
    private int $open_day;
    private string $open_hour;
    private string $close_mid_hour;
    private string $open_mid_hour;
    private string $close_hour;
    private string $updated_at;


    // GETTER & SETTER
    // ========================================================================
    // --------------------------------------------------
    // ID

    /**
     * Permet de définir l'id du jour
     * @param int $value
     * 
     * @return void
     */
    public function set_id(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Permet de récupérer l'id du jour
     * @return int
     */
    public function get_id(): int
    {
        return $this->id;
    }

    // --------------------------------------------------
    // WEEK_DAY

    /**
     * Permet de définir le nom du jour
     * @param string $value
     * 
     * @return void
     */
    public function set_week_day(string $value): void
    {
        $this->week_day = $value;
    }

    /**
     * Permet de récupérer le nom du jour
     * @return string
     */
    public function get_week_day(): string
    {
        return $this->week_day;
    }

    // --------------------------------------------------
    // OPEN_DAY

    /**
     * Permet de définir si un jour est ouvert ou non
     * @param int $value
     * 
     * @return void
     */
    public function set_open_day(int $value): void
    {
        $this->open_day = $value;
    }

    /**
     * Permet de récupérer si un jour est ouvert ou non
     * @return int
     */
    public function get_open_day(): int
    {
        return $this->open_day;
    }

    // --------------------------------------------------
    // OPEN_HOUR

    /**
     * Permet de définir l'horaire d'ouverture
     * @param string $value
     * 
     * @return void
     */
    public function set_open_hour(string $value): void
    {
        $this->open_hour = $value;
    }

    /**
     * Permet de récupérer l'horaire d'ouverture
     * @return string
     */
    public function get_open_hour(): string
    {
        return $this->open_hour;
    }

    // --------------------------------------------------
    // CLOSE_MID_HOUR

    /**
     * Permet de définir l'horaire de fermeture quand il y a une interruption
     * @param string $value
     * 
     * @return void
     */
    public function set_close_mid_hour(string $value): void
    {
        $this->close_mid_hour = $value;
    }

    /**
     * Permet de récupérer l'horaire de fermeture quand il y a une interruption
     * @return string
     */
    public function get_close_mid_hour(): string
    {
        return $this->close_mid_hour;
    }

    // --------------------------------------------------
    // CLOSE_MID_HOUR

    /**
     * Permet de définir l'horaire d'ouverture quand il y a une interruption
     * @param string $value
     * 
     * @return void
     */
    public function set_open_mid_hour(string $value): void
    {
        $this->open_mid_hour = $value;
    }

    /**
     * Permet de récupérer l'horaire d'ouverture quand il y a une interruption
     * @return string
     */
    public function get_open_mid_hour(): string
    {
        return $this->open_mid_hour;
    }

    // --------------------------------------------------
    // CLOSE_HOUR

    /**
     * Permet de définir l'horaire de fermeture
     * @param string $value
     * 
     * @return void
     */
    public function set_close_hour(string $value): void
    {
        $this->close_hour = $value;
    }

    /**
     * Permet de récupérer l'horaire de fermeture
     * @return string
     */
    public function get_close_hour(): string
    {
        return $this->close_hour;
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
    // UPDATE

    /**
     * Mets à jour les horaires d'un jour en particulier
     * @param int $id
     * 
     * @return bool
     */
    public function update(int $id): bool
    {
        $pdo = Database::getInstance();
        $sql = 'UPDATE `schedules` SET 
                        `open_day` = :open_day,
                        `open_hour` = :open_hour, 
                        `close_mid_hour` = :close_mid_hour,
                        `open_mid_hour` = :open_mid_hour,
                        `close_hour` = :close_hour,
                        `updated_at` = NOW()
                WHERE `id_schedules` = :id;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':open_day', $this->open_day, PDO::PARAM_INT);
        $sth->bindValue(':open_hour', $this->open_hour);
        $sth->bindValue(':close_mid_hour', $this->close_mid_hour);
        $sth->bindValue(':open_mid_hour', $this->open_mid_hour);
        $sth->bindValue(':close_hour', $this->close_hour);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);

        return $sth->execute();
    }


    // --------------------------------------------------
    // FETCH ALL

    /**
     * Permets de récupérer tous les horaires des jours de la semaine
     * @return array
     */
    public static function fetchAll(): array
    {
        $pdo = Database::getInstance();

        $sql = 'SELECT
            `id_schedules`, 
            `week_day`, 
            `open_day`,
            `open_hour`, 
            `close_mid_hour`, 
            `open_mid_hour`, 
            `close_hour` 
        FROM `schedules`;';

        $sth = $pdo->prepare($sql);

        return ($sth->execute()) ? $sth->fetchAll() : [];
    }
    // --------------------------------------------------
    // ========================================================================


    // VERIFICATION
    // ========================================================================
    // --------------------------------------------------

    /**
     * Permets de vérifier si les heures et les minutes sont bien conformes
     * @param array $hours
     * @param array $minutes
     * 
     * @return array
     */
    public static function verifSchedules(array $hours, array $minutes):array {

        $hours = array_map(fn($hour) => ($hour >= 0 && $hour <= 23), $hours);
        $minutes = array_map(fn($minute) => ($minute >= 0 && $minute <= 59), $minutes);

        return [$hours, $minutes];

    }
    // --------------------------------------------------
    // ========================================================================


    // FORMATAGE COMPLET POUR L'AFFICHAGE
    // ========================================================================
    // --------------------------------------------------

    /**
     * Permets de formater intégralement les horaires pour les afficher directement sans traitement supplémentaire
     * @param array $schedules
     * 
     * @return array
     */
    public static function formatting (array $schedules):array {

        foreach ($schedules as $schedule) {
            
            if ($schedule->open_day == 0) {

                $schedule->display = 'Fermé';

            } else {

                $time1 = date_create_from_format('H:i:s', $schedule->open_hour);
                $formattedTime1 = date_format($time1, 'H\hi');

                $time2 = date_create_from_format('H:i:s', $schedule->close_mid_hour);
                $formattedTime2 = date_format($time2, 'H\hi');

                $time3 = date_create_from_format('H:i:s', $schedule->open_mid_hour);
                $formattedTime3 = date_format($time3, 'H\hi');

                $time4 = date_create_from_format('H:i:s', $schedule->close_hour);
                $formattedTime4 = date_format($time4, 'H\hi');

                // Retrait des minutes si elles sont égales à '00'
                if (substr($formattedTime1, -2) === '00') {
                    $formattedTime1 = substr($formattedTime1, 0, -2);
                }

                if (substr($formattedTime2, -2) === '00') {
                    $formattedTime2 = substr($formattedTime2, 0, -2);
                }

                if (substr($formattedTime3, -2) === '00') {
                    $formattedTime3 = substr($formattedTime3, 0, -2);
                }

                if (substr($formattedTime4, -2) === '00') {
                    $formattedTime4 = substr($formattedTime4, 0, -2);
                }

                if ($schedule->open_day == 1) {
                    $schedule->display = "$formattedTime1-$formattedTime4";
                } else {
                    $schedule->display = "$formattedTime1-$formattedTime2, $formattedTime3-$formattedTime4";
                }
                
            }
        }

        return $schedules;
    }
    // --------------------------------------------------
    // ========================================================================
}
