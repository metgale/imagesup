$(document).ready(function() {
    $("#slider-brightness").slider({value: 50})
            .bind("slide", function(event, ui) {
                var value = $("#slider-brightness").slider("value");
                var qq = value * 2;
                $("#myimg").css("-webkit-filter", "brightness(" + qq + "%)");
            });

    $("#slider-saturation").slider({value: 50})
            .bind("slide", function(event, ui) {
                var value = $("#slider-saturation").slider("value");
                var qq = value * 2;
                $("#myimg").css("-webkit-filter", "saturate(" + qq + "%)");
            });

    $("#slider3").slider({value: 50})
            .bind("slide", function(event, ui) {
                var value = $("#slider3").slider("value");
                var qq = value * 2;
                $("#myimg").css("-webkit-filter", "grayscale(" + qq + "%)");
            });

    $("#slider4").slider({value: 50})
            .bind("slide", function(event, ui) {
                var value = $("#slider4").slider("value");
                var qq = value * 2;
                $("#myimg").css("-webkit-filter", "sepia(" + qq + "%)");
            });

    $("#slider5").slider({value: 50})
            .bind("slide", function(event, ui) {
                var value = $("#slider5").slider("value");
                var qq = value * 2;
                $("#myimg").css("-webkit-filter", "invert(" + qq + "%)");
            });
    $("#slider6").slider({value: 50})
            .bind("slide", function(event, ui) {
                var value = $("#slider6").slider("value");
                var qq = value * 2;
                $("#myimg").css("-webkit-filter", "contrast(" + qq + "%)");
            });
})
