jQuery(function ($) {
    $("#send").on("click",sendOrder);
    $("#order-form").on("submit",function (e) {
        e.preventDefault();
        return false;
    })
});
function sendOrder(){
    const $text_field = $('#orderForm :input:text');

    const position = {};
    const counterparty = {};
    const organization = {};

    $text_field.each(function() {
        const this_val = $(this).val();
        const is_it_position = $(this).data('position-type');

        const may_assign = typeof this_val !== typeof undefined;

        if ( may_assign && is_it_position > 0){
            position[this.id] = this_val;
        }
    });

    const $radio_field = $('#orderForm :input:radio:checked');
    $radio_field.each(function() {
        const this_val = $(this).val();

        const is_it_counterparty = $(this).data('counterparty-type');
        const is_it_organization = $(this).data('organization-type');

        const may_assign = typeof this_val !== typeof undefined;

        if ( may_assign && is_it_counterparty > 0){
            counterparty[this.id] = this_val;
        }
        if ( may_assign && is_it_organization > 0){
            organization[this.id] = this_val;
        }
    });

    const postData = JSON.stringify(
        {
            position : position,
            counterparty : counterparty ,
            organization : organization
        });
    // noinspection JSUnusedGlobalSymbols
    $.ajax({
        type: "POST",
        url: "moyskald_add_order.php",
        data: postData,
        contentType: "application/json; charset=utf-8",
        dataType: "text",
        timeout: 10000,
        error: function(){
            alert("Сбой добавления заказа");
        },
        success: function(data){alert(data);},
        failure: function(errMsg) {
            alert(errMsg);
        }
    });
}
