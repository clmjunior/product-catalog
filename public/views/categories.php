<?php
/** @var \League\Plates\Template\Template $this */
use app\controllers\CategoryController;

$categoriesArray = CategoryController::getCategories();

?>
<?php $this->layout('master', ['title' => 'Categorias', 'name' => 'categories']) ?>
<section class="banner-container">
    <div class="image-container">
        <img src="../assets/img/categories_banner.png" class="banner" alt="">
    </div>
</section>
<section class="categories-container">
    <div>
        <h1 class="text-center">CATEGORIAS</h1>
        <small class="text-center">Subtitulo categorias</small>
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
</section>

