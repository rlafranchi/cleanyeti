

jQuery(document).ready(function ($) {

    var orbitselect = $("#no_slides").find('option:selected');

    $("#orbitselect").removeAttr('id');
    $(orbitselect).attr('id', 'orbitselect');
    var orbitselectval = $("#orbitselect").val();
    var orbitselectval1 = 1;
    while (orbitselectval1 <= orbitselectval) {
        var imageid1 = "orbit_image_" + orbitselectval1;
        var pageid1 = "orbit_page_link_" + orbitselectval1;
        $("#" + imageid1).parents('tr').removeAttr('style');
        $("#" + pageid1).parents('tr').removeAttr('style');
        orbitselectval1++;
    }
    orbitselectval++;


    while (orbitselectval <= 10) {
        var imageid = "orbit_image_" + orbitselectval;
        var pageid = "orbit_page_link_" + orbitselectval;
        $("#" + imageid).parents('tr').hide();
        $("#" + pageid).parents('tr').hide();
        orbitselectval++;
    }


    $("#no_slides").change(function () {

        var orbitselect = $(this).find('option:selected');



        $("#orbitselect").removeAttr('id');
        $(orbitselect).attr('id', 'orbitselect');
        var orbitselectval = $("#orbitselect").val();
        var orbitselectval1 = 1;
        while (orbitselectval1 <= orbitselectval) {
            var imageid1 = "orbit_image_" + orbitselectval1;
            var pageid1 = "orbit_page_link_" + orbitselectval1;
            $("#" + imageid1).parents('tr').removeAttr('style');
            $("#" + pageid1).parents('tr').removeAttr('style');
            orbitselectval1++;
        }
        orbitselectval++;


        while (orbitselectval <= 10) {
            var imageid = "orbit_image_" + orbitselectval;
            var pageid = "orbit_page_link_" + orbitselectval;
            $("#" + imageid).parents('tr').hide();
            $("#" + pageid).parents('tr').hide();
            orbitselectval++;
        }

    });
});
