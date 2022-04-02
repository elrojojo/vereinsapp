<div class="col-12 fixed-top filler-sticky bg-white"></div>
<div class="col-12 mb-3 sticky-top second-sticky bg-white">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-white">
      <li class="breadcrumb-item">
        <a class="btn btn-outline-primary btn-sm" href="<?php echo site_url().'notenbank'; ?>">
          Notenbank
        </a>
      </li>
      <li class="breadcrumb-item<?php if( empty($pfad_array) ) echo ' active" aria-current="page'; ?>">
        <a class="btn btn-<?php if( !empty($pfad_array) ) echo 'outline-'; ?>primary btn-sm" href="<?php echo site_url().'notenbank/titel/'.$titel['id']; ?>">
          <?php echo $titel['titel_nr']; ?> <?php echo $titel['titel']; ?>
        </a>
      </li>
    <?php $pfad_foreach = ''; foreach( $pfad_array as $verzeichnisid => $verzeichnis ):
      $pfad_foreach = $pfad_foreach.'/'.$verzeichnis; ?>
      <li class="breadcrumb-item<?php if( $verzeichnisid == array_key_last($pfad_array) ) echo ' active" aria-current="page'; ?>">
        <a class="btn btn-<?php if( $verzeichnisid != array_key_last($pfad_array) ) echo 'outline-'; ?>primary btn-sm" href="<?php echo site_url().'notenbank/titel/'.$titel['id'].$pfad_foreach; ?>">
          <?php echo $verzeichnis; ?>
        </a>
      </li>
    <?php endforeach; ?>
    </ol>
  </nav>
</div>

