$(function () {
    $("#add_post").click(e => {
        $('#add_post_form_bg').fadeIn(250);
        $('#add_post_form').fadeIn(250);
        $('#search_btn').fadeOut(250);
    });
    $('#add_post_form_close_btn').click(e => {
        $('#add_post_form_bg').fadeOut(250);
        $('#add_post_form').fadeOut(250);
        $('#search_btn').fadeIn(250);
    });
    $('.edit_btn').click(e => {
        e.preventDefault();
        let post_id = e.target.id;
        $(`.default_card_id_${post_id}`).fadeOut(100);
        setTimeout(() => {
            $(`.edit_card_id_${post_id}`).fadeIn(100);
        }, 100);
        $(document).keyup(e => {
            if (e.keyCode === 27) {
                $(`.edit_card_id_${post_id}`).fadeOut(100);
                setTimeout(() => {
                    $(`.default_card_id_${post_id}`).fadeIn(100);
                }, 100);
            }
        });
    });
    $('.cancel_btn').click(e => {
        e.preventDefault();
        let post_id = e.target.id;
        $(`.edit_card_id_${post_id}`).fadeOut(100);
        setTimeout(() => {
            $(`.default_card_id_${post_id}`).fadeIn(100);
        }, 100);
    });
    $('#profile_pic_label').click(e => {
        $('#profile_pic_submit').fadeIn();
    });
    $('#profile_pic_submit').click(e => {
        $('#profile_pic_submit').fadeOut();
    });
    $('#comment_btn').click(e => {
        $('#comment_textarea').slideDown();
    });
    $('#cancel_comment_btn').click(e => {
        $('#comment_textarea').slideUp();
    });

    $('#edit_about_btn').click(e => {
        e.preventDefault();
        let post_id = e.target.id;
        $('#about').fadeOut(100);
        setTimeout(() => {
            $('#edit_about_form').fadeIn(100);
        }, 100);
    });
    $('#cancel_edit_about_btn').click(e => {
        $('#edit_about_form').fadeOut(100);
        setTimeout(() => {
            $('#about').fadeIn(100);
        }, 100);
    });
    $(document).keyup(e => {
        if (e.keyCode === 27) {
            $('#add_post_form_bg').fadeOut(250);
            $('#add_post_form').fadeOut(250);
            $('#search_btn').fadeIn(250);
            $('#comment_textarea').slideUp();
            $('#edit_about_form').fadeOut(100);
            setTimeout(() => {
                $('#about').fadeIn(100);
            }, 100);
            $('#profile_pic_submit').fadeOut();
        }
    });
    $(document).keyup(e => {
        if (e.keyCode === 144) {
            $('.card-block').slideToggle();
        }
    });

})