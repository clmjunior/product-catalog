<?php

namespace app\controllers;
use app\helpers\ApiHelper;
class UserController extends Controller
{
    public function indexLogin()
    {
        // session_start();

        self::view('login');
    }

    public function indexRegister()
    {
        // session_start();

        self::view('register');
    }
    
    public function authenticate()
    {
        // session_start();

        if(!isset($_POST['remember'])) {
            $_POST['remember'] = "off";
        }

        $data = [
            "login" => $_POST['login'],
            "password" => $_POST['password'],
            "remember" => $_POST['remember'],
        ];

        $url = 'https://totalcommerce-dev.ddns.net/api/user/authenticate_user';
        
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        $error = false;
        if(!empty(json_decode($response,true)['error'])) {
            $error = true;
        }

        $response = ApiHelper::responseMap($response);

        if ($response !== false) {
            if($error == false) {
                $_SESSION['user'] = true;
                return self::view('home', ['success_msg' => $response]);
            } else {
                return self::view('login', ['error_msg' => $response, 'data' => $data]);
            }
        } else {
            echo json_encode(array('error' => 'Não foi possível obter a resposta do endpoint.'));
        }
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
        // session_start();

        if(!isset($_POST['receive'])) {
            $_POST['receive'] = "off";
        }
        
        $data = [
            "customer_name" => $_POST['name'],
            "corporate_name" => $_POST['corporate_name'],
            "trade_name" => $_POST['trade_name'],
            "state_registration" => $_POST["state_registration"],
            "access_email" => $_POST['email'],
            "password" => $_POST['password'],
            "confirmed_password" => $_POST['confirm-password'],
            "receber_email" => $_POST['receive'],
            "contact" => [
                "contact_name" => $_POST['cont-name'],
                "phone_ddd" => $_POST['ddd'],
                "phone_number" => $_POST['phone'],
                "phone_extension" => ""
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

        $error = false;
        if(!empty(json_decode($response,true)['error'])) {
            $error = true;
        }

        $response = ApiHelper::responseMap($response);

        if ($response !== false) {
            if($error == false) {
                return self::view('home', ['success_msg' => $response]);
            } else {
                return self::view('register', ['error_msg' => $response, 'data' => $data]);
            }
        } else {
            echo json_encode(array('error' => 'Não foi possível obter a resposta do endpoint.'));
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /login");
        exit();
    }
}