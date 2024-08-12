<?php

namespace app\controllers;

use app\controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        session_start();

        self::view('products');
    }

    public function showProductDetail()
    {
        session_start();

        $product_id = $_GET['id'];
        $product_id;

        $url = "https://totalcommerce-dev.ddns.net/api/product/get_product_by_id?sku={$product_id}";

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

        $url = "https://totalcommerce-dev.ddns.net/api/product/search?term={$_GET['search']}&limit=24&offset={$pagina}";

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
            $pages['url'] = str_replace('http://totalcommerce-dev.ddns.net/api/product/search?p_atual=', "/pesquisar?search={$_GET['search']}&pagina=", $pages['url']);
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

    public function showProducts()
    {
        session_start();

        if(!isset($_GET['pagina'])) {
            $pagina = '1';
        } else {
            $pagina = $_GET['pagina'];
        }

        $url = "https://totalcommerce-dev.ddns.net/api/product/get_products_by_category?category_id={$_GET['categoria']}&limit=24&offset={$pagina}";

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
            $pages['url'] = str_replace('http://totalcommerce-dev.ddns.net/api/product/get_products_by_category?p_atual=', "/produtos?categoria={$_GET['categoria']}&pagina=", $pages['url']);
            $pages['atual'] = $pagina;
        }
        $productsArray['paginacao']['url_primeira_pagina'] = "/produtos?categoria={$_GET['categoria']}";
        $prev = $pagina - 1 <= 0 ? 1 : $pagina - 1;
        $productsArray['paginacao']['url_pagina_anterior'] = "/produtos?categoria={$_GET['categoria']}&pagina={$prev}";

        $productsArray['paginacao']['url_ultima_pagina'] = "/produtos?categoria={$_GET['categoria']}&pagina={$productsArray['paginacao']['paginas']}";

        $next = $pagina + 1;
        $nextPageUrl = $next >= $productsArray['paginacao']['paginas'] ? $productsArray['paginacao']['url_ultima_pagina'] : "/produtos?categoria={$_GET['categoria']}&pagina={$next}";

        $productsArray['paginacao']['url_proxima_pagina'] = $nextPageUrl;
        
        
        self::view('products', ['products' => $productsArray]);
    }
}