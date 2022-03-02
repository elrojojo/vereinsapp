<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo VEREINSAPP_NAME; ?></title>

    <?php foreach( HEAD_STYLESHEET as $stylesheet ): ?><link rel="stylesheet" href="<?php echo $stylesheet['href']; ?>"<?php if( array_key_exists( 'integrity', $stylesheet ) ) echo ' integrity="'.$stylesheet['integrity'].'"'; ?><?php if( array_key_exists( 'crossorigin', $stylesheet ) ) echo ' crossorigin="'.$stylesheet['crossorigin'].'"'; ?>>
    <?php endforeach; ?>

    <?php foreach( HEAD_SCRIPT as $script ):                         ?><script src="<?php echo $script['src']; ?>"<?php      if( array_key_exists( 'integrity', $script ) )     echo ' integrity="'.$script['integrity'].'"'; ?><?php     if( array_key_exists( 'crossorigin', $script ) )     echo ' crossorigin="'.$script['crossorigin'].'"';     ?>></script>
    <?php endforeach; ?>

    <style>
      body { padding-top: 70px; }
      .h5 { margin-bottom: 0px; }
      .stretched-link-unwirksam { z-index: 2; position: relative; }
      .invisible { display:none; }
      .nowrap { white-space: nowrap; }

      .btn { min-width: 40px; }
      .btn-sm { min-width: 30px; }
      .btn-lg { max-width: 50px; }
      .btn-autosize { min-width: 0px; }

      .list-group-liste_h5 { padding:15px; }

      .form-check-input-lg { transform: scale(1.5); -webkit-transform: scale(1.5); margin-right:10px; margin-left:3px; }
      .form-check-input-lg-ml { transform: scale(1.5); -webkit-transform: scale(1.5); margin-right:5px; margin-left:-16px; }

      .progress { height: 10px; }

      .second-sticky{ top: 70px; z-index: 95; }
      .filler-sticky { top: 0px; height: 70px; z-index: 90; }
      /*.filler { top: 57px; height: 13px; z-index: 90; }*/
    </style>

    <script>
    $(document).ready(function(){
      $('[data-toggle="popover"]').popover();

      $(".sortable").sortable({
        handle: "#sortable_aendern",
        start: function( event, ui ) {
          ui.item.addClass('border-top border-primary shadow');
        },
        stop: function( event, ui ) {
          ui.item.removeClass('border-top border-primary shadow');
        },
        update: function() { 
          $("#sortable_speichern").attr( 'disabled', false );
        }
      });
      
    } );

    $(window).on('beforeunload', function(){
      $(".navbar-brand").html('<span class="spinner-border text-secondary" style="width:30px;" role="status"><span class="sr-only">Loading...</span></span>');
    });

    </script>
    
  </head>
  <body onScroll="document.cookie='vereinsapp_scrollpos='+window.pageYOffset+'; expires=<?php echo 60*60*24; ?>; path=/';" onLoad='window.scrollTo(0,<?php echo SCROLLPOS; ?>)'>

    <?php if( array_key_exists( CONTROLLER, CONTROLLER_INT) ) { ?><nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
      <a class="navbar-brand" href="<?php echo site_url(); ?>" id="loader"><img class="title" src="/vereinsapp_images/title.png" style="width:30px;" /></a>
      <span class="navbar-text"><i class="bi-<?php echo CONTROLLER_INT[ CONTROLLER ]['symbol']; ?>"></i> <?php echo CONTROLLER_INT[ CONTROLLER ]['titel']; ?></span>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <?php foreach ( MENUE as $controller ): ?>
          <li class="nav-item<?php if ( CONTROLLER == $controller ) echo ' active'; ?>">
            <a class="nav-link" href="<?php echo site_url().$controller; ?>"><i class="bi-<?php echo CONTROLLER_INT[ $controller ]['symbol']; ?>"></i> <?php echo CONTROLLER_INT[ $controller ]['titel'] ?></a>
          </li>
          <?php endforeach; ?>
          <?php /* <li class="nav-item">
            <a class="nav-link" href="https://mv-schwarzach.de/vereinsapp_storage/manual/vereinsapp_erklaervideo_20210628.mp4"><i class="bi-film"></i> Erklärvideo</a>
          </li>*/ ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url(); ?>logout"><i class="bi-door-open"></i> Logout</a>
          </li>
        </ul>
      </div>
    </nav><?php }
    
    elseif( array_key_exists( CONTROLLER, CONTROLLER_EXT) ) { ?><nav class="navbar navbar-expand-md navbar-light fixed-top bg-light text-secondary">
      <div class="row no-gutters align-items-center"><div class="col-auto"><a class="navbar-brand" href="<?php echo site_url(); ?>"><img class="title" src="/vereinsapp_images/title.png" width="30" /></a></div><div class="col text-center"><?php echo VEREINSAPP_NAME; ?></div></div>
    </nav><?php } ?>

    <div class="container p-0">

    