<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <title><?= VEREINSAPP_NAME; ?></title>

    <?php foreach( HEAD_STYLESHEET as $stylesheet ): ?><link rel="stylesheet" href="<?= $stylesheet['href']; ?>"<?php if( array_key_exists( 'integrity', $stylesheet ) ) echo ' integrity="'.$stylesheet['integrity'].'"'; ?><?php if( array_key_exists( 'crossorigin', $stylesheet ) ) echo ' crossorigin="'.$stylesheet['crossorigin'].'"'; ?>>
    <?php endforeach; ?>

    <script type='text/javascript'>
<?= view( 'Templates/javascript' ); ?>
    </script>

    <?php foreach( HEAD_SCRIPT as $script ): ?><script src="<?= $script['src']; ?>"<?php if( array_key_exists( 'integrity', $script ) ) echo ' integrity="'.$script['integrity'].'"'; ?><?php if( array_key_exists( 'crossorigin', $script ) ) echo ' crossorigin="'.$script['crossorigin'].'"'; ?>></script>
    <?php endforeach; ?>

  </head>

  <body>
    <?= $this->renderSection('navbar') ?>
    
    <?= $this->renderSection('containers') ?>

    <?php /* ÜBERARBEITEN
    <div class="row g-0 p-2 align-items-end fixed-bottom">
      <div class="col">
        <?php if( isset($links) ) foreach( $links as $link):
          ?><a class="btn btn-light btn-lg btn-outline-primary rounded-pill me-1 shadow-lg" href="<?= $link['ziel']; ?>"><i class="bi bi-<?= $link['symbol']; ?>"></i></a>
        <?php endforeach; ?>
      </div>
      <div class="col text-right">
        <div class="btn-group shadow-lg" role="group" aria-label="werkzeugkasten_gruppe">
          <?php if( isset($werkzeugkasten) ) foreach( $werkzeugkasten as $werkzeug):

            if( array_key_exists( 'typ', $werkzeug ) AND $werkzeug['typ'] == 'dropdown' ){
        ?><div class="btn-group dropup">
            <button type="button" class="btn btn-light btn-outline<?php if( isset($werkzeug['farbe']) ) echo '-'.$werkzeug['farbe']; else echo '-primary'; ?>" id="<?= $werkzeug['ziel']; ?>" data-toggle="dropdown" data-flip="false" aria-expanded="false"><i class="bi bi-<?= $werkzeug['symbol']; ?>"></i></button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="<?= $werkzeug['ziel']; ?>">
            
<?= $werkzeug['dropdown_inhalt']; ?>
            </div>
          </div><?php }
          else {
        ?><button type="button" class="btn btn-light btn-outline<?php if( isset($werkzeug['farbe']) ) echo '-'.$werkzeug['farbe']; else echo '-primary'; ?>" data-toggle="modal" data-target="#<?= $werkzeug['ziel']; ?>"<?php if( isset($werkzeug['data']) ) foreach( $werkzeug['data'] as $data_id => $data ) echo ' data-'.$data_id.'="'.$data.'"'; ?> aria-expanded="false" aria-controls="<?= $werkzeug['ziel']; ?>"><i class="bi bi-<?= $werkzeug['symbol']; ?>"></i></button>
          <?php } endforeach; ?>          
        </div>
      </div>
    </div> */ ?>

    <div class="text-secondary mt-5 small"><?= OFFIZIELLER_NAME ?> - Stand vom <?= date('d.m.Y H:i', time()); ?></div>

    <input type="hidden" id="csrf_hash" value="<?= csrf_hash() ?>" />

    <div id="status_anzeigen_liste" class="position-fixed" style="padding-right: 5px; padding-left: 5px; right: 0px; top: 70px; z-index: 99;">
      <?php /* muss überarbeitet werden? foreach( $status_anzeigen_liste as $eigenschaften ):
        ?><?= $eigenschaften['view']; ?>
      <?php endforeach; */ ?>
    </div>

    <div id="modals_anzeigen_liste">
      <?php /* muss überarbeitet werden? foreach( $modals_anzeigen_liste as $eigenschaften ):
        ?><?= $eigenschaften['view']; ?>
      <?php endforeach; */ ?>
    </div>

    <?= $this->renderSection('werkzeugkasten') ?>

    <script>

    <?php /* muss überarbeitet werden?
    foreach( $status_anzeigen_liste as $status => $eigenschaften ):
      ?>$('#status_<?= $status; ?>').toast('show');
    <?php endforeach; */ ?>

    <?php  /* muss überarbeitet werden?
    $vorheriges_modal = NULL; foreach( $modals_anzeigen_liste as $modal => $eigenschaften ):
      if( array_key_first( $modals_anzeigen_liste ) == $modal ) { ?>$('#<?= $modal; ?>').modal('show');
    <?php } else { ?>$('#<?= $vorheriges_modal; ?>').on( 'hide.bs.modal', function (e) { $('#<?= $modal; ?>').modal('show'); } );
    <?php } $vorheriges_modal = $modal; endforeach; */ ?>

    </script>

  </body>
</html>