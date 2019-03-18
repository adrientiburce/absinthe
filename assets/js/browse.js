$(document).ready(function () {
    $('.ouca').html('coucou');
    // $('.file-upload-name').html('test');
    $('.file-upload-name').on('change',function(){
        var fileName = $(this).val().replace("C:\\fakepath\\", "");
        $(this).next('.custom-file-label').html(fileName);
    });
  });
