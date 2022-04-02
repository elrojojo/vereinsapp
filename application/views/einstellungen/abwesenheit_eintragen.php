<div class="col-12 mb-3">
  <?php echo form_open( site_url().'einstellungen/einstellungen_abwesenheit_eintragen' ) ; ?>
    <div class="input-group flex-nowrap">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="bi bi-<?php echo SYMBOLE['zeitraum']['bootstrap']; ?>"></i></span>
      </div>
      <input type="date" class="form-control" name="start" value="<?php echo html_date( HEUTE ); ?>" min="<?php echo html_date( time() ); ?>">
      <input type="date" class="form-control" name="ende" value="<?php echo html_date( MORGEN ); ?>" min="<?php echo html_date( time() ); ?>">
    </div>
    <div class="input-group flex-nowrap">
      <input type="text" class="form-control" placeholder="(Bemerkung optional)" name="bemerkung">
      <div class="input-group-append">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-<?php echo SYMBOLE['hinzufuegen']['bootstrap']; ?>"></i></button>
      </div>
    </div>
    <span class="form-text m-0 ml-1 text-secondary small">Abwesenheiten gelten jeweils bis 00:00 des Folgetages.</span>
    <input type="text" class="invisible" name="mitglied_id" value="<?php if( isset($mitglied['id']) ) echo $mitglied['id']; else echo ICH['id']; ?>" />
  </form>
</div>

