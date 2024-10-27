<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Petrona:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./../../../public/assets/bootstrap-icons-1.10.3/bootstrap-icons.css">
    <link rel="stylesheet" href="./../../../public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./../../../public/assets/css/main.css">
    <meta name="description" content="<?= $meta_description ?? '' ?>">
    <link rel="icon" type="image/png" href="./../../../public/assets/img/logos/logo.webp">
    <title><?= $document_title ?? '' ?></title>
    <?= $leaflet_css ?? '' ?>
    <?= $captcha_script ?? '' ?>
</head>

<body>

    <header>
        <nav class="navbar navbar-dark mainNav navbar-expand-xl">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="/accueil"><img src="./../../../public/assets/img/logos/logo.webp" alt="Logo l'Aura Natur'elle" class="d-inline-block me-3">L'Aura Natur'elle</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end offcanvasColor" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <a class="navbar-brand offcanvas-title d-flex align-items-center" href="/accueil" id="offcanvasDarkNavbarLabel"><img src="../public/assets/img/logos/logo.webp alt="Logo l'Aura Natur'elle" class="d-inline-block me-3">L'Aura Natur'elle</a>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav my-auto">
                            <li class="nav-item drop-menu mx-1 mx-xl-3 mx-xxl-4 my-2 my-xl-0">
                                <a class="nav-link header-link <?= (basename($_SERVER['PHP_SELF']) == 'services_controller.php' || basename($_SERVER['PHP_SELF']) == 'services_categories_controller.php') ? 'active' : ''; ?>" <?= (basename($_SERVER['PHP_SELF']) == 'services_controller.php' || basename($_SERVER['PHP_SELF']) == 'services_categories_controller.php') ? 'aria-current="page"' : ''; ?> href="/prestations">
                                    Prestations
                                </a>
                                <ul class="drop-links d-none">
                                    <?php foreach ($nav_categories as $key => $link) { ?>
                                        <li><a href="/prestations/<?= $link->slug ?>?id=<?= $link->id_category ?>" class="ps-3 <?= (basename($_SERVER['PHP_SELF']) == 'services_controller.php') && $_GET['id'] == $link->id_category ? 'active' : ''; ?>" <?= (basename($_SERVER['PHP_SELF']) == 'services_controller.php') && $_GET['id'] == $link->id_category ? 'aria-current="location"' : ''; ?>><?= $link->name ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <!-- <li class="nav-item mx-1 mx-xl-3 mx-xxl-4 my-2 my-xl-0">
                                <a class="nav-link header-link" href="">Prendre RDV</a>
                            </li> -->
                            <li class="nav-item mx-1 mx-xl-3 mx-xxl-4 my-2 my-xl-0">
                                <a class="nav-link header-link <?= (basename($_SERVER['PHP_SELF']) == 'gift_card_controller.php') ? 'active' : ''; ?>" <?= (basename($_SERVER['PHP_SELF']) == 'gift_card_controller.php') ? 'aria-current="page"' : ''; ?> href="/cartes-cadeaux">Cartes cadeaux</a>
                            </li>
                            <li class="nav-item mx-1 mx-xl-3 mx-xxl-4 my-2 my-xl-0">
                                <a class="nav-link header-link <?= (basename($_SERVER['PHP_SELF']) == 'contact_controller.php') ? 'active' : ''; ?>" <?= (basename($_SERVER['PHP_SELF']) == 'contact_controller.php') ? 'aria-current="page"' : ''; ?> href="/contact">Contact</a>
                            </li>
                        </ul>
                        <?php if(isset($_SESSION['user'])) { ?>
                        <ul class="navbar-nav justify-content-end align-items-xl-center flex-grow-1">
                            <li class="nav-item mx-1 mx-xxl-3 my-2 my-xl-0">
                                <a class="nav-link dashboardLink px-4 <?= (strpos($_SERVER['PHP_SELF'], '/dashboard/') !== false) ? 'active' : ''; ?>" <?= (strpos($_SERVER['PHP_SELF'], '/dashboard/') !== false) ? 'aria-current="page"' : ''; ?> href="/gestion/mon-compte">Gestion</a>
                            </li>
                            <li class="nav-item me-4"><a href="/gestion/deconnexion" title="Se déconnecter" class="nav-link"><i class="bi bi-box-arrow-in-right fs-4"></i></a></li>
                        </ul> 
                        <?php } ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>