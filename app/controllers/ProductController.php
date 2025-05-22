<?php

namespace app\controllers;

use app\controllers\Controller;
use app\controllers\CategoryController;
use app\helpers\ApiHelper;

class ProductController extends Controller
{
    public function index()
    {
        session_start();

        self::view('products');
    }

    public function showProductDetail($slug, $id)
    {
        session_start();
        
        $product_id = $id;

        // Monta a URL para a API com o id do produto
        $url = ApiHelper::getApiHost() . "/product/get_product_by_id?sku={$product_id}";

        if (isset($_SESSION['user_data']) && $_SESSION['user_data']['cliente_id'] > 0) {
            $url .= "&client_id={$_SESSION['user_data']['cliente_id']}";
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        // Verifica se ocorreu um erro
        if (curl_errno($ch)) {
            echo 'Erro no cURL: ' . curl_error($ch);
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        $product = json_decode($response, true);
        $product['especificacoes_produto'] = $this->formatSpecifications($product['especificacoes_produto']);
                
        self::view('product_detail', ['product' => $product]);
    }


    private function formatSpecifications($specString)
    {
        $specs = explode('<br><br>', $specString);
        $formatted = [];

        foreach ($specs as $spec) {
            $lines = explode('<br>', $spec);
            $category = array_shift($lines);
            $formatted[$category] = [];

            foreach ($lines as $line) {
                $line = trim($line, ': ');
                $formatted[$category][] = $line;
            }
        }

        return $formatted;
    }

    public function searchItems()
    {

        session_start();

        if(!isset($_GET['pagina'])) {
            $pagina = '1';
        } else {
            $pagina = $_GET['pagina'];
        }

        if(!isset($_GET['search'])) {
            echo "Error";
        } 

        // $_GET['search'] = urlencode($_GET['search']);
        $_GET['search'] = str_replace(' ', '%20', $_GET['search']);
        $reqSearch = utf8_decode($_GET['search']);
        
        $url = ApiHelper::getApiHost()."/product/search?term={$reqSearch}&limit=24&offset={$pagina}";
       
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


        foreach($productsArray['paginacao']['navegacao'] as &$pages) {
            if (strpos($pages['url'], 'https://') === false) {
                $pages['url'] = str_replace('http://', 'https://', $pages['url']);
            }

            if($pages['numero'] == 1) {

                $pages['url'] = str_replace(ApiHelper::getApiHost().'/product/search', "/pesquisar?search={$_GET['search']}", $pages['url']);
            
            } else {
                $pages['url'] = str_replace(ApiHelper::getApiHost().'/product/search?p_atual=', "/pesquisar?search={$_GET['search']}&pagina=", $pages['url']);
            }

            $pages['atual'] = $pagina;
        }
        
        $productsArray['paginacao']['url_primeira_pagina'] = "/pesquisar?search={$_GET['search']}";
        $prev = $pagina - 1 <= 0 ? 1 : $pagina - 1;
        $productsArray['paginacao']['url_pagina_anterior'] = "/pesquisar?search={$_GET['search']}&pagina={$prev}";

        $productsArray['paginacao']['url_ultima_pagina'] = "/pesquisar?search={$_GET['search']}&pagina={$productsArray['paginacao']['paginas']}";

        $next = $pagina + 1;
        $nextPageUrl = $next >= $productsArray['paginacao']['paginas'] ? $productsArray['paginacao']['url_ultima_pagina'] : "/produtos?search={$_GET['search']}&pagina={$next}";

        $productsArray['paginacao']['url_proxima_pagina'] = $nextPageUrl;
        
        
        self::view('products', ['products' => $productsArray]);
    }

    public function showProductsByCategory($category_slug)
    {
        session_start();

        $category_id = CategoryController::getCategoryBySlug($category_slug);

        if($category_id <= 0) {
            return null;
        }


        if(!isset($_GET['pagina'])) {
            $pagina = '1';
        } else {
            $pagina = $_GET['pagina'];
        }


        $url = ApiHelper::getApiHost()."/product/get_products_by_category?category_id={$category_id}&&order=titulo_produto&order_type=asc&limit=24&offset={$pagina}";

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

        foreach($productsArray['paginacao']['navegacao'] as &$pages) {

            if($pages['numero'] == 1) {

                if (strpos($pages['url'], 'https://') === false) {
                    $pages['url'] = str_replace('http://', 'https://', $pages['url']);
                }
                $pages['url'] = str_replace(ApiHelper::getApiHost().'/product/get_products_by_category', "/{$category_slug}", $pages['url']);
            } else {
                
                if (strpos($pages['url'], 'https://') === false) {
                    $pages['url'] = str_replace('http://', 'https://', $pages['url']);
                }
                $pages['url'] = str_replace(ApiHelper::getApiHost().'/product/get_products_by_category?p_atual=', "/{$category_slug}?pagina=", $pages['url']);

            }

            $pages['atual'] = $pagina;
        }
        
        $productsArray['paginacao']['url_primeira_pagina'] = "/{$category_slug}";
        $prev = $pagina - 1 <= 0 ? 1 : $pagina - 1;
        $productsArray['paginacao']['url_pagina_anterior'] = "/{$category_slug}?pagina={$prev}";

        $productsArray['paginacao']['url_ultima_pagina'] = "/{$category_slug}?pagina={$productsArray['paginacao']['paginas']}";

        $next = $pagina + 1;
        $nextPageUrl = $next >= $productsArray['paginacao']['paginas'] ? $productsArray['paginacao']['url_ultima_pagina'] : "/{$category_slug}?pagina={$next}";

        $productsArray['paginacao']['url_proxima_pagina'] = $nextPageUrl;
        
        
        self::view('products', ['products' => $productsArray]);
    }


    public function showAllProducts()
    {
        session_start();


        if(!isset($_GET['pagina'])) {
            $pagina = '1';
        } else {
            $pagina = $_GET['pagina'];
        }


        $url = ApiHelper::getApiHost()."/product/get_products_by_category?limit=24&order=titulo_produto&order_type=asc&offset={$pagina}";

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

        foreach($productsArray['paginacao']['navegacao'] as &$pages) {

            if($pages['numero'] == 1) {

                if (strpos($pages['url'], 'https://') === false) {
                    $pages['url'] = str_replace('http://', 'https://', $pages['url']);
                }
                $pages['url'] = str_replace(ApiHelper::getApiHost().'/product/get_products_by_category', "/produtos", $pages['url']);
            } else {
                
                if (strpos($pages['url'], 'https://') === false) {
                    $pages['url'] = str_replace('http://', 'https://', $pages['url']);
                }
                $pages['url'] = str_replace(ApiHelper::getApiHost().'/product/get_products_by_category?p_atual=', "/produtos?pagina=", $pages['url']);

            }

            $pages['atual'] = $pagina;
        }
        
        $productsArray['paginacao']['url_primeira_pagina'] = "/produtos";
        $prev = $pagina - 1 <= 0 ? 1 : $pagina - 1;
        $productsArray['paginacao']['url_pagina_anterior'] = "/produtos?pagina={$prev}";

        $productsArray['paginacao']['url_ultima_pagina'] = "/produtos?pagina={$productsArray['paginacao']['paginas']}";

        $next = $pagina + 1;
        $nextPageUrl = $next >= $productsArray['paginacao']['paginas'] ? $productsArray['paginacao']['url_ultima_pagina'] : "/produtos?pagina={$next}";

        $productsArray['paginacao']['url_proxima_pagina'] = $nextPageUrl;
        
        
        self::view('products', ['products' => $productsArray]);
    }
}