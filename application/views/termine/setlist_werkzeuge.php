<div class="col-12 mb-3 text-right">
  <input type="text" class="invisible" name="termin_id" value="<?php echo $termin['id']; ?>" />
  <div class="btn-group">
    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#notenverzeichnis_auswaehlen" data-element_id="<?php echo $termin['id']; ?>" aria-expanded="false" aria-controls="notenverzeichnis_auswaehlen"><i class="bi bi-<?php echo $setlist_werkzeuge['auswaehlen_symbol']; ?>"></i></button>
    <button type="submit" class="btn btn-outline-success" id="sortable_speichern" disabled><i class="bi bi-<?php echo SYMBOLE['speichern']['bootstrap']; ?>"></i></button>
  </div>
</div>


