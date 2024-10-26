<?php

require_once(__DIR__ . '/../../config/init.php');
require_once(__DIR__ . '/../../models/Category.php');


if (empty($_SESSION['user'])) {
    $categories = Category::fetch_index();
} else {
    $categories = Category::fetch_index(false, true);
}

echo json_encode($categories);