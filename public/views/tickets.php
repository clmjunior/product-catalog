<?php 
/** @var \League\Plates\Template\Template $this */

if (!isset($_SESSION['user']) || $_SESSION['user_data']['cliente_id'] <= 0) {
    
    header("Location: /login");
    exit;
}

use app\controllers\Controller;

$config = Controller::getConfig();
?>
<?php $this->layout('master', ['title' => 'Boletos', 'name' => 'tickets']);
?>

<div class="nav-top-padding"></div>
<section class="tickets-section text-center">
    <h2>BOLETOS</h2>
    <?php if(!empty($tickets)): ?>
    <table class="tickets-table">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Data de Emissão</th>
                <th>Data de Vencimento</th>
                <th>Status</th>
                <th>Valor</th>
                <th>Vencimento em</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?= htmlspecialchars($ticket['duplicate_number']); ?></td>
                    <td><?= htmlspecialchars($ticket['issuance_date']); ?></td>
                    <td><?= htmlspecialchars($ticket['due_date']); ?></td>
                    <td><?= htmlspecialchars($ticket['status']); ?></td>
                    <td><?= htmlspecialchars($ticket['total_amount']); ?></td>
                    <td><?= htmlspecialchars($ticket['expires_in']); ?> dias</td>
                    <td><a href="<?= htmlspecialchars($ticket['pdf']); ?>" target="_blank">Visualizar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <h1 class="text-center color-lightgrey">Nenhum resultado encontrado...</h1>
    <?php endif; ?>
</section>

