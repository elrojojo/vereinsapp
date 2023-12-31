<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<head>
    <meta name="x-apple-disable-message-reformatting">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= config('Vereinsapp')->vereinsapp_name; ?> - Einmal-Link</title>
</head>

<body>
    Hallo, für deinen Zugang zur <?= config('Vereinsapp')->vereinsapp_name; ?> hast du einen Einmal-Link angefordert. Du kannst diesen Einmal-Link sofort benutzen um dich in der <?= config('Vereinsapp')->vereinsapp_name; ?> einzuloggen: 

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important;">
        <tbody>
            <tr>
                <td style="line-height: 24px; font-size: 16px; border-radius: 6px; margin: 0; width:200px; height: 50px;" align="center" bgcolor="#0d6efd">
                    <a href="<?= url_to('verify-magic-link') ?>?token=<?= $token ?>" style="color: #ffffff; font-size: 16px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; border-radius: 6px; line-height: 20px; display: inline-block; font-weight: normal; white-space: nowrap; background-color: #0d6efd; padding: 8px 12px; border: 1px solid #0d6efd;">Einmal-Link verwenden</a>
                </td>
            </tr>
        </tbody>
    </table>

    Viele Grüße,<br>
    <?= config('Vereinsapp')->verein_name; ?>

    <i><?= esc($ipAddress) ?> / <?= esc($userAgent) ?> / <?= esc($date) ?></i>
</body>

</html>
