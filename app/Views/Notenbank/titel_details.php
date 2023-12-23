<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'werkzeugkasten' ); ?><?= view( 'Templates/werkzeugkasten' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-2 text-center element" data-liste="notenbank" data-element_id="<?= $element_id; ?>">

    <div class="h5">
        <!-- <span class="float-start vorheriges_element"><i class="bi bi-arrow-left"></i></span> -->
        <span class="beschriftung"><span class="eigenschaft" data-eigenschaft="titel"></span></span>
        <!-- <span class="float-end naechstes_element"><i class="bi bi-arrow-right"></i></span> -->
    </div>

</div>

<?php if( auth()->user()->can('notenbank.verwaltung') ) echo view( 'Notenbank/titel_erstellen_modal' ); ?>
<?php if( auth()->user()->can('notenbank.verwaltung') ) echo view( 'Templates/Liste/liste_filtern_modal' ); ?>
<?php if( auth()->user()->can('notenbank.verwaltung') ) echo view( 'Templates/Liste/liste_sortieren_modal' ); ?>
<?php //if( auth()->user()->can('notenbank.verwaltung') ) echo view( 'Templates/Liste/loeschen_modal' ); ?>

<?= $this->endSection() ?>

