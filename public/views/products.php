<?php 
/** @var \League\Plates\Template\Template $this */
?>
<?php $this->layout('master', ['title' => 'Produtos', 'name' => 'products']) ?>
<section class="banner-container">
    <div class="image-container">
        <img src="../assets/img/products_banner.png" class="banner" alt="">
    </div>
</section>
<section class="products-section">
    <?php foreach($products as $product): ?>
        <a href="/produto?id=<?= htmlspecialchars($product['id']) ?>" class="product-card">
            <img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
            <img src="../assets/img/liveup-original-logo.png" alt="Marca d'água" class="watermark">
            <div class="product-info">
                <h2 class="product-name"><?= htmlspecialchars($product['name']) ?></h2>
                <p class="product-description">Descrição do produto aqui</p>
                <div class="card-footer">
                    <div class="price"><h3>R$ 49,99</h3></div>
                    <button class="product-button">Comprar</button>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</section>
