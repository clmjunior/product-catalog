<?php

namespace app\controllers;

use app\controllers\Controller;
use app\helpers\ApiHelper;

class CategoryController extends Controller
{
    public function index()
    {
        session_start();

        self::view('categories');
    }

    public static function getCategories()
    {
        $url = ApiHelper::getApiHost().'/category/get_categories';

        if(isset($_SESSION['user_data']) && $_SESSION['user_data']['cliente_id'] > 0) {
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

    public static function getCategoryBySlug($slug)
    {
        $categories = self::getCategories();

        foreach($categories['nivel_abaixo'] as $category) {
            
            if(isset($category['nivel_abaixo']) && !empty($category['nivel_abaixo'])) {
                foreach($category['nivel_abaixo'] as $subCategory) {

                    $subCategoryMap[$subCategory['slug_categoria']] = $subCategory['id'];
                } 
            }

            $subCategoryMap[$category['slug_categoria']] = $category['id'];

        }

        if(array_key_exists($slug, $subCategoryMap)) {
            return $subCategoryMap[$slug]; 
        } 
        
        return null;

    }

    public static function getTopCategories()
    {
        $url = ApiHelper::getApiHost().'/category/get_top_categories';
    
        if(isset($_SESSION['user_data']) && $_SESSION['user_data']['cliente_id'] > 0) {
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
        $url = ApiHelper::getApiHost().'/category/get_showcase_categories';
    
        if(isset($_SESSION['user_data']) && $_SESSION['user_data']['cliente_id'] > 0) {
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