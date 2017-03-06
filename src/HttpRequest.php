<?php
/**
 * Ce fichier contient la class HttpRequest
 */

namespace Tourbillon\Request;

/**
 * Classe represantant le HttpRequest
 *
 * PHP version 5.3
 *
 * @category   Tourbillon
 * @package    Tourbillon
 * @author     Gwennael Jean <gwennael.jean@gmail.com>
 * @version    1
 * @link       http://leblogdegwenn.fr
 *
 */
class HttpRequest {

    protected $sBaseUrl;
    protected $sUrl;
    protected $sBasePath;
    protected $sMethod;

    public function __construct() {
        $this->initBasePath();
        $this->initBaseUrl();
        $this->initUrl();
        $this->initMethod();
    }

    public function cookieData($key) {
        return $this->cookieExists($key) ? $_COOKIE[$key] : null;
    }

    public function cookieExists($key) {
        return isset($_COOKIE[$key]);
    }

    public function getData($key = null) {
        if (null !== $key) {
            return $this->getExists($key) ? $_GET[$key] : null;
        }
        return isset($_GET) ? $_GET : array();
    }

    public function getExists($key) {
        return isset($_GET[$key]);
    }

    public function postData($key = null) {
        if (null !== $key) {
            return $this->postExists($key) ? $_POST[$key] : null;
        }
        return isset($_POST) ? $_POST : array();
    }

    public function postExists($key) {
        return isset($_POST[$key]);
    }
    
    public function serverData($key) {
        return $this->serverExists($key) ? $_SERVER[$key] : null;
    }

    public function serverExists($key) {
        return isset($_SERVER[$key]);
    }
    
    /**
     * Indique si la methode est de type AJAX
     * @return boolean
     */
    public function isAjaxRequest() {
        return array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }


    /**
     * Retourne le path du projet. exemple : C:/xampp/htdocs/monsite/
     * @return string
     */
    public function getBasePath() {
        return $this->sBasePath;
    }

    /**
     * Retourne l'URL du projet. exemple : http://localhost/monsite/
     * @return string
     */
    public function getBaseUrl() {
        return $this->sBaseUrl;
    }
    
    /**
     * Retourne le type de methode. exemple : GET, POST
     * @return type
     */
    public function getMethod() {
        return $this->sMethod;
    }

    /**
     * Retourne l'URL
     * @return string
     */
    public function getUrl() {
        return $this->sUrl;
    }
    
    /**
     * Permet de supprimer les slash en debut et fin de chaine
     * @param string $sValue
     * @return string
     */
    public function parse($sValue) {
        return trim($sValue, '/');
    }

    private function initBaseUrl() {
        if (isset($_SERVER['HTTP_HOST'])) {
            $this->sBaseUrl = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $this->sBaseUrl .= '://' . $_SERVER['HTTP_HOST'];
            $this->sBaseUrl .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        } else {
            $this->sBaseUrl = 'http://localhost/';
        }
    }
    
    private function initUrl() {
        $sUrl = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https://' : 'http://';
        $sUrl .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        if (strpos($sUrl, '?')) {
            $sUrl = substr($sUrl, 0, strpos($sUrl, '?'));
        }
        $this->sUrl = $this->parse($sUrl);
    }
    
    private function initBasePath() {
        $this->sBasePath = dirname($_SERVER['SCRIPT_FILENAME']) . '/';
    }
    
    private function initMethod() {
        $this->sMethod = $_SERVER['REQUEST_METHOD'];
    }
}
