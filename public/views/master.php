<?php

/** @var \League\Plates\Template\Template $this */
use app\controllers\CategoryController;
use app\controllers\ConfigController;

$topCategoriesArray = CategoryController::getTopCategories();
$categoriesArray = CategoryController::getCategories();
$config = ConfigController::getConfig();

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
    
    <link rel="icon" type="image/x-icon" href="<?=$config['favicon_url']?>">
    <title><?=$this->e($title)?></title>
</head>
<body>
    <nav class="navbar">
        <div class="nav-top">
            <a href="/">
                <img src="<?=$config['empresa_logomarca']?>" class="nav-logo" alt="">
            </a>
            
            <div class="right-container">
                <form action="/pesquisar" method="get">
                    <div class="search-input">
                        <input type="text" name="search" class="searchbar" />
                        <ion-icon class="search-icon" name="search"></ion-icon>
                    </div>
                </form>
                <div class="separator"></div>

                <?php if(!isset($_SESSION['user'])): ?>
                    <a href="/login">
                        <button class="login-link">
                            <ion-icon name="log-in"></ion-icon> <p>Login</p>
                        </button>
                    </a>
                    <?php else: ?>
                        <div class="dropdown account">
                            <a class="nav-link dropdown-toggle" id="dropdownMenuButton">
                                <ion-icon name="person-circle"></ion-icon> <p>Conta</p>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/boletos">Meus Boletos</a>
                                <a class="dropdown-item text-danger" href="/logout"><ion-icon name="log-out"></ion-icon> Sair</a>
                            </div>
                        </div>
                    <?php endif; ?>
            </div>
            
            <ion-icon class="navbar-menu" name="menu"></ion-icon>

            <div class="sidebar" id="sidebar">
                <ion-icon class="close-sidebar" name="chevron-forward"></ion-icon>
                <div class="side-search">
                    <form action="/pesquisar" method="get">
                        <div class="search-input">
                            <input type="text" name="search" class="searchbar" />
                            <ion-icon class="search-icon" name="search"></ion-icon>
                        </div>
                    </form>
                </div>
                <div class="side-categories">
                    <ul class="dropdown-menu-side">
                        <?php foreach($categoriesArray['nivel_abaixo'] as $category): ?>
                            <li class="parent-category">
                                <a href="javascript:void(0);" class="dropdown-toggle"><ion-icon class="caret-forward" name="caret-forward"></ion-icon><?= htmlspecialchars($category['categoria']) ?></a>
                                <ul class="dropdown-menu-side">
                                    <?php foreach($category['nivel_abaixo'] as $subCategory): ?>
                                        <li class="side-subcategory">
                                            <a href="/produtos?categoria=<?= $subCategory['id'] ?>"><?= htmlspecialchars($subCategory['categoria']) ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <script>
                    document.querySelectorAll('.side-categories .dropdown-toggle').forEach(function(toggle) {
                        toggle.addEventListener('click', function() {
                            var parentCategory = this.parentElement;
                            parentCategory.classList.toggle('open');
                        });
                    });
                </script>




                <?php if(isset($_SESSION['user'])): ?>
                    <div class="side-account">
                        <a class="dropdown-item" href="/boletos">Meus Boletos</a>
                        <a class="dropdown-item text-danger" href="/logout"><ion-icon name="log-out"></ion-icon> Sair</a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="overlay" id="overlay"></div>

        </div>
        <div class="nav-bot">
            <div class="all-center more-categories">
                <div class="categ-name">
                    <small><h3>+ CATEGORIAS</h3></small>
                </div>
                <ul class="dropdown-menu">
                    <?php foreach($categoriesArray['nivel_abaixo'] as $category): ?>
                        <li class="subdropdown-link">
                            <a href="/produtos?categoria=<?= $category['id'] ?>"><?= htmlspecialchars($category['categoria']) ?></a>
                            <ul class="subdropdown-menu">
                                <?php foreach($category['nivel_abaixo'] as $subCategory): ?>
                                    <li>
                                        <a href="/produtos?categoria=<?= $subCategory['id'] ?>"><?= htmlspecialchars($subCategory['categoria']) ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php foreach($topCategoriesArray as $topCategory): ?>
                <a href="/produtos?categoria=<?= $topCategory['id'] ?>">
                    <div class="categ-wrap">
                        <div class="categ-name">
                            <small><?= mb_strtoupper($topCategory['categoria'], 'UTF-8') ?></small>     
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
                <img src="<?=$config['empresa_logomarca']?>" class="footer-img" alt="">
                <div class="company-info">
                    <h3 class="footer-company"><?=$config['nome_empresa']?></h3>
                    <ul class="info-items">
                        <li class="info-item">CNPJ: <?=$config['cnpj']?></li>
                        <li class="info-item">LOCALIZAÇÃO: <?=$config['endereco_rua']?>, <?=$config['endereco_numero']?> <?=$config['endereco_bairro']?> - <?=$config['endereco_cidade']?>/<?=$config['endereco_estado']?></li>
                        <li class="info-item">CEP: <?=$config['endereco_cep']?></li>
                        <li class="info-item">TEL: <?=$config['contato_telefone']?></li>
                        <li class="info-item">E-MAIL: <?=$config['contato_email']?></li>
                    </ul>
                </div>
            </div>
            <!-- <div class="contact-section">
                <form action="" class="company-contact">
                    <h4>Fale Conosco</h4>
                    <input placeholder="Nome" class="contact-input" type="text">
                    <input placeholder="E-mail" class="contact-input" type="text">
                    <input placeholder="Telefone" class="contact-input" type="text">
                    <textarea placeholder="Mensagem" class="message-input"></textarea>
                    <button class="contact-submit">Enviar</button>
                </form>
            </div> -->
            <div class="privacy-terms">
                <a href="/privacidade" target="_blank"><b><small>Política de Privacidade</small></b></a>
                <p><small>© Copyright 2024 – <?=$config['nome_empresa']?></small></p>
            </div>
        </div>
    </footer>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> 
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="../assets/js/master.js"></script>
    <script type="text/javascript" src="../assets/js/<?=$this->e($name)?>.js"></script>
</body>
</html>
