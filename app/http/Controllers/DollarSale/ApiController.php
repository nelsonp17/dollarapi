<?php

namespace App\Http\Controllers\DollarSale;

use Goutte\Client;
use Carbon\Carbon;

class ApiController extends DatabaseController{
    public $client = null;
    public $urlScrapping = "https://monitordolarvenezuela.com/";
    public $urlVercel = "https://dollar-frontend-api.vercel.app/";
    public $priceVercel = [];

    public function __construct()
    {
        $this->client = new Client();
        parent::__construct(); // Llama al constructor de la clase padre para establecer la conexión a la base de datos
    }
    public function run()
    {
        // Hacer una solicitud HTTP GET a la página
        $crawler = $this->client->request('GET', $this->urlScrapping);

        // Seleccionar los elementos HTML que coincidan con el selector "#promedios .row div.col-lg-2 div"
        $elements = $crawler->filter('#promedios .row div.col-lg-2 div');

        // Recorrer los elementos seleccionados y acceder a sus propiedades
        $elements->each(function ($element) {
            $imgTitle = $element->filter('img')->attr('alt');
            $srcTitle = $element->filter('img')->attr('src');
            $title = $element->filter('h4.title-prome')->text();
            $update = $element->filter('small')->text();
            $price = $element->filter('p')->text();

            // Realizar las operaciones necesarias con las propiedades obtenidas
            // ...

            // Ejemplo de impresión de los valores obtenidos
            echo "imgTitle: " . $imgTitle . "\n";
            echo "srcTitle: " . $srcTitle . "\n";
            echo "title: " . $title . "\n";
            echo "update: " . $update . "\n";
            echo "price: " . $price . "\n";
        });

        echo "finalizo";

    }

    public function vercel()
    {
        // Hacer una solicitud HTTP GET a la página
        $crawler = $this->client->request('GET', $this->urlVercel);

        // Seleccionar los elementos HTML que coincidan con el selector "#promedios .row div.col-lg-2 div"
        $elements = $crawler->filter('.dolar-card');

        // Recorrer los elementos seleccionados y acceder a sus propiedades
        $elements->each(function ($element) {
            //$imgTitle = $element->filter('img')->attr('alt');
            //$srcTitle = $element->filter('img')->attr('src');
            //$title = $element->filter('h4.title-prome')->text();
            //$update = $element->filter('small')->text();
            //$price = $element->filter('p')->text();

            $price = $element->filter('.dolar-price')->text();
            $origin = $element->filter('.dolar-origin')->text();
            $cadena = str_replace(',', '.', $price);
            $numero = floatval($cadena);
            $this->priceVercel[] = [
                'name' => $origin,
                'price' => $price,
                "price_number" => floatval($numero),
                'updated_at' => Carbon::now()->format('Y-m-d h:i:s'),
            ];
        });

        //echo "finalizo 2";
        $this->jsonResponse($this->priceVercel);

    }
}