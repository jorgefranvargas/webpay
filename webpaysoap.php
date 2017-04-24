<?php
//Notar que se incluyen dos archivos que se proveen en la librería de encriptación
require_once 'seguridad/xmlseclibs.php';
require_once 'seguridad/soap-wsse.php';
/*
define('PRIVATE_KEY', dirname(__FILE__) . '/certificados/597020000541.key');
define('CERT_FILE', dirname(__FILE__) . '/certificados/597020000541.crt'); */

define('PRIVATE_KEY', dirname(__FILE__) . '/certificados/597032064922.key');
define('CERT_FILE', dirname(__FILE__) . '/certificados/597032064922.crt');


class webPaySoap extends SoapClient
{
    private $useSSL = false;
    public function __construct($wsdl, $options)
    {
        $locationparts = parse_url($wsdl);
        $this->useSSL  = $locationparts['scheme'] == "https" ? true : false;
        return parent::__construct($wsdl, $options);
    }
    public function __doRequest($request, $location, $saction, $version)
    {
        if ($this->useSSL) {
            $locationparts = parse_url($location);
            $location      = 'https://';
            if (isset($locationparts['host'])) {
                $location .=
                    $locationparts['host'];
            }
            if (isset($locationparts['port'])) {
                $location .=
                    ':' . $locationparts['port'];
            }
            if (isset($locationparts['path'])) {
                $location .=
                    $locationparts['path'];
            }
            if (isset($locationparts['query'])) {
                $location .=
                    '?' . $locationparts['query'];
            }
        }
        $doc = new DOMDocument('1.0');
        $doc->loadXML($request);
        $objWSSE = new WSSESoap($doc);
        $objKey  = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type' => 'private'));
        $objKey->loadKey(PRIVATE_KEY, true);
        $options = array("insertBefore" => true);
        $objWSSE->signSoapDoc($objKey, $options);
        $objWSSE->addIssuerSerial(CERT_FILE);
        $objKey = new XMLSecurityKey(XMLSecurityKey::AES256_CBC);
        $objKey->generateSessionKey();
        $retVal = parent::__doRequest($objWSSE->saveXML(), $location,
            $saction, $version);
        $doc = new DOMDocument();
        $doc->loadXML($retVal);
        return $doc->saveXML();
    }
}