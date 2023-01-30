function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#viewpicture').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}	
$("#upfile").change(function(){
    readURL(this);	
    if($('#upfile').val() == "")
    {
        $('#viewpicture').attr('src','./dist/images/user-blue.png');	
    }
});