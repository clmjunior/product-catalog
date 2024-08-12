<?php 
/** @var \League\Plates\Template\Template $this */
use app\controllers\Controller;

$config = Controller::getConfig();
?>
<?php $this->layout('master', ['title' => 'Produtos', 'name' => 'products']);
?>

<div class="nav-top-padding"></div>
<section class="products-section">
    <?php foreach($products['itens'] as $product): ?>
        <a class="product-card" href="/produto?id=<?= htmlspecialchars($product['sku']) ?>&titulo=<?= htmlspecialchars($product['slug_titulo_produto']) ?>">
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
                    
                    if($mostrarPreco): ?>
                        <div class="price"><h3>R$ <?= htmlspecialchars(number_format($product['precos']['valor_final'], 2, ',', '.')) ?></h3></div>
                    <?php endif; ?>
                    
                    <?php if($config['liberado_comprar'] == "S"): ?>
                        <button class="product-button">Comprar</button>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </a>
    <?php endforeach; ?>
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
