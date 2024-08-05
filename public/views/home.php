<?php
/** @var \League\Plates\Template\Template $this */
use app\controllers\CategoryController;
use app\controllers\ConfigController;

$categoriesArray = CategoryController::getTopCategories();
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

    if (isset($success_msg) && !empty($success_msg)) {
        foreach(explode(";", $success_msg) as $msg) {
            echo "<div class='message-box bg-success'>{$msg}</div>";
        } 
    }
?>

</div>

<section class="banner-container">
    <div class="image-container">
        <img src="../assets/img/home_banner.png" class="banner animate__animated animate__zoomOutSmooth" alt="">
    </div>
    <div class="banner-content">
        <h1 class="animate__animated  animate__fadeInUp">TÍTULO LIVEUP</h1>
        <h4 class="animate__animated  animate__fadeInUp animate__delay-1s">SUBTITULO LIVEUP</h4>
        <button type="submit" class="explore-button animate__animated  animate__fadeInUp animate__delay-2s">EXPLORAR CATEGORIAS</button>
    </div>
</section>
<section class="about-container">
    <div class="card">
        <h3>Quem Somos</h3>
        <p><?= $config['texto_paginas']['quem_somos_resumo'] ?></p>
    </div>
    <div class="card">
        <h3>O Que Fazemos</h3>
        <p>Uma empresa jovem que através de constantes pesquisas nos mercados externo e interno vem trazendo produtos e oportunidades diferenciadas para o comércio brasileiro.</p>
    </div>
    <div class="card">
        <h3>Missão e Valores</h3>
        <p>Uma empresa jovem que através de constantes pesquisas nos mercados externo e interno vem trazendo produtos e oportunidades diferenciadas para o comércio brasileiro.</p>
    </div>
</section>
<section class="hot-products-container">
    <div>
        <h1 class="text-center">PRODUTOS</h1>
        
    </div>
    <?php foreach($products as $key => $value): ?>
        <div class="options">
            <div id="hot" class="option-item"><?= $key ?></div>
        </div>
        <div class="carousel-container">
            <div class="multiple-items">
                <?php foreach($value as $product): ?>
                    <?php foreach($product as $productCard): ?>
                        <a class="product-card" href="/produto?id=<?= htmlspecialchars($productCard['sku']) ?>&titulo=<?= htmlspecialchars($productCard['slug_titulo_produto']) ?>">
                            <div class="product-img-container">
                                <img src="<?= htmlspecialchars($productCard['fotos'][0]['url_imagem_0350']) ?>" alt="<?= htmlspecialchars($productCard['titulo_produto']) ?>" class="product-image">
                                <img src="../assets/img/liveup-original-logo.png" alt="Marca d'água" class="watermark">
                            </div>
                            <div class="product-info">
                                <h1 class="product-name"><?= htmlspecialchars($productCard['titulo_produto']) ?></h1>
                                <p class="product-description"><small><b><?= $productCard['referencia'] ?></b></small></p>

                                <?php if($config['mostrar_preco_site'] == "S" || $config['liberado_comprar'] == "S"): ?>
                                    <div class="card-footer">
                                        <?php if($config['mostrar_preco_site'] == "S"): ?>
                                            <div class="price"><h3>R$ <?= htmlspecialchars(number_format($productCard['precos']['valor_final'], 2, ',', '.')) ?></h3></div>
                                        <?php endif; ?>
                                        <?php if($config['liberado_comprar'] == "S"): ?>
                                            <button class="product-button">Comprar</button>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

</section>


