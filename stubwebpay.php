<?php
require_once 'webpaysoap.php';

class getTransactionResult
{
    public $tokenInput; //string
}
class getTransactionResultResponse
{
    public $return; //transactionResultOutput
}
class transactionResultOutput
{
    public $accountingDate; //string
    public $buyOrder; //string
    public $cardDetail; //cardDetail
    public $detailOutput; //wsTransactionDetailOutput
    public $sessionId; //string
    public $transactionDate; //dateTime
    public $urlRedirection; //string
    public $VCI; //string
}
class cardDetail
{
    public $cardNumber; //string
    public $cardExpirationDate; //string
}
class wsTransactionDetailOutput
{
    public $authorizationCode; //string
    public $paymentTypeCode; //string
    public $responseCode; //int
}
class wsTransactionDetail
{
    public $sharesAmount; //decimal
    public $sharesNumber; //int
    public $amount; //decimal
    public $commerceCode; //string
    public $buyOrder; //string
}
class acknowledgeTransaction
{
    public $tokenInput; //string
}
class acknowledgeTransactionResponse
{
}
class initTransaction
{
    public $wsInitTransactionInput; //wsInitTransactionInput
}
class wsInitTransactionInput
{
    public $wSTransactionType; //wsTransactionType
    public $commerceId; //string
    public $buyOrder; //string
    public $sessionId; //string
    public $returnURL; //anyURI
    public $finalURL; //anyURI
    public $transactionDetails; //wsTransactionDetail
    public $wPMDetail; //wpmDetailInput
}
class wpmDetailInput
{
    public $serviceId; //string
    public $cardHolderId; //string
    public $cardHolderName; //string
    public $cardHolderLastName1; //string
    public $cardHolderLastName2; //string
    public $cardHolderMail; //string
    public $cellPhoneNumber; //string
    public $expirationDate; //dateTime
    public $commerceMail; //string
    public $ufFlag; //boolean
}
class initTransactionResponse
{
    public $return; //wsInitTransactionOutput
}
class wsInitTransactionOutput
{
    public $token; //string
    public $url; //string
}
class webpayService
{
    public $soapClient;

    private static $classmap = array('getTransactionResult' => 'getTransactionResult'
        , 'getTransactionResultResponse' => 'getTransactionResultResponse'
        , 'transactionResultOutput' => 'transactionResultOutput'
        , 'cardDetail' => 'cardDetail'
        , 'wsTransactionDetailOutput' => 'wsTransactionDetailOutput'
        , 'wsTransactionDetail' => 'wsTransactionDetail'
        , 'acknowledgeTransaction' => 'acknowledgeTransaction'
        , 'acknowledgeTransactionResponse' => 'acknowledgeTransactionResponse'
        , 'initTransaction' => 'initTransaction'
        , 'wsInitTransactionInput' => 'wsInitTransactionInput'
        , 'wpmDetailInput' => 'wpmDetailInput'
        , 'initTransactionResponse' => 'initTransactionResponse'
        , 'wsInitTransactionOutput' => 'wsInitTransactionOutput',

    );

    public function __construct($url = 'https://webpay3gint.transbank.cl/WSWebpayTransaction/cxf/WSWebpayService?wsdl')
    {
        $this->soapClient = new webPaySoap($url, array("classmap" => self::$classmap, "trace" => true, "exceptions" => true));
    }

    public function getTransactionResult($getTransactionResult)
    {    
       
           $getTransactionResultResponse = $this->soapClient->getTransactionResult($getTransactionResult);
        return $getTransactionResultResponse;

    }
    public function acknowledgeTransaction($acknowledgeTransaction)
    {

        $acknowledgeTransactionResponse = $this->soapClient->acknowledgeTransaction($acknowledgeTransaction);
        return $acknowledgeTransactionResponse;

    }
    public function initTransaction($initTransaction)
    {  

        $initTransactionResponse = $this->soapClient->initTransaction($initTransaction);
        return $initTransactionResponse;

    }}
