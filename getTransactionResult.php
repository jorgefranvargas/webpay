<?php
require_once 'seguridad/soap-wsse.php';
require_once 'seguridad/soap-validation.php';
/* WebpayService.php es el archivo que contiene la
clasestub creado en el paso 1*/
require_once 'stubwebpay.php';

/*define('SERVER_CERT', dirname(__FILE__) . '/certificados/tbk.pem');*/

define('SERVER_CERT', dirname(__FILE__) . '/certificados/serverTBK.crt');

$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

/*$url_wsdl      = "https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl";*/
  
$url_wsdl                = "https://webpay3g.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl";
$webpayService = new WebpayService($url_wsdl);



$getTransactionResult = new getTransactionResult();

$getTransactionResult->tokenInput = $data['tokenInput'];

/* try{ */

  $getTransactionResultResponse = $webpayService->getTransactionResult($getTransactionResult);

/* 
}catch( SoapFault $exception ){
      $xmlResponse = $webpayService->soapClient->__getLastResponse();   
      header('Content-Type: application/json');
      echo json_encode(array(	 
		 'error' => $xmlResponse,
)); 

}

*/

/*
 Validación de firma del requerimiento de respuesta enviado por Webpay*/

$xmlResponse      = $webpayService->soapClient->__getLastResponse();
$soapValidation   = new SoapValidation($xmlResponse, SERVER_CERT);
$validationResult = $soapValidation->getValidationResult();
/*Invocar sólo sí $validationResult es TRUE*/
if ($validationResult) {
    header('Content-Type: application/json');
    echo json_encode(array(	 
		'transactionResultOutput' => $getTransactionResultResponse->return,       
		
	
		  ));
}