<?= $this->extend( 'Templates/layout' ); ?>

<?= $this->section( 'werkzeugkasten' ); ?><?= view( 'Templates/werkzeugkasten' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-2 text-center">
    Der Status ist gut.
</div>

<?= $this->endSection() ?>

