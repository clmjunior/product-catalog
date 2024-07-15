<?php

namespace app\controllers;

use app\controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $this->view('categories');
    }

    public static function getCategories()
    {
        $url = 'https://totalcommerce-dev.ddns.net/api/category/get_categories';
    
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


        $categoriesArray = [
            1 => "Bolas",
            2 => "Yoga",
            3 => "Camping",
            4 => "Corpo",
            5 => "Saúde",
            6 => "Halteres",
            7 => "Halteres",
            8 => "Fisioterapia",
            9 => "Fitness",
            10 => "Funcional",
        ];
        
        return $categoriesArray;
    }
}