<?php
/** @var \League\Plates\Template\Template $this */
use app\controllers\ConfigController;

$config = ConfigController::getConfig();
?>
<?php $this->layout('master', ['title' => 'Register', 'name' => 'register']) ?>
<section class="register-container">
    <div class="container">
        <div class="register-form">
            <h2>Cadastro</h2>
            <form action="/register" method="post">
                <?php
                switch($config['metodo_login']) {
                    case "EMAIL":
                        $field = "EMAIL";
                        break;
                    case "CPF_CNPJ":
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
                <input type="text" id="document" name="document" required>
                <div class="resp-wrap">
                    <small id="response-message" class="text-danger"></small>
                </div>

                <div class="cpf-data">
                    <label for="name">Nome:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="cnpj-data">
                    <label for="corporate_name">Razão Social:</label>
                    <input type="text" id="corporate_name" name="corporate_name" required>
                    
                    <label for="trade_name">Nome Fantasia:</label>
                    <input type="text" id="trade_name" name="trade_name" required>
                    
                    <label for="state_registration">Inscrição Estadual:</label>
                    <input type="text" id="state_registration" name="state_registration" required>
                </div>
                
                <div class="d-flex phone-group">
                    <div class="w-25">
                        <label for="ddd">DDD:</label>
                        <input type="text" id="ddd" name="ddd" required>
                    </div>
                    <div class="w-75">
                        <label for="phone">Telefone:</label>
                        <input type="text" id="phone" name="phone" required>
                    </div>
                </div>
                
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>
                
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                
                <label for="confirm-password">Confirmar Senha:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
                
                <button class="register-button" type="submit">REGISTRAR</button>
                <div class="login-link-redirect">
                    <p><small>Já possui uma conta? <a href="/login">Entrar</a></small></p>
                </div>
            </form>
        </div>
    </div>
</section>
