<?= $this->extend('Templates/layout') ?>
<?= $this->section('containers') ?>

<div class="container" style="max-width: 36rem;"><div class="card">
<h5 class="card-header text-center text-secondary">Einmal-Link</h5>
  <div class="card-body">

  <div class="mb-1"><?= lang('Auth.checkYourEmail') ?></div>
  <div class="mb-1"><?= lang('Auth.magicLinkDetails', [setting('Auth.magicLinkLifetime') / 60]) ?></div>

  </div>
</div></div>

<?= $this->endSection() ?>
