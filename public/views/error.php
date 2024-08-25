<?php
/** @var \League\Plates\Template\Template $this */
?>
<?php $this->layout('master', ['title' => 'Error', 'name' => 'error']) ?>

<link rel="stylesheet" href="/path/to/css/error.css">

<div class="error-container">
    <div class="error-card">
        <h1>Oops! Algo deu errado.</h1>
        <small>
            <p><b><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></b></p>
            <p class="error-footer"><b>Por favor, tente novamente mais tarde.</b></p>
        </small>
    </div>
</div>
