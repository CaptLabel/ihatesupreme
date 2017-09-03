$('.ui-btn-panier').click(function(){
    var this_elt = $(this);
    var data_id = this_elt.attr('data-id');
    var date_action = this_elt.attr('date-action');
    if(data_id == "" || !$.isNumeric(data_id))return;
    if(typeof date_action != "string" || date_action == "")return;
    $.ajax({
        url: '../../panier/'+date_action+'/'+data_id,
        method: 'POST',
        dataType: 'json',
        success : function(data){
            if(data.status == "OK"){
                if(date_action == "add"){
                    this_elt.attr('date-action', 'remove');
                    this_elt.html('retirer au panier');
                    $('#fade_black').show();
                    $('#popup_ajout').show();
                }else{
                    this_elt.attr('date-action', 'add');
                    this_elt.html('ajouter au panier');
                }
            }
        }
    });
});

$('.ui-remove-item-panier').click(function(){
    var this_elt = $(this);
    var data_id = this_elt.attr('data-id');
    var date_action = this_elt.attr('date-action');
    if(data_id == "" || !$.isNumeric(data_id))return;
    if(typeof date_action != "string" || date_action == "")return;
    $.ajax({
        url: 'panier/'+date_action+'/'+data_id,
        method: 'POST',
        dataType: 'json',
        success : function(data){
            if(data.status == "OK"){
                this_elt.parents('tr').remove();
                updateTotalPanier();
                if($('.ui-item-buy').length == 0){
                    location.reload();
                }
            }
        }
    });
});

function updateTotalPanier(){
    $('.ui-parent-calcul').each(function(){
        var total = 0;
        $(this).find('td[data-price]').each(function () {
            total += parseFloat($(this).attr('data-price'));
        });
        $(this).find('.ui-total').html(total+' €');
        if($('#amount').length > 0){
            $('#amount').val(total);
        }
    });

}

function hidePopupAjout(){
    $('#fade_black').hide();
    $('#popup_ajout').hide();
}

$(document).ready(function(){
    if($('.ui-total').length > 0){
        updateTotalPanier();
    }
    $('.form-control').keypress(function(){
        $(this).parent().find('ul').remove();
    });
});