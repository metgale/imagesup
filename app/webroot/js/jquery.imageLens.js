/*  
    http://www.dailycoding.com/ 
*/
(function ($) {
    $.fn.imageLens = function (options) {

        var defaults = {
            lensSize: 100,
            borderSize: 4,
            borderColor: "#888"
        };
        var options = $.extend(defaults, options);
        var lensStyle = "background-position: 0px 0px;width: " + String(options.lensSize) + "px;height: " + String(options.lensSize)
            + "px;float: left;display: none;border-radius: " + String(options.lensSize / 2 + options.borderSize)
            + "px;border: " + String(options.borderSize) + "px solid " + options.borderColor 
            + ";background-repeat: no-repeat;position: absolute;";

        return this.each(function () {
            obj = $(this);

            var offset = $(this).offset();

            // Creating lens
            var target = $("<div style='" + lensStyle + "' class='" + options.lensCss + "'>&nbsp;</div>").appendTo($(this).parent());
            var targetSize = target.size();

            // Calculating actual size of image
            var imageSrc = options.imageSrc ? options.imageSrc : $(this).attr("src");
            var imageTag = "<img style='display:none;' src='" + imageSrc + "' />";

            var widthRatio = 0;
            var heightRatio = 0;

			var o_width = obj.width() * 2;
			var o_height = obj.height() * 2;
			
           var ddd = $(imageTag).load(function () {
                widthRatio = 2; // 1200 / obj.width(); // $(this).width() / obj.width();
                heightRatio = 2; //1200 / obj.height(); //$(this).height() / obj.height();
				//console.log("width: " + widthRatio + "  heightRatio:" + heightRatio);
				//console.log("widthRatio: " + widthRatio + "  heightRatio:" + heightRatio);
            }).appendTo($(this).parent());

            target.css({ backgroundImage: "url('" + imageSrc + "')" });

            target.mousemove(setPosition);
            $(this).mousemove(setPosition);
			
			target.css('background-size', o_width + 'px ' +  o_height + 'px');

            function setPosition(e) {

                var leftPos = parseInt(e.pageX - offset.left);
                var topPos = parseInt(e.pageY - offset.top);

                if (leftPos < 0 || topPos < 0 || leftPos > obj.width() || topPos > obj.height()) {
                    target.hide();
                }
                else {
                    target.show();

                    leftPos = String(((e.pageX - offset.left) * widthRatio - target.width() / 2) * (-1));
                    topPos = String(((e.pageY - offset.top) * heightRatio - target.height() / 2) * (-1));

                    target.css({ backgroundPosition: leftPos + 'px ' + topPos + 'px' });

                    leftPos = String(e.pageX - target.width() / 2);
                    topPos = String(e.pageY - target.height() / 2);
                    target.css({ left: leftPos + 'px', top: topPos + 'px' });

                }
            }
        });
    };
})(jQuery);
