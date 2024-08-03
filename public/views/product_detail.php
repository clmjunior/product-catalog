<?php 
/** @var \League\Plates\Template\Template $this */
?>
<?php $this->layout('master', ['title' => 'Detalhe', 'name' => 'product_detail']) ?>


<div class="container-wrapper-detail">
    <section class="product-container">
        <div class="product-detail">
            

            <div style="width: 40%;">
                <div id="page">
                    <div class="row">
                        <div class="column small-11 small-centered">
                            <div class="slider slider-single">
                                <?php foreach($product['fotos'] as $img): ?>
                                    <img class="product-caroussel-image-main" src="<?= htmlspecialchars($img['url_imagem_0750']) ?>" alt="<?= htmlspecialchars($product['descricao_produto']) ?>">
                                <?php endforeach; ?> 
                            </div>
                            <div class="slider slider-nav">
                                <?php foreach($product['fotos'] as $img): ?>
                                    <img class="product-caroussel-image" src="<?= htmlspecialchars($img['url_imagem_0750']) ?>" alt="<?= htmlspecialchars($product['descricao_produto']) ?>">
                                <?php endforeach; ?> 
                            </div>
                        </div>
                    </div>
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

