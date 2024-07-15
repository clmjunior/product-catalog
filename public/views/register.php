<?php
/** @var \League\Plates\Template\Template $this */
?>
<?php $this->layout('master', ['title' => 'Register', 'name' => 'register']) ?>
<section class="register-container">
    <div class="container">
        <div class="register-form">
            <h2>Cadastro</h2>
            <form action="/auth" method="post">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required>
                
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required>
                
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
