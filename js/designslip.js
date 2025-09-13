var textElement = document.querySelectorAll('.textElement');
var parentElement = document.getElementById("parent");

var initialX = 0;
var initialY = 0;

var i = 1 ;
    textElement.forEach(function(element) {
            element.addEventListener('mousedown', function(e) {

            let offsetX = e.clientX - element.getBoundingClientRect().left;
            let offsetY = e.clientY - element.getBoundingClientRect().top;

            if(initialX == 0 ) {
                initialX = e.clientX - offsetX;
                initialY = e.clientY - offsetY;
            }
            

            document.addEventListener('mousemove', dragElement);
            document.addEventListener('mouseup', function() {
                document.removeEventListener('mousemove', dragElement);
            });

            function dragElement(e) {
                let x = e.clientX - offsetX;
                let y = e.clientY - offsetY;

                var deltaX = x - initialX;
                var deltaY = y - initialY;
                
                

                // Contain the draggable element within its parent
                //alert(parentElement.getBoundingClientRect().left);
                //x = Math.min(Math.max(x, parentElement.getBoundingClientRect().left), parentElement.getBoundingClientRect().right - element.offsetWidth);
                //y = Math.min(Math.max(y, parentElement.getBoundingClientRect().top), parentElement.getBoundingClientRect().bottom - element.offsetHeight);
                


                //element.style.left = x + 'px';
                //element.style.top = y + 'px';
                element.style.left = deltaX + 'px';
                element.style.top = deltaY + 'px';

                $(element).attr('title', 'X: ' + deltaX + ', Y: ' + deltaY);//.tooltip('open');

                $(element).children('input[name*="x[]"]').val(deltaX);
                $(element).children('input[name*="y[]"]').val(deltaY);
            }
        });
    });

    $(document).ready(function() {

        var textElement = document.querySelectorAll('.textElement');
        var parentElement = document.getElementById("parent");
        // Your code here
        textElement.forEach(function(element) {

            element.style.left = $(element).children('input[name*="x[]"]').val() + 'px';
            element.style.top = $(element).children('input[name*="y[]"]').val() + 'px';
            $(element).attr('title', 'X: ' + $(element).children('input[name*="x[]"]').val() + ', Y: ' + $(element).children('input[name*="y[]"]').val());//.tooltip('open');
        });
    });    