<?php
require_once 'seguridad/soap-wsse.php';
require_once 'seguridad/soap-validation.php';
/* WebpayService.php es el archivo que contiene la
clasestub creado en el paso 1*/
require_once 'stubAnulacion.php';
/*define('SERVER_CERT', dirname(__FILE__) . '/certificados/tbk.pem');/*

define('SERVER_CERT', dirname(__FILE__) . '/certificados/serverTBK.crt');

$request_body = file_get_contents('php://input');
$data         = json_decode($request_body, true);

$nullificationInput = new nullificationInput();

$nullificationInput->commerceId = $data['commerceId'];
$nullificationInput->buyOrder =          $data['buyOrder'];
$nullificationInput->authorizedAmount =  $data['authorizedAmount'];
$nullificationInput->authorizationCode = $data['authorizationCode'];
$nullificationInput->nullifyAmount =     $data['nullifyAmount'];

$url_wsdl     = "https://webpay3g.transbank.cl/WSWebpayTransaction/cxf/WSCommerceIntegrationService?wsdl";

/*$url_wsdl     = "https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSCommerceIntegrationService?wsdl";*/

$stubAnulacion= new stubAnulacion($url_wsdl);

try {
  
$nullifyResponse = $stubAnulacion->nullify(array ("nullificationInput" => $nullificationInput));


    }catch( SoapFault $exception ){
      $xmlResponse = $stubAnulacion->soapClient->__getLastResponse();   
      header('Content-Type: application/json');
      echo json_encode(array(	 
		 'error' => $xmlResponse,
)); 
}


$xmlResponse = $stubAnulacion->soapClient->__getLastResponse();
$soapValidation = new SoapValidation($xmlResponse, SERVER_CERT);
$validationResult = $soapValidation->getValidationResult();

if ($validationResult) {
    header('Content-Type: application/json');
    echo json_encode(array(	 
		'nullificationOutput' => $nullifyResponse->return,       
			
		  ));
}

?>