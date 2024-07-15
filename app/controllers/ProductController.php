<?php

namespace app\controllers;

use app\controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $this->view('products');
    }

    public function proccessCategoryItems()
    {
        $url = "https://totalcommerce-dev.ddns.net/api/product/get_product_by_category?category_id={$_POST['category_id']}";

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

        // Redireciona para a página de produtos
        header('Location: /produtos');
        exit;
    }

    public function showProductDetail()
    {
        $product_id = $_GET['id'];
        $product_id;

        $product = [
            "id" => 1,
            "name" => "Bola Feijao Liveup - 90x45cm - Liveup Sports",
            "img" => "https://www.liveupsports.com.br/dados_empresa/imagens/produtos/0350/8_3.jpg",
            "stock" => 122,
            "price" => 49.99,
            "categories" => "Home >> Bolas >> Bola Feijão",
            "details" => "Ideal tanto para exercícios de reabilitação quanto para atividades de condicionamento físico, pode ser usada individualmente ou em par no treinamento de diversos esportes. Os exercícios contribuem para o aumento da força, agilidade e velocidade.",
            "specifications" => [
                "SKU" => "8",
                "EAN" => "7898495110068",
                "Referência" => "LS3223 A1",
                "Marca" => "Liveup Sports",
                "Especificações" => [
                    "Fabricado em material PVC",
                    "Suporta até 200 kg",
                    "Acompanha bico reserva"
                ],
                "Medidas do produto" => "90cm x 45 cm de diâmetro",
                "Medidas do produto na embalagem" => [
                    "Comprimento" => "13 cm",
                    "Largura" => "24 cm",
                    "Altura" => "18 cm",
                    "Peso" => "1,546 Kg"
                ],
                "Dimensão com embalagem (aproximado)" => "13cm x 24cm x 18cm",
                "Peso com embalagem (aproximado)" => "1,55 Kg",
                "Garantia" => "90 Dias"
            ]
        ];
                
        $this->view('product_detail', ['product' => $product]);
    }

    public function showProducts()
    {
        session_start();
        $productsArray = $_SESSION['productsArray'] ?? [];

        $this->view('products', ['products' => $productsArray]);
    }
}