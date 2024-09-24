<?php 
/** @var \League\Plates\Template\Template $this */
use app\controllers\ConfigController;

$config = ConfigController::getConfig();
$files = ConfigController::getSiteFiles();

?>
<?php $this->layout('master', ['title' => 'Produtos', 'name' => 'products']);
?>

<div class="nav-top-padding"></div>
<section class="banner-container">
    <div class="banner-content">
        <h1 class="animate__animated  animate__fadeInUp">EXPLORE NOSSO CATÁLOGO COMPLETO</h1>
        <div class="d-flex catalog-links">
            <?php foreach($files as $file): ?>
                <a target="_blank" href="<?= $file['file_link'] ?>" class="explore-button animate__animated  animate__fadeInUp animate__delay-2s"><?= mb_strtoupper($file['title']) ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    <div class="image-container">
        <img src="../assets/img/catalog_banner.png" class="banner animate__animated animate__zoomOutSmooth" alt="">
    </div>
</section>

<section class="products-section">
    
    <?php 
        if(!empty($products['itens'])):
            foreach($products['itens'] as $product): 
    ?>
                <a class="product-card" href="/<?= htmlspecialchars($product['slug_titulo_produto']) ?>_<?= htmlspecialchars($product['sku']) ?>">
                    <div class="product-img-container">
                        <img src="<?= htmlspecialchars($product['fotos'][0]['url_imagem_0350']) ?>" alt="<?= htmlspecialchars($product['titulo_produto']) ?>" class="product-image">
                        <img src="../assets/img/liveup-original-logo.png" alt="Marca d'água" class="watermark">
                    </div>
                    <div class="product-info">
                        <p class="product-name" title="<?= htmlspecialchars($product['titulo_produto']) ?>"><?= mb_strimwidth(htmlspecialchars($product['titulo_produto']), 0, 80, '...') ?></p>
                        <p class="product-description"><small><b><?= $product['referencia'] ?></b></small></p>
                        <?php if($config['mostrar_preco_login'] == "S" || $config['mostrar_preco_logout'] == "S" || $config['liberado_comprar'] == "S"): ?>

                        <div class="card-footer">
                            <?php 
                            $mostrarPrecoLogin = $config['mostrar_preco_login'] == "S";
                            $mostrarPrecoLogout = $config['mostrar_preco_logout'] == "S";
                            $usuarioLogado = isset($_SESSION['user']) && $_SESSION['user'] == true;
                            
                            $mostrarPreco = ($mostrarPrecoLogin && $mostrarPrecoLogout) ||
                                            ($mostrarPrecoLogin && !$mostrarPrecoLogout && $usuarioLogado) ||
                                            ($mostrarPrecoLogout && !$mostrarPrecoLogin && !$usuarioLogado);
                            
                            if($mostrarPreco && $_SESSION['user_data']['acesso_liberado'] == "S"): ?>
                                <div class="price"><h3>R$ <?= htmlspecialchars(number_format($product['precos']['valor_final'], 2, ',', '.')) ?></h3></div>
                            <?php endif; ?>
                            
                            <?php if($config['liberado_comprar'] == "S"): ?>
                                <!-- <button class="product-button">Comprar</button> -->
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </a>
    <?php 
        endforeach; 
        else: 
    ?>
        <h1 class="text-center color-lightgrey">Nenhum resultado encontrado...</h1>
    <?php 
        endif; 
    ?>
</section>

<section class="pages-container">
    <a href="<?= htmlspecialchars($products['paginacao']['url_primeira_pagina']) ?>" class="page-link">
        <ion-icon name="chevron-back" style="margin-right: -6px;"></ion-icon>
        <ion-icon name="chevron-back"></ion-icon>
    </a>
    <a href="<?= htmlspecialchars($products['paginacao']['url_pagina_anterior']) ?>" class="page-link">
        <ion-icon name="chevron-back"></ion-icon>
    </a>
    <?php foreach($products['paginacao']['navegacao'] as $page): ?>
        <?php
            $class = "";
            if($page['numero'] == $page['atual']) {
                $class = "page-active";
            }
        ?>
        <a href="<?= htmlspecialchars($page['url']) ?>" class="page-link <?= htmlspecialchars($class) ?>">
            <?= htmlspecialchars($page['numero']) ?>
        </a>
    
    <?php endforeach; ?>
    <a href="<?= htmlspecialchars($products['paginacao']['url_proxima_pagina']) ?>" class="page-link">
        <ion-icon name="chevron-forward"></ion-icon>
    </a>
    <a href="<?= htmlspecialchars($products['paginacao']['url_ultima_pagina']) ?>" class="page-link">
        <ion-icon name="chevron-forward" style="margin-right: -6px;"></ion-icon>
        <ion-icon name="chevron-forward"></ion-icon>
    </a>
</section>
