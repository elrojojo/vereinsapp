<div id="status<?php if( isset($prioritaet) AND !is_null($prioritaet) ) echo '_'.$prioritaet; ?>" class="toast<?php if( isset($farbe) ) echo ' border-'.$farbe; ?>" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000"> <?php //  ?>
  <div class="toast-header<?php if( isset($farbe) ) echo ' text-'.$farbe; ?>">
    <?php print_r( $status ); ?>
    <button type="button" class="ml-2 mb-1 close <?php if( isset($farbe) ) echo ' text-'.$farbe; ?>" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</div>

