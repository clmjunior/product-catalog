<?php

namespace app\controllers;

class UserController extends Controller
{
    public function indexLogin()
    {
        self::view('login');
    }

    public function indexRegister()
    {
        self::view('register');
    }
    
    public function authenticate()
    {

    }

    public function check()
    {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);

        if (isset($input['document'])) {
            $document = $input['document'];

            $url = 'https://totalcommerce-dev.ddns.net/api/user/check_user_registration';
            
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/json\r\n",
                    'method'  => 'POST',
                    'content' => json_encode(array('document' => $document)),
                ),
            );
            $context  = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            if ($response !== FALSE) {
                echo $response;
            } else {
                echo json_encode(array('error' => 'Não foi possível obter a resposta do endpoint.'));
            }
        } else {
            echo json_encode(array('error' => 'Parâmetro "document" não encontrado.'));
        }
    }

    public function register()
    {
        header('Content-Type: application/json');
        
        $data = [
            "customer_name" => $_POST['name'],
            "corporate_name" => $_POST['name'],
            "trade_name" => $_POST['name'],
            "state_registration" => "8",
            "access_email" => $_POST['email'],
            "password" => $_POST['password'],
            "confirmed_password" => $_POST['confirm-password'],
            "receber_email" => false,
            "customer_type" => "F",
            "contact" => [
                "contact_name" => "10",
                "phone_ddd" => "11",
                "phone_number" => "12154875",
                "phone_extension" => "13"
            ]           
        ];

        $document = preg_replace('/\D/', '', $_POST['document']); 
        if(strlen($document) == 14) {
            $data['cnpj'] = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $document);  
            $data['customer_type'] = "J";
        } else if(strlen($document) == 11) {
            $data['cpf'] = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $document);  
            $data['customer_type'] = "F";  
        } else {
            echo "Parâmetro incorreto";
        }

        $url = 'https://totalcommerce-dev.ddns.net/api/user/register_user';
        
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        if ($response !== FALSE) {
            echo $response;
        } else {
            echo json_encode(array('error' => 'Não foi possível obter a resposta do endpoint.'));
        }
    }
}