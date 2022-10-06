<li class="list-group-item">
  <?php echo $titel['titel_nr']; ?> <?php echo $titel['titel']; ?>
  <input type="text" class="invisible position" name="positionen[<?php echo $setlist_titel['id']; ?>]" value="<?php echo intval($setlist_titel['position']); ?>" />
  <?php if( in_array( '-t', ICH['rechte'] ) ) { ?><i class="bi bi-arrow-down-up text-primary float-right" id="sortable_setlist_aendern"></i><?php } ?>
</li>

