<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use CodeIgniter\I18n\Time;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $router, $request, $validation, $session;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [
        'filesystem',
      ];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        $this->router = \Config\Services::router();
        $this->request  = \Config\Services::request();
        $this->validation  = \Config\Services::validation();
        $this->session = \Config\Services::session();

        if( str_contains( strtolower( (string) $this->request->getUserAgent() ), "whatsapp" ) ) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $verfuegbare_rechte = array(); $id = 1;
        foreach( config('AuthGroups')->permissions as $permission => $beschriftung ) {
            $verfuegbares_recht['id'] = $id;
            $verfuegbares_recht['permission'] = $permission;
            $verfuegbares_recht['beschriftung'] = $beschriftung;
            $verfuegbare_rechte[$permission] = $verfuegbares_recht;
            $id++;
        }
        defined('VERFUEGBARE_RECHTE') OR define( 'VERFUEGBARE_RECHTE', $verfuegbare_rechte );

        defined('EIGENSCHAFTEN') OR define( 'EIGENSCHAFTEN', config('Vereinsapp')->eigenschaften );
        defined('VORGEGEBENE_WERTE') OR define( 'VORGEGEBENE_WERTE', config('Vereinsapp')->vorgegebene_werte );

        defined('CSRF_NAME') OR define( 'CSRF_NAME', csrf_token() );

        defined('ICH') OR define( 'ICH', $this->session->user );

        defined('VERSION') OR define( 'VERSION', preg_replace('/\s+/', '', file_get_contents( ROOTPATH.'/README.md', FALSE, NULL, 13 ) ) );

        defined('JETZT') OR define( 'JETZT', Time::now('Europe/Berlin') );

        defined('AKTIVER_CONTROLLER') OR define( 'AKTIVER_CONTROLLER', lcfirst(
          explode( '\\', $this->router->controllerName() )[ array_key_last(
            explode( '\\', $this->router->controllerName() )
            ) ]
          ) );
        defined('METHOD') OR define( 'METHOD', $this->router->methodName() );

        defined('HEAD_STYLESHEET') OR define( 'HEAD_STYLESHEET', array( 
          array( 'href' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', 'integrity' => 'sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH', 'crossorigin' => 'anonymous', ),
          array( 'href' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css'),
          array( 'href' => base_url('css/vereinsapp.css?v='.VERSION), ),
        ) );
        $head_script = array();
        $head_script[] = array( 'src' => 'https://code.jquery.com/jquery-3.7.1.js', 'integrity' => 'sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=', 'crossorigin' => 'anonymous', );
        // $head_script[] = array( 'src' => 'https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.js', 'integrity' => 'sha256-1PYCpx/EXA36KN1NKrK7auaTylVyk01D98R7Ccf04Bc=', 'crossorigin' => 'anonymous', );
        $head_script[] = array( 'src' => 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', 'integrity' => 'sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=', 'crossorigin' => 'anonymous', );
        $head_script[] = array( 'src' => 'https://cdn.jsdelivr.net/npm/jquery-ui-touch-punch@0.2.3/jquery.ui.touch-punch.min.js', );
        $head_script[] = array( 'src' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', 'integrity' => 'sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz', 'crossorigin' => 'anonymous', );
        $head_script[] = array( 'src' => 'https://cdn.jsdelivr.net/npm/luxon@3.4.4/build/global/luxon.min.js', );
        $head_script[] = array( 'src' => 'https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js', );
        $head_script[] = array( 'src' => base_url('js/lib/sha256.min.js?v='.VERSION), ); // https://www.npmjs.com/package/js-sha256
        $head_script[] = array( 'src' => base_url('js/lib/ajaxqueue.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/lib/isJson.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/lib/isObject.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/lib/isNumber.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/lib/isLuxonDateTime.js?v='.VERSION), ); // abhaengig von isObject
        $head_script[] = array( 'src' => base_url('js/lib/zufaelligeZeichenketteZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/lib/umlaute2unixZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/lib/unix2umlauteZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/lib/exists.js?v='.VERSION), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/Vereinsapp_Init.js?v='.VERSION), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/Liste_Init.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/Liste_Aktualisieren.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/element/Liste_ElementFormularInitialisiertZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/element/Liste_ElementFormularEigenschaftenWerteInAjaxData.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/element/Liste_ElementFormularValidationAktualisieren.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/element/Liste_ElementLoeschen.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/element/Liste_ElementAktualisieren.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/element/Liste_WertFormatiertZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/element/Liste_ElementZusatzsymbolAktualisieren.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/element/Liste_ElementNavigationAktualisieren.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/element/Liste_ElementBeschriftungZurueck.js?v='.VERSION), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_FilternInit.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_FilternFormularOeffnen.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_FilternErstellen.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_FilternVerknuepfungAendern.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_FilternLoeschen.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_FilternSpeichern.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_Filtern2$FilternZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_$Filtern2FilternZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_TabelleGefiltertZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_FilternEigenschaftPositionZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_FilternPositionGeloeschtZurueck.js?v='.VERSION), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_SortierenInit.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_SortierenFormularOeffnen.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_SortierenErstellen.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_SortierenRichtungAendern.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_SortierenLoeschen.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_SortierenSpeichern.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_Sortieren2$SortierenZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_$Sortieren2SortierenZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_ArraySortiertZurueck.js?v='.VERSION), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/gruppieren/Liste_GruppierenInit.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/gruppieren/Liste_GruppierenFormularOeffnen.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/gruppieren/Liste_GruppierenSpeichern.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/gruppieren/Liste_ArrayGruppiertZurueck.js?v='.VERSION), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/auswertungen/Liste_AuswertungenInit.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/auswertungen/Liste_AuswertungenAktualisieren.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/auswertungen/Liste_AuswertungAktualisieren.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/auswertungen/Liste_AuswertungenErgebnisZurueck.js?v='.VERSION), );
        
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/checkliste/Liste_ChecklisteInit.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/checkliste/Liste_CheckAendern.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/checkliste/Liste_CheckAktualisieren.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/checkliste/Liste_ElementIdZurueck.js?v='.VERSION), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/verzeichnis/Liste_VerzeichnisInit.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/verzeichnis/Liste_VerzeichnisAktualisieren.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/verzeichnis/Liste_DateiAktualisieren.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/verzeichnis/Liste_VerzeichnisAnzahlZurueck.js?v='.VERSION), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/ajax/Schnittstelle_AjaxInit.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/ajax/Schnittstelle_AjaxInDieSchlange.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/ajax/Schnittstelle_AjaxRaus.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/ajax/Schnittstelle_AjaxRein.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/ajax/Schnittstelle_AjaxReinErfolg.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/ajax/Schnittstelle_AjaxReinFehler.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/ajax/Schnittstelle_AjaxStatusSetzen.js?v='.VERSION), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/localstorage/Schnittstelle_LocalstorageInit.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/localstorage/Schnittstelle_LocalstorageRein.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/localstorage/Schnittstelle_LocalstorageRausZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/localstorage/Schnittstelle_LocalstorageLoeschen.js?v='.VERSION), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/variable/Schnittstelle_VariableRein.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/variable/Schnittstelle_VariableRausZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/variable/Schnittstelle_VariableObjektBereinigtZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/variable/Schnittstelle_VariableArrayBereinigtZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/variable/Schnittstelle_VariableWertBereinigtZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/variable/Schnittstelle_VariableLoeschen.js?v='.VERSION), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/dom/Schnittstelle_DomInit.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/dom/Schnittstelle_DomToastFeuern.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/dom/Schnittstelle_DomModalOeffnen.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/dom/Schnittstelle_DomLetztesModalZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/dom/Schnittstelle_DomLetztesWartendesModalZurueck.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/dom/Schnittstelle_DomModalSchliessen.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/dom/Schnittstelle_DomBestaetigungEinfordern.js?v='.VERSION), );
        
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventSqlUpdLocalstorage.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventLocalstorageUpdVariable.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventVariableUpdLocalstorage.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventElementErgaenzenMitglieder.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventElementErgaenzenTermine.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventElementErgaenzenStrafkatalog.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventElementErgaenzenKassenbuch.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventElementErgaenzenNotenbank.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventVariableUpdDom.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_NaechsteAktion.js?v='.VERSION), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventDurchfuehren.js?v='.VERSION), );

        if( auth()->loggedIn() ) {
            $head_script[] = array( 'src' => base_url('js/vereinsapp/mitglieder/Mitglieder_Init.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/mitglieder/Mitglieder_MitgliedErstellen.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/mitglieder/Mitglieder_MitgliedAendern.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/mitglieder/Mitglieder_PasswortAendern.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/mitglieder/Mitglieder_PasswortFestlegen.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/mitglieder/Mitglieder_EinmalLinkAnzeigen.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/mitglieder/Mitglieder_EinmalLinkEmail.js?v='.VERSION), );

            $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/Termine_Init.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/Termine_TerminErstellen.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/Termine_TerminAendern.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/Termine_RueckmeldungErstellen.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/Termine_RueckmeldungAendern.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/Termine_RueckmeldungDetaillieren.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/Termine_RueckmeldungAktualisieren.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/Termine_RueckmeldungEinAusblenden.js?v='.VERSION), );
            
            $head_script[] = array( 'src' => base_url('js/vereinsapp/strafkatalog/Strafkatalog_Init.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/strafkatalog/Strafkatalog_StrafeErstellen.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/strafkatalog/Strafkatalog_StrafeAendern.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/strafkatalog/Strafkatalog_StrafeZuweisen.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/strafkatalog/Strafkatalog_KassenbucheintragErstellen.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/strafkatalog/Strafkatalog_KassenbucheintragAendern.js?v='.VERSION), );
            // $head_script[] = array( 'src' => base_url('js/vereinsapp/strafkatalog/Strafkatalog_KassenbucheintragAktivieren.js?v='.VERSION), );

            $head_script[] = array( 'src' => base_url('js/vereinsapp/notenbank/Notenbank_Init.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/notenbank/Notenbank_TitelErstellen.js?v='.VERSION), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/notenbank/Notenbank_TitelAendern.js?v='.VERSION), );
        }
        defined('HEAD_SCRIPT') OR define( 'HEAD_SCRIPT', $head_script );

        $this->viewdata = array();
    }

}