<?php

/**
 * @return resource
 */
function getCurl()
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);

    curl_setopt($curl, CURLOPT_USERPWD,
        "admin@ulfnew:34bdca9826");
    curl_setopt($curl, CURLOPT_USERAGENT,
        'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36'
        .' (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36');

    return $curl;
}
function getJuridicalPerson($curlObject)
{
    $response = null;
    try {
        $response = curlExec($curlObject);
    } catch (Exception $e) {
    }
    $data = json_decode($response, true);
    $result = $data['rows'];
    return $result;
}

/**
 * @param $curlObject
 * @return mixed
 * @throws Exception
 */
function curlExec($curlObject)
{
    $response = curl_exec($curlObject);

    $curlErrorNumber = curl_errno($curlObject);
    if ($curlErrorNumber) {
        throw new Exception(curl_error($curlObject));
    }

    return $response;
}

function getCounterparty($curlObject)
{
    $response = null;
    try {
        $response = curlExec($curlObject);
    } catch (Exception $e) {
    }
    $data = json_decode($response, true);
    $result = $data['rows'];
    return $result;
}

function getNomenclature($curlObject)
{
    $response = null;
    try {
        $response = curlExec($curlObject);
    } catch (Exception $e) {
    }
    $data = json_decode($response, true);
    $result = $data['rows'];
    return $result;
}

function setCurl(&$curlObject, $uri, $method)
{
    curl_setopt($curlObject, CURLOPT_URL, $uri);

    curl_setopt($curlObject, CURLOPT_HTTPGET, true);
    switch ($method) {
        case 'GET':
            break;
        case 'POST':
            curl_setopt($curlObject, CURLOPT_POST, true);
            break;
        case 'PUT':
            curl_setopt($curlObject, CURLOPT_PUT, true);
            break;
    }

    return $curlObject;
}
function setCustomerOrder($curlObject)
{
    $response = null;
    try {
        $response = curlExec($curlObject);
    } catch (Exception $e) {
    }
    $data = json_decode($response, true);
    $customerOrderId = $data['id'];
    return $customerOrderId;
}
function setCustomerOrderPosition($curlObject)
{
    $response = null;
    try {
        $response = curlExec($curlObject);
    } catch (Exception $e) {
    }
    $data = json_decode($response, true);
    return $data;
}
