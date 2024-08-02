<?php 
/** @var \League\Plates\Template\Template $this */
?>
<?php $this->layout('master', ['title' => 'Detalhe', 'name' => 'product_detail']) ?>
<style>
    body { background-color: #aacccc }

.js .slider-single > div:nth-child(1n+2) { display: none }

.js .slider-single.slick-initialized > div:nth-child(1n+2) { display: block }

h3 {
	background: #f0f0f0;
	color: #3498db;
	font-size: 2.25rem;
	margin: .5rem;
	padding: 2%;
	position: relative;
	text-align: center;
}

.slider-single h3 {
	line-height: 10rem;
}

.slider-nav h3::before {
	content: "";
	display: block;
	padding-top: 75%;
}

.slider-nav h3 span {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}

.slider-nav .slick-slide { cursor: pointer; }

.slick-slide.is-active h3 {
	color: #c00;
	background-color: #fff
}
</style>

<div style="background-color: pink; width: 50%; padding-top: 200px;">


    <div id="page">
        <div class="row">
            <div class="column small-11 small-centered">
                <h2>Slick Slider Syncing</h2>
                <div class="slider slider-single">
                    <div><h3>1</h3></div>
                    <div><h3>2</h3></div>
                    <div><h3>3</h3></div>
                    <div><h3>4</h3></div>
                    <div><h3>5</h3></div>
                    <div><h3>6</h3></div>
                    <div><h3>7</h3></div>
                    <div><h3>8</h3></div>
                    <div><h3>9</h3></div>
                    <div><h3>10</h3></div>
                </div>
                <div class="slider slider-nav">
                    <div><h3><span>1</span></h3></div>
                    <div><h3><span>2</span></h3></div>
                    <div><h3><span>3</span></h3></div>
                    <div><h3><span>4</span></h3></div>
                    <div><h3><span>5</span></h3></div>
                    <div><h3><span>6</span></h3></div>
                    <div><h3><span>7</span></h3></div>
                    <div><h3><span>8</span></h3></div>
                    <div><h3><span>9</span></h3></div>
                    <div><h3><span>10</span></h3></div>
                </div>
            </div>
        </div>
    </div>




</div>










<div class="container-wrapper-detail">
    <section class="product-container">
        <div class="product-detail">
            <div class="product-image-container">
                <div class="img-main">
                    <?php foreach($product['fotos'] as $img): ?>
                        <div class="img-caroussel-container">
                            <img class="product-caroussel-image" src="<?= htmlspecialchars($img['url_imagem_0750']) ?>" alt="<?= htmlspecialchars($product['descricao_produto']) ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="img-caroussel">
                    <?php foreach($product['fotos'] as $img): ?>
                        <div class="img-caroussel-container">
                            <img class="product-caroussel-image" src="<?= htmlspecialchars($img['url_imagem_0750']) ?>" alt="<?= htmlspecialchars($product['descricao_produto']) ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="product-details">
                <h1><?= htmlspecialchars($product['titulo_produto']) ?></h1>
                <hr class="divisor"/>
                <h3>R$ <?= htmlspecialchars($product['precos']['valor_final']) ?></h3>
                <p><?= htmlspecialchars($product['descricao_produto']) ?></p>
                
                <div class="info-card">
                    <div class="top">
                        <small><ion-icon class="stock-check" name="checkbox"></ion-icon> <?= htmlspecialchars($product['quantidade_estoque']) ?> Em estoque</small>
                        <form class="add-to-cart" action="add_to_cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['sku']) ?>">
                            <div class="quantity-input">
                                <button class="minus-button" type="button" onclick="updateQuantity(-1)">-</button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= htmlspecialchars($product['quantidade_estoque']) ?>">
                                <button class="plus-button" type="button" onclick="updateQuantity(1)">+</button>
                            </div>
                            <button class="add-button" type="submit">Adicionar ao Carrinho</button>
                        </form>
                    </div>

                    <div class="bottom">
                        <hr class="divisor"/>
                        <!-- <small><b>CATEGORIAS:</b> <?= htmlspecialchars($product['categories']) ?></small> -->

                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="specs-container">
        <div class="product-specifications">
            <?php foreach ($product['especificacoes_produto'] as $category => $specs): ?>
                
                <table class="spec-table">
                    <th colspan="2"><h2 class="spec-category"><?= htmlspecialchars($category) ?></h2></th>
                    <tbody>
                        <?php foreach ($specs as $spec):
                                $specArr = explode(":", $spec);
                                if(count($specArr) > 1):
                                    list($key, $value) = $specArr;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($key) ?></td>
                                <td><?= htmlspecialchars($value) ?></td>
                            </tr>
                            <?php else: ?>
                                <tr>
                                <td><?= htmlspecialchars($spec) ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        </div>
    </section>

</div>
<script>
    function updateQuantity(amount) {
        var quantityInput = document.getElementById('quantity');
        var currentQuantity = parseInt(quantityInput.value);
        var newQuantity = currentQuantity + amount;
        if (newQuantity >= 1 && newQuantity <= <?= htmlspecialchars($product['stock']) ?>) {
            quantityInput.value = newQuantity;
        }
    }
</script>