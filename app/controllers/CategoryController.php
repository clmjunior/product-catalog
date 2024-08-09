<?php

namespace app\controllers;

use app\controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        session_start();

        self::view('categories');
    }

    public static function getCategories()
    {
        $url = 'https://totalcommerce-dev.ddns.net/api/category/get_categories';

        if($_SESSION['user_data']['cliente_id'] > 0) {
            $url .= "?client_id={$_SESSION['user_data']['cliente_id']}";
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
        $categoriesArray = json_decode($response, true);
       
        return $categoriesArray;
    }

    public static function getTopCategories()
    {
        $url = 'https://totalcommerce-dev.ddns.net/api/category/get_top_categories';
    
        if($_SESSION['user_data']['cliente_id'] > 0) {
            $url .= "?client_id={$_SESSION['user_data']['cliente_id']}";
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
        $categoriesArray = json_decode($response, true);

        return $categoriesArray;
    }

    public static function getShowcaseCategories()
    {
        $url = 'https://totalcommerce-dev.ddns.net/api/category/get_showcase_categories';
    
        if($_SESSION['user_data']['cliente_id'] > 0) {
            $url .= "?client_id={$_SESSION['user_data']['cliente_id']}";
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
        $categoriesArray = json_decode($response, true);
       
        return $categoriesArray;
    }


}