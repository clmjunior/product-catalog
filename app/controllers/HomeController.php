<?php

namespace app\controllers;

use app\controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        self::proccessHotItems();
        $productsArray = $_SESSION['productsArray'] ?? [];

        $this->view('home', ['products' => $productsArray]);

    }

    protected  function proccessHotItems()
    {
        // $url = "https://totalcommerce-dev.ddns.net/api/product/get_product_by_category?category_id={$_POST['category_id']}";

        // // Inicializa uma nova sessão cURL
        // $ch = curl_init();

        // // Define a URL para a requisição
        // curl_setopt($ch, CURLOPT_URL, $url);

        // // Define que a resposta deve ser retornada como string
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // // Faz a requisição
        // $response = curl_exec($ch);

        // // Verifica se ocorreu um erro
        // if (curl_errno($ch)) {
        //     echo 'Erro no cURL: ' . curl_error($ch);
        //     curl_close($ch);
        //     return null;
        // }

        // // Fecha a sessão cURL
        // curl_close($ch);

        // // Convertendo a resposta JSON em um array associativo
        // $productsArray = json_decode($response, true);
        
        // Dados de teste (se desejar manter)
        $productsArray = [
            [
                "id" => 1,
                "name" => "Bola Feijao Liveup - 90x45cm - Liveup Sports",
                "img" => "https://www.liveupsports.com.br/dados_empresa/imagens/produtos/0350/8_3.jpg",
            ],
            [
                "id" => 2,
                "name" => "Bola Feijao Liveup - 100x45cm - Liveup Sports",
                "img" => "https://www.liveupsports.com.br/dados_empresa/imagens/produtos/0350/9_1.jpg",
            ],
            [
                "id" => 3,
                "name" => "Bomba Manual para Inflar - 6 Polegadas - Liveup Sports",
                "img" => "https://www.liveupsports.com.br/dados_empresa/imagens/produtos/0350/14_02_bomba-manual-para-inflar-6-polegadas-liveup-sports.jpg",
            ],
            [
                "id" => 4,
                "name" => "Soft Ball - Mini Bola de Exercício - 1kg",
                "img" => "https://www.liveupsports.com.br/dados_empresa/imagens/produtos/0350/76_1.jpg",
            ],
            [
                "id" => 5,
                "name" => "Soft Ball - Mini Bola de Exercício - 2kg",
                "img" => "https://www.liveupsports.com.br/dados_empresa/imagens/produtos/0350/77_2.jpg",
            ],
            [
                "id" => 6,
                "name" => "Soft Ball - Mini Bola de Exercício - 3kg",
                "img" => "https://www.liveupsports.com.br/dados_empresa/imagens/produtos/0350/78_3.jpg",
            ],
            [
                "id" => 7,
                "name" => "Overball - 25cm Circunferencia. - Cor Laranja - Liveup Sports",
                "img" => "https://www.liveupsports.com.br/dados_empresa/imagens/produtos/0350/146_1.jpg",
            ],
        ];

        // Armazena os dados na sessão para acesso na página redirecionada
        session_start();
        $_SESSION['productsArray'] = $productsArray;

    }
}