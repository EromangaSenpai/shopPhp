$(function() {
    $("input:file").change(function (){
        var fileName = $(this).val().split( '\\' ).pop();
        $(this).next('label').html('<i class="fa fa-file"></i> ' + fileName);
    });
});