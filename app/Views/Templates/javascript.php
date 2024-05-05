const BASE_URL = '<?= base_url() ?>';
const AKTIVER_CONTROLLER = '<?= AKTIVER_CONTROLLER ?>';
const CSRF_NAME = '<?= CSRF_NAME ?>';
const ERSTER_CSRF_HASH = '<?= csrf_hash() ?>';
const ICH = <?= json_encode( ICH ) ?>;
LOGGEDIN = <?php if( auth()->loggedIn() ) echo (int) TRUE; else echo (int) FALSE; ?>;
FORCE_LOCALSTORAGE_RESET_ZEITPUNKT = '<?= config('Vereinsapp')->force_localstorage_reset_zeitpunkt; ?>';

const JANEIN = <?= json_encode( JANEIN ) ?>;
const WOCHENTAGE_KURZ = <?= json_encode( WOCHENTAGE_KURZ ) ?>;
const WOCHENTAGE_LANG = <?= json_encode( WOCHENTAGE_LANG ) ?>;

const EIGENSCHAFTEN = <?= json_encode( EIGENSCHAFTEN ) ?>;
const VORGEGEBENE_WERTE = <?= json_encode( VORGEGEBENE_WERTE ) ?>;

const SORTIERBARE_EIGENSCHAFTEN = <?= json_encode( config('Vereinsapp')->sortierbare_eigenschaften ) ?>;
const FILTERBARE_EIGENSCHAFTEN = <?= json_encode( config('Vereinsapp')->filterbare_eigenschaften ) ?>;

const TERMINE_KATEGORIE_FILTERN_MITGLIEDER = <?= json_encode( config('Vereinsapp')->termine_kategorie_filtern_mitglieder ) ?>;

const NOTENVERZEICHNIS_ERLAUBTE_DATEITYPEN_NOTEN = <?= json_encode( config('Vereinsapp')->notenbank_erlaubte_dateitypen_noten ) ?>;
const NOTENVERZEICHNIS_ERLAUBTE_DATEITYPEN_AUDIO = <?= json_encode( config('Vereinsapp')->notenbank_erlaubte_dateitypen_audio ) ?>;

const AJAX_ZYKLUSZEIT = <?= config('Vereinsapp')->ajax_zykluszeit ?>;
const AJAX_ZUSTAND = Object.freeze({<?php foreach (AJAX_ZUSTAND::cases() as $ajax_zustand) { echo $ajax_zustand->name . ': Symbol("'.$ajax_zustand->name.'"), '; } ?>});

const DATENACHUTZ_RICHTLINIE_DATUM = '<?= config('Vereinsapp')->datenschutz_richtlinie_datum; ?>';

const SYMBOLE = <?= json_encode( SYMBOLE) ?>;
const SORT_ASC = <?= SORT_ASC ?>;
const SORT_DESC = <?= SORT_DESC ?>;