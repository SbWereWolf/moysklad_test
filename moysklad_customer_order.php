<?php

/*
//Tell cURL that we want to carry out a POST request.
curl_setopt($curl, CURLOPT_POST, true);

//Set our post fields / date (from the array above).
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postValues));
*/

error_reporting(E_ALL);

include('moysklad_routine_library.php');

$apiSettings = getSettings();
$curl = setupCurl($apiSettings);

$curl = setCurl(
    $curl,
    $apiSettings[MOYSKLAD_API_URL] . $apiSettings[MOYSKLAD_GET_JURIDICAL_PERSON],
    $apiSettings[MOYSKLAD_GET_JURIDICAL_PERSON_METHOD]);

$persons = getJuridicalPerson($curl);

$curl = setCurl(
    $curl,
    $apiSettings[MOYSKLAD_API_URL] . $apiSettings[MOYSKLAD_GET_COUNTERPARTY],
    MOYSKLAD_GET_COUNTERPARTY_METHOD);
$counterparty = getCounterparty($curl);

$curl = setCurl(
    $curl,
    $apiSettings[MOYSKLAD_API_URL] . $apiSettings[MOYSKLAD_GET_NOMENCLATURE],
    MOYSKLAD_GET_NOMENCLATURE_METHOD);
$nomenclature = getNomenclature($curl);

echo '<form action="#" onsubmit="return false;" id="orderForm"  ><p>Доступные юридические лица:<br />';
foreach ($persons as $key => $person) {
    $personId = $person['id'];
    echo '<label for="' . $personId . '">' . $person['name'] . '</label><input type="radio" data-organization-type="1" id="' . $personId . '" name="organization"><br />';
}
echo 'Доступные контрагенты:<br />';
foreach ($counterparty as $key => $person) {
    $personId = $person['id'];
    echo '<label for="' . $personId . '">' . $person['name'] . '</label><input type="radio" data-counterparty-type="1" id="' . $personId . '" name="counterparty"><br />';
}
echo 'Номенклатура товаров:<br />';
foreach ($nomenclature as $key => $position) {
    $positionId = $position['id'];
    echo '<label for="' . $positionId . '">' . $position['name'] . ', количество для заказа => </label><input type="text" id="' . $positionId . '" data-position-type="1"><br />';
}
echo '
<input type="submit" name="Сформировать заказ покупателя" onclick="sendOrder();"><br /></p></form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
function sendOrder(){
    var $text_field = $(\'#orderForm :input:text\');
    
    var position = {};
    var counterparty = {};
    var organization = {};
    
    $text_field.each(function() {        
        var this_val = $(this).val();
        var is_it_position = $(this).data(\'position-type\');
        
        var may_assign = this_val>0 || this_val !="";
        
        if ( may_assign && is_it_position > 0){
            position[this.id] = this_val;
        }
    });
    
    var $radio_field = $(\'#orderForm :input:radio:checked\');
    $radio_field.each(function() {
        var this_val = $(this).val();
        
        var is_it_counterparty = $(this).data(\'counterparty-type\');
        var is_it_organization = $(this).data(\'organization-type\');
        
        var may_assign = this_val>0 || this_val !="";
        
        if ( may_assign && is_it_counterparty > 0){
            counterparty[this.id] = this_val;
        }
        if ( may_assign && is_it_organization > 0){
            organization[this.id] = this_val;
        }    
    });
    
    var postData = JSON.stringify({position : position, counterparty : counterparty , organization : organization});
    $.ajax({
        type: "POST",
        url: "moyskald_add_order.php",        
        data: postData,
        contentType: "application/json; charset=utf-8",
        dataType: "text",
        timeout: 10000,        
        error: function(){
            alert("сбой добавления заказа");        
        },
        success: function(data){alert(data);},
        failure: function(errMsg) {
            alert(errMsg);
        }        
    });
}
</script>

';


