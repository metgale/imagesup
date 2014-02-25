$(function () {
    'use strict';
	var albumId = $('#fileupload').attr('data-album-id');
	var folder = null;

	$('#fileupload').fileupload({
		autoUpload: true,
        url: '/albums/upload/' + albumId,
		maxFileSize: 50000000, //50MB
        previewCrop: false,
		dataType: 'json',
		disableImageResize: true,
		disableImageLoad:true,
		sequentialUploads: true,
		limitConcurrentUploads: 1,
		maxChunkSize: 0,
		stop: function (e, data) {
			window.location.href = '/albums/view/' + albumId + '/' + folder;
        },
		start: function (e, data) {
			$('.wait-message').show();
		},
		//acceptFileTypes: /(\.|\/)(jpeg|jpg|png|zip)$/i
		acceptFileTypes: /(\.|\/)(zip)$/i
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>').append($('<span/>').text(file.name));
            if (!index) {
                node.append('<br>')
            }
            node.appendTo(data.context);
        });
		if ($('#fileupload').length) {
			$('.cancel').show();
		}
		$('.cancel').click(function (e) {
			if(typeof jqXHR !== 'undefined') {
				jqXHR.abort();
			}
			data.context.hide('');
		})
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.error) {
            node.append($('<span class="label label-warning"/>').text(file.error));
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('.bar-success').css('width',progress + '%');
    }).on('fileuploaddone', function (e, data) {
		if (data.result.folder) {
			folder = data.result.folder;
		}
        $.each(data.result.files, function (index, file) {
			if (file.error) {
                var error = $('<span class="label label-warning"/>').text(file.error);
                $(data.context.children()[index]).append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index, file) {
            var error = $('<span class="label label-warning"/>').text('File upload failed.');
            $(data.context.children()[index]).append(error);
        });
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

});
