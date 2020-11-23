(function ($) {
    'use strict';

    $(document).ready(function () {
        var mediaUploader;
        $('#bitscr_course').on('change', function () {
            let course_id = $(this).find(':selected').attr('data-course_id');
            let data = {
                'action': 'bitscr_get_lessons',
                'course_id': course_id
            };
            $('.bitwise-content-form').find('.wp-spin.spinner').css('visibility', 'visible');
            $.post(ajaxurl, data, function (resp) {
                if (true === resp.success) {
                    $('.bitwise-content-form').find('.wp-spin.spinner').css('visibility', 'hidden');
                    let html = '<option value="0">Select a lesson</option>';
                    for (let lesson_id in resp.lessons) {
                        html += '<option value="' + lesson_id + '">' + resp.lessons[lesson_id] + '</option>';
                    }
                    $('#bitscr_lessons').html(html);
                }
            });
        });
        $('#upload_image_button').on('click', function (e) {
            e.preventDefault();
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                }, multiple: false
            });
            mediaUploader.on('select', function () {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                console.log(attachment);
                $('#content_url').val(attachment.url);
            });
            mediaUploader.open();
        });

        $('.bitscr-delete-content').on('click', function () {
            let content_id = $(this).attr('data-content-id');
            if (parseInt(content_id) > 0) {
                let data = {
                    'action': 'bitscr_delete_content',
                    'content_id': content_id
                };
                $('.bitwise-content-form').find('.wp-spin.spinner').css('visibility', 'visible');
                $.post(ajaxurl, data, function (resp) {
                    if (true === resp.success) {
                        window.location = resp.redirect_url;
                    }
                });
            }
        });
        /** Opening text area on selecting code **/
        let content_type = $('input[name=content_type]:checked').val();
        $('input[name=content_type]').on('click', function () {
            content_type = $(this).val();
            show_hide_code_fields(content_type);
        });

        show_hide_code_fields(content_type);
        function show_hide_code_fields(type) {
            if ('Code' === type) {
                $('.bitscr-code-snippet').removeClass('bitscr-hide');
                $('.bitscr-content-url').addClass('bitscr-hide');
                $('.bitscr-content-or').addClass('bitscr-hide');
                $('.bitscr-content-upload').addClass('bitscr-hide');
            } else {
                $('.bitscr-code-snippet').addClass('bitscr-hide');
                $('.bitscr-content-url').removeClass('bitscr-hide');
                $('.bitscr-content-or').removeClass('bitscr-hide');
                $('.bitscr-content-upload').removeClass('bitscr-hide');
            }
        }
    }); //document.ready


})(jQuery);
