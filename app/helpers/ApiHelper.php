<?php

namespace app\helpers;

use Dotenv\Dotenv;


class ApiHelper
{

    public static function getApiHost()
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
        
        return $_ENV['API_HOST'];
    }

    public static function responseMap($response)
    {
        $map = [
            "Welcome" => "Usuário registrado com sucesso!",
            "Successfully logged in." => "Bem Vindo!",
            "User not found" => "Usuário não encontrado.",
            "Invalid email" => "Email inválido.",
            "User exists" => "Usuário existente.",
            "Password must be at least 4 characters long." => "A senha deve conter pelo menos 4 caracteres.",
            "The email is already in our database. Please use a different email or try logging in with your email, CPF, or CNPJ and password. If you forgot your password, use the 'forgot my password' option on the previous screen." => "O e-mail já está em nosso banco de dados. Por favor, use um e-mail diferente ou tente fazer login com seu e-mail, CPF, ou CNPJ e senha. Se você esqueceu sua senha, use a opção 'esqueci minha senha' na tela anterior.",
        ];

        $responseArray = json_decode($response, true);
        foreach($responseArray as $key => $value) {
            if($key == "error" || $key == "success") {
                if($value == "Successfully logged in.") {
                    $resp['user_data'] = json_encode($responseArray['user_data']);

                } 
                if(array_key_exists($value, $map)) {
                    $resp[] = $map[$value];
                }
            }
        }
        
        if(isset($resp)) {
            $response = implode(";",$resp);
        }

        return $response;
    }
}