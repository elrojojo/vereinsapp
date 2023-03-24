<?= $this->section('navbar') ?>

<nav class="navbar navbar-expand-md fixed-top navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= site_url(); ?>"><img class="title" src="<?= base_url('images/title.png'); ?>" style="width:30px;" /></a>
        <span class="navbar-text"><?= CONTROLLERS[ CONTROLLER ]['titel']; ?><i class="bi-<?= CONTROLLERS[ CONTROLLER ]['symbol']; ?> float-start me-1"></i><span id="status" class="float-end ms-1 text-success"><i class="bi-circle-fill"></i></span></span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <?php foreach ( MENUE as $controller ): ?>
                <li class="nav-item">
                    <a class="nav-link<?php if ( CONTROLLER == $controller ) echo ' active'; ?>" href="<?= site_url().$controller; ?>">
                        <i class="bi-<?= CONTROLLERS[ $controller ]['symbol']; ?> float-start me-1"></i>
                        <?= CONTROLLERS[ $controller ]['titel'] ?>
                    </a>
                </li>
                <?php endforeach; ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url(); ?>logout">
                        <i class="bi-door-open float-start me-1"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?= $this->endSection() ?>
