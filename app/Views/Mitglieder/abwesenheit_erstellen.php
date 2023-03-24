<div class="formular">

  <div class="input-group mb-1">
    <span class="input-group-text text-secondary"><i class="bi bi-<?= SYMBOLE['zeitraum']['bootstrap']; ?>"></i></span>
    <div class="form-floating">
      <input type="date" class="form-control eigenschaft" data-eigenschaft="start" placeholder="<?= EIGENSCHAFTEN['mitglieder']['abwesenheiten']['start']['beschriftung']; ?>" value="<?= EIGENSCHAFTEN['mitglieder']['abwesenheiten']['start']['standard']; ?>" />
      <label><?= EIGENSCHAFTEN['mitglieder']['abwesenheiten']['start']['beschriftung']; ?></label>
    </div>
    <div class="form-floating">
      <input type="date" class="form-control eigenschaft" data-eigenschaft="ende" placeholder="<?= EIGENSCHAFTEN['mitglieder']['abwesenheiten']['ende']['beschriftung']; ?>" value="<?= EIGENSCHAFTEN['mitglieder']['abwesenheiten']['ende']['standard']; ?>" />
      <label><?= EIGENSCHAFTEN['mitglieder']['abwesenheiten']['ende']['beschriftung']; ?></label>
    </div>
  </div>

  <div class="input-group mb-1">
    <div class="form-floating">
      <input type="text" class="form-control eigenschaft" data-eigenschaft="bemerkung" placeholder="Bemerkung" />
      <label>Bemerkung</label>
    </div>
    <button type="button" class="btn_element_erstellen btn btn-outline-success" data-element="abwesenheit" data-aktion="erstellen" data-werte='<?= json_encode( array( 'mitglied_id' => $element_id ), JSON_UNESCAPED_UNICODE ); ?>'><i class="bi bi-<?= SYMBOLE['erstellen']['bootstrap']; ?>"></i></button>
  </div>

  <?php // <span class="text-secondary small">Abwesenheiten gelten bis 00:00 des Folgetages.</span> ?>

</div>

