<div class="modal fade" id="termin_personenkreis_beschraenken_Modal" tabindex="-1" aria-labelledby="termin_personenkreis_beschraenken_Modal_Label" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5" id="termin_personenkreis_beschraenken_Modal_Label">Personenkreis beschränken</div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="card mb-2">
          <div class="card-header h5">Personenkreis beschränkt auf</div>
          <ul class="card-body list-group personenkreis_beschraenken p-2">

            <li class="list-group-item list-group-item-action blanko invisible p-0"><div class="card border-0"><div class="row g-0">
              <div class="col-2 bg-light text-center" role="button">
                <div class="text-secondary small verknuepfung"></div>
                <i class="bi bi-<?= SYMBOLE['aendern']['bootstrap']; ?> btn_personenkreis_beschraenken_aendern text-primary"></i>
                <i class="bi bi-<?= SYMBOLE['loeschen']['bootstrap']; ?> btn_personenkreis_beschraenken_loeschen text-danger"></i>
              </div>
              <div class="col"><ul class="card-body list-group personenkreis_beschraenken_kind p-1">

                <li class="list-group-item list-group-item-action blanko invisible" role="button">
                  <span class="eigenschaft"></span> <span class="operator"></span> <span class="wert"></span><i class="bi bi-<?= SYMBOLE['loeschen']['bootstrap']; ?> btn_personenkreis_beschraenken_loeschen float-end ms-2 text-danger"></i>
                </li>

              </ul></div>
            </div></div></li>

          </ul>
        </div>

        <div class="accordion personenkreis_beschraenken_definitionen">

          <div class="accordion-item blanko invisible" data-typ="zeitpunkt">
            <div class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"></button>
            </div>
            <div class="accordion-collapse collapse">
              <div class="accordion-body input-group">
                <span class="input-group-text text-secondary"><i class="bi bi-<?= SYMBOLE['zeitraum']['bootstrap']; ?>"></i></span>
                <div class="form-floating">
                  <input type="date" class="form-control personenkreis_beschraenken_wert" data-operator=">=" />
                  <label>von</label>
                </div>
                <div class="form-floating">
                  <input type="date" class="form-control personenkreis_beschraenken_wert" data-operator="<=" />
                  <label>bis</label>
                </div>
                <button type="button" class="btn_personenkreis_beschraenken_erstellen btn btn-outline-success"><i class="bi bi-<?= SYMBOLE['erstellen']['bootstrap']; ?>"></i></button>
              </div>
            </div>
          </div>

          <div class="accordion-item blanko invisible" data-typ="zahl">
            <div class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"></button>
            </div>
            <div class="accordion-collapse collapse">
              <div class="accordion-body input-group">
                <span class="input-group-text text-secondary"><i class="bi bi-<?= SYMBOLE['zahlenraum']['bootstrap']; ?>"></i></span>
                <div class="form-floating">
                  <input type="number" class="form-control personenkreis_beschraenken_wert" data-operator=">=" />
                  <label>von</label>
                </div>
                <div class="form-floating">
                  <input type="number" class="form-control personenkreis_beschraenken_wert" data-operator="<=" />
                  <label>bis</label>
                </div>
                <button type="button" class="btn_personenkreis_beschraenken_erstellen btn btn-outline-success"><i class="bi bi-<?= SYMBOLE['erstellen']['bootstrap']; ?>"></i></button>
              </div>
            </div>
          </div>

          <div class="accordion-item blanko invisible" data-typ="vorgegebene_werte">
            <div class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"></button>
            </div>
            <div class="accordion-collapse collapse">
              <div class="accordion-body input-group">
                <select class="form-select personenkreis_beschraenken_wert" data-operator="==">
                </select>
                <button type="button" class="btn_personenkreis_beschraenken_erstellen btn btn-outline-success"><i class="bi bi-<?= SYMBOLE['erstellen']['bootstrap']; ?>"></i></button>
              </div>
            </div>
          </div>

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Schließen</button>
      </div>
    </div>
  </div>
</div>

