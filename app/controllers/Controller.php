<?php

namespace app\controllers;

use League\Plates\Engine;
use app\helpers\ApiHelper;

abstract class Controller
{
    public static function view(string $view, array $data = [])
    {
        $pathViews = dirname(__FILE__, 3).DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."views";
        $templates = new Engine($pathViews);

        echo $templates->render($view, $data);
    }

    public static function getConfig() {

        $url = ApiHelper::getApiHost()."/config/get_config";

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
        $configArray = json_decode($response, true);
        
        return $configArray;
    }
}
