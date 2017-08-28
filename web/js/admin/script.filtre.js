var status_array = [];
$(document).ready(function(){
    $('.ui_row_filtre').each(function(){
        var ui_filtre_type = $(this).attr('ui-filtre-type');
        if($.inArray(ui_filtre_type, status_array) == -1){
            status_array.push(ui_filtre_type);
            $('#select_filtre').append('<option value="'+ui_filtre_type+'">'+ui_filtre_type+'</option>');
        }
    });
    $('#select_filtre').change(function(){
        var status = $(this).val();
        status.replace(' ', '_');
        if(status == 0){
            $('.ui_row_filtre').show();
        }else{
            $('.ui_row_filtre').hide();
            $('.ui_row_filtre[ui-filtre-type='+$(this).val()+']').show();
        }
    });
});