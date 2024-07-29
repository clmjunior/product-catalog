<?php
/** @var \League\Plates\Template\Template $this */
use app\controllers\CategoryController;
$topCategoriesArray = CategoryController::getTopCategories();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="../assets/css/master.css">
    <link rel="stylesheet" href="../assets/css/<?=$this->e($name)?>.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="../assets/js/master.js"></script>
    <script type="text/javascript" src="../assets/js/<?=$this->e($name)?>.js"></script>
    <title><?=$this->e($title)?></title>
</head>
<body>
    <nav class="navbar">
        <div class="nav-top">
            <img src="../assets/img/liveup-original-logo.png" class="nav-logo" alt="">
            
            <div class="nav-links">
                <a id="home" class="nav-link" href="/">HOME</a>
                <a id="company" class="nav-link" href="">EMPRESA</a>
                <a id="products" class="nav-link" href="/categorias">PRODUTOS</a>
                <a id="contact" class="nav-link" href="">CONTATO</a>
            </div>
            <div class="right-container">
                <div class="search-input">
                    <input type="text" name="searchbar" class="searchbar" />
                    <ion-icon class="search-icon" name="search"></ion-icon>
                </div>
                <div class="separator"></div>
                <button class="login-link">
                    <a href="/login">
                        <ion-icon name="log-in"></ion-icon> <p>Login</p>
                    </a>
                </button>
            </div>
            <ion-icon class="navbar-menu" name="menu"></ion-icon>
        </div>
        <div class="nav-bot">
            <?php foreach($topCategoriesArray as $topCategory): ?>
                <a href="/produtos?categoria=<?= $topCategory['id'] ?>">
                    <div class="categ-wrap">
                        <div class="categ-icon">
                            <img src="<?= $topCategory['url_icone'] ?>" class="icon-img" alt="">
                        </div>
                        <div class="categ-name">
                            <?= $topCategory['categoria'] ?>     
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>

    
    <?= $this->section('content') ?>

    <footer class="footer">
        <div class="footer-wrapper">
            <div>
                <img src="../assets/img/liveup-logo.png" alt="">
                <div class="company-info">
                    <h3 class="footer-company">PURYS IMPORTADORA E EXPORTADORA LTDA</h3>
                    <ul class="info-items">
                        <li class="info-item">CNPJ: 00.000.000/0000-00</li>
                        <li class="info-item">Localização: Rua Marcelino Jasinski, 1023 Tindiquera - Araucaria/PR</li>
                        <li class="info-item">CEP: 83708-132</li>
                        <li class="info-item">Tel: +55 (41) 3642-4011</li>
                        <li class="info-item">E-mail: adm1@purys.com.br</li>
                    </ul>
                </div>
            </div>
            <div class="contact-section">
                <form action="" class="company-contact">
                    <h4>Fale Conosco</h4>
                    <input placeholder="Nome" class="contact-input" type="text">
                    <input placeholder="E-mail" class="contact-input" type="text">
                    <input placeholder="Telefone" class="contact-input" type="text">
                    <textarea placeholder="Mensagem" class="message-input"></textarea>
                    <button class="contact-submit">Enviar</button>
                </form>
            </div>
        </div>
    </footer>
    
</body>
</html>
