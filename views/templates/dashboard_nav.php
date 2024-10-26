<div class="col-12 col-xxl-2 dashboard-nav">
    <aside>
        <nav class="navbar navbar-expand-xxl">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <div class="links-container d-flex flex-column flex-md-row flex-xxl-column mt-4">
                        <ul class="d-flex flex-column navbar-nav mx-auto mb-2 mb-lg-0">
                            <div class="navbar-title mb-3">Général</div>
                            <li class="nav-item py-2 px-md-4 px-xl-0">
                                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'account_controller.php') ? 'active' : ''; ?>" <?= (basename($_SERVER['PHP_SELF']) == 'account_controller.php') ? 'aria-current="location"' : ''; ?> href="/gestion/mon-compte"><i class="bi bi-person-bounding-box mx-3"></i>Mon compte</a>
                            </li>
                            <li class="nav-item py-2 px-md-4 px-xl-0">
                                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'schedules_controller.php') ? 'active' : ''; ?>" <?= (basename($_SERVER['PHP_SELF']) == 'schedules_controller.php') ? 'aria-current="location"' : ''; ?> href="/gestion/mes-horaires"><i class="bi bi-clock mx-3"></i>Mes horaires</a>
                            </li>
                            <li class="nav-item py-2 px-md-4 px-xl-0">
                                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'announcement_controller.php') ? 'active' : ''; ?>" <?= (basename($_SERVER['PHP_SELF']) == 'announcement_controller.php') ? 'aria-current="location"' : ''; ?> href="/gestion/mes-annonces"><i class="bi bi-megaphone mx-3"></i>Mes annonces</a>
                            </li>
                        </ul>

                        <ul class="d-flex flex-column navbar-nav me-auto mt-xxl-5 mb-2 mb-lg-0">
                            <div class="navbar-title mb-3">Prestations</div>
                            <li class="nav-item py-2 px-md-4 px-xl-0">
                                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'services_list_controller.php') ? 'active' : ''; ?>" <?= (basename($_SERVER['PHP_SELF']) == 'services_list_controller.php') ? 'aria-current="location"' : ''; ?> href="/gestion/liste-des-prestations"><i class="bi bi-list-ul mx-3"></i>Liste des prestations</a>
                            </li>
                            <li class="nav-item py-2 px-md-4 px-xl-0">
                                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'discounts_list_controller.php' || basename($_SERVER['PHP_SELF']) == 'discount_manager_controller.php') ? 'active' : ''; ?>" <?= (basename($_SERVER['PHP_SELF']) == 'discounts_list_controller.php' || basename($_SERVER['PHP_SELF']) == 'discount_manager_controller.php') ? 'aria-current="location"' : ''; ?> href="/gestion/liste-des-promotions"><i class="bi bi-tags mx-3"></i>Promotions</a>
                            </li>
                            <li class="nav-item py-2 px-md-4 px-xl-0">
                                <a class="nav-link <?= ($current_path == '/gestion/ajouter-une-categorie') ? 'active' : ''; ?>" <?= ($current_path == '/gestion/ajouter-une-categorie') ? 'aria-current="location"' : ''; ?> href="/gestion/ajouter-une-categorie"><i class="bi bi-plus-circle mx-3"></i>Ajouter une catégorie</a>
                            </li>
                            <li class="nav-item py-2 px-md-4 px-xl-0">
                                <a class="nav-link <?= ($current_path == '/gestion/ajouter-une-prestation') ? 'active' : ''; ?>" <?= ($current_path == '/gestion/ajouter-une-prestation') ? 'aria-current="location"' : ''; ?> href="/gestion/ajouter-une-prestation"><i class="bi bi-plus-circle mx-3"></i>Ajouter une prestation</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </aside>
</div>