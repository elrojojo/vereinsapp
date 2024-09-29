<div class="modal sortieren invisible fade" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title h5"></div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div class="card mb-3">
                    <div class="card-header h5">Aktive Sortierungen</div>
                    <ul class="card-body list-group sortieren p-2">

                        <li class="list-group-item list-group-item-action blanko invisible" role="button">
                            <i class="bi btn_sortieren_aendern richtung float-start me-2 text-primary"></i> <span class="eigenschaft"></span><i class="bi bi-<?= SYMBOLE['loeschen']['bootstrap']; ?> btn_sortieren_loeschen float-end ms-2 text-danger"></i>
                        </li>

                    </ul>
                </div>

                <div class="input-group sortieren_definitionen">
                    <select class="form-select sortieren_eigenschaft">
                    </select>
                    <input type="radio" class="btn-check sortieren_richtung" name="sortieren_richtung" id="sortieren_richtung_asc" value="<?= SORT_ASC; ?>" checked>
                    <label class="btn btn-outline-primary" for="sortieren_richtung_asc"><i class="bi bi-<?= SYMBOLE['asc']['bootstrap']; ?>"></i></label>
                    <input type="radio" class="btn-check sortieren_richtung" name="sortieren_richtung" id="sortieren_richtung_desc" value="<?= SORT_DESC; ?>">
                    <label class="btn btn-outline-primary" for="sortieren_richtung_desc"><i class="bi bi-<?= SYMBOLE['desc']['bootstrap']; ?>"></i></label>
                    <button type="button" class="btn_sortieren_erstellen btn btn-outline-success"><i class="bi bi-<?= SYMBOLE['erstellen']['bootstrap']; ?>"></i></button>
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Zurück</button>
            </div>
        </div>
    </div>
</div>

