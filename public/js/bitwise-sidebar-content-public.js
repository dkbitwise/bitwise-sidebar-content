(function ($) {
    'use strict';

    $(document).ready(function () {
        var navId = "masthead";
        var time = 7000;
        $('#' + navId).attr('data-visible', "time");
        $('body').mousemove(function () {
            if ($('#' + navId).attr('data-visible') == "mouse") {
                $('#' + navId).fadeIn(500);
                $("#move").addClass("mt-35", 500);
                $("#move1").addClass("m-15", 500);
                $("header").removeClass("mt-35", 500);
                $("header").addClass("m-0", 500);
                $('#' + navId).attr('data-visible', "time");
            }
        });
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

        jQuery('.open_new_links').on('click', function () {
            let new_window, features, title;
            features = 'location=1,status=1,toolbar=1,resizeable=1,width=800,height=500';
            new_window = window.open('', '_blank', features);
            title = 'Bitwise Content';

            let html_content = '';
            let content_url = jQuery(this).attr('data-url');
            let c_type = jQuery(this).attr('data-c_type');
            html_content += '<div class="content-div">';
            if ('image' === c_type) {
                html_content += '<img src="' + content_url + '" width="100%" height="auto" >';
            } else if ('video' === c_type) {
                html_content += '<video preload="none" class="lightbox" width="800" height="500" style="border:none;" controls>';
                html_content += '<source src="' + content_url + '" type="video/mp4">';
                html_content += 'Your browser does not support the video tag.';
                html_content += '</video>';
            } else if ('document' === c_type) {
                html_content += '<embed src="' + content_url + '" width="800px" height="2100px" />';
            }
            html_content += '</div>';

            if (content_url !== null) {
                new_window.document.write('<!doctype html><html><head><title>' + title + '</title><meta charset="UTF-8" /></head><body style="padding: 0; margin: 0;">' + html_content + '</body></html>');
            }
        });

    }); //document.ready
})(jQuery);
