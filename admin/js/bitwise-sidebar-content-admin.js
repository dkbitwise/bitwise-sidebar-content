(function ($) {
    'use strict';

    $(document).ready(function () {
        $('#bitscr_course').on('change', function () {
            let course_id = $(this).val();
            let data = {
                'action': 'bitscr_get_lessons',
                'course_id': course_id
            };
            jQuery.post(ajaxurl, data, function (resp) {
                console.log(resp);
                if (true === resp.success) {
                    let html = '<option value="0">Select a lesson</option>';
                    for (let lesson_id in resp.lessons) {
                        html += '<option value="' + lesson_id + '">' + resp.lessons[lesson_id] + '</option>';
                    }
                    $('#bitscr_lessons').html(html);
                }
            });
        });
    });
})(jQuery);
