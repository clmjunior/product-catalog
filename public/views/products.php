<?php 
/** @var \League\Plates\Template\Template $this */
?>
<?php $this->layout('master', ['title' => 'Produtos', 'name' => 'products', 'logoImg' => 'liveup-original-logo.png']) ?>
<section class="image-container">
        <div class="product-img-container">
            <img src="<?= htmlspecialchars($product['fotos'][0]['url_imagem_0350']) ?>" alt="<?= htmlspecialchars($product['titulo_produto']) ?>" class="product-image">
        </div>
    </div>
</section>

<section class="products-section">
    <?php foreach($products['itens'] as $product): ?>
        <a class="product-card" href="/produto?id=<?= htmlspecialchars($product['sku']) ?>&titulo=<?= htmlspecialchars($product['slug_titulo_produto']) ?>">
            <div class="product-img-container">
                <img src="<?= htmlspecialchars($product['fotos'][0]['url_imagem_0350']) ?>" alt="<?= htmlspecialchars($product['titulo_produto']) ?>" class="product-image">
            </div>
            <div class="product-info">
                <h2 class="product-name"><?= htmlspecialchars($product['titulo_produto']) ?></h2>
                <p class="product-description">Descrição do produto aqui</p>
                <div class="card-footer">
                    <div class="price"><h3>R$ <?= htmlspecialchars(number_format($product['precos']['valor_final'], 2, ',', '.')) ?></h3></div>
                    <button class="product-button">Comprar</button>
                </div>
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
                        <!-- <img src="../assets/img/liveup-original-logo.png" alt="Marca d'água" class="watermark"> -->
