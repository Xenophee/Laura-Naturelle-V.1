<main>
    <div class="container-fluid px-0">
        <section class="pb-5">
            <h1 class="text-center pt-5 pb-lg-5 mt-md-5">Mentions légales</h1>


            <div class="row justify-content-evenly mx-0 py-md-5 mt-5">

                <div class="col-12 col-md-5 col-4 d-flex flex-column justify-content-center align-items-center">
                    <h2 class="notice-title text-center mb-4">Identité de l'entreprise</h2>
                    <ul>
                        <li class="my-3"><span class="bold">Nom de l'entreprise :</span> L' Aura Natur'elle (AE)</li>
                        <li class="my-3"><span class="bold">Nom & Prénom de l'artisan :</span> Sandrine Dassonville</li>
                        <li class="my-3"><span class="bold">Adresse :</span> <?= $artisan->address ?> <?= $artisan->zipcode . ' ' . $artisan->city ?></li>
                        <li class="my-3"><span class="bold">Mail :</span> <?= $artisan->email ?></li>
                        <li class="my-3"><span class="bold">Téléphone :</span> <?= $artisan->phone ?></li>
                        <li class="my-3"><span class="bold">Numéro SIRET :</span> 84942902200015</li>
                        <li class="my-3"><span class="bold">N° TVA :</span> FR78849429022</li>
                    </ul>
                </div>

                <div class="col-12 col-md-5 col-4 d-flex flex-column align-items-center mt-4 mt-md-0">
                    <h2 class="notice-title text-center mb-4">Identité de l'hébergeur</h2>
                    <ul>
                        <li class="my-3"><span class="bold">Nom de l'entreprise :</span> 000webhost.com</li>
                        <li class="my-3"><span class="bold">Adresse :</span> 61 Lordou Vironos Street 6023 Larnaca, Cyprus</li>
                        <li class="my-3"><span class="bold">Email :</span> contact@000webhost.com</li>
                    </ul>
                </div>

            </div>
        </section>

    </div>
</main>