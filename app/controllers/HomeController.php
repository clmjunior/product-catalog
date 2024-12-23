<?php

namespace app\controllers;

use app\controllers\Controller;
use app\controllers\CategoryController;
use app\helpers\ApiHelper;

class HomeController extends Controller
{
    public function index()
    {
        session_start();

        $productsArray = self::proccessHotItems();
        $partnersArray = self::getPartners();

        self::view('home', ['products' => $productsArray, 'partners' => $partnersArray]);

    }

    protected function getPartners()
    {
            
        $url = ApiHelper::getApiHost()."/config/get_partners";

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
        $data = json_decode($response, true);
            

        return $data;
    }

    protected  function proccessHotItems()
    {

        $showcaseCategories = CategoryController::getShowcaseCategories();
        
        foreach($showcaseCategories as $showcaseCategory) {
            
            $url = ApiHelper::getApiHost()."/product/get_home_products?limit=10&category_id={$showcaseCategory['id']}&order=titulo_produto&order_type=asc";

            if(isset($_SESSION['user_data']) && $_SESSION['user_data']['cliente_id'] > 0) {
                $url .= "&client_id={$_SESSION['user_data']['cliente_id']}";
            }
            
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
                    "category_banner" => $showcaseCategory['banner_categoria'],
                    "items" => $productsArray['itens']
                ];
            }
        }

        return $data;
    }
}