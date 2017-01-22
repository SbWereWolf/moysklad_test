<?php

error_reporting(E_ALL);

include('moysklad_routine_library.php');

$rawData = file_get_contents("php://input");

$data = json_decode($rawData, true);

$rawPosition = $data['position'];
$rawCounterparty = $data['counterparty'];
$rawOrganization = $data['organization'];

$counterpartyIdCollection = array_keys($rawCounterparty);
$organizationIdCollection = array_keys($rawOrganization);

const FIRST_INDEX = 0;
$counterpartyId = $counterpartyIdCollection[FIRST_INDEX];
$organizationId = $organizationIdCollection[FIRST_INDEX];

$textAddCustomerOrder = '
{
  "name": "' . time() . '",
  "organization": {
    "meta": {
      "href": "https://online.moysklad.ru/api/remap/1.1/entity/organization/' . $organizationId . '",
      "type": "organization",
      "mediaType": "application/json"
    }
  },
  "agent": {
    "meta": {
      "href": "https://online.moysklad.ru/api/remap/1.1/entity/counterparty/' . $counterpartyId . '",
      "type": "counterparty",
      "mediaType": "application/json"
    }
  }
}
';

$apiSettings = getSettings();
$curl = setupCurl($apiSettings);

$curl = setCurl(
    $curl,
    $apiSettings[MOYSKLAD_API_URL] . $apiSettings[MOYSKLAD_ADD_CUSTOMER_ORDER],
    $apiSettings[MOYSKLAD_ADD_CUSTOMER_ORDER_METHOD]);

curl_setopt($curl, CURLOPT_POSTFIELDS, $textAddCustomerOrder);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($textAddCustomerOrder))
);

$customerOrderId = setCustomerOrder($curl);
// $customerOrderId = $rawCustomerOrder['id'];

$isPositionArray = is_array($rawPosition);

$orderPositions= array();
if ($isPositionArray) {
    foreach ($rawPosition as $id => $quantity) {

        $positionQuantity=floatval($quantity);

        $orderPositions[] =
            [
                "quantity" =>$positionQuantity,
                "price"=>0,
                "discount"=>0,
                "vat"=>0,
                "assortment" =>[
                    "meta"=>[
                        "href"=>"https://online.moysklad.ru/api/remap/1.1/entity/product/$id",
                        "type"=>"product",
                        "mediaType"=>"application/json"
                    ]
                ],
                "reserve"=>$positionQuantity,
            ];
    }
}

$jsonResponse = 'empty';
$isContainPosition = count($orderPositions)>0;
if($isContainPosition ){
    $jsonOrderPositions= json_encode($orderPositions);

    $curl = setupCurl($apiSettings);

    $curl = setCurl(
        $curl,
        $apiSettings[MOYSKLAD_API_URL]
        . $apiSettings[MOYSKLAD_ADD_ORDER_POSITION_PREFIX]
        . $customerOrderId
        . $apiSettings[MOYSKLAD_ADD_ORDER_POSITION_SUFFIX],
        $apiSettings[MOYSKLAD_ADD_ORDER_POSITION_METHOD]);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonOrderPositions);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonOrderPositions))
    );

    $jsonResponse = setCustomerOrderPosition($curl);
}
var_export($jsonResponse);


