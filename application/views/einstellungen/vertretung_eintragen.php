<div class="col-12 mb-3">
  <?php echo form_open( site_url().'einstellungen/einstellungen_vertretung_eintragen' ); ?>
    <select class="form-control" name="recht">
    <?php  foreach( RECHTE as $recht => $recht_meta ): if( $recht_meta['veraenderbar'] AND in_array( $recht, ICH['rechte_db'] ) ) { ?>
      <option value="<?php echo $recht; ?>"><?php echo $recht_meta['beschriftung']; ?></option>
    <?php } endforeach; ?>
    </select>
    <div class="input-group flex-nowrap">
      <select class="form-control" name="vertretung_id">
      <?php  foreach ( MITGLIEDER as $mitglied ): ?>
        <option value="<?php echo $mitglied['id']; ?>"<?php if ( $mitglied['id'] == ICH['id'] ) echo ' selected'; ?>><?php echo $mitglied['vorname'].' '.$mitglied['nachname']; ?></option>
      <?php endforeach; ?>
      </select>
      <div class="input-group-append">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-<?php echo SYMBOLE['hinzufuegen']['bootstrap']; ?>"></i></button>
      </div>
    </div>
  </form>
</div>

