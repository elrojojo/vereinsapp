<div class="modal fade" id="<?php echo CONTROLLER; ?>_sortieren" tabindex="-1" aria-labelledby="<?php echo CONTROLLER; ?>_sortieren_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="<?php echo CONTROLLER; ?>_sortieren_label">Sortieren</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table m-0">
          <?php foreach ( $view['sortierbare_kategorien'] as $sortierbare_kategorie ):
            $aufsteigend = NULL; foreach( $sortieren as $prioritaet => $reihenfolge )
              if( $sortierbare_kategorie == $reihenfolge['kategorie'] ) {
                $prioritaet_real = $prioritaet+1;
                if( $reihenfolge['richtung'] == SORT_DESC ) $aufsteigend = FALSE; else $aufsteigend = TRUE;
              } ?><tr><td class="p-1 pl-2 border-0">
            <a class="<?php if( !is_null($aufsteigend) ) echo 'text-primary'; else echo 'text-body'; ?>" href="<?php echo site_url().CONTROLLER.'/sortieren'; if( !is_null($aufsteigend) ) echo '_umkehren'; echo '/'.$sortierbare_kategorie; ?>">
              <i class="bi bi-<?php if( !is_null($aufsteigend) ) echo SYMBOLE['haken']['bootstrap']; else echo SYMBOLE['kein_haken']['bootstrap']; ?>"></i> <?php
              echo $view['kategorien'][ $sortierbare_kategorie ]['beschriftung']; ?><?php if( !is_null($aufsteigend) ) { ?> <i class="bi bi-<?php if( $aufsteigend ) echo SYMBOLE['aufsteigend']['bootstrap']; else echo SYMBOLE['absteigend']['bootstrap']; ?>"></i><span class="small"><?php echo $prioritaet_real; ?></span><?php } ?>
            </a>
          </td>
          <td class="p-0 pr-1 border-0 text-right"><?php if( !is_null($aufsteigend) ) { if( count( $sortieren ) > 1 ) { ?>
            <a class="btn btn-sm btn-outline-danger" href="<?php echo site_url().CONTROLLER.'/sortieren_loeschen/'.$sortierbare_kategorie; ?>">
              <i class="bi bi-<?php echo SYMBOLE['loeschen']['bootstrap']; ?>"></i>
            </a><?php } }
            else { ?><a class="btn btn-sm btn-outline-primary" href="<?php echo site_url().CONTROLLER.'/sortieren_hinzu/'.$sortierbare_kategorie; ?>">
              <i class="bi bi-<?php echo SYMBOLE['hinzufuegen']['bootstrap']; ?>"></i>
            </a>
          <?php } ?></td></tr><?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</div>


