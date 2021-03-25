
CKEDITOR.editorConfig = function( config )
{
        // Define changes to default configuration here. For example:
    config.language = 'vi';
            
        
        config.toolbar_Full = [
            ['Source','-','Save','NewPage','Preview','-','Templates'],
            ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
            ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
            ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript','-','CopyFormatting','RemoveFormat'],
            ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['BidiLtr', 'BidiRtl' ],
            ['Link','Unlink','Anchor'],
            ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],
            '/',
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor'],
            ['Maximize', 'ShowBlocks','-','About']
            ];
        
        config.entities = false;
        config.uiColor= '#44B8C4';
        config.extraPlugins = 'videoembed,tableresize';
        //config.extraPlugins = 'emojione';
        //config.entities_latin = false;        
        config.filebrowserBrowseUrl = 'https://khotinmoi.com/ckfinder/ckfinders.php';

        config.filebrowserImageBrowseUrl = 'https://khotinmoi.com/ckfinder/ckfinders.php?type=Images';

        config.filebrowserFlashBrowseUrl = 'https://khotinmoi.com/ckfinder/ckfinders.php?type=Flash';

        config.filebrowserUploadUrl = 'https://khotinmoi.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

        config.filebrowserImageUploadUrl = 'https://khotinmoi.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';

        config.filebrowserFlashUploadUrl = 'https://khotinmoi.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

};  