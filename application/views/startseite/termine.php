<div class="row no-gutters">
    <div class="col">
        <?php echo $termin['titel']; ?>
    </div>
    <div class="col-auto pr-1 text-right">
        <?php echo date( 'd.m. H:i', $termin['start'] ); ?>
    </div>
    <div class="col-auto text-right">
        <?php if( intval($termin['start']) >= HEUTE ) { ?> <a class="btn btn-sm btn-outline-primary" href="<?php echo site_url().'termine/details/'.$termin['id']; ?>"><i class="bi bi-three-dots"></i></a><?php } ?>
    </div>
</div>

