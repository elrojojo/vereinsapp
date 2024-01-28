<?= $this->section('navbar') ?>

<nav class="navbar navbar-expand-md fixed-top navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= site_url(); ?>"><img class="title" src="<?= config('vereinsapp')->vereinsapp_logo; ?>" style="width:30px;" /></a>
        <span class="navbar-text"><?= config('Vereinsapp')->controllers[ AKTIVER_CONTROLLER ]['beschriftung']; ?><i class="bi-<?= config('Vereinsapp')->controllers[ AKTIVER_CONTROLLER ]['symbol']; ?> float-start me-1"></i><span id="status" class="float-end ms-1 text-success"><i class="bi-circle-fill"></i></span></span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <?php foreach ( config('Vereinsapp')->menue as $controller ): ?>
                <li class="nav-item">
                    <a class="nav-link<?php if ( AKTIVER_CONTROLLER == $controller ) echo ' active'; ?>" href="<?= site_url().$controller; ?>">
                        <i class="bi-<?= config('Vereinsapp')->controllers[ $controller ]['symbol']; ?> float-start me-1"></i>
                        <?= config('Vereinsapp')->controllers[ $controller ]['beschriftung'] ?>
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
