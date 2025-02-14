MITGLIED_NAME <?php if( isset( $mitglied_name ) ) echo ' '.$mitglied_name; ?>
VEREINSAPP_NAME <?= VEREINSAPP_NAME ?>
VERIFY_MAGIC_LINK <?= url_to('verify-magic-link') ?>
TOKEN <?= $token ?>
VEREIN_NAME <?= VEREIN_NAME ?>
IP <?= esc($ipAddress) ?>
USERAGENT <?= esc($userAgent) ?>
DATE <?= esc($date) ?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
       /* Add custom classes and styles that you want inlined here */
    </style>
  </head>
  <body class="bg-light">

    <div class="container"><div class="card">
      <div class="card-body">
        <div class="mb-1">Hallo MITGLIED_NAME,</div>

        <div class="mb-3">
            für deinen Zugang zur VEREINSAPP_NAME hast du einen Einmal-Link bekommen.
            Du kannst diesen Einmal-Link sofort benutzen um dich in der VEREINSAPP_NAME einzuloggen:
        </div>
        <a href="VERIFY_MAGIC_LINK?token=TOKEN" class="btn btn-outline-primary mb-3">Einmal-Link verwenden</a>
        <div class="mb-1">Viele Grüße,</div>
        <div class="mb-1">VEREIN_NAME</div>
        <hr>
        <div class="mb-1 small text-secondary"><i>IP / USERAGENT / DATE</i></div>
        
      </div>
    </div></div>

  </body>
</html>
