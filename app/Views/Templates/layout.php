<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <title><?= config('Vereinsapp')->vereinsapp_name; ?></title>

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

    <div class="text-secondary mt-5 small"><?= config('Vereinsapp')->verein_name; ?> - Stand vom <?= date('d.m.Y H:i', time()); ?></div>

    <div id="status_anzeigen_liste" class="position-fixed" style="padding-right: 5px; padding-left: 5px; right: 0px; top: 70px; z-index: 99;"></div>

    <div id="modals_anzeigen_liste"></div>

    <?= $this->renderSection('werkzeugkasten') ?>

  </body>
</html>