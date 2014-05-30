jQuery(document).ready(function($) {
    var count = 1;
    while ( count <= 10 ) {
        $('#orbit_image_' + count).click(function() {
            tb_show('Upload an Image', 'media-upload.php?referer=cleanyeti-settings&type=image&TB_iframe=true&post_id=0', false);
            return false;
        });
        window.send_to_editor = function(html) {
            var image_url = $('img',html).attr('src');
            $('#text_orbit_image_' + count).val(image_url);
            tb_remove();
        }
        count++;
    }
});
