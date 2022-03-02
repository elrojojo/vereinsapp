<div class="col-12 fixed-top filler-sticky bg-white"></div>
<div class="col-12 pb-3 sticky-top second-sticky bg-white">
  <div class="row no-gutters">
    <div class="col-auto text-left mb-1">
      <a class="h5 text<?php if( !$vorheriges_mitglied ) echo '-secondary disabled'; else echo '-primary' ?> mr-1"<?php if( $vorheriges_mitglied ) echo ' href="'.site_url().'mitglieder/'.METHOD.'/'.$vorheriges_mitglied['id'].'"'; ?>>
        <i class="bi bi-arrow-left"></i>
      </a>
    </div>
    <div class="col text-center">
      <div class="h5"><?php echo $mitglied['vorname']; ?> <?php echo $mitglied['nachname']; ?>
        <span><?php echo $details['float_right']; ?></span>
        </div>
    </div>
    <div class="col-auto text-right mb-1">
      <a class="h5 text<?php if( !$naechstes_mitglied ) echo '-secondary disabled'; else echo '-primary' ?> ml-1"<?php if( $naechstes_mitglied ) echo ' href="'.site_url().'mitglieder/'.METHOD.'/'.$naechstes_mitglied['id'].'"'; ?>>
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>
  </div>
</div>

