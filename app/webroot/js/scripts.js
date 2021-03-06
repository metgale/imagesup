$(document).ready(function() {

    $("#toggleview").click(function() {
        $("#imagedetails").toggle();
    });

    $(".share").focus();
    $(".subfolders").css('word-wrap', 'break-word');
    $("#clear").click(function() {
        qq = 50;
        $("#slider-brightness").slider({value: 50});
        $("#slider-contrast").slider({value: 50});
        $("#slider-invert").slider({value: 50});
        $("#slider-saturation").slider({value: 50});
        $("#myimg").css("-webkit-filter", "none");
    });

    $("#slider-brightness").slider({value: 50})
            .bind("slide", function(event, ui) {
                var value = $("#slider-brightness").slider("value");
                var qq = value * 2;
                $("#myimg").css("-webkit-filter", "brightness(" + qq + "%)");
            });
    $("#slider-contrast").slider({value: 50})
            .bind("slide", function(event, ui) {
                var value = $("#slider-contrast").slider("value");
                var qq = value * 2;
                $("#myimg").css("-webkit-filter", "contrast(" + qq + "%)");
            });
    $("#slider-invert").slider({value: 50})
            .bind("slide", function(event, ui) {
                var value = $("#slider-invert").slider("value");
                var qq = value * 2;
                $("#myimg").css("-webkit-filter", "invert(" + qq + "%)");
            });

    $("#slider-saturation").slider({value: 50, max: 100})
            .bind("slide", function(event, ui) {
                var value = $("#slider-saturation").slider("value");
                var qq = value * 2;
                $("#myimg").css("-webkit-filter", "saturate(" + qq + "%)");
            });

    $('#enable').click(function() {
        if (this.checked) {
            $("#myimg").imageLens({lensSize: 200});
        }
        if (!this.checked) {
            $("#myimg").unbind("mousemove");
        }
    });




});
