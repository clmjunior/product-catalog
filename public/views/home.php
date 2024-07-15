<?php
/** @var \League\Plates\Template\Template $this */
use app\controllers\CategoryController;

$categoriesArray = CategoryController::getCategories();

?>
<?php $this->layout('master', ['title' => 'Home', 'name' => 'home']) ?>
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
        <p>Uma empresa jovem que através de constantes pesquisas nos mercados externo e interno vem trazendo produtos e oportunidades diferenciadas para o comércio brasileiro.</p>
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
        <div class="options">
            <div id="hot" class="option-item">Em Alta</div>
            <div id="new" class="option-item">Novos Produtos</div>
        </div>
    </div>
    <div class="multiple-items">
        <?php foreach($products as $product): ?>
            <div class="product-card">
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
            </div>
        <?php endforeach; ?>
    </div>
</section>
<section class="categories-container">
    <div>
        <h1 class="text-center">EXPLORE NOSSAS CATEGORIAS</h1>
    </div>
    <form class="categories" action="/produtos" method="post">
        <?php foreach($categoriesArray as $key => $value): ?>
            <input type="hidden" name="category_id" value="<?= $key ?>" />
            <button type="submit" class="category">
                <h1 class="category-title"><?= $value ?></h1>
                <img class="category-img" src="../assets/img/home_banner.png" alt="">
            </button>
        <?php endforeach; ?>
    </form>
    <a href="/categorias" class="explore-button-container">
        <button type="submit" class="explore-button-dark">EXPLORAR CATEGORIAS</button>
    </a>
</section>


