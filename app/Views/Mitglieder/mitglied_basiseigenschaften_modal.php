<div class="blanko invisible fade" id="basiseigenschaften" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5"></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

      <div class="form-floating mb-2">
        <input type="text" class="form-control eigenschaft" data-eigenschaft="vorname" placeholder="<?= EIGENSCHAFTEN['mitglieder']['vorname']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['mitglieder']['vorname']['beschriftung']; ?></label>
      </div>

      <div class="form-floating mb-2">
        <input type="text" class="form-control eigenschaft" data-eigenschaft="nachname" placeholder="<?= EIGENSCHAFTEN['mitglieder']['nachname']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['mitglieder']['nachname']['beschriftung']; ?></label>
      </div>

      <div class="row g-2">
        <div class="col form-floating mb-2">
          <input type="date" class="form-control eigenschaft" data-eigenschaft="geburt" />
          <label><?= EIGENSCHAFTEN['mitglieder']['geburt']['beschriftung']; ?></label>
        </div>
        <div class="col form-floating mb-2">
          <select class="form-select eigenschaft" data-eigenschaft="geschlecht">
          <?php foreach ( VORGEGEBENE_WERTE['mitglieder']['geschlecht'] as $geschlecht => $eigenschaften ): ?>
            <option value="<?= $geschlecht; ?>"><?= $eigenschaften['beschriftung']; ?></option>
          <?php endforeach; ?>
          </select>
          <label><?= EIGENSCHAFTEN['mitglieder']['geschlecht']['beschriftung']; ?></label>
        </div>
      </div>

      <div class="form-floating mb-2">
        <input type="email" class="form-control eigenschaft" data-eigenschaft="email" placeholder="<?= EIGENSCHAFTEN['mitglieder']['email']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['mitglieder']['email']['beschriftung']; ?></label>
      </div>

      <div class="row g-2">
        <div class="col-4 form-floating mb-2">
          <input type="number" class="form-control eigenschaft" data-eigenschaft="postleitzahl" placeholder="<?= EIGENSCHAFTEN['mitglieder']['postleitzahl']['beschriftung']; ?>" min="10000" max="99999" />
          <label><?= EIGENSCHAFTEN['mitglieder']['postleitzahl']['beschriftung']; ?></label>
        </div>
        <div class="col-8 form-floating mb-2">
          <input type="text" class="form-control eigenschaft" data-eigenschaft="wohnort" placeholder="<?= EIGENSCHAFTEN['mitglieder']['wohnort']['beschriftung']; ?>" />
          <label><?= EIGENSCHAFTEN['mitglieder']['wohnort']['beschriftung']; ?></label>
        </div>
      </div>

      <div class="form-floating mb-2">
        <select class="form-select eigenschaft" data-eigenschaft="register">
        <?php foreach ( VORGEGEBENE_WERTE['mitglieder']['register'] as $register => $eigenschaften ): ?>
          <option value="<?= $register; ?>"><?= $eigenschaften['beschriftung']; ?></option>
        <?php endforeach; ?>
        </select>
        <label><?= EIGENSCHAFTEN['mitglieder']['register']['beschriftung']; ?></label>
      </div>

      <div class="form-floating mb-2">
        <select class="form-select eigenschaft" data-eigenschaft="funktion">
        <?php foreach ( VORGEGEBENE_WERTE['mitglieder']['funktion'] as $funktion => $eigenschaften ): ?>
          <option value="<?= $funktion; ?>"><?= $eigenschaften['beschriftung']; ?></option>
        <?php endforeach; ?>
        </select>
        <label><?= EIGENSCHAFTEN['mitglieder']['funktion']['beschriftung']; ?></label>
      </div>

      <div class="row g-2">
        <div class="col form-floating mb-2">
          <select class="form-select eigenschaft" data-eigenschaft="vorstandschaft">
          <?php foreach ( VORGEGEBENE_WERTE['mitglieder']['vorstandschaft'] as $vorstandschaft => $eigenschaften ): ?>
            <option value="<?= $vorstandschaft; ?>"><?= $eigenschaften['beschriftung']; ?></option>
          <?php endforeach; ?>
          </select>
          <label><?= EIGENSCHAFTEN['mitglieder']['vorstandschaft']['beschriftung']; ?></label>
        </div>
        <div class="col form-floating mb-2">
          <select class="form-select eigenschaft" data-eigenschaft="aktiv">
          <?php foreach ( VORGEGEBENE_WERTE['mitglieder']['aktiv'] as $aktiv => $eigenschaften ): ?>
            <option value="<?= $aktiv; ?>"<?php if( $aktiv == 1 ) echo ' selected'; ?>><?= $eigenschaften['beschriftung']; ?></option>
          <?php endforeach; ?>
          </select>
          <label><?= EIGENSCHAFTEN['mitglieder']['aktiv']['beschriftung']; ?></label>
        </div>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn_mitglied_aktion btn btn-outline-success">Speichern</button>
      </div>
    </div>
  </div>
</div>

