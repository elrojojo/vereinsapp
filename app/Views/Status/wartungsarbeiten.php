<?= $this->extend('Templates/layout') ?>
<?= $this->section('containers') ?>

<div class="container" style="max-width: 36rem;"><div class="card">
    <h5 class="card-header text-center text-secondary">Hoppla...</h5>
    <div class="card-body">Aktuell finden Wartungsarbeiten statt. Bitte hab etwas Geduld und versuche es später nochmal!</div>
</div></div>

<?php if (config('vereinsapp')->kasten_weiter_zur_website_von_login ) : ?>
<div class="container mt-5" style="max-width: 36rem;"><div class="card">
    <div class="card-body">
        <div class="mb-3">Du wolltest eigentlich zur öffentlichen Website von <?= config('vereinsapp')->verein_name; ?>?</div>
        <div class="d-grid"><a class="btn btn-outline-primary" href="<?= config('vereinsapp')->verein_domain; ?>">Weiter zu <?= config('vereinsapp')->verein_domain; ?></a></div>
    </div>
</div></div>
<?php endif ?>

<?= $this->endSection() ?>
