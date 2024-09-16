<div class="formular" data-liste="mitglieder" data-element_id="<?= ICH['id'] ?>">

<?= view( 'Mitglieder/mitglied_basiseigenschaften_formular' ); ?>

    <div class="d-grid"><button type="button" class="btn btn_mitglied_aendern btn-outline-success" data-element_id="<?= ICH['id']; ?>"><i class="bi bi-<?= SYMBOLE['mitglied']['bootstrap']; ?>"></i> Meine Daten ändern</button></div>

</div>