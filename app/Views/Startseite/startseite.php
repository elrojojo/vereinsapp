<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= $this->include( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'werkzeugkasten' ); ?><?= $this->include( 'Templates/werkzeugkasten' ); ?><?= $this->endSection(); ?>
<?= $this->section('containers') ?>

<div class="container mb-2 text-center">
  <img src="<?= config('vereinsapp')->vereinsapp_logo; ?>" />
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

