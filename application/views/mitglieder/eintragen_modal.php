<?php if( isset( $eintragen['form']) ) echo form_open( $eintragen['form'] ); ?>
  <div class="modal fade" id="mitglied_eintragen" tabindex="-1" aria-labelledby="mitglied_eintragen_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mitglied_eintragen_label">titel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <div class="form-group mb-2">
            <label class="small m-0 ml-1" for="mitglied_eintragen_vorname"><?php echo MITGLIEDER_KATEGORIEN['vorname']['beschriftung']; ?>:</label>
            <input type="text" class="form-control" name="vorname" id="mitglied_eintragen_vorname" value="" />
          </div>

          <div class="form-group mb-2">
            <label class="small m-0 ml-1" for="mitglied_eintragen_nachname"><?php echo MITGLIEDER_KATEGORIEN['nachname']['beschriftung']; ?>:</label>
            <input type="text" class="form-control" name="nachname" id="mitglied_eintragen_nachname" value="" />
          </div>

          <div class="form-group form-row mb-2">
            <div class="col">
              <label class="small m-0 ml-1" for="mitglied_eintragen_geburt"><?php echo MITGLIEDER_KATEGORIEN['geburt']['beschriftung']; ?>:</label>
              <input type="date" class="form-control" name="geburt" id="mitglied_eintragen_geburt" value="<?php echo html_date( HEUTE ); ?>" />
            </div>
            <div class="col">
              <label class="small m-0 ml-1" for="mitglied_eintragen_geschlecht"><?php echo MITGLIEDER_KATEGORIEN['geschlecht']['beschriftung']; ?>:</label>
              <select class="form-control" name="geschlecht" id="mitglied_eintragen_geschlecht">
              <?php  foreach ( VORGEGEBENE_WERTE['mitglieder']['geschlecht'] as $geschlecht => $eigenschaften ): ?>
                <option value="<?php echo $geschlecht; ?>"><?php echo $eigenschaften['beschriftung']; ?></option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-group mb-2">
            <label class="small m-0 ml-1" for="mitglied_eintragen_email"><?php echo MITGLIEDER_KATEGORIEN['email']['beschriftung']; ?>:</label>
            <input type="email" class="form-control" name="email" id="mitglied_eintragen_email" value="" />
          </div>

          <?php if( array_key_exists( 'adresse', MITGLIEDER_KATEGORIEN ) ) { ?><div class="form-group mb-2">
            <label class="small m-0 ml-1" for="mitglied_eintragen_adresse"><?php echo MITGLIEDER_KATEGORIEN['adresse']['beschriftung']; ?>:</label>
            <input type="text" class="form-control" name="adresse" id="mitglied_eintragen_adresse" value="" />
          </div><?php } ?>

          <?php if( array_key_exists( 'postleitzahl', MITGLIEDER_KATEGORIEN ) OR array_key_exists( 'wohnort', MITGLIEDER_KATEGORIEN ) ) { ?><div class="form-group form-row mb-2">
            <?php if( array_key_exists( 'postleitzahl', MITGLIEDER_KATEGORIEN ) ) { ?><div class="col-4">
              <label class="small m-0 ml-1" for="mitglied_eintragen_postleitzahl"><?php echo MITGLIEDER_KATEGORIEN['postleitzahl']['beschriftung']; ?>:</label>
              <input type="number" class="form-control" name="postleitzahl" id="mitglied_eintragen_postleitzahl" value="" min="10000" max="99999" />
            </div><?php } ?>
            <?php if( array_key_exists( 'wohnort', MITGLIEDER_KATEGORIEN ) ) { ?><div class="col-8">
              <label class="small m-0 ml-1" for="mitglied_eintragen_wohnort"><?php echo MITGLIEDER_KATEGORIEN['wohnort']['beschriftung']; ?>:</label>
              <input type="text" class="form-control" name="wohnort" id="mitglied_eintragen_wohnort" value="" />
            </div><?php } ?>
          </div><?php } ?>

          <?php if( array_key_exists( 'register', MITGLIEDER_KATEGORIEN ) ) { ?><div class="form-group mb-2">
            <label class="small m-0 ml-1" for="mitglied_eintragen_register"><?php echo MITGLIEDER_KATEGORIEN['register']['beschriftung']; ?>:</label>
            <select class="form-control" name="register" id="mitglied_eintragen_register">
            <?php  foreach ( VORGEGEBENE_WERTE['mitglieder']['register'] as $register => $eigenschaften ): ?>
              <option value="<?php echo $register; ?>"><?php echo $eigenschaften['beschriftung']; ?></option>
            <?php endforeach; ?>
            </select>
          </div><?php } ?>

          <?php if( array_key_exists( 'funktion', MITGLIEDER_KATEGORIEN ) ) { ?><div class="form-group mb-2">
            <label class="small m-0 ml-1" for="mitglied_eintragen_funktion"><?php echo MITGLIEDER_KATEGORIEN['funktion']['beschriftung']; ?>:</label>
            <select class="form-control" name="funktion" id="mitglied_eintragen_funktion">
            <?php  foreach ( VORGEGEBENE_WERTE['mitglieder']['funktion'] as $funktion => $eigenschaften ): ?>
              <option value="<?php echo $funktion; ?>"><?php echo $eigenschaften['beschriftung']; ?></option>
            <?php endforeach; ?>
            </select>
          </div><?php } ?>

          <?php if( array_key_exists( 'vorstandschaft', MITGLIEDER_KATEGORIEN ) OR array_key_exists( 'aktiv', MITGLIEDER_KATEGORIEN ) ) { ?><div class="form-group form-row mb-2">
            <?php if( array_key_exists( 'vorstandschaft', MITGLIEDER_KATEGORIEN ) ) { ?><div class="col">
              <label class="small m-0 ml-1" for="mitglied_eintragen_vorstandschaft"><?php echo MITGLIEDER_KATEGORIEN['vorstandschaft']['beschriftung']; ?>:</label>
              <select class="form-control" name="vorstandschaft" id="mitglied_eintragen_vorstandschaft">
              <?php  foreach ( VORGEGEBENE_WERTE['mitglieder']['vorstandschaft'] as $vorstandschaft => $eigenschaften ): ?>
                <option value="<?php echo $vorstandschaft; ?>"><?php echo $eigenschaften['beschriftung']; ?></option>
              <?php endforeach; ?>
              </select>
            </div><?php } ?>
            <?php if( array_key_exists( 'aktiv', MITGLIEDER_KATEGORIEN ) ) { ?><div class="col">
              <label class="small m-0 ml-1" for="mitglied_eintragen_aktiv"><?php echo MITGLIEDER_KATEGORIEN['aktiv']['beschriftung']; ?>:</label>
              <select class="form-control" name="aktiv" id="mitglied_eintragen_aktiv">
              <?php  foreach ( VORGEGEBENE_WERTE['mitglieder']['aktiv'] as $aktiv => $eigenschaften ): ?>
                <option value="<?php echo $aktiv; ?>"><?php echo $eigenschaften['beschriftung']; ?></option>
              <?php endforeach; ?>
              </select>
            </div><?php } ?>
          </div><?php } ?>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
          <input type="text" class="invisible" name="mitglied_id" id="mitglied_eintragen_mitglied_id" value="" />
          <button type="submit" class="btn btn-outline-success" id="mitglied_eintragen_submit">submit</button>
        </div>
      </div>
    </div>
  </div>
<?php if( isset( $eintragen['form']) ) echo '</form>'; ?>

<script>

  $('#mitglied_eintragen').on('show.bs.modal', function (event) {

    var mitglied_eintragen_titel = new Object();
<?php foreach( $eintragen['titel'] as $aktion => $titel ): ?>
      mitglied_eintragen_titel["<?php echo $aktion; ?>"] = "<?php echo $titel; ?>";
<?php endforeach; ?>

    var mitglied_eintragen_submit = new Object();
<?php foreach( $eintragen['submit'] as $aktion => $submit ): ?>
      mitglied_eintragen_submit["<?php echo $aktion; ?>"] = "<?php echo $submit; ?>";
<?php endforeach; ?>

<?php if( array_key_exists( 'mitglieder', $eintragen ) AND !empty($eintragen['mitglieder']) ){ ?>
    var mitglied_eintragen_mitglieder = new Array();
<?php foreach( $eintragen['mitglieder'] as $mitglied_id => $mitglied ): ?>
      mitglied_eintragen_mitglieder[<?php echo $mitglied_id; ?>] = new Object();
      mitglied_eintragen_mitglieder[<?php echo $mitglied_id; ?>]["vorname"] = "<?php echo $mitglied['vorname']; ?>";
      mitglied_eintragen_mitglieder[<?php echo $mitglied_id; ?>]["nachname"] = "<?php echo $mitglied['nachname']; ?>";
      mitglied_eintragen_mitglieder[<?php echo $mitglied_id; ?>]["geburt"] = "<?php echo html_date( intval($mitglied['geburt']) ); ?>";
      mitglied_eintragen_mitglieder[<?php echo $mitglied_id; ?>]["geschlecht"] = "<?php echo $mitglied['geschlecht']; ?>";
      mitglied_eintragen_mitglieder[<?php echo $mitglied_id; ?>]["email"] = "<?php echo $mitglied['email']; ?>";
      <?php if( array_key_exists( 'adresse', MITGLIEDER_KATEGORIEN ) ) { ?>mitglied_eintragen_mitglieder[<?php echo $mitglied_id; ?>]["adresse"] = "<?php echo $mitglied['adresse']; ?>";<?php } ?>
      <?php if( array_key_exists( 'postleitzahl', MITGLIEDER_KATEGORIEN ) ) { ?>mitglied_eintragen_mitglieder[<?php echo $mitglied_id; ?>]["postleitzahl"] = "<?php echo $mitglied['postleitzahl']; ?>";<?php } ?>
      <?php if( array_key_exists( 'wohnort', MITGLIEDER_KATEGORIEN ) ) { ?>mitglied_eintragen_mitglieder[<?php echo $mitglied_id; ?>]["wohnort"] = "<?php echo $mitglied['wohnort']; ?>";<?php } ?>
      <?php if( array_key_exists( 'register', MITGLIEDER_KATEGORIEN ) ) { ?>mitglied_eintragen_mitglieder[<?php echo $mitglied_id; ?>]["register"] = "<?php echo $mitglied['register']; ?>";<?php } ?>
      <?php if( array_key_exists( 'funktion', MITGLIEDER_KATEGORIEN ) ) { ?>mitglied_eintragen_mitglieder[<?php echo $mitglied_id; ?>]["funktion"] = "<?php echo $mitglied['funktion']; ?>";<?php } ?>
      <?php if( array_key_exists( 'vorstandschaft', MITGLIEDER_KATEGORIEN ) ) { ?>mitglied_eintragen_mitglieder[<?php echo $mitglied_id; ?>]["vorstandschaft"] = "<?php echo $mitglied['vorstandschaft']; ?>";<?php } ?>
      <?php if( array_key_exists( 'aktiv', MITGLIEDER_KATEGORIEN ) ) { ?>mitglied_eintragen_mitglieder[<?php echo $mitglied_id; ?>]["aktiv"] = "<?php echo $mitglied['aktiv']; ?>";<?php } ?>
<?php endforeach; } ?>

    var modal = $(this);
    var button = $(event.relatedTarget) // Button that triggered the modal
    var aktion = button.data('aktion');

    modal.find('.modal-title').text( mitglied_eintragen_titel[aktion] );
    //modal.find('.modal-title span[name=bemerkung]').text( mitglied_auswaehlen_bemerkungen[element_id] );

    if( button.data('mitglied_id') !== undefined ) {
      var mitglied_id = button.data('mitglied_id');
      modal.find('#mitglied_eintragen_vorname').val( mitglied_eintragen_mitglieder[mitglied_id].vorname );
      modal.find('#mitglied_eintragen_nachname').val( mitglied_eintragen_mitglieder[mitglied_id].nachname );
      modal.find('#mitglied_eintragen_geburt').val( mitglied_eintragen_mitglieder[mitglied_id].geburt );
      modal.find("#mitglied_eintragen_geschlecht").val( mitglied_eintragen_mitglieder[mitglied_id].geschlecht ).change();
      modal.find('#mitglied_eintragen_email').val( mitglied_eintragen_mitglieder[mitglied_id].email );
      <?php if( array_key_exists( 'adresse', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find('#mitglied_eintragen_adresse').val( mitglied_eintragen_mitglieder[mitglied_id].adresse );<?php } ?>
      <?php if( array_key_exists( 'postleitzahl', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find('#mitglied_eintragen_postleitzahl').val( mitglied_eintragen_mitglieder[mitglied_id].postleitzahl );<?php } ?>
      <?php if( array_key_exists( 'wohnort', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find('#mitglied_eintragen_wohnort').val( mitglied_eintragen_mitglieder[mitglied_id].wohnort );<?php } ?>
      <?php if( array_key_exists( 'register', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find("#mitglied_eintragen_register").val( mitglied_eintragen_mitglieder[mitglied_id].register ).change();<?php } ?>
      <?php if( array_key_exists( 'funktion', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find("#mitglied_eintragen_funktion").val( mitglied_eintragen_mitglieder[mitglied_id].funktion ).change();<?php } ?>
      <?php if( array_key_exists( 'vorstandschaft', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find("#mitglied_eintragen_vorstandschaft").val( mitglied_eintragen_mitglieder[mitglied_id].vorstandschaft ).change();<?php } ?>
      <?php if( array_key_exists( 'aktiv', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find("#mitglied_eintragen_aktiv").val( mitglied_eintragen_mitglieder[mitglied_id].aktiv ).change();<?php } ?>
      if( aktion == "aendern" ) modal.find('#mitglied_eintragen_mitglied_id').val( mitglied_id ); else modal.find('#mitglied_eintragen_mitglied_id').val( "" );
    } else { 
      modal.find('#mitglied_eintragen_vorname').val( "" );
      modal.find('#mitglied_eintragen_nachname').val( "" );
      modal.find('#mitglied_eintragen_geburt').val( "" );
      modal.find("#mitglied_eintragen_geschlecht").val( "d" ).change();
      modal.find('#mitglied_eintragen_email').val( "" );
      <?php if( array_key_exists( 'adresse', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find('#mitglied_eintragen_adresse').val( "" );<?php } ?>
      <?php if( array_key_exists( 'postleitzahl', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find('#mitglied_eintragen_postleitzahl').val( "" );<?php } ?>
      <?php if( array_key_exists( 'wohnort', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find('#mitglied_eintragen_wohnort').val( "" );<?php } ?>
      <?php if( array_key_exists( 'register', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find("#mitglied_eintragen_register").val( "" ).change();<?php } ?>
      <?php if( array_key_exists( 'funktion', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find("#mitglied_eintragen_funktion").val( "" ).change();<?php } ?>
      <?php if( array_key_exists( 'vorstandschaft', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find("#mitglied_eintragen_vorstandschaft").val( "0" ).change();<?php } ?>
      <?php if( array_key_exists( 'aktiv', MITGLIEDER_KATEGORIEN ) ) { ?>modal.find("#mitglied_eintragen_aktiv").val( "1" ).change();<?php } ?>
      modal.find('#mitglied_eintragen_mitglied_id').val( "" );
    }
    modal.find('#mitglied_eintragen_submit').text( mitglied_eintragen_submit[aktion] );

  });

</script>

