<?php

class Flash {

    private static function sessionStart() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function setMessage(string $message, bool $success = true) {
        self::sessionStart();
        $_SESSION['flash']['message'] = $message;

        if ($success) {
            $_SESSION['flash']['class'] = 'bg-green';
            $_SESSION['flash']['icon'] = 'bi-check-circle-fill';
        } else {
            $_SESSION['flash']['class'] = 'bg-dark-pink';
            $_SESSION['flash']['icon'] = 'bi-exclamation-circle-fill';
        }
    }

    public static function getMessage():array {
        self::sessionStart();
        $flash = (isset($_SESSION['flash'])) ? $_SESSION['flash'] : '';
        self::deleteMessage();
        return $flash;
    }

    public static function isExist():bool {
        self::sessionStart();
        return isset($_SESSION['flash']) ? true : false;
    }



    private static function deleteMessage() {
        unset($_SESSION['flash']);
    }
}