<?php

session_start();

if (empty($_SESSION['visitor'])) {
    $_SESSION['visitor'] = true;
    $display_modal = true;
} else {
    $display_modal = false;
}


echo json_encode($display_modal);