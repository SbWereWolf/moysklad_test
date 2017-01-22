<?php

function getSettings()
{
    $apiConfig = include('moysklad_curl_details.php');
    return $apiConfig;
}
/**
 * @param $apiSettings
 * @return resource
 */
function setupCurl($apiSettings)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);

    $userName = $apiSettings[MOYSKLAD_USERNAME];
    $userPassword = $apiSettings[MOYSKLAD_PASSWORD];
    curl_setopt($curl, CURLOPT_USERPWD, "$userName:$userPassword");
    curl_setopt($curl, CURLOPT_USERAGENT, $apiSettings[MOYSKLAD_USER_AGENT]);
    return $curl;
}
function getJuridicalPerson($curlObject)
{
    $response = curlExec($curlObject);
    $data = json_decode($response, true);
    $result = $data['rows'];
    return $result;
}

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
    $response = curlExec($curlObject);
    $data = json_decode($response, true);
    $result = $data['rows'];
    return $result;
}

function getNomenclature($curlObject)
{
    $response = curlExec($curlObject);
    $data = json_decode($response, true);
    $result = $data['rows'];
    return $result;
}

function setCurl(&$curlObject, $uri, $method)
{
    curl_setopt($curlObject, CURLOPT_URL, $uri);

    curl_setopt($curlObject, CURLOPT_HTTPGET, true);
    switch ($method) {
        case MOYSKLAD_METHOD_GET:
            break;
        case MOYSKLAD_METHOD_POST:
            curl_setopt($curlObject, CURLOPT_POST, true);
            break;
        case MOYSKLAD_METHOD_PUT:
            curl_setopt($curlObject, CURLOPT_PUT, true);
            break;
    }

    return $curlObject;
}
function setCustomerOrder($curlObject)
{
    $response = curlExec($curlObject);
    $data = json_decode($response, true);
    return $data;
}
function setCustomerOrderPosition($curlObject)
{
    $response = curlExec($curlObject);
    $data = json_decode($response, true);
    return $data;
}
