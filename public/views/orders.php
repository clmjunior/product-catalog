<?php 
/** @var \League\Plates\Template\Template $this */

if (!isset($_SESSION['user']) || $_SESSION['user_data']['cliente_id'] <= 0) {
    
    header("Location: /login");
    exit;
}

?>
<?php $this->layout('master', ['title' => 'Liveup Sports - Pedidos', 'name' => 'orders']);
?>

<div class="nav-top-padding"></div>
<section class="orders-section text-center">
    <h2>HISTÓRICO DE PEDIDOS</h2>
    <?php if(!empty($orders)): ?>
    <table class="orders-table">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Data de Emissão</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['numero_nota_fiscal']); ?></td>
                    <td><?= htmlspecialchars($order['data_emissao']); ?></td>
                    <td>
                        <form action="/download_xml" method="POST">
                            <input type="hidden" name="file" value="<?= htmlspecialchars($order['nfe_xml']); ?>">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($order['numero_nota_fiscal']); ?>">
                            <button type="submit" class="download-button">Baixar XML</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <h1 class="text-center color-lightgrey">Nenhum resultado encontrado...</h1>
    <?php endif; ?>
</section>

