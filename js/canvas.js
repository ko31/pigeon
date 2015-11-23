window.onload = function() {
    var cv = document.getElementById('c');
    var ct = cv.getContext('2d');
    var isDrawing;
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
        ct.beginPath();
        ct.clearRect(0, 0, cv.width, cv.height);
    };
    document.getElementById('save').onclick = function() {
        //TODO:画像保存
        console.debug(cv.toDataURL());
    };
};
