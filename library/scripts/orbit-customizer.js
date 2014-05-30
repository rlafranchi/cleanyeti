

jQuery(document).ready(function ($) {

    var orbitselect = $("#customize-control-cleanyeti_no_slides").find('option:selected');

    $("#orbitselect").removeAttr('id');
    $(orbitselect).attr('id', 'orbitselect');
    var orbitselectval = $("#orbitselect").val();
    var orbitselectval1 = 1;
    while (orbitselectval1 <= orbitselectval) {
        var imageid1 = "customize-control-cleanyeti_orbit_image_" + orbitselectval1;
        var pageid1 = "customize-control-cleanyeti_orbit_page_link_" + orbitselectval1;
        $("#" + imageid1).removeAttr('style');
        $("#" + pageid1).removeAttr('style');
        orbitselectval1++;
    }
    orbitselectval++;


    while (orbitselectval <= 10) {
        var imageid = "customize-control-cleanyeti_orbit_image_" + orbitselectval;
        var pageid = "customize-control-cleanyeti_orbit_page_link_" + orbitselectval;
        $("#" + imageid).hide();
        $("#" + pageid).hide();
        orbitselectval++;
    }


    $("#customize-control-cleanyeti_no_slides").change(function () {

        var orbitselect = $(this).find('option:selected');



        $("#orbitselect").removeAttr('id');
        $(orbitselect).attr('id', 'orbitselect');
        var orbitselectval = $("#orbitselect").val();
        var orbitselectval1 = 1;
        while (orbitselectval1 <= orbitselectval) {
            var imageid1 = "customize-control-cleanyeti_orbit_image_" + orbitselectval1;
            var pageid1 = "customize-control-cleanyeti_orbit_page_link_" + orbitselectval1;
            $("#" + imageid1).removeAttr('style');
            $("#" + pageid1).removeAttr('style');
            orbitselectval1++;
        }
        orbitselectval++;


        while (orbitselectval <= 10) {
            var imageid = "customize-control-cleanyeti_orbit_image_" + orbitselectval;
            var pageid = "customize-control-cleanyeti_orbit_page_link_" + orbitselectval;
            $("#" + imageid).hide();
            $("#" + pageid).hide();
            orbitselectval++;
        }

    });
});
