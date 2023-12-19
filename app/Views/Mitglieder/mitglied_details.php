<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'werkzeugkasten' ); ?><?= view( 'Templates/werkzeugkasten' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-2 element" data-element="mitglied" data-element_id="<?= $element_id; ?>">
    <div class="h5 text-center">
        <span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span>
    </div>
    <div class="row row-cols-2 g-0">
      <div class="col-4 text-secondary small">Vorname:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="vorname"></span></div>
      <div class="col-4 text-secondary small">Nachname:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="nachname"></span></div>
      <div class="col-4 text-secondary small">Geboren am:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="geburt"></span></div>
      <div class="col-4 text-secondary small">Alter:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="alter"></span></div>
      <div class="col-4 text-secondary small">Geschlecht:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="geschlecht"></span></div>
      <div class="col-4 text-secondary small">Postleitzahl:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="postleitzahl"></span></div>
      <div class="col-4 text-secondary small">Wohnort:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="wohnort"></span></div>
      <div class="col-4 text-secondary small">Instrument:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="register"></span></div>
      <div class="col-4 text-secondary small">Funktion:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="funktion"></span></div>
      <div class="col-4 text-secondary small">Vorstandschaft:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="vorstandschaft"></span></div>
      <div class="col-4 text-secondary small">Aktiv:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="aktiv"></span></div>
    </div>
</div>

<?php if( auth()->user()->can('mitglieder.verwaltung') ) { ?><div class="container mb-2">
    <div class="ueberschrift text-secondary text-center invisible mb-1" data-instanz="abwesenheiten_des_mitglieds">Abwesenheiten</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['abwesenheiten_des_mitglieds'] ) ); ?>
<?= view( 'Mitglieder/abwesenheit_erstellen', array( 'element_id' => $element_id ) ); ?>
</div>

<?php if( auth()->user()->can('mitglieder.rechte') ) { ?><div class="container mb-2">
    <div class="ueberschrift text-secondary text-center invisible mb-1" data-instanz="rechte">Rechte</div>
<?= view( 'Mitglieder/permissions', array( 'liste' => array( 'id' => 'rechte', 'beschriftung' => array( 'beschriftung' => '', ) ), 'checkliste' => $checkliste['rechte'] ) ); ?>
</div><?php } ?>
<?php } ?>

<div class="container mb-2">
<?//= view( 'Mitglieder/rueckmeldung_erstellen' ); ?>
</div>

<?php if( auth()->user()->can('mitglieder.verwaltung') ) echo view( 'Mitglieder/mitglied_erstellen_modal' ); ?>
<?php if( auth()->user()->can('mitglieder.verwaltung') ) echo view( 'Templates/Liste/loeschen_modal' ); ?>

<?= $this->endSection() ?>

