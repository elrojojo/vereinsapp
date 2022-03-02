<?php echo form_open( $austragen['form'] ); ?>
  <div class="modal fade" id="<?php echo $austragen['id']; ?>" tabindex="-1" aria-labelledby="<?php echo $austragen['id']; ?>_label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="<?php echo $austragen['id']; ?>_label"><div class="h5"><?php echo $austragen['titel']; ?> löschen</div></div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          Willst du <span id="<?php echo $austragen['id']; ?>_beschriftung">beschriftung</span> wirklich löschen?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
          <input type="text" class="invisible" name="element_id" id="<?php echo $austragen['id']; ?>_element_id" value="" />
          <button type="submit" class="btn btn-outline-danger">Löschen</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>

  $('#<?php echo $austragen['id']; ?>').on('show.bs.modal', function (event) {

<?php if( array_key_exists( 'elemente', $austragen ) AND !empty($austragen['elemente']) ){ ?>
    var <?php echo $austragen['id']; ?>_elemente = new Array();
<?php foreach( $austragen['elemente'] as $element_id => $element ): ?>
      <?php echo $austragen['id']; ?>_elemente[<?php echo $element_id; ?>] = new Object();
      <?php echo $austragen['id']; ?>_elemente[<?php echo $element_id; ?>]["beschriftung"] = "<?php echo $element['beschriftung']; ?>";
<?php endforeach; } ?>

    var modal = $(this);
    var button = $(event.relatedTarget) // Button that triggered the modal
    var element_id = button.data('element_id');

    modal.find('#<?php echo $austragen['id']; ?>_beschriftung').text( <?php echo $austragen['id']; ?>_elemente[element_id].beschriftung );
    modal.find('#<?php echo $austragen['id']; ?>_element_id').val( element_id );
  
  });

</script>

