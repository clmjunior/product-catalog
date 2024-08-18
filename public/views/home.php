<?php
/** @var \League\Plates\Template\Template $this */
use app\controllers\ConfigController;
use app\controllers\CategoryController;

$topCategoriesArray = CategoryController::getTopCategories();
$config = ConfigController::getConfig();
?>
<?php $this->layout('master', ['title' => 'Home', 'name' => 'home']) ?>

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

<section class="banner-container">
    <div class="image-container">
        <img src="../assets/img/home_banner.png" class="banner animate__animated animate__zoomOutSmooth" alt="">
    </div>
    <div class="banner-content">
        <h1 class="animate__animated  animate__fadeInUp">ELEVE-SE AO MÁXIMO</h1>
        <h4 class="animate__animated  animate__fadeInUp animate__delay-1s">FORÇA E SAÚDE EM HARMONIA</h4>
        <?php if(!empty($products)): ?>
            <button onclick="rollToProductsSection();" type="button" class="explore-button animate__animated  animate__fadeInUp animate__delay-2s">EXPLORAR PRODUTOS</button>
        <?php endif; ?>
    </div>
</section>
<section class="about-container">
    <div class="card">
        <h3>Quem Somos</h3>
        <p><?= $config['texto_paginas']['quem_somos_resumo'] ?></p>
    </div>
    <div class="card">
        <h3>O Que Fazemos</h3>
        <p><?= $config['texto_paginas']['como_comprar'] ?></p>
    </div>
    <div class="card">
        <h3>Missão e Valores</h3>
        <p><?= $config['texto_paginas']['politica_troca'] ?></p>
    </div>
</section>
<section class="small-categories-container">
    <div class="small-categories">
        <?php foreach($topCategoriesArray as $topCategory): ?>
            <div class="category-container">
                <a href="/produtos?categoria=<?= $topCategory['id'] ?>">
                    <h4 class="category-title"><?= mb_strtoupper($topCategory['categoria'], "UTF-8") ?></h4>
                    <img src="<?= str_replace("https://www.liveupsports.com.br", "https://totalcommerce-dev.ddns.net/", $topCategory['url_icone']) ?>">
                </a>
            </div>
        <?php endforeach; ?>
    </div>


</section>
<?php if(!empty($products)): ?>
    <section id="products-section" class="products-section">
        <?php foreach($products as $categoryItems): ?>
            <div class="category-banner">
                <img src="<?= $categoryItems['category_banner'] ?>" alt="">
            </div>
            <div class="carousel-container">
                <div class="multiple-items">
                    <?php foreach($categoryItems['items'] as $productCard): ?>
                        <?php //foreach($product as $productCard): ?>
                            <a class="product-card" href="/produto?id=<?= htmlspecialchars($productCard['sku']) ?>&titulo=<?= htmlspecialchars($productCard['slug_titulo_produto']) ?>">
                                <div class="product-img-container">
                                    <img src="<?= htmlspecialchars($productCard['fotos'][0]['url_imagem_0350']) ?>" alt="<?= htmlspecialchars($productCard['titulo_produto']) ?>" class="product-image">
                                    <img src="../assets/img/liveup-original-logo.png" alt="Marca d'água" class="watermark">
                                </div>
                                <div class="product-info">
                                    <p class="product-name" title="<?= htmlspecialchars($productCard['titulo_produto']) ?>"><?= mb_strimwidth(htmlspecialchars($productCard['titulo_produto']), 0, 80, '...') ?></p>
                                    <p class="product-description"><small><b><?= $productCard['referencia'] ?></b></small></p>

                                    <?php if($config['mostrar_preco_login'] == "S" || $config['mostrar_preco_logout'] == "S" || $config['liberado_comprar'] == "S"): ?>

                                    <div class="card-footer">
                                        <?php 
                                        $mostrarPrecoLogin = $config['mostrar_preco_login'] == "S";
                                        $mostrarPrecoLogout = $config['mostrar_preco_logout'] == "S";
                                        $usuarioLogado = isset($_SESSION['user']) && $_SESSION['user'] == true;
                                        
                                        $mostrarPreco = ($mostrarPrecoLogin && $mostrarPrecoLogout) ||
                                                        ($mostrarPrecoLogin && !$mostrarPrecoLogout && $usuarioLogado) ||
                                                        ($mostrarPrecoLogout && !$mostrarPrecoLogin && !$usuarioLogado);
                                        
                                        if($mostrarPreco): ?>
                                            <div class="price"><h3>R$ <?= htmlspecialchars(number_format($productCard['precos']['valor_final'], 2, ',', '.')) ?></h3></div>
                                        <?php endif; ?>
                                        
                                        <?php if($config['liberado_comprar'] == "S"): ?>
                                            <!-- <button class="product-button">Comprar</button> -->
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php //endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

    </section>
<?php endif; ?>



