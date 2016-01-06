jQuery(document).ready(function($) {
    var cv = document.getElementById('canvas');
    var ct = cv.getContext('2d');
    var isDrawing;

    $("#canvas").attr('height', $("#canvas_area").height());
    $("#canvas").attr('width', $("#canvas_area").width());
    $("#canvas").css("border", "1px solid #eeeeee");

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
        ct.lineWidth = 3;
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
        ct.lineWidth = 3;
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

    // Clear button
    $('#clear-btn').on('click', function(){
        clearCanvas();
    });

    // Send button
    $('#send-btn').on('click', function(){
        base64 = cv.toDataURL('image/jpeg');
        $('#base64').val(base64);
        $('#messageform').submit();
    });
});
