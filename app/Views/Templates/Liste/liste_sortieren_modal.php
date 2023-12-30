<div class="modal fade" id="liste_sortieren_Modal" tabindex="-1" aria-labelledby="liste_sortieren_Modal_Label" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5" id="liste_sortieren_Modal_Label"></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="card mb-2">
          <div class="card-header h5">Aktive Sortierungen</div>
          <ul class="card-body list-group sortieren p-2">

            <li class="list-group-item list-group-item-action blanko invisible" role="button">
              <i class="bi btn_sortieren_richtung richtung float-start me-2 text-primary"></i></span> <span class="eigenschaft"></span><i class="bi bi-<?= SYMBOLE['loeschen']['bootstrap']; ?> btn_sortieren_loeschen float-end ms-2 text-danger"></i>
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
        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Schließen</button>
      </div>
    </div>
  </div>
</div>

