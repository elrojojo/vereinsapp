<div class="dropleft float-right" style="z-index: 10; position:relative;">
    <a class="h5 text-primary ml-1" id="liste_element_werkzeugkasten_<? echo $liste_element_werkzeugkasten['id']; ?>" role="button" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></a>
    <div class="dropdown-menu dropdown-menu-right bg-transparent border-0 p-0 text-right" aria-labelledby="liste_element_werkzeugkasten_<? echo $liste_element_werkzeugkasten['id']; ?>">
      <div class="btn-group shadow-lg" role="group" aria-label="werkzeugkasten_gruppe">
        <?php foreach( $liste_element_werkzeugkasten['werkzeugkasten'] as $werkzeug):
          ?><button type="button" class="btn btn-light btn-outline<?php if( isset($werkzeug['farbe']) ) echo '-'.$werkzeug['farbe']; else echo '-primary'; ?>" data-toggle="modal" data-target="#<?php echo $werkzeug['ziel']; ?>"<?php if( isset($werkzeug['data']) ) foreach( $werkzeug['data'] as $data_id => $data ) echo ' data-'.$data_id.'="'.$data.'"'; ?> aria-expanded="false" aria-controls="<?php echo $werkzeug['ziel']; ?>"><i class="bi bi-<?php echo $werkzeug['symbol']; ?>"></i></button>
        <?php endforeach; ?>          
      </div>
    </div>
  </div>

