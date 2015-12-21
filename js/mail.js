jQuery(document).ready(function($) {
    $('.send-btn').on('click', function(){
        post_id = $(this).data('id');
        $('#post_id').val(post_id);
        $('#messageform').submit();
    });
});
