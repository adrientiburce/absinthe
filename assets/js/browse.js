$('.file-upload-name').on('change',function(){
    var fileName = $(this).val().replace("C:\\fakepath\\", "");
    $(this).next('.file-upload-name').html(fileName);
});

$('.ouca').html('coucou');
console.log('test');