<?php

if (isset($_SESSION['user'])) {
    header('Location: /');
    exit();
}

/** @var \League\Plates\Template\Template $this */
use app\controllers\ConfigController;

$config = ConfigController::getConfig();

?>
<?php $this->layout('master', ['title' => 'Register', 'name' => 'register']) ?>

<div class="message-container">
    
<?php
    if (isset($error_msg) && !empty($error_msg)) {
        foreach(explode(";", $error_msg) as $msg) {
            echo "<div class='message-box bg-danger'>{$msg}</div>";
        } 
    }

    if (isset($success_msg) && !empty($success_msg)) {
        foreach(explode(";", $success_msg) as $msg) {
            echo "<div class='message-box bg-success'>{$msg}</div>";
        } 
    }
?>

</div>
<section class="register-container">
    <div class="container">
        <div class="register-form">
            <h2>Cadastro</h2>
            <form action="/register" method="post">
                <?php
                switch($config['metodo_login']) {
                    case "EMAIL":
                        $field = "CPF OU CNPJ";
                        break;
                    case "CNPJ_CPF":
                        $field = "CPF OU CNPJ";
                        break;
                    case "TODOS":
                        $field = "CPF OU CNPJ";
                        break;
                    case "CPF":
                        $field = "CPF";
                        break;
                    case "CNPJ":
                        $field = "CNPJ";
                        break;
                }
                ?>
                 <label for="document"><?= $field ?></label>
                <input type="text" id="document" name="document" value="<?= isset($data['customer_type']) && $data['customer_type'] == "F" ? $data['cpf'] : (isset($data['cnpj']) ? $data['cnpj'] : '') ?>" required>
                <div class="resp-wrap">
                    <small id="response-message" class="text-danger"></small>
                </div>

                <div class="cpf-data">
                    <label for="name">Nome:</label>
                    <input type="text" id="name" name="name" value="<?= isset($data['customer_name']) ? $data['customer_name'] : '' ?>">
                </div>

                <div class="cnpj-data">
                    <label for="corporate_name">Razão Social:</label>
                    <input type="text" id="corporate_name" name="corporate_name" value="<?= isset($data['corporate_name']) ? $data['corporate_name'] : '' ?>">
                    
                    <label for="trade_name">Nome Fantasia:</label>
                    <input type="text" id="trade_name" name="trade_name" value="<?= isset($data['trade_name']) ? $data['trade_name'] : '' ?>">
                    
                    <label for="state_registration">Inscrição Estadual:</label>
                    <input type="text" id="state_registration" name="state_registration" value="<?= isset($data['state_registration']) ? $data['state_registration'] : '' ?>">
                </div>
                
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?= isset($data['access_email']) ? $data['access_email'] : '' ?>" required>
                
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                
                <label for="confirm-password">Confirmar Senha:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>

                <div class="d-flex phone-group">
                    <div class="w-50">
                        <label for="ddd">Nome do Contato:</label>
                        <input type="text" id="cont-name" name="cont-name" value="<?= isset($data['contact']['contact_name']) ? $data['contact']['contact_name'] : '' ?>" required>
                    </div>
                    <div class="w-25">
                        <label for="ddd">DDD:</label>
                        <input type="text" id="ddd" name="ddd" value="<?= isset($data['contact']['phone_ddd']) ? $data['contact']['phone_ddd'] : '' ?>" required>
                    </div>
                    <div class="w-25">
                        <label for="phone">Telefone:</label>
                        <input type="number" id="phone" name="phone" value="<?= isset($data['contact']['phone_number']) ? $data['contact']['phone_number'] : '' ?>" required>
                    </div>
                </div>
<!-- 
                <div class="checkbox-input">
                    <input type="checkbox" name="receive" id="receive" <?= isset($data['receber_email']) && $data['receber_email'] == "on" ? "checked" : "" ?>>
                    <label for="receive"><small>Receber informações por E-mail</small></label>
                </div> -->
                
                <button class="register-button" type="submit">REGISTRAR</button>
                <div class="login-link-redirect">
                    <p><small>Já possui uma conta? <a href="/login">Entrar</a></small></p>
                </div>
            </form>
        </div>
    </div>
</section>
