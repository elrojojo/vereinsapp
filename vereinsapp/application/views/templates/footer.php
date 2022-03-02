      <div class="row now-gutters p-2 align-items-end fixed-bottom">
        <div class="col">
          <?php foreach( $links as $link):
            ?><a class="btn btn-light btn-lg btn-outline-primary rounded-pill mr-1 shadow-lg" href="<?php echo $link['ziel']; ?>"><i class="bi bi-<?php echo $link['symbol']; ?>"></i></a>
          <?php endforeach; ?>
        </div>
        <div class="col text-right">
          <div class="btn-group shadow-lg" role="group" aria-label="werkzeugkasten_gruppe">
            <?php foreach( $werkzeugkasten as $werkzeug):

              if( array_key_exists( 'typ', $werkzeug ) AND $werkzeug['typ'] == 'dropdown' ){
          ?><div class="btn-group dropup">
              <button type="button" class="btn btn-light btn-outline<?php if( isset($werkzeug['farbe']) ) echo '-'.$werkzeug['farbe']; else echo '-primary'; ?>" id="<? echo $werkzeug['ziel']; ?>" data-toggle="dropdown" data-flip="false" aria-expanded="false"><i class="bi bi-<?php echo $werkzeug['symbol']; ?>"></i></button>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="<? echo $werkzeug['ziel']; ?>">
              
<?php echo $werkzeug['dropdown_inhalt']; ?>
              </div>
            </div><?php }
            else {
          ?><button type="button" class="btn btn-light btn-outline<?php if( isset($werkzeug['farbe']) ) echo '-'.$werkzeug['farbe']; else echo '-primary'; ?>" data-toggle="modal" data-target="#<?php echo $werkzeug['ziel']; ?>"<?php if( isset($werkzeug['data']) ) foreach( $werkzeug['data'] as $data_id => $data ) echo ' data-'.$data_id.'="'.$data.'"'; ?> aria-expanded="false" aria-controls="<?php echo $werkzeug['ziel']; ?>"><i class="bi bi-<?php echo $werkzeug['symbol']; ?>"></i></button>
            <?php } endforeach; ?>          
          </div>
        </div>
      </div>
    </div>

    

    <footer class="footer mt-5"><div class="container"><div class="row"><span class="text-secondary"><small><em><?php echo OFFIZIELLER_NAME ?> - Stand vom <?php echo date('d.m.Y H:i', time()); ?></em></small></span></div></div></footer>

<!--    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script> -->
<?php /*
    <!-- jQuery (wird für Bootstrap JavaScript-Plugins benötigt) --><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Binde alle kompilierten Plugins zusammen ein (wie hier unten) oder such dir einzelne Dateien nach Bedarf aus --><script src="/vereinsapp_css/bootstrap/js/bootstrap.min.js"></script>
    <!-- IE10-Anzeigefenster-Hack für Fehler auf Surface und Desktop-Windows-8 --><script src="/vereinsapp_css/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
    */ ?>



<div class="position-fixed" style="padding-right: 5px; padding-left: 5px; right: 0px; top: 70px; z-index: 99;">
  
  <?php foreach( $status_anzeigen_liste as $eigenschaften ):
    ?><?php echo $eigenschaften['view']; ?>
  <?php endforeach; ?>

</div>


<?php foreach( $modals_anzeigen_liste as $eigenschaften ):
  ?><?php echo $eigenschaften['view']; ?>
<?php endforeach; ?>


<script>
<?php foreach( $status_anzeigen_liste as $status => $eigenschaften ):
  ?>$('#status_<?php echo $status; ?>').toast('show');
<?php endforeach; ?>

<?php $vorheriges_modal = NULL; foreach( $modals_anzeigen_liste as $modal => $eigenschaften ):
  if( array_key_first( $modals_anzeigen_liste ) == $modal ) { ?>$('#<?php echo $modal; ?>').modal('show');
<?php } else { ?>$('#<?php echo $vorheriges_modal; ?>').on( 'hide.bs.modal', function (e) { $('#<?php echo $modal; ?>').modal('show'); } );
<?php } $vorheriges_modal = $modal; endforeach; ?>

</script>

  </body>
</html>

