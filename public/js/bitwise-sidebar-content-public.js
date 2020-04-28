(function ($) {
    'use strict';

    $(document).ready(function () {
        var navId = "masthead"
        var time = 7000;
        $('#' + navId).attr('data-visible', "time");
        $('body').mousemove(function () {
            if ($('#' + navId).attr('data-visible') == "mouse") {
                $('#' + navId).fadeIn(500);
                $("#move").addClass("mt-35", 500);
                $("#move1").addClass("m-15", 500);
                $("header").removeClass("mt-35", 500);
                $("header").addClass("m-0", 500);
                $('#' + navId).attr('data-visible', "time")
            }
        })
        window.setInterval(function () {
            if ($('#' + navId).attr('data-visible') == "time") {
                $('#' + navId).fadeOut(700);
                $("#move").removeClass("mt-35", 700);
                $("#move1").removeClass("mt-35", 700);
                $("header").removeClass("m-0", 700);
                $("header").addClass("m-15", 700);
                $('#' + navId).attr('data-visible', "mouse")
            }
        }, time);

        var active = "europa-view";
        $('.info_close').click(function () {
            var divname = this.name;
            $("#" + ".bt_box_shadow").hide("slide", {direction: "right"}, 1200);
            $("#" + ".bt_box_shadow").delay(400000).show("slide", {direction: "right"}, 1200);
            active = ".bt_box_shadow";
        });

      //  $('[data-toggle="tooltip"]').tooltip();

        jQuery(function () {
            jQuery("#accordion").accordion();
        });

        jQuery(function () {
            jQuery("#accordion2").accordion();
        });

        jQuery(function () {
            jQuery("#tabs").tabs();
        });

        function open_in_new_window(id, title) {
            var new_window;
            var features;
            features = 'location=1,status=1,toolbar=1,resizeable=1,width=800,height=500';
            if (features !== undefined && features !== '') {
                new_window = window.open('', '_blank', features);
            } else {
                new_window = window.open('', '_blank');
            }

            var html_contents = document.getElementById(id);
            if (html_contents !== null) {
                new_window.document.write('<!doctype html><html><head><title>' + title + '</title><meta charset="UTF-8" /></head><body style="padding: 0; margin: 0;">' + html_contents.innerHTML + '</body></html>');
            }
        }

    }); //document.ready

})(jQuery);
