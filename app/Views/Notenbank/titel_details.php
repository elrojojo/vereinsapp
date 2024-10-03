<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3 element" data-liste="notenbank" data-element_id="<?= $element_id; ?>">
    <?= view( 'Templates/Liste/element_navigation', array( 'element_navigation' => $element_navigation ) ); ?>
    <div class="h5 beschriftung text-center">
        <span class="eigenschaft" data-eigenschaft="titel"></span>
    </div>
    <div class="row g-0 my-1">
        <div class="col text-center text-nowrap"><span class="eigenschaft" data-eigenschaft="kategorie"></span></div>
    </div>
</div>

<div class="container mb-3">
<?= view( 'Templates/Liste/verzeichnis', array( 'verzeichnis' => $verzeichnis['aktuelles_verzeichnis'] ) ); ?>
</div>

<div class="blanko_modals" data-liste="notenbank">
<?php if( auth()->user()->can( 'notenbank.verwaltung' ) ) echo
        view( 'Templates/modal', array( 'modal_id' => 'basiseigenschaften', 'modal' =>
        view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'notenbank', 'aktion' => 'aendern' ), 'btn' => array( 'klasse_id' => 'btn_titel_aktion' ), 'formular' =>
        view( 'Notenbank/titel_basiseigenschaften_formular' ) ) ) ) ); ?>
</div>

<?php if( auth()->user()->can( 'notenbank.verwaltung' ) ) echo view( 'Templates/werkzeugkasten_handle', array( 'liste' => 'notenbank', 'element_id' => $element_id ) ); ?>
<?= $this->endSection() ?>