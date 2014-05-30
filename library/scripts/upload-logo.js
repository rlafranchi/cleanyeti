jQuery(document).ready(function($) {
    $('#logo').click(function() {
        tb_show('Upload an Image', 'media-upload.php?referer=cleanyeti-settings&type=image&TB_iframe=true&post_id=0', false);
        return false;
    });
    window.send_to_editor = function(html) {
        var image_url = $('img',html).attr('src');
        $('#text_logo').val(image_url);
        tb_remove();
    }
});
