<footer>
    <div class="container-fluid">
        <div class="row justify-content-around mt-4 mb-4 mb-lg-0 mb-xxl-4 mx-0">
            <div class="col-12 col-md-6 col-lg-3 order-1 d-flex justify-content-md-center mb-4 mb-md-5 mb-lg-4" id="informations">
                <ul class="ms-3 ms-md-0">
                    <li class="fs-4 footerTitle mb-4">Informations</li>
                    <li class="my-2"><a href="/informations/mentions-legales" class="footer-link">Mentions légales</a></li>
                    <li class="my-2"><a href="/informations/politique-de-confidentialite" class="footer-link">Politiques de confidentialité</a></li>
                    <li class="my-2"><a href="/informations/conditions-generales-de-vente" class="footer-link">Conditions générales de vente</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3 order-3 order-lg-2 d-flex justify-content-md-center mb-4" id="contact">
                <ul class="ms-3 ms-md-0">
                    <li class="fs-4 footerTitle mb-4">Contact</li>
                    <li class="my-3"><i class="bi bi-geo-alt me-2"></i> <?= $artisan->address ?> <br> <?= $artisan->zipcode . ' ' . $artisan->city ?></li>
                    <li class="my-3"><a href="mailto: <?= $artisan->email ?>"><i class="bi bi-envelope-at me-2"></i><?= $artisan->email ?></a></li>
                    <li class="my-3"><i class="bi bi-telephone me-2"></i><?= $artisan->phone ?></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3 order-2 order-lg-3 d-flex justify-content-md-center mb-4 mb-md-5 mb-lg-4" id="websiteNavigation">
                <ul class="ms-3 ms-md-0">
                    <li class="fs-4 footerTitle mb-4">L' Aura Natur'elle</li>
                    <li class="my-2"><a href="/accueil" class="footer-link">Accueil</a></li>
                    <li class="my-2"><a href="/prestations" class="footer-link">Prestations</a></li>
                    <!-- <li class="my-2"><a href="" class="footer-link">Prendre RDV</a></li> -->
                    <li class="my-2"><a href="/cartes-cadeaux" class="footer-link">Carte cadeaux</a></li>
                    <li class="my-2"><a href="/contact" class="footer-link">Contact</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-3 order-4 d-flex justify-content-md-center mb-4" id="schedule">
                <ul class="ms-3 ms-md-0">
                    <li class="fs-4 footerTitle mb-4">Horaires</li>
                    <?php foreach ($schedules_sign as $schedule) { ?>
                        <li class="my-2"><span><?= $schedule->week_day ?> :</span> <?= $schedule->display ?></li><?php } ?>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-6 order-5 d-flex justify-content-center align-items-center" id="socialNetwork">
                <ul class="d-flex">
                    <li class="me-5"><a href="https://www.facebook.com/lauranaturellebioetvegan02" target="_blank" rel="noopener noreferrer" title="Facebook" aria-label="Ouvrir la page facebook de L'Aura Natur'elle"><i class="bi bi-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="https://www.instagram.com/lauranaturelle" target="_blank" rel="noopener noreferrer" title="Instagram" aria-label="Ouvrir la page instagram de L'Aura Natur'elle"><i class="bi bi-instagram" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>

        <div class="row mx-0">
            <div class="col d-flex flex-column justify-content-center align-items-center">
                <hr>
                <small class="text-center mb-4">© L'Aura Natur'elle 2019 - <?= date('Y') ?> - Tous droits réservés</small>
            </div>
        </div>
    </div>
</footer>


<?= $map_location ?? '' ?>
<?= $review_google ?? '' ?>
<script src="../../public/assets/js/bootstrap.min.js"></script>
<script src="../../public/assets/js/script.js"></script>

<?php if (isset($js)) {
    foreach ($js as $sheet) { ?>
        <script type="module" src="../../public/assets/js/<?= $sheet ?>.js"></script>
<?php }
} ?>

</body>

</html>