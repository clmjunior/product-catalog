<?php 
/** @var \League\Plates\Template\Template $this */
use app\controllers\Controller;
use app\helpers\ApiHelper;

$config = Controller::getConfig();
$hostUrl = ApiHelper::getApiHost();
?>
<?php $this->layout('master', ['title' => 'Detalhe', 'name' => 'product_detail']) ?>


<div class="container-wrapper-detail">
    <section class="product-container">
        <div class="product-detail">
            

            <div class="img-prod-container">
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
                    <div class="download-images">
                        <a href="<?= $hostUrl ?>/product/download_product_images?sku=<?= htmlspecialchars($product['sku']) ?>" class="download-link">Baixar Imagens do Produto</a>
                    </div>
                </div>
            </div>

            <div class="product-details">
                <h1><?= htmlspecialchars($product['titulo_produto']) ?></h1>
                <hr class="divisor"/>
                    <?php 
                    $mostrarPrecoLogin = $config['mostrar_preco_login'] == "S";
                    $mostrarPrecoLogout = $config['mostrar_preco_logout'] == "S";
                    $usuarioLogado = isset($_SESSION['user']) && $_SESSION['user'] == true;
                    
                    $mostrarPreco = ($mostrarPrecoLogin && $mostrarPrecoLogout) ||
                                    ($mostrarPrecoLogin && !$mostrarPrecoLogout && $usuarioLogado) ||
                                    ($mostrarPrecoLogout && !$mostrarPrecoLogin && !$usuarioLogado);
                    
                    if($mostrarPreco): ?>
                    <div class="card-footer">
                        <h3>R$ <?= htmlspecialchars($product['precos']['valor_final']) ?></h3>
                    </div>
                <?php endif; ?>

                <p><?= $product['descricao_produto'] ?></p>

                
                <?php 
                $mostrarEstoqueLogin = $config['mostrar_estoque_login'] == "S";
                $mostrarEstoqueLogout = $config['mostrar_estoque_logout'] == "S";
                $usuarioLogado = isset($_SESSION['user']) && $_SESSION['user'] == true;
                
                $mostrarEstoque = ($mostrarEstoqueLogin && $mostrarEstoqueLogout) ||
                                ($mostrarEstoqueLogin && !$mostrarEstoqueLogout && $usuarioLogado) ||
                                ($mostrarEstoqueLogout && !$mostrarEstoqueLogin && !$usuarioLogado);

                if($mostrarEstoque): ?>
                <div class="info-card">
                    <div class="top">

                        <?php if($mostrarEstoque): ?>
                            <small><ion-icon class="stock-check" name="checkbox"></ion-icon> <?= htmlspecialchars($product['quantidade_estoque']) ?> Em estoque</small>
                        <?php endif; ?>


                        <?php if($config['liberado_comprar'] == "S"): ?>
                            <!-- <form class="add-to-cart" action="add_to_cart.php" method="post">
                                <input type="hidden" name="product_id" value=" htmlspecialchars($product['sku']) ">
                                <div class="quantity-input">
                                    <button class="minus-button" type="button" onclick="updateQuantity(-1)">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max=" htmlspecialchars($product['quantidade_estoque']) ">
                                    <button class="plus-button" type="button" onclick="updateQuantity(1)">+</button>
                                </div>
                                <button class="add-button" type="submit">Adicionar ao Carrinho</button>
                            </form> -->
                        <?php endif; ?>
                    </div>

                    <!-- <div class="bottom"> -->
                        <!-- <hr class="divisor"/> -->
                        <!-- <small><b>CATEGORIAS:</b> <?= htmlspecialchars($product['categories']) ?></small> -->

                    <!-- </div> -->
                </div>
                <?php endif; ?>
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
                            $key = isset($specArr[0]) ? trim($specArr[0]) : '';
                            $value = isset($specArr[1]) ? trim($specArr[1]) : '';
                            
                            if (!empty($key) && !empty($value)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($key) ?></td>
                                    <td><?= htmlspecialchars($value) ?></td>
                                </tr>
                            <?php elseif (!empty($key)): ?>
                                <tr>
                                    <td colspan="2"><?= htmlspecialchars($key) ?></td>
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

