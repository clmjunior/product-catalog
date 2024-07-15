<?php
/** @var \League\Plates\Template\Template $this */
?>
<?php $this->layout('master', ['title' => 'Login', 'name' => 'login']) ?>
<section class="login-container">
    <div class="container">
        <div class="login-form">
            <h2>Login</h2>
            <div class="google-auth">
                <p>Entre com o Google</p>
                <ion-icon class="logo-google" name="logo-google"></ion-icon>
            </div>
            <div class="divider">
                <div class="separator"></div>
                <p>OU</p>
                <div class="separator"></div>
            </div>
            <form action="/auth" method="post">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>
                
                <div class="password-wrap">
                    <label for="password">Senha:</label>
                    <input type="password" id="password" name="password" required>
                    <a href="#">Esqueci minha senha</a>
                </div>

                <div class="checkbox-input">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember"><small>Mantenha-me conectado</small></label>
                </div>
                
                <button class="login-button" type="submit">LOGIN</button>
                <div class="register-link">
                    <p><small>Ainda não possui uma conta? <a href="/cadastro">Registre-se</a></small></p>
                </div>
            </form>
        </div>
    </div>
</section>