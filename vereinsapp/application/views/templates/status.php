<div class="col-md-12"><div class="alert alert-<?php echo $farbe; ?><?php if( isset($dismissible) AND $dismissible ) echo ' alert-dismissible fade show'; ?>" role="alert">
  <?php print_r( $status ); ?>
  <?php if( isset($dismissible) AND $dismissible ) { ?><button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button><?php } ?>
</div></div>