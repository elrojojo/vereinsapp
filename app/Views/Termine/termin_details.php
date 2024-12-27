<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3 element" data-liste="termine" data-element_id="<?= $element_id; ?>">
<?= view( 'Templates/Liste/element_navigation', array( 'element_navigation' => $element_navigation ) ); ?>
    <div class="h5 beschriftung text-center"><span class="eigenschaft" data-eigenschaft="titel"></span></div>
    <div class="row g-0 my-1">
        <div class="col text-center text-nowrap"><i class="bi bi-<?= SYMBOLE["termine"]["bootstrap"]; ?>"></i> <span class="eigenschaft" data-eigenschaft="start"></span></div>
        <div class="col text-center text-nowrap"><span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span></div>
        <div class="col text-center text-nowrap"><i class="bi bi-<?= SYMBOLE["ort"]["bootstrap"]; ?>"></i> <span class="eigenschaft" data-eigenschaft="ort"></span></div>
    </div>
    <div class="row g-0 my-1">
        <div class="col text-center text-nowrap fst-italic"><span class="eigenschaft" data-eigenschaft="bemerkung"></span></div>
    </div>
<?= view( 'Termine/rueckmeldung_basiseigenschaften', array( 'mitglied_id' => ICH['id'] ) ); ?>
</div>

<div class="container mb-3">
    <ul class="nav nav-tabs">
        <li class="col-6 nav-item text-center" data-bs-target="#rueckmeldungen_container" role="button">
            <a class="nav-link active">Rückmeldungen</a>
        </li>
        <li class="col-6 nav-item collapsed text-center" data-bs-toggle="collapse" data-bs-target="#anwesenheiten_container" role="button">
            <a class="nav-link">Anwesenheiten</a>
        </li>
    </ul>
</div>

<div class="container rueckmeldungen_anwesenheiten_parent mb-3">
    <div id="rueckmeldungen_container" class="collapse tab_collapse show" data-bs-parent=".rueckmeldungen_anwesenheiten_parent">
<?= view( 'Templates/Liste/auswertungen', array( 'auswertungen' => $auswertungen['rueckmeldungen_termin'], 'view' => 'Termine/auswertung_rueckmeldungen' ) ); ?>
    </div>
    <div id="anwesenheiten_container" class="collapse tab_collapse" data-bs-parent=".rueckmeldungen_anwesenheiten_parent">
<?= view( 'Templates/Liste/auswertungen', array( 'auswertungen' => $auswertungen['anwesenheiten_termin'], 'view' => 'Termine/auswertung_anwesenheiten' ) ); ?>
    </div>
</div>

<div class="container mb-3">
    <div class="ueberschrift text-secondary text-center invisible mb-1" data-liste="aufgaben" data-instanz="zugeordnete_aufgaben">Zugeordnete Aufgaben</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['zugeordnete_aufgaben'] ) ); ?>
<?php if( array_key_exists( 'aufgaben.verwaltung', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'aufgaben.verwaltung' ) ) echo
    view( 'Templates/modal', array( 'id' => 'aufgaben_basiseigenschaften', 'modal' =>
    view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'aufgaben' ), 'btn' => array( 'klasse_id' => 'btn_aufgabe_aktion' ), 'formular' =>
    view( 'Aufgaben/aufgabe_basiseigenschaften_formular' ) ) ) ) ); ?>
</div>

<?= view( 'Templates/modal', array( 'id' => 'termine_anwesenheiten_dokumentieren', 'modal' =>
    view( 'Templates/Liste/liste', array( 'liste' => $liste['anwesenheiten_dokumentieren'] ) ) ) ); ?>
<?php if( auth()->user()->can( 'termine.verwaltung' ) ) echo
    view( 'Templates/modal', array( 'id' => 'termine_basiseigenschaften', 'modal' =>
    view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'termine' ), 'btn' => array( 'klasse_id' => 'btn_termin_aktion' ), 'formular' =>
    view( 'Termine/termin_basiseigenschaften_formular' ) ) ) ) ); ?>

<?= view( 'Templates/werkzeugkasten_handle', array( 'liste' => 'termine', 'element_id' => $element_id ) ); ?>
<?= $this->endSection() ?>