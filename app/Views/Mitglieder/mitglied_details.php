<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-2 element" data-liste="mitglieder" data-element_id="<?= $element_id; ?>">
    <?= view( 'Templates/Liste/element_navigation', array( 'element_navigation' => $element_navigation ) ); ?>
    <div class="h5 beschriftung text-center">
        <span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span>
    </div>
    <div class="row row-cols-2 g-0">
      <div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['vorname']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="vorname"></span></div>
      <div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['nachname']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="nachname"></span></div>
      <?php if( auth()->user()->can( 'mitglieder.verwaltung' ) ) { ?><div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['email']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="email"></span></div><?php } ?>
      <div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['geburt']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="geburt"></span></div>
      <div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['alter']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="alter"></span></div>
      <div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['geschlecht']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="geschlecht"></span></div>
      <div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['postleitzahl']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="postleitzahl"></span></div>
      <div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['wohnort']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="wohnort"></span></div>
      <div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['register']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="register"></span></div>
      <div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['funktion']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="funktion"></span></div>
      <div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['vorstandschaft']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="vorstandschaft"></span></div>
      <div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['aktiv']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="aktiv"></span></div>
    </div>
</div>

<?php if( auth()->user()->can('mitglieder.verwaltung') ) { ?><?php /*<div class="container mb-2">
    <div class="ueberschrift text-secondary text-center invisible mb-1" data-instanz="abwesenheiten_des_mitglieds">Abwesenheiten</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['abwesenheiten_des_mitglieds'] ) ); ?>
<?= view( 'Mitglieder/abwesenheit_erstellen', array( 'mitglied_id' => $element_id ) ); ?>
</div> */ ?>

<?php if( auth()->user()->can('mitglieder.rechte') ) { ?><div class="container mb-2">
    <div class="ueberschrift text-secondary text-center invisible mb-1" data-instanz="verfuegbare_rechte">Rechte</div>
<?= view( 'Templates/Liste/checkliste', array( 'liste' => $liste['verfuegbare_rechte'], 'checkliste' => $checkliste['vergebene_rechte_des_mitglieds'] ) ); ?>
</div><?php } ?>

<div class="container mb-2">
    <div class="ueberschrift text-secondary text-center invisible mb-1" data-instanz="bevorstehende_termine">Termine</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['bevorstehende_termine'] ) ); ?>
</div>
<?= view( 'Termine/rueckmeldung_detaillieren_modal' ); ?>
<?php } ?>

<?= view( 'Templates/werkzeugkasten' ); ?>
<?= view( 'Templates/werkzeugkasten_handle', array( 'liste' => 'mitglieder', 'element_id' => $element_id ) ); ?>
<?php if( auth()->user()->can('mitglieder.verwaltung') ) echo view( 'Mitglieder/mitglied_erstellen_modal' ); ?>
<?php if( auth()->user()->can('mitglieder.verwaltung') ) echo view( 'Mitglieder/mitglied_einmal_link_anzeigen_modal' ); ?>
<?php if( auth()->user()->can('mitglieder.verwaltung') ) echo view( 'Mitglieder/mitglied_einmal_link_email_modal' ); ?>
<?php if( auth()->user()->can('mitglieder.verwaltung') ) echo view( 'Templates/Liste/loeschen_modal' ); ?>

<?= $this->endSection() ?>

