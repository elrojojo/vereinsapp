const BASE_URL = '<?= base_url() ?>';
const CSRF_NAME = '<?= CSRF_NAME ?>';
const ERSTER_CSRF_HASH = '<?= csrf_hash() ?>';
const ICH = <?= json_encode( ICH ) ?>;

const SQL_TIME = '<?= SQL_TIME ?>';
const SQL_TIME_REGEX = <?= SQL_TIME_REGEX ?>;
const SQL_DATE = '<?= SQL_DATE ?>';
const SQL_DATE_REGEX = <?= SQL_DATE_REGEX ?>;
const SQL_DATETIME = '<?= SQL_DATETIME ?>';
const SQL_DATETIME_REGEX = <?= SQL_DATETIME_REGEX ?>;

const EIGENSCHAFTEN = <?= json_encode( EIGENSCHAFTEN ) ?>;
const SORTIERBARE_EIGENSCHAFTEN = <?= json_encode( SORTIERBARE_EIGENSCHAFTEN ) ?>;
const FILTERBARE_EIGENSCHAFTEN = <?= json_encode( FILTERBARE_EIGENSCHAFTEN ) ?>;
const VORGEGEBENE_WERTE = <?= json_encode( VORGEGEBENE_WERTE ) ?>;
const WOCHENTAGE_KURZ = <?= json_encode( WOCHENTAGE_KURZ ) ?>;
const WOCHENTAGE_LANG = <?= json_encode( WOCHENTAGE_LANG ) ?>;
const JANEIN = <?= json_encode( JANEIN ) ?>;

const AJAX_ZYKLUSZEIT = <?= config('Vereinsapp')->ajax_zykluszeit ?>;
const AJAX_ZUSTAND = Object.freeze({<?php foreach (AJAX_ZUSTAND::cases() as $ajax_zustand) { echo $ajax_zustand->name . ': Symbol("'.$ajax_zustand->name.'"), '; } ?>});

const DATENACHUTZ_RICHTLINIE_DATUM = '<?= config('Vereinsapp')->datenschutz_richtlinie_datum; ?>';

const SYMBOLE = <?= json_encode( SYMBOLE) ?>;
const SORT_ASC = <?= SORT_ASC ?>;
const SORT_DESC = <?= SORT_DESC ?>;