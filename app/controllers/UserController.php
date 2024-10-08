<?php

namespace app\controllers;
use app\helpers\ApiHelper;
class UserController extends Controller
{
    public function indexPrivacy()
    {
        session_start();

        self::view('privacy');
    }

    public function indexLogin()
    {
        session_start();

        self::view('login');
    }

    public function indexRegister()
    {
        session_start();

        self::view('register');
    }

    public function indexTickets()
    {
        session_start();

        $tickets = self::getUserTickets($_SESSION['user_data']['documento']);

        self::view('tickets', ['tickets' => $tickets]);

    }

    public function indexOrders()
    {
        session_start();
        $document = preg_replace('/\D/', '', $_SESSION['user_data']['documento']); 
        $orders = self::getUserOrders($document);
        
        self::view('orders', ['orders' => $orders]);

    }


    private static function getUserOrders($document)
    {
        if (!$document) {
            return false;
        }

    
        $url = ApiHelper::getApiHost() . "/user/get_user_orders?document={$document}";
    
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
        
        return json_decode($response, true)['body'];
    }


    public function decodeFile()
    {
        if (isset($_POST['file']) && isset($_POST['id'])) {
            // Decodifica o conteúdo Base64 do arquivo XML
            $xmlContent = base64_decode($_POST['file']);
            
            // Define o nome do arquivo a ser salvo
            $fileName = "xml-{$_POST['id']}.xml";
        
            // Define os headers para forçar o download
            header('Content-Description: File Transfer');
            header('Content-Type: application/xml');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($xmlContent));
        
            // Envia o conteúdo do arquivo para download
            echo $xmlContent;

        } else {
            echo "Arquivo ou ID não fornecidos.";
            exit;
        }
    }



    private static function getUserTickets($document)
    {
        
        if (!$document) {
            return false;
        }

    
        $url = ApiHelper::getApiHost() . "/user/get_user_tickets?document={$document}";
    
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
        
        return json_decode($response, true)['body'];

    }
    
    public function authenticate()
    {
        session_start();

        if(!isset($_POST['remember'])) {
            $_POST['remember'] = "off";
        }

        $data = [
            "login" => $_POST['login'],
            "password" => $_POST['password'],
            "remember" => $_POST['remember'],
        ];

        $url = ApiHelper::getApiHost().'/user/authenticate_user';
        
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

        $res = ApiHelper::responseMap($response);

        if ($res !== false) {
            if($error == false) {
                $resArray = explode(";", $res);
                list($user_data, $msg) = $resArray;

                $_SESSION['user'] = true;
                $_SESSION['user_data'] = json_decode($user_data, true);
                
                 // self::view('home', ['success_msg' => $res]);
                 $_SESSION['success_msg'] = $msg;
                 header('Location: /');
                //  self::view('home', ['success_msg' => $res]);
            } else {
                self::view('login', ['error_msg' => $res, 'data' => $data]);
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

            $url = ApiHelper::getApiHost().'/user/check_user_registration';
            
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
        session_start();

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
            $data['trade_name'] = $data['customer_name'];  
        } else {
            echo "Parâmetro incorreto";
        }


        $url = ApiHelper::getApiHost().'/user/register_user';
        
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
                // self::view('home', ['success_msg' => $response]);
                $_SESSION['success_msg'] = $response;
                header('Location: /login');
            } else {
                self::view('register', ['error_msg' => $response, 'data' => $data]);
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