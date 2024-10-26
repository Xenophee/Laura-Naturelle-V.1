<?php

session_start();

require_once(__DIR__ . '/constants.php');
require_once(__DIR__ . '/seo.php');
require_once(__DIR__ . '../../helpers/functions.php');

require_once(__DIR__ . './../helpers/Database.php');
require_once(__DIR__ . './../models/User.php');
require_once(__DIR__ . './../models/Schedule.php');
require_once(__DIR__ . './../models/Category.php');



if (empty($_SESSION['user'])) {
    $nav_categories = Category::fetch_index(true);
} else {
    $nav_categories = Category::fetch_index(true, true);
}

foreach ($nav_categories as $key => $nav_category) {
    $nav_category->slug = slug($nav_category->name);
}

$current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$artisan = User::fetch_artisan();

$artisan->phone = preg_replace('/(\d{2})(?=\d)/', '$1 ', $artisan->phone);

$schedules = Schedule::fetchAll();

$schedules_sign = Schedule::formatting($schedules);
