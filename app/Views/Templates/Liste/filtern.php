<div class="filtern_formular">

    <div class="card mb-3">
        <div class="h5 card-header">Aktive Filter</div>
        <ul class="card-body list-group filtern p-2">

            <li class="list-group-item list-group-item-action blanko filtern_sammlung invisible p-0"><div class="card border-0"><div class="row g-0">
                <div class="col-2 bg-light text-center" role="button">
                    <div class="text-secondary small verknuepfung"></div>
                    <i class="bi bi-<?= SYMBOLE['aendern']['bootstrap']; ?> btn_filtern_aendern text-primary"></i>
                    <i class="bi bi-<?= SYMBOLE['loeschen']['bootstrap']; ?> btn_filtern_loeschen text-danger"></i>
                </div>
                <div class="col"><ul class="card-body list-group filtern_kind p-1">

                    <li class="list-group-item list-group-item-action blanko filtern_element invisible" role="button">
                        <span class="eigenschaft"></span> <span class="operator"></span> <span class="wert"></span><i class="bi bi-<?= SYMBOLE['loeschen']['bootstrap']; ?> btn_filtern_loeschen float-end ms-2 text-danger"></i>
                    </li>

                </ul></div>
            </div></div></li>

        </ul>
    </div>

    <div class="filtern_definitionen">

        <div class="input-group blanko filtern_definition invisible mb-1" data-typ="zeitpunkt">
            <span class="input-group-text"><i class="bi bi-<?= SYMBOLE['zeitraum']['bootstrap']; ?>"></i></span>
            <div class="form-floating">
                <input type="date" class="form-control filtern_wert" data-operator=">=" />
                <label><span class="beschriftung"></span> von</label>
            </div>
            <div class="form-floating">
                <input type="date" class="form-control filtern_wert" data-operator="<=" />
                <label><span class="beschriftung"></span> bis</label>
            </div>
            <button type="button" class="btn_filtern_erstellen btn btn-outline-success"><i class="bi bi-<?= SYMBOLE['erstellen']['bootstrap']; ?>"></i></button>
        </div>

        <div class="input-group blanko filtern_definition invisible mb-1" data-typ="zahl">
            <span class="input-group-text"><i class="bi bi-<?= SYMBOLE['zahlenraum']['bootstrap']; ?>"></i></span>
            <div class="form-floating">
                <input type="number" class="form-control filtern_wert" data-operator=">=" />
                <label><span class="beschriftung"></span> von</label>
            </div>
            <div class="form-floating">
                <input type="number" class="form-control filtern_wert" data-operator="<=" />
                <label><span class="beschriftung"></span> bis</label>
            </div>
            <button type="button" class="btn_filtern_erstellen btn btn-outline-success"><i class="bi bi-<?= SYMBOLE['erstellen']['bootstrap']; ?>"></i></button>
        </div>

        <div class="input-group blanko filtern_definition invisible mb-1" data-typ="vorgegebene_werte">
            <div class="form-floating">
                <select class="form-select filtern_wert" data-operator="==">
                </select>
                <label><span class="beschriftung"></span></label>
            </div>
            <button type="button" class="btn_filtern_erstellen btn btn-outline-success"><i class="bi bi-<?= SYMBOLE['erstellen']['bootstrap']; ?>"></i></button>
        </div>

    </div>

</div>