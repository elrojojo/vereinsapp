<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

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
        'form',
        'filesystem',
        'vereinsapp_helper',
      ];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->helpers = array_merge($this->helpers, ['setting']);

        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        $this->router = \Config\Services::router();
        $this->request  = \Config\Services::request();
        $this->validation  = \Config\Services::validation();
        $this->session = \Config\Services::session();

        defined('CSRF_NAME') OR define( 'CSRF_NAME', csrf_token() );

        defined('ICH') OR define( 'ICH', $this->session->user );
    
        defined('CONTROLLER') OR define( 'CONTROLLER', lcfirst(
          explode( '\\', $this->router->controllerName() )[ array_key_last(
            explode( '\\', $this->router->controllerName() )
            ) ]
          ) );
        defined('METHOD') OR define( 'METHOD', $this->router->methodName() );

        defined('HEAD_STYLESHEET') OR define( 'HEAD_STYLESHEET', array( 
          array( 'href' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css', 'integrity' => 'sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65', 'crossorigin' => 'anonymous', ),
          array( 'href' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css'),
          array( 'href' => base_url('css/vereinsapp.css'), ),
        ) );
        $head_script = array();
        $head_script[] = array( 'src' => 'https://code.jquery.com/jquery-3.6.3.js', 'integrity' => 'sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=', 'crossorigin' => 'anonymous', );
        // $head_script[] = array( 'src' => 'https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.js', 'integrity' => 'sha256-1PYCpx/EXA36KN1NKrK7auaTylVyk01D98R7Ccf04Bc=', 'crossorigin' => 'anonymous', );
        $head_script[] = array( 'src' => 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', 'integrity' => 'sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=', 'crossorigin' => 'anonymous', );
        $head_script[] = array( 'src' => 'https://cdn.jsdelivr.net/npm/jquery-ui-touch-punch@0.2.3/jquery.ui.touch-punch.min.js', );
        $head_script[] = array( 'src' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js', 'integrity' => 'sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4', 'crossorigin' => 'anonymous', );
        $head_script[] = array( 'src' => 'https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js', );
        $head_script[] = array( 'src' => base_url('js/lib/sha256.min.js'), ); // https://www.npmjs.com/package/js-sha256
        $head_script[] = array( 'src' => base_url('js/lib/ajaxqueue.js'), ); // https://stackoverflow.com/questions/3034874/sequencing-ajax-requests/3035268

        $head_script[] = array( 'src' => base_url('js/vereinsapp/vereinsapp.js'), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/Liste_Init.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/Liste_Aktualisieren.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/Liste_ElementFormularOeffnen.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/Liste_ElementErstellen.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/Liste_ElementLoeschen.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/Liste_ElementAktualisieren.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/Liste_Formular.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/Liste_GibWertFormatiert.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/Liste_GibTodo.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/Liste_CheckAendern.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/element/Liste_ElementZusatzsymbolAktualisieren.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/element/Liste_ElementCheckAktualisieren.js'), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_FilternInit.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_FilternFormularOeffnen.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_FilternErstellen.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_FilternVerknuepfungAendern.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_FilternLoeschen.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_GibFiltern2$Filtern.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_Gib$Filtern2Filtern.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_GibPhpFiltern2Filtern.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_GibSqlFiltern2Filtern.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/filtern/Liste_GibTabelleGefiltert.js'), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_SortierenInit.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_SortierenFormularOeffnen.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_SortierenErstellen.js'), );
        // $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_SortierenAendern.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_SortierenLoeschen.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_GibSortieren2$Sortieren.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_Gib$Sortieren2Sortieren.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/sortieren/Liste_GibArraySortiert.js'), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/auswertungen/Liste_AuswertungenInit.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/liste/auswertungen/Liste_AuswertungenAktualisieren.js'), );

        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/Schnittstelle_DomWarten.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/ajax/Schnittstelle_AjaxInDieSchlange.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/ajax/Schnittstelle_AjaxFuerDieSchlangeVorbereiten.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/ajax/Schnittstelle_AjaxRaus.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/ajax/Schnittstelle_AjaxRein.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/ajax/Schnittstelle_AjaxReinErfolg.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/ajax/Schnittstelle_AjaxReinFehler.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/localstorage/Schnittstelle_GibLocalstorageRaus.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/localstorage/Schnittstelle_LocalstorageRein.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/localstorage/Schnittstelle_LocalstorageWertBereinigtZurueck.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventSqlUpdLocalstorage.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventLocalstorageUpdVariable.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventVariableUpdLocalstorage.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventElementErgaenzenMitglieder.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventElementErgaenzenTermine.js'), );
        $head_script[] = array( 'src' => base_url('js/vereinsapp/schnittstelle/event/Schnittstelle_EventElementErgaenzenNotenbank.js'), );

        if( auth()->loggedIn() ) {
            $head_script[] = array( 'src' => base_url('js/vereinsapp/mitglieder/Mitglieder_Init.js'), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/mitglieder/Mitglieder_PermissionsAktualisieren.js'), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/mitglieder/Mitglieder_PermissionAktualisieren.js'), );
            $head_script[] = array( 'src' => base_url('js/vereinsapp/mitglieder/Mitglieder_PermissionAendern.js'), );
            if( in_array( 'termine', AKTIVE_CONTROLLER ) ) {
                $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/Termine_Init.js'), );
                $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/Termine_MeineRueckmeldungAktualisieren.js'), );
                $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/Termine_FormularMeineRueckmeldungEinAusblenden.js'), );
                $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/personenkreis_beschraenken/Termine_FormularPersonenkreisBeschraenkenOeffnen.js'), );
                $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/personenkreis_beschraenken/Termine_PersonenkreisBeschraenkenAktualisieren.js'), );
                $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/personenkreis_beschraenken/Termine_PersonenkreisBeschraenkenErstellen.js'), );
                $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/personenkreis_beschraenken/Termine_PersonenkreisBeschraenkenAendern.js'), );
                $head_script[] = array( 'src' => base_url('js/vereinsapp/termine/personenkreis_beschraenken/Termine_PersonenkreisBeschraenkenLoeschen.js'), );
            }
            if( in_array( 'notenbank', AKTIVE_CONTROLLER ) ) $head_script[] = array( 'src' => base_url('js/vereinsapp/notenbank/Notenbank_Init.js'), );
        }
        defined('HEAD_SCRIPT') OR define( 'HEAD_SCRIPT', $head_script );

        $this->viewdata = array();
    }

}