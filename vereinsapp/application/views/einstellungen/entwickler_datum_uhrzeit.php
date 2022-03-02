<div class="col-12 mb-3">
  <?php echo form_open( site_url().'einstellungen/entwickler_datum_uhrzeit_generieren' ); ?>
    <div class="input-group flex-nowrap">
      <input type="number" class="form-control" name="zeitpunkt" value="<?php echo time(); ?>">
      <div class="input-group-append">
        <button type="submit" class="btn btn-outline-danger"><i class="bi bi-hourglass-split"></i></button>
      </div>
    </div>
  </form>
</div>

