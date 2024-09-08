<?php

if (isset($_SESSION['user'])) {
    header('Location: /');
    exit();
}

/** @var \League\Plates\Template\Template $this */
use app\controllers\ConfigController;

$config = ConfigController::getConfig();
?>
<?php $this->layout('master', ['title' => 'Login', 'name' => 'login']) ?>

<div class="message-container">
    
<?php
    if (isset($error_msg) && !empty($error_msg)) {
        foreach(explode(";", $error_msg) as $msg) {
            echo "<div class='message-box bg-danger'>{$msg}</div>";
        } 
    }

    if (isset($success_msg) && !empty($success_msg) || isset($_SESSION['success_msg'])) {
        if(isset($_SESSION['success_msg'])) {
            $success_msg = $_SESSION['success_msg'];
        }
        foreach(explode(";", $success_msg) as $msg) {
            echo "<div class='message-box bg-success'>{$msg}</div>";
        } 
        unset($_SESSION['success_msg']);
    }
?>

</div>
<section class="login-container">
    <div class="container">
        <div class="login-form">
            <h2>Login</h2>
            <!-- <div class="google-auth">
                <p>Entre com o Google</p>
                <ion-icon class="logo-google" name="logo-google"></ion-icon>
            </div>
            <div class="divider">
                <div class="separator"></div>
                <p>OU</p>
                <div class="separator"></div>
            </div> -->
            <form action="/auth" method="post">
                <?php
                switch($config['metodo_login']) {
                    case "EMAIL":
                        $field = "EMAIL";
                        break;
                    case "CNPJ_CPF":
                        $field = "CPF OU CNPJ";
                        break;
                    case "TODOS":
                        $field = "CPF, CNPJ OU EMAIL";
                        break;
                    case "CPF":
                        $field = "CPF";
                        break;
                    case "CNPJ":
                        $field = "CNPJ";
                        break;
                }
                ?>
                <label for="login"><?= $field ?></label>
                <input type="text" id="login" name="login" value="<?= isset($data['login']) ? $data['login'] : '' ?>" required>
                
                <div class="password-wrap">
                    <label for="password">Senha:</label>
                    <input type="password" id="password" name="password" required>
                    <!-- <a href="#">Esqueci minha senha</a> -->
                </div>

                <div class="checkbox-input">
                    <input type="checkbox" name="remember" id="remember" <?= isset($data['remember']) && $data['remember'] == "on" ? "checked" : "" ?>>
                    <!-- <label for="remember"><small>Mantenha-me conectado</small></label> -->
                </div>
                
                <button class="login-button" type="submit">LOGIN</button>
                <div class="register-link">
                    <p><small>Ainda não possui uma conta? <a href="/cadastro">Registre-se</a></small></p>
                </div>
            </form>
        </div>
    </div>
</section>