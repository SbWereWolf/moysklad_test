<?php

/*
//Tell cURL that we want to carry out a POST request.
curl_setopt($curl, CURLOPT_POST, true);

//Set our post fields / date (from the array above).
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postValues));
*/

error_reporting(E_ALL);

require_once 'moysklad_routine_library.php';

$api = 'https://online.moysklad.ru/api/remap/1.1';
$curl = getCurl();

$curl = setCurl($curl, "$api/entity/organization", 'GET');
$persons = getJuridicalPerson($curl);

$curl = setCurl($curl, "$api/entity/counterparty", 'GET');
$counterparty = getCounterparty($curl);

$curl = setCurl($curl, "$api/entity/product", 'GET');
$nomenclature = getNomenclature($curl);
?>

<form id="order-form">
    <p>Доступные юридические лица:<br/>

        <?php
foreach ($persons as $key => $person) {
    $personId = $person['id'];
    echo '<label for="' . $personId . '">' . $person['name']
        . '</label>
<input type="radio" data-organization-type="1" id="'
        . $personId . '" name="organization"><br />';
}
echo 'Доступные контрагенты:<br />';
foreach ($counterparty as $key => $person) {
    $personId = $person['id'];
    echo '<label for="' . $personId . '">'
        . $person['name']
        . '</label><input type="radio" data-counterparty-type="1" id="'
        . $personId . '" name="counterparty"><br />';
}
echo 'Номенклатура товаров:<br />';
foreach ($nomenclature as $key => $position) {
    $positionId = $position['id'];
    echo '<label for="' . $positionId . '">' . $position['name']
        . ', количество для заказа => </label><input type="text"'
        . ' id="' . $positionId . '" data-position-type="1"><br />';
}
        ?>
        <input id="send" type="submit"
               name="Сформировать заказ покупателя">
        <br/>
    </p>
</form>
<script src=
        "https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"
        type="text/javascript"></script>
<script type="text/javascript" src="/send-order.js"></script>
