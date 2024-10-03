<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<?php if( NOTENBANK_VERZEICHNIS != NULL AND !empty(NOTENBANK_VERZEICHNIS) ) { ?><div class="container mb-3">
<?= view( 'Notenbank/verzeichnis_oeffnen' ); ?>
</div><?php } ?>

<div class="container mb-3">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['aktuelles_verzeichnis'] ) ); ?>
</div>

<div class="blanko_modals">
<?php if( auth()->user()->can( 'notenbank.verwaltung' ) ) echo
        view( 'Templates/modal', array( 'modal_id' => 'notenbank_basiseigenschaften', 'modal' =>
        view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'notenbank', 'aktion' => 'aendern' ), 'btn' => array( 'klasse_id' => 'btn_titel_aktion' ), 'formular' =>
        view( 'Notenbank/titel_basiseigenschaften_formular' ) ) ) ) ); ?>
</div>
<?= $this->endSection() ?>

