<main>
    <div class="container-fluid px-0">

        <div class="row justify-content-around mx-0">

            <?php
            include(__DIR__ . './../../views/templates/dashboard_nav.php');
            ?>

            <div class="col-12 col-xl-9 col-xxl-10">
                <section class="d-flex flex-column justify-content-center align-items-center">
                    <h1 class="category-title text-center py-4 my-5 px-3 px-md-5">Ajouter une catégorie</h1>

                    <!-- ========================================================================================================================================================================== -->
                    <!-- MESSAGE FLASH -->
                    <!-- ========================================================================================================================================================================== -->

                    <?php if (Flash::isExist()) {
                        $flash = Flash::getMessage(); ?>
                        <div class="alert alert-dismissible <?= $flash['class'] ?? '' ?> fade show w-50 mt-5" data-bs-theme="dark" role="alert">
                            <div><i class="bi <?= $flash['icon'] ?? '' ?> me-3"></i><?= $flash['message'] ?></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <!-- ========================================================================================================================================================================== -->
                    <!-- FORMULAIRE -->
                    <!-- ========================================================================================================================================================================== -->

                    <form method="post" action="../../controllers/dashboard/category_manager_controller.php?id=<?= $id ?>" enctype="multipart/form-data" class="dashboard-form mt-5" id="category-form">

                        <fieldset class="mb-5">

                            <!-- -------------------------------------------------------------- -->
                            <!-- IMAGE DE LA CATÉGORIE -->
                            <div class="mb-5">
                                <div class="d-flex justify-content-center mb-4">
                                    <img src="<?= (empty($id)) ? '../../public/assets/img/illustrations/others/cover.webp' : '../../public/uploads/categories/' . $id . '-xl.webp'?>" class="cover img-fluid" alt="Image d'illustration">
                                </div>
                                <p class="text-center text-green fst-italic">Si le découpage ne vous convient pas, n'hésitez pas à recadrer l'image d'origine sur <a href="https://www.resizepixel.com/fr" class="text-pink underline" target="_blank" rel="noopener noreferrer">Resizepixel</a>.</p>
                                <div class="d-flex justify-content-center">
                                    <div>
                                        <label class="btn btn-classic form-label d-flex align-items-center justify-content-center py-3 m-1" for="cover">Image de couverture</label>
                                        <input type="file" class="form-control d-none" id="cover" name="cover" accept="image/jpeg">
                                    </div>
                                </div>
                                <small class="<?= (empty($cover['message'])) ? 'd-none' : '' ?> d-block text-danger text-center fst-italic mt-2" role="alert" aria-errormessage="cover" id="coverError"><?= $cover['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- CHOIX DU CONTRASTE PAR RAPPORT À L'IMAGE -->
                            <label class="d-block text-center">Rendu textuel sur l'image en page d'accueil * :</label>
                            <small class="<?= (empty($darkmode['message'])) ? 'd-none' : '' ?> d-block text-danger text-center fst-italic mt-2" role="alert" id="darkmodeError"><?= $darkmode['message'] ?? '' ?></small>
                            <div class="btn-group d-flex mt-3 mb-5" role="group" aria-label="Choisir l'affichage en page d'accueil">
                                <input type="radio" class="btn-check" name="darkmode" value="0" id="light" autocomplete="off" aria-errormessage="darkmodeError" <?= (isset($darkmode) && $darkmode['data'] === 0) || (isset($category) && $category->darkmode === 0) ? 'checked' : '' ?> required>
                                <label class="btn btn-radio" for="light">Mode clair</label>
                            
                                <input type="radio" class="btn-check" name="darkmode" value="1" id="dark" autocomplete="off" aria-errormessage="darkmodeError" <?= (isset($darkmode) && $darkmode['data'] === 1) || (isset($category) && $category->darkmode === 1) ? 'checked' : '' ?>>
                                <label class="btn btn-radio" for="dark">Mode sombre</label>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- NOM DE LA CATÉGORIE -->
                            <div class="mb-4">
                                <label for="title" class="form-label me-3">Nom * :</label>
                                <input type="text" class="form-control <?= (empty($name['message'])) ? '' : 'error-form' ?>" id="title" name="title" value="<?= $name['data'] ?? $category->name ?? '' ?>" pattern="<?= $regex->get_text() ?>" maxlength="<?= TEXT_LIMIT['short'] ?>" required>
                                <small class="<?= (empty($name['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="title" id="titleError"><?= $name['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- DESCRIPTION DE LA CATEGORIE -->
                            <div class="mb-4 pt-md-5">
                                <p class="text-center text-green fst-italic mb-5">Afin de limiter les erreurs d'orthographe, vous pouvez faire vérifier votre texte sur le site de <a href="https://bonpatron.com/fr/" class="text-pink underline" target="_blank" rel="noopener noreferrer">Bonpatron</a>.</p>
                                <div class="d-flex flex-column flex-md-row justify-content-between">
                                    <label for="description" class="form-label me-3">Description :</label>
                                    <small>Nb de caractères restants : <span id="counterChar"><?= TEXT_LIMIT['large'] ?></span></small>
                                </div>
                                <textarea class="form-control <?= (empty($description['message'])) ? '' : 'error-form' ?> textarea" name="description" id="description" maxlength="<?= TEXT_LIMIT['large'] ?>"><?= $description['data'] ?? $category->description ?? '' ?></textarea>
                                <small class="<?= (empty($description['message'])) ? 'd-none' : '' ?> text-danger fst-italic mt-2" role="alert" aria-errormessage="description" id="descriptionLenght"><?= $description['message'] ?? '' ?></small>
                            </div>
                            <!-- -------------------------------------------------------------- -->

                            <!-- -------------------------------------------------------------- -->
                            <!-- MODE D'AFFICHAGE DES PRESTATIONS -->
                            <label class="d-block text-center pt-4">Comment souhaitez-vous afficher les prestations de cette catégorie ? *</label>
                            <small class="<?= (empty($view['message'])) ? 'd-none' : '' ?> d-block text-danger text-center fst-italic mt-2" role="alert" id="viewError"><?= $view['message'] ?? '' ?></small>
                            <div class="btn-group d-flex pt-3 pb-md-5" role="group" aria-label="Choisir l'affichage des prestations au sein de la catégorie">
                                <input type="radio" class="btn-check" name="view" value="1" id="lines" autocomplete="off" aria-errormessage="viewError" <?= (isset($view) && $view['data'] == 1) || (isset($category) && $category->view == 1) ? 'checked' : '' ?> required>
                                <label class="btn btn-radio" for="lines">Affichage en ligne</label>
                            
                                <input type="radio" class="btn-check" name="view" value="2" id="grid" autocomplete="off" aria-errormessage="viewError" <?= (isset($view) && $view['data'] == 2) || (isset($category) && $category->view == 2) ? 'checked' : '' ?>>
                                <label class="btn btn-radio" for="grid">Affichage en grille</label>
                            </div>
                            <!-- -------------------------------------------------------------- -->
                        </fieldset>

                        <!-- -------------------------------------------------------------- -->
                        <!-- BOUTON DE VALIDATION -->
                        <div class="d-flex justify-content-center pb-md-5 mb-5">
                            <button type="submit" class="btn btn-classic py-2"><i class="bi bi-pencil-fill me-3" aria-hidden="true"></i><?= (empty($id)) ? 'Ajouter' : 'Modifier' ?> la catégorie</button>
                        </div>
                        <!-- -------------------------------------------------------------- -->

                    </form>
                </section>
            </div>

        </div>

    </div>
</main>