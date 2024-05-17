<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-2 text-center element" data-liste="termine" data-element_id="<?= $element_id; ?>">
    <?= view( 'Templates/Liste/element_navigation', array( 'element_navigation' => $element_navigation ) ); ?>
    <div class="h5 beschriftung"><span class="eigenschaft" data-eigenschaft="titel"></span></div>
    <div class="row g-0 my-1">
        <div class="col text-nowrap"><i class="bi bi-calendar-event"></i> <span class="eigenschaft" data-eigenschaft="start"></span></div>
        <div class="col text-nowrap"><span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span></div>
        <div class="col text-nowrap"><i class="bi bi-geo-alt-fill"></i> <span class="eigenschaft" data-eigenschaft="ort"></span></div>
    </div>
    <div class="row g-0 my-1">
        <div class="col text-nowrap fst-italic"><span class="eigenschaft" data-eigenschaft="bemerkung"></span></div>
    </div>
    <?= view( 'Termine/rueckmeldung_basiseigenschaften', array( 'mitglied_id' => ICH['id'] ) ); ?>
</div>

<div class="container mb-2">
    <ul class="nav nav-tabs">
        <li class="col-6 nav-item text-center" data-bs-target="#rueckmeldungen_container" role="button">
            <a class="nav-link active">Rückmeldungen</a>
        </li>
        <li class="col-6 nav-item collapsed text-center" data-bs-toggle="collapse" data-bs-target="#anwesenheiten_container" role="button">
            <a class="nav-link">Anwesenheiten</a>
        </li>
    </ul>
</div>

<div class="container rueckmeldungen_anwesenheiten_parent mb-2">
    <div id="rueckmeldungen_container" class="collapse tab_collapse show" data-bs-parent=".rueckmeldungen_anwesenheiten_parent">
<?= view( 'Templates/Liste/auswertungen', array( 'auswertungen' => $auswertungen['rueckmeldungen_termin'], 'view' => 'Termine/auswertung_rueckmeldungen' ) ); ?>
    </div>
    <div id="anwesenheiten_container" class="collapse tab_collapse" data-bs-parent=".rueckmeldungen_anwesenheiten_parent">
<?= view( 'Templates/Liste/auswertungen', array( 'auswertungen' => $auswertungen['anwesenheiten_termin'], 'view' => 'Termine/auswertung_anwesenheiten' ) ); ?>
    </div>
</div>

<div class="blanko_modals" data-liste="termine">
<?php if( auth()->user()->can('termine.verwaltung') ) echo view( 'Termine/termin_basiseigenschaften_modal' ); ?>
</div>

<div class="blanko_modals" data-liste="mitglieder">
<?= view( 'Templates/Liste/checkliste_modal', array( 'liste' => $liste['anwesenheiten_dokumentieren'] ) ); ?>
</div>

<?= view( 'Templates/werkzeugkasten_handle', array( 'liste' => 'termine', 'element_id' => $element_id ) ); ?>
<?= $this->endSection() ?>

