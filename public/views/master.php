<?php

/** @var \League\Plates\Template\Template $this */
use app\controllers\CategoryController;
use app\controllers\ConfigController;
use app\helpers\ApiHelper;

if (ApiHelper::isApiAccessible()):
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
            <div class="logo-menu-container">
                <a href="/">
                    <img src="<?=$config['empresa_logomarca']?>" class="nav-logo" alt="">
                </a>
                <ion-icon class="navbar-menu" name="menu"></ion-icon>
            </div>
    
            <form action="/pesquisar" method="get">
                <div class="search-input">
                    <input type="text" name="search" class="searchbar" placeholder="O que você procura?" />
                    <ion-icon class="search-icon" name="search"></ion-icon>
                </div>
            </form>

            <div class="right-container">
                <!-- <div class="separator"></div> -->

                <?php if(!isset($_SESSION['user'])): ?>
                    <a class="login-link" href="/login">
                        <ion-icon name="log-in"></ion-icon> 
                        <p>Entrar</p>
                    </a>
                    <?php else: ?>
                        <div class="dropdown account">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="dropdownMenuButton" >
                                <?php $user_name = $_SESSION['user_data']['nome_fantasia'] ?? "Conta"; ?>
                                <ion-icon name="person-circle"></ion-icon> <p><?= $user_name ?></p>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/boletos">Meus Boletos</a>
                                <a class="dropdown-item" href="/pedidos">Histórico de Pedidos</a>
                                <a class="dropdown-item text-danger" href="/logout"><ion-icon name="log-out"></ion-icon> Sair</a>
                            </div>
                        </div>
                    <?php endif; ?>
            </div>
            

            <div class="sidebar" id="sidebar">
                <ion-icon class="close-sidebar" name="close"></ion-icon>
                <div class="side-categories">
                    <ul class="dropdown-menu-side">
                        <?php foreach($categoriesArray['nivel_abaixo'] as $category): ?>
                            <li class="parent-category">
                                <a href="javascript:void(0);" class="dropdown-toggle"><?= htmlspecialchars($category['categoria']) ?><ion-icon class="caret-down" name="caret-down"></ion-icon></a>
                                <ul class="dropdown-menu-side">
                                    <?php foreach($category['nivel_abaixo'] as $subCategory): ?>
                                        <li class="side-subcategory">
                                            <a href="/<?= $subCategory['slug_categoria'] ?>"><?= htmlspecialchars($subCategory['categoria']) ?></a>
                                        </li>
                                        <?php endforeach; ?>
                                        <li class="side-subcategory">
                                            <a href="/<?= $category['slug_categoria'] ?>">Mostrar Tudo</a>
                                        </li>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <script>
                    document.querySelectorAll('.side-categories .dropdown-toggle').forEach(function(toggle) {
                        toggle.addEventListener('click', function() {
                            // Fechar todos os outros dropdowns
                            document.querySelectorAll('.side-categories .parent-category').forEach(function(parent) {
                                if (parent !== toggle.parentElement) {
                                    parent.classList.remove('open');
                                    parent.querySelector('ul.dropdown-menu-side').style.maxHeight = null;
                                }
                            });

                            // Alternar o dropdown clicado
                            var parentCategory = this.parentElement;
                            parentCategory.classList.toggle('open');

                            var dropdown = parentCategory.querySelector('ul.dropdown-menu-side');
                            if (parentCategory.classList.contains('open')) {
                                dropdown.style.maxHeight = dropdown.scrollHeight + "px";
                            } else {
                                dropdown.style.maxHeight = null;
                            }
                        });
                    });
                </script>




                <?php if(isset($_SESSION['user'])): ?>
                    <div class="side-account">
                        <a class="dropdown-item" href="/boletos">Meus Boletos</a>
                        <a class="dropdown-item" href="/pedidos">Histórico de Pedidos</a>
                        <a class="dropdown-item text-danger" href="/logout"><ion-icon name="log-out"></ion-icon> Sair</a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="overlay" id="overlay"></div>

        </div>
        <div class="nav-bot">
            <div class="all-center more-categories">
                <div class="categ-name">
                    <small><ion-icon name="menu"></ion-icon> CATEGORIAS</small>
                </div>

                <ul class="dropdown-menu" id="main-dropdown-menu">
                    <?php foreach($categoriesArray['nivel_abaixo'] as $category): ?>
                        <li class="subdropdown-link" 
                            data-submenu='<?= json_encode($category['nivel_abaixo']) ?>'>
                            <a href="/<?= $category['slug_categoria'] ?>">
                                <?= htmlspecialchars($category['categoria']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Submenu fora da estrutura -->
            <ul id="floating-submenu" class="subdropdown-menu"></ul>


            <?php foreach($topCategoriesArray as $topCategory): ?>
                <a href="/<?= $topCategory['slug_categoria'] ?>">
                    <div class="categ-wrap">
                        <div class="categ-name">
                            <small><?= mb_strtoupper($topCategory['categoria'], 'UTF-8') ?></small>     
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
                <a href="/produtos">
                    <div class="categ-wrap">
                        <div class="categ-name">
                            <small class='text-orange'>+ MOSTRAR TUDO</small>   
                        </div>
                    </div>
                </a>
        </div>
    </nav>

    <?= $this->section('content') ?>

    <?php
    $telefone_formatado = '55' . preg_replace('/[^0-9]/', '', $config['contato_celular']);
    ?>

    <a target="_blank" href="https://api.whatsapp.com/send?phone=<?= $telefone_formatado ?>&text=Tenho interesse em um dos produtos do site <?= $config['nome_fantasia'] ?> ">
        <ion-icon name="logo-whatsapp" class="wpp-logo"></ion-icon>
    </a>
    <footer class="footer">
        <div class="footer-wrapper">
            <div class="footer-top">
                <!-- <img src="<?=$config['empresa_logomarca']?>" class="footer-img" alt=""> -->
                <div class="company-info">
                    <h3 class="footer-company"><?=$config['nome_empresa']?></h3>
                    <ul class="info-items">
                        <li class="info-item">CNPJ: <?=$config['cnpj']?></li>
                        <li class="info-item">LOCALIZAÇÃO: <?=$config['endereco_rua']?>, <?=$config['endereco_numero']?> <?=$config['endereco_bairro']?>, <?=$config['endereco_cidade']?>-<?=$config['endereco_estado'] == 'PARANA' ? 'PR' : $config['endereco_estado'] ?></li>
                        <li class="info-item">CEP: <?=$config['endereco_cep']?></li>
                        <li class="info-item">TEL: <?=$config['contato_telefone']?></li>
                        <!-- <li class="info-item">E-MAIL: <?=$config['contato_email']?></li> -->
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
                <p><small>© Copyright 2024 - <?=$config['nome_empresa']?></small></p>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdownToggle = document.getElementById("dropdownMenuButton");
            const dropdownMenu = document.querySelector(".dropdown-menu");

            if (dropdownToggle && dropdownMenu) {
                dropdownToggle.addEventListener("click", function(event) {
                    event.preventDefault(); // Prevent the default anchor behavior
                    dropdownMenu.classList.toggle("show");
                });

                window.addEventListener("click", function(event) {
                    // Close the dropdown if clicking outside of it
                    if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.remove("show");
                    }
                });
            }

            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const navbarMenu = document.querySelector('.navbar-menu');
            const closeSidebar = document.querySelector('.close-sidebar');

            function showSidebar() {
                sidebar.classList.add('active');
                overlay.classList.add('active');
            }

            function hideSidebar() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }

            navbarMenu.addEventListener('click', showSidebar);
            closeSidebar.addEventListener('click', hideSidebar);
            overlay.addEventListener('click', hideSidebar);
        });

    </script>
</body>
</html>
<?php else: ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/master.css">
    <link rel="stylesheet" href="../assets/css/<?=$this->e($name)?>.css">
    
    <title><?=$this->e($title)?></title>
</head>
<body>
    
    <?= $this->section('content') ?>

    </body>
</html>
<?php endif; ?>