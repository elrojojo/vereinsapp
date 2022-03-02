<li class="list-group-item">
  <div class="input-group flex-nowrap">
    <input class="form-check-input-lg" type="checkbox" value="<?php echo $login_erlaubt; ?>" name="login_erlaubt[]" id="<?php echo $login_erlaubt; ?>" onclick="this.form.submit();"<?php
    if( !is_null(ICH['login_erlaubt']) AND in_array( $login_erlaubt, ICH['login_erlaubt'] ) ) echo ' checked'; ?> />
    <label class="form-check-label" for="<?php echo $login_erlaubt; ?>"><?php echo $eigenschaften['beschriftung']; ?></label>
  </div>
  <?php if( array_key_exists( 'bemerkung', $eigenschaften ) ) { ?><span class="small"><?php echo $eigenschaften['bemerkung']; ?></span><?php } ?>
  <input type="text" class="invisible" name="mitglied_id" value="<?php echo ICH['id']; ?>" />
</li>

