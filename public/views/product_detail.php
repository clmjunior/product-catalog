<?php 
/** @var \League\Plates\Template\Template $this */
?>
<?php $this->layout('master', ['title' => 'Detalhe', 'name' => 'product_detail']) ?>
<div class="container-wrapper-detail">
    <section class="product-container">
        <div class="product-image">
            <img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>
        <div class="product-details">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            <h3>R$ <?= htmlspecialchars($product['price']) ?></h3>
            <p><?= htmlspecialchars($product['details']) ?></p>
            
            <div class="info-card">
                <div class="top">
                    <small><ion-icon class="stock-check" name="checkbox"></ion-icon> <?= htmlspecialchars($product['stock']) ?> Em estoque</small>
                    <form class="add-to-cart" action="add_to_cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                        <div class="quantity-input">
                            <button class="minus-button" type="button" onclick="updateQuantity(-1)">-</button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= htmlspecialchars($product['stock']) ?>">
                            <button class="plus-button" type="button" onclick="updateQuantity(1)">+</button>
                        </div>
                        <button class="add-button" type="submit">Adicionar ao Carrinho</button>
                    </form>
                </div>

                <div class="bottom">
                    <hr class="divisor"/>
                    <small><b>CATEGORIAS:</b> <?= htmlspecialchars($product['categories']) ?></small>

                </div>
            </div>
        </div>
    </section>
    <div class="product-specifications">
        <h2>Especificações</h2>
        <table class="spec-table">
            <?php foreach ($product['specifications'] as $key => $value): ?>
                <?php if (is_array($value)): ?>
                    <tr>
                        <th><?= htmlspecialchars($key) ?></th>
                        <td>
                            <ul>
                                <?php foreach ($value as $subValue): ?>
                                    <li><?= htmlspecialchars($subValue) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <th><?= htmlspecialchars($key) ?></th>
                        <td><?= htmlspecialchars($value) ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    </div>
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