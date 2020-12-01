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

        //Adding validation on
        $('form[name="bitsc_content_from"] .button-primary').on('click', function (e) {
            e.preventDefault();
            let submit_btn = this;
            $('.bitsc_err_msg').remove();
            let course = $('select[name="course"]');
            let submit = true;
            if (course.val() < 1) {
                course.addClass('bitsc_err')
                course.parent('td').append('<span class="bitsc_err_msg">Please Select a course</span>');
                submit = false;
            } else {
                course.removeClass('bitsc_err');
                course.parent('td').find('span').remove();
            }

            let status = $('select[name="content_status"]');
            if ('0' === status.val()) {
                status.addClass('bitsc_err')
                status.parent('td').append('<span class="bitsc_err_msg">Please content status</span>');
                submit = false;
            } else {
                status.removeClass('bitsc_err');
                status.parent('td').find('span').remove();
            }

            let content_name = $('input[name="content_name"]');
            if ('' === content_name.val()) {
                content_name.addClass('bitsc_err')
                content_name.parent('td').append('<span class="bitsc_err_msg">Please enter content title</span>');
                submit = false;
            } else {
                content_name.removeClass('bitsc_err');
                content_name.parent('td').find('span').remove();
            }

            let category = $('select[name="content_category"]');
            if (category.val() < 0) {
                category.addClass('bitsc_err')
                category.parent('td').append('<span class="bitsc_err_msg">Please select content category</span>');
                submit = false;
            } else {
                category.removeClass('bitsc_err');
                category.parent('td').find('span').remove();
            }

            let lesson = $('select[name="lesson"]');
            let lesson_id = lesson.val();
            if (lesson_id < 1) {
                lesson.addClass('bitsc_err')
                lesson.parent('td').append('<span class="bitsc_err_msg">Please select a lesson</span>');
                submit = false;
            } else {
                lesson.removeClass('bitsc_err');
                lesson.parent('td').find('span').remove();
            }

            let content_type = $('input[name="content_type"]:checked').val();

            if ('Code' === content_type) {
                let code_id = $('select[name="bitsc_code_id"]');
                let code_val = code_id.val();
                if (code_val < 1) {
                    code_id.addClass('bitsc_err')
                    code_id.parent('td').append('<span class="bitsc_err_msg">Please select a code example.</span>');
                    submit = false;
                } else {
                    code_id.removeClass('bitsc_err');
                    code_id.parent('td').find('span').remove();
                }
            } else {
                let content_url = $('input[name="content_url"]');
                if ('' === content_url.val()) {
                    content_url.addClass('bitsc_err')
                    content_url.parent('td').append('<span class="bitsc_err_msg">Upload or enter content URL.</span>');
                    submit = false;
                } else {
                    content_url.removeClass('bitsc_err');
                    content_url.parent('td').find('span').remove();
                }
            }
            if (submit) {
                $('form[name="bitsc_content_from"]').submit();
            }
        });
        $('select[name="lesson"]').on('change', function () {
            maybe_check_existing();
        });
        $('#bitsc_code_id').on('change', function () {
            maybe_check_existing()
        });

        function maybe_check_existing() {
            let code_id = $('#bitsc_code_id');
            let code_val = code_id.val();
            let submit_btn = $('form[name="bitsc_content_from"] .button-primary');
            let lesson = $('select[name="lesson"]');
            let lesson_id = lesson.val();
            
            if (lesson_id > 0 && code_val > 0) {
                code_id.removeClass('bitsc_err');
                code_id.parent('td').find('span').remove();
                let data = {
                    'action': 'bitscr_get_code_in_lesson',
                    'lesson_id': lesson_id,
                    'code_id': code_val
                };
                $(submit_btn).attr('disabled', true);
                $.post(ajaxurl, data, function (resp) {
                    if (resp.success === true) {
                        if (true === resp.in_lesson) {
                            code_id.addClass('bitsc_err');
                            code_id.parent('td').append('<span class="bitsc_err_msg">The code is already in this lesson</span>');
                        } else {
                            $(submit_btn).attr('disabled', false);
                            code_id.removeClass('bitsc_err');
                            code_id.parent('td').find('span').remove();
                        }
                    }
                });
            }
        }
    }); //document.ready


})(jQuery);
