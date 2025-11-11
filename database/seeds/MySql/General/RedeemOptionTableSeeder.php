<?php

use Illuminate\Database\Seeder;

class RedeemOptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            'US' => array(
                "Amazon.com-Gift-Card.png" =>  array("Amazon.com Gift Card","giftcard"),
                "Panera-Gift-Card.png" =>  array("Panera Gift Card","giftcard"),
                "iTunes-Gift-Card.png" =>  array("iTunes Gift Card","giftcard"),
                "target-1.png" =>  array("Target Gift Card","giftcard"),
                "hulu.png" =>  array("Hulu Gift Subscription","giftcard"),
                "googleplay.png" =>  array("Google Play Gift Card","giftcard"),
                "macys.png" =>  array("Macy's Gift Card","giftcard"),
                "bestbuy.png" =>  array("Best Buy Gift Card","giftcard"),
                "regal-cinema-e-gift-card.png" =>  array("Regal Cinema Gift Card","giftcard"),
                "staples-e-gift-card.png" =>  array("Staples Gift Card","giftcard"),
                "sephora-gift-card.png" =>  array("Sephora Gift Card","giftcard"),
                "nike-gift-card.png" =>  array("Nike Gift Card","giftcard"),
                "amc-theaters-gift-card.png" =>  array("AMC Theaters Gift Card","giftcard"),
                "nordstrom-gift-card.png" =>  array("Nordstrom Gift Card","giftcard"),
                "pottery-barn-gift-card.png" =>  array("Pottery Barn Gift Card","giftcard"),
                "nfl-shop-gift-card.png" =>  array("NFL Shop Gift Card","giftcard"),
                "barnes-and-noble-gift-card.png" =>  array("Barnes & Noble Gift Card","giftcard"),
                "hotels.com-gift-card.png" =>  array("Hotels.com Gift Card","giftcard"),
                "Uber.png" =>  array("Uber Gift Card","giftcard"),
                "Under-Armour.png" =>  array("Under Amour Gift Card","giftcard"),
                "Whole-Foods.png" =>  array("Whole Foods Gift Card","giftcard"),
                "Walmart.png" =>  array("Walmart Gift Card","giftcard"),
                "Home-Depot.png" =>  array("Home Depot Gift Card","giftcard"),
                "Lowes.png" =>  array("Lowe's Gift Card","giftcard"),
                "dominos-1.png" =>  array("Domino's Gift Card","giftcard"),
                "American-Cancer-Society.png" =>  array("Habitat For Humanity Donation","charity"),
                "Clean-Water-Fund.png" =>  array("American Cancer Society Donation","charity"),
                "hfh-1.png" =>  array("National Park Foundation Donation","charity"),
                "National-Park-Foundation.png" =>  array("Clean Water Fund Donation","charity"),
            ),
            'CA' => array(
                "Amazon.ca-Gift-Card.png" =>  array("Amazon.ca Gift Card","giftcard"),
                "itunes_ca.png" =>  array("iTunes Canada Gift Card","giftcard"),
                "brass_pro.png" =>  array("Bass Pro Shops Canada Gift Card","giftcard"),
                "best_buy.png" =>  array("Best Buy Canada Gift Card","giftcard"),
                "boston.png" =>  array("Boston Pizza Canada Gift Card","giftcard"),
                "roots.png" =>  array("Roots Canada Gift Card","giftcard"),
            ),
            'UK' => array(
                "Amazon-co-uk.png" =>  array("Amazon.uk Gift Card","giftcard"),
                "itune_aus.png" =>  array("iTunes UK Gift Card","giftcard"),
                "argos.png" =>  array("Argos UK Gift Card","giftcard"),
                "tesco.png" =>  array("Tesco UK Gift Card","giftcard"),
                "uber.png" =>  array("Uber UK Gift Card","giftcard"),
            ),
            'DE' => array(
                "amazon_ge.png" =>  array("Amazon.de Gift card","giftcard"),
                "itune_aus(1).png" =>  array("iTunes Germany Gift Card","giftcard"),
            ),
            'FR' => array(
                "Amazon.fr_.png" =>  array("Amazon.fr Gift Card","giftcard"),
                "itune_aus.png" =>  array("iTunes France Gift Card","giftcard"),
            ),
            'ES' => array(
                "Amazon.es_.png" =>  array("Amazon.es Gift Card","giftcard"),
                "itune_aus.png" =>  array("iTunes Spain Gift Card","giftcard"),
            ),
            'IT' => array(
                "Amazon.it_.png" =>  array("Amazon.it Gift Card","giftcard"),
                "itune_aus.png" =>  array("iTunes Italy Gift Card","giftcard"),
            ),
            'IN' => array(
                "AmazonIndia-1.png" =>  array("Amazon.in Gift Card","giftcard"),
                "big-baazar.png" =>  array("Big Bazaar Gift Card","giftcard"),
                "shoppersstop.png" =>  array("Shoppers Stop Gift Card","giftcard"),
                "croma.png" =>  array("Croma Gift Card","giftcard"),
                "book-my-show.png" =>  array("Book My Show Gift Card","giftcard"),
                "pantaloons.png" =>  array("Pantaloons Gift Card","giftcard"),
            ),
            'AU' => array(
                "itune_aus.png" =>  array("iTunes Australia Gift Card","giftcard"),
                "coles.png" =>  array("Coles Australia Gift Card","giftcard"),
                "b033627-1200w-326ppi.png" =>  array("David Jones Australia Gift Card","giftcard"),
                "b449047-1200w-326ppi.png" =>  array("JB Hi-Fi Australia Gift Card","giftcard"),
                "b998736-1200w-326ppi.png" =>  array("Myer Australia Gift Card","giftcard"),
            ),
            'CN' => array(
                "Amazon.cn-Gift-Card.png" =>  array("Amazon.cn Gift Card","giftcard"),
            ),
            'JP' => array(
                "Amazon.jp-Gift-Card.png" =>  array("Amazon.cn Gift Card","giftcard"),
            ),

        );
        foreach ($data as $country_code => $giftcard_options) {
            $countryData = \App\Models\CountryTrans::where('country_code', '=', $country_code)->first();
            /*$countryTranslated = $countryData->translate(App::getLocale());*/
            if ($countryData) {
                foreach($giftcard_options as $image => $option){
                    $row = array(
                        'name' => $option[0],
                        'display_name' => $option[0],
                        'code' => $option[0],
                        'image_uri' => $image,
                        'country_display_name' => $countryData['country_name'],
                        'country_code' => $countryData['country_code'],
                        /*'country_id' => $countryData['_id'],*/
                        'type' => $option[1],
                    );
                    \App\Models\RedeemOption::create($row);
                }
            }

        }
    }
}
