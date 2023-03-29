<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'werkzeugkasten' ); ?><?= view( 'Templates/werkzeugkasten' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-2 text-center element" data-element="termin" data-element_id="<?= $element_id; ?>">

    <div class="h5">
        <!-- <span class="float-start vorheriges_element"><i class="bi bi-arrow-left"></i></span> -->
        <span class="beschriftung"><span class="eigenschaft" data-eigenschaft="titel"></span></span>
        <!-- <span class="float-end naechstes_element"><i class="bi bi-arrow-right"></i></span> -->
    </div>
    <div class="row g-0 my-1">
        <div class="col text-nowrap"><i class="bi bi-calendar-event"></i> <span class="eigenschaft" data-eigenschaft="start"></span></div>
        <div class="col text-nowrap"><span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span></div>
        <div class="col text-nowrap"><i class="bi bi-geo-alt-fill"></i> <span class="eigenschaft" data-eigenschaft="ort"></span></div>
    </div>
    <div class="row g-0 my-1">
        <div class="col text-nowrap fst-italic"><span class="eigenschaft" data-eigenschaft="bemerkung"></span></div>
    </div>
    <?= view( 'Termine/rueckmeldung_erstellen' ); ?>

</div>

<div class="container mb-2">
<?= view( 'Templates/Liste/auswertungen', array( 'auswertungen' => $auswertungen[ 'auswertungen_termin_'.$element_id ] ) ); ?>
</div>

<?= view( 'Termine/rueckmeldung_detaillieren_modal' ); ?>
<?php if( auth()->user()->can('termine.verwaltung') ) echo view( 'Termine/termin_erstellen_modal' ); ?>
<?php if( auth()->user()->can('termine.verwaltung') ) echo view( 'Termine/termin_personenkreis_beschraenken_modal' ); ?>
<?php if( auth()->user()->can('termine.anwesenheiten') ) echo view( 'Termine/termin_anwesenheiten_modal', array( 'liste' => $liste['alle_aktiven'], 'check_liste' => $check_liste['anwesenheiten'] ) ); ?>
<?php //if( auth()->user()->can('termine.verwaltung') ) echo view( 'Templates/Liste/loeschen_modal' ); ?>

<?= $this->endSection() ?>

