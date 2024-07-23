<?php
/** @var \League\Plates\Template\Template $this */
use app\controllers\CategoryController;

$categoriesArray = CategoryController::getCategories();

?>
<?php $this->layout('master', ['title' => 'Categorias', 'name' => 'categories', 'logoImg' => 'liveup-original-logo.png']) ?>
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
    <div class="categories" >
        <?php foreach($categoriesArray['nivel_abaixo'] as $category):?>
            <div type="submit" class="category">
                <?php
                    if(empty($category['url_banner'])) {
                        $banner = "https://picsum.photos/500/300";
                    } else {
                        $banner = $category['url_banner'];
                    }
                ?>
                <img class="category-img" src="<?= htmlspecialchars($banner) ?>" alt="">
                <!-- <h1 class="category-title"><a class="category-link" href="/produtos?categoria=<?= $category['slug_categoria'] ?>"><?= $category['categoria'] ?></a> -->
                <h1 class="category-title"><a class="category-link" href="/produtos?categoria=<?= $category['id'] ?>"><?= $category['categoria'] ?></a>
                    <?php if(count($category['nivel_abaixo']) > 0): ?>
                        <div class="subcategory-container">
                            <?php foreach($category['nivel_abaixo'] as $subCategory):?>
                                <div class="subcategory-title"><?= htmlspecialchars($subCategory['categoria']) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </h1>
            </div>
        <?php endforeach; ?>
    </div>
</section>

