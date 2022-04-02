<div class="col-md-6 mb-3">
  <div class="row row-cols-2 no-gutters">
    <div class="col-4 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['vorname']['beschriftung']; ?>:</div>
    <div class="col-8"><?php echo $mitglied['vorname']; ?></div>
    <div class="col-4 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['nachname']['beschriftung']; ?>:</div>
    <div class="col-8"><?php echo $mitglied['nachname']; ?></div>
    <div class="col-4 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['geburt']['beschriftung']; ?>:</div>
    <div class="col-8"><?php echo date( 'd.m.Y', $mitglied['geburt'] ); ?></div>
    <div class="col-4 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['alter']['beschriftung']; ?>:</div>
    <div class="col-8"><?php echo $mitglied['alter']; ?></div>
    <div class="col-4 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['geschlecht']['beschriftung']; ?>:</div>
    <div class="col-8"><?php echo VORGEGEBENE_WERTE['mitglieder']['geschlecht'][ $mitglied['geschlecht'] ]['beschriftung']; ?></div>
    <?php if( array_key_exists( 'adresse', MITGLIEDER_KATEGORIEN ) ) { ?><div class="col-4 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['adresse']['beschriftung']; ?>:</div>
    <div class="col-8"><?php echo $mitglied['adresse']; ?></div><?php } ?>
    <?php if( array_key_exists( 'postleitzahl', MITGLIEDER_KATEGORIEN ) ) { ?><div class="col-4 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['postleitzahl']['beschriftung']; ?>:</div>
    <div class="col-8"><?php echo $mitglied['postleitzahl']; ?></div><?php } ?>
    <?php if( array_key_exists( 'wohnort', MITGLIEDER_KATEGORIEN ) ) { ?><div class="col-4 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['wohnort']['beschriftung']; ?>:</div>
    <div class="col-8"><?php echo $mitglied['wohnort']; ?></div><?php } ?>
    <?php if( array_key_exists( 'register', MITGLIEDER_KATEGORIEN ) ) { ?><div class="col-4 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['register']['beschriftung']; ?>:</div>
    <div class="col-8"><?php echo VORGEGEBENE_WERTE['mitglieder']['register'][ $mitglied['register'] ]['beschriftung']; ?></div><?php } ?>
    <?php if( array_key_exists( 'funktion', MITGLIEDER_KATEGORIEN ) ) { ?><div class="col-4 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['funktion']['beschriftung']; ?>:</div>
    <div class="col-8"><?php echo VORGEGEBENE_WERTE['mitglieder']['funktion'][ $mitglied['funktion'] ]['beschriftung']; ?></div><?php } ?>
    <?php if( array_key_exists( 'vorstandschaft', MITGLIEDER_KATEGORIEN ) ) { ?><div class="col-4 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['vorstandschaft']['beschriftung']; ?>:</div>
    <div class="col-8"><?php echo VORGEGEBENE_WERTE['mitglieder']['vorstandschaft'][ $mitglied['vorstandschaft'] ]['beschriftung']; ?></div><?php } ?>
    <?php if( array_key_exists( 'aktiv', MITGLIEDER_KATEGORIEN ) ) { ?><div class="col-4 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['aktiv']['beschriftung']; ?>:</div>
    <div class="col-8"><?php echo VORGEGEBENE_WERTE['mitglieder']['aktiv'][ $mitglied['aktiv'] ]['beschriftung']; ?></div><?php } ?>
  </div>
</div>

