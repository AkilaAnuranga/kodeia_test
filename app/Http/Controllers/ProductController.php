<?php

namespace App\Http\Controllers;

use App\Jobs\DownloadProductImage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    private $consumerKey;
    private $consumerSecret;

    private $storeUrl;

    public function sync_products()
    {
        // preferred way is to store keys in env
        $this->consumerKey = 'ck_547cc1e0c953c44c4744cd29466ad2ba65a658d6';
        $this->consumerSecret = 'cs_c8973040acc5d8f4c581d67d611f03d5b3eb733d';
        $this->storeUrl = 'https://tests.kodeia.com/wordpress/';

        try {
            $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
                ->get("{$this->storeUrl}/wp-json/wc/v3/products", [
                    'per_page' => 15,
                    'order' => 'asc',
                ]);

            if ($response->successful()) {
                $products = $response->json();
                foreach ($products as $product) {
                    $createdProduct = Product::updateOrCreate(
                        ['name' => $product['name']],
                        [
                            'price' => $product['price'],
                            'image_filename' => $product['images'][0]['src'] ?? null,
                            'description' => $product['description'],
                        ]
                    );


                    DownloadProductImage::dispatch($createdProduct);

                }

                //return response with 200 status if success
                return response()->json(array("message" => "Products have been synchronized."));



            } else {
                // if fails to connect with woocommerce return response with particular status code
                return response()->json(['error' => 'Unable to fetch products'], $response->status());
            }
        }catch (\Exception $ex){
            // if there is an error return with 500 status code
            return response()->json(['error' => 'Unable to fetch products server error'], 500);
        }
    }
}
