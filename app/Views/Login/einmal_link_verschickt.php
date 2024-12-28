<?= $this->extend('Templates/layout') ?>
<?= $this->section('containers') ?>

<div class="container" style="max-width: 36rem;"><div class="card">
    <div class="h5 card-header text-center text-secondary">Einmal-Link</div>
    <div class="card-body">

        <div class="mb-1">Es wurde eine Email verschickt mit dem angeforderten Einmal-Link.</div>
        <div class="mb-1">Bitte prüfe dein Email-Postfach!</div>

    </div>
</div></div>

<?= $this->endSection() ?>
