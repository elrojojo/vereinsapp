<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3 element" data-liste="umfragen" data-element_id="<?= $element_id; ?>">
<?= view( 'Templates/Liste/element_navigation', array( 'element_navigation' => $element_navigation ) ); ?>
    <div class="h5 beschriftung text-center"><span class="eigenschaft" data-eigenschaft="titel"></span></div>
    <div class="row g-0 my-1">
        <div class="col text-center text-nowrap fst-italic"><span class="eigenschaft" data-eigenschaft="bemerkung"></span></div>
    </div>
<?= view( 'Umfragen/rueckmeldung_basiseigenschaften', array( 'mitglied_id' => ICH['id'] ) ); ?>
</div>

<div class="container mb-3">
    <div class="ueberschrift text-secondary text-center invisible mb-1" data-liste="aufgaben" data-instanz="zugeordnete_aufgaben">Zugeordnete Aufgaben</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['zugeordnete_aufgaben'] ) ); ?>
<?php if( array_key_exists( 'aufgaben.verwaltung', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'aufgaben.verwaltung' ) ) echo
    view( 'Templates/modal', array( 'id' => 'aufgaben_basiseigenschaften', 'modal' =>
    view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'aufgaben' ), 'btn' => array( 'klasse_id' => 'btn_aufgabe_aktion' ), 'formular' =>
    view( 'Aufgaben/aufgabe_basiseigenschaften_formular' ) ) ) ) ); ?>
</div>

<?php if( auth()->user()->can( 'umfragen.verwaltung' ) ) echo
    view( 'Templates/modal', array( 'id' => 'umfrage_basiseigenschaften', 'modal' =>
    view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'umfragen' ), 'btn' => array( 'klasse_id' => 'btn_umfrage_aktion' ), 'formular' =>
    view( 'Umfragen/umfrage_basiseigenschaften_formular' ) ) ) ) ); ?>

<?= view( 'Templates/werkzeugkasten_handle', array( 'liste' => 'umfragen', 'element_id' => $element_id ) ); ?>
<?= $this->endSection() ?>