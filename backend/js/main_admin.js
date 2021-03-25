$(document).ready(function(){   
    function readImage(file) {
        var reader = new FileReader();
        var image  = new Image();
        reader.readAsDataURL(file);  
        reader.onload = function(_file) {
            image.src = _file.target.result; // url.createObjectURL(file);
            image.onload = function() {
                var w = this.width,
                h = this.height,
                t = file.type, // ext only: // file.type.split('/')[1],
                n = file.name,
                s = ~~(file.size/1024) +'KB';
                $('#uploadPreview').prepend('<div class="col-lg-3"><div class="form-group"><img src="' + this.src + '" class="thumb"></div></div>');
            };
            image.onerror= function() {
                alert('Invalid file type: '+ file.type);
            };      
        };
    }
    $("#image_file").change(function (e) {
        if(this.disabled) {
            return alert('File upload not supported!');
        }
        var F = this.files;
        if (F && F[0]) {
            for (var i = 0; i < F.length; i++) {
                readImage(F[i]);
            }
        }
    });
});
function readURL(input) {
if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
    $('#blah').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
}
}
$("#imgInp").change(function() {
readURL(this);
});