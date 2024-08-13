<?php
/** @var \League\Plates\Template\Template $this */
use app\controllers\ConfigController;

$config = ConfigController::getConfig();
?>
<?php $this->layout('master', ['title' => 'Privacidade', 'name' => 'privacy']) ?>

<section class="privacy-container">
    <div class="privacy-header">
        <h1>Política de Privacidade</h1>
        <!-- <p>Última atualização: <?= date('d/m/Y', strtotime($config['ultima_atualizacao'])) ?></p> -->
    </div>
    <div class="privacy-content">
        <p><?= $config['texto_paginas']['privacidade'] ?></p>
    </div>
</section>