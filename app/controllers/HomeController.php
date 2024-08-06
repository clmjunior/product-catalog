<?php

namespace app\controllers;

use app\controllers\Controller;
use app\controllers\CategoryController;

class HomeController extends Controller
{
    public function index()
    {
        session_start();

        $productsArray = self::proccessHotItems();

        self::view('home', ['products' => $productsArray]);

    }

    protected  function proccessHotItems()
    {

        $showcaseCategories = CategoryController::getShowcaseCategories();
        
        foreach($showcaseCategories as $showcaseCategory) {
            
            $url = "https://totalcommerce-dev.ddns.net/api/product/get_home_products?limit=10&category_id={$showcaseCategory['id']}&order=frequencia_venda";

            // Inicializa uma nova sessão cURL
            $ch = curl_init();

            // Define a URL para a requisição
            curl_setopt($ch, CURLOPT_URL, $url);

            // Define que a resposta deve ser retornada como string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            // Faz a requisição
            $response = curl_exec($ch);

            // Verifica se ocorreu um erro
            if (curl_errno($ch)) {
                echo 'Erro no cURL: ' . curl_error($ch);
                curl_close($ch);
                return null;
            }

            // Fecha a sessão cURL
            curl_close($ch);

            // Convertendo a resposta JSON em um array associativo
            $productsArray = json_decode($response, true);
            if(isset($productsArray['filtro']['categorias'][0]['categoria'])) {
                $data[$productsArray['filtro']['categorias'][0]['categoria']] = [
                    "items" => $productsArray['itens']
                ];
            }
        }

        return $data;
    }
}