jQuery(document).ready(function($) {
    $('.send').on('click', function(){
        post_id = $(this).data('id');
        base64 = '';
        $.ajax({
            type: 'POST',
            url: ajax_url,
            data: {
                'action' : 'pigeon_ajax_send_mail',
                'post_id' : post_id,
                'base64' : base64,
            },
            success: function( data, dataType ){
                console.debug( data );
            }
        });
        return false;
    });
});
