<div class="row no-gutters">
    <div class="col">
        <?php echo $geburtstagskind['vorname']; ?> <?php echo $geburtstagskind['nachname'][0]; ?>.
    </div>
    <div class="col-auto text-right">
        <?php echo date( 'd.m.', $geburtstagskind['geburtstag'] ); ?> (<?php echo floor( ( intval($geburtstagskind['geburtstag']) - intval($geburtstagskind['geburt']) ) / SEK_PRO_JAHR ); ?>) <?php echo '&#127873'; ?>
    </div>
</div>

