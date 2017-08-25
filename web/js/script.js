$('#buy').click(function(){
    var list = [];
    $('.ui-item-buy').each(function () {
        list.push($(this).attr('data-id'));
    });
    $('#defaultbundle_purchase_purchase_list').val(list);

    console.log(list);


    //return false;
    $('form[name=defaultbundle_purchase]').submit();
});

$('#send_freedom').click(function(){
    $('form[name=defaultbundle_freedom]').submit();
});