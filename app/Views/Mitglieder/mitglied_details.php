<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3 element" data-liste="mitglieder" data-element_id="<?= $element_id; ?>">
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
      <?php if( array_key_exists( 'register', EIGENSCHAFTEN['mitglieder'] ) ) { ?><div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['register']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="register"></span></div><?php } ?>
      <?php if( array_key_exists( 'auto', EIGENSCHAFTEN['mitglieder'] ) ) { ?><div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['auto']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="auto"></span></div><?php } ?>
      <?php if( array_key_exists( 'funktion', EIGENSCHAFTEN['mitglieder'] ) ) { ?><div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['funktion']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="funktion"></span></div><?php } ?>
      <?php if( array_key_exists( 'vorstandschaft', EIGENSCHAFTEN['mitglieder'] ) ) { ?><div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['vorstandschaft']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="vorstandschaft"></span></div><?php } ?>
      <?php if( array_key_exists( 'aktiv', EIGENSCHAFTEN['mitglieder'] ) ) { ?><div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['aktiv']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="aktiv"></span></div><?php } ?>
      <?php if( auth()->user()->can( 'mitglieder.verwaltung' ) ) { ?><div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['erstellung']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="erstellung"></span></div><?php } ?>
      <?php if( auth()->user()->can( 'mitglieder.verwaltung' ) ) { ?><div class="col-4 text-secondary small"><?= EIGENSCHAFTEN['mitglieder']['letzte_aktivitaet']['beschriftung']; ?>:</div><div class="col-8"><span class="eigenschaft" data-eigenschaft="letzte_aktivitaet"></span></div><?php } ?>
    </div>
</div>

<?php if( auth()->user()->can( 'mitglieder.verwaltung' ) ) { ?>
<?php if( auth()->user()->can( 'mitglieder.rechte' ) ) { ?><div class="container mb-3">
    <div class="ueberschrift text-secondary text-center invisible mb-1" data-instanz="rechte_vergeben">Rechte</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['rechte_vergeben'] ) ); ?>
</div><?php } ?>

<div class="container mb-3">
    <div class="ueberschrift text-secondary text-center invisible mb-1" data-instanz="bevorstehende_termine_mitglied">Termine</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['bevorstehende_termine_mitglied'] ) ); ?>
</div>
<div class="blanko_modals" data-liste="rueckmeldungen">
<?= view( 'Templates/modal', array( 'modal_id' => 'bemerkung', 'modal' =>
    view( 'Templates/formular', array( 'data' => array( 'liste' => 'rueckmeldungen' ), 'btn' => array( 'klasse_id' => 'btn_rueckmeldung_detaillieren' ), 'formular' =>
    view( 'Termine/rueckmeldung_bemerkung_formular' ) ) ) ) ); ?>
</div>
<?php } ?>

<?php if( array_key_exists( 'strafkatalog.verwaltung', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'strafkatalog.verwaltung' ) ) { ?><div class="container mb-3">
    <div class="text-secondary text-center mb-1">Offene Kassenbucheinträge</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['kassenbuch_offene_eintraege_mitglied'] ) ); ?>
</div><?php } ?>

<div class="blanko_modals" data-liste="mitglieder">
<?php if( auth()->user()->can( 'mitglieder.verwaltung' ) ) echo
        view( 'Templates/modal', array( 'modal_id' => 'basiseigenschaften', 'modal' =>
        view( 'Templates/formular', array( 'data' => array( 'liste' => 'mitglieder', 'aktion' => 'aendern' ), 'btn' => array( 'klasse_id' => 'btn_mitglied_aktion' ), 'formular' =>
        view( 'Mitglieder/mitglied_basiseigenschaften_formular' ) ) ) ) ); 
      elseif( $element_id == ICH['id'] ) echo
        view( 'Templates/modal', array( 'modal_id' => 'basiseigenschaften', 'modal' =>
        view( 'Templates/formular', array( 'data' => array( 'liste' => 'mitglieder', 'element_id' => ICH['id'] ), 'btn' => array( 'klasse_id' => 'btn_mitglied_aendern', 'beschriftung' => 'Meine Daten ändern' ), 'formular' =>
        view( 'Mitglieder/mitglied_basiseigenschaften_formular' ) ) ) ) ); ?>
<?php if( auth()->user()->can( 'mitglieder.verwaltung' ) ) echo
        view( 'Templates/modal', array( 'modal_id' => 'einmal_link_anzeigen', 'modal' =>
        view( 'Templates/formular', array( 'data' => array( 'liste' => 'mitglieder' ), 'btn' => array( 'klasse_id' => 'btn_mitglied_einmal_link_anzeigen', 'beschriftung' => 'Einmal-Link anzeigen' ), 'formular' =>
        view( 'Mitglieder/mitglied_einmal_link_anzeigen_formular' ) ) ) ) ); ?>
<?= view( 'Templates/Liste/liste_modal', array( 'liste' => $liste['anwesenheiten_dokumentieren'] ) ); ?>
</div>

<div class="blanko_modals" data-liste="strafkatalog">
<?php if( array_key_exists( 'strafkatalog.verwaltung', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'strafkatalog.verwaltung' ) ) echo
        view( 'Templates/Liste/liste_modal', array( 'liste' => $liste['strafkatalog_auswahl'] ) ); ?>
</div>

<?= view( 'Templates/werkzeugkasten_handle', array( 'liste' => 'mitglieder', 'element_id' => $element_id ) ); ?>
<?= $this->endSection() ?>