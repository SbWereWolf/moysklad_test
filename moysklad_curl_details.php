<?php

define('MOYSKLAD_METHOD_GET', 'GET');
define('MOYSKLAD_METHOD_POST', 'POST');
define('MOYSKLAD_METHOD_PUT', 'PUT');

define('MOYSKLAD_USERNAME', 'USERNAME');
define('MOYSKLAD_PASSWORD', 'PASSWORD');
define('MOYSKLAD_USER_AGENT', 'USER_AGENT');
define('MOYSKLAD_API_URL', 'API_URL');

define('MOYSKLAD_GET_NOMENCLATURE', 'GET_NOMENCLATURE');
define('MOYSKLAD_GET_NOMENCLATURE_METHOD', 'GET_NOMENCLATURE_METHOD');
define('MOYSKLAD_GET_JURIDICAL_PERSON', 'GET_JURIDICAL_PERSON');
define('MOYSKLAD_GET_JURIDICAL_PERSON_METHOD', 'GET_JURIDICAL_PERSON_METHOD');
define('MOYSKLAD_GET_COUNTERPARTY', 'GET_COUNTERPARTY');
define('MOYSKLAD_GET_COUNTERPARTY_METHOD', 'GET_COUNTERPARTY_METHOD');
define('MOYSKLAD_ADD_CUSTOMER_ORDER', 'ADD_CUSTOMER_ORDER');
define('MOYSKLAD_ADD_CUSTOMER_ORDER_METHOD', 'ADD_CUSTOMER_ORDER_METHOD');
define('MOYSKLAD_ADD_ORDER_POSITION_METHOD', 'ADD_ORDER_POSITION_METHOD');
define('MOYSKLAD_ADD_ORDER_POSITION_PREFIX', 'ADD_ORDER_POSITION_PREFIX');
define('MOYSKLAD_ADD_ORDER_POSITION_SUFFIX', 'ADD_ORDER_POSITION_SUFFIX');

$curl_details = array(
    MOYSKLAD_USERNAME => 'admin@ulfnew',
    MOYSKLAD_PASSWORD => '34bdca9826',
    MOYSKLAD_USER_AGENT => 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36',
    MOYSKLAD_API_URL => 'https://online.moysklad.ru/api/remap/1.1',
    MOYSKLAD_GET_NOMENCLATURE => '/entity/product',
    MOYSKLAD_GET_NOMENCLATURE_METHOD => MOYSKLAD_METHOD_GET,
    MOYSKLAD_GET_JURIDICAL_PERSON => '/entity/organization',
    MOYSKLAD_GET_JURIDICAL_PERSON_METHOD => MOYSKLAD_METHOD_GET,
    MOYSKLAD_GET_COUNTERPARTY => '/entity/counterparty',
    MOYSKLAD_GET_JURIDICAL_PERSON_METHOD => MOYSKLAD_METHOD_GET,
    MOYSKLAD_ADD_CUSTOMER_ORDER => '/entity/customerorder',
    MOYSKLAD_ADD_CUSTOMER_ORDER_METHOD => MOYSKLAD_METHOD_POST,
    MOYSKLAD_ADD_ORDER_POSITION_PREFIX => '/entity/customerorder/',
    MOYSKLAD_ADD_ORDER_POSITION_SUFFIX => '/positions',
    MOYSKLAD_ADD_ORDER_POSITION_METHOD => MOYSKLAD_METHOD_POST,

);
return $curl_details;
