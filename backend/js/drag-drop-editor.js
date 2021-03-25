jQuery(document).ready(function($){
    if($('.ctrl-templates.act-index').length) {
        $('.pull-right a[href*="/create"]').each(function(){
            $(this).before(' <a class="btn btn-danger btn-flat" title="" href="'+$(this).attr('href')+'#dde"><i class="fa fa-plus-square" data-original-title="" title=""></i>'+$(this).text()+' (Drag&Drop Editor)</a> ');
        });
    }
    if($('.ctrl-email_templates_gallery.act-index').length) {
        $('.pull-right a[href*="/create"]').each(function(){
            $(this).before(' <a class="btn btn-danger btn-flat" title="" href="'+$(this).attr('href')+'#dde"><i class="fa fa-plus-square" data-original-title="" title=""></i>'+$(this).text()+' (Drag&Drop Editor)</a> ');
        });
    }
});