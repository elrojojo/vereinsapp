<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo VEREINSAPP_NAME; ?></title>

    <?php foreach( HEAD_STYLESHEET as $stylesheet ): ?><link rel="stylesheet" href="<?php echo $stylesheet['href']; ?>"<?php if( array_key_exists( 'integrity', $stylesheet ) ) echo ' integrity="'.$stylesheet['integrity'].'"'; ?><?php if( array_key_exists( 'crossorigin', $stylesheet ) ) echo ' crossorigin="'.$stylesheet['crossorigin'].'"'; ?>>
    <?php endforeach; ?>

    <?php foreach( HEAD_SCRIPT as $script ): ?><script src="<?php echo $script['src']; ?>"<?php if( array_key_exists( 'integrity', $script ) ) echo ' integrity="'.$script['integrity'].'"'; ?><?php if( array_key_exists( 'crossorigin', $script ) ) echo ' crossorigin="'.$script['crossorigin'].'"'; ?>></script>
<?php endforeach; ?>

    <script type='text/javascript'>
      const LOGIN_COOKIE_EXPIRE = <?php echo LOGIN_COOKIE_EXPIRE; ?>;
      const BASE_URL = '<?php echo BASE_URL; ?>';
      const CONTROLLER = '<?php echo CONTROLLER; ?>';
      const ABSPRUNG = '<?php echo ABSPRUNG; ?>';
      const COOKIES_RICHTLINIE_DATUM = '<?php echo COOKIES_RICHTLINIE_DATUM; ?>';
    </script>

  </head>
  <body>

    <?php if( array_key_exists( CONTROLLER, CONTROLLER_INT) ) { ?><nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
      <a class="navbar-brand" href="<?php echo site_url(); ?>"><img class="title" src="<?php echo base_url('images/title.png'); ?>" style="width:30px;" /></a>
      <span class="navbar-text"><?php echo CONTROLLER_INT[ CONTROLLER ]['titel']; ?><i class="bi-<?php echo CONTROLLER_INT[ CONTROLLER ]['symbol']; ?> float-left mr-1"></i><span id="status" class="float-right ml-1 text-success"><i class="bi-circle-fill"></i></span></span>
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
            <a class="nav-link" href="<?php echo base_url('storage/manual/vereinsapp_erklaervideo_20210628.mp4'); ?>"><i class="bi-film"></i> Erklärvideo</a>
          </li>*/ ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url(); ?>logout"><i class="bi-door-open"></i> Logout</a>
          </li>
        </ul>
      </div>
    </nav><?php }
    
    elseif( array_key_exists( CONTROLLER, CONTROLLER_EXT) ) { ?><nav class="navbar navbar-expand-md navbar-light fixed-top bg-light text-secondary">
      <div class="row no-gutters align-items-center"><div class="col-auto"><a class="navbar-brand" href="<?php echo site_url(); ?>"><img class="title" src="<?php echo base_url('images/title.png'); ?>" width="30" /></a></div><div class="col text-center"><?php echo VEREINSAPP_NAME; ?></div></div>
    </nav><?php } ?>

    <div class="container p-0">

