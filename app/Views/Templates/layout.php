<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <title><?= VEREINSAPP_NAME ?></title>

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

<?php if( isset( $werkzeugkasten ) ) echo view( 'Templates/werkzeugkasten' ); ?>

    <div class="text-secondary mt-5 small text-center"><?= VEREINSAPP_NAME ?> <?= VERSION; ?></div>
    <div class="text-secondary small text-center jetzt"></div>

    <div id="toasts" class="toast-container position-fixed end-0 pe-3">
        <?= view( 'Templates/toast' ); ?>
    </div>

    <div id="modals">
    <?= view( 'Templates/bestaetigung_modal' ); ?>
    <?= view( 'Templates/Liste/liste_filtern_modal' ); ?>
    <?= view( 'Templates/Liste/liste_sortieren_modal' ); ?>
    <?= view( 'Templates/Liste/liste_gruppieren_modal' ); ?>
    <?php if( auth()->loggedIn() && auth()->user()->requiresPasswordReset() ) echo view( 'Templates/modal', array( 'modal_id' => 'passwort_festlegen', 'modal_autoload' => TRUE,
            'modal_title' => 'Mein Passwort festlegen', 'modal_body' => view( 'Mitglieder/mitglied_passwort_festlegen_formular', array( 'data' => array( 'liste' => 'mitglieder', 'element_id' => ICH['id'] ), 'btn_beschriftung' => 'Neues Passwort festlegen' ) ) ) ); ?>
    </div>

  </body>
</html>