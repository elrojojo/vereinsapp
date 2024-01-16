<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= $this->include( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'werkzeugkasten' ); ?><?= $this->include( 'Templates/werkzeugkasten' ); ?><?= $this->endSection(); ?>
<?= $this->section('containers') ?>

<div class="container mb-2 text-center">
<?php if (config('vereinsapp')->kasten_weiter_zur_website_von_startseite ) : ?>
    <div class="row row-cols-2 g-0">
        <div class="col-6" style="position: relative;">
            <img style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" src="<?= config('vereinsapp')->vereinsapp_logo; ?>" /></div>
        <div class="col-6"><a class="btn" style="position: relative;" href="<?= config('vereinsapp')->verein_domain; ?>">
            <img class="opacity-25" src="<?= config('vereinsapp')->vereinsapp_logo; ?>" />
            <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" class="h5 text-primary">Weiter zur öffentlichen Website</span>
        </a></div>
    </div>
<?php else : ?>
  <img src="<?= config('vereinsapp')->vereinsapp_logo; ?>" />
<?php endif ?>
</div>

<div class="container mb-2">
  <div class="ueberschrift text-secondary text-center invisible mb-1" data-instanz="anstehende_geburtstage">Geburtstage in den nächsten 14 Tagen</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['anstehende_geburtstage'] ) ); ?>
</div>

<div class="container mb-2">
  <div class="ueberschrift text-secondary text-center invisible mb-1" data-instanz="anstehende_termine">Termine in den nächsten 14 Tagen</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['anstehende_termine'] ) ); ?>
</div>

<div class="container mb-2">
  <div class="ueberschrift text-secondary text-center invisible mb-1" data-instanz="termine_ausstehende_rueckmeldung">Termine ohne Rückmeldung</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['termine_ausstehende_rueckmeldung'] ) ); ?>
</div>

<?= $this->endSection() ?>

