(function ($) {
    'use strict';

    $(document).ready(function () {
        /* var navId = "masthead";
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

      */
        var navId = "masthead"
        var time = 7000;
        $('#' + navId).attr('data-visible', "time");
        $('body').mousemove(function (e) {
            if ($('#' + navId).attr('data-visible') == "mouse") {
                $('#' + navId).fadeIn(500);
                $("#move").addClass("mt-35", 500);
                $("#move1").addClass("m-15", 500);
                $("header").removeClass("mt-35", 500);
                $("header").addClass("m-0", 500);
                $('#' + navId).attr('data-visible', "time")
            }
        });

        //The following code hide the menu if cursor not top of the page update by suresh on 22-4-2020
        var cursorY;
        var scrolltop;
        document.onmousemove = function (e) {
            cursorY = e.pageY;
            scrolltop = document.documentElement.scrollTop;
        }
        setInterval(checkCursor, 6000);

        function checkCursor() {
            if (scrolltop > 0) {
                var mousenewposition = (cursorY - scrolltop);
                if (mousenewposition > 36) {
                    $('#' + navId).fadeOut(1000);
                    $("#move").removeClass("mt-35", 700);
                    $("#move1").removeClass("mt-35", 700);
                    $("header").removeClass("m-0", 700);
                    $("header").addClass("m-15", 700);
                    $('#' + navId).attr('data-visible', "mouse");

                } else {
                    $('#' + navId).fadeIn(500);
                    $("#move").addClass("mt-35", 500);
                    $("#move1").addClass("m-15", 500);
                    $("header").removeClass("mt-35", 500);
                    $("header").addClass("m-0", 500);
                    $('#' + navId).attr('data-visible', "time");
                }
            } else if (cursorY > 26) {
                $('#' + navId).fadeOut(1000);
                $("#move").removeClass("mt-35", 700);
                $("#move1").removeClass("mt-35", 700);
                $("header").removeClass("m-0", 700);
                $("header").addClass("m-15", 700);
                $('#' + navId).attr('data-visible', "mouse");
            } else {
                $('#' + navId).fadeIn(500);
                $("#move").addClass("mt-35", 500);
                $("#move1").addClass("m-15", 500);
                $("header").removeClass("mt-35", 500);
                $("header").addClass("m-0", 500);
                $('#' + navId).attr('data-visible', "time");
            }
        }

        jQuery(function () {
            jQuery("#accordion").accordion();
        });

        jQuery(function () {
            jQuery("#accordion2").accordion();
        });

        jQuery(function () {
            jQuery("#tabs").tabs();
        });

        $('.open_new_links').on('click', function () { //Opening the popup box with different content
            let new_window, features, title;
            features = 'location=1,status=1,toolbar=1,resizeable=1,width=800,height=500';
            new_window = window.open('', '_blank', features);
            title = 'Bitwise Content';

            let html_content = '';
            let content = $(this).attr('data-url');
            let c_type = $(this).attr('data-c_type');
            html_content += '<div class="content-div">';
            if ('image' === c_type) {
                html_content += '<img data-lightbox="example-1" src="' + content + '" width="100%" height="auto" >';
            } else if ('video' === c_type) {
                html_content += '<video preload="none" class="lightbox" width="800" height="500" style="border:none;" controls>';
                html_content += '<source src="' + content + '" type="video/mp4">';
                html_content += 'Your browser does not support the video tag.';
                html_content += '</video>';
            } else if ('document' === c_type) {
                html_content += '<embed src="' + content + '" width="800px" height="2100px" />';
            }
            html_content += '</div>';

            if (content !== null) {
                new_window.document.write('<!doctype html><html><head><title>' + title + '</title><meta charset="UTF-8" /></head><body style="padding: 0; margin: 0;">' + html_content + '</body></html>');
            }
        });

        /**
         * opening respective content by default on clicking a sidebar tab link
         */
        $('.content_btns').find('.bttn').on('click', function () {
            let tab_slug = $(this).attr('data-tab');
            console.log(tab_slug);
            $('.info_wrapp').find('.tab-pane').removeClass('active in');
            $('.info_wrapp').find('#' + tab_slug).addClass('active in');

            $('.info_wrapp').find('.nav.nav-pills li').removeClass('active');
            $('.info_wrapp').find('a[href="#' + tab_slug + '"]').parent('li').addClass('active');
        });

        //Save notes updated by suresh 22-6-2020
        $('#bitwisescr-note-submit').click(function (event) {
            var dt = new Date();
            var startMinutes = dt.getMinutes() < 10 ? '0' + dt.getMinutes() : dt.getMinutes();
            var startseconds = dt.getSeconds() < 10 ? '0' + dt.getSeconds() : dt.getSeconds();

            var time = dt.getHours() + ":" + startMinutes + ":" + startseconds;
            //var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
            event.preventDefault();

            var ed = tinyMCE.get('bitwisescr-note-body');
            var content = tinymce.get("bitwisescr-note-body").getContent();
            var formData = {
                'title': document.getElementById('bitwisescr-note-titlenew').value,
                'body': content,
                'userId': document.getElementById('bitwisescr-note-user-id').value,
                'currentLessonId': document.getElementById('bitwisescr-note-current-lessson-id').value,
                'currentcourseid': document.getElementById('bitwisescr-note-current-course-id').value,
                'currenttopicid': document.getElementById('bitwisescr-note-current-topic-id').value,
                'currentPostType': document.getElementById('bitwisescr-note-current-post-type').value,
                'noteId': document.getElementById('bitwisescr-note-id').value
            };

            let data = {
                'action': 'bitsa_notes_process',
                'formData': formData
            };
            if (content == "") {
            } else {
                jQuery.post(ajaxurl, data, function (resp) {
                    if (_.isEqual(true, resp.success)) {

                        // $( '#bitwisescr-note-submit' ).val('NOTE' ).addClass( 'nt-note-saving' );
                        $('#bitwisescr-note-submit').html('NOTE SAVED AT' + ' ' + time);

                        $('.notestitle').html(resp.data['title']);

                        $('.notescontent').html(resp.data['content']);


                        setTimeout(function () {

                            $('#bitwisescr-note-submit').html('<i class="fa fa-floppy-o" aria-hidden="true"></i>').removeClass('nt-note-saving');

                        }, 4000);

                    }
                });
            }
        });

        //Download the notes updated by suresh on 22-6-2020
        $('.bitwisescr-notes-download-modal').click(function () {
            var formData = {
                'userId': document.getElementById('bitwisescr-note-user-id').value,
                'currentLessonId': document.getElementById('bitwisescr-note-current-lessson-id').value,
                'currentcourseid': document.getElementById('bitwisescr-note-current-course-id').value,
                'currenttopicid': document.getElementById('bitwisescr-note-current-topic-id').value,
                'noteId': document.getElementById('bitwisescr-note-id').value
            };
            let data = {
                'action': 'bitsa_notes_download',
                'formData': formData
            };
            jQuery.post(ajaxurl, data, function (resp) {
                if (_.isEqual(true, resp.status)) {
                }
            });
        });
        //Delete the notes updated by suresh on 23-6-2020
        $('body').on('click', '.bitwisescr-notes-delete-note', function (e) {
            e.preventDefault();
            var r = confirm('Are you sure you want to delete this?');
            if (r == true) {
                var note_id = $(this).data('note');
                var element = $(this);

                jQuery.ajax({
                    url: ajaxurl + '?action=bitsa_notes_delete',
                    type: 'post',
                    data: {
                        note_id: note_id
                    },
                    success: function (data) {
                        $(element).parents('tr').fadeOut('slow');
                    }
                });
            }
        });

        //download single topic content
        $('body').on('click', '.downloadword', function () {
            var id = $(this).data('note');
            $("#singlesubmit" + id).submit();
        });

        //Pagination and search option for notes page updated by suresh on 8-7-2020
        var current_page = 1;
        var total_records = 10;
        var data_display = 10;
        var pages = Math.ceil(total_records / data_display);
        var sort = '';
        var search = '';

        get_notes_data({
            'current_page': current_page,
            'data_display': data_display,
            'sort': sort,
            'search': search
        });

        $('body').on('click', '.notes_list_tablediv .pagination li a:not(.notes_list_table .disabled a)', function () {
            var click_page = $(this).text();
            if (click_page != current_page) {
                if (click_page == 'Previous') {
                    if (current_page > 0) {
                        change_pagi((current_page - 1));
                    }
                } else if (click_page == 'Next') {
                    if (current_page < pages) {
                        change_pagi((current_page + 1));
                    }
                } else if ($.isNumeric(click_page)) {
                    change_pagi(click_page);
                }
            }
        });

        //display count updated by suresh on 7-7-2020
        $(".notes_list_filter .data_display").change(function () {
            data_display = parseInt($(this).val());
            pages = Math.ceil(total_records / data_display);
            change_pagi(current_page);
        });

        //Search function for notes page updated by suresh on 7-7-2020
        $('body').on('keyup', '.notes_list_filter  .search', function () {
            search = $(this).val();
            change_pagi(1);
        });

        function change_pagi(now_page, api_run = true) {
            current_page = parseInt(now_page);
            if (current_page > pages && pages != 0) {
                current_page = pages;
            }
            var html = '';
            if (pages <= 5) {
                var disable = (current_page == 1) ? 'disabled' : '';
                html += '<li class="' + disable + ' pre"><a>Previous</a></li>';

                for (var i = 1; i <= pages; ++i) {
                    var active = (current_page == i) ? 'active' : '';
                    html += '<li class="' + active + '"><a>' + i + '</a></li>';
                }

                var disable = (current_page == pages) ? 'disabled' : '';
                html += '<li class="' + disable + ' next"><a>Next</a></li>';
            } else if (current_page == 1 || current_page <= 4) {
                var disable = (current_page == 1) ? 'disabled' : '';
                html += '<li class="' + disable + ' pre"><a>Previous</a></li>';

                for (var i = 1; i <= 5; ++i) {
                    var active = (current_page == i) ? 'active' : '';
                    html += '<li class="' + active + '"><a>' + i + '</a></li>';
                }

                html += '<li><a>...</a></li>';
                html += '<li><a>' + pages + '</a></li>';
                html += '<li class="next"><a>Next</a></li>';
            } else if (current_page == pages || current_page > (pages - 4)) {
                html += ' <li><a>Previous</a></li> ' +
                    '<li><a>1</a></li> ' +
                    '<li><a>...</a></li> ';
                for (var i = pages - 4; i <= pages; ++i) {
                    var active = (current_page == i) ? 'active' : '';
                    html += '<li class="' + active + '"><a>' + i + '</a></li>';
                }
                var disable = (current_page == pages) ? 'disabled' : '';
                html += '<li class="' + disable + ' next"><a>Next</a></li>';
            } else if (current_page >= 5) {
                html += '<li class="pre"><a>Previous</a></li>';
                html += '<li><a>1</a></li>';
                html += '<li><a>...</a></li>';
                html += '<li><a>' + (current_page - 1) + '</a></li>' +
                    '<li class="active"><a>' + current_page + '</a></li> ' +
                    '<li><a>' + (current_page + 1) + '</a></li>';
                html += '<li><a>...</a></li>';
                html += '<li><a>' + pages + '</a></li> ' +
                    '<li class="next"><a>Next</a></li>';
            }

            if (pages != 0) {
                $('.pagination').html(html);
            } else {
                $('.pagination').html('');
            }

            if (api_run == true) {
                get_notes_data({
                    'current_page': current_page,
                    'data_display': data_display,
                    'sort': sort,
                    'search': search
                });
            }
        }

        //Function for get the all notes with pagination updated by suresh 8-7-2020
        function get_notes_data(filter) {
            $('.notes_list_table tbody').html(' <tr> ' +
                '<td colspan="5" class="text-center"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Getting data</td> ' +
                '</tr>');
            $(".displaying_message").html('');
            $.post(ajaxurl, {
                'action': 'bitsa_get_notes_withlimit',
                'filter': filter
            }, function (response) {
                response = JSON.parse(response);
                if (response['status'] == true) {
                    $('.notes_list_table tbody').html('');
                    if (response['data'].length > 0) {
                        $('.notes_list_table tbody').append(response['data']);

                    } else {
                        $('.notes_list_table tbody').html(' <tr> ' +
                            '<td colspan="5" class="text-center">No data found</td> ' +
                            '</tr>');
                    }
                    var starting_from = ((response['current_page'] - 1) * response['per_page']) + 1;
                    var ending_to = (starting_from - 1) + response['displaying'];
                    var total = response['total'];
                    if (response['pages'] != 0) {
                        $(".displaying_message").html('Showing ' + starting_from + ' to ' + ending_to + ' of ' + total + ' entries')
                    } else {
                        $(".displaying_message").html('');
                    }
                    pages = response['pages'];
                    change_pagi(current_page, false);
                }
            }).always(function () {
            });
        }

    }); //document.ready
})(jQuery);
