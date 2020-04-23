(function ($) {
    'use strict';

    $(document).ready(function () {
        var mediaUploader;
        $('#bitscr_course').on('change', function () {
            let course_id = $(this).val();
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
//                console.log(attachment);
                $('#content_url').val(attachment.url);
            });
            mediaUploader.open();
        });
    });
})(jQuery);
