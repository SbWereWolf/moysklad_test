<?php

error_reporting(E_ALL);

require_once 'moysklad_routine_library.php';

$handle = fopen('php://input', 'r');
$rawData = stream_get_contents($handle);
fclose($handle);

$data = json_decode($rawData, true);

$rawPosition = $data['position'];
$rawCounterparty = $data['counterparty'];
$rawOrganization = $data['organization'];

$counterpartyIdCollection = array_keys($rawCounterparty);
$organizationIdCollection = array_keys($rawOrganization);

$counterpartyId = $counterpartyIdCollection[0];
$organizationId = $organizationIdCollection[0];

$textAddCustomerOrder = '
{
  "name": "' . time() . '",
  "organization": {
    "meta": {
      "href": "https://online.moysklad.ru/api/remap/1.1/entity/organization/'
    . $organizationId . '",
      "type": "organization",
      "mediaType": "application/json"
    }
  },
  "agent": {
    "meta": {
      "href": "https://online.moysklad.ru/api/remap/1.1/entity/counterparty/'
    . $counterpartyId . '",
      "type": "counterparty",
      "mediaType": "application/json"
    }
  }
}
';

$api = 'https://online.moysklad.ru/api/remap/1.1';
$curl = getCurl();
$curl = setCurl($curl, "$api/entity/customerorder", 'POST');

curl_setopt($curl, CURLOPT_POSTFIELDS, $textAddCustomerOrder);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($textAddCustomerOrder))
);

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

    $customerOrderId = setCustomerOrder($curl);

    $curl = getCurl();
    $curl = setCurl($curl,
        "$api/entity/customerorder/"
        . "$customerOrderId/positions",
        'POST');

    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonOrderPositions);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonOrderPositions))
    );

    $jsonResponse = setCustomerOrderPosition($curl);
}
var_export($jsonResponse);
