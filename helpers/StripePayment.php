<?php


use Stripe\Checkout\Session;
use Stripe\Stripe;

// Carte de test Stripe 4242 4242 4242 4242

class StripePayment
{

    public function __construct(readonly private string $clientSecret)
    {
        Stripe::setApiKey($this->clientSecret);
        Stripe::setApiVersion('2023-10-16');
    }


    public function startPayment(int $price)
    {
        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Carte cadeau',
                    ],
                    'unit_amount' => $price *100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://laura-naturelle.test/controllers/gift_card_controller.php?status=1',
            'cancel_url' => 'http://laura-naturelle.test/controllers/gift_card_controller.php?status=0',
            'billing_address_collection' => 'required',
            'shipping_address_collection' => [
                'allowed_countries' => ['FR']
            ]
        ]);

        header("HTTP/1.1 303 See Other");
        header("Location: " . $session->url);
    }
}
