<main>
    <div class="container-fluid px-0">
        <h1 class="text-center pt-5 mt-md-5">Cartes cadeaux</h1>

        <section class="pb-5">
            <!-- TITRE CATEGORIE -->
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
            <div class="row mx-0 px-md-5 pb-md-5 my-xxl-5">
                <div class="col-12 col-lg-5 d-flex align-items-center">
                    <div class="d-flex justify-content-center pt-5 mt-5 w-100">
                        <picture class="d-flex justify-content-center gift-card">
                            <source srcset="../public/assets/img/illustrations/others/gift_card-xl.webp" type="image/webp" media="(min-width: 768px)">
                            <img src="../public/assets/img/illustrations/others/gift_card.webp" alt="Carte cadeau l'Aura Natur'elle" class="img-fluid">
                        </picture>
                    </div>
                </div>

                <?php if (isset($payment_status)) { ?>
                    <div class="col-12 col-lg-7 col-xxl-5 d-flex align-items-center mt-5 mt-md-0">
                        <div class="d-flex align-items-center py-5">
                            <?php if ($payment_status) { ?>
                                <p class="text-center text-green fs-3">L'Aura Natur'elle vous remercie de votre confiance pour l'achat d'une carte cadeau.</p>
                            <?php } else { ?>
                                <p class="text-center text-pink fs-3">Le paiement de la carte cadeau a échoué.</p>
                            <?php }
                            ?>
                        </div>
                    </div>

                <?php } else { ?>
                    <div class="col-12 col-lg-7 mt-5 mt-md-0">
                        <p class="service-text text-center pt-md-5 mt-5">Faites plaisir à vos proches en leur
                            envoyant une carte cadeau !</p>

                        <form method="POST">
                            <div class="d-flex flex-column align-items-center py-5">
                                <label class="d-block text-center mb-3">Choisissez le montant :</label>
                                <small class="<?= (empty($price['message'])) ? 'd-none' : '' ?> text-danger text-center fst-italic mb-2" role="alert" id="priceError"><?= $price['message'] ?? '' ?></small>

                                <div class="d-flex flex-wrap flex-md-nowrap btn-group btn-group-gift-card" role="group" aria-label="Choisir le montant de la carte cadeau">
                                    <?php foreach (GIFT_CARD_PRICES as $key => $price) { ?>
                                        <input type="radio" class="btn-check" name="price" value="<?= $price ?>" id="price<?= $key + 1 ?>" autocomplete="off" aria-errormessage="priceError">
                                        <label class="btn btn-radio py-2 mt-2 mt-md-0" for="price<?= $key + 1 ?>"><?= $price ?> €</label>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="d-flex justify-content-evenly align-items-center mt-md-5">
                                <span class="line"></span>
                                <button type="submit" class="btn btn-classic py-3">Procéder au paiement</button>
                                <span class="line"></span>
                            </div>
                            <small class="d-block text-center mt-2"><i class="bi bi-lock-fill me-2" aria-hidden="true"></i>Paiements 100%
                                sécurisés</small>
                        </form>
                    </div>
                <?php }
                ?>
            </div>
            <!-- ------------------------------------------------------------------------------------------------------------------------------ -->


        </section>

    </div>
</main>