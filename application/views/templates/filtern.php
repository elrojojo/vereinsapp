<div class="modal fade" id="<?php echo CONTROLLER; ?>_filtern" tabindex="-1" aria-labelledby="<?php echo CONTROLLER; ?>_filtern_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="<?php echo CONTROLLER; ?>_filtern_label">Filtern</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table m-0">
          <?php foreach ( $view['filterbare_kategorien'] as $filterbare_kategorie => $filtertyp ):
          $filter_wert = NULL; foreach( $filtern as $filter ) if( $filterbare_kategorie == $filter['kategorie'] ) $filter_wert = $filter['filter'];
          $filter = $filter_wert; ?><tr><td class="p-1 border-0 align-middle">
            <span class="<?php if( !is_null($filter) ) echo 'text-primary'; else echo 'text-body'; ?>">
              <i class="bi bi-<?php if( !is_null($filter) ) echo SYMBOLE['haken']['bootstrap']; else echo SYMBOLE['kein_haken']['bootstrap']; ?>"></i> <?php
              echo $view['kategorien'][ $filterbare_kategorie ]['beschriftung']; ?>
            </span>
          </td>
          <td class="p-1 border-0 text-right"><?php if( !is_null($filter) ) { ?>
            <a class="btn btn-sm btn-outline-danger" href="<?php echo site_url().CONTROLLER.'/filtern_loeschen/'.$filterbare_kategorie; ?>">
              <i class="bi bi-<?php echo SYMBOLE['loeschen']['bootstrap']; ?>"></i>
            </a>
          <?php } ?></td></tr>
          <tr><td class="p-1 border-left-0 border-top-0 border-right-0 border-bottom" colspan=2>
            <?php if( in_array( $filtertyp, array( 'anfangsbuchstabe', ) ) ) {
              foreach( range( 'A', 'Z' ) as $anfangsbuchstabe ): ?><a class="btn btn-sm btn<?php if( is_null($filter) OR lcfirst($filter) != lcfirst($anfangsbuchstabe) ) echo '-outline'; ?>-primary" href="<?php echo site_url().CONTROLLER.'/filtern_hinzu/'.$filterbare_kategorie.'/'.$anfangsbuchstabe; ?>">
              <?php echo $anfangsbuchstabe; ?>
            </a><?php endforeach; }
            elseif( in_array( $filtertyp, array( 'verfuegbare_werte', ) ) ) {
              ?><?php echo form_open( site_url().CONTROLLER.'/filtern_hinzu/'.$filterbare_kategorie ); ?><div class="input-group flex-nowrap">
              <select class="form-control" name="<?php echo $filterbare_kategorie; ?>_filter1">
              <?php foreach ( verfuegbare_werte_in_spalte( array_column( $view['objekte'], $filterbare_kategorie ) ) as $wert ): ?>
                <option value="<?php echo $wert; ?>"<?php if ( $wert == $filter_wert ) echo ' selected'; ?>><?php if( array_key_exists( $filterbare_kategorie, VORGEGEBENE_WERTE[ CONTROLLER] ) ) echo VORGEGEBENE_WERTE[ CONTROLLER][ $filterbare_kategorie ][ $wert ]['beschriftung']; else echo $wert; ?></option>
              <?php endforeach; ?>
              </select>
              <button type="submit" class="btn btn-outline-primary"><i class="bi bi-<?php echo SYMBOLE['hinzufuegen']['bootstrap']; ?>"></i></button>
            </div></form><?php }
            elseif( in_array( $filtertyp, array( 'zeitraum', 'zeitraum_jahr', ) ) ) {
              ?><?php echo form_open( site_url().CONTROLLER.'/filtern_hinzu/'.$filterbare_kategorie ); ?><div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-<?php echo SYMBOLE['zeitraum']['bootstrap']; ?>"></i></span>
              </div>
              <input type="datetime-local" class="form-control" name="<?php echo $filterbare_kategorie; ?>_filter1" value="<?php if( !is_null($filter) ) echo html_datetime_local( $filter['start'] ); else echo html_datetime_local( HEUTE ); ?>"<?php if( in_array( $filtertyp, array( 'zeitraum_jahr', ) ) ) echo ' min="'.html_datetime_local( HEUTE-(SEK_PRO_JAHR/2) ).'" max="'.html_datetime_local( MORGEN+(SEK_PRO_JAHR/2) ).'"'; ?>>
              <input type="datetime-local" class="form-control" name="<?php echo $filterbare_kategorie; ?>_filter2" value="<?php if( !is_null($filter) ) echo html_datetime_local( $filter['ende'] ); else echo html_datetime_local( MORGEN ); ?>"<?php if( in_array( $filtertyp, array( 'zeitraum_jahr', ) ) ) echo ' min="'.html_datetime_local( HEUTE-(SEK_PRO_JAHR/2) ).'" max="'.html_datetime_local( MORGEN+(SEK_PRO_JAHR/2) ).'"'; ?>>
              <button type="submit" class="btn btn-outline-primary"><i class="bi bi-<?php echo SYMBOLE['hinzufuegen']['bootstrap']; ?>"></i></button>
              </div></form><?php }
            elseif( in_array( $filtertyp, array( 'zahlenraum', ) ) ) {
              ?><?php echo form_open( site_url().CONTROLLER.'/filtern_hinzu/'.$filterbare_kategorie ); ?><div class="input-group">
              <input type="number" class="form-control" name="<?php echo $filterbare_kategorie; ?>_filter1" value="<?php if( !is_null($filter) ) echo $filter['start']; else echo 0; ?>">
              <input type="number" class="form-control" name="<?php echo $filterbare_kategorie; ?>_filter2" value="<?php if( !is_null($filter) ) echo $filter['ende']; else echo 0; ?>">
              <button type="submit" class="btn btn-outline-primary"><i class="bi bi-<?php echo SYMBOLE['hinzufuegen']['bootstrap']; ?>"></i></button>
            </div></form><?php } ?>
          </td></tr><?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</div>

