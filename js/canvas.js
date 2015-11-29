//window.onload = function() {
jQuery(document).ready(function($) {
    var cv = document.getElementById('c');
    var ct = cv.getContext('2d');
    var isDrawing;

    clearCanvas = function() {
        ct.beginPath();
        ct.clearRect(0, 0, cv.width, cv.height);
        ct.fillStyle = '#ffffff';
        ct.fillRect(0, 0, cv.width, cv.height);
    };
    clearCanvas();

    // for PC
    cv.onmousedown = function(e) {
        isDrawing = true;
        ct.lineWidth = 10;
        ct.lineJoin = ct.lineCap = 'round';
        var rect = e.target.getBoundingClientRect();
        ct.moveTo(e.clientX-rect.left, e.clientY-rect.top);
    };
    cv.onmousemove = function(e) {
        if (isDrawing) {
            var rect = e.target.getBoundingClientRect();
            ct.lineTo(e.clientX-rect.left, e.clientY-rect.top);
            ct.stroke();
        }
    };
    cv.onmouseup = function() {
        isDrawing = false;
    };
    // for SmartPhone
    cv.ontouchstart = function (e) {
        ct.lineWidth = 10;
        ct.lineJoin = ct.lineCap = 'round';
        e.preventDefault();
        var rect = e.target.getBoundingClientRect();
        ct.moveTo(e.touches[0].pageX-rect.left, e.touches[0].pageY-rect.top);
    };
    cv.ontouchmove = function (e) {
        var rect = e.target.getBoundingClientRect();
        ct.lineTo(e.touches[0].pageX-rect.left, e.touches[0].pageY-rect.top);
        ct.stroke();
    };
    // Button
    document.getElementById('clear').onclick = function() {
        clearCanvas();
    };
    document.getElementById('save').onclick = function() {
        post_id = document.getElementById('post_id').value;
        base64 = cv.toDataURL('image/jpeg');
        jQuery.ajax({
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
    };
//};
});
