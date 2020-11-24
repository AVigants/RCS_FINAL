$(function(){
    $("#add_post").click(e=>{
        $('#add_post_form').fadeIn(250);
    });
    $('#add_post_form_close_btn').click(e=>{
        $('#add_post_form').fadeOut(250);
    });

    $('.edit_btn').click(e=>{
        e.preventDefault();
        let post_id = e.target.id;
        $(`.default_card_id_${post_id}`).fadeOut(100);
        setTimeout(() => {
            $(`.edit_card_id_${post_id}`).fadeIn(100);
        }, 100);
    });
    $('.cancel_btn').click(e=>{
        e.preventDefault();
        let post_id = e.target.id;
        $(`.edit_card_id_${post_id}`).fadeOut(100);
        setTimeout(() => {
            $(`.default_card_id_${post_id}`).fadeIn(100);
        }, 100);
    });
    $('#profile_pic_label').click(e=>{
        $('#profile_pic_submit').fadeIn();
    });
    $('#profile_pic_submit').click(e=>{
        $('#profile_pic_submit').fadeOut();
    });
})