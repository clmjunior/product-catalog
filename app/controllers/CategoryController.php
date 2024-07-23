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
        
        return $categoriesArray;
    }

    public static function getTopCategories()
    {
        $url = 'https://totalcommerce-dev.ddns.net/api/category/get_top_categories';
    
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
            [
                "id" => "859",
                "categoria" => "Brinquedos",
                "slug_categoria" => "brinquedos",
                "url_banner" => "https://totalcommerce-dev.ddns.net/dados_empresa/imagens/categorias/banner_categoria_859.png",
                "url_icone" => "https://totalcommerce-dev.ddns.net/dados_empresa/imagens/categorias/icone_categoria_859.png",
                "flag_mostrar_texto_menu_topo" => "S",
                "total_produtos" => "79",
                "url_categoria" => "//brinquedos"
            ],
            [
                "id" => "804",
                "categoria" => "Camping",
                "slug_categoria" => "camping",
                "url_banner" => "https://totalcommerce-dev.ddns.net/dados_empresa/imagens/categorias/banner_categoria_804.png",
                "url_icone" => "https://totalcommerce-dev.ddns.net/dados_empresa/imagens/categorias/icone_categoria_804.png",
                "flag_mostrar_texto_menu_topo" => "S",
                "total_produtos" => "379",
                "url_categoria" => "//camping",
            ],
            [
                "id" => "1077",
                "categoria" => "Barracas para Camping",
                "slug_categoria" => "barracas-para-camping",
                "url_banner" => "https://totalcommerce-dev.ddns.net/dados_empresa/imagens/categorias/banner_categoria_1077.png",
                "url_icone" => "",
                "flag_mostrar_texto_menu_topo" => "N",
                "total_produtos" => "40",
                "url_categoria" => "//barracas-para-camping",
            ],
            [
                "id" => "747",
                "categoria" => "Casa",
                "slug_categoria" => "casa",
                "url_banner" => "https://totalcommerce-dev.ddns.net/dados_empresa/imagens/categorias/banner_categoria_747.png",
                "url_icone" => "https://totalcommerce-dev.ddns.net/dados_empresa/imagens/categorias/icone_categoria_747.png",
                "flag_mostrar_texto_menu_topo" => "S",
                "total_produtos" => "731",
                "url_categoria" => "//casa",
            ],
            [
                "id" => "1081",
                "categoria" => "Culinária Oriental",
                "slug_categoria" => "culinaria-oriental",
                "url_banner" => "https://totalcommerce-dev.ddns.net/dados_empresa/imagens/categorias/categ_culinaria_oriental.png",
                "url_icone" => "https://totalcommerce-dev.ddns.net/dados_empresa/imagens/categorias/icone_categoria_1081.jpeg",
                "flag_mostrar_texto_menu_topo" => "S",
                "total_produtos" => "85",
                "url_categoria" => "//culinaria-oriental",
            ],
            [
                "id" => "321",
                "categoria" => "Maçaricos",
                "slug_categoria" => "macaricos",
                "url_banner" => "https://totalcommerce-dev.ddns.net/dados_empresa/imagens/categorias/categ_macarico.png",
                "url_icone" => "",
                "flag_mostrar_texto_menu_topo" => "N",
                "total_produtos" => "5",
                "url_categoria" => "//macaricos",
            ],
            [
                "id" => "1016",
                "categoria" => "Potes para Mantimentos",
                "slug_categoria" => "potes-para-mantimentos",
                "url_banner" => "https://totalcommerce-dev.ddns.net/dados_empresa/imagens/categorias/categ_pote_mantimento.png",
                "url_icone" => "",
                "flag_mostrar_texto_menu_topo" => "N",
                "total_produtos" => "26",
                "url_categoria" => "//potes-para-mantimentos",
            ],
            [
                "id" => "970",
                "categoria" => "Utensílios de Cozinha",
                "slug_categoria" => "utensilios-de-cozinha",
                "url_banner" => "https://totalcommerce-dev.ddns.net/dados_empresa/imagens/categorias/categ_ud.png",
                "url_icone" => "",
                "flag_mostrar_texto_menu_topo" => "N",
                "total_produtos" => "33",
                "url_categoria" => "//utensilios-de-cozinha",
            ],
        ];
       
        return $categoriesArray;
    }


}