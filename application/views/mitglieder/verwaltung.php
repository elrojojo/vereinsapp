<div class="col-md-6 mb-3">
  <div class="row row-cols-2 no-gutters">
  <div class="col-4 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['email']['beschriftung']; ?>:</div>
    <div class="col-8"><?php echo $mitglied['email']; ?></div>
    <div class="col-7 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['loginversuche']['beschriftung']; ?>:</div>
    <div class="col-5"><?php if( intval($mitglied['loginversuche']) > 0 ) echo $mitglied['loginversuche']; else echo '<span class="text-danger">Zugang gesperrt!</span>'; ?></div>
    <div class="col-5 text-secondary small"><?php echo MITGLIEDER_KATEGORIEN['login_schluessel']['beschriftung']; ?>:</div>
    <div class="col-7"><?php if( !is_null($mitglied['login_schluessel']) AND $mitglied['login_schluessel_zeitpunkt']+max( LOGIN_EINMAL_LINK_EXPIRE, LOGIN_PASSWORT_VERGEBEN_EXPIRE, LOGIN_ZUGANG_ENTSPERREN_EXPIRE ) > time() ) echo '<span class="text-danger">aktiv <span class="small">(vom '.date( 'd.m.Y H:i', $mitglied['login_schluessel_zeitpunkt'] ).')</span></span>'; else echo '<span class="text-success">nicht aktiv</span>' ?></div>
  </div>
  <?php if( intval($mitglied['loginversuche']) == 0 ) { ?>
    <?php echo form_open( site_url().'mitglieder/zugang_entsperren' ) ; ?>
      <button type="submit" class="btn btn-block btn-outline-success">Zugang entsperren</button>
      <input type="text" class="invisible" name="mitglied_id" value="<?php echo $mitglied['id']; ?>" />
    </form>
  <?php } ?>
</div>

